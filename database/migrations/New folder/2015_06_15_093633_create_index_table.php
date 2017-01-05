<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndexTable extends Migration
{
    public function up()
    {
        Schema::create('index', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('index');
    }
}
