<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImIssue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('im_issue', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('im_id')->unsigned();
            $table->integer('issue_id')->unsigned();
            $table->foreign('im_id')
                ->references('id')
                ->on('issue_manager')
                ->onDelete('cascade');
            $table->foreign('issue_id')
                ->references('id')
                ->on('issue')
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
        Schema::table('im_issue', function(Blueprint $table){
            $table->dropForeign('im_issue_issue_id_foreign');
            $table->dropForeign('im_issue_im_id_foreign');
        });
        Schema::drop('im_issue');
    }
}
