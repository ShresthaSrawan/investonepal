<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterviewArticleTable extends Migration
{
    public function up()
    {
        Schema::create('interview_article', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('type');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('category_id')->unsigned();
            $table->integer('company_id')->unsigned()->nullable();
            $table->integer('bullion_type_id')->unsigned()->nullable();
            $table->string('title');
            $table->string('slug');
            $table->text('details');
            $table->dateTime('pub_date');
            $table->string('tags')->nullable();
            $table->foreign('user_id')
            	->references('id')
            	->on('user')
            	->onDelete('set null');
            $table->foreign('category_id')
                ->references('id')
                ->on('news_category')
                ->onDelete('cascade');
            $table->foreign('company_id')
                ->references('id')
                ->on('company')
                ->onDelete('set null');
            $table->foreign('bullion_type_id')
                ->references('id')
                ->on('bullion_type')
                ->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('interview_article', function(Blueprint $table){
            $table->dropForeign('interview_article_category_id_foreign');
            $table->dropForeign('interview_article_company_id_foreign');
            $table->dropForeign('interview_article_user_id_foreign');
            $table->dropForeign('interview_article_bullion_type_id_foreign');
        });
        Schema::drop('interview_article');
    }
}
