<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('album-contents', function (Blueprint $table) {
            $table->integer('album_id')->unsigned();
            $table->foreign('album_id')->references('album_id')->on('bandalbums')->onDelete('cascade');
            $table->integer('song_id')->unsigned();
            $table->foreign('song_id')->references('song_id')->on('songs')->onDelete('cascade');
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
        Schema::dropIfExists('album-contents');
    }
}
