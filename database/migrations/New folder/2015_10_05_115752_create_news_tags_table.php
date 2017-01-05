<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTagsTable extends Migration
{
    public function up()
    {
        Schema::create('news_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('news_id')->unsigned();
            $table->integer('tag_id')->unsigned();
            $table->foreign('news_id')
                ->references('id')
                ->on('news')
                ->onDelete('cascade');
            $table->foreign('tag_id')
                ->references('id')
                ->on('tag_id')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('news_tags', function(Blueprint $table){
            $table->dropForeign('news_tags_news_id_foreign');
            $table->dropForeign('news_tags_tag_id_foreign');
        });
        Schema::drop('news_tags');
    }
}
