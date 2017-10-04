<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserhistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userhistory', function (Blueprint $table) {
            $table->string('user_id',100);
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->string('genre_searched', 50);
            $table->string('term_searched', 50);
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
        Schema::dropIfExists('userhistory');
    }
}
