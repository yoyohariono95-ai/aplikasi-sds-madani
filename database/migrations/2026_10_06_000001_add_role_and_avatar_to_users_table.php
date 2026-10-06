<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleAndAvatarToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable()->unique()->after('name');
            $table->string('role')->default('siswa')->after('email');
            $table->string('avatar')->nullable()->default('🚀')->after('role');
            $table->string('phone')->nullable()->after('avatar');
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
            $table->dropColumn(['username', 'role', 'avatar', 'phone']);
        });
    }
}
