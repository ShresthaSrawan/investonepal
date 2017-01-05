<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmStockSellTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('am_stocks_sell', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('buy_id')->unsigned();
            $table->date('sell_date');
            $table->integer('quantity');
            $table->double('sell_rate',8,2);
            $table->double('commission',9,2)->nullable();
            $table->double('total_tax',9,2)->nullable();
            $table->string('note',160);
            $table->timestamps();

            $table->foreign('buy_id')
                ->references('id')
                ->on('am_stocks_buy')
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
        Schema::table('am_stocks_sell', function(Blueprint $table){
            $table->dropForeign('am_stocks_sell_buy_id_foreign');
        });
        Schema::drop('am_stocks_sell');
    }
}
