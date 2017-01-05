<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyReviewTable extends Migration
{
    public function up()
    {
        Schema::create('company_review', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('company_id')->unsigned();
            $table->string('type');
            $table->text('review')->nullable();
            $table->date('date');
            $table->text('up_user_id');
            $table->text('down_user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('user')
                ->onDelete('set null');
            $table->foreign('company_id')
                ->references('id')
                ->on('company')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('company_review', function(Blueprint $table){
            $table->dropForeign('company_review_company_id_foreign');
            $table->dropForeign('company_review_user_id_foreign');
        });
        Schema::drop('company_review');
    }
}
