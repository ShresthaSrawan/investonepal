<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrencyTable extends Migration
{
    public function up()
    {
        Schema::create('currency', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('currency');
    }
}
