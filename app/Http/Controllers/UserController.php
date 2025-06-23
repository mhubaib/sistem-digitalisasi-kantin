<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function santriIndex()
    {
        $santris = Santri::with(['user', 'wali'])
            ->select('santris.id', 'santris.user_id', 'santris.wali_id', 'santris.saldo')
            ->get();

        return view('admin.santri.index', compact('santris'));
    }

    /**
     * Show the form for editing santri status.
     */
    public function editSantriStatus(Santri $santri)
    {
        return view('admin.santri.edit-status', compact('santri'));
    }

    /**
     * Update the santri status.
     */
    public function updateSantriStatus(Request $request, Santri $santri)
    {
        $request->validate([
            'active' => 'required|boolean',
        ]);

        DB::beginTransaction();
        try {
            // Update santri's user status
            $santri->user->update([
                'active' => $request->active,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.santri.index')
                ->with('success', 'Status santri dan wali berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui status: ' . $e->getMessage());
        }
    }

    /**
     * Display the santri's profile page.
     */
    public function santriProfile()
    {
        $user = Auth::user();
        $santri = Santri::with(['user', 'wali', 'transactions', 'topups', 'walletHistories'])
            ->where('user_id', $user->id)
            ->first();

        return view('santri.profile', compact('user', 'santri'));
    }


    public function waliProfile()
    {
        $user = Auth::user();
        $santris = Santri::where('wali_id', $user->id)->get();
        return view('wali.profile', compact('user', 'santris'));
    }
}
