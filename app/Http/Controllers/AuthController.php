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
                'subtitle' => 'Petualangan materi interaktif, kuis harian 10 soal, dan mini game seru',
                'name' => 'Doni Pratama',
                'identifier' => 'siswa@sdsmadani.sch.id',
                'username' => 'siswa',
                'password' => 'password123',
                'icon' => '🎒',
                'badge' => 'Siswa Kelas 5-A',
                'theme_color' => '#3b82f6',
                'features' => ['Materi 5 Mata Pelajaran Inti', 'Kuis Harian Streak & XP', 'Koleksi Lencana & Avatar']
            ],
            'guru' => [
                'role' => 'guru',
                'title' => 'Guru Pengajar',
                'subtitle' => 'Kelola bank soal, pantau topik sulit kelas, dan unduh rekap nilai siswa',
                'name' => 'Ibu Rahmawati, S.Pd.',
                'identifier' => 'guru@sdsmadani.sch.id',
                'username' => 'guru',
                'password' => 'password123',
                'icon' => '👨‍🏫',
                'badge' => 'Wali Kelas 5-A',
                'theme_color' => '#8b5cf6',
                'features' => ['Buat & Publikasi Soal Baru', 'Analisis Topik Sulit Siswa', 'Ekspor Nilai Kelas (CSV/Excel)']
            ],
            'orang_tua' => [
                'role' => 'orang_tua',
                'title' => 'Orang Tua Murid',
                'subtitle' => 'Pantau durasi waktu layar, progres nilai harian, dan notifikasi belajar ananda',
                'name' => 'Bunda Doni Pratama',
                'identifier' => 'orangtua@sdsmadani.sch.id',
                'username' => 'orangtua',
                'password' => 'password123',
                'icon' => '👨‍👩‍👧',
                'badge' => 'Orang Tua Doni Pratama',
                'theme_color' => '#10b981',
                'features' => ['Batas Waktu Layar (Screen Time)', 'Grafik Nilai & Kelemahan Ananda', 'Simulasi Notifikasi Belajar WA']
            ]
        ];

        return view('auth.login', compact('demoAccounts'));
    }

    /**
     * Handle authentication attempt
     */
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
            'selected_role' => 'nullable|string|in:siswa,guru,orang_tua',
        ], [
            'login.required' => 'Email atau Username wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.'
        ]);

        $loginInput = trim($request->input('login'));
        $fieldType = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $fieldType => $loginInput,
            'password' => $request->input('password')
        ];

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            $welcomeMessages = [
                'siswa' => "Selamat datang kembali, {$user->name}! 🚀 Ayo selesaikan kuis harian dan raih XP tertinggimu!",
                'guru' => "Selamat datang di Portal Pengajar, {$user->name}! 👨‍🏫 Panel statistik kelas siap ditinjau.",
                'orang_tua' => "Selamat datang, {$user->name}! 👨‍👩‍👧 Anda dapat memantau progres belajar dan kendali waktu layar Doni hari ini."
            ];

            $msg = $welcomeMessages[$user->role] ?? "Selamat datang di SDS Madani E-Learning!";

            return $this->redirectByRole($user)->with('success', $msg);
        }

        return back()
            ->withInput($request->only('login', 'selected_role'))
            ->withErrors([
                'login' => 'Email/Username atau kata sandi tidak cocok. Silakan coba kembali atau gunakan Akun Demo 1-Klik.'
            ]);
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
