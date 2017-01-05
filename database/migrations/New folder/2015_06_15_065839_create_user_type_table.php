<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');
            $table->string('news_rights',4);
            $table->string('portfolio_rights',4);
            $table->string('data_rights',4);
            $table->string('user_rights',4);
            $table->string('crawl_rights',4);
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
        Schema::drop('user_type');
    }
}
