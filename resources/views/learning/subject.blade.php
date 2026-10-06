@extends('layouts.app')

@section('title', $subject['name'] . ' | SDS Madani SD Kelas 4-6')

@section('content')
@php
    $selectedTopicId = request('topic');
    $currentTopic = collect($subject['topics'])->firstWhere('id', $selectedTopicId) ?: $subject['topics'][0];
    $exercises = $currentTopic['exercises'] ?? $currentTopic['questions'] ?? [];
    $embedUrl = $currentTopic['embed_url'] ?? \App\Models\Topic::parseYoutubeUrl($currentTopic['video_url'] ?? null);
@endphp

@if(session('success'))
<div style="background: rgba(16, 185, 129, 0.2); border: 1px solid #10b981; color: #a7f3d0; padding: 0.9rem 1.25rem; border-radius: 14px; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between; gap: 0.8rem; animation: fadeIn 0.3s ease;">
    <div style="display: flex; align-items: center; gap: 0.75rem;">
        <span style="font-size: 1.4rem;">🎉</span>
        <span style="font-size: 0.95rem; font-weight: 600;">{{ session('success') }}</span>
    </div>
    <button onclick="this.parentElement.remove()" style="background: transparent; border: none; color: #a7f3d0; cursor: pointer; font-size: 1.2rem; line-height: 1;">✕</button>
</div>
@endif

@if(session('error'))
<div style="background: rgba(239, 68, 68, 0.2); border: 1px solid #ef4444; color: #fca5a5; padding: 0.9rem 1.25rem; border-radius: 14px; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between; gap: 0.8rem; animation: fadeIn 0.3s ease;">
    <div style="display: flex; align-items: center; gap: 0.75rem;">
        <span style="font-size: 1.4rem;">⚠️</span>
        <span style="font-size: 0.95rem; font-weight: 600;">{{ session('error') }}</span>
    </div>
    <button onclick="this.parentElement.remove()" style="background: transparent; border: none; color: #fca5a5; cursor: pointer; font-size: 1.2rem; line-height: 1;">✕</button>
</div>
@endif

<div style="margin-bottom: 1.5rem;">
    <a href="{{ route('learning.index') }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 0.4rem; margin-bottom: 0.8rem;">
        ← Kembali ke Semua Mata Pelajaran
    </a>
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div class="subject-icon-box" style="background: {{ $subject['bg_gradient'] }}; width: 56px; height: 56px; font-size: 2rem;">
                {{ $subject['icon'] }}
            </div>
            <div>
                <h1 style="font-family: var(--font-heading); font-size: 2rem; color: white;">
                    {{ $subject['name'] }}
                </h1>
                <p style="color: var(--text-muted); font-size: 0.95rem;">
                    Topik: <strong style="color: white;">{{ $currentTopic['title'] }}</strong> • Estimasi: <span style="color: #38bdf8;">{{ $currentTopic['duration'] }}</span>
                    @if(!empty($currentTopic['video_url']))
                    <span style="display: inline-flex; align-items: center; gap: 0.3rem; margin-left: 0.5rem; color: #f87171; font-weight: 700; font-size: 0.8rem; background: rgba(239,68,68,0.15); padding: 0.1rem 0.5rem; border-radius: 6px;">
                        ▶ Video YouTube
                    </span>
                    @endif
                </p>
            </div>
        </div>

        <div style="display: flex; gap: 0.8rem; align-items: center; flex-wrap: wrap;">
            @if(Auth::check() && Auth::user()->isGuru())
                <button class="btn btn-primary btn-sm" onclick="openTambahMateriModal()" style="background: linear-gradient(135deg, #8b5cf6, #6366f1); border: none; box-shadow: 0 4px 15px rgba(99,102,241,0.4); font-weight: 700;">
                    ➕ Tambah Materi / Modul Baru
                </button>
                <button class="btn btn-outline btn-sm" onclick="openEditVideoModal()" style="border-color: rgba(139,92,246,0.5); color: #c4b5fd;">
                    🎬 Atur Video YouTube
                </button>
            @else
                <span style="font-size: 0.85rem; color: #fbbf24; font-weight: 700;">🎁 Hadiah Selesai: +50 XP</span>
                <button class="btn btn-outline btn-sm" onclick="soundFX.playCoin(); GameState.addCoins(10); alert('🪙 Bonus 10 Koin diperoleh karena rajin membuka modul!');">
                    🪙 Ambil Koin Harian
                </button>
            @endif
        </div>
    </div>
