<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockBuyDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('am_stock_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('buy_id')->unsigned();
            $table->integer('fiscal_year_id')->unsigned();
            $table->integer('stock_dividend')->nullable();
            $table->integer('cash_dividend')->nullable();
            $table->string('right_share')->nullable();
            $table->string('remarks',160)->nullable();
            $table->timestamps();

            $table->foreign('buy_id')
                ->references('id')
                ->on('am_stocks_buy')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('fiscal_year_id')
                ->references('id')
                ->on('fiscal_year')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('am_stock_details', function(Blueprint $table){
            $table->dropForeign('am_stock_details_buy_id_foreign');
            $table->dropForeign('am_stock_details_fiscal_year_id_foreign');
        });

        Schema::drop('am_stock_details');
    }
}
