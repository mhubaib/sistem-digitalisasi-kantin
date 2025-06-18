<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();
        $santri = $user->santri;

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'wali_name' => ['required', 'string', 'max:255'],
            'wali_email' => ['required', 'string', 'email', 'max:255'],
        ]);

        DB::transaction(function () use ($request, $user, $santri) {
            // Update user data
            DB::table('users')->where('id', $user->id)->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // Update wali data
            if ($santri->wali) {
                DB::table('users')->where('id', $santri->wali->id)->update([
                    'name' => $request->wali_name,
                    'email' => $request->wali_email,
                ]);
            }
        });

        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai']);
        }

        DB::table('users')->where('id', $user->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->back()->with('success', 'Password berhasil diperbarui');
    }
}
