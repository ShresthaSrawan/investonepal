<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBullionTypeTable extends Migration
{
    public function up()
    {
        Schema::create('bullion_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('unit');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('bullion_type');
    }
}
