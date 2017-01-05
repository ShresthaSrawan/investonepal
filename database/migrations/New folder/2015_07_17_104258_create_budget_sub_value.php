<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetSubValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_sub_value', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('budget_id')->unsigned();
            $table->integer('sub_label_id')->unsigned();
            $table->double('value',15,4);
            $table->foreign('sub_label_id')
                ->references('id')
                ->on('budget_sub_label')
                ->onDelete('cascade');
            $table->foreign('budget_id')
                ->references('id')
                ->on('budget')
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
        Schema::table('budget_sub_value', function(Blueprint $table){
            $table->dropForeign('budget_sub_value_sub_label_id_foreign');
            $table->dropForeign('budget_sub_value_budget_id_foreign');
        });
        Schema::drop('budget_sub_value');
    }
}
