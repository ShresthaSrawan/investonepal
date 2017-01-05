<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmCurrencySellTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('am_currency_sell', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('buy_id')->unsigned();
            $table->date('sell_date');
            $table->double('sell_rate',15,4);
            $table->double('quantity',15,4);
            $table->string('remarks')->nullable();
            $table->timestamps();

            $table->foreign('buy_id')
                ->references('id')
                ->on('am_currency')
                ->onUpdate('cascade')
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
        Schema::table('am_currency_sell', function(Blueprint $table){
            $table->dropForeign('am_currency_sell_buy_id_foreign');
        });

        Schema::drop('am_currency_sell');
    }
}
