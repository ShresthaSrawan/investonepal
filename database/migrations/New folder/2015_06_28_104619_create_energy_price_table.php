<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnergyPriceTable extends Migration
{
    public function up()
    {
        Schema::create('energy_price', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type_id')->unsigned();
            $table->integer('energy_id')->unsigned();
            $table->float('price');
            $table->foreign('energy_id')
                ->references('id')
                ->on('energy')
                ->onDelete('cascade');
            $table->foreign('type_id')
                ->references('id')
                ->on('energy_type')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('energy_price', function(Blueprint $table){
            $table->dropForeign('energy_price_type_id_foreign');
            $table->dropForeign('energy_price_energy_id_foreign');
        });
        Schema::drop('energy_price');
    }
}
