<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTodaysPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todays_price', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->date('date');
            $table->integer('tran_count');
            $table->float('open');
            $table->float('close');
            $table->float('high');
            $table->float('low');
            $table->integer('volume');
            $table->double('amount',15,4);
            $table->timestamps();
            $table->foreign('company_id')
                ->references('id')
                ->on('company')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('todays_price',function (Blueprint $table) {
            $table->dropForeign('todays_price_company_id_foreign');
        });
        Schema::drop('todays_price');
    }
}
