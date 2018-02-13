<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSongsplayedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('songsplayed', function (Blueprint $table) {
            $table->string('user_id');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');            
            $table->integer('song_id')->unsigned()->nullable();
            $table->foreign('song_id')->references('song_id')->on('songs');   
            $table->integer('category')->unsigned();   
            $table->timestamps();
            //nag usab ko diri
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
