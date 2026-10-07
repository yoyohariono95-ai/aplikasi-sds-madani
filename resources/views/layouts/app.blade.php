<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SDS Madani E-Learning SD Kelas 4-6')</title>
    <meta name="description" content="Aplikasi Pembelajaran Interaktif SDS Madani Kelas 4-6: Matematika, IPA, IPS, Bahasa Indonesia, Bahasa Inggris dengan Gamifikasi, Kuis, Portal Guru & Orang Tua.">
    <!-- Favicon & School Brand Icons -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/logo-512.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-512.png') }}">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fredoka:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    @yield('styles')
</head>
<body class="theme-app">
    <!-- Glowing background elements -->
    <div class="ambient-glow glow-1"></div>
    <div class="ambient-glow glow-2"></div>
    <div class="ambient-glow glow-3"></div>

    <!-- Main Navigation Bar -->
    <header class="app-header">
        <div class="nav-container">
            <!-- Brand Logo SDS Madani Pontianak -->
            <div class="nav-brand">
                <a href="{{ route('home') }}" class="brand-link" title="Beranda E-Learning SDS Madani Pontianak Tenggara">
                    <div class="brand-logo-wrapper">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo SDS Madani Pontianak Tenggara" class="brand-logo-img">
                    </div>
                    <div class="brand-title-box">
                        <span class="brand-text">SDS MADANI</span>
                        <span class="brand-subtext">PONTIANAK TENGGARA</span>
                    </div>
                    <span class="badge-grade">SD KELAS 4-6</span>
                </a>
            </div>

            <!-- Primary Navigation Menu (Desktop) -->
            <nav class="nav-menu" id="primaryNavMenu">
                @auth
                    @if(Auth::user()->isGuru())
                        <!-- Menu Khusus Guru -->
                        <a href="{{ route('teacher.index') }}" class="nav-item nav-item-teacher {{ request()->routeIs('teacher.index') ? 'active' : '' }}">
                            <span class="icon">👨‍🏫</span> Dashboard Guru
                        </a>
                        <a href="{{ route('learning.index') }}" class="nav-item {{ request()->routeIs('learning.*') ? 'active' : '' }}">
                            <span class="icon">📚</span> Modul & Soal
                        </a>
                        <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                            <span class="icon">👁️</span> Pratinjau Siswa
                        </a>
                        <a href="{{ route('teacher.export') }}" class="nav-item" title="Unduh Rekap Nilai CSV">
                            <span class="icon">📥</span> Unduh CSV
                        </a>
                    @elseif(Auth::user()->isOrangTua())
                        <!-- Menu Khusus Orang Tua -->
                        <a href="{{ route('parent.index') }}" class="nav-item nav-item-parent {{ request()->routeIs('parent.index') ? 'active' : '' }}">
                            <span class="icon">👨‍👩‍👧</span> Portal Orang Tua
                        </a>
                        <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                            <span class="icon">📚</span> Materi Ananda
                        </a>
                        <a href="{{ route('quiz.daily') }}" class="nav-item {{ request()->routeIs('quiz.daily') ? 'active' : '' }}">
                            <span class="icon">⚡</span> Kuis Anak
                        </a>
                    @else
                        <!-- Menu Siswa (Default) -->
                        <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                            <span class="icon">🏠</span> Beranda
                        </a>
                        <a href="{{ route('learning.index') }}" class="nav-item {{ request()->routeIs('learning.*') ? 'active' : '' }}">
                            <span class="icon">📚</span> Belajar Inti
                        </a>
                        <a href="{{ route('quiz.daily') }}" class="nav-item {{ request()->routeIs('quiz.daily') ? 'active' : '' }}">
                            <span class="icon">⚡</span> Kuis Harian
                            <span class="nav-badge-pulse">10 Soal</span>
                        </a>
                        <a href="{{ route('gamification.index') }}" class="nav-item {{ request()->routeIs('gamification.*') ? 'active' : '' }}">
                            <span class="icon">🎮</span> Gamifikasi & Game
                        </a>
                    @endif
                @else
                    <!-- Menu Pengunjung (Belum Login) -->
                    <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                        <span class="icon">🏠</span> Beranda
                    </a>
                    <a href="{{ route('learning.index') }}" class="nav-item {{ request()->routeIs('learning.*') ? 'active' : '' }}">
                        <span class="icon">📚</span> Belajar Inti
                    </a>
                    <a href="{{ route('quiz.daily') }}" class="nav-item {{ request()->routeIs('quiz.daily') ? 'active' : '' }}">
                        <span class="icon">⚡</span> Kuis Harian
                    </a>
                    <a href="{{ route('gamification.index') }}" class="nav-item {{ request()->routeIs('gamification.*') ? 'active' : '' }}">
                        <span class="icon">🎮</span> Gamifikasi
                    </a>
                @endauth
            </nav>

            <!-- Nav Stats & User Action Controls -->
            <div class="nav-stats">
                <!-- Sound Toggle Button -->
                <button class="stat-pill" id="soundToggleBtn" onclick="toggleMuteAudio()" style="cursor: pointer; background: rgba(255,255,255,0.08);" title="Nyalakan/Matikan Suara">
                    <span id="soundIcon">🔊</span>
                </button>

                @auth
                    @if(Auth::user()->isSiswa())
                        <!-- Student Gamified Quick Stats Header -->
                        <div class="stat-pill streak-pill d-none-mobile-xs" title="Streak Belajar Harian!">
                            <span class="streak-icon">🔥</span>
                            <span class="stat-val" id="headerStreak">7</span>
                            <span class="stat-lbl">Hari</span>
                        </div>
                        <div class="stat-pill xp-pill d-none-mobile-xs" title="XP Kamu (Kumpulkan untuk naik level!)">
                            <span class="xp-icon">⭐</span>
                            <span class="stat-val" id="headerXp">850</span>
                            <span class="stat-lbl">XP</span>
                        </div>
                        <div class="stat-pill coin-pill" title="Koin Bintang untuk Beli Aksesoris Avatar">
                            <span class="coin-icon">🪙</span>
                            <span class="stat-val" id="headerCoins">350</span>
                        </div>
                    @elseif(Auth::user()->isGuru())
                        <!-- Teacher Quick Header Pill -->
                        <div class="stat-pill" style="background: rgba(139, 92, 246, 0.18); border-color: rgba(139, 92, 246, 0.4); color: #c4b5fd;">
                            <span>👨‍🏫 Guru 5-A</span>
                        </div>
                    @elseif(Auth::user()->isOrangTua())
                        <!-- Parent Quick Header Pill -->
                        <div class="stat-pill" style="background: rgba(16, 185, 129, 0.18); border-color: rgba(16, 185, 129, 0.4); color: #86efac;">
                            <span>👨‍👩‍👧 Orang Tua Doni</span>
                        </div>
                    @endif

                    <!-- User Account Dropdown Button -->
                    <div class="user-dropdown-container">
                        <button class="user-account-btn" id="userMenuToggleBtn" onclick="toggleUserDropdown(event)" title="Menu Akun & Ganti Peran">
                            <span class="user-role-avatar">{{ Auth::user()->avatar ?? (Auth::user()->isGuru() ? '👩‍🏫' : (Auth::user()->isOrangTua() ? '👩‍👧' : '🚀')) }}</span>
                            <span class="user-name-short">{{ explode(' ', Auth::user()->name)[0] }}</span>
                            <span class="user-dropdown-chevron">▼</span>
                        </button>

                        <!-- Dropdown Menu Box -->
                        <div class="user-dropdown-menu" id="userDropdownMenu">
                            <div class="dropdown-header">
                                <div class="dropdown-user-name">{{ Auth::user()->name }}</div>
                                <div class="dropdown-role-badge role-badge-{{ Auth::user()->role }}">
                                    {{ Auth::user()->role_label }}
                                </div>
                                <div class="dropdown-user-email">{{ Auth::user()->email }}</div>
                            </div>

                            <div class="dropdown-divider"></div>

                            <div class="dropdown-section-title">Ganti Peran Cepat (Demo):</div>
                            <div class="dropdown-role-switchers">
                                <form action="{{ route('login.quick') }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <input type="hidden" name="role" value="siswa">
                                    <button type="submit" class="dropdown-role-btn {{ Auth::user()->isSiswa() ? 'current' : '' }}">
                                        <span>🎒</span> Siswa (Doni)
                                    </button>
                                </form>
                                <form action="{{ route('login.quick') }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <input type="hidden" name="role" value="guru">
                                    <button type="submit" class="dropdown-role-btn {{ Auth::user()->isGuru() ? 'current' : '' }}">
                                        <span>👨‍🏫</span> Guru (Rahmawati)
                                    </button>
                                </form>
                                <form action="{{ route('login.quick') }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <input type="hidden" name="role" value="orang_tua">
                                    <button type="submit" class="dropdown-role-btn {{ Auth::user()->isOrangTua() ? 'current' : '' }}">
                                        <span>👨‍👩‍👧</span> Orang Tua (Bunda)
                                    </button>
                                </form>
                            </div>

                            <div class="dropdown-divider"></div>

                            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit" class="dropdown-logout-btn">
                                    <span>🚪</span> Keluar dari Akun
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Login Button for Guests -->
                    <a href="{{ route('login') }}" class="btn-nav-login" title="Masuk ke Akun Anda">
                        <span>🔐</span> <span class="login-text">Masuk</span>
                    </a>
                @endauth

                <!-- Hamburger Button for Mobile & Tablet -->
                <button class="hamburger-btn" id="mobileMenuToggleBtn" onclick="toggleMobileDrawer()" aria-label="Menu Navigasi Mobile">
                    <span class="bar bar-1"></span>
                    <span class="bar bar-2"></span>
                    <span class="bar bar-3"></span>
                </button>
            </div>
        </div>
    </header>

    <!-- Mobile Navigation Drawer & Backdrop -->
    <div class="mobile-drawer-backdrop" id="mobileDrawerBackdrop" onclick="closeMobileDrawer()"></div>
    <aside class="mobile-nav-drawer" id="mobileNavDrawer">
        <div class="mobile-drawer-header">
            <div class="drawer-brand">
                <div class="brand-logo-wrapper" style="width: 44px; height: 44px;">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo SDS Madani" class="brand-logo-img">
                </div>
                <div>
                    <div style="font-family: var(--font-heading); font-size: 1.15rem; color: white; font-weight: 700; line-height: 1.2;">SDS MADANI</div>
                    <div style="font-size: 0.68rem; color: #a5b4fc; font-weight: 700; letter-spacing: 0.5px;">AL-MADANI PONTIANAK TENGGARA</div>
                </div>
            </div>
            <button class="btn-drawer-close" onclick="closeMobileDrawer()" aria-label="Tutup Menu">✕</button>
        </div>

        <div class="mobile-drawer-body">
            @auth
                <!-- User Profile Card in Mobile Drawer -->
                <div class="mobile-user-card">
                    <div class="mobile-avatar">{{ Auth::user()->avatar ?? '🚀' }}</div>
                    <div class="mobile-user-details">
                        <div class="mobile-user-name">{{ Auth::user()->name }}</div>
                        <div class="dropdown-role-badge role-badge-{{ Auth::user()->role }}">
                            {{ Auth::user()->role_label }}
                        </div>
                    </div>
                </div>

                @if(Auth::user()->isSiswa())
                    <!-- Mobile Student Stats Row -->
                    <div class="mobile-stats-row">
                        <div class="mobile-stat-item">
                            <span style="color: #f97316;">🔥</span>
                            <span><strong>7</strong> Hari Streak</span>
                        </div>
                        <div class="mobile-stat-item">
                            <span style="color: #fbbf24;">⭐</span>
                            <span><strong>850</strong> XP</span>
                        </div>
                        <div class="mobile-stat-item">
                            <span style="color: #fbbf24;">🪙</span>
                            <span><strong>350</strong> Koin</span>
                        </div>
                    </div>
                @endif
            @else
                <div class="mobile-guest-card">
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 0.8rem;">
                        Belum masuk? Pilih peran untuk pengalaman belajar terbaik.
                    </p>
                    <a href="{{ route('login') }}" class="btn btn-primary btn-sm" style="width: 100%; justify-content: center;">
                        🔐 Halaman Masuk / Login
                    </a>
                </div>
            @endauth

            <div class="mobile-menu-section-title">NAVIGASI UTAMA</div>
            <nav class="mobile-drawer-nav">
                @auth
                    @if(Auth::user()->isGuru())
                        <a href="{{ route('teacher.index') }}" class="mobile-nav-link {{ request()->routeIs('teacher.index') ? 'active' : '' }}" onclick="closeMobileDrawer()">
                            <span class="icon">👨‍🏫</span> Dashboard Guru
                        </a>
                        <a href="{{ route('learning.index') }}" class="mobile-nav-link {{ request()->routeIs('learning.*') ? 'active' : '' }}" onclick="closeMobileDrawer()">
                            <span class="icon">📚</span> Modul & Bank Soal
                        </a>
                        <a href="{{ route('home') }}" class="mobile-nav-link {{ request()->routeIs('home') ? 'active' : '' }}" onclick="closeMobileDrawer()">
                            <span class="icon">👁️</span> Pratinjau Tampilan Siswa
                        </a>
                        <a href="{{ route('teacher.export') }}" class="mobile-nav-link" onclick="closeMobileDrawer()">
                            <span class="icon">📥</span> Unduh Rekap Nilai CSV
                        </a>
                    @elseif(Auth::user()->isOrangTua())
                        <a href="{{ route('parent.index') }}" class="mobile-nav-link {{ request()->routeIs('parent.*') ? 'active' : '' }}" onclick="closeMobileDrawer()">
                            <span class="icon">👨‍👩‍👧</span> Portal Orang Tua
                        </a>
                        <a href="{{ route('home') }}" class="mobile-nav-link {{ request()->routeIs('home') ? 'active' : '' }}" onclick="closeMobileDrawer()">
                            <span class="icon">📚</span> Materi Pelajaran Ananda
                        </a>
                        <a href="{{ route('quiz.daily') }}" class="mobile-nav-link {{ request()->routeIs('quiz.daily') ? 'active' : '' }}" onclick="closeMobileDrawer()">
                            <span class="icon">⚡</span> Kuis Harian Ananda
                        </a>
                    @else
                        <a href="{{ route('home') }}" class="mobile-nav-link {{ request()->routeIs('home') ? 'active' : '' }}" onclick="closeMobileDrawer()">
                            <span class="icon">🏠</span> Beranda Belajar
                        </a>
                        <a href="{{ route('learning.index') }}" class="mobile-nav-link {{ request()->routeIs('learning.*') ? 'active' : '' }}" onclick="closeMobileDrawer()">
                            <span class="icon">📚</span> Modul Belajar & Coding
                        </a>
                        <a href="{{ route('quiz.daily') }}" class="mobile-nav-link {{ request()->routeIs('quiz.daily') ? 'active' : '' }}" onclick="closeMobileDrawer()">
                            <span class="icon">⚡</span> Kuis Harian (10 Soal)
                        </a>
                        <a href="{{ route('gamification.index') }}" class="mobile-nav-link {{ request()->routeIs('gamification.*') ? 'active' : '' }}" onclick="closeMobileDrawer()">
                            <span class="icon">🎮</span> Gamifikasi, Avatar & Mini Game
                        </a>
                    @endif
                @else
                    <a href="{{ route('home') }}" class="mobile-nav-link {{ request()->routeIs('home') ? 'active' : '' }}" onclick="closeMobileDrawer()">
                        <span class="icon">🏠</span> Beranda Belajar
                    </a>
                    <a href="{{ route('learning.index') }}" class="mobile-nav-link {{ request()->routeIs('learning.*') ? 'active' : '' }}" onclick="closeMobileDrawer()">
                        <span class="icon">📚</span> Modul Belajar & Coding
                    </a>
                    <a href="{{ route('quiz.daily') }}" class="mobile-nav-link {{ request()->routeIs('quiz.daily') ? 'active' : '' }}" onclick="closeMobileDrawer()">
                        <span class="icon">⚡</span> Kuis Harian (10 Soal)
                    </a>
                    <a href="{{ route('gamification.index') }}" class="mobile-nav-link {{ request()->routeIs('gamification.*') ? 'active' : '' }}" onclick="closeMobileDrawer()">
                        <span class="icon">🎮</span> Gamifikasi & Mini Game
                    </a>
                @endauth
            </nav>

            <div class="mobile-menu-section-title">GANTI PERAN CEPAT (DEMO)</div>
            <div class="mobile-role-switches">
                <form action="{{ route('login.quick') }}" method="POST">
                    @csrf
                    <input type="hidden" name="role" value="siswa">
                    <button type="submit" class="btn-mobile-role role-siswa">
                        <span>🎒</span> Tampilan Siswa
                    </button>
                </form>
                <form action="{{ route('login.quick') }}" method="POST">
                    @csrf
                    <input type="hidden" name="role" value="guru">
                    <button type="submit" class="btn-mobile-role role-guru">
                        <span>👨‍🏫</span> Tampilan Guru
                    </button>
                </form>
                <form action="{{ route('login.quick') }}" method="POST">
                    @csrf
                    <input type="hidden" name="role" value="orang_tua">
                    <button type="submit" class="btn-mobile-role role-orang_tua">
                        <span>👨‍👩‍👧</span> Tampilan Orang Tua
                    </button>
                </form>
            </div>
        </div>

        <div class="mobile-drawer-footer">
            @auth
                <form action="{{ route('logout') }}" method="POST" style="margin: 0; width: 100%;">
                    @csrf
                    <button type="submit" class="btn-drawer-logout">
                        <span>🚪</span> Keluar dari Akun
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary" style="width: 100%; justify-content: center;">
                    🔐 Masuk ke Portal
                </a>
            @endauth
        </div>
    </aside>

    <!-- Global Floating Alert/Toast Container for Session Messages -->
    @if(session('success') || session('warning') || session('info') || session('error'))
        <div class="global-toast-container" id="globalToastContainer">
            @if(session('success'))
                <div class="global-toast toast-success">
                    <span class="toast-icon">✅</span>
                    <div class="toast-content">{{ session('success') }}</div>
                    <button class="toast-close" onclick="dismissToast(this)">✕</button>
                </div>
            @endif
            @if(session('warning'))
                <div class="global-toast toast-warning">
                    <span class="toast-icon">⚠️</span>
                    <div class="toast-content">{{ session('warning') }}</div>
                    <button class="toast-close" onclick="dismissToast(this)">✕</button>
                </div>
            @endif
            @if(session('info'))
                <div class="global-toast toast-info">
                    <span class="toast-icon">ℹ️</span>
                    <div class="toast-content">{{ session('info') }}</div>
                    <button class="toast-close" onclick="dismissToast(this)">✕</button>
                </div>
            @endif
            @if(session('error'))
                <div class="global-toast toast-error">
                    <span class="toast-icon">❌</span>
                    <div class="toast-content">{{ session('error') }}</div>
                    <button class="toast-close" onclick="dismissToast(this)">✕</button>
                </div>
            @endif
        </div>
    @endif

    <!-- Main Content Area -->
    <main class="app-main">
        @yield('content')
    </main>

    <!-- Screen Time Warning Indicator (Only for Siswa or Guest) -->
    @if(!Auth::check() || Auth::user()->isSiswa())
        <!-- Screen Time Out Overlay Modal (Locks screen when time reaches 0) -->
        <div id="screenTimeLockModal" style="display: none; position: fixed; inset: 0; background: rgba(2,6,23,0.96); backdrop-filter: blur(20px); z-index: 99999; align-items: center; justify-content: center; padding: 2rem;">
            <div class="glass-panel" style="max-width: 480px; width: 100%; text-align: center; border-color: #ef4444; box-shadow: 0 0 50px rgba(239,68,68,0.4);">
                <div style="font-size: 4rem; margin-bottom: 1rem;">🛑</div>
                <h2 style="font-family: var(--font-heading); color: #fca5a5; font-size: 1.8rem; margin-bottom: 0.5rem;">Waktu Belajar Harian Selesai!</h2>
                <p style="color: #cbd5e1; font-size: 0.95rem; margin-bottom: 1.5rem; line-height: 1.6;">
                    Hebat sekali, kamu sudah belajar dengan tekun hari ini! Istirahatkan matamu sejenak ya. Untuk melanjutkan belajar, mintalah Ayah atau Bunda untuk membuka kunci via Portal Orang Tua.
                </p>
                <div style="display: flex; gap: 0.8rem; justify-content: center; flex-wrap: wrap;">
                    <a href="{{ route('parent.index') }}" class="btn btn-primary">
                        Buka Portal Orang Tua (Buka Kunci PIN)
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- Official School Footer -->
    <footer class="app-footer">
        <div class="footer-container">
            <div class="footer-brand-section">
                <div class="footer-brand-header">
                    <div class="footer-logo-wrapper">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo Resmi SDS Al-Madani Pontianak" class="footer-logo-img">
                    </div>
                    <div>
                        <div class="footer-school-name">SDS AL - MADANI</div>
                        <div class="footer-school-sub">PONTIANAK TENGGARA</div>
                    </div>
                </div>
                <p class="footer-desc">
                    Platform e-learning interaktif terpadu untuk siswa kelas 4, 5, dan 6 Sekolah Dasar Swasta Al-Madani Pontianak Tenggara. Dilengkapi gamifikasi kuis, penguasaan kurikulum inti, modul coding & logika algoritma, serta portal monitoring orang tua dan pendidik.
                </p>
                <div class="footer-badges">
                    <span class="footer-badge">🎓 Kurikulum Merdeka</span>
                    <span class="footer-badge">💻 Literasi Digital & Coding</span>
                    <span class="footer-badge">🛡️ Aman Ramah Anak</span>
                </div>
            </div>

            <div class="footer-links-group">
                <div class="footer-links-col">
                    <h4 class="footer-col-title">Navigasi Utama</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Beranda Belajar</a></li>
                        <li><a href="{{ route('learning.index') }}">Modul & Materi Inti</a></li>
                        <li><a href="{{ route('quiz.daily') }}">Kuis Harian (10 Soal)</a></li>
                        <li><a href="{{ route('gamification.index') }}">Gamifikasi & Mini Game</a></li>
                    </ul>
                </div>

                <div class="footer-links-col">
                    <h4 class="footer-col-title">Portal Peran</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('login') }}">Masuk Akun (Login)</a></li>
                        <li><a href="{{ route('teacher.index') }}">Dashboard Guru Pengajar</a></li>
                        <li><a href="{{ route('parent.index') }}">Portal Pendamping Orang Tua</a></li>
                        <li><a href="{{ route('erd') }}" target="_blank">Dokumentasi ERD Sistem</a></li>
                    </ul>
                </div>

                <div class="footer-links-col">
                    <h4 class="footer-col-title">Kontak & Lokasi</h4>
                    <ul class="footer-links contact-info">
                        <li>📍 Pontianak Tenggara, Kalimantan Barat</li>
                        <li>🏫 Sekolah Dasar Swasta Al-Madani</li>
                        <li>⭐ Kelas 4, Kelas 5, Kelas 6 SD</li>
                        <li>🕒 Jam Belajar: 07.00 - 14.30 WIB</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="footer-bottom-container">
                <p>© {{ date('Y') }} SDS Al-Madani Pontianak Tenggara. Seluruh hak cipta dilindungi.</p>
                <div class="footer-bottom-links">
                    <span>Membentuk Generasi Cerdas, Tangguh & Berakhlakul Karimah</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Interactive Audio FX Engine & Global Script -->
    <script>
        class SoundFX {
            constructor() {
                this.ctx = null;
                this.muted = localStorage.getItem('sds_muted') === 'true';
            }

            init() {
                if (!this.ctx) {
                    const AudioContext = window.AudioContext || window.webkitAudioContext;
                    this.ctx = new AudioContext();
                }
            }

            playCorrect() {
                if (this.muted) return;
                this.init();
                const now = this.ctx.currentTime;
                const osc = this.ctx.createOscillator();
                const gain = this.ctx.createGain();
                osc.type = 'triangle';
                osc.frequency.setValueAtTime(523.25, now);
                osc.frequency.exponentialRampToValueAtTime(659.25, now + 0.1);
                osc.frequency.exponentialRampToValueAtTime(783.99, now + 0.2);
                osc.frequency.exponentialRampToValueAtTime(1046.50, now + 0.3);
                gain.gain.setValueAtTime(0.3, now);
                gain.gain.linearRampToValueAtTime(0, now + 0.45);
                osc.connect(gain);
                gain.connect(this.ctx.destination);
                osc.start(now);
                osc.stop(now + 0.45);
            }

            playWrong() {
                if (this.muted) return;
                this.init();
                const now = this.ctx.currentTime;
                const osc = this.ctx.createOscillator();
                const gain = this.ctx.createGain();
                osc.type = 'sawtooth';
                osc.frequency.setValueAtTime(220, now);
                osc.frequency.linearRampToValueAtTime(160, now + 0.25);
                gain.gain.setValueAtTime(0.25, now);
                gain.gain.linearRampToValueAtTime(0, now + 0.3);
                osc.connect(gain);
                gain.connect(this.ctx.destination);
                osc.start(now);
                osc.stop(now + 0.3);
            }

            playCoin() {
                if (this.muted) return;
                this.init();
                const now = this.ctx.currentTime;
                const osc = this.ctx.createOscillator();
                const gain = this.ctx.createGain();
                osc.type = 'sine';
                osc.frequency.setValueAtTime(987.77, now);
                osc.frequency.setValueAtTime(1318.51, now + 0.08);
                gain.gain.setValueAtTime(0.3, now);
                gain.gain.linearRampToValueAtTime(0, now + 0.35);
                osc.connect(gain);
                gain.connect(this.ctx.destination);
                osc.start(now);
                osc.stop(now + 0.35);
            }

            playFanfare() {
                if (this.muted) return;
                this.init();
                const notes = [440, 554.37, 659.25, 880];
                notes.forEach((freq, idx) => {
                    const now = this.ctx.currentTime + (idx * 0.12);
                    const osc = this.ctx.createOscillator();
                    const gain = this.ctx.createGain();
                    osc.type = 'square';
                    osc.frequency.setValueAtTime(freq, now);
                    gain.gain.setValueAtTime(0.15, now);
                    gain.gain.linearRampToValueAtTime(0, now + 0.25);
                    osc.connect(gain);
                    gain.connect(this.ctx.destination);
                    osc.start(now);
                    osc.stop(now + 0.25);
                });
            }
        }

        window.soundFX = new SoundFX();

        function toggleMuteAudio() {
            window.soundFX.muted = !window.soundFX.muted;
            localStorage.setItem('sds_muted', window.soundFX.muted);
            const icon = document.getElementById('soundIcon');
            if (icon) icon.innerText = window.soundFX.muted ? '🔇' : '🔊';
        }

        // Gamification Persistence Engine + Backend Sync
        const GameState = {
            getXp() { return parseInt(localStorage.getItem('sds_xp') || '850'); },
            addXp(amount) {
                const newXp = this.getXp() + amount;
                localStorage.setItem('sds_xp', newXp);
                this.updateUI();
                this.syncBackend();
                return newXp;
            },
            getCoins() { return parseInt(localStorage.getItem('sds_coins') || '350'); },
            addCoins(amount) {
                const newCoins = this.getCoins() + amount;
                localStorage.setItem('sds_coins', newCoins);
                this.updateUI();
                this.syncBackend();
                return newCoins;
            },
            getAvatar() { return localStorage.getItem('sds_avatar') || '🚀'; },
            setAvatar(icon) {
                localStorage.setItem('sds_avatar', icon);
                this.updateUI();
                this.syncBackend();
            },
            updateUI() {
                const xpEl = document.getElementById('headerXp');
                const coinsEl = document.getElementById('headerCoins');
                const avatarEl = document.getElementById('headerAvatarFace');
                if (xpEl) xpEl.innerText = this.getXp();
                if (coinsEl) coinsEl.innerText = this.getCoins();
                if (avatarEl) avatarEl.innerText = this.getAvatar();
            },
            syncBackend() {
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                if (!token) return;
                fetch('{{ route("api.save-progress") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        xp: this.getXp(),
                        coins: this.getCoins(),
                        avatar: this.getAvatar()
                    })
                }).catch(() => {});
            }
        };

        // Mobile Drawer Controller
        function toggleMobileDrawer() {
            const drawer = document.getElementById('mobileNavDrawer');
            const backdrop = document.getElementById('mobileDrawerBackdrop');
            const btn = document.getElementById('mobileMenuToggleBtn');
            const isOpen = drawer.classList.contains('active');

            if (isOpen) {
                closeMobileDrawer();
            } else {
                drawer.classList.add('active');
                backdrop.classList.add('active');
                btn.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeMobileDrawer() {
            const drawer = document.getElementById('mobileNavDrawer');
            const backdrop = document.getElementById('mobileDrawerBackdrop');
            const btn = document.getElementById('mobileMenuToggleBtn');
            if (drawer) drawer.classList.remove('active');
            if (backdrop) backdrop.classList.remove('active');
            if (btn) btn.classList.remove('active');
            document.body.style.overflow = '';
        }

        // User Dropdown Controller
        function toggleUserDropdown(e) {
            e.stopPropagation();
            const menu = document.getElementById('userDropdownMenu');
            if (menu) menu.classList.toggle('active');
        }

        window.addEventListener('click', () => {
            const menu = document.getElementById('userDropdownMenu');
            if (menu) menu.classList.remove('active');
        });

        // Toast Dismissal
        function dismissToast(btn) {
            const toast = btn.closest('.global-toast');
            if (toast) {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(-10px)';
                setTimeout(() => toast.remove(), 300);
            }
        }

        // Auto dismiss toast after 6s
        setTimeout(() => {
            const toasts = document.querySelectorAll('.global-toast');
            toasts.forEach(t => {
                t.style.opacity = '0';
                t.style.transform = 'translateY(-10px)';
                setTimeout(() => t.remove(), 300);
            });
        }, 6000);

        // Screen Time Countdown Simulation
        let screenTimeRemainingMinutes = parseInt(localStorage.getItem('sds_screen_time_left') || '20');

        function updateScreenTimeDisplay() {
            const remEl = document.getElementById('screenTimeRemainingText');
            if (remEl) remEl.innerText = screenTimeRemainingMinutes;
            if (screenTimeRemainingMinutes <= 0) {
                const modal = document.getElementById('screenTimeLockModal');
                if (modal) modal.style.display = 'flex';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            GameState.updateUI();
            const icon = document.getElementById('soundIcon');
            if (icon && window.soundFX.muted) icon.innerText = '🔇';
            updateScreenTimeDisplay();
        });
    </script>

    @yield('scripts')
</body>
</html>
