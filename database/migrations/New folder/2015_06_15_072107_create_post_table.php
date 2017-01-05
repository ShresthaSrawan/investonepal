<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('company_id')->unsigned()->nullable();
            $table->timestamp('pub_date');
            $table->text('title');
            $table->text('details');
            $table->text('featured_image')->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('user')
                ->onDelete('cascade');
            $table->foreign('company_id')
                ->references('id')
                ->on('company')
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
        Schema::table('post', function(Blueprint $table){
            $table->dropForeign('post_user_id_foreign');
            $table->dropForeign('post_company_id_foreign');
        });
        Schema::drop('post');
    }
}
