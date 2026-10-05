@extends('layouts.app')

@section('title', 'Kuis Harian 10 Soal | SDS Madani SD Kelas 4-6')

@section('content')
<div class="quiz-wrapper">
    <!-- Quiz Header with Timer & Streak Alert -->
    <div class="quiz-top-bar">
        <div>
            <span style="font-size: 0.85rem; color: #fbbf24; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                ⚡ TANTANGAN HARIAN 10 SOAL
            </span>
            <h1 style="font-family: var(--font-heading); font-size: 1.8rem; color: white;">
                Kuis Disiplin Belajar Harian
            </h1>
        </div>
        <div class="quiz-timer-pill" id="quizTimerBox">
            <span>⏱️</span>
            <span id="quizTimerText">15:00</span>
        </div>
    </div>

    <!-- Progress Track -->
    <div style="margin-bottom: 1.5rem;">
        <div style="display: flex; justify-content: space-between; font-size: 0.85rem; color: var(--text-muted); margin-bottom: 0.4rem;">
            <span>Progres: <strong style="color: white;"><span id="currentQuestionNum">1</span> dari 10 Soal</strong></span>
            <span style="color: #38bdf8;">Skor Sementara: <strong id="currentLiveScore">0</strong> Poin</span>
        </div>
        <div class="progress-track" style="height: 10px;">
            <div class="progress-fill" id="quizProgressBar" style="width: 10%;"></div>
        </div>
    </div>

    <!-- Active Question Card -->
    <div class="glass-panel" id="questionCard">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.2rem;">
            <span class="subject-tag" id="qSubjectBadge" style="background: rgba(59,130,246,0.2); border-color: #3b82f6; color: #93c5fd;">
                Matematika
            </span>
            <span style="font-size: 0.8rem; color: #fbbf24;">Hadiah: +10 XP</span>
        </div>

        <h2 id="qText" style="font-size: 1.25rem; font-weight: 600; color: white; margin-bottom: 1.8rem; line-height: 1.5;">
            <!-- Question text -->
        </h2>

        <div class="options-list" id="quizOptionsList">
            <!-- Options injected by JS -->
        </div>

        <!-- Immediate Explanation -->
        <div class="explanation-card" id="quizExplCard" style="display: none; margin-top: 1rem;">
            <div id="quizExplTitle" style="font-weight: 700; margin-bottom: 0.3rem;"></div>
            <p id="quizExplText" style="font-size: 0.95rem;"></p>
        </div>

        <div style="margin-top: 1.5rem; display: flex; justify-content: flex-end;">
            <button class="btn btn-primary" id="btnNextQuestion" style="display: none;" onclick="goToNextQuestion()">
                Lanjut ke Soal Berikutnya →
            </button>
        </div>
    </div>

    <!-- Final Result Screen (Hidden by default) -->
    <div class="glass-panel" id="resultCard" style="display: none; text-align: center; padding: 3rem 2rem;">
        <div style="font-size: 4.5rem; margin-bottom: 1rem;" id="resultEmoji">🏆</div>
        <h2 style="font-family: var(--font-heading); font-size: 2.2rem; color: white; margin-bottom: 0.5rem;" id="resultHeading">
            Luar Biasa, Doni!
        </h2>
        <p style="color: var(--text-muted); font-size: 1.05rem; margin-bottom: 2rem;">
            Kamu telah menyelesaikan 10 soal kuis harian dengan sangat disiplin!
        </p>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 2rem; max-width: 500px; margin-left: auto; margin-right: auto;">
            <div style="background: rgba(15,23,42,0.8); border: 1px solid var(--border-glass); border-radius: 16px; padding: 1.2rem;">
                <div style="font-size: 1.8rem; font-family: var(--font-heading); color: #38bdf8;" id="finalScoreVal">100</div>
                <div style="font-size: 0.8rem; color: var(--text-muted);">Skor Akhir</div>
            </div>
            <div style="background: rgba(15,23,42,0.8); border: 1px solid var(--border-glass); border-radius: 16px; padding: 1.2rem;">
                <div style="font-size: 1.8rem; font-family: var(--font-heading); color: #fbbf24;" id="finalXpVal">+100</div>
                <div style="font-size: 0.8rem; color: var(--text-muted);">XP Didapat</div>
            </div>
            <div style="background: rgba(15,23,42,0.8); border: 1px solid var(--border-glass); border-radius: 16px; padding: 1.2rem;">
                <div style="font-size: 1.8rem; font-family: var(--font-heading); color: #f97316;">🔥 8</div>
                <div style="font-size: 0.8rem; color: var(--text-muted);">Streak Hari</div>
            </div>
        </div>

        <div style="display: flex; gap: 1rem; justify-content: center;">
            <a href="{{ route('home') }}" class="btn btn-outline">
                Kembali ke Beranda
            </a>
            <a href="{{ route('gamification.index') }}" class="btn btn-accent">
                Buka Avatar & Hadiah 🎁
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const questions = @json($questions);
    let currentIdx = 0;
    let score = 0;
    let answeredCurrent = false;

    function renderQuestion() {
        answeredCurrent = false;
        const q = questions[currentIdx];
        
        document.getElementById('currentQuestionNum').innerText = currentIdx + 1;
        document.getElementById('quizProgressBar').style.width = `${((currentIdx + 1) / questions.length) * 100}%`;
        document.getElementById('qSubjectBadge').innerText = q.subject;
        document.getElementById('qSubjectBadge').style.borderColor = q.badge_color;
        document.getElementById('qText').innerText = q.question;
        
        document.getElementById('quizExplCard').style.display = 'none';
        document.getElementById('btnNextQuestion').style.display = 'none';

        const optList = document.getElementById('quizOptionsList');
        optList.innerHTML = '';

        const labels = ['A', 'B', 'C', 'D'];
        q.options.forEach((opt, oIdx) => {
            const btn = document.createElement('button');
            btn.className = 'option-btn';
            btn.innerHTML = `<span class="option-label">${labels[oIdx]}</span><span>${opt}</span>`;
            btn.onclick = () => handleAnswer(oIdx, q.answer, q.explanation);
            optList.appendChild(btn);
        });
    }

    function handleAnswer(selectedIdx, correctIdx, explanation) {
        if (answeredCurrent) return;
        answeredCurrent = true;

        const isCorrect = (selectedIdx === correctIdx);
        const options = document.querySelectorAll('#quizOptionsList .option-btn');
        options.forEach((btn, idx) => {
            btn.style.cursor = 'default';
            if (idx === correctIdx) btn.classList.add('selected-correct');
            else if (idx === selectedIdx) btn.classList.add('selected-wrong');
        });

        const explCard = document.getElementById('quizExplCard');
        const explTitle = document.getElementById('quizExplTitle');
        const explText = document.getElementById('quizExplText');

        explCard.style.display = 'block';
        if (isCorrect) {
            score += 10;
            document.getElementById('currentLiveScore').innerText = score;
            soundFX.playCorrect();
            explCard.className = 'explanation-card correct';
            explTitle.innerHTML = '🎉 JAWABAN TEPAT! (+10 XP)';
            GameState.addXp(10);
        } else {
            soundFX.playWrong();
            explCard.className = 'explanation-card wrong';
            explTitle.innerHTML = '💡 BELUM TEPAT (Perhatikan Pembahasan)';
        }

        explText.innerHTML = explanation;
        document.getElementById('btnNextQuestion').style.display = 'inline-flex';
        if (currentIdx === questions.length - 1) {
            document.getElementById('btnNextQuestion').innerText = 'Lihat Hasil Akhir Kuis 🏆';
        }
    }

    function goToNextQuestion() {
        if (currentIdx < questions.length - 1) {
            currentIdx++;
            renderQuestion();
        } else {
            showFinalResults();
        }
    }

    function showFinalResults() {
        document.getElementById('questionCard').style.display = 'none';
        document.getElementById('quizTimerBox').style.display = 'none';
        const resultCard = document.getElementById('resultCard');
        resultCard.style.display = 'block';

        document.getElementById('finalScoreVal').innerText = score;
        document.getElementById('finalXpVal').innerText = `+${score}`;

        soundFX.playFanfare();
        confetti({
            particleCount: 150,
            spread: 100,
            origin: { y: 0.5 }
        });

        // Boost student streak and coins
        GameState.addCoins(25);
        const streakEl = document.getElementById('headerStreak');
        if (streakEl) streakEl.innerText = '8';
    }

    // Simple countdown timer
    let timeLeft = 900; // 15 mins
    setInterval(() => {
        if (timeLeft <= 0) return;
        timeLeft--;
        const mins = Math.floor(timeLeft / 60);
        const secs = timeLeft % 60;
        document.getElementById('quizTimerText').innerText = `${mins}:${secs < 10 ? '0' : ''}${secs}`;
    }, 1000);

    document.addEventListener('DOMContentLoaded', () => {
        renderQuestion();
    });
</script>
@endsection
