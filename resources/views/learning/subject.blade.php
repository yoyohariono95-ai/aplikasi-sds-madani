@extends('layouts.app')

@section('title', $subject['name'] . ' | SDS Madani SD Kelas 4-6')

@section('content')
@php
    $selectedTopicId = request('topic');
    $currentTopic = collect($subject['topics'])->firstWhere('id', $selectedTopicId) ?: $subject['topics'][0];
    $exercises = $currentTopic['exercises'] ?? $currentTopic['questions'] ?? [];
@endphp

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
                </p>
            </div>
        </div>

        <div style="display: flex; gap: 0.8rem; align-items: center;">
            <span style="font-size: 0.85rem; color: #fbbf24; font-weight: 700;">🎁 Hadiah Selesai: +50 XP</span>
            <button class="btn btn-outline btn-sm" onclick="soundFX.playCoin(); GameState.addCoins(10); alert('🪙 Bonus 10 Koin diperoleh karena rajin membuka modul!');">
                🪙 Ambil Koin Harian
            </button>
        </div>
    </div>
</div>

<div class="topic-viewer-layout">
    <!-- Left Column: Bite-sized Microlearning & Video/Infografis -->
    <div>
        <!-- 1. Video / Infografis Pendek 2-5 Menit -->
        <div class="video-player-card">
            <div class="video-screen-mock" id="videoScreenMock">
                <div class="play-btn-circle" id="playBtnMock" onclick="toggleMockVideo()">▶</div>
                <h3 style="font-family: var(--font-heading); font-size: 1.25rem; color: white; margin-bottom: 0.4rem;" id="videoMockTitle">
                    🎬 {{ $currentTopic['video_title'] }}
                </h3>
                <p style="color: #cbd5e1; font-size: 0.85rem; max-width: 480px;" id="videoMockDesc">
                    {{ $currentTopic['video_desc'] }}
                </p>
                <div class="video-duration-pill">⏱️ {{ $currentTopic['duration'] }}</div>

                <div id="videoPlayingStatus" style="display: none; margin-top: 0.8rem; background: rgba(34,197,94,0.2); border: 1px solid #22c55e; color: #86efac; padding: 0.3rem 0.8rem; border-radius: 8px; font-size: 0.8rem;">
                    🟢 Video animasi sedang diputar... Pahami konsep visualnya dengan santai!
                </div>
            </div>
            <div class="video-caption-bar" style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 0.85rem; color: var(--text-muted);">
                    💡 <em>Tip Guru: Tonton video animasi dulu sebelum mencoba latihan soal di bawah ya!</em>
                </span>
                <button class="btn btn-outline btn-sm" style="font-size: 0.75rem;" onclick="toggleMockVideo()">
                    Putar Ulang Video ↻
                </button>
            </div>
        </div>

        <!-- 2. Micro-Learning Explanations (Bite-sized, Chunked) -->
        <div class="micro-learning-container">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-family: var(--font-heading); font-size: 1.3rem; color: white; display: flex; align-items: center; gap: 0.5rem;">
                    <span>🧩</span> Penjelasan Inti (Bite-Sized)
                </h3>
                <span style="font-size: 0.8rem; background: rgba(99,102,241,0.2); color: #c7d2fe; padding: 0.2rem 0.6rem; border-radius: 6px;">
                    3 Langkah Mudah
                </span>
            </div>

            @foreach($currentTopic['micro_steps'] as $idx => $step)
            <div class="micro-step-card">
                <div class="micro-step-number">{{ $idx + 1 }}</div>
                <div class="micro-step-content">
                    <h4>{{ $step['title'] }}</h4>
                    <p>{!! $step['content'] !!}</p>
                    <div class="micro-highlight-pill">
                        ✨ {{ $step['highlight'] }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- 3. Latihan Soal Bertingkat: Mudah (★☆☆) -> Sedang (★★☆) -> Sulit (★★★) -->
        <div class="exercises-section">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
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
    </div>

    <!-- Right Sidebar Column: Navigation & Progress -->
    <div>
        <div class="glass-panel" style="margin-bottom: 1.5rem;">
            <h4 style="font-family: var(--font-heading); font-size: 1.15rem; color: white; margin-bottom: 1rem;">
                📌 Modul Lain di {{ $subject['name'] }}
            </h4>
            <div style="display: flex; flex-direction: column; gap: 0.8rem;">
                @foreach($subject['topics'] as $t)
                <a href="{{ route('learning.subject', ['id' => $subject['id'], 'topic' => $t['id']]) }}" style="text-decoration: none; padding: 0.9rem; border-radius: 14px; background: {{ $currentTopic['id'] === $t['id'] ? 'rgba(99,102,241,0.25)' : 'rgba(15,23,42,0.8)' }}; border: 1px solid {{ $currentTopic['id'] === $t['id'] ? 'var(--primary-light)' : 'rgba(255,255,255,0.1)' }}; display: flex; justify-content: space-between; align-items: center; transition: all 0.2s ease;">
                    <div>
                        <div style="font-weight: 600; color: white; font-size: 0.9rem;">{{ $t['title'] }}</div>
                        <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $t['duration'] }} • {{ $t['difficulty'] }}</div>
                    </div>
                    <span style="font-size: 1.2rem;">{{ $currentTopic['id'] === $t['id'] ? '▶' : '📖' }}</span>
                </a>
                @endforeach
            </div>
        </div>

        <div class="glass-panel" style="background: linear-gradient(135deg, rgba(249,115,22,0.15), rgba(15,23,42,0.8)); border-color: rgba(249,115,22,0.3);">
            <div style="display: flex; align-items: center; gap: 0.6rem; margin-bottom: 0.8rem;">
                <span style="font-size: 1.8rem;">🔥</span>
                <div>
                    <div style="font-weight: 700; color: #fed7aa; font-size: 1rem;">Streak Belajar Doni</div>
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
@endsection

@section('scripts')
<script>
    function toggleMockVideo() {
        soundFX.playCorrect();
        const status = document.getElementById('videoPlayingStatus');
        const playBtn = document.getElementById('playBtnMock');
        if (status.style.display === 'none') {
            status.style.display = 'block';
            playBtn.innerText = '⏸';
        } else {
            status.style.display = 'none';
            playBtn.innerText = '▶';
        }
    }

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
</script>
@endsection
