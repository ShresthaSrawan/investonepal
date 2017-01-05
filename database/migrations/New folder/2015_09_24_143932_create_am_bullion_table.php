<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmBullionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('am_bullion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('type_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('owner_name');
            $table->date('buy_date');
            $table->double('quantity',15,4);
            $table->double('total_amount',15,4);
            $table->timestamps();

            $table->foreign('type_id')
                ->references('id')
                ->on('bullion_type')
                ->onUpdate('cascade')
                ->onDelete('restrict');

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
        Schema::table('am_bullion', function(Blueprint $table){
            $table->dropForeign('am_bullion_type_id_foreign');
            $table->dropForeign('am_bullion_user_id_foreign');
        });

        Schema::drop('am_bullion');
    }
}
