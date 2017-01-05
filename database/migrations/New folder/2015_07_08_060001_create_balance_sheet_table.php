<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBalanceSheetTable extends Migration
{
    public function up()
    {
        Schema::create('balance_sheet', function (Blueprint $table) {
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
        Schema::table('balance_sheet', function(Blueprint $table){
            $table->dropForeign('balance_sheet_label_id_foreign');
            $table->dropForeign('balance_sheet_financial_report_id_foreign');
        });
        Schema::drop('balance_sheet');
    }
}
