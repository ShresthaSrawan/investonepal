<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancialReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_report', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fiscal_year_id')->unsigned();
            $table->integer('quarter_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->string('entry_by');
            $table->date('entry_date');
            $table->foreign('company_id')
                ->references('id')
                ->on('company')
                ->onDelete('cascade');
            $table->foreign('fiscal_year_id')
                ->references('id')
                ->on('fiscal_year')
                ->onDelete('cascade');
            $table->foreign('quarter_id')
                ->references('id')
                ->on('quarter')
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
        Schema::table('financial_report', function(Blueprint $table){
            $table->dropForeign('financial_report_quarter_id_foreign');
            $table->dropForeign('financial_report_fiscal_year_id_foreign');
            $table->dropForeign('financial_report_company_id_foreign');
        });
        Schema::drop('financial_report');
    }
}
