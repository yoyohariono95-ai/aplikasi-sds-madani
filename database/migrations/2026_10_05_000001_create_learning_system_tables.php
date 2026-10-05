<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLearningSystemTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->string('class')->default('Kelas 4 - 6');
            $table->string('icon');
            $table->string('color');
            $table->string('bg_gradient');
            $table->text('summary');
            $table->integer('progress')->default(0);
            $table->timestamps();
        });

        Schema::create('topics', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('subject_id');
            $table->string('title');
            $table->string('duration');
            $table->string('difficulty');
            $table->string('video_title');
            $table->text('video_desc');
            $table->json('micro_steps');
            $table->timestamps();

            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('subject_id');
            $table->string('topic_id')->nullable();
            $table->string('level')->default('Mudah'); // Mudah, Sedang, Sulit, Harian
            $table->string('stars')->default('★☆☆');
            $table->text('question');
            $table->json('options');
            $table->integer('answer');
            $table->text('explanation');
            $table->boolean('is_daily')->default(false);
            $table->timestamps();
        });

        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('class')->default('Kelas 5-A');
            $table->integer('score')->default(85);
            $table->string('status')->default('Aktif');
            $table->integer('streak')->default(1);
            $table->integer('xp')->default(100);
            $table->integer('coins')->default(50);
            $table->string('avatar')->default('🚀');
            $table->integer('level')->default(1);
            $table->string('weakness')->nullable();
            $table->boolean('is_me')->default(false);
            $table->timestamps();
        });

        Schema::create('badges', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('title');
            $table->string('icon');
            $table->text('desc');
            $table->boolean('unlocked')->default(false);
            $table->string('unlocked_at')->nullable();
            $table->timestamps();
        });

        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('date');
            $table->text('desc');
            $table->timestamps();
        });

        Schema::create('parent_settings', function (Blueprint $table) {
            $table->id();
            $table->string('child_name')->default('Doni Pratama');
            $table->string('wali_kelas')->default('Ibu Rahmawati, S.Pd.');
            $table->integer('max_screen_time')->default(45);
            $table->integer('used_screen_time')->default(25);
            $table->string('pin')->default('1234');
            $table->string('study_time')->default('19:00');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parent_settings');
        Schema::dropIfExists('announcements');
        Schema::dropIfExists('badges');
        Schema::dropIfExists('students');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('topics');
        Schema::dropIfExists('subjects');
    }
}
