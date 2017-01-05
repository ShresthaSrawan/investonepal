<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBondAndDebenture extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('bond_and_debenture', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('announcement_id')->unsigned();
            $table->integer('company_id')->unsigned()->nullable();
            $table->integer('fiscal_year_id')->unsigned();
            $table->string('title_of_securities');
            $table->double('face_value',15,4);
            $table->double('kitta',15,4);
            $table->integer('maturity_period');
            $table->date('issue_open_date');
            $table->date('issue_close_date');
            $table->double('coupon_interest_rate',15,4);
            $table->string('interest_payment_method');
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
        Schema::table('bond_and_debenture', function(Blueprint $table){
            $table->dropForeign('bond_and_debenture_company_id_foreign');
            $table->dropForeign('bond_and_debenture_announcement_id_foreign');
            $table->dropForeign('bond_and_debenture_fiscal_year_id_foreign');
        });
        Schema::drop('bond_and_debenture');
    }
}
