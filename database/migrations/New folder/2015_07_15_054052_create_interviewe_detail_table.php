<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntervieweDetailTable extends Migration
{
    public function up()
    {
        Schema::create('interviewe_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('interview_id')->unsigned();
            $table->string('name');
            $table->string('organization')->nullable();
            $table->string('contact')->nullable();
            $table->string('address')->nullable();
            $table->string('position')->nullable();
            $table->text('photo')->nullable();
            $table->foreign('interview_id')
                ->references('id')
                ->on('interview_article')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('interviewe_detail', function(Blueprint $table){
            $table->dropForeign('interviewe_detail_interview_id_foreign');
        });
        Schema::drop('interviewe_detail');
    }
}
