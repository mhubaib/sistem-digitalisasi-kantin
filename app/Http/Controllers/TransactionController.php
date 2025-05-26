<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Santri;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\transactions;
use App\Models\WalletHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $santris = Santri::with('user')->where('status', 'approved')->get();
        $products = Product::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'santri_id'     => 'required|exists:santris,id',
            'payment_type'  => 'required|in:saldo,cash',
            'items'         => 'required|array',
            'items.*.id'    => 'required|exists:products,id',
            'items.*.qty'   => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $total = 0;
            $itemsData = [];

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['id']);
                $subTotal = $product->price * $item['qty'];
                $total += $subTotal;

                // kurangi stok barang
                if ($product->stock < $item['qty']) {
                    throw new \Exception("Stok produk {$product->name} tidak cukup.");
                }

                $product->decrement('stock', $item['qty']);

                $itemsData[] = [
                    'product_id' => $product->id,
                    'quantity'   => $item['qty'],
                    'price'      => $product->price,
                    'subtotal'   => $subTotal,
                ];
            }

            $transaction = Transaction::create([
                'santri_id'    => $request->santri_id,
                'payment_type' => $request->payment_type,
                'total'        => $total,
                'created_by'   => auth()->id,
            ]);

            foreach ($itemsData as $itemData) {
                $itemData['transaction_id'] = $transaction->id;
                TransactionItem::create($itemData);
            }

            // Jika pembayaran pakai saldo, kurangi saldo santri dan catat histori
            if ($request->payment_type === 'saldo' && $request->santri_id) {
                $santri = Santri::findOrFail($request->santri_id);

                if ($santri->saldo < $total) {
                    throw new \Exception("Saldo tidak mencukupi.");
                }

                $santri->decrement('saldo', $total);

                WalletHistory::create([
                    'santri_id'   => $santri->id,
                    'type'        => 'purchase',
                    'method'      => 'saldo',
                    'amount'      => -1 * $total,
                    'description' => 'Pembelian di koperasi',
                    'created_by'  => auth()->id,
                ]);
            }

            DB::commit();

            return redirect()->route('transactions.create')->with('success', 'Transaksi berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transactions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transactions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transactions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transactions)
    {
        //
    }
}
