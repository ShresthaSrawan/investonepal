<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTreasuryBill extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('treasury_bill', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('announcement_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->integer('fiscal_year_id')->unsigned();
            $table->string('serial_number')->nullable();
            $table->double('highest_discount_rate',15,4)->nullable();
            $table->double('lowest_discount_rate',15,4)->nullable();
            $table->integer('bill_days');
            $table->date('issue_open_date')->nullable();
            $table->date('issue_close_date')->nullable();
            $table->double('weighted_average_rate',15,4)->nullable();
            $table->double('slr_rate',15,4)->nullable();
            $table->double('issue_amount',15,4)->nullable();
            $table->foreign('company_id')
                ->references('id')
                ->on('company')
                ->onDelete('cascade');
            $table->foreign('announcement_id')
                ->references('id')
                ->on('announcement')
                ->onDelete('cascade');
            $table->foreign('fiscal_year_id')
                ->references('id')
                ->on('fiscal_year')
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
        Schema::table('treasury_bill', function(Blueprint $table){
            $table->dropForeign('treasury_bill_company_id_foreign');
            $table->dropForeign('treasury_bill_announcement_id_foreign');
            $table->dropForeign('treasury_bill_fiscal_year_id_foreign');
        });
        Schema::drop('treasury_bill');
    }
}
