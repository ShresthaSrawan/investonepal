<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnergyTable extends Migration
{
    public function up()
    {
        Schema::create('energy', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('energy');
    }
}
