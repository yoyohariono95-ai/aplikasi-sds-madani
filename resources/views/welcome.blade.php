@extends('layouts.app')

@section('title', 'SDS Madani E-Learning | Belajar Seru Kelas 4-6 SD')

@section('content')
<!-- Role Status Banner -->
@auth
    @if(Auth::user()->isGuru())
        <div class="role-status-banner role-status-guru">
            <div class="role-status-content">
                <span class="role-status-icon">👨‍🏫</span>
                <div>
                    <strong>Mode Guru Aktif:</strong> Anda masuk sebagai <b>{{ Auth::user()->name }}</b>. Anda sedang melihat pratinjau antarmuka materi siswa kelas 4-6.
                </div>
            </div>
            <div class="role-status-actions">
                <a href="{{ route('teacher.index') }}" class="btn btn-primary btn-sm">
                    🚀 Buka Dashboard Guru
                </a>
            </div>
        </div>
    @elseif(Auth::user()->isOrangTua())
        <div class="role-status-banner role-status-parent">
            <div class="role-status-content">
                <span class="role-status-icon">👨‍👩‍👧</span>
                <div>
                    <strong>Mode Orang Tua Aktif:</strong> Anda masuk sebagai <b>{{ Auth::user()->name }}</b>. Anda sedang melihat kurikulum belajar yang diakses ananda Doni.
                </div>
            </div>
            <div class="role-status-actions">
                <a href="{{ route('parent.index') }}" class="btn btn-primary btn-sm">
                    ⏱️ Buka Portal Orang Tua
                </a>
            </div>
        </div>
    @endif
@else
    <div class="role-status-banner role-status-guest">
        <div class="role-status-content">
            <span class="role-status-icon">🔒</span>
            <div>
                <strong>Perhatian:</strong> Untuk mengerjakan kuis harian, membuka modul belajar inti, dan arena gamifikasi, Anda <b>wajib masuk (login)</b> terlebih dahulu.
            </div>
        </div>
        <div class="role-status-actions">
            <a href="{{ route('login') }}" class="btn btn-primary btn-sm">
                🔐 Masuk Sekarang
            </a>
        </div>
    </div>
@endauth

