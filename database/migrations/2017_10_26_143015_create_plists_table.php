<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plists', function (Blueprint $table) {
            $table->integer('genre_id')->unsigned();
            $table->foreign('genre_id')->references('genre_id')->on('genres')->onDelete('cascade');      
            $table->integer('song_id')->unsigned();
            $table->foreign('song_id')->references('song_id')->on('songs')->onDelete('cascade');      
            $table->integer('pl_id')->unsigned();
            $table->foreign('pl_id')->references('pl_id')->on('playlists')->onDelete('cascade');


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
        Schema::dropIfExists('plists');
    }
}
