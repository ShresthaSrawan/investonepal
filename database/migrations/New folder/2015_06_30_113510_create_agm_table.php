<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agm', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->integer('announcement_id')->unsigned();
            $table->string('count');
            $table->string('venue')->nullable();
            $table->bigInteger('bonus')->nullable();
            $table->double('dividend',15,4)->nullable();
            $table->time('time')->nullable();
            $table->date('book_closer_from')->nullable();
            $table->date('book_closer_to')->nullable();
            $table->dateTime('agm_date');
            $table->text('agenda');
            $table->foreign('company_id')
                ->references('id')
                ->on('company')
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
        Schema::table('agm', function(Blueprint $table){
            $table->dropForeign('agm_company_id_foreign');
            $table->dropForeign('agm_announcement_id_foreign');
        });
        Schema::drop('agm');
    }
}
