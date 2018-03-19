<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->string('user_id');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');            
            $table->integer('band_id')->unsigned()->nullable();
            $table->foreign('band_id')->references('band_id')->on('bands');
            $table->string('aria_visits')->nullable();
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
        Schema::dropIfExists('visits');
    }
}
