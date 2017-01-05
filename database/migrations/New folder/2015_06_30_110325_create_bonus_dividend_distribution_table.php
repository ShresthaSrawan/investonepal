<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBonusDividendDistributionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonus_dividend_distribution', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->integer('announcement_id')->unsigned();
            $table->integer('fiscal_year_id')->unsigned();
            $table->float('bonus_share')->nullable();
            $table->double('cash_dividend',15,4)->nullable();
            $table->date('distribution_date');
            $table->boolean('is_bod_approved')->default(0);
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
        Schema::table('bonus_dividend_distribution', function(Blueprint $table){
            $table->dropForeign('bonus_dividend_distribution_company_id_foreign');
            $table->dropForeign('bonus_dividend_distribution_announcement_id_foreign');
            $table->dropForeign('bonus_dividend_distribution_fiscal_year_id_foreign');
        });
        Schema::drop('bonus_dividend_distribution');
    }
}
