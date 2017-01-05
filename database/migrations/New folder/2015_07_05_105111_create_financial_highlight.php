<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancialHighlight extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_highlight', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fiscal_year_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->integer('announcement_id')->unsigned();
            $table->double('paid_up_capital',15,4);
            $table->double('reserve_and_surplus',15,4);
            $table->double('earning_per_share',15,4);
            $table->double('net_worth_per_share',15,4);
            $table->double('book_value_per_share',15,4);
            $table->double('net_profit',15,4);
            $table->string('liquidity_ratio',15,4);
            $table->string('price_earning_ratio',15,4);
            $table->double('operating_profit',15,4);
            $table->foreign('company_id')
                ->references('id')
                ->on('company')
                ->onDelete('cascade');
            $table->foreign('fiscal_year_id')
                ->references('id')
                ->on('fiscal_year')
                ->onDelete('cascade');
            $table->foreign('announcement_id')
                ->references('id')
                ->on('announcement')
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
        Schema::table('financial_highlight', function(Blueprint $table){
            $table->dropForeign('financial_highlight_company_id_foreign');
            $table->dropForeign('financial_highlight_fiscal_year_id_foreign');
            $table->dropForeign('financial_highlight_announcement_id_foreign');
        });
        Schema::drop('financial_highlight');
    }
}
