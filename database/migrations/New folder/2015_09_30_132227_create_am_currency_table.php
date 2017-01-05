<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmCurrencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('am_currency', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->integer('type_id')->unsigned();
            $table->double('total_amount',15,4);
            $table->date('buy_date');
            $table->double('quantity',15,4);
            $table->timestamps();

            $table->foreign('type_id')
                ->references('id')
                ->on('currency_type')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('user')
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
        Schema::table('am_currency', function(Blueprint $table){
            $table->dropForeign('am_currency_type_id_foreign');
            $table->dropForeign('am_currency_user_id_foreign');
        });
        
        Schema::drop('am_currency');
    }
}
