@extends('layouts.app')

@section('title', 'Masuk ke Portal | SDS Madani E-Learning SD Kelas 4-6')

@section('styles')
<style>
/* Login View Specific Styles */
.auth-page-wrapper {
    min-height: calc(100vh - 140px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2.5rem 1.25rem;
    position: relative;
    z-index: 10;
}

.auth-container {
    width: 100%;
    max-width: 1100px;
    display: grid;
    grid-template-columns: 1.15fr 0.85fr;
    background: rgba(15, 23, 42, 0.82);
    border: 1px solid var(--border-glass);
    border-radius: 28px;
    box-shadow: 0 25px 60px -15px rgba(2, 6, 23, 0.7), 0 0 40px rgba(99, 102, 241, 0.15);
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    overflow: hidden;
}

/* Form Column */
.auth-form-column {
    padding: 2.75rem 2.5rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.auth-brand-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(99, 102, 241, 0.15);
    border: 1px solid rgba(99, 102, 241, 0.35);
    padding: 0.35rem 0.85rem;
    border-radius: 999px;
    font-size: 0.78rem;
    font-weight: 700;
    color: #a5b4fc;
    margin-bottom: 1rem;
    width: fit-content;
}

.auth-heading {
    font-family: var(--font-heading);
    font-size: 2.1rem;
    font-weight: 700;
    color: #ffffff;
    line-height: 1.25;
    margin-bottom: 0.5rem;
}

.auth-subheading {
    color: var(--text-muted);
    font-size: 0.95rem;
    margin-bottom: 1.8rem;
    line-height: 1.5;
}

/* Role Selector Tabs */
.role-tabs {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0.6rem;
    background: rgba(2, 6, 23, 0.6);
    padding: 0.4rem;
    border-radius: 16px;
    border: 1px solid var(--border-glass);
    margin-bottom: 1.8rem;
}

.role-tab-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.25rem;
    padding: 0.7rem 0.5rem;
    border-radius: 12px;
    border: 1px solid transparent;
    background: transparent;
    color: var(--text-muted);
    cursor: pointer;
    font-family: var(--font-body);
    font-size: 0.82rem;
    font-weight: 600;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

.role-tab-btn .role-icon {
    font-size: 1.4rem;
    transition: transform 0.2s ease;
}

.role-tab-btn:hover {
    color: #ffffff;
    background: rgba(255, 255, 255, 0.05);
}

.role-tab-btn:hover .role-icon {
    transform: scale(1.15);
}

.role-tab-btn.active {
    background: rgba(99, 102, 241, 0.22);
    color: #ffffff;
    border-color: rgba(99, 102, 241, 0.5);
    box-shadow: 0 4px 15px rgba(99, 102, 241, 0.25);
}

.role-tab-btn.active.role-siswa {
    background: rgba(59, 130, 246, 0.22);
    border-color: rgba(59, 130, 246, 0.5);
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.25);
}

.role-tab-btn.active.role-guru {
    background: rgba(139, 92, 246, 0.22);
    border-color: rgba(139, 92, 246, 0.5);
    box-shadow: 0 4px 15px rgba(139, 92, 246, 0.25);
}

.role-tab-btn.active.role-orang_tua {
    background: rgba(16, 185, 129, 0.22);
    border-color: rgba(16, 185, 129, 0.5);
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.25);
}

/* Alert Boxes */
.auth-alert {
    padding: 0.85rem 1rem;
    border-radius: 12px;
    font-size: 0.88rem;
    line-height: 1.45;
    margin-bottom: 1.25rem;
    display: flex;
    align-items: flex-start;
    gap: 0.6rem;
}

.auth-alert-danger {
    background: rgba(239, 68, 68, 0.15);
    border: 1px solid rgba(239, 68, 68, 0.4);
    color: #fca5a5;
}

.auth-alert-warning {
    background: rgba(245, 158, 11, 0.15);
    border: 1px solid rgba(245, 158, 11, 0.4);
    color: #fcd34d;
}

