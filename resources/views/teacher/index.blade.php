@extends('layouts.app')

@section('title', 'Portal Guru | SDS Madani SD Kelas 4-6')

@section('content')
<div class="page-header" style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-family: var(--font-heading); font-size: 2.2rem; color: white;">
                👨‍🏫 Dashboard Guru Kelas 5-A SDS Madani
            </h1>
            <p style="color: var(--text-muted); font-size: 1rem;">
                Pantau progres dan nilai siswa secara real-time, analisis topik tersulit, dan buat penugasan soal mandiri.
            </p>
        </div>
        <div style="display: flex; gap: 0.8rem;">
            <button class="btn btn-primary btn-sm" onclick="scrollToQuizBuilder()">
                ➕ Buat Soal & Tugas Baru
            </button>
            <a href="{{ route('teacher.export') }}" class="btn btn-outline btn-sm">
                📥 Unduh Rekap Nilai CSV
            </a>
        </div>
    </div>
</div>

<!-- 1. Statistik Kelas (Ringkasan Real-Time) -->
<div class="teacher-stat-cards">
    <div class="t-stat-card">
        <span class="t-stat-label">👥 Total Siswa Terdaftar</span>
        <span class="t-stat-val">{{ $classStats['total_students'] }} Siswa</span>
        <span style="font-size: 0.75rem; color: #4ade80;">100% Memiliki Akun</span>
    </div>

    <div class="t-stat-card">
        <span class="t-stat-label">📊 Rerata Nilai Tugas & Kuis</span>
        <span class="t-stat-val" style="color: #38bdf8;">{{ $classStats['avg_score'] }} / 100</span>
        <span style="font-size: 0.75rem; color: #38bdf8;">Kategori: Sangat Baik</span>
    </div>

    <div class="t-stat-card">
        <span class="t-stat-label">🔥 Siswa Belajar Hari Ini</span>
        <span class="t-stat-val" style="color: #f97316;">{{ $classStats['active_today'] }} Siswa</span>
        <span style="font-size: 0.75rem; color: #fed7aa;">Keaktifan: {{ $classStats['completion_rate'] }}</span>
    </div>

    <div class="t-stat-card">
        <span class="t-stat-label">⚠️ Siswa Butuh Remedial</span>
        <span class="t-stat-val" style="color: #f43f5e;">2 Siswa</span>
        <span style="font-size: 0.75rem; color: #fecdd3;">Perlu bimbingan khusus</span>
    </div>
</div>

<!-- 2. Laporan Otomatis: Analisis Topik Paling Sulit Bagi Siswa -->
<div class="difficulty-alert-box">
    <div style="display: flex; align-items: center; gap: 0.8rem; margin-bottom: 1rem;">
        <span style="font-size: 1.8rem;">🚨</span>
        <div>
            <h3 style="font-family: var(--font-heading); font-size: 1.3rem; color: #fca5a5;">
                Laporan Otomatis: Topik Paling Sulit Bagi Siswa (Perlu Remedial)
            </h3>
            <p style="color: #fecdd3; font-size: 0.85rem;">
                Sistem mendeteksi topik dengan tingkat kesalahan latihan & kuis tertinggi minggu ini.
            </p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1rem;">
        @foreach($difficultTopics as $dt)
        <div style="background: rgba(15,23,42,0.85); border: 1px solid rgba(239,68,68,0.4); border-radius: 14px; padding: 1.2rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.6rem;">
                <span class="badge-grade" style="background: #ef4444;">{{ $dt['status'] }}</span>
                <span style="font-size: 0.8rem; color: #fca5a5; font-weight: 700;">{{ $dt['difficulty_rate'] }}</span>
            </div>
            <h4 style="font-size: 1rem; color: white; margin-bottom: 0.5rem;">{{ $dt['topic'] }}</h4>
            <p style="font-size: 0.85rem; color: #cbd5e1; line-height: 1.4; margin-bottom: 0.8rem;">
                💡 <strong>Rekomendasi Guru:</strong> {{ $dt['recommendation'] }}
            </p>
            <button class="btn btn-outline btn-sm" style="font-size: 0.75rem; width: 100%; justify-content: center;" onclick="alert('Materi remedial telah dikirimkan ke modul Doni dan Budi!')">
                Tugaskan Modul Latihan Tambahan
            </button>
        </div>
        @endforeach
    </div>
</div>

