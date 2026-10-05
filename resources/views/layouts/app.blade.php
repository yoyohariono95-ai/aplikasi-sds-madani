<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SDS Madani E-Learning SD Kelas 4-6')</title>
    <meta name="description" content="Aplikasi Pembelajaran Interaktif SDS Madani Kelas 4-6: Matematika, IPA, IPS, Bahasa Indonesia, Bahasa Inggris dengan Gamifikasi, Kuis, Portal Guru & Orang Tua.">
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
            <div class="nav-brand">
                <a href="{{ route('home') }}" class="brand-link">
                    <span class="brand-icon">🚀</span>
                    <span class="brand-text">SDS MADANI</span>
                    <span class="badge-grade">SD KELAS 4-6</span>
                </a>
            </div>

            <nav class="nav-menu" id="primaryNavMenu">
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
                <a href="{{ route('teacher.index') }}" class="nav-item nav-item-teacher {{ request()->routeIs('teacher.*') ? 'active' : '' }}">
                    <span class="icon">👨‍🏫</span> Guru
                </a>
                <a href="{{ route('parent.index') }}" class="nav-item nav-item-parent {{ request()->routeIs('parent.*') ? 'active' : '' }}">
                    <span class="icon">👨‍👩‍👧</span> Orang Tua
                </a>
            </nav>

            <!-- Student Gamified Quick Stats Header -->
            <div class="nav-stats">
                <button class="stat-pill" id="soundToggleBtn" onclick="toggleMuteAudio()" style="cursor: pointer; background: rgba(255,255,255,0.08);" title="Nyalakan/Matikan Suara">
                    <span id="soundIcon">🔊</span>
                </button>

                <div class="stat-pill streak-pill" title="Streak Belajar Harian!">
                    <span class="streak-icon">🔥</span>
                    <span class="stat-val" id="headerStreak">7</span>
                    <span class="stat-lbl">Hari</span>
                </div>
                <div class="stat-pill xp-pill" title="XP Kamu (Kumpulkan untuk naik level!)">
                    <span class="xp-icon">⭐</span>
                    <span class="stat-val" id="headerXp">850</span>
                    <span class="stat-lbl">XP</span>
                </div>
                <div class="stat-pill coin-pill" title="Koin Bintang untuk Beli Aksesoris Avatar">
                    <span class="coin-icon">🪙</span>
                    <span class="stat-val" id="headerCoins">350</span>
                </div>
                <a href="{{ route('gamification.index') }}" class="user-avatar-btn" title="Kustomisasi Avatar">
                    <span class="avatar-face" id="headerAvatarFace">🚀</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="app-main">
        @yield('content')
    </main>

    <!-- Screen Time Warning Indicator (Parent Feature) -->
    <div class="screen-time-bar" id="screenTimeBar">
        <div class="screen-time-info">
            <span>⏱️ Waktu Belajar Hari Ini: <strong><span id="screenTimeUsedText">25</span> / <span id="screenTimeLimitText">45</span> Menit</strong> (Sisa <strong id="screenTimeRemainingText" style="color: #38bdf8;">20</strong> Menit)</span>
            <a href="{{ route('parent.index') }}" class="link-manage-time">⚙️ Atur Batas Waktu di Portal Orang Tua</a>
        </div>
    </div>

    <!-- Screen Time Out Overlay Modal (Locks screen when time reaches 0) -->
    <div id="screenTimeLockModal" style="display: none; position: fixed; inset: 0; background: rgba(2,6,23,0.96); backdrop-filter: blur(20px); z-index: 99999; align-items: center; justify-content: center; padding: 2rem;">
        <div class="glass-panel" style="max-width: 480px; width: 100%; text-align: center; border-color: #ef4444; box-shadow: 0 0 50px rgba(239,68,68,0.4);">
            <div style="font-size: 4rem; margin-bottom: 1rem;">🛑</div>
            <h2 style="font-family: var(--font-heading); color: #fca5a5; font-size: 1.8rem; margin-bottom: 0.5rem;">Waktu Belajar Harian Selesai!</h2>
            <p style="color: #cbd5e1; font-size: 0.95rem; margin-bottom: 1.5rem; line-height: 1.6;">
                Hebat sekali, kamu sudah belajar dengan tekun hari ini! Istirahatkan matamu sejenak ya. Untuk melanjutkan belajar, mintalah Ayah atau Bunda untuk memasukkan PIN.
            </p>
            <div style="display: flex; gap: 0.8rem; justify-content: center;">
                <a href="{{ route('parent.index') }}" class="btn btn-primary">
                    Buka Portal Orang Tua (Buka Kunci PIN)
                </a>
            </div>
        </div>
    </div>

    <!-- Interactive Audio FX Engine (Web Audio API Synthesizer) -->
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

        // Real Screen Time Countdown Simulation
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
