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
use Illuminate\Support\Facades\DB;

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
        // Ambil data santri pending dengan email wali
        $pendingSantris = DB::table('users')
            ->join('santris', 'users.id', '=', 'santris.user_id')
            ->where('users.role', 'santri')
            ->where('santris.status', 'pending')
            ->select('users.*', 'santris.wali_email', 'santris.status as santri_status')
            ->get();

        // Convert ke collection User untuk kompatibilitas
        $pendingSantris = $pendingSantris->map(function ($item) {
            $user = User::find($item->id);
            $user->wali_email = $item->wali_email;
            return $user;
        });

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

        // Log untuk memverifikasi penyimpanan wali_email
        Log::info('Santri Registration Debug', [
            'user_id' => $user->id,
            'santri_id' => $santri->id,
            'wali_email' => $santri->wali_email,
            'input_wali_email' => $request->wali_email
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

            // Cek status aktif user
            if (!$user->active) {
                Auth::logout();
                return back()->with('error', 'Akun Anda telah dinonaktifkan.');
            }

            // Khusus untuk wali, cek status aktif santri
            if ($user->role === 'wali') {
                $santri = Santri::where('wali_id', $user->id)->first();
                if ($santri && !$santri->user->active) {
                    Auth::logout();
                    return back()->with('error', 'Akun Anda telah dinonaktifkan karena anak anda telah dinonaktifkan.');
                }
            }

            // Khusus untuk santri, cek status approval
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

    // Approve santri oleh admin
    public function approveSantri($id)
    {
        DB::beginTransaction();
        try {
            $user = User::with('santri')
                ->where('id', $id)
                ->where('role', 'santri')
                ->whereHas('santri', function ($q) {
                    $q->where('status', 'pending');
                })
                ->firstOrFail();

            // Update user status
            $user->active = true;
            $user->save();

            // Update status santri
            $santri = Santri::where('user_id', $user->id)->where('status', 'pending')->first();
            if (!$santri) {
                throw new \Exception('Data santri tidak ditemukan atau sudah tidak pending.');
            }
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

                try {
                    // Kirim password wali ke email
                    Mail::to($wali->email)->send(new WaliAccountCreated($wali, $generatedPassword, $user->name));
                } catch (\Exception $e) {
                    Log::error('Failed to send email to wali: ' . $e->getMessage());
                    // Lanjutkan proses meskipun email gagal terkirim
                }
            }

            // Update wali_id di santri
            $santri->wali_id = $wali->id;
            $santri->save();

            try {
                // Kirim email notifikasi ke santri
                Mail::to($user->email)->send(new SantriApprovedMail($user));
            } catch (\Exception $e) {
                Log::error('Failed to send email to santri: ' . $e->getMessage());
                // Lanjutkan proses meskipun email gagal terkirim
            }

            // Tambahkan notifikasi untuk santri
            $this->notificationService->createForSantri(
                $user->id,
                'santri_approved',
                'Akun Disetujui',
                'Akun Anda telah disetujui oleh admin. Sekarang Anda dapat mengakses sistem.',
                ['santri_id' => $user->id]
            );

            // Tambahkan notifikasi untuk wali
            $this->notificationService->createForWali(
                $wali->id,
                'wali_account_created',
                'Akun Wali Dibuat',
                'Akun wali telah dibuat untuk Anda. Silakan cek email Anda untuk informasi login.',
                ['santri_id' => $user->id]
            );

            DB::commit();
            return back()->with('success', 'Santri berhasil di-approve dan akun wali telah dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to approve santri: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyetujui santri: ' . $e->getMessage());
        }
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
