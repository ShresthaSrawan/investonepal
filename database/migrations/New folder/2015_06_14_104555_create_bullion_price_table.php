<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBullionPriceTable extends Migration
{
    public function up()
    {
        Schema::create('bullion_price', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type_id')->unsigned();
            $table->integer('bullion_id')->unsigned();
            $table->float('price');
            $table->foreign('type_id')
                ->references('id')
                ->on('bullion_type')
                ->onDelete('cascade');
            $table->foreign('bullion_id')
                ->references('id')
                ->on('bullion')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('bullion_price', function(Blueprint $table){
            $table->dropForeign('bullion_price_type_id_foreign');
            $table->dropForeign('bullion_price_bullion_id_foreign');
        });
        Schema::drop('bullion_price');
    }
}
