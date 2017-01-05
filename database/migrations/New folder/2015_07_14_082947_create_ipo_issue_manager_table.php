<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIpoIssueManagerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ipo_issue_manager', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('issue_manager_id')->unsigned();
            $table->integer('ipo_pipeline_id')->unsigned();
            $table->foreign('issue_manager_id')
                ->references('id')
                ->on('issue_manager')
                ->onDelete('cascade');
            $table->foreign('ipo_pipeline_id')
                ->references('id')
                ->on('ipo_pipeline')
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
        Schema::table('ipo_issue_manager', function(Blueprint $table){
            $table->dropForeign('ipo_issue_manager_issue_manager_id_foreign');
            $table->dropForeign('ipo_issue_manager_ipo_pipeline_id_foreign');
        });
        Schema::drop('ipo_issue_manager');
    }
}
