<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\Topup;
use App\Models\WalletHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopupController extends Controller
{
    // Tampilkan form top-up
    public function create()
    {
        $santris = Santri::with('user')->where('status', 'approved')->get();
        return view('admin.topups.create', compact('santris'));
    }

    // Simpan top-up saldo
    public function store(Request $request)
    {
        $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'amount'    => 'required|numeric|min:1000',
            'method'    => 'required|in:cash,transfer,manual,lainnya',
        ]);

        DB::beginTransaction();

        try {
            $topup = Topup::create([
                'santri_id'  => $request->santri_id,
                'amount'     => $request->amount,
                'method'     => $request->method,
                'created_by' => auth()->id,
            ]);

            $santri = Santri::findOrFail($request->santri_id);
            $santri->increment('saldo', $request->amount);

            WalletHistory::create([
                'santri_id'   => $santri->id,
                'type'        => 'topup',
                'method'      => $request->method,
                'amount'      => $request->amount,
                'description' => 'Top-up saldo',
                'created_by'  => auth()->id,
            ]);

            DB::commit();

            return redirect()->route('topups.create')->with('success', 'Top-up berhasil.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
