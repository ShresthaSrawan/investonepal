<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfitLoss extends Migration
{
    public function up()
    {
        Schema::create('profit_loss', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('label_id')->unsigned();
            $table->integer('financial_report_id')->unsigned();
            $table->float('value')->nullable();
            $table->foreign('label_id')
                ->references('id')
                ->on('report_label')
                ->onDelete('cascade');
            $table->foreign('financial_report_id')
                ->references('id')
                ->on('financial_report')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('profit_loss', function(Blueprint $table){
            $table->dropForeign('profit_loss_label_id_foreign');
            $table->dropForeign('profit_loss_financial_report_id_foreign');
        });
        Schema::drop('profit_loss');
    }
}
