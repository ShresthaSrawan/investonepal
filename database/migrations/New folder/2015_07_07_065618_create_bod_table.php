<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bod', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();

            $table->integer('post_id')->unsigned();
            $table->string('name');
            $table->text('photo');
            $table->text('profile');
            $table->foreign('company_id')
                ->references('id')
                ->on('company')
                ->onDelete('cascade');
            $table->foreign('post_id')
                ->references('id')
                ->on('bod_post')
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
        Schema::table('bod', function(Blueprint $table){
            $table->dropForeign('bod_company_id_foreign');
            $table->dropForeign('bod_post_id_foreign');
        });
        Schema::drop('bod');
    }
}