.auth-alert-info {
    background: rgba(59, 130, 246, 0.15);
    border: 1px solid rgba(59, 130, 246, 0.4);
    color: #93c5fd;
}

.auth-alert-success {
    background: rgba(16, 185, 129, 0.15);
    border: 1px solid rgba(16, 185, 129, 0.4);
    color: #86efac;
}

/* Input Form Controls */
.form-group {
    margin-bottom: 1.25rem;
}

.form-label {
    display: block;
    font-size: 0.85rem;
    font-weight: 600;
    color: #cbd5e1;
    margin-bottom: 0.45rem;
}

.input-with-icon {
    position: relative;
    display: flex;
    align-items: center;
}

.input-icon-left {
    position: absolute;
    left: 1rem;
    font-size: 1.1rem;
    color: var(--text-muted);
    pointer-events: none;
}

.form-input-text {
    width: 100%;
    background: rgba(2, 6, 23, 0.55);
    border: 1px solid var(--border-glass);
    border-radius: 14px;
    padding: 0.85rem 1rem 0.85rem 2.85rem;
    color: #ffffff;
    font-family: var(--font-body);
    font-size: 0.95rem;
    transition: all 0.2s ease;
}

.form-input-text:focus {
    outline: none;
    border-color: #818cf8;
    background: rgba(2, 6, 23, 0.75);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.25);
}

.form-input-text.has-toggle {
    padding-right: 2.85rem;
}

.btn-toggle-pwd {
    position: absolute;
    right: 0.85rem;
    background: transparent;
    border: none;
    color: var(--text-muted);
    cursor: pointer;
    font-size: 1.15rem;
    padding: 0.3rem;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: color 0.2s ease;
}

.btn-toggle-pwd:hover {
    color: #ffffff;
}

.form-meta-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
    font-size: 0.85rem;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-muted);
    cursor: pointer;
    user-select: none;
}

.checkbox-label input {
    accent-color: var(--primary);
    width: 16px;
    height: 16px;
    cursor: pointer;
}

.btn-auth-submit {
    width: 100%;
    padding: 0.95rem 1.5rem;
    border-radius: 14px;
    font-family: var(--font-body);
    font-size: 1rem;
    font-weight: 700;
    color: #ffffff;
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    border: none;
    cursor: pointer;
    box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.45);
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.6rem;
}

.btn-auth-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 30px -5px rgba(99, 102, 241, 0.6);
    filter: brightness(1.08);
}

.btn-auth-submit:active {
    transform: translateY(0);
}

/* Quick 1-Click Role Login Bar */
.quick-login-divider {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin: 1.75rem 0 1.25rem 0;
    color: var(--text-dim);
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.quick-login-divider::before,
.quick-login-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: rgba(255, 255, 255, 0.1);
}

.quick-role-buttons {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0.6rem;
}

.btn-quick-role {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.45rem;
    padding: 0.7rem 0.6rem;
    border-radius: 12px;
    background: rgba(30, 41, 59, 0.6);
    border: 1px solid var(--border-glass);
    color: #e2e8f0;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    text-align: center;
}

.btn-quick-role:hover {
    background: rgba(51, 65, 85, 0.8);
    transform: translateY(-2px);
    border-color: rgba(255, 255, 255, 0.25);
}

.btn-quick-role.role-siswa:hover {
    border-color: #3b82f6;
    color: #93c5fd;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.25);
}

.btn-quick-role.role-guru:hover {
    border-color: #8b5cf6;
    color: #c4b5fd;
    box-shadow: 0 4px 15px rgba(139, 92, 246, 0.25);
}

.btn-quick-role.role-orang_tua:hover {
    border-color: #10b981;
    color: #a7f3d0;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.25);
}

/* Sidebar Info Column */
.auth-info-column {
    background: linear-gradient(160deg, rgba(30, 41, 59, 0.7) 0%, rgba(15, 23, 42, 0.9) 100%);
    border-left: 1px solid var(--border-glass);
    padding: 2.75rem 2.25rem;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.role-info-card {
    transition: all 0.3s ease;
}

.role-info-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.25rem;
}

