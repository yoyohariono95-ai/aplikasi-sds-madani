@extends('layouts.app')

@section('title', 'Portal Guru | SDS Madani SD Kelas 4-6')

@section('content')
<!-- Role Status Banner -->
<div class="role-status-banner role-status-guru" style="margin-bottom: 1.75rem;">
    <div class="role-status-content">
        <span class="role-status-icon">👨‍🏫</span>
        <div>
            <strong>Portal Guru Terautentikasi:</strong> Selamat datang, <b>{{ Auth::user()->name ?? 'Ibu Rahmawati, S.Pd.' }}</b> (Wali Kelas 5-A). Pantau pencapaian belajar, buat akun siswa, dan kelola materi pelajaran di sini.
        </div>
    </div>
    <div class="role-status-actions">
        <a href="{{ route('teacher.export') }}" class="btn btn-outline btn-sm">
            📥 Unduh Rekap Nilai CSV
        </a>
    </div>
</div>

@if(session('success'))
<div style="background: rgba(16, 185, 129, 0.2); border: 1px solid #10b981; color: #a7f3d0; padding: 0.9rem 1.25rem; border-radius: 14px; margin-bottom: 1.75rem; display: flex; align-items: center; justify-content: space-between; gap: 0.8rem; animation: fadeIn 0.3s ease;">
    <div style="display: flex; align-items: center; gap: 0.75rem;">
        <span style="font-size: 1.4rem;">🎉</span>
        <span style="font-size: 0.95rem; font-weight: 600;">{{ session('success') }}</span>
    </div>
    <button onclick="this.parentElement.remove()" style="background: transparent; border: none; color: #a7f3d0; cursor: pointer; font-size: 1.2rem; line-height: 1;">✕</button>
</div>
@endif

@if(session('error'))
<div style="background: rgba(239, 68, 68, 0.2); border: 1px solid #ef4444; color: #fca5a5; padding: 0.9rem 1.25rem; border-radius: 14px; margin-bottom: 1.75rem; display: flex; align-items: center; justify-content: space-between; gap: 0.8rem; animation: fadeIn 0.3s ease;">
    <div style="display: flex; align-items: center; gap: 0.75rem;">
        <span style="font-size: 1.4rem;">⚠️</span>
        <span style="font-size: 0.95rem; font-weight: 600;">{{ session('error') }}</span>
    </div>
    <button onclick="this.parentElement.remove()" style="background: transparent; border: none; color: #fca5a5; cursor: pointer; font-size: 1.2rem; line-height: 1;">✕</button>
</div>
@endif

<div class="page-header" style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-family: var(--font-heading); font-size: 2.2rem; color: white;">
                👨‍🏫 Dashboard Pengajar Kelas 5-A SDS Madani
            </h1>
            <p style="color: var(--text-muted); font-size: 1rem;">
                Kelola akun siswa, pantau progres dan nilai real-time, analisis topik remedial, dan buat materi baru.
            </p>
        </div>
        <div style="display: flex; gap: 0.8rem; flex-wrap: wrap;">
            <button class="btn btn-primary btn-sm" onclick="openTambahSiswaModal()" style="background: linear-gradient(135deg, #10b981, #059669); border: none; font-weight: 700; box-shadow: 0 4px 15px rgba(16,185,129,0.35);">
                👤+ Tambah Akun Siswa Baru
            </button>
            <button class="btn btn-primary btn-sm" onclick="scrollToMateriBuilder()" style="background: linear-gradient(135deg, #8b5cf6, #6366f1); border: none; font-weight: 700;">
                ➕ Tambah Materi & Video
            </button>
            <button class="btn btn-outline btn-sm" onclick="scrollToQuizBuilder()">
                ✍️ Buat Soal Kuis
            </button>
            <a href="{{ route('teacher.export') }}" class="btn btn-outline btn-sm">
                📥 Rekap CSV
            </a>
            <a href="{{ route('learning.index') }}" class="btn btn-outline btn-sm" title="Lihat Materi Pembelajaran">
                📖 Halaman Materi
            </a>
        </div>
    </div>
