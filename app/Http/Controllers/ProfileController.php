<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        try {
            /** @var \App\Models\User $user */
            $user = Auth::user();

            $request->validate([
                'name' => ['required', 'string', 'max:255'],
            ]);

            $user->name = $request->name;
            $user->save();

            return redirect()->back()->with('success', 'Profil berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui profil: ' . $e->getMessage());
        }
    }

    public function updatePassword(Request $request)
    {
        try {
            // Validate input
            $validator = Validator::make($request->all(), [
                'current_password' => ['required', 'string'],
                'new_password' => ['required', 'string', 'min:8', 'different:current_password', 'confirmed'],
            ], [
                'new_password.min' => 'Password baru minimal 8 karakter.',
                'new_password.different' => 'Password baru harus berbeda dengan password saat ini.',
                'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
                'current_password.required' => 'Password saat ini harus diisi.',
            ]);

            // Check validation first
            if ($validator->fails()) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'errors' => $validator->errors()->toArray()
                    ], 422);
                }

                return back()->withErrors($validator);
            }

            // Get authenticated user
            $user = Auth::user();

            // Verify current password
            if (!Hash::check($request->current_password, $user->password)) {
                $errors = ['current_password' => ['Password saat ini tidak sesuai']];

                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'errors' => $errors
                    ], 422);
                }

                return back()->withErrors($errors);
            }

            // Update password
            $user->password = Hash::make($request->new_password);
            $user->save();

            // Redirect or return response
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Password berhasil diperbarui'
                ]);
            }

            return redirect()->route('wali.profile')->with('success', 'Password berhasil diperbarui');
        } catch (\Exception $e) {
            // Log the error for debugging
            \Illuminate\Support\Facades\Log::error('Password Update Error: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => ['system' => ['Terjadi kesalahan sistem. Silakan coba lagi.']]
                ], 500);
            }

            return back()->with('error', 'Terjadi kesalahan saat memperbarui password');
        }
    }
}
