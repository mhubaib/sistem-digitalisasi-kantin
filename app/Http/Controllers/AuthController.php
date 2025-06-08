<?php

namespace App\Http\Controllers;

use App\Mail\SantriApprovedMail;
use App\Mail\WaliAccountCreated;
use App\Models\Santri;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;
use App\Services\NotificationService;

class AuthController extends Controller
{

    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    // Tampilkan daftar santri yang belum di-approve (admin)
    public function index()
    {
        $pendingSantris = User::with('santri')->where('role', 'santri')->where('active', false)->get();
        return view('admin.santri-approvals', compact('pendingSantris'));
    }

    // Form Registrasi Santri
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Proses Registrasi Santri + Buat Akun Wali
    public function register(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|min:6|confirmed',
            'wali_email'   => 'required|email|different:email',
        ]);

        // Buat akun santri (belum aktif, nunggu approval)
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'santri',
            'active'   => false,
        ]);

        // Simpan data santri dengan wali_email (tanpa membuat akun wali dulu)
        $santri = Santri::create([
            'user_id' => $user->id,
            'wali_id' => null, // Akan diisi nanti saat approval
            'status' => 'pending',
            'wali_email' => $request->wali_email,
        ]);

        // Tambahkan notifikasi untuk admin
        $notification = $this->notificationService->createForAdmin(
            'santri_registration',
            'Pendaftaran Santri Baru',
            "Santri baru {$user->name} telah mendaftar dan menunggu persetujuan.",
            ['santri_id' => $user->id]
        );

        return redirect()->route('auth.login')->with('success', 'Registrasi berhasil. Tunggu persetujuan admin.');
    }

    // Tampilkan form Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses Login
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

            // Arahkan ke dashboard sesuai role
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


    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth.login');
    }

    // Tampilkan daftar santri yang belum di-approve (admin)
    public function showPendingSantri()
    {
        $santris = User::where('role', 'santri')->where('active', false)->get();
        return view('<admin class="santri"></admin>approvals', compact('santris'));
    }

    // Approve santri oleh admin
    public function approveSantri($id)
    {
        $user = User::with('santri')->where('id', $id)->where('role', 'santri')->firstOrFail();
        $user->active = true;
        $user->save();

        // Update status santri
        if ($user->santri) {
            $santri = $user->santri;
            $santri->status = 'approved';

            // Buat akun wali jika belum ada
            $wali = User::where('email', $santri->wali_email)->where('role', 'wali')->first();

            if (!$wali) {
                // Buat password wali secara acak (8 karakter acak)
                $generatedPassword = Str::random(8);
                $wali = User::create([
                    'name'     => 'Wali dari ' . $user->name,
                    'email'    => $santri->wali_email,
                    'password' => Hash::make($generatedPassword),
                    'role'     => 'wali',
                    'active'   => true,
                ]);

                // Kirim password wali ke email
                Mail::to($wali->email)->send(new WaliAccountCreated($wali, $generatedPassword, $user->name));
            }

            // Update wali_id di santri
            $santri->wali_id = $wali->id;
            $santri->save();

            // Kirim email notifikasi ke santri
            Mail::to($user->email)->send(new SantriApprovedMail($user));
        }

        return back()->with('success', 'Santri berhasil di-approve dan akun wali telah dibuat.');
    }

    // Tolak pendaftaran santri
    public function rejectSantri($id)
    {
        $user = User::with('santri')->where('id', $id)->where('role', 'santri')->where('active', false)->firstOrFail();

        // Hapus data santri & user (otomatis juga hapus relasi santri )
        $user->delete();

        return back()->with('success', 'Pendaftaran santri berhasil ditolak.');
    }
}