</div>

<div class="topic-viewer-layout">
    <!-- Left Column: Bite-sized Microlearning & Video/Infografis -->
    <div>
        <!-- 1. Video Pembelajaran Interaktif (YouTube Embed / Mock Player) -->
        <div class="video-player-card" style="margin-bottom: 1.75rem;">
            @if(!empty($embedUrl))
                <!-- Real YouTube Responsive Embed Player -->
                <div class="video-embed-wrapper" id="videoEmbedWrapper">
                    <iframe id="youtubeIframePlayer" src="{{ $embedUrl }}" title="{{ $currentTopic['video_title'] ?? 'Video Pembelajaran' }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>
                <div class="video-caption-bar" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.8rem; margin-top: 0.75rem; padding: 0.85rem 1.1rem; background: rgba(15,23,42,0.65); border-radius: 14px; border: 1px solid rgba(255,255,255,0.06);">
                    <div style="flex: 1; min-width: 260px;">
                        <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                            <span style="background: #ef4444; color: white; font-size: 0.72rem; font-weight: 800; padding: 0.15rem 0.5rem; border-radius: 6px; letter-spacing: 0.5px;">
                                ▶ YOUTUBE
                            </span>
                            <span style="font-weight: 700; color: white; font-size: 0.95rem;">
                                {{ $currentTopic['video_title'] }}
                            </span>
                        </div>
                        <p style="color: var(--text-muted); font-size: 0.82rem; margin: 0.3rem 0 0 0; line-height: 1.4;">
                            {{ $currentTopic['video_desc'] }}
                        </p>
                    </div>
                    <div style="display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap;">
                        @if(!empty($currentTopic['video_url']))
                        <a href="{{ $currentTopic['video_url'] }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline btn-sm" style="font-size: 0.78rem;">
                            Buka di YouTube ↗
                        </a>
                        @endif
                        @if(Auth::check() && Auth::user()->isGuru())
                        <button class="btn btn-sm" onclick="openEditVideoModal()" style="font-size: 0.78rem; background: rgba(139,92,246,0.3); border: 1px solid #8b5cf6; color: #e9d5ff;">
                            ✏️ Ganti Video
                        </button>
                        @endif
                    </div>
                </div>
            @else
                <!-- Fallback Mock / Placeholder Card -->
                <div class="video-screen-mock" id="videoScreenMock">
                    <div class="play-btn-circle" id="playBtnMock" onclick="toggleMockVideo()">▶</div>
                    <h3 style="font-family: var(--font-heading); font-size: 1.25rem; color: white; margin-bottom: 0.4rem;" id="videoMockTitle">
                        🎬 {{ $currentTopic['video_title'] ?? 'Animasi Pembelajaran' }}
                    </h3>
                    <p style="color: #cbd5e1; font-size: 0.85rem; max-width: 480px;" id="videoMockDesc">
                        {{ $currentTopic['video_desc'] ?? 'Pahami konsep materi ini melalui simulasi dan penjelasan langkah-demi-langkah.' }}
                    </p>
                    <div class="video-duration-pill">⏱️ {{ $currentTopic['duration'] ?? '3 Menit' }}</div>

                    <div id="videoPlayingStatus" style="display: none; margin-top: 0.8rem; background: rgba(34,197,94,0.2); border: 1px solid #22c55e; color: #86efac; padding: 0.3rem 0.8rem; border-radius: 8px; font-size: 0.8rem;">
                        🟢 Simulasi konsep sedang berjalan... Pahami visualnya dengan santai!
                    </div>
                </div>
                <div class="video-caption-bar" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
                    <span style="font-size: 0.85rem; color: var(--text-muted);">
                        💡 <em>Tip: Guru dapat menambahkan link video YouTube asli pada materi ini kapan saja.</em>
                    </span>
                    @if(Auth::check() && Auth::user()->isGuru())
                    <button class="btn btn-primary btn-sm" onclick="openEditVideoModal()" style="font-size: 0.8rem; background: linear-gradient(135deg, #8b5cf6, #6366f1); border: none;">
                        ➕ Tambah Link Video YouTube
                    </button>
                    @else
                    <button class="btn btn-outline btn-sm" style="font-size: 0.75rem;" onclick="toggleMockVideo()">
                        Putar Ulang Simulasi ↻
                    </button>
                    @endif
                </div>
            @endif
        </div>

        <!-- 2. Micro-Learning Explanations (Bite-sized, Chunked) -->
        <div class="micro-learning-container">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                <h3 style="font-family: var(--font-heading); font-size: 1.3rem; color: white; display: flex; align-items: center; gap: 0.5rem;">
                    <span>🧩</span> Penjelasan Inti (Bite-Sized)
                </h3>
                <span style="font-size: 0.8rem; background: rgba(99,102,241,0.2); color: #c7d2fe; padding: 0.2rem 0.6rem; border-radius: 6px;">
                    {{ count($currentTopic['micro_steps'] ?? []) }} Langkah Mudah
                </span>
            </div>

            @foreach($currentTopic['micro_steps'] ?? [] as $idx => $step)
            <div class="micro-step-card">
                <div class="micro-step-number">{{ $idx + 1 }}</div>
                <div class="micro-step-content">
                    <h4>{{ $step['title'] }}</h4>
                    <p>{!! $step['content'] !!}</p>
                    @if(!empty($step['highlight']))
                    <div class="micro-highlight-pill">
                        ✨ {{ $step['highlight'] }}
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- 3. Latihan Soal Bertingkat: Mudah (★☆☆) -> Sedang (★★☆) -> Sulit (★★★) -->
        @if(!empty($exercises))
        <div class="exercises-section">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 0.5rem;">
                <h3 style="font-family: var(--font-heading); font-size: 1.3rem; color: white; display: flex; align-items: center; gap: 0.5rem;">
                    <span>🎯</span> Latihan Soal Bertingkat & Pembahasan Langsung
                </h3>
                <span style="font-size: 0.85rem; color: var(--text-muted);">Langsung ketahui penjelasan saat menjawab</span>
            </div>

            <!-- Level Selector Tabs -->
            <div class="exercise-level-tab">
                @foreach($exercises as $eIdx => $ex)
                <button class="level-btn {{ $eIdx === 0 ? 'active' : '' }}" onclick="switchExerciseTab({{ $eIdx }})" id="levelBtn-{{ $eIdx }}">
                    Tingkat {{ $ex['level'] }} ({{ $ex['stars'] }})
                </button>
                @endforeach
            </div>

            <!-- Questions Containers -->
            @foreach($exercises as $eIdx => $ex)
            <div class="exercise-question-box" id="exerciseBox-{{ $eIdx }}" style="{{ $eIdx === 0 ? '' : 'display: none;' }}">
                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                    <span style="font-size: 0.85rem; color: #fbbf24; font-weight: 700;">
                        Tingkat: {{ $ex['level'] }} {{ $ex['stars'] }}
                    </span>
                    <span style="font-size: 0.85rem; color: var(--text-muted);">
                        Poin: <b>+{{ ($eIdx + 1) * 20 }} XP</b>
                    </span>
                </div>

                <div class="question-text" id="qText-{{ $eIdx }}">
                    {{ $ex['question'] }}
                </div>

                <div class="options-list" id="optionsList-{{ $eIdx }}">
                    @php $labels = ['A', 'B', 'C', 'D']; @endphp
                    @foreach($ex['options'] as $oIdx => $opt)
                    <button class="option-btn" 
                            id="optBtn-{{ $eIdx }}-{{ $oIdx }}" 
                            onclick="selectOption({{ $eIdx }}, {{ $oIdx }}, {{ $ex['answer'] }}, '{{ addslashes($ex['explanation']) }}')">
                        <span class="option-label">{{ $labels[$oIdx] }}</span>
                        <span>{{ $opt }}</span>
                    </button>
                    @endforeach
                </div>

                <!-- Pembahasan Langsung Card (Hidden by default, shown upon answer) -->
                <div class="explanation-card" id="explanationBox-{{ $eIdx }}">
                    <div style="display: flex; align-items: center; gap: 0.6rem; font-weight: 700; margin-bottom: 0.4rem;" id="explTitle-{{ $eIdx }}">
                        <!-- Injected via JS -->
                    </div>
                    <p style="font-size: 0.95rem; line-height: 1.5;" id="explText-{{ $eIdx }}"></p>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <!-- Right Sidebar Column: Navigation & Progress -->
    <div>
        <div class="glass-panel" style="margin-bottom: 1.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <h4 style="font-family: var(--font-heading); font-size: 1.15rem; color: white; margin: 0;">
                    📌 Modul di {{ $subject['name'] }}
                </h4>
                @if(Auth::check() && Auth::user()->isGuru())
                <button class="btn btn-outline btn-sm" onclick="openTambahMateriModal()" style="font-size: 0.75rem; padding: 0.25rem 0.6rem; border-color: rgba(139,92,246,0.5); color: #c4b5fd;">
                    + Tambah
                </button>
                @endif
            </div>

            <div style="display: flex; flex-direction: column; gap: 0.8rem;">
                @foreach($subject['topics'] as $t)
                <a href="{{ route('learning.subject', ['id' => $subject['id'], 'topic' => $t['id']]) }}" style="text-decoration: none; padding: 0.9rem; border-radius: 14px; background: {{ $currentTopic['id'] === $t['id'] ? 'rgba(99,102,241,0.25)' : 'rgba(15,23,42,0.8)' }}; border: 1px solid {{ $currentTopic['id'] === $t['id'] ? 'var(--primary-light)' : 'rgba(255,255,255,0.1)' }}; display: flex; justify-content: space-between; align-items: center; transition: all 0.2s ease;">
                    <div style="flex: 1; padding-right: 0.5rem;">
                        <div style="font-weight: 600; color: white; font-size: 0.9rem;">{{ $t['title'] }}</div>
                        <div style="font-size: 0.75rem; color: var(--text-muted); display: flex; align-items: center; gap: 0.4rem; margin-top: 0.2rem;">
                            <span>{{ $t['duration'] }}</span> • <span>{{ $t['difficulty'] }}</span>
                            @if(!empty($t['video_url']))
                            <span style="color: #f87171; font-weight: 700;">• 🎬 Video</span>
                            @endif
                        </div>
                    </div>
                    <span style="font-size: 1.2rem;">{{ $currentTopic['id'] === $t['id'] ? '▶' : '📖' }}</span>
                </a>
                @endforeach
            </div>

            @if(Auth::check() && Auth::user()->isGuru())
            <div style="margin-top: 1rem; padding-top: 0.9rem; border-top: 1px dashed rgba(255,255,255,0.15);">
                <button class="btn btn-outline btn-sm" onclick="openTambahMateriModal()" style="width: 100%; justify-content: center; gap: 0.4rem; font-size: 0.82rem; border-color: rgba(139,92,246,0.4); color: #c4b5fd;">
                    ➕ Tambah Materi Baru di Sini
                </button>
            </div>
            @endif
        </div>

        <div class="glass-panel" style="background: linear-gradient(135deg, rgba(249,115,22,0.15), rgba(15,23,42,0.8)); border-color: rgba(249,115,22,0.3);">
            <div style="display: flex; align-items: center; gap: 0.6rem; margin-bottom: 0.8rem;">
                <span style="font-size: 1.8rem;">🔥</span>
                <div>
                    <div style="font-weight: 700; color: #fed7aa; font-size: 1rem;">Streak Belajar Siswa</div>
                    <div style="font-size: 0.8rem; color: #fdba74;">7 Hari Berturut-turut!</div>
                </div>
            </div>
            <p style="font-size: 0.85rem; color: #fed7aa; margin-bottom: 1rem; line-height: 1.5;">
                Hebat! Selesaikan 1 latihan soal hari ini agar apimu tidak padam dan bonus XP tetap mengalir!
            </p>
            <a href="{{ route('quiz.daily') }}" class="btn btn-accent btn-sm" style="width: 100%; justify-content: center;">
                Kuis Harian 10 Soal →
            </a>
        </div>
    </div>
