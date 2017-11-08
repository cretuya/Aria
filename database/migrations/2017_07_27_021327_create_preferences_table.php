<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preferences', function (Blueprint $table) {
            $table->string('user_id');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->integer('pl_id')->unsigned()->nullable();
            $table->foreign('pl_id')->references('pl_id')->on('playlists');
            $table->integer('band_id')->unsigned()->nullable();
            $table->foreign('band_id')->references('band_id')->on('bands');       
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
        Schema::dropIfExists('preferences');
    }
}
