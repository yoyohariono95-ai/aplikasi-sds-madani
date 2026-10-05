<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\Question;
use App\Models\Student;
use App\Models\Badge;
use App\Models\Announcement;
use App\Models\ParentSetting;
use App\Http\Controllers\LearningController;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 1. Seed Subjects, Topics, and Graduated Exercises
        $subjectsData = LearningController::getSubjectsData();
        foreach ($subjectsData as $sId => $sData) {
            $subject = Subject::updateOrCreate(
                ['id' => $sId],
                [
                    'name' => $sData['name'],
                    'class' => $sData['class'],
                    'icon' => $sData['icon'],
                    'color' => $sData['color'],
                    'bg_gradient' => $sData['bg_gradient'],
                    'summary' => $sData['summary'],
                    'progress' => $sData['progress']
                ]
            );

            foreach ($sData['topics'] as $tData) {
                Topic::updateOrCreate(
                    ['id' => $tData['id']],
                    [
                        'subject_id' => $sId,
                        'title' => $tData['title'],
                        'duration' => $tData['duration'],
                        'difficulty' => $tData['difficulty'],
                        'video_title' => $tData['video_title'],
                        'video_desc' => $tData['video_desc'],
                        'micro_steps' => $tData['micro_steps']
                    ]
                );

                if (!empty($tData['exercises'])) {
                    foreach ($tData['exercises'] as $ex) {
                        Question::updateOrCreate(
                            [
                                'subject_id' => $sId,
                                'topic_id' => $tData['id'],
                                'question' => $ex['question']
                            ],
                            [
                                'level' => $ex['level'],
                                'stars' => $ex['stars'],
                                'options' => $ex['options'],
                                'answer' => $ex['answer'],
                                'explanation' => $ex['explanation'],
                                'is_daily' => false
                            ]
                        );
                    }
                }
            }
        }

        // 2. Seed 10 Daily Quiz Questions
        $dailyQuestions = LearningController::getDailyQuizQuestions();
        foreach ($dailyQuestions as $idx => $dq) {
            Question::updateOrCreate(
                ['question' => $dq['question']],
                [
                    'subject_id' => strtolower(str_replace(' ', '-', $dq['subject'])),
                    'topic_id' => null,
                    'level' => 'Harian',
                    'stars' => '★☆☆',
                    'options' => $dq['options'],
                    'answer' => $dq['answer'],
                    'explanation' => $dq['explanation'],
                    'is_daily' => true
                ]
            );
        }

        // 3. Seed Students
        $students = [
            ['name' => 'Doni Pratama', 'score' => 88, 'status' => 'Aktif', 'streak' => 7, 'xp' => 850, 'coins' => 350, 'avatar' => '🚀', 'level' => 3, 'weakness' => 'Pecahan Desimal', 'is_me' => true],
            ['name' => 'Siti Aisyah', 'score' => 96, 'status' => 'Sangat Aktif', 'streak' => 9, 'xp' => 1280, 'coins' => 420, 'avatar' => '🦊', 'level' => 4, 'weakness' => 'Tidak ada', 'is_me' => false],
            ['name' => 'Ahmad Fauzi', 'score' => 98, 'status' => 'Sangat Aktif', 'streak' => 12, 'xp' => 1420, 'coins' => 600, 'avatar' => '🦁', 'level' => 5, 'weakness' => 'Tidak ada', 'is_me' => false],
            ['name' => 'Budi Santoso', 'score' => 74, 'status' => 'Perlu Pendampingan', 'streak' => 4, 'xp' => 640, 'coins' => 180, 'avatar' => '🐼', 'level' => 2, 'weakness' => 'Rumus Bangun Datar', 'is_me' => false],
            ['name' => 'Rina Wijaya', 'score' => 85, 'status' => 'Aktif', 'streak' => 6, 'xp' => 790, 'coins' => 290, 'avatar' => '🐱', 'level' => 3, 'weakness' => 'Ide Pokok Induktif', 'is_me' => false],
            ['name' => 'Nadia Safira', 'score' => 79, 'status' => 'Perlu Diingatkan', 'streak' => 3, 'xp' => 590, 'coins' => 150, 'avatar' => '🦄', 'level' => 2, 'weakness' => 'Telling Time', 'is_me' => false]
        ];
        foreach ($students as $st) {
            Student::updateOrCreate(['name' => $st['name']], $st);
        }

        // 4. Seed Badges
        $badges = [
            ['id' => 'first-step', 'title' => 'Langkah Pertama', 'icon' => '🚀', 'desc' => 'Menyelesaikan modul pertama', 'unlocked' => true, 'unlocked_at' => 'Kemarin'],
            ['id' => 'quiz-master', 'title' => 'Raja Kuis', 'icon' => '🎯', 'desc' => 'Mendapatkan nilai 100 di kuis harian', 'unlocked' => true, 'unlocked_at' => 'Hari ini'],
            ['id' => 'streak-7', 'title' => 'Api Membara 🔥', 'icon' => '🔥', 'desc' => 'Streak belajar 7 hari berturut-turut', 'unlocked' => true, 'unlocked_at' => '3 hari lalu'],
            ['id' => 'math-wizard', 'title' => 'Penyihir Angka', 'icon' => '📐', 'desc' => 'Selesaikan semua latihan pecahan', 'unlocked' => true, 'unlocked_at' => 'Minggu lalu'],
            ['id' => 'science-detective', 'title' => 'Detektif Sains', 'icon' => '🔬', 'desc' => 'Paham sistem pencernaan & ekosistem', 'unlocked' => false, 'unlocked_at' => null],
            ['id' => 'speed-runner', 'title' => 'Kilat Petir', 'icon' => '⚡', 'desc' => 'Jawab 10 soal math speed dalam 30 detik', 'unlocked' => false, 'unlocked_at' => null],
            ['id' => 'vocabulary-hero', 'title' => 'Jago Bahasa', 'icon' => '📖', 'desc' => 'Temukan 10 ide pokok paragraf', 'unlocked' => false, 'unlocked_at' => null],
            ['id' => 'night-owl', 'title' => 'Bintang Malam', 'icon' => '🌟', 'desc' => 'Belajar sebelum jam 8 malam', 'unlocked' => true, 'unlocked_at' => 'Kemarin']
        ];
        foreach ($badges as $b) {
            Badge::updateOrCreate(['id' => $b['id']], $b);
        }

        // 5. Seed Announcements
        $announcements = [
            ['title' => 'Kuis Harian Persiapan PTS', 'date' => 'Senin, 05 Okt', 'desc' => 'Anak-anak hebat, jangan lupa selesaikan kuis harian 10 soal sebelum jam 20.00 malam ya!'],
            ['title' => 'Tugas Pengamatan Sains di Halaman Rumah', 'date' => 'Kamis, 08 Okt', 'desc' => 'Temukan 3 serangga dan tuliskan apa yang mereka makan untuk modul ekosistem.']
        ];
        foreach ($announcements as $anc) {
            Announcement::updateOrCreate(['title' => $anc['title']], $anc);
        }

        // 6. Seed Parent Settings
        ParentSetting::updateOrCreate(
            ['id' => 1],
            [
                'child_name' => 'Doni Pratama',
                'wali_kelas' => 'Ibu Rahmawati, S.Pd.',
                'max_screen_time' => 45,
                'used_screen_time' => 25,
                'pin' => '1234',
                'study_time' => '19:00'
            ]
        );
    }
}
