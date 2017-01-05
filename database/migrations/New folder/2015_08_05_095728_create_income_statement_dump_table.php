<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncomeStatementDumpTable extends Migration
{
    public function up()
    {
        Schema::create('income_statement_dump', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');
            $table->double('value',15,4);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('income_statement_dump');
    }
}
