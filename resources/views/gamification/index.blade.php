@extends('layouts.app')

@section('title', 'Gamifikasi & Mini Game Edukasi | SDS Madani SD Kelas 4-6')

@section('content')
<div class="page-header" style="margin-bottom: 2rem;">
    <h1 style="font-family: var(--font-heading); font-size: 2.2rem; color: white;">
        🎮 Gamifikasi, Avatar Studio & Mini Game Edukasi
    </h1>
    <p style="color: var(--text-muted); font-size: 1rem;">
        Belajar lebih semangat dengan mengoleksi lencana, menaikkan level XP, mendandani avatar, dan bermain mini-game edukasi interaktif!
    </p>
</div>

<!-- Row 1: Avatar Studio & Badges Showcase -->
<div class="gamification-grid">
    <!-- 1. Avatar Studio (Kustomisasi Karakter dari Hadiah Poin) -->
    <div class="glass-panel">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3 style="font-family: var(--font-heading); font-size: 1.3rem; color: white; display: flex; align-items: center; gap: 0.5rem;">
                <span>🎨</span> Studio Kustomisasi Avatar
            </h3>
            <span style="font-size: 0.85rem; color: #60a5fa; font-weight: 700;">🪙 <span id="studioCoinText">350</span> Koin Dimiliki</span>
        </div>

        <div class="avatar-studio-box">
            <div class="avatar-preview-stage" id="mainAvatarStage">
                🚀
            </div>
            <div>
                <h4 style="font-family: var(--font-heading); font-size: 1.15rem; color: white;">Doni si Penjelajah Angkasa</h4>
                <p style="font-size: 0.85rem; color: var(--text-muted);">Pilih karakter kesukaanmu menggunakan koin dari hasil belajar:</p>
            </div>

            <!-- Choice Picker -->
            <div class="avatar-picker-row">
                @php
                    $avatars = [
                        ['icon' => '🚀', 'name' => 'Roket Cepat', 'price' => 0],
                        ['icon' => '🦁', 'name' => 'Singa Pemberani', 'price' => 50],
                        ['icon' => '🦊', 'name' => 'Rubah Cerdas', 'price' => 50],
                        ['icon' => '🧙‍♂️', 'name' => 'Penyihir Bijak', 'price' => 100],
                        ['icon' => '🤖', 'name' => 'Robot Pintar', 'price' => 120],
                        ['icon' => '🦄', 'name' => 'Unicorn Ajaib', 'price' => 150],
                        ['icon' => '🥷', 'name' => 'Ninja Matematika', 'price' => 200]
                    ];
                @endphp
                @foreach($avatars as $av)
                <button class="avatar-choice-btn" 
                        onclick="pickAvatar('{{ $av['icon'] }}', '{{ $av['name'] }}', {{ $av['price'] }})" 
                        title="{{ $av['name'] }} ({{ $av['price'] === 0 ? 'Gratis' : $av['price'] . ' Koin' }})">
                    {{ $av['icon'] }}
                </button>
                @endforeach
            </div>

            <div id="avatarStatusAlert" style="font-size: 0.85rem; color: #86efac; min-height: 24px;"></div>
        </div>
    </div>

    <!-- 2. Lencana & Pencapaian (Badges Showcase) -->
    <div class="glass-panel">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3 style="font-family: var(--font-heading); font-size: 1.3rem; color: white; display: flex; align-items: center; gap: 0.5rem;">
                <span>🏅</span> Lencana Prestasi (Badges)
            </h3>
            <span style="font-size: 0.85rem; color: #fbbf24;">5 dari 8 Terbuka</span>
        </div>

        <div class="badges-grid">
            @foreach($badges as $b)
            <div class="badge-item {{ $b['unlocked'] ? '' : 'locked' }}" title="{{ $b['desc'] }}">
                <div class="badge-icon-box">{{ $b['icon'] }}</div>
                <div class="badge-title">{{ $b['title'] }}</div>
                <div style="font-size: 0.7rem; color: {{ $b['unlocked'] ? '#86efac' : '#94a3b8' }};">
                    {{ $b['unlocked'] ? '✓ ' . $b['unlocked_at'] : '🔒 Terkunci' }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Row 2: Leaderboard Ramah Anak (Dapat Dimatikan) -->
<div class="glass-panel" style="margin-bottom: 2.5rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;">
        <div>
            <h3 style="font-family: var(--font-heading); font-size: 1.3rem; color: white; display: flex; align-items: center; gap: 0.5rem;">
                <span>🏆</span> Papan Peringkat Sahabat Kelas 5-A
            </h3>
            <p style="font-size: 0.85rem; color: var(--text-muted);">
                Semua teman berjuang bersama dengan giat!
            </p>
        </div>

        <!-- Optional Toggle to turn off ranking pressure -->
        <div style="display: flex; align-items: center; gap: 0.8rem; background: rgba(15,23,42,0.8); padding: 0.4rem 0.9rem; border-radius: 999px; border: 1px solid var(--border-glass);">
            <span style="font-size: 0.85rem; color: #cbd5e1;">Mode Santai (Tanpa Peringkat):</span>
            <input type="checkbox" id="toggleRelaxMode" onchange="toggleRelaxedLeaderboard(this.checked)" style="cursor: pointer; width: 18px; height: 18px;">
        </div>
    </div>

    <div class="leaderboard-list" id="leaderboardContainer">
        @foreach($leaderboard as $lead)
        <div class="leader-item {{ !empty($lead['is_me']) ? 'is-me' : '' }}">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <span class="leader-rank top-{{ $lead['rank'] }}">#{{ $lead['rank'] }}</span>
                <span style="font-size: 1.5rem;">{{ $lead['avatar'] }}</span>
                <div>
                    <div style="font-weight: 700; color: white; font-size: 0.95rem;">
                        {{ $lead['name'] }}
                        @if(!empty($lead['is_me']))
                        <span style="background: rgba(99,102,241,0.4); font-size: 0.7rem; padding: 0.1rem 0.4rem; border-radius: 4px; margin-left: 0.4rem;">Kamu</span>
                        @endif
                    </div>
                    <div style="font-size: 0.75rem; color: var(--text-muted);">
                        Level {{ $lead['level'] }} • {{ $lead['badge'] }}
                    </div>
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 1.5rem;">
                <div style="font-size: 0.85rem; color: #fed7aa; font-weight: 700;">
                    🔥 {{ $lead['streak'] }} Hari
                </div>
                <div style="font-size: 1rem; color: #fef08a; font-weight: 800;">
                    {{ $lead['xp'] }} XP
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div id="relaxedViewMessage" style="display: none; text-align: center; padding: 2rem; background: rgba(16,185,129,0.1); border-radius: 16px; border: 1px dashed #10b981;">
        <span style="font-size: 2rem;">🌿</span>
        <h4 style="color: #6ee7b7; font-family: var(--font-heading); margin-top: 0.5rem;">Mode Santai Aktif</h4>
        <p style="font-size: 0.9rem; color: #cbd5e1;">Peringkat disembunyikan agar kamu bisa belajar dengan tenang sesuai kecepatan belajarmu sendiri tanpa tekanan!</p>
    </div>
</div>

<!-- Row 3: 4 Mini Game Edukasi Interaktif -->
<div class="section-header">
    <div>
        <h2 class="section-title">
            <span>🎯</span> 4 Mini Game Edukasi Interaktif
        </h2>
        <p class="section-subtitle">
            Mainkan langsung di sini untuk melatih ketangkasan berhitung, memori sains, dan kosakata!
        </p>
    </div>
</div>

<div class="minigames-grid">
    <!-- Game 1: Kejar Waktu Hitungan (Math Speed Run) -->
    <div class="game-card" id="cardGameSpeedRun">
        <div style="font-size: 2.5rem;">⚡</div>
        <div>
            <h3 style="font-family: var(--font-heading); font-size: 1.3rem; color: white;">Kejar Waktu Hitungan (30s)</h3>
            <p style="color: var(--text-muted); font-size: 0.85rem; line-height: 1.5;">
                Jawab secepat mungkin operasi hitung perkalian & penjumlahan sebelum waktu 30 detik habis!
            </p>
        </div>
        <button class="btn btn-primary btn-sm" onclick="openMathSpeedGame()">
            Mulai Mainkan Sekarang ▶
        </button>
    </div>

    <!-- Game 2: Mencocokkan Kartu (Memory Card Match) -->
    <div class="game-card" id="cardGameMemory">
        <div style="font-size: 2.5rem;">🎴</div>
        <div>
            <h3 style="font-family: var(--font-heading); font-size: 1.3rem; color: white;">Cocok Kartu Memori Sains</h3>
            <p style="color: var(--text-muted); font-size: 0.85rem; line-height: 1.5;">
                Balik 8 kartu dan temukan pasangan organ tubuh, tumbuhan, atau angka pecahan yang serasi!
            </p>
        </div>
        <button class="btn btn-accent btn-sm" onclick="openMemoryGame()">
            Mulai Balik Kartu ▶
        </button>
    </div>

    <!-- Game 3: Tebak Gambar Misteri -->
    <div class="game-card" id="cardGameMystery">
        <div style="font-size: 2.5rem;">🖼️</div>
        <div>
            <h3 style="font-family: var(--font-heading); font-size: 1.3rem; color: white;">Tebak Gambar Alam Misterius</h3>
            <p style="color: var(--text-muted); font-size: 0.85rem; line-height: 1.5;">
                Buka kotak petunjuk satu per satu dan tebak fenomena alam atau hewan langka yang tersembunyi!
            </p>
        </div>
        <button class="btn btn-outline btn-sm" onclick="openPictureGame()">
            Mulai Tebak Gambar ▶
        </button>
    </div>

    <!-- Game 4: Teka-Teki Kata (Word Scramble) -->
    <div class="game-card" id="cardGameWord">
        <div style="font-size: 2.5rem;">🧩</div>
        <div>
            <h3 style="font-family: var(--font-heading); font-size: 1.3rem; color: white;">Susun Huruf Kata Pintar</h3>
            <p style="color: var(--text-muted); font-size: 0.85rem; line-height: 1.5;">
                Susun huruf-huruf yang teracak menjadi istilah sains & bahasa yang tepat untuk hadiah koin!
            </p>
        </div>
        <button class="btn btn-outline btn-sm" onclick="openWordGame()">
            Susun Kata Sekarang ▶
        </button>
    </div>
</div>

<!-- Modal Container for Playable Mini-Games -->
<div id="gameModal" style="display: none; position: fixed; inset: 0; background: rgba(2,6,23,0.85); backdrop-filter: blur(16px); z-index: 2000; align-items: center; justify-content: center; padding: 1.5rem;">
    <div class="glass-panel" style="max-width: 600px; width: 100%; position: relative; border-color: rgba(99,102,241,0.5);" id="modalContentInner">
        <button onclick="closeGameModal()" style="position: absolute; top: 16px; right: 16px; background: transparent; border: none; color: white; font-size: 1.5rem; cursor: pointer;">✕</button>
        <div id="gamePlayArea">
            <!-- Dynamic game markup injected here -->
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function pickAvatar(icon, name, price) {
        soundFX.playCoin();
        document.getElementById('mainAvatarStage').innerText = icon;
        GameState.setAvatar(icon);
        const alertEl = document.getElementById('avatarStatusAlert');
        alertEl.innerText = `✨ Karakter "${name}" berhasil dipasang pada profilmu!`;
        confetti({ particleCount: 50, spread: 50 });
    }

    function toggleRelaxedLeaderboard(isRelaxed) {
        const list = document.getElementById('leaderboardContainer');
        const msg = document.getElementById('relaxedViewMessage');
        if (isRelaxed) {
            list.style.display = 'none';
            msg.style.display = 'block';
        } else {
            list.style.display = 'flex';
            msg.style.display = 'none';
        }
    }

    function closeGameModal() {
        document.getElementById('gameModal').style.display = 'none';
        clearInterval(window.activeGameTimer);
    }

    // 1. Math Speed Run Game Implementation
    function openMathSpeedGame() {
        soundFX.playCoin();
        const modal = document.getElementById('gameModal');
        const area = document.getElementById('gamePlayArea');
        modal.style.display = 'flex';

        let mathScore = 0;
        let mathTime = 30;
        let currentAns = 0;

        function nextMathProblem() {
            const n1 = Math.floor(Math.random() * 9) + 2;
            const n2 = Math.floor(Math.random() * 9) + 2;
            currentAns = n1 * n2;
            document.getElementById('mathProblemDisplay').innerText = `${n1} × ${n2} = ?`;
            document.getElementById('mathInput').value = '';
            document.getElementById('mathInput').focus();
        }

        area.innerHTML = `
            <div style="text-align: center;">
                <h3 style="font-family: var(--font-heading); font-size: 1.6rem; color: white; margin-bottom: 0.5rem;">⚡ Kejar Waktu Hitungan (30 Detik)</h3>
                <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem;">Jawab sebanyak mungkin sebelum waktu habis!</p>
                
                <div style="display: flex; justify-content: space-around; margin-bottom: 1.5rem;">
                    <div style="font-size: 1.2rem; font-weight: 700; color: #fca5a5;">⏱️ Waktu: <span id="mathTimerSec">30</span>s</div>
                    <div style="font-size: 1.2rem; font-weight: 700; color: #fbbf24;">⭐ Skor: <span id="mathScoreVal">0</span></div>
                </div>

                <div id="mathProblemDisplay" style="font-family: var(--font-heading); font-size: 3rem; color: #38bdf8; margin-bottom: 1.5rem;">
                    7 × 8 = ?
                </div>

                <div style="display: flex; gap: 0.5rem; justify-content: center; max-width: 320px; margin: 0 auto 1.5rem;">
                    <input type="number" id="mathInput" style="width: 140px; font-size: 1.8rem; text-align: center; border-radius: 12px; border: 2px solid var(--primary); background: #0f172a; color: white;" placeholder="Jawaban">
                    <button class="btn btn-primary" id="btnSubmitMath">Jawab</button>
                </div>
                <div id="mathFeedback" style="min-height: 24px; font-size: 0.9rem; font-weight: 700;"></div>
            </div>
        `;

        nextMathProblem();

        function checkMathAnswer() {
            const userVal = parseInt(document.getElementById('mathInput').value);
            const fb = document.getElementById('mathFeedback');
            if (userVal === currentAns) {
                mathScore++;
                soundFX.playCorrect();
                document.getElementById('mathScoreVal').innerText = mathScore;
                fb.innerHTML = '<span style="color: #4ade80;">Benar! +1 Poin</span>';
                GameState.addXp(5);
                nextMathProblem();
            } else {
                soundFX.playWrong();
                fb.innerHTML = '<span style="color: #f87171;">Kurang tepat, coba lagi!</span>';
            }
        }

        document.getElementById('btnSubmitMath').onclick = checkMathAnswer;
        document.getElementById('mathInput').onkeydown = (e) => { if (e.key === 'Enter') checkMathAnswer(); };

        window.activeGameTimer = setInterval(() => {
            mathTime--;
            const timerEl = document.getElementById('mathTimerSec');
            if (timerEl) timerEl.innerText = mathTime;
            if (mathTime <= 0) {
                clearInterval(window.activeGameTimer);
                soundFX.playFanfare();
                confetti({ particleCount: 100, spread: 80 });
                area.innerHTML = `
                    <div style="text-align: center; padding: 1.5rem;">
                        <div style="font-size: 4rem;">🏆</div>
                        <h3 style="font-family: var(--font-heading); color: white; font-size: 1.8rem;">Waktu Habis!</h3>
                        <p style="color: var(--text-muted); margin-bottom: 1.5rem;">Kamu berhasil menjawab <b>${mathScore}</b> soal dengan cepat!</p>
                        <p style="color: #fbbf24; font-weight: 700; margin-bottom: 1.5rem;">Bonus Diperoleh: +${mathScore * 10} XP & +15 Koin</p>
                        <button class="btn btn-primary" onclick="closeGameModal()">Tutup & Ambil Hadiah</button>
                    </div>
                `;
                GameState.addXp(mathScore * 10);
                GameState.addCoins(15);
            }
        }, 1000);
    }

    // 2. Memory Card Match Game Implementation
    function openMemoryGame() {
        soundFX.playCoin();
        const modal = document.getElementById('gameModal');
        const area = document.getElementById('gamePlayArea');
        modal.style.display = 'flex';

        const cardPairs = ['🔬', '🔬', '🌱', '🌱', '🌍', '🌍', '📐', '📐'];
        cardPairs.sort(() => Math.random() - 0.5);

        area.innerHTML = `
            <div style="text-align: center;">
                <h3 style="font-family: var(--font-heading); font-size: 1.5rem; color: white; margin-bottom: 0.5rem;">🎴 Cocok Kartu Sains (Memory Match)</h3>
                <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 1.5rem;">Temukan 4 pasang kartu simbol yang sama!</p>
                <div id="memoryGrid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 0.8rem; max-width: 400px; margin: 0 auto 1.5rem;"></div>
                <div id="memoryStatus" style="font-size: 0.9rem; color: #93c5fd; min-height: 24px;"></div>
            </div>
        `;

        const grid = document.getElementById('memoryGrid');
        let flipped = [];
        let matched = 0;

        cardPairs.forEach((symbol, idx) => {
            const card = document.createElement('div');
            card.style.cssText = 'height: 80px; background: #1e293b; border: 2px solid rgba(255,255,255,0.15); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 2rem; cursor: pointer; user-select: none; transition: transform 0.2s;';
            card.innerText = '❓';
            card.onclick = () => {
                if (card.innerText !== '❓' || flipped.length === 2) return;
                soundFX.playCorrect();
                card.innerText = symbol;
                card.style.background = '#3b82f6';
                flipped.push({ card, symbol });

                if (flipped.length === 2) {
                    if (flipped[0].symbol === flipped[1].symbol) {
                        soundFX.playCoin();
                        matched++;
                        flipped = [];
                        if (matched === 4) {
                            soundFX.playFanfare();
                            confetti({ particleCount: 100, spread: 70 });
                            document.getElementById('memoryStatus').innerHTML = '🎉 <strong>Hebat! Semua kartu berhasil dicocokkan! (+40 XP)</strong>';
                            GameState.addXp(40);
                            GameState.addCoins(10);
                        }
                    } else {
                        soundFX.playWrong();
                        setTimeout(() => {
                            flipped[0].card.innerText = '❓';
                            flipped[0].card.style.background = '#1e293b';
                            flipped[1].card.innerText = '❓';
                            flipped[1].card.style.background = '#1e293b';
                            flipped = [];
                        }, 700);
                    }
                }
            };
            grid.appendChild(card);
        });
    }

    // 3. Picture Guessing Game Implementation
    function openPictureGame() {
        soundFX.playCoin();
        const modal = document.getElementById('gameModal');
        const area = document.getElementById('gamePlayArea');
        modal.style.display = 'flex';

        area.innerHTML = `
            <div style="text-align: center;">
                <h3 style="font-family: var(--font-heading); font-size: 1.5rem; color: white; margin-bottom: 0.5rem;">🖼️ Tebak Gambar Alam Misterius</h3>
                <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 1.5rem;">Klik kotak untuk membuka petunjuk fenomena alam!</p>
                
                <div style="position: relative; width: 280px; height: 180px; margin: 0 auto 1.5rem; background: #0284c7; border-radius: 16px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                    <div style="font-size: 5rem;" id="mysterySecretEmoji">🌋</div>
                    <div id="mysteryTilesOverlay" style="position: absolute; inset: 0; display: grid; grid-template-columns: repeat(3, 1fr); gap: 2px;"></div>
                </div>

                <p style="color: #cbd5e1; font-size: 0.9rem; margin-bottom: 1rem;">Petunjuk: Fenomena keluarnya magma dari perut bumi!</p>
                <div style="display: flex; gap: 0.5rem; justify-content: center; max-width: 320px; margin: 0 auto;">
                    <input type="text" id="picGuessInput" placeholder="Tebak fenomena..." style="padding: 0.6rem; border-radius: 10px; border: 1px solid var(--primary); background: #0f172a; color: white; flex: 1;">
                    <button class="btn btn-primary btn-sm" onclick="checkPicGuess()">Tebak</button>
                </div>
                <div id="picGuessFeedback" style="margin-top: 1rem; font-size: 0.9rem; font-weight: 700;"></div>
            </div>
        `;

        const overlay = document.getElementById('mysteryTilesOverlay');
        for (let i = 0; i < 6; i++) {
            const tile = document.createElement('div');
            tile.style.cssText = 'background: #1e293b; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; color: #94a3b8; border: 1px solid rgba(255,255,255,0.1);';
            tile.innerText = `Buka ${i + 1}`;
            tile.onclick = () => {
                tile.style.opacity = '0';
                tile.style.pointerEvents = 'none';
                soundFX.playCorrect();
            };
            overlay.appendChild(tile);
        }

        window.checkPicGuess = function() {
            const val = document.getElementById('picGuessInput').value.toLowerCase().trim();
            const fb = document.getElementById('picGuessFeedback');
            if (val.includes('gunung') || val.includes('letusan') || val.includes('gunung meletus') || val.includes('vulkanik')) {
                soundFX.playFanfare();
                confetti({ particleCount: 90, spread: 70 });
                fb.innerHTML = '<span style="color: #4ade80;">🎉 TEPAT SEKALI! Gunung Meletus / Letusan Vulkanik! (+50 XP)</span>';
                document.getElementById('mysteryTilesOverlay').style.display = 'none';
                GameState.addXp(50);
            } else {
                soundFX.playWrong();
                fb.innerHTML = '<span style="color: #f87171;">Kurang tepat, coba buka kotak petunjuk lain!</span>';
            }
        };
    }

    // 4. Word Scramble Game Implementation
    function openWordGame() {
        soundFX.playCoin();
        const modal = document.getElementById('gameModal');
        const area = document.getElementById('gamePlayArea');
        modal.style.display = 'flex';

        area.innerHTML = `
            <div style="text-align: center;">
                <h3 style="font-family: var(--font-heading); font-size: 1.5rem; color: white; margin-bottom: 0.5rem;">🧩 Susun Huruf Kata Pintar</h3>
                <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 1.5rem;">Susun huruf acak berikut menjadi nama organ tubuh penting!</p>
                
                <div style="font-family: var(--font-heading); font-size: 2.8rem; letter-spacing: 8px; color: #f43f5e; margin-bottom: 1.5rem;">
                    B - U - N - G - L - A - M
                </div>

                <p style="color: #cbd5e1; font-size: 0.9rem; margin-bottom: 1rem;">Petunjuk: Tempat mencerna makanan dengan bantuan asam HCl.</p>
                <div style="display: flex; gap: 0.5rem; justify-content: center; max-width: 320px; margin: 0 auto;">
                    <input type="text" id="wordScrambleInput" placeholder="Ketik kata..." style="padding: 0.6rem; border-radius: 10px; border: 1px solid var(--primary); background: #0f172a; color: white; flex: 1;">
                    <button class="btn btn-primary btn-sm" onclick="checkWordGuess()">Kirim</button>
                </div>
                <div id="wordGuessFeedback" style="margin-top: 1rem; font-size: 0.9rem; font-weight: 700;"></div>
            </div>
        `;

        window.checkWordGuess = function() {
            const val = document.getElementById('wordScrambleInput').value.toLowerCase().trim();
            const fb = document.getElementById('wordGuessFeedback');
            if (val === 'lambung') {
                soundFX.playFanfare();
                confetti({ particleCount: 90, spread: 70 });
                fb.innerHTML = '<span style="color: #4ade80;">🎉 BENAR SEKALI! Organ tersebut adalah LAMBUNG! (+30 XP)</span>';
                GameState.addXp(30);
            } else {
                soundFX.playWrong();
                fb.innerHTML = '<span style="color: #f87171;">Masih belum tepat, periksa kembali hurufnya!</span>';
            }
        };
    }
</script>
@endsection
