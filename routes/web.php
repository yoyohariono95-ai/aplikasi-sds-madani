<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LearningController;

/*
|--------------------------------------------------------------------------
| Web Routes - SDS Madani E-Learning SD Kelas 4-6
|--------------------------------------------------------------------------
*/

// Public and Student Routes
Route::get('/', [LearningController::class, 'index'])->name('home');
Route::get('/belajar', [LearningController::class, 'learning'])->name('learning.index');
Route::get('/belajar/{id}', [LearningController::class, 'subjectDetail'])->name('learning.subject');
Route::get('/kuis-harian', [LearningController::class, 'dailyQuiz'])->name('quiz.daily');
Route::get('/gamifikasi', [LearningController::class, 'gamification'])->name('gamification.index');

// Teacher Portal Routes
Route::get('/guru', [LearningController::class, 'teacher'])->name('teacher.index');
Route::get('/guru/unduh-rekap', [LearningController::class, 'exportReport'])->name('teacher.export');

// Parent Portal Routes
Route::get('/orang-tua', [LearningController::class, 'parent'])->name('parent.index');

// Interactive API Endpoints for Real Database Persistence
Route::post('/api/save-progress', [LearningController::class, 'saveProgress'])->name('api.save-progress');
Route::post('/api/store-question', [LearningController::class, 'storeQuestion'])->name('api.store-question');
Route::post('/api/update-parent-settings', [LearningController::class, 'updateParentSettings'])->name('api.parent-settings');
