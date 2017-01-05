<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgmFiscal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agm_fiscal', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('agm_id')->unsigned();
            $table->integer('fiscal_year_id')->unsigned();
            $table->foreign('agm_id')
                ->references('id')
                ->on('agm')
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
        Schema::table('agm_fiscal', function(Blueprint $table){
            $table->dropForeign('agm_fiscal_fiscal_year_id_foreign');
            $table->dropForeign('agm_fiscal_agm_id_foreign');
        });
        Schema::drop('agm_fiscal');
    }
}
