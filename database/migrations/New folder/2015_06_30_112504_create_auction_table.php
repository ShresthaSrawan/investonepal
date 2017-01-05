<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuctionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auction', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('issue_id')->unsigned();
            $table->integer('ordinary');
            $table->integer('promoter');
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
        Schema::table('auction', function(Blueprint $table){
            $table->dropForeign('auction_issue_id_foreign');
        });
        Schema::drop('auction');
    }
}
