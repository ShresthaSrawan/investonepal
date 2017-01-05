<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEconomyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('economy', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fiscal_year_id')->unsigned();
            $table->timestamps();

            $table->foreign('fiscal_year_id')
                ->references('id')
                ->on('fiscal_year')
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
        Schema::table('economy', function(Blueprint $table){
            $table->dropForeign('economy_fiscal_year_id_foreign');
        });
        Schema::dropIfExists('economy');
    }
}
