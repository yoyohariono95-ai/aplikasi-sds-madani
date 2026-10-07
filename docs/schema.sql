-- =====================================================================
-- DATABASE SCHEMA DDL: Aplikasi SDS Madani
-- Generated from Laravel Migrations
-- Target DBMS: MySQL 8.0+ / MariaDB 10.4+
-- =====================================================================

SET FOREIGN_KEY_CHECKS = 0;

-- 1. Users (Akun Pengguna)
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `username` VARCHAR(255) DEFAULT NULL,
  `email` VARCHAR(255) NOT NULL,
  `role` VARCHAR(255) NOT NULL DEFAULT 'siswa',
  `avatar` VARCHAR(255) DEFAULT '🚀',
  `phone` VARCHAR(255) DEFAULT NULL,
  `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `remember_token` VARCHAR(100) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Subjects (Mata Pelajaran)
DROP TABLE IF EXISTS `subjects`;
CREATE TABLE `subjects` (
  `id` VARCHAR(255) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `class` VARCHAR(255) NOT NULL DEFAULT 'Kelas 4 - 6',
  `icon` VARCHAR(255) NOT NULL,
  `color` VARCHAR(255) NOT NULL,
  `bg_gradient` VARCHAR(255) NOT NULL,
  `summary` TEXT NOT NULL,
  `progress` INT NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Topics (Topik Materi)
DROP TABLE IF EXISTS `topics`;
CREATE TABLE `topics` (
  `id` VARCHAR(255) NOT NULL,
  `subject_id` VARCHAR(255) NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `duration` VARCHAR(255) NOT NULL,
  `difficulty` VARCHAR(255) NOT NULL,
  `video_title` VARCHAR(255) NOT NULL,
  `video_desc` TEXT NOT NULL,
  `video_url` VARCHAR(500) DEFAULT NULL,
  `micro_steps` JSON NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `topics_subject_id_foreign` (`subject_id`),
  CONSTRAINT `topics_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Questions (Soal / Kuis)
DROP TABLE IF EXISTS `questions`;
CREATE TABLE `questions` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `subject_id` VARCHAR(255) NOT NULL,
  `topic_id` VARCHAR(255) DEFAULT NULL,
  `level` VARCHAR(255) NOT NULL DEFAULT 'Mudah',
  `stars` VARCHAR(255) NOT NULL DEFAULT '★☆☆',
  `question` TEXT NOT NULL,
  `options` JSON NOT NULL,
  `answer` INT NOT NULL,
  `explanation` TEXT NOT NULL,
  `is_daily` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `questions_subject_id_foreign` (`subject_id`),
  KEY `questions_topic_id_foreign` (`topic_id`),
  CONSTRAINT `questions_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `questions_topic_id_foreign` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Students (Profil Siswa Gamifikasi)
DROP TABLE IF EXISTS `students`;
CREATE TABLE `students` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `class` VARCHAR(255) NOT NULL DEFAULT 'Kelas 5-A',
  `score` INT NOT NULL DEFAULT 85,
  `status` VARCHAR(255) NOT NULL DEFAULT 'Aktif',
  `streak` INT NOT NULL DEFAULT 1,
  `xp` INT NOT NULL DEFAULT 100,
  `coins` INT NOT NULL DEFAULT 50,
  `avatar` VARCHAR(255) NOT NULL DEFAULT '🚀',
  `level` INT NOT NULL DEFAULT 1,
  `weakness` VARCHAR(255) DEFAULT NULL,
  `is_me` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Badges (Lencana Pencapaian)
DROP TABLE IF EXISTS `badges`;
CREATE TABLE `badges` (
  `id` VARCHAR(255) NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `icon` VARCHAR(255) NOT NULL,
  `desc` TEXT NOT NULL,
  `unlocked` TINYINT(1) NOT NULL DEFAULT 0,
  `unlocked_at` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Announcements (Pengumuman)
DROP TABLE IF EXISTS `announcements`;
CREATE TABLE `announcements` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `date` VARCHAR(255) NOT NULL,
  `desc` TEXT NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Parent Settings (Pengaturan Orang Tua)
DROP TABLE IF EXISTS `parent_settings`;
CREATE TABLE `parent_settings` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `child_name` VARCHAR(255) NOT NULL DEFAULT 'Doni Pratama',
  `wali_kelas` VARCHAR(255) NOT NULL DEFAULT 'Ibu Rahmawati, S.Pd.',
  `max_screen_time` INT NOT NULL DEFAULT 45,
  `used_screen_time` INT NOT NULL DEFAULT 25,
  `pin` VARCHAR(255) NOT NULL DEFAULT '1234',
  `study_time` VARCHAR(255) NOT NULL DEFAULT '19:00',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
