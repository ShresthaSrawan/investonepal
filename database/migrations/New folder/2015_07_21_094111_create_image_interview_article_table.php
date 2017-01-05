<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageInterviewArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_interview_article', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('interview_article_id')->unsigned();
            $table->string('featured_image');
            $table->foreign('interview_article_id')
              ->references('id')
              ->on('interview_article')
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
        Schema::table('image_interview_article', function(Blueprint $table){
          $table->dropForeign('image_interview_article_interview_article_id_foreign');
        });
        Schema::drop('image_interview_article');
    }
}