</div>

<!-- 1. Statistik Kelas (Ringkasan Real-Time) -->
<div class="teacher-stat-cards">
    <div class="t-stat-card">
        <span class="t-stat-label">👥 Total Siswa Terdaftar</span>
        <span class="t-stat-val">{{ $classStats['total_students'] }} Siswa</span>
        <span style="font-size: 0.75rem; color: #4ade80; font-weight: 700;">
            ✅ {{ $classStats['total_with_account'] ?? $classStats['total_students'] }} Memiliki Akun Login
        </span>
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
    <div style="display: flex; align-items: center; gap: 0.8rem; margin-bottom: 1rem; flex-wrap: wrap;">
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

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1rem;">
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
            <button class="btn btn-outline btn-sm" style="font-size: 0.75rem; width: 100%; justify-content: center;" onclick="alert('Materi remedial telah dikirimkan ke modul siswa!')">
                Tugaskan Modul Latihan Tambahan
            </button>
        </div>
        @endforeach
    </div>
</div>

<!-- 3. Tabel Kelola Akun Siswa & Rekapitulasi Progres -->
<div class="glass-panel" id="tabelNilaiSection" style="margin-bottom: 2.5rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h3 style="font-family: var(--font-heading); font-size: 1.35rem; color: white; display: flex; align-items: center; gap: 0.5rem;">
                <span>👥</span> Rekapitulasi & Kelola Akun Siswa
            </h3>
            <p style="font-size: 0.85rem; color: var(--text-muted);">
                Guru dapat menambahkan akun baru untuk siswa, memantau username/email, mereset password, dan melacak perolehan nilai.
            </p>
        </div>
        <div style="display: flex; gap: 0.8rem; align-items: center; flex-wrap: wrap;">
            <button class="btn btn-primary btn-sm" onclick="openTambahSiswaModal()" style="background: linear-gradient(135deg, #10b981, #059669); border: none; font-weight: 700;">
                👤+ Tambah Akun Siswa
            </button>
            <input type="text" placeholder="Cari nama / username..." id="searchStudentInput" onkeyup="filterStudentTable()" style="padding: 0.55rem 1rem; border-radius: 12px; border: 1px solid var(--border-glass); background: rgba(15,23,42,0.8); color: white; font-size: 0.85rem; width: 220px;">
        </div>
    </div>

    <div class="table-responsive">
        <table class="data-table" id="studentGradeTable">
            <thead>
                <tr>
                    <th>Nama & Avatar</th>
                    <th>Akun Login (Username & Email)</th>
                    <th>Kelas</th>
                    <th>Rata-rata Nilai</th>
                    <th>Streak Harian</th>
                    <th>Total XP</th>
                    <th>Aksi Guru</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $st)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.65rem;">
                            <span style="font-size: 1.4rem; width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.08); border-radius: 10px;">
                                {{ $st['avatar'] ?? '🚀' }}
                            </span>
                            <div>
                                <div style="font-weight: 700; color: white; font-size: 0.95rem;">{{ $st['name'] }}</div>
                                <div style="font-size: 0.72rem; color: var(--text-muted);">{{ $st['status'] ?? 'Aktif' }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if(!empty($st['user']))
                            <div style="display: flex; flex-direction: column; gap: 0.2rem;">
                                <div style="font-size: 0.85rem; color: #38bdf8; font-weight: 700; font-family: monospace;">
                                    👤 {{ $st['user']['username'] }}
                                </div>
                                <div style="font-size: 0.75rem; color: #cbd5e1;">
                                    ✉️ {{ $st['user']['email'] }}
                                </div>
                            </div>
                        @else
                            <button class="btn btn-outline btn-sm" style="font-size: 0.72rem; padding: 0.25rem 0.6rem; color: #f59e0b; border-color: rgba(245,158,11,0.4);" onclick="openQuickCreateAccountModal('{{ addslashes($st['name']) }}', '{{ $st['class'] ?? 'Kelas 5-A' }}', '{{ $st['avatar'] ?? '🚀' }}')">
                                + Aktifkan Akun Login
                            </button>
                        @endif
                    </td>
                    <td style="color: #cbd5e1; font-size: 0.85rem;">
                        {{ $st['class'] ?? 'Kelas 5-A' }}
                    </td>
                    <td>
                        <span style="font-weight: 700; font-size: 0.95rem; color: {{ ($st['score'] ?? 0) >= 85 ? '#4ade80' : (($st['score'] ?? 0) >= 75 ? '#fbbf24' : '#f87171') }};">
                            {{ $st['score'] ?? 85 }}
                        </span>
                    </td>
                    <td>
                        <span style="font-size: 0.8rem; color: #fed7aa; font-weight: 600;">
                            🔥 {{ $st['streak'] ?? 1 }} Hari
                        </span>
                    </td>
                    <td style="color: #fef08a; font-weight: 700; font-size: 0.9rem;">
                        {{ $st['xp'] ?? 100 }} XP
                    </td>
                    <td>
                        <div style="display: flex; gap: 0.4rem; align-items: center;">
                            @if(!empty($st['user']))
                            <button class="btn btn-outline btn-sm" style="font-size: 0.75rem; padding: 0.35rem 0.65rem; border-color: rgba(56,189,248,0.4); color: #38bdf8;" onclick="openResetPasswordModal({{ $st['user']['id'] }}, '{{ addslashes($st['name']) }}', '{{ $st['user']['username'] }}')" title="Reset Sandi Akun Siswa">
                                🔑 Sandi
                            </button>
                            @endif
                            <button class="btn btn-sm" style="font-size: 0.75rem; padding: 0.35rem 0.65rem; background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3); color: #fca5a5;" onclick="confirmDeleteStudent({{ $st['user']['id'] ?? 'null' }}, {{ $st['id'] ?? 'null' }}, '{{ addslashes($st['name']) }}')" title="Hapus Siswa">
                                🗑️
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- 4. Tambah Materi yang Akan Diajar & Video YouTube -->
<div class="glass-panel" id="materiBuilderSection" style="margin-bottom: 2.5rem; border: 1px solid rgba(139,92,246,0.35); background: linear-gradient(135deg, rgba(30,27,75,0.4), rgba(15,23,42,0.85));">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 0.5rem;">
        <div>
            <h3 style="font-family: var(--font-heading); font-size: 1.35rem; color: white; display: flex; align-items: center; gap: 0.5rem;">
                <span>📚</span> Tambah Materi yang Akan Diajar & Video YouTube
            </h3>
            <p style="font-size: 0.88rem; color: #cbd5e1;">
                Tambahkan modul/materi pembelajaran baru untuk siswa lengkap dengan link video animasi YouTube dan konsep inti.
            </p>
        </div>
        <span style="font-size: 0.8rem; background: rgba(139,92,246,0.25); color: #c4b5fd; padding: 0.3rem 0.8rem; border-radius: 8px; font-weight: 700;">
            Portal Guru
        </span>
    </div>

    <form action="{{ route('guru.topic.store') }}" method="POST">
        @csrf
        <div class="teacher-form-grid" style="margin-bottom: 1.5rem;">
            <div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.4rem;">
                        Pilih Mata Pelajaran: <span style="color: #ef4444;">*</span>
                    </label>
                    <select name="subject_id" style="width: 100%; padding: 0.75rem; border-radius: 12px; background: #0f172a; border: 1px solid var(--border-glass); color: white;" required>
                        <option value="matematika">📐 Matematika</option>
                        <option value="ipa">🔬 IPA (Ilmu Pengetahuan Alam)</option>
                        <option value="ips">🌏 IPS (Ilmu Pengetahuan Sosial)</option>
                        <option value="bahasa-indonesia">📖 Bahasa Indonesia</option>
                        <option value="bahasa-inggris">🔤 Bahasa Inggris (English for Kids)</option>
                        <option value="coding">💻 Coding Dasar & Logika Komputer</option>
                    </select>
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.4rem;">
                        Judul Materi yang Akan Diajar: <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="text" name="title" placeholder="Contoh: Operasi Hitung Campuran Pecahan" style="width: 100%; padding: 0.75rem; border-radius: 12px; background: #0f172a; border: 1px solid var(--border-glass); color: white;" required>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.8rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.4rem;">
                            Tingkat Kesulitan:
                        </label>
                        <select name="difficulty" style="width: 100%; padding: 0.75rem; border-radius: 12px; background: #0f172a; border: 1px solid var(--border-glass); color: white;">
                            <option value="Mudah">Mudah</option>
                            <option value="Sedang" selected>Sedang</option>
                            <option value="Sulit">Sulit</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.4rem;">
                            Estimasi Waktu:
                        </label>
                        <input type="text" name="duration" value="4 Menit" placeholder="Contoh: 4 Menit" style="width: 100%; padding: 0.75rem; border-radius: 12px; background: #0f172a; border: 1px solid var(--border-glass); color: white;">
                    </div>
                </div>
            </div>

            <div>
                <!-- Video YouTube Box -->
                <div style="background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); border-radius: 16px; padding: 1.1rem; margin-bottom: 1rem;">
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.6rem;">
                        <span style="font-size: 1.2rem;">🎬</span>
                        <h4 style="color: white; font-size: 0.95rem; margin: 0; font-weight: 700;">
                            Sematkan Link Video YouTube
                        </h4>
                    </div>
                    <div style="margin-bottom: 0.8rem;">
                        <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #fca5a5; margin-bottom: 0.3rem;">
                            Link / URL Video YouTube:
                        </label>
                        <input type="url" name="video_url" placeholder="https://www.youtube.com/watch?v=... atau https://youtu.be/..." style="width: 100%; padding: 0.7rem; border-radius: 10px; background: #0f172a; border: 1px solid rgba(239,68,68,0.35); color: white;">
                        <span style="font-size: 0.72rem; color: #94a3b8; display: block; margin-top: 0.3rem;">
                            Video YouTube akan otomatis ditampilkan dalam pemutar video responsif di modul belajar siswa.
                        </span>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.6rem;">
                        <div>
                            <label style="display: block; font-size: 0.8rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.2rem;">
                                Judul Video:
                            </label>
                            <input type="text" name="video_title" placeholder="Contoh: Animasi Konsep" style="width: 100%; padding: 0.55rem; border-radius: 8px; background: #0f172a; border: 1px solid var(--border-glass); color: white; font-size: 0.85rem;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.8rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.2rem;">
                                Ringkasan Video:
                            </label>
                            <input type="text" name="video_desc" placeholder="Contoh: Tonton visualisasinya" style="width: 100%; padding: 0.55rem; border-radius: 8px; background: #0f172a; border: 1px solid var(--border-glass); color: white; font-size: 0.85rem;">
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 0.8rem; align-items: flex-end;">
                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; background: linear-gradient(135deg, #8b5cf6, #6366f1); border: none; font-weight: 700; padding: 0.85rem;">
                        🚀 Terbitkan Materi & Video Sekarang
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- 5. Pembuat Soal & Tugas Mandiri (Interactive Quiz Creator) -->
<div class="glass-panel" id="bankSoalSection" style="margin-bottom: 2.5rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 0.5rem;">
        <div>
            <h3 style="font-family: var(--font-heading); font-size: 1.3rem; color: white; display: flex; align-items: center; gap: 0.5rem;">
                <span>✍️</span> Pembuat Soal & Tugas Mandiri oleh Guru
            </h3>
            <p style="font-size: 0.85rem; color: var(--text-muted);">
                Tambahkan pertanyaan kuis baru atau buat tugas bertarget khusus untuk siswa Anda.
            </p>
        </div>
    </div>

    <form onsubmit="handleCreateQuestion(event)" class="teacher-form-grid" id="quizCreatorSection">
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
                    <option value="Coding">Coding Dasar (Informatika Anak)</option>
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

<!-- 6. Pengumuman dan Jadwal Tugas -->
<div class="glass-panel" id="pengumumanSection">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 0.5rem;">
        <h3 style="font-family: var(--font-heading); font-size: 1.3rem; color: white; display: flex; align-items: center; gap: 0.5rem;">
            <span>📢</span> Pengumuman & Jadwal Tugas Kelas
        </h3>
        <button class="btn btn-outline btn-sm" onclick="alert('Formulir tambah pengumuman baru terbuka!')">
            + Tambah Pengumuman
        </button>
    </div>

    <div class="announcements-grid">
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

<!-- =======================================================
     MODAL GURU: TAMBAH AKUN SISWA BARU
     ======================================================= -->
<div class="modal-overlay" id="modalTambahSiswa">
    <div class="modal-card" style="max-width: 620px;">
        <div class="modal-header">
            <h3 class="modal-title">
                <span>👤+</span> Tambah Akun Siswa Baru
            </h3>
            <button type="button" class="btn-modal-close" onclick="closeTambahSiswaModal()">✕</button>
        </div>
        <form action="{{ route('guru.student.store') }}" method="POST" id="formTambahSiswa">
            @csrf
            <div class="modal-body">
                <div style="background: rgba(16,185,129,0.12); border: 1px solid rgba(16,185,129,0.3); border-radius: 12px; padding: 0.8rem 1rem; margin-bottom: 1.25rem; font-size: 0.85rem; color: #a7f3d0;">
                    💡 <strong>Pembuatan Akun Siswa:</strong> Akun yang didaftarkan akan langsung aktif. Siswa dapat langsung login dengan <b>Username</b> atau <b>Email</b> dan password yang ditentukan.
                </div>

                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.4rem;">
                            Nama Lengkap Siswa: <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="text" name="name" id="newStudentName" placeholder="Contoh: Rizky Ramadhan" style="width: 100%; padding: 0.75rem; border-radius: 12px; background: #0f172a; border: 1px solid var(--border-glass); color: white;" oninput="autoGenerateCredentials(this.value)" required>
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.4rem;">
                            Kelas:
                        </label>
                        <select name="class" style="width: 100%; padding: 0.75rem; border-radius: 12px; background: #0f172a; border: 1px solid var(--border-glass); color: white;">
                            <option value="Kelas 4-A">Kelas 4-A</option>
                            <option value="Kelas 4-B">Kelas 4-B</option>
                            <option value="Kelas 5-A" selected>Kelas 5-A</option>
                            <option value="Kelas 5-B">Kelas 5-B</option>
                            <option value="Kelas 6-A">Kelas 6-A</option>
                            <option value="Kelas 6-B">Kelas 6-B</option>
                        </select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #38bdf8; margin-bottom: 0.4rem;">
                            Username Login: <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="text" name="username" id="newStudentUsername" placeholder="contoh: rizky" style="width: 100%; padding: 0.75rem; border-radius: 12px; background: #0f172a; border: 1px solid rgba(56,189,248,0.4); color: white; font-family: monospace;" required>
                        <span style="font-size: 0.72rem; color: var(--text-dim); margin-top: 0.25rem; display: block;">
                            Hanya huruf kecil, angka, atau tanda minus (-)
                        </span>
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.4rem;">
                            Email Siswa: <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="email" name="email" id="newStudentEmail" placeholder="contoh: rizky@sdsmadani.sch.id" style="width: 100%; padding: 0.75rem; border-radius: 12px; background: #0f172a; border: 1px solid var(--border-glass); color: white;" required>
                    </div>
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.4rem;">
                        Kata Sandi Awal (Password): <span style="color: #ef4444;">*</span>
                    </label>
                    <div style="position: relative;">
                        <input type="text" name="password" id="newStudentPassword" value="password123" placeholder="Minimal 6 karakter" style="width: 100%; padding: 0.75rem 2.8rem 0.75rem 0.8rem; border-radius: 12px; background: #0f172a; border: 1px solid var(--border-glass); color: white;" required>
                        <button type="button" onclick="togglePasswordVisibility('newStudentPassword', this)" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: transparent; border: none; color: var(--text-muted); cursor: pointer; font-size: 1rem;">👁️</button>
                    </div>
                    <span style="font-size: 0.75rem; color: #a5b4fc; margin-top: 0.25rem; display: block;">
                        Default: <code>password123</code> (Guru dapat memberitahukan ini ke siswa)
                    </span>
                </div>

                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.4rem;">
                        Pilih Karakter / Avatar Siswa:
                    </label>
                    <input type="hidden" name="avatar" id="newStudentAvatar" value="🚀">
                    <div class="avatar-picker-grid">
                        @php $avatars = ['🚀', '🦊', '🦁', '🐼', '🐱', '🦄', '🤖', '🌟', '🐬', '🦖']; @endphp
                        @foreach($avatars as $av)
                        <div class="avatar-pill {{ $av === '🚀' ? 'selected' : '' }}" onclick="selectAvatarOption('{{ $av }}', this)" title="Pilih {{ $av }}">
                            {{ $av }}
                        </div>
                        @endforeach
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.3rem;">
                            No. HP / WA Orang Tua (Opsional):
                        </label>
                        <input type="text" name="phone" placeholder="Contoh: 081234567890" style="width: 100%; padding: 0.65rem; border-radius: 10px; background: #0f172a; border: 1px solid var(--border-glass); color: white;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.3rem;">
                            Nilai Rata-rata Awal (Baseline):
                        </label>
                        <input type="number" name="score" value="85" min="0" max="100" style="width: 100%; padding: 0.65rem; border-radius: 10px; background: #0f172a; border: 1px solid var(--border-glass); color: white;">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline btn-sm" onclick="closeTambahSiswaModal()">Batal</button>
                <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #10b981, #059669); border: none; font-weight: 700;">
                    Simpan & Daftarkan Akun Siswa 🚀
                </button>
            </div>
        </form>
    </div>
</div>

<!-- =======================================================
     MODAL GURU: RESET PASSWORD AKUN SISWA
     ======================================================= -->
<div class="modal-overlay" id="modalResetPassword">
    <div class="modal-card" style="max-width: 480px;">
        <div class="modal-header">
            <h3 class="modal-title">
                <span>🔑</span> Reset Kata Sandi Siswa
            </h3>
            <button type="button" class="btn-modal-close" onclick="closeResetPasswordModal()">✕</button>
        </div>
        <form action="{{ route('guru.student.reset-password') }}" method="POST">
            @csrf
            <input type="hidden" name="user_id" id="resetUserId">
            <div class="modal-body">
                <p style="font-size: 0.9rem; color: #cbd5e1; margin-bottom: 1rem;">
                    Atur ulang kata sandi untuk siswa: <br>
                    <strong style="color: white; font-size: 1.05rem;" id="resetStudentNameDisplay">Doni Pratama</strong> 
                    <span style="color: #38bdf8; font-family: monospace;" id="resetStudentUsernameDisplay">(siswa)</span>
                </p>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #fca5a5; margin-bottom: 0.4rem;">
                        Kata Sandi Baru: <span style="color: #ef4444;">*</span>
                    </label>
                    <div style="position: relative;">
                        <input type="text" name="new_password" id="inputResetPassword" value="password123" placeholder="Minimal 6 karakter" style="width: 100%; padding: 0.75rem 2.8rem 0.75rem 0.8rem; border-radius: 12px; background: #0f172a; border: 1px solid rgba(56,189,248,0.4); color: white;" required>
                        <button type="button" onclick="togglePasswordVisibility('inputResetPassword', this)" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: transparent; border: none; color: var(--text-muted); cursor: pointer; font-size: 1rem;">👁️</button>
                    </div>
                    <span style="font-size: 0.75rem; color: var(--text-dim); margin-top: 0.3rem; display: block;">
                        Setelah disimpan, berikan kata sandi baru ini kepada siswa/wali murid.
                    </span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline btn-sm" onclick="closeResetPasswordModal()">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm" style="background: linear-gradient(135deg, #38bdf8, #0284c7); border: none; font-weight: 700;">
                    Simpan Sandi Baru 🔑
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Hidden Delete Form -->
<form id="deleteStudentForm" action="{{ route('guru.student.delete') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="user_id" id="deleteUserId">
    <input type="hidden" name="student_id" id="deleteStudentId">
</form>

@endsection

@section('scripts')
<script>
    function openTambahSiswaModal() {
        const modal = document.getElementById('modalTambahSiswa');
        if (modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
            setTimeout(() => {
                document.getElementById('newStudentName')?.focus();
            }, 100);
        }
    }

    function closeTambahSiswaModal() {
        const modal = document.getElementById('modalTambahSiswa');
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    function openResetPasswordModal(userId, name, username) {
        const modal = document.getElementById('modalResetPassword');
        if (modal) {
            document.getElementById('resetUserId').value = userId;
            document.getElementById('resetStudentNameDisplay').innerText = name;
            document.getElementById('resetStudentUsernameDisplay').innerText = `(${username})`;
            document.getElementById('inputResetPassword').value = 'password123';
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeResetPasswordModal() {
        const modal = document.getElementById('modalResetPassword');
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    function openQuickCreateAccountModal(name, studentClass, avatar) {
        openTambahSiswaModal();
        const nameInput = document.getElementById('newStudentName');
        if (nameInput) {
            nameInput.value = name;
            autoGenerateCredentials(name);
        }
    }

    function autoGenerateCredentials(name) {
        if (!name) return;
        const cleanName = name.trim().toLowerCase();
        // Take first word or alphanumeric slug
        const slug = cleanName
            .replace(/[^a-z0-9\s]/g, '')
            .split(' ')[0] || 'siswa';
        
        const usernameInput = document.getElementById('newStudentUsername');
        const emailInput = document.getElementById('newStudentEmail');

        if (usernameInput) usernameInput.value = slug;
        if (emailInput) emailInput.value = `${slug}@sdsmadani.sch.id`;
    }

    function selectAvatarOption(emoji, element) {
        document.getElementById('newStudentAvatar').value = emoji;
        document.querySelectorAll('.avatar-pill').forEach(el => el.classList.remove('selected'));
        element.classList.add('selected');
    }

    function togglePasswordVisibility(inputId, btn) {
        const inp = document.getElementById(inputId);
        if (inp) {
            if (inp.type === 'password') {
                inp.type = 'text';
                btn.innerText = '🔒';
            } else {
                inp.type = 'password';
                btn.innerText = '👁️';
            }
        }
    }

    function confirmDeleteStudent(userId, studentId, name) {
        if (confirm(`Apakah Ibu/Bapak Guru yakin ingin menghapus siswa "${name}" beserta akun loginnya?`)) {
            const form = document.getElementById('deleteStudentForm');
            document.getElementById('deleteUserId').value = userId || '';
            document.getElementById('deleteStudentId').value = studentId || '';
            form.submit();
        }
    }

    function scrollToMateriBuilder() {
        const el = document.getElementById('materiBuilderSection');
        if (el) el.scrollIntoView({ behavior: 'smooth' });
    }

    function scrollToQuizBuilder() {
        const el = document.getElementById('bankSoalSection');
        if (el) el.scrollIntoView({ behavior: 'smooth' });
    }

    function filterStudentTable() {
        const input = document.getElementById('searchStudentInput').value.toLowerCase();
        const rows = document.querySelectorAll('#studentGradeTable tbody tr');
        rows.forEach(r => {
            const text = r.innerText.toLowerCase();
            r.style.display = text.includes(input) ? '' : 'none';
        });
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

    // Modal click outside to close
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                overlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    });

    // Close on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay.active').forEach(m => {
                m.classList.remove('active');
            });
            document.body.style.overflow = '';
        }
    });
</script>
@endsection
