<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->text('address');
            $table->string('phone');
            $table->string('email');
            $table->text('web')->nullable();
            $table->date('operation_date')->nullable();
            $table->integer('issue_manager_id')->unsigned()->nullable();
            $table->foreign('issue_manager_id')
                ->references('id')
                ->on('issue_manager')
                ->onDelete('restrict');
            $table->text('profile');
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
        Schema::table('company_detail', function(Blueprint $table){
            $table->dropForeign('company_detail_issue_manager_id_foreign');
        });
        Schema::drop('company_detail');
    }
}
