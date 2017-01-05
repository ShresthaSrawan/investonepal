<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnergyTypeTable extends Migration
{
    public function up()
    {
        Schema::create('energy_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('unit');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('energy_type');
    }
}
