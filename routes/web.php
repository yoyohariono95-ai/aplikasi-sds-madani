<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes - SDS Madani E-Learning SD Kelas 4-6
|--------------------------------------------------------------------------
*/

// Authentication & Session Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
Route::post('/login/quick', [AuthController::class, 'quickLogin'])->name('login.quick');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Public Landing Page
Route::get('/', [LearningController::class, 'index'])->name('home');

// Interactive ERD Visualizer & Designer
Route::get('/erd', function () {
    return response()->file(base_path('docs/erd.html'));
})->name('erd');

Route::get('/erd/pdf', function () {
    return response()->file(base_path('docs/erd-sds-madani.pdf'), [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="erd-sds-madani.pdf"'
    ]);
})->name('erd.pdf');

// Protected Student Learning, Quiz & Gamification Routes (Must Login First)
Route::group(['middleware' => ['auth']], function () {
    Route::get('/belajar', [LearningController::class, 'learning'])->name('learning.index');
    Route::get('/belajar/{id}', [LearningController::class, 'subjectDetail'])->name('learning.subject');
    Route::get('/kuis-harian', [LearningController::class, 'dailyQuiz'])->name('quiz.daily');
    Route::get('/gamifikasi', [LearningController::class, 'gamification'])->name('gamification.index');
    Route::post('/api/save-progress', [LearningController::class, 'saveProgress'])->name('api.save-progress');
});

// Teacher Portal Routes (Protected by auth & guru role)
Route::group(['middleware' => ['auth', 'role:guru']], function () {
    Route::get('/guru', [LearningController::class, 'teacher'])->name('teacher.index');
    Route::get('/guru/unduh-rekap', [LearningController::class, 'exportReport'])->name('teacher.export');
    Route::post('/api/store-question', [LearningController::class, 'storeQuestion'])->name('api.store-question');
    Route::post('/guru/materi', [LearningController::class, 'storeTopic'])->name('guru.topic.store');
    Route::post('/guru/materi/update-video', [LearningController::class, 'updateTopicVideo'])->name('guru.topic.update-video');
    Route::post('/guru/materi/delete', [LearningController::class, 'deleteTopic'])->name('guru.topic.delete');
    Route::post('/guru/siswa/tambah', [LearningController::class, 'storeStudentAccount'])->name('guru.student.store');
    Route::post('/guru/siswa/reset-password', [LearningController::class, 'resetStudentPassword'])->name('guru.student.reset-password');
    Route::post('/guru/siswa/hapus', [LearningController::class, 'deleteStudentAccount'])->name('guru.student.delete');
});

// Parent Portal Routes (Protected by auth & orang_tua role)
Route::group(['middleware' => ['auth', 'role:orang_tua']], function () {
    Route::get('/orang-tua', [LearningController::class, 'parent'])->name('parent.index');
    Route::post('/api/update-parent-settings', [LearningController::class, 'updateParentSettings'])->name('api.parent-settings');
});
