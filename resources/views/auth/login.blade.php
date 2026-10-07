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
    background: rgba(15, 23, 42, 0.85);
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
    margin-bottom: 0.5rem;
    width: fit-content;
}

.auth-heading {
    font-family: var(--font-heading);
    font-size: 2.1rem;
    font-weight: 700;
    color: #ffffff;
    line-height: 1.25;
    margin-bottom: 0.35rem;
}

.auth-subheading {
    color: var(--text-muted);
    font-size: 0.92rem;
    margin-bottom: 1.5rem;
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
    margin-bottom: 1.25rem;
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
    border-color: rgba(59, 130, 246, 0.6);
    background: rgba(59, 130, 246, 0.2);
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.25);
}

.role-tab-btn.active.role-guru {
    border-color: rgba(139, 92, 246, 0.6);
    background: rgba(139, 92, 246, 0.2);
    box-shadow: 0 4px 15px rgba(139, 92, 246, 0.25);
}

.role-tab-btn.active.role-orang_tua {
    border-color: rgba(16, 185, 129, 0.6);
    background: rgba(16, 185, 129, 0.2);
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.25);
}

/* Demo Mode Gating Control Bar */
.demo-gate-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: rgba(30, 41, 59, 0.4);
    border: 1px solid var(--border-glass);
    padding: 0.65rem 1rem;
    border-radius: 14px;
    margin-bottom: 1.5rem;
    transition: all 0.3s ease;
}

.demo-gate-bar.active {
    background: rgba(99, 102, 241, 0.14);
    border-color: rgba(99, 102, 241, 0.45);
    box-shadow: 0 0 20px rgba(99, 102, 241, 0.2);
}

.demo-gate-info {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    flex-wrap: wrap;
}

.demo-badge-pulse {
    font-size: 0.72rem;
    font-weight: 700;
    color: #fbbf24;
    background: rgba(245, 158, 11, 0.15);
    border: 1px solid rgba(245, 158, 11, 0.35);
    padding: 0.2rem 0.55rem;
    border-radius: 999px;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
}

.demo-gate-text {
    font-size: 0.78rem;
    color: var(--text-muted);
    font-weight: 500;
}

/* Switch Toggle UI */
.demo-switch {
    position: relative;
    display: inline-block;
    width: 44px;
    height: 24px;
    flex-shrink: 0;
}

.demo-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.demo-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(71, 85, 105, 0.6);
    transition: .3s cubic-bezier(0.4, 0, 0.2, 1);
    border-radius: 24px;
    border: 1px solid rgba(255, 255, 255, 0.15);
}

.demo-slider:before {
    position: absolute;
    content: "";
    height: 16px;
    width: 16px;
    left: 3px;
    bottom: 3px;
    background-color: #ffffff;
    transition: .3s cubic-bezier(0.4, 0, 0.2, 1);
    border-radius: 50%;
    box-shadow: 0 2px 5px rgba(0,0,0,0.3);
}

.demo-switch input:checked + .demo-slider {
    background-color: #6366f1;
    border-color: #818cf8;
    box-shadow: 0 0 12px rgba(99, 102, 241, 0.5);
}

