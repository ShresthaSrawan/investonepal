<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsolidateRevenueDumpTable extends Migration
{
    public function up()
    {
        Schema::create('consolidate_revenue_dump', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');
            $table->double('value',15,4);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('consolidate_revenue_dump');
    }
}
