<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewHighLowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_high_low', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->double('high',15,4);
            $table->date('high_date');
            $table->double('low',15,4);
            $table->date('low_date');
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
        Schema::table('new_high_low', function(Blueprint $table){
            $table->dropForeign('new_high_low_company_id_foreign');
        });
        Schema::drop('new_high_low');
    }
}
