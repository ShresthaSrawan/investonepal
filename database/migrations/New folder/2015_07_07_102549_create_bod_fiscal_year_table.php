<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBodFiscalYearTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bod_fiscal_year', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bod_id')->unsigned();
            $table->integer('fiscal_year_id')->unsigned();
            $table->foreign('bod_id')
                ->references('id')
                ->on('bod')
                ->onDelete('cascade');
            $table->foreign('fiscal_year_id')
                ->references('id')
                ->on('fiscal_year')
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
        Schema::table('bod_fiscal_year', function(Blueprint $table){
            $table->dropForeign('bod_fiscal_year_bod_id_foreign');
            $table->dropForeign('bod_fiscal_year_fiscal_year_id_foreign');
        });
        Schema::drop('bod_fiscal_year');
    }
}
