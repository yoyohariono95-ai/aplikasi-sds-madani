@extends('layouts.app')

@section('title', 'Portal Orang Tua | SDS Madani SD Kelas 4-6')

@section('content')
<!-- Role Status Banner -->
<div class="role-status-banner role-status-parent" style="margin-bottom: 2rem;">
    <div class="role-status-content">
        <span class="role-status-icon">👨‍👩‍👧</span>
        <div>
            <strong>Portal Pendampingan Orang Tua:</strong> Masuk sebagai <b>{{ Auth::user()->name ?? 'Bunda Doni Pratama' }}</b>. Anda memiliki akses kendali waktu layar dan laporan perkembangan ananda <b>Doni Pratama</b>.
        </div>
    </div>
    <div class="role-status-actions">
        <button class="btn btn-primary btn-sm" onclick="openPinModal('tambah')">
            ⏱️ Tambah Screen Time
        </button>
    </div>
</div>

<div class="page-header" style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-family: var(--font-heading); font-size: 2.2rem; color: white;">
                👨‍👩‍👧 Portal Pendampingan Orang Tua Murid
            </h1>
            <p style="color: var(--text-muted); font-size: 1rem;">
                Pantau perkembangan belajar ananda <strong style="color: white;">{{ $childProfile['name'] }}</strong> ({{ $childProfile['class'] }}), atur batas waktu layar harian, dan atur jadwal pengingat rutin.
            </p>
        </div>
        <div style="display: flex; gap: 0.8rem; align-items: center; flex-wrap: wrap;">
            <span class="badge-grade" style="background: #10b981; font-size: 0.8rem; padding: 0.35rem 0.8rem;">
                Wali Kelas: {{ $childProfile['wali_kelas'] }}
            </span>
            <a href="{{ route('home') }}" class="btn btn-outline btn-sm">
                📚 Intip Materi Siswa
            </a>
        </div>
    </div>
</div>

<div class="parent-dashboard-grid" style="margin-bottom: 2.5rem;">
    <!-- 1. Laporan Perkembangan Anak (Nilai & Keaktifan 5 Mapel) -->
    <div class="glass-panel" id="subjectProgressSection">
        <h3 style="font-family: var(--font-heading); font-size: 1.3rem; color: white; margin-bottom: 1.2rem; display: flex; align-items: center; gap: 0.5rem;">
            <span>📈</span> Laporan Nilai & Penguasaan Mata Pelajaran
        </h3>

        <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 1.5rem;">
            @foreach($subjectProgress as $sp)
            <div>
                <div style="display: flex; justify-content: space-between; font-size: 0.9rem; margin-bottom: 0.35rem; flex-wrap: wrap;">
                    <span style="font-weight: 600; color: white;">{{ $sp['subject'] }}</span>
                    <span style="font-weight: 700; color: {{ $sp['color'] }};">
                        Nilai {{ $sp['score'] }} ({{ $sp['status'] }})
                    </span>
                </div>
                <div class="progress-track" style="height: 10px;">
                    <div class="progress-fill" style="width: {{ $sp['score'] }}%; background: {{ $sp['color'] }};"></div>
                </div>
            </div>
            @endforeach
        </div>

        <div style="background: rgba(15,23,42,0.8); border: 1px solid var(--border-glass); border-radius: 14px; padding: 1.2rem;">
            <h4 style="font-size: 0.95rem; color: #fbbf24; margin-bottom: 0.4rem;">
                💡 Catatan Evaluasi Guru untuk Orang Tua:
            </h4>
            <p style="font-size: 0.85rem; color: #cbd5e1; line-height: 1.5;">
                Ananda Doni sangat aktif dan antusias di mata pelajaran IPA dan Bahasa Indonesia. Untuk Matematika materi pecahan desimal, disarankan meluangkan 10 menit bersama ananda untuk latihan tambahan menggunakan alat peraga permen atau potongan kue.
            </p>
        </div>
    </div>

    <!-- 2. Batas Waktu Penggunaan Harian (Screen Time Limiter) -->
    <div class="screen-time-controller" id="screenTimeController">
        <h3 style="font-family: var(--font-heading); font-size: 1.3rem; color: white; display: flex; align-items: center; gap: 0.5rem;">
            <span>⏱️</span> Batas Waktu Penggunaan Harian (Screen Time)
        </h3>
        <p style="font-size: 0.85rem; color: var(--text-muted);">
            Menjaga kesehatan mata dan kedisiplinan anak agar tidak menatap layar berlebihan.
        </p>

        <div class="time-gauge">
            <div style="text-align: center;">
                <div class="time-number" id="screenTimeLeftVal">20</div>
                <div style="font-size: 0.85rem; color: var(--text-muted);">Menit Tersisa</div>
            </div>
            <div style="width: 2px; height: 60px; background: rgba(255,255,255,0.15);"></div>
            <div style="text-align: center;">
                <div style="font-family: var(--font-heading); font-size: 2.2rem; color: #94a3b8;" id="screenTimeLimitVal">45</div>
                <div style="font-size: 0.85rem; color: var(--text-muted);">Batas Maksimal/Hari</div>
            </div>
        </div>

        <div class="progress-track" style="height: 12px;">
            <div class="progress-fill" style="width: 55%; background: linear-gradient(90deg, #10b981, #f59e0b);"></div>
        </div>
        <div style="display: flex; justify-content: space-between; font-size: 0.75rem; color: var(--text-muted);">
            <span>Terpakai: 25 Menit</span>
            <span>Batas: 45 Menit</span>
        </div>

        <div style="display: flex; gap: 0.8rem; margin-top: 1rem; flex-wrap: wrap;">
            <button class="btn btn-outline btn-sm" style="flex: 1; min-width: 130px; justify-content: center;" onclick="openPinModal('tambah')">
                ➕ Tambah 15 Menit
            </button>
            <button class="btn btn-accent btn-sm" style="flex: 1; min-width: 130px; justify-content: center;" onclick="openPinModal('kunci')">
                🔒 Kunci Aplikasi Sekarang
            </button>
        </div>

        <div id="screenTimeAlertMsg" style="font-size: 0.85rem; color: #4ade80; text-align: center; min-height: 20px;"></div>
    </div>
