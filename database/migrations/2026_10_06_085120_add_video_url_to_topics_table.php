<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVideoUrlToTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('topics', function (Blueprint $table) {
            $table->string('video_url', 500)->nullable()->after('video_desc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('topics', function (Blueprint $table) {
            $table->dropColumn('video_url');
        });
    }
}
