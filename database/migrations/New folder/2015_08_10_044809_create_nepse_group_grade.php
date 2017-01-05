<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNepseGroupGrade extends Migration
{
    public function up()
    {
        Schema::create('nepse_group_grade', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->integer('nepse_group_id')->unsigned();
            $table->string('grade');
            $table->foreign('company_id')
                ->references('id')
                ->on('company')
                ->onDelete('restrict');
            $table->foreign('nepse_group_id')
                ->references('id')
                ->on('nepse_group')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }
            

    public function down()
    {
        Schema::table('nepse_group_grade', function(Blueprint $table){
            $table->dropForeign('nepse_group_grade_company_id_foreign');
        });
        Schema::drop('nepse_group_grade');
    }
}
