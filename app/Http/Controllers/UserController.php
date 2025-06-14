<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('santri')->get();

        return view('admin.users.index', compact('users'));
    }

    // Menampilkan detail user
    public function show($id)
    {
        $user = User::with('santri')->findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

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

            // If santri has a wali, update wali's status too
            if ($santri->wali_id) {
                $santri->wali->update([
                    'active' => $request->active,
                ]);
            }

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
}
