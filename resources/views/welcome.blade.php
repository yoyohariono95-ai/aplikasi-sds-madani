@extends('layouts.app')

@section('title', 'SDS Madani E-Learning | Belajar Seru Kelas 4-6 SD')

@section('content')
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
            Platform pembelajaran khusus siswa kelas 4, 5, dan 6 SDS Madani. Kuasai Matematika, IPA, IPS, Bahasa Indonesia, dan Bahasa Inggris dengan materi interaktif, kuis harian berhadiah XP, dan mini game edukasi!
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

    <!-- Student Passport Card (Gamified Overview) -->
    <div class="student-passport-card">
        <div class="passport-header">
            <div class="passport-avatar" id="passportAvatar">🚀</div>
            <div class="passport-info">
                <h3>Doni Pratama</h3>
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

        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ route('gamification.index') }}" class="btn btn-outline btn-sm" style="flex: 1; font-size: 0.8rem;">
                🎨 Ganti Avatar
            </a>
            <a href="{{ route('quiz.daily') }}" class="btn btn-primary btn-sm" style="flex: 1; font-size: 0.8rem;">
                +100 XP Kuis
            </a>
        </div>
    </div>
</section>

<!-- 5 Mata Pelajaran Inti (Matematika, IPA, IPS, Bahasa Indonesia, Bahasa Inggris) -->
<section class="subjects-section">
    <div class="section-header">
        <div>
            <h2 class="section-title">
                <span>📖</span> 5 Mata Pelajaran Inti
            </h2>
            <p class="section-subtitle">
                Materi disajikan ringkas, bergambar, dengan video infografis 3 menit dan latihan soal bergradasi!
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
<section class="highlights-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-top: 1rem;">
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
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ route('teacher.index') }}" class="btn btn-outline btn-sm">Portal Guru</a>
            <a href="{{ route('parent.index') }}" class="btn btn-outline btn-sm">Orang Tua</a>
        </div>
    </div>
</section>
@endsection
