<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrencyTypeTable extends Migration
{
    public function up()
    {
        Schema::create('currency_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('unit');
            $table->string('country_name');
            $table->text('country_flag');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('currency_type');
    }
}
