<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('am_stocks_buy', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('basket_id')->unsigned();
            $table->integer('type_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->string('shareholder_number',100)->nullable();
            $table->string('certificate_number')->nullable();
            $table->string('owner_name')->nullable();
            $table->date('buy_date');
            $table->integer('quantity');
            $table->double('buy_rate',8,2);
            $table->double('commission',9,2)->nullable();
            $table->timestamps();

            $table->foreign('basket_id')
                ->references('id')
                ->on('am_stock_basket')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('type_id')
                ->references('id')
                ->on('am_stock_types')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('company_id')
                ->references('id')
                ->on('company')
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
        Schema::table('am_stocks_buy', function(Blueprint $table){
            $table->dropForeign('am_stocks_buy_company_id_foreign');
            $table->dropForeign('am_stocks_buy_basket_id_foreign');
            $table->dropForeign('am_stocks_buy_type_id_foreign');
        });
        Schema::drop('am_stocks_buy');
    }
}
