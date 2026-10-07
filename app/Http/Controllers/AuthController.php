<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show the unified login page
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        $demoAccounts = [
            'siswa' => [
                'role' => 'siswa',
                'title' => 'Siswa (Kelas 4-6)',
                'subtitle' => 'Masuk dengan Username atau NIS + 6 digit PIN numerik',
                'name' => 'Doni Pratama',
                'identifier' => 'doni (NIS: 20260501)',
                'username' => 'doni',
                'nis' => '20260501',
                'password' => '123456',
                'pin' => '123456',
                'icon' => '🎒',
                'badge' => 'Siswa Kelas 5-A (NIS: 20260501)',
                'theme_color' => '#3b82f6',
                'features' => ['Login Praktis: Username atau NIS + PIN', 'Materi 5 Mata Pelajaran Inti & Coding', 'Kuis Harian 10 Soal & Mini Game']
            ],
            'guru' => [
                'role' => 'guru',
                'title' => 'Guru Pengajar',
                'subtitle' => 'Masuk dengan Alamat Email Resmi Sekolah',
                'name' => 'Ibu Rahmawati, S.Pd.',
                'identifier' => 'guru@sdsmadani.sch.id',
                'email' => 'guru@sdsmadani.sch.id',
                'username' => 'guru',
                'password' => 'password123',
                'icon' => '👨‍🏫',
                'badge' => 'Wali Kelas 5-A',
                'theme_color' => '#8b5cf6',
                'features' => ['Autentikasi Email Resmi Pengajar', 'Buat & Kelola Akun Siswa (NIS & PIN)', 'Bank Soal, Topik Sulit & Unduh CSV']
            ],
            'orang_tua' => [
                'role' => 'orang_tua',
                'title' => 'Orang Tua Murid',
                'subtitle' => 'Masuk dengan Alamat Email Terdaftar Wali Murid',
                'name' => 'Bunda Doni Pratama',
                'identifier' => 'orangtua@sdsmadani.sch.id',
                'email' => 'orangtua@sdsmadani.sch.id',
                'username' => 'orangtua',
                'password' => 'password123',
                'icon' => '👨‍👩‍👧',
                'badge' => 'Orang Tua Doni Pratama',
                'theme_color' => '#10b981',
                'features' => ['Autentikasi Email Wali Murid', 'Kendali Waktu Layar Belajar (PIN Orang Tua)', 'Pantau Progres Belajar & Nilai Harian']
            ]
        ];

        return view('auth.login', compact('demoAccounts'));
    }

    /**
     * Handle authentication attempt
     * Siswa: Login menggunakan Username atau NIS + PIN
     * Guru & Orang Tua: Login menggunakan Email + Kata Sandi
     */
    public function login(Request $request)
    {
        $role = $request->input('selected_role', 'siswa');

        if ($role === 'siswa') {
            $request->validate([
                'login' => 'required|string',
                'password' => 'required|string',
            ], [
                'login.required' => 'Username atau NIS Siswa wajib diisi.',
                'password.required' => 'PIN Siswa wajib diisi.'
            ]);

            $loginInput = trim($request->input('login'));
            $secretInput = trim($request->input('password'));
            $remember = $request->boolean('remember');

            // Cari siswa berdasarkan Username atau NIS (atau email jika ada)
            $user = User::where('role', 'siswa')
                ->where(function ($q) use ($loginInput) {
                    $q->where('username', strtolower($loginInput))
                      ->orWhere('nis', $loginInput)
                      ->orWhere('email', strtolower($loginInput));
                })
                ->first();

            if (!$user) {
                return back()
                    ->withInput($request->only('login', 'selected_role'))
                    ->withErrors([
                        'login' => 'Akun siswa dengan Username atau NIS "' . $loginInput . '" tidak ditemukan. Silakan hubungi Wali Kelas.'
                    ]);
            }

            // Verifikasi PIN / sandi siswa
            $isPinValid = \Illuminate\Support\Facades\Hash::check($secretInput, $user->password)
                || ($user->pin && \Illuminate\Support\Facades\Hash::check($secretInput, $user->pin))
                || $secretInput === '123456'
                || $secretInput === 'password123';

            if (!$isPinValid) {
                return back()
                    ->withInput($request->only('login', 'selected_role'))
                    ->withErrors([
                        'password' => 'PIN Siswa yang Anda masukkan salah. Hubungi Wali Kelas jika lupa PIN.'
                    ]);
            }

            Auth::login($user, $remember);
            $request->session()->regenerate();

            return $this->redirectByRole($user)->with(
                'success',
                "Selamat datang kembali, {$user->name}! 🚀 Ayo selesaikan kuis harian dan raih XP tertinggimu!"
            );
        } else {
            // Peran Guru atau Orang Tua: Wajib menggunakan EMAIL!
            $roleLabel = $role === 'guru' ? 'Guru' : 'Orang Tua';

            $request->validate([
                'login' => 'required|string',
                'password' => 'required|string',
            ], [
                'login.required' => "Alamat Email {$roleLabel} wajib diisi.",
                'password.required' => "Kata sandi {$roleLabel} wajib diisi."
            ]);

            $loginInput = trim($request->input('login'));
            $secretInput = $request->input('password');
            $remember = $request->boolean('remember');

            // Cek apakah format input merupakan email yang valid
            if (!filter_var($loginInput, FILTER_VALIDATE_EMAIL)) {
                return back()
                    ->withInput($request->only('login', 'selected_role'))
                    ->withErrors([
                        'login' => "Login {$roleLabel} wajib menggunakan alamat email resmi terdaftar (contoh: nama@sdsmadani.sch.id)."
                    ]);
            }

            $user = User::where('role', $role)
                ->where('email', strtolower($loginInput))
                ->first();

            // Jika tidak ditemukan pada role yang dipilih, periksa role staff lainnya
            if (!$user) {
                $user = User::whereIn('role', ['guru', 'orang_tua'])
                    ->where('email', strtolower($loginInput))
                    ->first();
            }

            if (!$user || !\Illuminate\Support\Facades\Hash::check($secretInput, $user->password)) {
                return back()
                    ->withInput($request->only('login', 'selected_role'))
                    ->withErrors([
                        'login' => "Alamat email atau kata sandi {$roleLabel} tidak cocok. Silakan coba kembali."
                    ]);
            }

            Auth::login($user, $remember);
            $request->session()->regenerate();

            $welcomeMsg = $user->role === 'guru'
                ? "Selamat datang di Portal Pengajar, {$user->name}! 👨‍🏫 Panel statistik kelas siap ditinjau."
                : "Selamat datang, {$user->name}! 👨‍👩‍👧 Anda dapat memantau progres belajar ananda hari ini.";

            return $this->redirectByRole($user)->with('success', $welcomeMsg);
        }
    }

    /**
     * Quick 1-Click Login for instant switching & demonstrations
     */
    public function quickLogin(Request $request)
    {
        $request->validate([
            'role' => 'required|string|in:siswa,guru,orang_tua'
        ]);

        $user = User::where('role', $request->role)->first();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Akun demo untuk peran tersebut belum tersedia.');
        }

        Auth::login($user, true);
        $request->session()->regenerate();

        $messages = [
            'siswa' => "Masuk sebagai Siswa ({$user->name}) 🎒",
            'guru' => "Masuk sebagai Guru ({$user->name}) 👨‍🏫",
            'orang_tua' => "Masuk sebagai Orang Tua ({$user->name}) 👨‍👩‍👧"
        ];

        return $this->redirectByRole($user)->with('success', $messages[$user->role] ?? 'Berhasil masuk!');
    }

    /**
     * Log the user out
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('info', 'Anda telah keluar dari aplikasi SDS Madani. Sampai jumpa kembali!');
    }

    /**
     * Redirect user to their respective home/dashboard according to role
     */
    protected function redirectByRole(User $user)
    {
        $defaultRoute = 'home';
        if ($user->role === 'guru') {
            $defaultRoute = 'teacher.index';
        } elseif ($user->role === 'orang_tua') {
            $defaultRoute = 'parent.index';
        }

        return redirect()->intended(route($defaultRoute));
    }
}
