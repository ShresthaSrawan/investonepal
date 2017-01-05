<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetSubLabelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_sub_label', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('budget_label_id')->unsigned();
            $table->string('label');
            $table->foreign('budget_label_id')
                ->references('id')
                ->on('budget_label')
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
        Schema::table('budget_sub_label', function(Blueprint $table){
            $table->dropForeign('budget_sub_label_budget_label_id_foreign');
        });
        Schema::drop('budget_sub_label');
    }
}
