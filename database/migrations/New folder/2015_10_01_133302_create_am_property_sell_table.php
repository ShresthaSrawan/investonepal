<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmPropertySellTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('am_property_sell', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('property_id')->unsigned();
            $table->date('sell_date');
            $table->double('sell_quantity',15,4);
            $table->double('sell_rate',15,4);
            $table->string('remarks',255)->nullable();
            $table->timestamps();
            
            $table->foreign('property_id')
                ->references('id')
                ->on('am_property')
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
        Schema::drop('am_property_sell');
    }
}
