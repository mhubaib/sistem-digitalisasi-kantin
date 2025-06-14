<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Notification;
use App\Models\Product;
use App\Models\Santri;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\WalletHistory;
use App\Services\NotificationService;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Exports\TransactionExport;
use App\Exports\TransactionPdfExport;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{

    protected $notificationService;
    protected $whatsappService;

    public function __construct(NotificationService $notificationService, WhatsAppService $whatsappService)
    {
        $this->notificationService = $notificationService;
        $this->whatsappService = $whatsappService;
    }

    /**
     * Display the transaction cart page with products and santri.
     */
    public function cart()
    {
        // Fetch active products with necessary attributes
        $products = Product::select('id', 'name', 'price', 'stock', 'image', 'status')
            ->where('status', 'active')
            ->get();

        // Fetch approved santri with id, saldo, and name from related user
        $santris = Santri::select('santris.id', 'santris.saldo')
            ->join('users', 'santris.user_id', '=', 'users.id')
            ->where('santris.status', 'approved')->where('users.active', true)
            ->addSelect('users.name')
            ->get();

        // Get cart from session (if any)
        $cart = session()->get('cart', []);

        return view('admin.transaction.cart', compact('products', 'santris', 'cart'));
    }

    /**
     * Process the transaction from the cart.
     */
    public function store(Request $request)
    {
        $request->validate([
            'santri_id' => 'nullable|exists:santris,id',
            'payment_type' => 'required|in:cash,saldo',
            'items' => 'required|array',
            'items.*.id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
            'subtotal' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
        ]);

        // Validasi khusus untuk pembayaran saldo
        if ($request->payment_type === 'saldo' && !$request->santri_id) {
            return response()->json([
                'success' => false,
                'message' => 'Santri harus dipilih untuk pembayaran menggunakan saldo.',
            ], 422);
        }

        DB::beginTransaction();
        try {
            $total = $request->total;

            // Create the transaction
            $transaction = Transaction::create([
                'santri_id' => $request->santri_id, // Can be null for cash payments
                'payment_type' => $request->payment_type,
                'total' => $total,
                'created_by' => Auth::id(),
            ]);

            // Process each item
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['id']);

                if ($product->stock < $item['qty']) {
                    throw new \Exception("Stok produk {$product->name} tidak mencukupi.");
                }

                // Calculate subtotal for this item
                $subtotal = $product->price * $item['qty'];

                // Create transaction item
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'quantity' => $item['qty'],
                    'subtotal' => $subtotal
                ]);

                // Update product stock
                $product->decrement('stock', $item['qty']);
            }

            // Handle payment if using saldo
            if ($request->payment_type === 'saldo' && $request->santri_id) {
                $santri = Santri::findOrFail($request->santri_id);

                if ($santri->saldo < $total) {
                    throw new \Exception("Saldo santri {$santri->user->name} tidak mencukupi.");
                }

                $santri->decrement('saldo', $total);

                WalletHistory::create([
                    'santri_id' => $santri->id,
                    'type' => 'purchase',
                    'method' => 'saldo',
                    'amount' => -1 * $total,
                    'description' => 'Pembelian di kantin',
                    'created_by' => Auth::id(),
                ]);
            }

            // Record the transaction in Wallet History for cash payments as well
            if ($request->payment_type === 'cash') {
                WalletHistory::create([
                    'santri_id'   => null, // Santri ID is null for cash payments
                    'type'        => 'purchase',
                    'method'      => 'cash',
                    'amount'      => -1 * $total, // Amount is negative for a purchase
                    'description' => 'Pembelian di kantin (Tunai)', // More specific description
                    'created_by'  => Auth::id(),
                ]);
            }

            DB::commit();

            // Create notification for wali when their santri makes a transaction
            if ($request->santri_id) {
                $santri = Santri::findOrFail($request->santri_id);
                if ($santri->wali_id) {
                    $notification = $this->notificationService->createForWali(
                        $santri->wali_id,
                        'santri_transaction',
                        'Transaksi Santri',
                        "Santri {$santri->user->name} telah melakukan transaksi sebesar Rp " . number_format($total, 0, ',', '.'),
                        [
                            'santri_id' => $santri->id,
                            'transaction_id' => $transaction->id,
                            'amount' => $total,
                            'items' => $request->items
                        ]
                    );
                }
            }

            // Kirim notifikasi WhatsApp
            if ($transaction) {
                $santri = $request->santri_id ? Santri::find($request->santri_id) : null;
                $this->whatsappService->sendTransactionNotification($transaction, $santri);

                // Jika pembayaran menggunakan saldo, kirim notifikasi ke santri
                if ($request->payment_type === 'saldo' && $santri) {
                    $this->whatsappService->sendBalanceNotification($santri, $total, 'debit');
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil dibuat.',
                'transaction_id' => $transaction->id,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Sync client-side cart with session (optional, for robustness).
     */
    public function syncCart(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:products,id',
            'items.*.name' => 'required|string',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.stock' => 'required|integer|min:0',
        ]);

        $cart = [];
        foreach ($request->items as $item) {
            $cart[$item['id']] = [
                'id' => $item['id'],
                'name' => $item['name'],
                'price' => $item['price'],
                'qty' => $item['qty'],
            ];
        }

        Session::put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Cart berhasil disinkronkan.',
        ]);
    }

    /**
     * Show all transactions for admin (santri or not, cash or saldo), with filter and total.
     */
    public function allTransactions(Request $request)
    {
        $query = Transaction::with(['santri.user', 'createdBy']);

        // Filter by payment type
        if ($request->filled('payment_type')) {
            $query->where('payment_type', $request->payment_type);
        }
        // Filter by santri
        if ($request->filled('santri_id')) {
            $query->where('santri_id', $request->santri_id);
        }
        // Filter by date
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $transactions = $query->latest()->paginate(15);
        $totalIncome = $query->sum('total');
        $totalExpenses = Expense::sum('amount');
        $santris = Santri::with('user')->get();

        return view('admin.transaction.index', compact('transactions', 'totalIncome', 'santris', 'totalExpenses'));
    }

    /**
     * Export transactions to Excel
     */
    public function exportExcel(Request $request)
    {
        $query = Transaction::with(['santri.user', 'createdBy']);

        // Apply filters
        if ($request->filled('payment_type')) {
            $query->where('payment_type', $request->payment_type);
        }
        if ($request->filled('santri_id')) {
            $query->where('santri_id', $request->santri_id);
        }
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        return Excel::download(new TransactionExport($query), 'laporan-transaksi-' . now()->format('Y-m-d') . '.xlsx');
    }

    /**
     * Export transactions to PDF
     */
    public function exportPdf(Request $request)
    {
        $query = Transaction::with(['santri.user', 'createdBy']);

        // Apply filters
        if ($request->filled('payment_type')) {
            $query->where('payment_type', $request->payment_type);
        }
        if ($request->filled('santri_id')) {
            $query->where('santri_id', $request->santri_id);
        }
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $totalIncome = $query->sum('total');
        $totalExpenses = Expense::sum('amount');

        return (new TransactionPdfExport($query, $totalIncome, $totalExpenses))->export();
    }
}
