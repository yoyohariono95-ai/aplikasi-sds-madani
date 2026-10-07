<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNisAndPinToUsersAndStudentsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'nis')) {
                $table->string('nis', 30)->nullable()->unique()->after('username');
            }
            if (!Schema::hasColumn('users', 'pin')) {
                $table->string('pin', 60)->nullable()->after('password');
            }
        });

        Schema::table('students', function (Blueprint $table) {
            if (!Schema::hasColumn('students', 'nis')) {
                $table->string('nis', 30)->nullable()->unique()->after('name');
            }
            if (!Schema::hasColumn('students', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'nis')) {
                $table->dropColumn('nis');
            }
            if (Schema::hasColumn('users', 'pin')) {
                $table->dropColumn('pin');
            }
        });

        Schema::table('students', function (Blueprint $table) {
            if (Schema::hasColumn('students', 'nis')) {
                $table->dropColumn('nis');
            }
            if (Schema::hasColumn('students', 'user_id')) {
                $table->dropColumn('user_id');
            }
        });
    }
}
