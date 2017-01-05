<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInfoTable extends Migration
{
    public function up()
    {
        Schema::create('user_info', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('address');
            $table->string('work');
            $table->string('phone');
            $table->date('dob');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('user_info');
    }
}