</div>

<!-- =======================================================
     MODAL GURU: TAMBAH MATERI YANG AKAN DIAJAR
     ======================================================= -->
@if(Auth::check() && Auth::user()->isGuru())
<div class="modal-overlay" id="modalTambahMateri">
    <div class="modal-card">
        <div class="modal-header">
            <h3 class="modal-title">
                <span>📚</span> Tambah Materi Pelajaran yang Akan Diajar
            </h3>
            <button type="button" class="btn-modal-close" onclick="closeTambahMateriModal()">✕</button>
        </div>
        <form action="{{ route('guru.topic.store') }}" method="POST" id="formTambahMateri">
            @csrf
            <div class="modal-body">
                <div style="background: rgba(99,102,241,0.12); border: 1px solid rgba(99,102,241,0.3); border-radius: 12px; padding: 0.8rem 1rem; margin-bottom: 1.25rem; font-size: 0.85rem; color: #c7d2fe;">
                    💡 <strong>Halo Guru Hebat!</strong> Tambahkan topik baru yang akan diajarkan ke siswa, lengkapi dengan link video pembelajaran YouTube, ringkasan konsep, dan latihan soal.
                </div>

                <!-- 1. Mata Pelajaran & Judul Materi -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.4rem;">
                            Mata Pelajaran: <span style="color: #ef4444;">*</span>
                        </label>
                        <select name="subject_id" style="width: 100%; padding: 0.7rem; border-radius: 12px; background: #0f172a; border: 1px solid var(--border-glass); color: white;" required>
                            @foreach($allSubjects as $s)
                            <option value="{{ $s->id }}" {{ $s->id === $subject['id'] ? 'selected' : '' }}>
                                {{ $s->icon ?? '📖' }} {{ $s->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.4rem;">
                            Tingkat Kesulitan:
                        </label>
                        <select name="difficulty" style="width: 100%; padding: 0.7rem; border-radius: 12px; background: #0f172a; border: 1px solid var(--border-glass); color: white;">
                            <option value="Mudah">Mudah</option>
                            <option value="Sedang" selected>Sedang</option>
                            <option value="Sulit">Sulit</option>
                        </select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1rem; margin-bottom: 1.25rem;">
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.4rem;">
                            Judul Materi yang Akan Diajar: <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="text" name="title" placeholder="Contoh: Operasi Hitung Campuran Pecahan" style="width: 100%; padding: 0.7rem; border-radius: 12px; background: #0f172a; border: 1px solid var(--border-glass); color: white;" required>
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.4rem;">
                            Estimasi Durasi:
                        </label>
                        <input type="text" name="duration" value="4 Menit" placeholder="Contoh: 4 Menit" style="width: 100%; padding: 0.7rem; border-radius: 12px; background: #0f172a; border: 1px solid var(--border-glass); color: white;">
                    </div>
                </div>

                <!-- 2. Bagian Video YouTube -->
                <div style="background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.25); border-radius: 16px; padding: 1.1rem; margin-bottom: 1.25rem;">
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.8rem;">
                        <span style="font-size: 1.2rem;">🎬</span>
                        <h4 style="color: white; font-size: 0.95rem; margin: 0; font-weight: 700;">
                            Integrasi Video YouTube
                        </h4>
                    </div>

                    <div style="margin-bottom: 0.8rem;">
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #fca5a5; margin-bottom: 0.4rem;">
                            Link / URL Video YouTube:
                        </label>
                        <input type="url" name="video_url" id="inputYoutubeUrl" placeholder="https://www.youtube.com/watch?v=... atau https://youtu.be/..." style="width: 100%; padding: 0.7rem; border-radius: 12px; background: #0f172a; border: 1px solid rgba(239,68,68,0.3); color: white;" oninput="previewYoutubeUrl(this.value)">
                        <span style="font-size: 0.75rem; color: var(--text-dim); margin-top: 0.3rem; display: block;">
                            Mendukung format link YouTube biasa, shorts, youtu.be, atau ID video. Video akan otomatis disematkan (embed) secara rapi untuk siswa.
                        </span>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.8rem;">
                        <div>
                            <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.3rem;">
                                Judul Video:
                            </label>
                            <input type="text" name="video_title" placeholder="Contoh: Video Animasi Penjelasan Konsep" style="width: 100%; padding: 0.6rem; border-radius: 10px; background: #0f172a; border: 1px solid var(--border-glass); color: white;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.3rem;">
                                Ringkasan Singkat Video:
                            </label>
                            <input type="text" name="video_desc" placeholder="Contoh: Simak contoh soal dan visualisasi di video ini" style="width: 100%; padding: 0.6rem; border-radius: 10px; background: #0f172a; border: 1px solid var(--border-glass); color: white;">
                        </div>
                    </div>
                </div>

                <!-- 3. Bagian Langkah Belajar Inti (Bite-Sized) -->
                <div style="margin-bottom: 1.25rem;">
                    <h4 style="color: white; font-size: 0.95rem; margin-bottom: 0.6rem; font-weight: 700; display: flex; align-items: center; gap: 0.4rem;">
                        <span>🧩</span> Langkah Pembelajaran Inti (Bite-Sized Microlearning)
                    </h4>
                    
                    <!-- Step 1 -->
                    <div class="step-input-card">
                        <div class="step-input-card-title">🔹 Langkah 1: Pengenalan Konsep</div>
                        <input type="text" name="step_title[]" value="Konsep Dasar" placeholder="Judul Langkah 1 (contoh: Apa itu Pecahan Campuran?)" style="width: 100%; padding: 0.6rem; border-radius: 8px; background: #0f172a; border: 1px solid var(--border-glass); color: white; margin-bottom: 0.5rem;" required>
                        <textarea name="step_content[]" rows="2" placeholder="Uraian materi inti langkah 1..." style="width: 100%; padding: 0.6rem; border-radius: 8px; background: #0f172a; border: 1px solid var(--border-glass); color: white; margin-bottom: 0.5rem;" required>Pahami konsep materi ini melalui penjelasan singkat dan contoh nyata sehari-hari.</textarea>
                        <input type="text" name="step_highlight[]" value="Poin Kunci: Pahami definisi utama sebelum masuk ke rumus." placeholder="Highlight / Poin Kunci" style="width: 100%; padding: 0.5rem; border-radius: 8px; background: #0f172a; border: 1px solid var(--border-glass); color: #fde047; font-size: 0.8rem;">
                    </div>

                    <!-- Step 2 -->
                    <div class="step-input-card">
                        <div class="step-input-card-title">🔹 Langkah 2: Cara Pengerjaan / Rumus</div>
                        <input type="text" name="step_title[]" value="Langkah & Metode Pengerjaan" placeholder="Judul Langkah 2" style="width: 100%; padding: 0.6rem; border-radius: 8px; background: #0f172a; border: 1px solid var(--border-glass); color: white; margin-bottom: 0.5rem;">
                        <textarea name="step_content[]" rows="2" placeholder="Uraian metode / rumus langkah demi langkah..." style="width: 100%; padding: 0.6rem; border-radius: 8px; background: #0f172a; border: 1px solid var(--border-glass); color: white; margin-bottom: 0.5rem;">Ikuti urutan langkah penyelesaian secara runtut dan teliti.</textarea>
                        <input type="text" name="step_highlight[]" value="Trik Cepat: Periksa kembali hasil akhirmu sebelum lanjut." placeholder="Highlight / Poin Kunci" style="width: 100%; padding: 0.5rem; border-radius: 8px; background: #0f172a; border: 1px solid var(--border-glass); color: #fde047; font-size: 0.8rem;">
                    </div>

                    <!-- Step 3 -->
                    <div class="step-input-card">
                        <div class="step-input-card-title">🔹 Langkah 3: Contoh & Kesimpulan</div>
                        <input type="text" name="step_title[]" value="Contoh Soal & Kesimpulan" placeholder="Judul Langkah 3" style="width: 100%; padding: 0.6rem; border-radius: 8px; background: #0f172a; border: 1px solid var(--border-glass); color: white; margin-bottom: 0.5rem;">
                        <textarea name="step_content[]" rows="2" placeholder="Contoh soal dan ringkasan..." style="width: 100%; padding: 0.6rem; border-radius: 8px; background: #0f172a; border: 1px solid var(--border-glass); color: white; margin-bottom: 0.5rem;">Gunakan contoh kasus di atas sebagai panduan ketika mencoba kuis.</textarea>
                        <input type="text" name="step_highlight[]" value="Ingat: Latihan rutin membuatmu semakin percaya diri!" placeholder="Highlight / Poin Kunci" style="width: 100%; padding: 0.5rem; border-radius: 8px; background: #0f172a; border: 1px solid var(--border-glass); color: #fde047; font-size: 0.8rem;">
                    </div>
                </div>

                <!-- 4. Latihan Soal Langsung (Opsional) -->
                <div style="background: rgba(30,41,59,0.5); border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; padding: 1.1rem;">
                    <h4 style="color: white; font-size: 0.95rem; margin-bottom: 0.6rem; font-weight: 700; display: flex; align-items: center; gap: 0.4rem;">
                        <span>🎯</span> Tambahkan 1 Soal Latihan Mandiri (Opsional)
                    </h4>
                    <div style="margin-bottom: 0.6rem;">
                        <input type="text" name="exercise_question" placeholder="Pertanyaan untuk siswa (contoh: Berapakah hasil dari 2/3 x 3/4?)" style="width: 100%; padding: 0.6rem; border-radius: 8px; background: #0f172a; border: 1px solid var(--border-glass); color: white;">
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; margin-bottom: 0.6rem;">
                        <input type="text" name="exercise_opt_a" placeholder="Pilihan A" style="padding: 0.5rem; border-radius: 8px; background: #0f172a; border: 1px solid var(--border-glass); color: white;">
                        <input type="text" name="exercise_opt_b" placeholder="Pilihan B" style="padding: 0.5rem; border-radius: 8px; background: #0f172a; border: 1px solid var(--border-glass); color: white;">
                        <input type="text" name="exercise_opt_c" placeholder="Pilihan C" style="padding: 0.5rem; border-radius: 8px; background: #0f172a; border: 1px solid var(--border-glass); color: white;">
                        <input type="text" name="exercise_opt_d" placeholder="Pilihan D" style="padding: 0.5rem; border-radius: 8px; background: #0f172a; border: 1px solid var(--border-glass); color: white;">
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 0.8rem;">
                        <div>
                            <select name="exercise_answer" style="width: 100%; padding: 0.55rem; border-radius: 8px; background: #0f172a; border: 1px solid var(--border-glass); color: white;">
                                <option value="0">Kunci: Pilihan A</option>
                                <option value="1">Kunci: Pilihan B</option>
                                <option value="2">Kunci: Pilihan C</option>
                                <option value="3">Kunci: Pilihan D</option>
                            </select>
                        </div>
                        <div>
                            <input type="text" name="exercise_explanation" placeholder="Penjelasan / Pembahasan singkat saat dijawab" style="width: 100%; padding: 0.55rem; border-radius: 8px; background: #0f172a; border: 1px solid var(--border-glass); color: white;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline btn-sm" onclick="closeTambahMateriModal()">Batal</button>
                <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #8b5cf6, #6366f1); border: none; font-weight: 700;">
                    Simpan & Terbitkan Materi 🚀
                </button>
            </div>
        </form>
    </div>
</div>

<!-- =======================================================
     MODAL GURU: ATUR / GANTI LINK VIDEO YOUTUBE
     ======================================================= -->
<div class="modal-overlay" id="modalEditVideo">
    <div class="modal-card" style="max-width: 540px;">
        <div class="modal-header">
            <h3 class="modal-title">
                <span>🎬</span> Atur Video YouTube Materi Ini
            </h3>
            <button type="button" class="btn-modal-close" onclick="closeEditVideoModal()">✕</button>
        </div>
        <form action="{{ route('guru.topic.update-video') }}" method="POST">
            @csrf
            <input type="hidden" name="topic_id" value="{{ $currentTopic['id'] }}">
            <div class="modal-body">
                <p style="font-size: 0.88rem; color: #cbd5e1; margin-bottom: 1rem;">
                    Materi: <strong style="color: white;">{{ $currentTopic['title'] }}</strong>
                </p>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #fca5a5; margin-bottom: 0.4rem;">
                        Link / URL Video YouTube: <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="url" name="video_url" value="{{ $currentTopic['video_url'] ?? '' }}" placeholder="https://www.youtube.com/watch?v=... atau https://youtu.be/..." style="width: 100%; padding: 0.75rem; border-radius: 12px; background: #0f172a; border: 1px solid rgba(239,68,68,0.4); color: white;" required>
                    <span style="font-size: 0.75rem; color: var(--text-dim); margin-top: 0.3rem; display: block;">
                        Salin dan tempel link YouTube (bisa dari laptop atau HP). Siswa dapat langsung menonton videonya di aplikasi.
                    </span>
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.4rem;">
                        Judul Video:
                    </label>
                    <input type="text" name="video_title" value="{{ $currentTopic['video_title'] ?? '' }}" placeholder="Contoh: Video Penjelasan Animasi" style="width: 100%; padding: 0.7rem; border-radius: 12px; background: #0f172a; border: 1px solid var(--border-glass); color: white;">
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.4rem;">
                        Deskripsi / Petunjuk Guru:
                    </label>
                    <textarea name="video_desc" rows="3" placeholder="Pesan untuk siswa sebelum menonton video..." style="width: 100%; padding: 0.7rem; border-radius: 12px; background: #0f172a; border: 1px solid var(--border-glass); color: white; resize: vertical;">{{ $currentTopic['video_desc'] ?? '' }}</textarea>
                </div>
            </div>
            <div class="modal-footer" style="justify-content: space-between;">
                <div>
                    <!-- Optional delete button if not initial core topic -->
                    <button type="button" class="btn btn-sm" style="background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3); color: #fca5a5;" onclick="confirmDeleteTopic('{{ $currentTopic['id'] }}')">
                        🗑️ Hapus Materi
                    </button>
                </div>
                <div style="display: flex; gap: 0.5rem;">
                    <button type="button" class="btn btn-outline btn-sm" onclick="closeEditVideoModal()">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm" style="background: linear-gradient(135deg, #ef4444, #dc2626); border: none; font-weight: 700;">
                        Simpan Video 💾
                    </button>
                </div>
            </div>
        </form>

        <form id="deleteTopicForm" action="{{ route('guru.topic.delete') }}" method="POST" style="display: none;">
            @csrf
            <input type="hidden" name="topic_id" id="deleteTopicId">
        </form>
    </div>
</div>
@endif

@endsection

@section('scripts')
<script>
    function toggleMockVideo() {
        soundFX.playCorrect();
        const status = document.getElementById('videoPlayingStatus');
        const playBtn = document.getElementById('playBtnMock');
        if (status) {
            if (status.style.display === 'none') {
                status.style.display = 'block';
                if (playBtn) playBtn.innerText = '⏸';
            } else {
                status.style.display = 'none';
                if (playBtn) playBtn.innerText = '▶';
            }
        }
    }

    function openTambahMateriModal() {
        const modal = document.getElementById('modalTambahMateri');
        if (modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeTambahMateriModal() {
        const modal = document.getElementById('modalTambahMateri');
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    function openEditVideoModal() {
        const modal = document.getElementById('modalEditVideo');
        if (modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeEditVideoModal() {
        const modal = document.getElementById('modalEditVideo');
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    function previewYoutubeUrl(url) {
        // Quick visual check for user
        console.log('Video url entered:', url);
    }

    function confirmDeleteTopic(topicId) {
        if (confirm('Apakah Ibu/Bapak Guru yakin ingin menghapus materi ini beserta soal latihannya?')) {
            const f = document.getElementById('deleteTopicForm');
            const inp = document.getElementById('deleteTopicId');
            if (f && inp) {
                inp.value = topicId;
                f.submit();
            }
        }
    }

    // Close modals on overlay backdrop click
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                overlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    });

    // Close modals with Esc key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay.active').forEach(m => {
                m.classList.remove('active');
            });
            document.body.style.overflow = '';
        }
    });

    function switchExerciseTab(index) {
        document.querySelectorAll('.level-btn').forEach((btn, idx) => {
            btn.classList.toggle('active', idx === index);
        });
        document.querySelectorAll('.exercise-question-box').forEach((box, idx) => {
            box.style.display = (idx === index) ? 'block' : 'none';
        });
    }

    const answeredTabs = {};

    function selectOption(tabIdx, selectedOptionIdx, correctOptionIdx, explanation) {
        if (answeredTabs[tabIdx]) return; // prevent multiple submissions
        answeredTabs[tabIdx] = true;

        const isCorrect = (selectedOptionIdx === correctOptionIdx);
        const explBox = document.getElementById(`explanationBox-${tabIdx}`);
        const explTitle = document.getElementById(`explTitle-${tabIdx}`);
        const explText = document.getElementById(`explText-${tabIdx}`);

        // Disable options and color them
        const options = document.querySelectorAll(`#optionsList-${tabIdx} .option-btn`);
        options.forEach((btn, idx) => {
            btn.style.cursor = 'default';
            if (idx === correctOptionIdx) {
                btn.classList.add('selected-correct');
            } else if (idx === selectedOptionIdx) {
                btn.classList.add('selected-wrong');
            }
        });

        if (explBox) {
            explBox.style.display = 'block';
            if (isCorrect) {
                soundFX.playCorrect();
                confetti({ particleCount: 80, spread: 70, origin: { y: 0.6 } });
                explBox.className = 'explanation-card correct';
                explTitle.innerHTML = '🎉 JAWABAN BENAR! (+30 XP)';
                GameState.addXp(30);
                GameState.addCoins(5);
            } else {
                soundFX.playWrong();
                explBox.className = 'explanation-card wrong';
                explTitle.innerHTML = '💡 JAWABAN BELUM TEPAT (Tetap Semangat!)';
            }
            explText.innerHTML = explanation;
        }
    }
</script>
@endsection