.role-info-avatar {
    width: 58px;
    height: 58px;
    border-radius: 18px;
    background: rgba(99, 102, 241, 0.2);
    border: 1px solid rgba(99, 102, 241, 0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    box-shadow: 0 8px 20px rgba(99, 102, 241, 0.2);
}

.role-info-title {
    font-family: var(--font-heading);
    font-size: 1.35rem;
    font-weight: 700;
    color: #ffffff;
}

.role-info-subtitle {
    font-size: 0.85rem;
    color: var(--text-muted);
}

.role-info-desc {
    color: #cbd5e1;
    font-size: 0.9rem;
    line-height: 1.55;
    margin-bottom: 1.5rem;
}

.role-feature-list {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 0.8rem;
    margin-bottom: 2rem;
}

.role-feature-item {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    font-size: 0.87rem;
    color: #e2e8f0;
}

.role-feature-item .check-icon {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: rgba(34, 197, 94, 0.2);
    border: 1px solid rgba(34, 197, 94, 0.4);
    color: #4ade80;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    flex-shrink: 0;
}

.demo-credentials-box {
    background: rgba(2, 6, 23, 0.7);
    border: 1px dashed rgba(255, 255, 255, 0.18);
    border-radius: 16px;
    padding: 1.1rem;
    font-size: 0.82rem;
}

.demo-cred-row {
    display: flex;
    justify-content: space-between;
    padding: 0.25rem 0;
    color: #cbd5e1;
}

.demo-cred-row strong {
    color: #ffffff;
    font-family: monospace;
    letter-spacing: 0.3px;
}

/* Responsive adjustments */
@media (max-width: 960px) {
    .auth-container {
        grid-template-columns: 1fr;
        max-width: 580px;
        margin: 0 auto;
    }
    .auth-info-column {
        border-left: none;
        border-top: 1px solid var(--border-glass);
        padding: 2rem 1.75rem;
    }
    .auth-form-column {
        padding: 2.25rem 1.75rem;
    }
}

@media (max-width: 640px) {
    .auth-page-wrapper {
        padding: 1.25rem 0.75rem;
    }
    .auth-heading {
        font-size: 1.75rem;
    }
    .role-tabs {
        grid-template-columns: 1fr;
        gap: 0.4rem;
    }
    .role-tab-btn {
        flex-direction: row;
        justify-content: flex-start;
        padding: 0.65rem 0.9rem;
    }
    .quick-role-buttons {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection

@section('content')
<div class="auth-page-wrapper">
    <div class="auth-container">
        <!-- Main Form Column -->
        <div class="auth-form-column">
            <div class="auth-brand-badge">
                <span>🔐</span> Sistem Masuk Terpadu
            </div>

            <h1 class="auth-heading" id="formHeaderTitle">Masuk ke Portal</h1>
            <p class="auth-subheading" id="formHeaderSubtitle">
                Pilih peran Anda untuk diarahkan ke tampilan antarmuka yang sesuai.
            </p>

            <!-- Flash Alert Messages -->
            @if(session('success'))
                <div class="auth-alert auth-alert-success">
                    <span>✅</span>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if(session('warning'))
                <div class="auth-alert auth-alert-warning">
                    <span>⚠️</span>
                    <div>{{ session('warning') }}</div>
                </div>
            @endif

            @if(session('info'))
                <div class="auth-alert auth-alert-info">
                    <span>ℹ️</span>
                    <div>{{ session('info') }}</div>
                </div>
            @endif

            @if(isset($errors) && $errors->any())
                <div class="auth-alert auth-alert-danger">
                    <span>❌</span>
                    <div>
                        @foreach($errors->all() as $err)
                            <div>{{ $err }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Role Selector Tabs -->
            <div class="role-tabs">
                <button type="button" class="role-tab-btn active role-siswa" onclick="selectRole('siswa')" id="tabSiswa">
                    <span class="role-icon">🎒</span>
                    <span>Siswa</span>
                </button>
                <button type="button" class="role-tab-btn role-guru" onclick="selectRole('guru')" id="tabGuru">
                    <span class="role-icon">👨‍🏫</span>
                    <span>Guru</span>
                </button>
                <button type="button" class="role-tab-btn role-orang_tua" onclick="selectRole('orang_tua')" id="tabOrangTua">
                    <span class="role-icon">👨‍👩‍👧</span>
                    <span>Orang Tua</span>
                </button>
            </div>

            <!-- Standard Credentials Login Form -->
            <form action="{{ route('login.perform') }}" method="POST" id="mainLoginForm">
                @csrf
                <input type="hidden" name="selected_role" id="inputSelectedRole" value="siswa">

                <div class="form-group">
                    <label class="form-label" for="loginInput" id="labelLoginInput">Email atau Username Siswa</label>
                    <div class="input-with-icon">
                        <span class="input-icon-left" id="iconLoginInput">🎒</span>
                        <input type="text"
                               name="login"
                               id="loginInput"
                               class="form-input-text"
                               placeholder="Contoh: siswa@sdsmadani.sch.id atau siswa"
                               value="{{ old('login', 'siswa@sdsmadani.sch.id') }}"
                               required
                               autocomplete="username">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="passwordInput">Kata Sandi</label>
                    <div class="input-with-icon">
                        <span class="input-icon-left">🔒</span>
                        <input type="password"
                               name="password"
                               id="passwordInput"
                               class="form-input-text has-toggle"
                               placeholder="Masukkan kata sandi..."
                               value="password123"
                               required
                               autocomplete="current-password">
                        <button type="button" class="btn-toggle-pwd" onclick="togglePasswordVisibility()" title="Lihat/Sembunyikan Sandi">
                            <span id="eyeIcon">👁️</span>
                        </button>
                    </div>
                </div>

                <div class="form-meta-row">
                    <label class="checkbox-label">
                        <input type="checkbox" name="remember" value="1" checked>
                        <span>Ingat saya di perangkat ini</span>
                    </label>
                    <span style="font-size: 0.8rem; color: #a5b4fc; cursor: pointer;" onclick="autofillCurrentRole()">
                        ⚡ Isi Sandi Demo
                    </span>
                </div>

                <button type="submit" class="btn-auth-submit" id="btnSubmitLogin">
                    <span>🚀 Masuk Sekarang</span>
                </button>
            </form>

            <!-- Quick 1-Click Role Login for instant switching -->
            <div class="quick-login-divider">
                <span>Atau Masuk Cepat 1-Klik (Demo)</span>
            </div>

            <div class="quick-role-buttons">
                <form action="{{ route('login.quick') }}" method="POST" style="margin: 0;">
                    @csrf
                    <input type="hidden" name="role" value="siswa">
                    <button type="submit" class="btn-quick-role role-siswa" title="Masuk langsung sebagai Siswa Doni Pratama">
                        <span>🎒</span> Siswa (Doni)
                    </button>
                </form>

                <form action="{{ route('login.quick') }}" method="POST" style="margin: 0;">
                    @csrf
                    <input type="hidden" name="role" value="guru">
                    <button type="submit" class="btn-quick-role role-guru" title="Masuk langsung sebagai Guru Bu Rahmawati">
                        <span>👨‍🏫</span> Guru (Rahmawati)
                    </button>
                </form>

                <form action="{{ route('login.quick') }}" method="POST" style="margin: 0;">
                    @csrf
                    <input type="hidden" name="role" value="orang_tua">
                    <button type="submit" class="btn-quick-role role-orang_tua" title="Masuk langsung sebagai Orang Tua Bunda Doni">
                        <span>👨‍👩‍👧</span> Orang Tua (Bunda)
                    </button>
                </form>
            </div>
        </div>

        <!-- Sidebar Role Explanation Column -->
        <div class="auth-info-column">
            <div>
                <div class="role-info-card" id="infoCardBox">
                    <div class="role-info-header">
                        <div class="role-info-avatar" id="infoAvatar">🚀</div>
                        <div>
                            <h2 class="role-info-title" id="infoTitle">Portal Siswa</h2>
                            <p class="role-info-subtitle" id="infoBadge">SD Kelas 4 - 6</p>
                        </div>
                    </div>

                    <p class="role-info-desc" id="infoDesc">
                        Tampilan ramah anak dirancang dengan elemen gamifikasi, pengumpulan XP, kenaikan level avatar, kuis harian 10 soal, dan mini games berhitung cepat.
                    </p>

                    <div style="font-size: 0.82rem; font-weight: 700; color: #a5b4fc; margin-bottom: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">
                        Fitur Utama Tampilan Ini:
                    </div>

                    <ul class="role-feature-list" id="infoFeaturesList">
                        <li class="role-feature-item">
                            <span class="check-icon">✓</span>
                            <span>Materi 5 Mata Pelajaran Inti Interaktif</span>
                        </li>
                        <li class="role-feature-item">
                            <span class="check-icon">✓</span>
                            <span>Kuis Harian 10 Soal Berhadiah +100 XP</span>
                        </li>
                        <li class="role-feature-item">
                            <span class="check-icon">✓</span>
                            <span>Peringkat Kelas & Koleksi Lencana Bintang</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Demo Account Credentials Box -->
            <div class="demo-credentials-box">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span style="font-weight: 700; color: #f8fafc;">📋 Akun Demo Terverifikasi:</span>
                    <span style="font-size: 0.72rem; color: #38bdf8; cursor: pointer;" onclick="autofillCurrentRole()">Terapkan ke Form ↗</span>
                </div>
                <div class="demo-cred-row">
                    <span>Email / User:</span>
                    <strong id="demoCredIdentifier">siswa@sdsmadani.sch.id</strong>
                </div>
                <div class="demo-cred-row">
                    <span>Kata Sandi:</span>
                    <strong>password123</strong>
                </div>
                <div class="demo-cred-row" style="border-top: 1px dashed rgba(255,255,255,0.1); margin-top: 0.4rem; padding-top: 0.4rem;">
                    <span>Tujuan Tampilan:</span>
                    <strong id="demoCredTarget" style="color: #38bdf8;">Beranda Pembelajaran Siswa</strong>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const roleData = {
        'siswa': {
            title: 'Portal Siswa',
            badge: 'Siswa Kelas 5-A SDS Madani',
            avatar: '🚀',
            desc: 'Tampilan ramah anak dirancang dengan gamifikasi, pengumpulan XP, kenaikan level avatar, kuis harian 10 soal, dan petualangan belajar 5 mata pelajaran inti.',
            features: [
                'Materi 5 Mata Pelajaran Inti Interaktif',
                'Kuis Harian 10 Soal Berhadiah +100 XP',
                'Peringkat Kelas & Koleksi Lencana Bintang'
            ],
            email: 'siswa@sdsmadani.sch.id',
            username: 'siswa',
            target: 'Beranda Pembelajaran Siswa',
            icon: '🎒',
            color: '#3b82f6',
            placeholder: 'Contoh: siswa@sdsmadani.sch.id atau siswa'
        },
        'guru': {
            title: 'Portal Pengajar Guru',
            badge: 'Wali Kelas & Guru Pengajar 5-A',
            avatar: '👨‍🏫',
            desc: 'Panel kontrol komprehensif bagi bapak/ibu guru untuk meninjau statistik nilai kelas, menganalisis topik yang sulit bagi siswa, menambah bank soal baru, dan mengunduh rekap CSV.',
            features: [
                'Bank Soal Interaktif (Buat & Publikasi Soal)',
                'Analisis Otomatis Topik Sulit Kelas',
                'Ekspor Rekapitulasi Nilai Siswa (CSV/Excel)'
            ],
            email: 'guru@sdsmadani.sch.id',
            username: 'guru',
            target: 'Dashboard Guru (/guru)',
            icon: '👨‍🏫',
            color: '#8b5cf6',
            placeholder: 'Contoh: guru@sdsmadani.sch.id atau guru'
        },
        'orang_tua': {
            title: 'Portal Orang Tua Murid',
            badge: 'Orang Tua Doni Pratama (Kelas 5-A)',
            avatar: '👨‍👩‍👧',
            desc: 'Portal pendampingan ayah & bunda untuk memantau durasi waktu belajar layar ananda, menyetel batas screen time dengan PIN, serta melihat progres nilai tiap mata pelajaran.',
            features: [
                'Pengatur Batas Waktu Layar Belajar (Screen Time)',
                'Grafik Rapor & Pantauan Kelemahan Belajar',
                'Simulasi Laporan Notifikasi Belajar via WhatsApp'
            ],
            email: 'orangtua@sdsmadani.sch.id',
            username: 'orangtua',
            target: 'Portal Orang Tua (/orang-tua)',
            icon: '👨‍👩‍👧',
            color: '#10b981',
            placeholder: 'Contoh: orangtua@sdsmadani.sch.id atau orangtua'
        }
    };

    let currentSelectedRole = 'siswa';

    function selectRole(role) {
        currentSelectedRole = role;
        document.getElementById('inputSelectedRole').value = role;

        // Update tabs active state
        document.getElementById('tabSiswa').className = 'role-tab-btn ' + (role === 'siswa' ? 'active role-siswa' : '');
        document.getElementById('tabGuru').className = 'role-tab-btn ' + (role === 'guru' ? 'active role-guru' : '');
        document.getElementById('tabOrangTua').className = 'role-tab-btn ' + (role === 'orang_tua' ? 'active role-orang_tua' : '');

        const data = roleData[role];
        if (!data) return;

        // Update sidebar info
        document.getElementById('infoAvatar').innerText = data.avatar;
        document.getElementById('infoTitle').innerText = data.title;
        document.getElementById('infoBadge').innerText = data.badge;
        document.getElementById('infoDesc').innerText = data.desc;

        // Update features
        const featList = document.getElementById('infoFeaturesList');
        featList.innerHTML = '';
        data.features.forEach(f => {
            const li = document.createElement('li');
            li.className = 'role-feature-item';
            li.innerHTML = `<span class="check-icon">✓</span><span>${f}</span>`;
            featList.appendChild(li);
        });

        // Update demo creds box
        document.getElementById('demoCredIdentifier').innerText = data.email;
        document.getElementById('demoCredTarget').innerText = data.target;

        // Update form input label & placeholder
        const label = document.getElementById('labelLoginInput');
        const icon = document.getElementById('iconLoginInput');
        const input = document.getElementById('loginInput');
        
        label.innerText = `Email atau Username ${data.title.replace('Portal ', '')}`;
        icon.innerText = data.icon;
        input.placeholder = data.placeholder;
        input.value = data.email;

        // Button submit styling
        const btnSubmit = document.getElementById('btnSubmitLogin');
        btnSubmit.innerHTML = `<span>${data.icon} Masuk Sebagai ${data.title.replace('Portal ', '')}</span>`;
    }

    function autofillCurrentRole() {
        const data = roleData[currentSelectedRole];
        if (!data) return;
        document.getElementById('loginInput').value = data.email;
        document.getElementById('passwordInput').value = 'password123';
    }

    function togglePasswordVisibility() {
        const pwd = document.getElementById('passwordInput');
        const icon = document.getElementById('eyeIcon');
        if (pwd.type === 'password') {
            pwd.type = 'text';
            icon.innerText = '🙈';
        } else {
            pwd.type = 'password';
            icon.innerText = '👁️';
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Init with default role
        selectRole('siswa');
    });
</script>
@endsection