.demo-switch input:checked + .demo-slider:before {
    transform: translateX(20px);
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

/* Form Meta Row (Remember Me & Forgot Password) */
.form-meta-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
    font-size: 0.85rem;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 0.55rem;
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

.btn-forgot-link {
    background: transparent;
    border: none;
    color: #818cf8;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s ease;
    padding: 0;
    font-family: var(--font-body);
}

.btn-forgot-link:hover {
    color: #a5b4fc;
    text-decoration: underline;
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

/* Quick 1-Click Role Login Bar (Gated by Demo Mode) */
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
    margin-bottom: 1.5rem;
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

/* Demo Credentials Box */
.demo-credentials-box {
    background: rgba(2, 6, 23, 0.7);
    border: 1px dashed rgba(255, 255, 255, 0.18);
    border-radius: 16px;
    padding: 1.1rem;
    font-size: 0.82rem;
    animation: fadeIn 0.3s ease;
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

/* School Notice Box (Shown when Demo Mode is OFF) */
.school-notice-box {
    background: rgba(15, 23, 42, 0.75);
    border: 1px solid var(--border-glass);
    border-radius: 16px;
    padding: 1.15rem;
    font-size: 0.84rem;
    animation: fadeIn 0.3s ease;
}

.school-notice-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #ffffff;
    font-weight: 700;
    margin-bottom: 0.4rem;
}

.school-notice-desc {
    color: var(--text-muted);
    font-size: 0.82rem;
    line-height: 1.5;
    margin-bottom: 0.8rem;
}

.school-notice-contact {
    display: flex;
    align-items: center;
    gap: 0.45rem;
    font-size: 0.76rem;
    color: #a5b4fc;
    font-weight: 600;
}

/* Alerts */
.auth-alert {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.85rem 1rem;
    border-radius: 14px;
    font-size: 0.88rem;
    margin-bottom: 1.25rem;
}

.auth-alert-danger {
    background: rgba(239, 68, 68, 0.15);
    border: 1px solid rgba(239, 68, 68, 0.4);
    color: #fca5a5;
}

.auth-alert-success {
    background: rgba(16, 185, 129, 0.15);
    border: 1px solid rgba(16, 185, 129, 0.4);
    color: #86efac;
}

.auth-alert-warning {
    background: rgba(245, 158, 11, 0.15);
    border: 1px solid rgba(245, 158, 11, 0.4);
    color: #fde68a;
}

.auth-alert-info {
    background: rgba(59, 130, 246, 0.15);
    border: 1px solid rgba(59, 130, 246, 0.4);
    color: #93c5fd;
}

/* Modal Popup Styles */
.modal-backdrop-custom {
    position: fixed;
    inset: 0;
    background: rgba(2, 6, 23, 0.82);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    z-index: 99999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 1.25rem;
    opacity: 0;
    transition: opacity 0.25s ease;
}

.modal-backdrop-custom.active {
    display: flex;
    opacity: 1;
}

.modal-card-custom {
    background: #0f172a;
    border: 1px solid var(--border-glass);
    border-radius: 24px;
    width: 100%;
    max-width: 520px;
    box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.8), 0 0 35px rgba(99, 102, 241, 0.25);
    overflow: hidden;
    transform: scale(0.95);
    transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.modal-backdrop-custom.active .modal-card-custom {
    transform: scale(1);
}

.modal-card-header {
    padding: 1.4rem 1.6rem;
    border-bottom: 1px solid var(--border-glass);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.btn-modal-close {
    background: rgba(255, 255, 255, 0.08);
    border: none;
    color: #cbd5e1;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    font-size: 1.2rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.btn-modal-close:hover {
    background: rgba(255, 255, 255, 0.2);
    color: #fff;
}

.modal-card-body {
    padding: 1.5rem 1.6rem;
    display: flex;
    flex-direction: column;
    gap: 0.9rem;
}

.role-help-pill {
    padding: 0.85rem 1rem;
    border-radius: 14px;
    font-size: 0.85rem;
    line-height: 1.55;
}

.role-help-siswa {
    background: rgba(59, 130, 246, 0.12);
    border: 1px solid rgba(59, 130, 246, 0.3);
    color: #bfdbfe;
}

.role-help-guru {
    background: rgba(139, 92, 246, 0.12);
    border: 1px solid rgba(139, 92, 246, 0.3);
    color: #ddd6fe;
}

.pill-title {
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 0.35rem;
    display: flex;
    align-items: center;
    gap: 0.45rem;
}

.contact-support-box {
    background: rgba(2, 6, 23, 0.7);
    border: 1px solid var(--border-glass);
    border-radius: 14px;
    padding: 0.95rem 1.1rem;
}

.modal-card-footer {
    padding: 1rem 1.6rem;
    border-top: 1px solid var(--border-glass);
    background: rgba(2, 6, 23, 0.4);
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
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
            <!-- Official School Header -->
            <div class="auth-header-with-logo" style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.25rem;">
                <div class="login-brand-logo-box" style="width: 54px; height: 54px; border-radius: 50%; background: #ffffff; padding: 2px; box-shadow: 0 0 20px rgba(99, 102, 241, 0.4), 0 4px 10px rgba(0,0,0,0.3); flex-shrink: 0; display: flex; align-items: center; justify-content: center; border: 1.5px solid rgba(255,255,255,0.9);">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo SDS Madani" style="width: 100%; height: 100%; object-fit: contain; border-radius: 50%;">
                </div>
                <div>
                    <div class="auth-brand-badge">
                        <span>🏫</span> Portal Resmi SDS Madani Pontianak
                    </div>
                    <div style="font-size: 0.72rem; font-weight: 700; color: #a5b4fc; letter-spacing: 0.8px;">SEKOLAH DASAR SWASTA AL-MADANI</div>
                </div>
            </div>

            <h1 class="auth-heading" id="formHeaderTitle">Masuk ke Portal</h1>
            <p class="auth-subheading" id="formHeaderSubtitle">
                Silakan pilih peran dan masukkan kredensial akun Anda.
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

            <!-- Demo Mode Gating Control Switch Bar -->
            <div class="demo-gate-bar" id="demoGateBar">
                <div class="demo-gate-info">
                    <span class="demo-badge-pulse" id="demoBadgePulse">⚡ Mode Demo</span>
                    <span class="demo-gate-text" id="demoGateText">Login cepat 1-klik & panduan simulasi</span>
                </div>
                <div style="display: flex; align-items: center; gap: 0.55rem;">
                    <span style="font-size: 0.74rem; font-weight: 700; color: #a5b4fc;" id="demoStatusLabel">Nonaktif</span>
                    <label class="demo-switch" title="Nyalakan atau Matikan Mode Demo">
                        <input type="checkbox" id="demoModeToggle" onchange="setDemoMode(this.checked)">
                        <span class="demo-slider"></span>
                    </label>
                </div>
            </div>

            <!-- Standard Credentials Login Form (Clean & Unfilled by Default) -->
            <form action="{{ route('login.perform') }}" method="POST" id="mainLoginForm">
                @csrf
                <input type="hidden" name="selected_role" id="inputSelectedRole" value="{{ old('selected_role', 'siswa') }}">

                <div class="form-group">
                    <label class="form-label" for="loginInput" id="labelLoginInput">Username atau NIS Siswa</label>
                    <div class="input-with-icon">
                        <span class="input-icon-left" id="iconLoginInput">🎒</span>
                        <input type="text"
                               name="login"
                               id="loginInput"
                               class="form-input-text"
                               placeholder="Contoh: doni atau 20260501"
                               value="{{ old('login', '') }}"
                               required
                               autocomplete="username">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="passwordInput" id="labelPasswordInput">PIN Siswa (6 Angka)</label>
                    <div class="input-with-icon">
                        <span class="input-icon-left" id="iconPasswordInput">🔢</span>
                        <input type="password"
                               name="password"
                               id="passwordInput"
                               class="form-input-text has-toggle"
                               placeholder="Masukkan 6 angka PIN siswa (contoh: 123456)..."
                               value=""
                               inputmode="numeric"
                               required
                               autocomplete="current-password">
                        <button type="button" class="btn-toggle-pwd" onclick="togglePasswordVisibility()" title="Lihat/Sembunyikan Sandi">
                            <span id="eyeIcon">👁️</span>
                        </button>
                    </div>
                </div>

                <!-- Form Meta: Remember Me (Unchecked by Default) & Forgot Password Link -->
                <div class="form-meta-row">
                    <label class="checkbox-label" for="rememberMe">
                        <input type="checkbox" name="remember" value="1" id="rememberMe">
                        <span>Ingat saya di perangkat ini</span>
                    </label>

                    <div style="display: flex; align-items: center; gap: 0.85rem;">
                        <span id="autofillHelperSpan" style="display: none; font-size: 0.78rem; color: #38bdf8; cursor: pointer; font-weight: 600;" onclick="autofillCurrentRole()" title="Otomatis isi form dengan kredensial demo peran ini">
                            ⚡ Isi Kredensial Demo
                        </span>
                        <button type="button" class="btn-forgot-link" onclick="openForgotModal()">
                            Lupa kata sandi?
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-auth-submit" id="btnSubmitLogin">
                    <span>🎒 Masuk Sebagai Siswa</span>
                </button>
            </form>

            <!-- Quick 1-Click Role Login (Gated by Demo Mode Switch) -->
            <div id="quickRoleSection" style="display: none;">
                <div class="quick-login-divider">
                    <span>Atau Masuk Cepat 1-Klik (Mode Demo)</span>
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
        </div>

        <!-- Sidebar Role Explanation Column -->
        <div class="auth-info-column">
            <div>
                <!-- Official School Seal Card -->
                <div class="school-seal-card" style="display: flex; align-items: center; gap: 0.85rem; padding: 0.85rem 1rem; border-radius: 16px; background: rgba(99, 102, 241, 0.12); border: 1px solid rgba(99, 102, 241, 0.3); margin-bottom: 1.25rem;">
                    <div style="width: 44px; height: 44px; border-radius: 50%; background: #ffffff; padding: 2px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; box-shadow: 0 0 12px rgba(99, 102, 241, 0.35);">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo SDS Madani" style="width: 100%; height: 100%; object-fit: contain; border-radius: 50%;">
                    </div>
                    <div>
                        <div style="font-weight: 800; font-size: 0.88rem; color: #ffffff; font-family: var(--font-heading); line-height: 1.2;">SDS AL - MADANI</div>
                        <div style="font-size: 0.7rem; color: #cbd5e1; font-weight: 600;">Pontianak Tenggara • Terakreditasi</div>
                    </div>
                </div>

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

            <!-- Demo Account Credentials Box (Visible ONLY in Demo Mode) -->
            <div class="demo-credentials-box" id="demoCredsBox" style="display: none;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span style="font-weight: 700; color: #f8fafc;">📋 Akun Demo Terverifikasi:</span>
                    <span style="font-size: 0.72rem; color: #38bdf8; cursor: pointer; font-weight: 600;" onclick="autofillCurrentRole()">Terapkan ke Form ↗</span>
                </div>
                <div id="demoCredRows">
                    <!-- Dinamis via roleData di scripts -->
                </div>
            </div>

            <!-- School Notice Card (Visible when Demo Mode is OFF) -->
            <div class="school-notice-box" id="schoolNoticeCard">
                <div class="school-notice-header">
                    <span>📢</span> <strong>Ketentuan Masuk Portal SDS Madani</strong>
                </div>
                <div class="school-notice-desc" style="display: flex; flex-direction: column; gap: 0.45rem;">
                    <div>
                        <b style="color: #93c5fd;">🎒 Siswa SD:</b> Masuk dengan <b>Username</b> atau <b>NIS</b> resmi dan 6 angka <b>PIN</b> yang dibagikan oleh Wali Kelas.
                    </div>
                    <div>
                        <b style="color: #c4b5fd;">👨‍🏫 Guru:</b> Wajib menggunakan <b>Alamat Email Resmi Sekolah</b> (@sdsmadani.sch.id) dan kata sandi.
                    </div>
                    <div>
                        <b style="color: #6ee7b7;">👨‍👩‍👧 Orang Tua:</b> Masuk menggunakan <b>Alamat Email Terdaftar</b> saat registrasi siswa.
                    </div>
                </div>
                <div class="school-notice-contact" style="margin-top: 0.6rem;">
                    <span>💬 Bantuan Akun: Hubungi Wali Kelas atau Tata Usaha SDS Madani</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Dialog Bantuan Lupa Kata Sandi / PIN -->
<div class="modal-backdrop-custom" id="forgotModal" onclick="closeForgotModal(event)">
    <div class="modal-card-custom" onclick="event.stopPropagation()">
        <div class="modal-card-header">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <div style="width: 42px; height: 42px; border-radius: 12px; background: rgba(99, 102, 241, 0.2); border: 1px solid rgba(99, 102, 241, 0.4); display: flex; align-items: center; justify-content: center; font-size: 1.3rem;">
                    🔑
                </div>
                <div>
                    <h3 style="font-family: var(--font-heading); font-size: 1.25rem; color: #fff; margin: 0;">Lupa Sandi atau PIN?</h3>
                    <p style="font-size: 0.75rem; color: #a5b4fc; margin: 0;">Bantuan Pemulihan Akun SDS Al-Madani</p>
                </div>
            </div>
            <button type="button" class="btn-modal-close" onclick="closeForgotModal()">&times;</button>
        </div>
        
        <div class="modal-card-body">
            <div class="role-help-pill role-help-siswa">
                <div class="pill-title"><span>🎒</span> <strong>Untuk Siswa (Kelas 4 - 6):</strong></div>
                <p>Lupa Username, NIS, atau PIN? Silakan sampaikan kepada <b>Wali Kelas</b> Anda (misal: Bu Rahmawati). Wali Kelas dapat langsung mengecek Username/NIS serta mereset PIN menjadi <b>123456</b> melalui Dashboard Guru.</p>
            </div>

            <div class="role-help-pill role-help-guru">
                <div class="pill-title"><span>👨‍🏫</span> <strong>Untuk Guru & Orang Tua:</strong></div>
                <p>Login guru dan orang tua menggunakan <b>alamat email resmi</b>. Jika lupa kata sandi email, hubungi administrator IT sekolah atau staf Tata Usaha untuk verifikasi dan pembaruan sandi.</p>
            </div>

            <div class="contact-support-box">
                <div style="font-size: 0.8rem; font-weight: 700; color: #f8fafc; margin-bottom: 0.45rem;">
                    📞 Saluran Bantuan Resmi:
                </div>
                <div style="font-size: 0.82rem; color: #cbd5e1; display: flex; flex-direction: column; gap: 0.35rem;">
                    <div>🏫 <b>Sekolah:</b> SDS Al-Madani Pontianak Tenggara, Kalbar</div>
                    <div>💬 <b>WhatsApp Tata Usaha:</b> <span id="helpDeskNumber" style="color: #38bdf8; font-weight: 600;">+62 812-5678-9012</span></div>
                    <div>✉️ <b>Email Resmi:</b> <span style="color: #a5b4fc;">admin@sdsmadani.sch.id</span></div>
                </div>
            </div>
        </div>

        <div class="modal-card-footer">
            <button type="button" class="btn btn-outline btn-sm" onclick="closeForgotModal()">Tutup</button>
            <button type="button" class="btn btn-primary btn-sm" id="btnCopyContact" onclick="copyContactHelpdesk()">
                <span>📋 Salin Kontak Bantuan</span>
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const roleData = {
        'siswa': {
            title: 'Portal Siswa',
            roleName: 'Siswa',
            badge: 'Siswa Kelas 5-A (NIS: 20260501)',
            avatar: '🚀',
            desc: 'Tampilan ramah anak dirancang dengan gamifikasi, pengumpulan XP, kenaikan level avatar, kuis harian 10 soal, dan petualangan belajar 5 mata pelajaran inti.',
            features: [
                'Login Fleksibel: Username atau Nomor Induk Siswa (NIS) + PIN',
                'Materi 5 Mata Pelajaran Inti & Mini Games Interaktif',
                'Kuis Harian 10 Soal Berhadiah +100 XP & Peringkat Kelas'
            ],
            loginLabel: 'Username atau NIS Siswa',
            loginPlaceholder: 'Contoh: doni atau 20260501',
            loginIcon: '🎒',
            secretLabel: 'PIN Siswa (6 Angka)',
            secretPlaceholder: 'Masukkan 6 angka PIN siswa (contoh: 123456)...',
            secretIcon: '🔢',
            buttonText: '🎒 Masuk Sebagai Siswa',
            autofillLogin: 'doni',
            autofillSecret: '123456',
            renderCreds: () => `
                <div class="demo-cred-row">
                    <span>Username Siswa:</span>
                    <strong style="color: #ffffff;">doni</strong>
                </div>
                <div class="demo-cred-row">
                    <span>Atau Nomor Induk Siswa (NIS):</span>
                    <strong style="color: #60a5fa;">20260501</strong>
                </div>
                <div class="demo-cred-row">
                    <span>PIN Siswa (6 Angka):</span>
                    <strong style="color: #34d399;">123456</strong>
                </div>
                <div class="demo-cred-row" style="border-top: 1px dashed rgba(255,255,255,0.1); margin-top: 0.4rem; padding-top: 0.4rem;">
                    <span>Tujuan Tampilan:</span>
                    <strong style="color: #38bdf8;">Beranda Pembelajaran Siswa</strong>
                </div>
                <div style="display: flex; gap: 0.5rem; margin-top: 0.6rem;">
                    <button type="button" onclick="autofillSiswaMode('username')" style="flex: 1; padding: 0.35rem 0.5rem; background: rgba(59,130,246,0.2); border: 1px solid rgba(59,130,246,0.4); border-radius: 8px; color: #93c5fd; font-size: 0.72rem; cursor: pointer; font-weight: 600;">
                        Isi Username (doni)
                    </button>
                    <button type="button" onclick="autofillSiswaMode('nis')" style="flex: 1; padding: 0.35rem 0.5rem; background: rgba(16,185,129,0.2); border: 1px solid rgba(16,185,129,0.4); border-radius: 8px; color: #6ee7b7; font-size: 0.72rem; cursor: pointer; font-weight: 600;">
                        Isi NIS (20260501)
                    </button>
                </div>
            `
        },
        'guru': {
            title: 'Portal Pengajar Guru',
            roleName: 'Guru',
            badge: 'Wali Kelas & Guru Pengajar 5-A',
            avatar: '👨‍🏫',
            desc: 'Panel kontrol komprehensif bagi bapak/ibu guru untuk meninjau statistik nilai kelas, menganalisis topik yang sulit bagi siswa, menambah bank soal baru, dan mengunduh rekap CSV.',
            features: [
                'Autentikasi Email: Wajib Menggunakan Alamat Email Resmi',
                'Bank Soal Interaktif (Buat & Publikasi Soal)',
                'Analisis Otomatis Topik Sulit & Ekspor Rekap Nilai CSV'
            ],
            loginLabel: 'Alamat Email Guru',
            loginPlaceholder: 'Contoh: guru@sdsmadani.sch.id',
            loginIcon: '📧',
            secretLabel: 'Kata Sandi Guru',
            secretPlaceholder: 'Masukkan kata sandi guru...',
            secretIcon: '🔒',
            buttonText: '👨‍🏫 Masuk Sebagai Guru',
            autofillLogin: 'guru@sdsmadani.sch.id',
            autofillSecret: 'password123',
            renderCreds: () => `
                <div class="demo-cred-row">
                    <span>Alamat Email Guru:</span>
                    <strong style="color: #ffffff;">guru@sdsmadani.sch.id</strong>
                </div>
                <div class="demo-cred-row">
                    <span>Kata Sandi:</span>
                    <strong style="color: #34d399;">password123</strong>
                </div>
                <div class="demo-cred-row" style="border-top: 1px dashed rgba(255,255,255,0.1); margin-top: 0.4rem; padding-top: 0.4rem;">
                    <span>Tujuan Tampilan:</span>
                    <strong style="color: #38bdf8;">Dashboard Guru (/guru)</strong>
                </div>
            `
        },
        'orang_tua': {
            title: 'Portal Orang Tua Murid',
            roleName: 'Orang Tua',
            badge: 'Orang Tua Doni Pratama (Kelas 5-A)',
            avatar: '👨‍👩‍👧',
            desc: 'Portal pendampingan ayah & bunda untuk memantau durasi waktu belajar layar ananda, menyetel batas screen time dengan PIN, serta melihat progres nilai tiap mata pelajaran.',
            features: [
                'Autentikasi Email: Wajib Menggunakan Alamat Email Terdaftar',
                'Pengatur Batas Waktu Layar Belajar (Screen Time)',
                'Grafik Rapor & Pantauan Kelemahan Belajar Siswa'
            ],
            loginLabel: 'Alamat Email Orang Tua',
            loginPlaceholder: 'Contoh: orangtua@sdsmadani.sch.id',
            loginIcon: '📧',
            secretLabel: 'Kata Sandi Orang Tua',
            secretPlaceholder: 'Masukkan kata sandi orang tua...',
            secretIcon: '🔒',
            buttonText: '👨‍👩‍👧 Masuk Sebagai Orang Tua',
            autofillLogin: 'orangtua@sdsmadani.sch.id',
            autofillSecret: 'password123',
            renderCreds: () => `
                <div class="demo-cred-row">
                    <span>Alamat Email Orang Tua:</span>
                    <strong style="color: #ffffff;">orangtua@sdsmadani.sch.id</strong>
                </div>
                <div class="demo-cred-row">
                    <span>Kata Sandi:</span>
                    <strong style="color: #34d399;">password123</strong>
                </div>
                <div class="demo-cred-row" style="border-top: 1px dashed rgba(255,255,255,0.1); margin-top: 0.4rem; padding-top: 0.4rem;">
                    <span>Tujuan Tampilan:</span>
                    <strong style="color: #38bdf8;">Portal Orang Tua (/orang-tua)</strong>
                </div>
            `
        }
    };

    let currentSelectedRole = 'siswa';

    function selectRole(role) {
        currentSelectedRole = role;
        const roleHiddenInput = document.getElementById('inputSelectedRole');
        if (roleHiddenInput) roleHiddenInput.value = role;

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
        const demoCredRows = document.getElementById('demoCredRows');
        if (demoCredRows && typeof data.renderCreds === 'function') {
            demoCredRows.innerHTML = data.renderCreds();
        }

        // Update form input label & placeholder (DO NOT auto-fill input values!)
        const label = document.getElementById('labelLoginInput');
        const icon = document.getElementById('iconLoginInput');
        const input = document.getElementById('loginInput');
        const labelPwd = document.getElementById('labelPasswordInput');
        const iconPwd = document.getElementById('iconPasswordInput');
        const inputPwd = document.getElementById('passwordInput');
        
        if (label) label.innerText = data.loginLabel;
        if (icon) icon.innerText = data.loginIcon;
        if (input) input.placeholder = data.loginPlaceholder;

        if (labelPwd) labelPwd.innerText = data.secretLabel;
        if (iconPwd) iconPwd.innerText = data.secretIcon;
        if (inputPwd) {
            inputPwd.placeholder = data.secretPlaceholder;
            if (role === 'siswa') {
                inputPwd.setAttribute('inputmode', 'numeric');
            } else {
                inputPwd.removeAttribute('inputmode');
            }
        }

        // Button submit styling
        const btnSubmit = document.getElementById('btnSubmitLogin');
        if (btnSubmit) {
            btnSubmit.innerHTML = `<span>${data.buttonText}</span>`;
        }

        // Helper text update
        const autofillSpan = document.getElementById('autofillHelperSpan');
        if (autofillSpan) {
            autofillSpan.innerText = role === 'siswa' ? '⚡ Isi PIN/Akun Demo' : '⚡ Isi Sandi Demo';
        }
    }

    // Demo Mode Gating Controller
    function setDemoMode(enabled, persist = true) {
        const toggle = document.getElementById('demoModeToggle');
        const bar = document.getElementById('demoGateBar');
        const statusLabel = document.getElementById('demoStatusLabel');
        const quickSection = document.getElementById('quickRoleSection');
        const demoCreds = document.getElementById('demoCredsBox');
        const noticeCard = document.getElementById('schoolNoticeCard');
        const autofillSpan = document.getElementById('autofillHelperSpan');

        if (toggle) toggle.checked = enabled;
        if (bar) bar.classList.toggle('active', enabled);
        if (statusLabel) {
            statusLabel.innerText = enabled ? 'Aktif' : 'Nonaktif';
            statusLabel.style.color = enabled ? '#86efac' : '#a5b4fc';
        }
        if (quickSection) quickSection.style.display = enabled ? 'block' : 'none';
        if (demoCreds) demoCreds.style.display = enabled ? 'block' : 'none';
        if (noticeCard) noticeCard.style.display = enabled ? 'none' : 'block';
        if (autofillSpan) autofillSpan.style.display = enabled ? 'inline' : 'none';

        if (persist) {
            localStorage.setItem('sds_demo_mode', enabled ? 'true' : 'false');
        }
    }

    function autofillCurrentRole() {
        const data = roleData[currentSelectedRole];
        if (!data) return;
        const loginEl = document.getElementById('loginInput');
        const pwdEl = document.getElementById('passwordInput');
        if (loginEl) loginEl.value = data.autofillLogin;
        if (pwdEl) pwdEl.value = data.autofillSecret;

        // Brief visual pulse feedback on input
        if (loginEl) loginEl.style.boxShadow = '0 0 0 3px rgba(16, 185, 129, 0.4)';
        if (pwdEl) pwdEl.style.boxShadow = '0 0 0 3px rgba(16, 185, 129, 0.4)';
        setTimeout(() => { 
            if (loginEl) loginEl.style.boxShadow = ''; 
            if (pwdEl) pwdEl.style.boxShadow = ''; 
        }, 600);
    }

    function autofillSiswaMode(type) {
        const loginEl = document.getElementById('loginInput');
        const pwdEl = document.getElementById('passwordInput');
        if (loginEl) {
            loginEl.value = type === 'nis' ? '20260501' : 'doni';
        }
        if (pwdEl) {
            pwdEl.value = '123456';
        }

        // Pulse feedback
        if (loginEl) loginEl.style.boxShadow = '0 0 0 3px rgba(56, 189, 248, 0.4)';
        if (pwdEl) pwdEl.style.boxShadow = '0 0 0 3px rgba(56, 189, 248, 0.4)';
        setTimeout(() => { 
            if (loginEl) loginEl.style.boxShadow = ''; 
            if (pwdEl) pwdEl.style.boxShadow = ''; 
        }, 600);
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

    // Modal Lupa Kata Sandi / PIN
    function openForgotModal() {
        const modal = document.getElementById('forgotModal');
        if (modal) {
            modal.style.display = 'flex';
            setTimeout(() => modal.classList.add('active'), 10);
            document.body.style.overflow = 'hidden';
        }
    }

    function closeForgotModal(e) {
        if (e && e.target && e.target.id !== 'forgotModal') return;
        const modal = document.getElementById('forgotModal');
        if (modal) {
            modal.classList.remove('active');
            setTimeout(() => {
                modal.style.display = 'none';
                document.body.style.overflow = '';
            }, 250);
        }
    }

    function copyContactHelpdesk() {
        const text = '+6281256789012';
        navigator.clipboard.writeText(text).then(() => {
            const btn = document.getElementById('btnCopyContact');
            if (btn) {
                const oldHtml = btn.innerHTML;
                btn.innerHTML = '<span>✅ Nomor Tersalin!</span>';
                btn.style.background = '#10b981';
                setTimeout(() => {
                    btn.innerHTML = oldHtml;
                    btn.style.background = '';
                }, 2000);
            }
        }).catch(() => {
            alert('Kontak Tata Usaha SDS Madani: +62 812-5678-9012');
        });
    }

    // Close modal on Escape key
    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            const modal = document.getElementById('forgotModal');
            if (modal && modal.classList.contains('active')) {
                closeForgotModal();
            }
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        // Read saved demo mode preference (default: false / nonaktif)
        const savedDemo = localStorage.getItem('sds_demo_mode') === 'true';
        setDemoMode(savedDemo, false);

        // Select initial role from old input or default to siswa without autofilling inputs
        const initialRole = "{{ old('selected_role', 'siswa') }}";
        selectRole(initialRole);
    });
</script>
@endsection
