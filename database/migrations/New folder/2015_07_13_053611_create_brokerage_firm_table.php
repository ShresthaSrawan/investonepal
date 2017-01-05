<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrokerageFirmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brokerage_firm', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firm_name');
            $table->string('code');
            $table->string('phone');
            $table->string('address');
            $table->string('director_name');
            $table->string('mobile');
            $table->text('photo');
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
        Schema::drop('brokerage_firm');
    }
}
