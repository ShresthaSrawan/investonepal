<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmPropertyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('am_property', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->string('asset_name');
            $table->string('unit');
            $table->string('owner_name')->nullable();
            $table->date('buy_date');
            $table->double('quantity',15,4);
            $table->double('rate',15,4);
            $table->double('market_rate',15,4)->nullable();
            $table->date('market_date')->nullable();
            /*
            $table->double('total_amount',15,4);

            */
            $table->foreign('user_id')
                ->references('id')
                ->on('user')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('am_property', function(Blueprint $table){
            $table->dropForeign('am_property_user_id_foreign');
        });

        Schema::drop('am_property');
    }
}
