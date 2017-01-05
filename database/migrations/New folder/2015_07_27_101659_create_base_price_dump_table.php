<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBasePriceDumpTable extends Migration
{
    public function up()
    {
        Schema::create('base_price_dump', function (Blueprint $table) {
            $table->increments('id');
            $table->string('quote');
            $table->double('price', 15,4);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('base_price_dump');
    }
}
