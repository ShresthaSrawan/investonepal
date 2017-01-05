<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLastTradedPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('last_traded_price', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->integer('company_id')->unique()->unsigned();
            $table->date('date');
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
        Schema::table('last_traded_price', function (Blueprint $table) {
            $table->dropForeign('last_traded_price_company_id_foreign');
        });
        Schema::drop('last_traded_price');
    }
}
