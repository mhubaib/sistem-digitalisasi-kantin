<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // 🧾 Form Registrasi Santri
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // 📝 Proses Registrasi Santri + Buat Akun Wali
    public function register(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'password'     =>'required|min:6|confirmed',
            'wali_email'   => 'required|email|different:email',
        ]);

        // Buat akun wali
        $generatedPassword = Str::random(8);
        $wali = User::create([
            'name'     => 'Wali dari ' . $request->name,
            'email'    => $request->wali_email,
            'password' => Hash::make($generatedPassword),
            'role'     => 'wali',
            'active'   => true,
        ]);

        // Kirim password wali ke email
        Mail::raw("Akun wali Anda telah dibuat. Password: {$generatedPassword}", function ($message) use ($wali) {
            $message->to($wali->email)
                ->subject('Akun Wali Santri - Sistem Pondok');
        });

        // Buat akun santri (belum aktif, nunggu approval)
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => hash::make($request->password),
            'role'     => 'santri',
            'active'   => false,
        ]);

        Santri::create([
            'user_id' => $user->id,
            'wali_id' => $wali->id,
            'status' => 'pending',
            'wali_email' => $request->wali_email,
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil. Tunggu persetujuan admin.');
    }

    // 🔑 Form Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // 🚪 Proses Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role === 'santri' && !$user->active) {
                Auth::logout();
                return back()->with('error', 'Akun Anda belum disetujui admin.');
            }

            // 🔥 Arahkan ke dashboard sesuai role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'santri') {
                return redirect()->route('santri.dashboard');
            } elseif ($user->role === 'wali') {
                return redirect()->route('wali.dashboard');
            }

            // Jika role tidak dikenali
            Auth::logout();
            return back()->with('error', 'Role pengguna tidak dikenali.');
        }

        return back()->with('error', 'Email atau password salah.');
    }


    // 🔓 Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth. login');
    }

    // ✅ Tampilkan daftar santri yang belum di-approve (admin)
    public function showPendingSantri()
    {
        $santris = User::where('role', 'santri')->where('active', false)->get();
        return view('admin.approval', compact('santris'));
    }

    // 🟢 Approve santri oleh admin
    public function approveSantri($id)
    {
        $user = User::where('id', $id)->where('role', 'santri')->firstOrFail();
        $user->update(['active' => true]);

        return back()->with('success', 'Santri berhasil di-approve.');
    }

    // 🔴 Tolak pendaftaran santri
    public function rejectSantri($id)
    {
        $user = User::where('id', $id)->where('role', 'santri')->where('active', false)->firstOrFail();

        // Hapus data santri & user (otomatis juga hapus relasi santri jika onDelete cascade)
        $user->delete();

        return back()->with('success', 'Pendaftaran santri berhasil ditolak.');
    }
}
