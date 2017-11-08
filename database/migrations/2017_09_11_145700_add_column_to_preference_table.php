<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToPreferenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('preferences', function (Blueprint $table) {
            $table->integer('album_id')->unsigned()->nullable()->after('band_id');
            $table->foreign('album_id')->references('album_id')->on('bandalbums')->onDelete('cascade');
            $table->integer('pl_id')->unsigned()->nullable()->after('album_id');
            $table->foreign('pl_id')->references('pl_id')->on('playlists');
        });
        //nag usab ko diri
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('preferences', function (Blueprint $table) {
            //
        });
    }
}