<!-- 3. Tabel Progres dan Nilai Tiap Siswa -->
<div class="glass-panel" style="margin-bottom: 2.5rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h3 style="font-family: var(--font-heading); font-size: 1.3rem; color: white;">
                📋 Rekapitulasi Progres & Nilai Siswa Kelas 5-A
            </h3>
            <p style="font-size: 0.85rem; color: var(--text-muted);">Data pemantauan keaktifan, perolehan XP, dan kesulitan belajar tiap anak.</p>
        </div>
        <input type="text" placeholder="Cari nama siswa..." style="padding: 0.5rem 1rem; border-radius: 10px; border: 1px solid var(--border-glass); background: rgba(15,23,42,0.8); color: white; font-size: 0.85rem;">
    </div>

    <div style="overflow-x: auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nama Siswa</th>
                    <th>Rata-rata Nilai</th>
                    <th>Status Belajar</th>
                    <th>Streak Harian</th>
                    <th>Total XP</th>
                    <th>Kelemahan Terdeteksi</th>
                    <th>Aksi Guru</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $st)
                <tr>
                    <td style="font-weight: 700; color: white;">{{ $st['name'] }}</td>
                    <td>
                        <span style="font-weight: 700; color: {{ $st['score'] >= 85 ? '#4ade80' : ($st['score'] >= 75 ? '#fbbf24' : '#f87171') }};">
                            {{ $st['score'] }}
                        </span>
                    </td>
                    <td>
                        <span style="font-size: 0.75rem; padding: 0.2rem 0.6rem; border-radius: 999px; background: rgba(255,255,255,0.08);">
                            {{ $st['status'] }}
                        </span>
                    </td>
                    <td>🔥 {{ $st['streak'] }} Hari</td>
                    <td style="color: #fef08a;">{{ $st['xp'] }} XP</td>
                    <td style="color: #cbd5e1; font-size: 0.85rem;">{{ $st['weakness'] }}</td>
                    <td>
                        <button class="btn btn-outline btn-sm" style="font-size: 0.75rem;" onclick="alert('Detail kartu rapor belajar {{ $st['name'] }} siap dicetak.')">
                            Rapor
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- 4. Pembuat Soal & Tugas Mandiri (Interactive Quiz Creator) -->
<div class="glass-panel" id="quizCreatorSection" style="margin-bottom: 2.5rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <div>
            <h3 style="font-family: var(--font-heading); font-size: 1.3rem; color: white; display: flex; align-items: center; gap: 0.5rem;">
                <span>✍️</span> Pembuat Soal & Tugas Mandiri oleh Guru
            </h3>
            <p style="font-size: 0.85rem; color: var(--text-muted);">
                Tambahkan pertanyaan kuis baru atau buat tugas bertarget khusus untuk siswa Anda.
            </p>
        </div>
    </div>

    <form onsubmit="handleCreateQuestion(event)" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
        <div>
            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.4rem;">
                    Mata Pelajaran:
                </label>
                <select id="newQuestionSubject" style="width: 100%; padding: 0.7rem; border-radius: 12px; background: #0f172a; border: 1px solid var(--border-glass); color: white;">
                    <option value="Matematika">Matematika</option>
                    <option value="IPA">IPA (Ilmu Pengetahuan Alam)</option>
                    <option value="IPS">IPS (Ilmu Pengetahuan Sosial)</option>
                    <option value="Bahasa Indonesia">Bahasa Indonesia</option>
                    <option value="Bahasa Inggris">Bahasa Inggris</option>
                </select>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.4rem;">
                    Tingkat Kesulitan:
                </label>
                <select id="newQuestionLevel" style="width: 100%; padding: 0.7rem; border-radius: 12px; background: #0f172a; border: 1px solid var(--border-glass); color: white;">
                    <option value="Mudah">Mudah (★☆☆)</option>
                    <option value="Sedang">Sedang (★★☆)</option>
                    <option value="Sulit">Sulit (★★★)</option>
                </select>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.4rem;">
                    Teks Pertanyaan:
                </label>
                <textarea id="newQuestionText" rows="3" placeholder="Contoh: Berapakah hasil dari 3/5 + 1/5?" style="width: 100%; padding: 0.7rem; border-radius: 12px; background: #0f172a; border: 1px solid var(--border-glass); color: white; resize: vertical;" required></textarea>
            </div>
        </div>

        <div>
            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.4rem;">
                    Pilihan Jawaban (A, B, C, D):
                </label>
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <input type="text" id="optA" placeholder="Pilihan A" style="padding: 0.6rem; border-radius: 8px; background: #0f172a; border: 1px solid var(--border-glass); color: white;" required>
                    <input type="text" id="optB" placeholder="Pilihan B" style="padding: 0.6rem; border-radius: 8px; background: #0f172a; border: 1px solid var(--border-glass); color: white;" required>
                    <input type="text" id="optC" placeholder="Pilihan C" style="padding: 0.6rem; border-radius: 8px; background: #0f172a; border: 1px solid var(--border-glass); color: white;">
                    <input type="text" id="optD" placeholder="Pilihan D" style="padding: 0.6rem; border-radius: 8px; background: #0f172a; border: 1px solid var(--border-glass); color: white;">
                </div>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.4rem;">
                    Kunci Jawaban Benar:
                </label>
                <select id="correctOptionKey" style="width: 100%; padding: 0.7rem; border-radius: 12px; background: #0f172a; border: 1px solid var(--border-glass); color: white;">
                    <option value="A">Pilihan A</option>
                    <option value="B">Pilihan B</option>
                    <option value="C">Pilihan C</option>
                    <option value="D">Pilihan D</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                Simpan & Terbitkan Soal ke Siswa 🚀
            </button>
        </div>
    </form>
    <div id="quizCreatedSuccessMsg" style="display: none; margin-top: 1rem; padding: 0.8rem; border-radius: 10px; background: rgba(34,197,94,0.2); border: 1px solid #22c55e; color: #86efac; font-size: 0.9rem;">
        ✅ Soal baru berhasil diterbitkan dan otomatis muncul di latihan siswa!
    </div>
