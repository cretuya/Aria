<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBandschedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bandschedules', function (Blueprint $table) {
            $table->integer('band_id')->unsigned();
            $table->foreign('band_id')->references('band_id')->on('bands')->onDelete('cascade');
            $table->string('event_name', 50);
            $table->string('event_desc', 100);
            $table->date('start_date');
            $table->date('end_date');
            $table->time('start_time');
            $table->time('end_time');
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
        Schema::dropIfExists('bandschedules');
    }
}