<!-- Hero Banner -->
<section class="hero-banner">
    <div class="hero-content">
        <div class="hero-badge-tag">
            <span>🔥 Streak Belajar 7 Hari Aktif!</span>
        </div>
        <h1 class="hero-title">
            Belajar Jadi Petualangan Seru <span>Penuh Bintang!</span>
        </h1>
        <p class="hero-subtitle">
            Platform pembelajaran khusus siswa kelas 4, 5, dan 6 SDS Madani. Kuasai Matematika, IPA, IPS, Bahasa Indonesia, Bahasa Inggris, dan <b>Coding Dasar (Algoritma Robot & Logika Scratch)</b> dengan materi interaktif, kuis harian, dan mini game edukasi!
        </p>
        <div class="hero-cta-group">
            <a href="{{ route('learning.index') }}" class="btn btn-primary" id="btnMulaiBelajar">
                <span>📚 Mulai Belajar Sekarang</span>
            </a>
            <a href="{{ route('quiz.daily') }}" class="btn btn-accent" id="btnKuisHarian">
                <span>⚡ Tantangan Kuis Harian (10 Soal)</span>
            </a>
            <a href="{{ route('gamification.index') }}" class="btn btn-outline" id="btnAvatarGame">
                <span>🎮 Avatar & Mini Game</span>
            </a>
        </div>
    </div>

    <!-- Right Side Hero Card (Differentiated per Role) -->
    @auth
        @if(Auth::user()->isGuru())
            <!-- Teacher Quick Overview Card -->
            <div class="student-passport-card teacher-passport-card">
                <div class="passport-header">
                    <div class="passport-avatar" style="background: rgba(139, 92, 246, 0.25); border-color: rgba(139, 92, 246, 0.5);">👨‍🏫</div>
                    <div class="passport-info">
                        <h3>{{ Auth::user()->name }}</h3>
                        <p>Wali Kelas & Guru Pengajar 5-A</p>
                    </div>
                </div>

                <div class="level-progress-box" style="background: rgba(15, 23, 42, 0.7); border-color: rgba(139, 92, 246, 0.3);">
                    <div class="level-label">
                        <span style="color: #c4b5fd;">📊 Ringkasan Kelas 5-A</span>
                        <span style="color: #4ade80;">28 Siswa Aktif</span>
                    </div>
                    <div style="font-size: 0.85rem; color: #cbd5e1; margin-top: 0.3rem;">
                        Rerata Nilai: <strong style="color: #38bdf8;">86.4 / 100</strong> • Keaktifan: <strong style="color: #f97316;">91.8%</strong>
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 0.5rem; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 1rem;">
                    <a href="{{ route('teacher.index') }}" class="btn btn-primary btn-sm" style="width: 100%; justify-content: center;">
                        👨‍🏫 Masuk ke Dashboard Guru
                    </a>
                    <a href="{{ route('teacher.export') }}" class="btn btn-outline btn-sm" style="width: 100%; justify-content: center;">
                        📥 Unduh Rekap Nilai CSV
                    </a>
                </div>
            </div>
        @elseif(Auth::user()->isOrangTua())
            <!-- Parent Quick Overview Card -->
            <div class="student-passport-card parent-passport-card">
                <div class="passport-header">
                    <div class="passport-avatar" style="background: rgba(16, 185, 129, 0.25); border-color: rgba(16, 185, 129, 0.5);">👨‍👩‍👧</div>
                    <div class="passport-info">
                        <h3>{{ Auth::user()->name }}</h3>
                        <p>Orang Tua Doni Pratama (Kelas 5-A)</p>
                    </div>
                </div>

                <div class="level-progress-box" style="background: rgba(15, 23, 42, 0.7); border-color: rgba(16, 185, 129, 0.3);">
                    <div class="level-label">
                        <span style="color: #86efac;">⏱️ Waktu Layar Doni Hari Ini</span>
                        <span style="color: #38bdf8;">25 / 45 Menit</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" style="width: 55%; background: linear-gradient(90deg, #10b981, #f59e0b);"></div>
                    </div>
                    <span style="font-size: 0.75rem; color: #94a3b8;">Sisa <b>20 menit</b> waktu belajar layar hari ini.</span>
                </div>

                <div style="display: flex; flex-direction: column; gap: 0.5rem; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 1rem;">
                    <a href="{{ route('parent.index') }}" class="btn btn-primary btn-sm" style="width: 100%; justify-content: center;">
                        👨‍👩‍👧 Buka Portal Orang Tua
                    </a>
                    <a href="{{ route('parent.index') }}#screenTimeController" class="btn btn-outline btn-sm" style="width: 100%; justify-content: center;">
                        ⚙️ Atur Batas Waktu Layar
                    </a>
                </div>
            </div>
        @else
            <!-- Student Passport Card (Gamified Overview) -->
            <div class="student-passport-card">
                <div class="passport-header">
                    <div class="passport-avatar" id="passportAvatar">🚀</div>
                    <div class="passport-info">
                        <h3>{{ Auth::user()->name }}</h3>
                        <p>Siswa Kelas 5-A SDS Madani</p>
                    </div>
                </div>

                <div class="level-progress-box">
                    <div class="level-label">
                        <span style="color: #fbbf24;">⭐ Level 3: Ksatria Pintar</span>
                        <span style="color: #94a3b8;"><span id="currentXpText">850</span> / 1000 XP</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" id="xpProgressBar" style="width: 85%;"></div>
                    </div>
                    <span style="font-size: 0.75rem; color: #a5b4fc;">Sisa 150 XP lagi untuk naik ke <b>Level 4: Master Penjelajah</b>!</span>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 1rem;">
                    <div style="font-size: 0.85rem; color: var(--text-muted);">Lencana Terbaru:</div>
                    <div class="passport-badges-row">
                        <div class="mini-badge" title="Raja Kuis">🎯</div>
                        <div class="mini-badge" title="Streak 7 Hari">🔥</div>
                        <div class="mini-badge" title="Penyihir Angka">📐</div>
                        <div class="mini-badge" title="Bintang Malam">🌟</div>
                    </div>
                </div>

                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    <a href="{{ route('gamification.index') }}" class="btn btn-outline btn-sm" style="flex: 1; font-size: 0.8rem; justify-content: center;">
                        🎨 Ganti Avatar
                    </a>
                    <a href="{{ route('quiz.daily') }}" class="btn btn-primary btn-sm" style="flex: 1; font-size: 0.8rem; justify-content: center;">
                        +100 XP Kuis
                    </a>
                </div>
            </div>
        @endif
    @else
        <!-- Guest Role Showcase Card -->
        <div class="student-passport-card guest-passport-card">
            <div class="passport-header">
                <div class="passport-avatar" style="background: rgba(99, 102, 241, 0.25);">🎒</div>
                <div class="passport-info">
                    <h3>Pilih Peran Anda</h3>
                    <p>Akses Tampilan Khusus SDS Madani</p>
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 0.6rem; margin: 1rem 0;">
                <form action="{{ route('login.quick') }}" method="POST" style="margin: 0;">
                    @csrf
                    <input type="hidden" name="role" value="siswa">
                    <button type="submit" class="btn-role-quick-showcase role-siswa" style="width: 100%;">
                        <span style="font-size: 1.2rem;">🎒</span>
                        <div style="text-align: left;">
                            <div style="font-weight: 700; color: white;">Masuk Sebagai Siswa</div>
                            <div style="font-size: 0.75rem; color: #93c5fd;">Belajar interaktif, kuis harian & gamifikasi</div>
                        </div>
                    </button>
                </form>

                <form action="{{ route('login.quick') }}" method="POST" style="margin: 0;">
                    @csrf
                    <input type="hidden" name="role" value="guru">
                    <button type="submit" class="btn-role-quick-showcase role-guru" style="width: 100%;">
                        <span style="font-size: 1.2rem;">👨‍🏫</span>
                        <div style="text-align: left;">
                            <div style="font-weight: 700; color: white;">Masuk Sebagai Guru</div>
                            <div style="font-size: 0.75rem; color: #c4b5fd;">Statistik nilai, bank soal & rekap CSV</div>
                        </div>
                    </button>
                </form>

                <form action="{{ route('login.quick') }}" method="POST" style="margin: 0;">
                    @csrf
                    <input type="hidden" name="role" value="orang_tua">
                    <button type="submit" class="btn-role-quick-showcase role-orang_tua" style="width: 100%;">
                        <span style="font-size: 1.2rem;">👨‍👩‍👧</span>
                        <div style="text-align: left;">
                            <div style="font-weight: 700; color: white;">Masuk Sebagai Orang Tua</div>
                            <div style="font-size: 0.75rem; color: #86efac;">Batas waktu layar & progres nilai ananda</div>
                        </div>
                    </button>
                </form>
            </div>

            <a href="{{ route('login') }}" class="btn btn-outline btn-sm" style="width: 100%; justify-content: center; font-size: 0.8rem;">
                🔐 Masuk dengan Email & Sandi →
            </a>
        </div>
    @endauth
</section>

<!-- 6 Mata Pelajaran Unggulan Termasuk Coding Dasar & Informatika Anak -->
<section class="subjects-section">
    <div class="section-header">
        <div>
            <h2 class="section-title">
                <span>💻</span> 6 Mata Pelajaran Unggulan Termasuk Coding
            </h2>
            <p class="section-subtitle">
                Materi disajikan ringkas, bergambar, animasi interaktif 3 menit, logika algoritma, dan latihan soal bertingkat!
            </p>
        </div>
        <a href="{{ route('learning.index') }}" class="btn btn-outline btn-sm">Lihat Semua Modul →</a>
    </div>

    <div class="subjects-grid">
        @foreach($subjects as $subj)
        <a href="{{ route('learning.subject', $subj['id']) }}" class="subject-card" id="cardSubject-{{ $subj['id'] }}">
            <div class="subject-card-header">
                <div class="subject-icon-box" style="background: {{ $subj['bg_gradient'] }};">
                    {{ $subj['icon'] }}
                </div>
                <span class="subject-tag">{{ $subj['class'] }}</span>
            </div>

            <div>
                <h3 class="subject-name">{{ $subj['name'] }}</h3>
                <p class="subject-desc">{{ $subj['summary'] }}</p>
            </div>

            <div class="subject-card-footer">
                <div class="subject-progress-label">
                    <span>Progres Belajar</span>
                    <span style="color: #38bdf8;">{{ $subj['completed_topics'] }}/{{ $subj['total_topics'] }} Topik ({{ $subj['progress'] }}%)</span>
                </div>
                <div class="progress-track" style="height: 8px;">
                    <div class="progress-fill" style="width: {{ $subj['progress'] }}%; background: {{ $subj['color'] }};"></div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</section>

<!-- Quick Action Highlights for Students, Teachers & Parents -->
<section class="highlights-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-top: 1rem;">
    <!-- Card 1: Kuis Harian -->
    <div class="glass-panel" style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.15), rgba(15, 23, 42, 0.8)); border-color: rgba(239, 68, 68, 0.3);">
        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">⚡</div>
        <h3 style="font-family: var(--font-heading); font-size: 1.3rem; margin-bottom: 0.5rem; color: #fca5a5;">Kuis Rutin Harian</h3>
        <p style="color: #cbd5e1; font-size: 0.9rem; margin-bottom: 1.2rem;">
            10 soal cepat untuk melatih ingatan harian. Jawab benar semua untuk dapat bonus <b>+100 XP</b> dan pertahankan streak apimu!
        </p>
        <a href="{{ route('quiz.daily') }}" class="btn btn-accent btn-sm">Mulai Kuis Sekarang →</a>
    </div>

    <!-- Card 2: Mini Game Edukasi -->
    <div class="glass-panel" style="background: linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(15, 23, 42, 0.8)); border-color: rgba(99, 102, 241, 0.3);">
        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">🎮</div>
        <h3 style="font-family: var(--font-heading); font-size: 1.3rem; margin-bottom: 0.5rem; color: #a5b4fc;">Arena Mini Game</h3>
        <p style="color: #cbd5e1; font-size: 0.9rem; margin-bottom: 1.2rem;">
            Mainkan Math Speed Run, Cocok Kartu Memori Sains, dan Tebak Gambar Misteri sambil mengumpulkan koin avatar!
        </p>
        <a href="{{ route('gamification.index') }}" class="btn btn-primary btn-sm">Buka Mini Games →</a>
    </div>

    <!-- Card 3: Dashboard Guru & Orang Tua -->
    <div class="glass-panel" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(15, 23, 42, 0.8)); border-color: rgba(16, 185, 129, 0.3);">
        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">👨‍🏫</div>
        <h3 style="font-family: var(--font-heading); font-size: 1.3rem; margin-bottom: 0.5rem; color: #6ee7b7;">Portal Guru & Orang Tua</h3>
        <p style="color: #cbd5e1; font-size: 0.9rem; margin-bottom: 1.2rem;">
            Analisis otomatis topik tersulit bagi siswa kelas 5A, grafik radar perkembangan anak, serta pembatas waktu layar (screen time).
        </p>
        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
            <a href="{{ route('teacher.index') }}" class="btn btn-outline btn-sm">Portal Guru</a>
            <a href="{{ route('parent.index') }}" class="btn btn-outline btn-sm">Orang Tua</a>
        </div>
    </div>
</section>
@endsection
