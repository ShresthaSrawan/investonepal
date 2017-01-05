<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEconomyValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('economy_value', function (Blueprint $table) {
            $table->increments('id');
            $table->string('value');
            $table->date('date');
            $table->integer('economy_id')->unsigned();
            $table->integer('label_id')->unsigned();
            $table->timestamps();

            $table->foreign('label_id')
                ->references('id')
                ->on('economy_label')
                ->onDelete('restrict');

            $table->foreign('economy_id')
                ->references('id')
                ->on('economy')
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
        Schema::table('economy_value', function(Blueprint $table){
            $table->dropForeign('economy_value_economy_id_foreign');
            $table->dropForeign('economy_value_label_id_foreign');
        });
        Schema::drop('consolidate_revenue_dump');
    }
}