</div>

<!-- 5. Pengumuman dan Jadwal Tugas -->
<div class="glass-panel">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h3 style="font-family: var(--font-heading); font-size: 1.3rem; color: white; display: flex; align-items: center; gap: 0.5rem;">
            <span>📢</span> Pengumuman & Jadwal Tugas Kelas
        </h3>
        <button class="btn btn-outline btn-sm" onclick="alert('Formulir tambah pengumuman baru terbuka!')">
            + Tambah Pengumuman
        </button>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
        @foreach($announcements as $anc)
        <div style="background: rgba(15,23,42,0.8); border: 1px solid var(--border-glass); border-radius: 16px; padding: 1.4rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                <span style="font-size: 0.8rem; background: rgba(99,102,241,0.2); color: #c7d2fe; padding: 0.2rem 0.6rem; border-radius: 6px;">
                    📅 {{ $anc['date'] }}
                </span>
                <span style="font-size: 0.75rem; color: #4ade80;">Aktif</span>
            </div>
            <h4 style="font-size: 1.1rem; color: white; margin-bottom: 0.4rem;">{{ $anc['title'] }}</h4>
            <p style="font-size: 0.9rem; color: #cbd5e1; line-height: 1.5;">{{ $anc['desc'] }}</p>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
<script>
    function scrollToQuizBuilder() {
        document.getElementById('quizCreatorSection').scrollIntoView({ behavior: 'smooth' });
    }

    function handleCreateQuestion(e) {
        e.preventDefault();
        const subject = document.getElementById('newQuestionSubject').value;
        const level = document.getElementById('newQuestionLevel').value;
        const questionText = document.getElementById('newQuestionText').value;
        const optA = document.getElementById('optA').value;
        const optB = document.getElementById('optB').value;
        const optC = document.getElementById('optC').value || '-';
        const optD = document.getElementById('optD').value || '-';
        const correctKey = document.getElementById('correctOptionKey').value;
        const answerIdx = {'A': 0, 'B': 1, 'C': 2, 'D': 3}[correctKey] || 0;

        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        fetch('{{ route("api.store-question") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({
                subject_id: subject,
                level: level,
                question: questionText,
                options: [optA, optB, optC, optD],
                answer: answerIdx,
                explanation: `Penjelasan untuk soal ini: Jawaban yang tepat adalah opsi ${correctKey}.`
            })
        })
        .then(res => res.json())
        .then(data => {
            soundFX.playCorrect();
            const successMsg = document.getElementById('quizCreatedSuccessMsg');
            successMsg.style.display = 'block';
            confetti({ particleCount: 70, spread: 60 });
            e.target.reset();
            setTimeout(() => {
                successMsg.style.display = 'none';
            }, 4000);
        })
        .catch(err => {
            alert('Gagal menyimpan soal ke server.');
        });
    }
</script>
@endsection
