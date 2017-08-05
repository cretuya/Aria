<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBandarticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bandarticles', function (Blueprint $table) {
            $table->integer('band_id')->unsigned();
            $table->foreign('band_id')->references('band_id')->on('bands')->onDelete('cascade');
            $table->integer('art_id')->unsigned();
            $table->foreign('art_id')->references('art_id')->on('articles')->onDelete('cascade');
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
        Schema::dropIfExists('bandarticles');
    }
}
