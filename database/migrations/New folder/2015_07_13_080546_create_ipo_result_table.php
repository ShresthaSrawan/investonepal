<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIpoResultTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ipo_result', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->integer('code')->nullable();
            $table->integer('application_no');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->integer('applied_kitta');
            $table->integer('alloted_kitta');
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
        Schema::table('ipo_result', function (Blueprint $table) {
            $table->dropForeign('ipo_result_company_id_foreign');
        });
        Schema::drop('ipo_result');
    }
}
