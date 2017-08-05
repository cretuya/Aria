<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBandmembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bandmembers', function (Blueprint $table) {
            $table->string('user_id',100);
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->integer('band_id')->unsigned();
            $table->foreign('band_id')->references('band_id')->on('bands')->onDelete('cascade');
            $table->string('bandrole', 50);
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
        Schema::dropIfExists('bandmembers');
    }
}
