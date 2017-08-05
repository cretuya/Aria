<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBandalbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bandalbums', function (Blueprint $table) {
            $table->increments('album_id');
            $table->string('album_name', 50);
            $table->string('album_desc', 100);
            $table->integer('num_views')->nullable();
            $table->integer('band_id')->unsigned();
            $table->foreign('band_id')->references('band_id')->on('bands')->onDelete('cascade');
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
        Schema::dropIfExists('bandalbums');
    }
}
