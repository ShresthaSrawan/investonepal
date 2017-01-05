<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrencyRateTable extends Migration
{
    public function up()
    {
        Schema::create('currency_rate', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type_id')->unsigned();
            $table->integer('currency_id')->unsigned();
            $table->float('buy')->nullable();
            $table->float('sell')->nullable();
            $table->foreign('type_id')
                ->references('id')
                ->on('currency_type')
                ->onDelete('cascade');
            $table->foreign('currency_id')
                ->references('id')
                ->on('currency')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('currency_rate', function(Blueprint $table){
            $table->dropForeign('currency_rate_type_id_foreign');
            $table->dropForeign('currency_rate_currency_id_foreign');
        });
        Schema::drop('currency_rate');
    }
}
