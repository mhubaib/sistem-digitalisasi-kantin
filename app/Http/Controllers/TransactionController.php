<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Santri;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\WalletHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TransactionController extends Controller
{

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
            ->where('santris.status', 'approved')
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

            // Clear session cart
            Session::forget('cart');

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
}
