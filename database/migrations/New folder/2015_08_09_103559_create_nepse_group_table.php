<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNepseGroupTable extends Migration
{
    public function up()
    {
        Schema::create('nepse_group', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fiscal_year_id')->unsigned();
            $table->foreign('fiscal_year_id')
                ->references('id')
                ->on('fiscal_year')
                ->onDelete('restrict');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('nepse_group', function(Blueprint $table){
            $table->dropForeign('nepse_group_fiscal_year_id_foreign');
        });
        Schema::drop('nepse_group');
    }
}
