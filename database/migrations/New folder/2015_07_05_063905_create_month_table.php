<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMonthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('month', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');
            $table->integer('quarter_id')->unsigned();
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
        Schema::table('month', function(Blueprint $table){
            $table->dropForeign('month_quarter_id_foreign');
        });
        Schema::drop('month');
    }
}
