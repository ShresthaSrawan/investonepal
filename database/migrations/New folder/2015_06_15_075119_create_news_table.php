<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('company_id')->unsigned()->nullable();
            $table->integer('bullion_id')->unsigned()->nullable();
            $table->string('source')->nullable();
            $table->string('location')->nullable();
            $table->string('title');
            $table->dateTime('pub_date');
            $table->text('details');
            $table->string('slug');
            $table->dateTime('event_date')->nullable();
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
            $table->foreign('bullion_id')
                ->references('id')
                ->on('bullion_type')
                ->onDelete('set null');
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
        Schema::table('news', function(Blueprint $table){
            $table->dropForeign('news_user_id_foreign');
            $table->dropForeign('news_category_id_foreign');
            $table->dropForeign('news_company_id_foreign');
            $table->dropForeign('news_bullion_id_foreign');
        });
        Schema::drop('news');
    }
}
