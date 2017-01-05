<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fiscal_year_id')->unsigned();
            $table->integer('label_id')->unsigned();
            $table->double('value',15,4);
            $table->foreign('label_id')
                ->references('id')
                ->on('budget_label')
                ->onDelete('cascade');
            $table->foreign('fiscal_year_id')
                ->references('id')
                ->on('budget_fiscal_year')
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
        Schema::table('budget', function(Blueprint $table){
            $table->dropForeign('budget_label_id_foreign');
            $table->dropForeign('budget_fiscal_year_id_foreign');
        });
        Schema::drop('budget');
    }
}
