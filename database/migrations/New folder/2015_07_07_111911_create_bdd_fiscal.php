<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBddFiscal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bdd_fiscal', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bbd_id')->unsigned();
            $table->integer('fiscal_year_id')->unsigned();
            $table->foreign('bbd_id')
                ->references('id')
                ->on('bonus_dividend_distribution')
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
        Schema::table('bdd_fiscal', function(Blueprint $table){
            $table->dropForeign('bdd_fiscal_fiscal_year_id_foreign');
            $table->dropForeign('bdd_fiscal_bbd_id_foreign');
        });
        Schema::drop('bdd_fiscal');
    }
}
