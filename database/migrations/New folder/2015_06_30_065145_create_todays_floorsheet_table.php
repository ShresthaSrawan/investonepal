<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTodaysFloorsheetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todays_floorsheet', function (Blueprint $table) {
            $table->increments('id');
            $table->string('transaction_no')->unique();
            $table->string('stock_symbol');
            $table->integer('buyer_broker');
            $table->integer('seller_broker');
            $table->double('quantity',15,4);
            $table->double('rate',15,4);
            $table->double('amount',15,4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('todays_floorsheet');
    }
}