</div>

<!-- 3. Notifikasi Pengingat Belajar Rutin (WhatsApp / Push Notification Simulation) -->
<div class="glass-panel" id="notifWaSection">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h3 style="font-family: var(--font-heading); font-size: 1.3rem; color: white; display: flex; align-items: center; gap: 0.5rem;">
                <span>🔔</span> Notifikasi & Jadwal Pengingat Belajar Rutin
            </h3>
            <p style="font-size: 0.85rem; color: var(--text-muted);">
                Sistem otomatis mengirim pesan ke nomor WhatsApp orang tua ketika jam belajar dimulai atau saat ada tugas baru.
            </p>
        </div>
        <button class="btn btn-primary btn-sm" onclick="sendTestNotification()">
            📱 Kirim Uji Coba Notifikasi WA
        </button>
    </div>

    <div class="parent-notif-grid">
        <!-- Pengaturan Jam Belajar Rutin -->
        <div style="background: rgba(15,23,42,0.8); border: 1px solid var(--border-glass); border-radius: 16px; padding: 1.4rem;">
            <h4 style="font-size: 1rem; color: white; margin-bottom: 1rem;">⏰ Jadwal Belajar Harian Doni:</h4>
            
            <div style="display: flex; flex-direction: column; gap: 0.8rem;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 0.9rem; color: #cbd5e1;">Jam Mulai Belajar Malam:</span>
                    <input type="time" value="19:00" style="padding: 0.4rem; border-radius: 8px; background: #020617; border: 1px solid var(--border-glass); color: white;">
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 0.9rem; color: #cbd5e1;">Notifikasi Kuis Harian:</span>
                    <input type="checkbox" checked style="width: 18px; height: 18px; cursor: pointer;">
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 0.9rem; color: #cbd5e1;">Laporan Nilai Mingguan:</span>
                    <input type="checkbox" checked style="width: 18px; height: 18px; cursor: pointer;">
                </div>
            </div>
        </div>

        <!-- Log Notifikasi Terkirim -->
        <div style="background: rgba(15,23,42,0.8); border: 1px solid var(--border-glass); border-radius: 16px; padding: 1.4rem;">
            <h4 style="font-size: 1rem; color: white; margin-bottom: 1rem;">💬 Riwayat Notifikasi Terkirim:</h4>
            <div style="display: flex; flex-direction: column; gap: 0.8rem;" id="notificationLogList">
                @foreach($notifications as $notif)
                <div style="display: flex; gap: 0.8rem; align-items: flex-start; padding: 0.6rem; border-radius: 8px; background: rgba(255,255,255,0.04);">
                    <span style="font-size: 0.8rem; background: rgba(34,197,94,0.2); color: #86efac; padding: 0.15rem 0.45rem; border-radius: 4px; font-weight: 700;">
                        {{ $notif['time'] }}
                    </span>
                    <span style="font-size: 0.85rem; color: #e2e8f0; line-height: 1.4;">{{ $notif['text'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Modal PIN Orang Tua -->
<div id="parentPinModal" style="display: none; position: fixed; inset: 0; background: rgba(2,6,23,0.85); backdrop-filter: blur(16px); z-index: 2000; align-items: center; justify-content: center; padding: 1.5rem;">
    <div class="glass-panel" style="max-width: 400px; width: 100%; text-align: center; position: relative;">
        <button onclick="closePinModal()" style="position: absolute; top: 16px; right: 16px; background: transparent; border: none; color: white; font-size: 1.5rem; cursor: pointer;">✕</button>
        <div style="font-size: 3rem; margin-bottom: 0.8rem;">🔐</div>
        <h3 style="font-family: var(--font-heading); font-size: 1.4rem; color: white; margin-bottom: 0.5rem;">Masukkan PIN Orang Tua</h3>
        <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1.5rem;">(PIN Default Pengaman: 1234)</p>

        <input type="password" id="parentPinInput" maxlength="4" placeholder="••••" style="width: 150px; font-size: 2rem; letter-spacing: 8px; text-align: center; padding: 0.5rem; border-radius: 12px; border: 2px solid var(--primary); background: #0f172a; color: white; margin-bottom: 1.5rem;">

        <div style="display: flex; gap: 0.8rem; justify-content: center;">
            <button class="btn btn-outline btn-sm" onclick="closePinModal()">Batal</button>
            <button class="btn btn-primary btn-sm" onclick="verifyParentPin()">Konfirmasi PIN</button>
        </div>
        <div id="pinErrorMsg" style="color: #f87171; font-size: 0.85rem; margin-top: 0.8rem; min-height: 20px;"></div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let currentPinAction = '';

    function openPinModal(action) {
        currentPinAction = action;
        document.getElementById('parentPinInput').value = '';
        document.getElementById('pinErrorMsg').innerText = '';
        document.getElementById('parentPinModal').style.display = 'flex';
        document.getElementById('parentPinInput').focus();
    }

    function closePinModal() {
        document.getElementById('parentPinModal').style.display = 'none';
    }

    function verifyParentPin() {
        const pin = document.getElementById('parentPinInput').value;
        const error = document.getElementById('pinErrorMsg');
        if (pin === '1234') {
            soundFX.playCorrect();
            closePinModal();
            const alertMsg = document.getElementById('screenTimeAlertMsg');
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            if (currentPinAction === 'tambah') {
                const curLeft = parseInt(document.getElementById('screenTimeLeftVal').innerText);
                const newLeft = curLeft + 15;
                document.getElementById('screenTimeLeftVal').innerText = newLeft;
                const curLimit = parseInt(document.getElementById('screenTimeLimitVal').innerText);
                const newLimit = curLimit + 15;
                document.getElementById('screenTimeLimitVal').innerText = newLimit;
                alertMsg.innerText = '✅ Waktu belajar berhasil ditambah 15 menit oleh Orang Tua!';
                
                localStorage.setItem('sds_screen_time_left', newLeft);
                const lockModal = document.getElementById('screenTimeLockModal');
                if (lockModal) lockModal.style.display = 'none';
                const remEl = document.getElementById('screenTimeRemainingText');
                if (remEl) remEl.innerText = newLeft;

                fetch('{{ route("api.parent-settings") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
                    body: JSON.stringify({ max_screen_time: newLimit, used_screen_time: 25 })
                }).catch(() => {});
            } else {
                document.getElementById('screenTimeLeftVal').innerText = 0;
                alertMsg.innerText = '🔒 Aplikasi telah dikunci oleh Orang Tua. Waktu istirahat!';
                localStorage.setItem('sds_screen_time_left', 0);
                const lockModal = document.getElementById('screenTimeLockModal');
                if (lockModal) lockModal.style.display = 'flex';
                const remEl = document.getElementById('screenTimeRemainingText');
                if (remEl) remEl.innerText = 0;
            }
        } else {
            soundFX.playWrong();
            error.innerText = 'PIN salah! Silakan coba lagi (PIN default: 1234).';
        }
    }

    function sendTestNotification() {
        soundFX.playCoin();
        const list = document.getElementById('notificationLogList');
        const now = new Date();
        const timeStr = `${now.getHours()}:${now.getMinutes() < 10 ? '0' : ''}${now.getMinutes()}`;
        
        const newNotif = document.createElement('div');
        newNotif.style.cssText = 'display: flex; gap: 0.8rem; align-items: flex-start; padding: 0.6rem; border-radius: 8px; background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.3);';
        newNotif.innerHTML = `
            <span style="font-size: 0.8rem; background: rgba(34,197,94,0.3); color: #86efac; padding: 0.15rem 0.45rem; border-radius: 4px; font-weight: 700;">
                ${timeStr}
            </span>
            <span style="font-size: 0.85rem; color: #e2e8f0; line-height: 1.4;">
                📲 <strong>WhatsApp ke Bunda:</strong> Doni sedang mengerjakan Kuis Harian Matematika SDS Madani!
            </span>
        `;
        list.prepend(newNotif);
        alert('📲 Pesan WhatsApp uji coba berhasil dikirim ke nomor orang tua!');
    }
</script>
@endsection
