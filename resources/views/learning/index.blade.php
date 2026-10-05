@extends('layouts.app')

@section('title', 'Direktori Materi Belajar Inti | SDS Madani SD Kelas 4-6')

@section('content')
<div class="page-header" style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-family: var(--font-heading); font-size: 2.2rem; color: white;">
                📚 Direktori Materi Belajar Inti
            </h1>
            <p style="color: var(--text-muted); font-size: 1rem;">
                Penjelasan konsep ringkas (bite-sized), ilustrasi visual, video animasi 3 menit, dan latihan soal bertingkat.
            </p>
        </div>
        <div style="display: flex; gap: 0.5rem; align-items: center;">
            <span style="font-size: 0.85rem; color: var(--text-muted);">Pilih Kelas:</span>
            <button class="btn btn-outline btn-sm active" style="background: rgba(99,102,241,0.3); border-color: var(--primary);">Semua Kelas</button>
            <button class="btn btn-outline btn-sm">Kelas 4</button>
            <button class="btn btn-outline btn-sm">Kelas 5</button>
            <button class="btn btn-outline btn-sm">Kelas 6</button>
        </div>
    </div>
</div>

<div class="subjects-grid">
    @foreach($subjects as $subj)
    <div class="glass-panel" style="border-top: 4px solid {{ $subj['color'] }}; display: flex; flex-direction: column; justify-content: space-between;">
        <div>
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                <div class="subject-icon-box" style="background: {{ $subj['bg_gradient'] }};">
                    {{ $subj['icon'] }}
                </div>
                <span class="subject-tag">{{ $subj['class'] }}</span>
            </div>

            <h2 style="font-family: var(--font-heading); font-size: 1.5rem; color: white; margin-bottom: 0.5rem;">
                {{ $subj['name'] }}
            </h2>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem;">
                {{ $subj['summary'] }}
            </p>

            <h4 style="font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px; color: #a5b4fc; margin-bottom: 0.8rem;">
                Daftar Topik Interaktif:
            </h4>
            <div style="display: flex; flex-direction: column; gap: 0.6rem; margin-bottom: 1.5rem;">
                @foreach($subj['topics'] as $topic)
                <div style="display: flex; justify-content: space-between; align-items: center; background: rgba(15,23,42,0.6); padding: 0.6rem 0.8rem; border-radius: 10px; border: 1px solid rgba(255,255,255,0.06);">
                    <div style="font-size: 0.85rem; font-weight: 600; color: #e2e8f0;">
                        📖 {{ $topic['title'] }}
                    </div>
                    <span style="font-size: 0.75rem; background: rgba(59,130,246,0.2); color: #93c5fd; padding: 0.15rem 0.5rem; border-radius: 6px;">
                        {{ $topic['duration'] }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        <div>
            <div style="display: flex; justify-content: space-between; font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.4rem;">
                <span>Progres Kamu</span>
                <span style="color: #38bdf8; font-weight: 700;">{{ $subj['progress'] }}%</span>
            </div>
            <div class="progress-track" style="height: 8px; margin-bottom: 1.2rem;">
                <div class="progress-fill" style="width: {{ $subj['progress'] }}%; background: {{ $subj['color'] }};"></div>
            </div>
            <a href="{{ route('learning.subject', $subj['id']) }}" class="btn btn-primary" style="width: 100%; font-size: 0.95rem; justify-content: center;">
                Buka Modul Belajar & Latihan →
            </a>
        </div>
    </div>
    @endforeach
</div>
@endsection
