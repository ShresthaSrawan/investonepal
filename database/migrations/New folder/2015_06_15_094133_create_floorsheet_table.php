<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFloorsheetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('floorsheet', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->string('transaction_no')->unique();
            $table->integer('buyer_broker');
            $table->integer('seller_broker');
            $table->double('quantity',15,4);
            $table->double('rate',15,4);
            $table->double('amount',15,4);
            $table->date('date');
            $table->timestamps();
            $table->foreign('company_id')
                ->references('id')
                ->on('company')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('floorsheet',function (Blueprint $table) {
            $table->dropForeign('floorsheet_company_id_foreign');
        });
        Schema::drop('floorsheet');
    }
}
