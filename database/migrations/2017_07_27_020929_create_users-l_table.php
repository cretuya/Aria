<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersLTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('user_id',100);
            $table->string('fname', 50);
            $table->string('lname', 50);
            $table->string('fullname', 100);
            $table->string('email', 50);
            $table->integer('age')->nullable();
            $table->string('gender', 10);
            $table->string('address', 50)->nullable();
            $table->string('contact', 50)->nullable();
            $table->string('bio', 255)->nullable();
            $table->string('profile_pic')->nullable();
            $table->string('remember_token')->nullable();
            $table->timestamps();
            $table->primary(['user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
