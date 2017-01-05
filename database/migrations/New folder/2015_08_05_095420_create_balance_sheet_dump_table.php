<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBalanceSheetDumpTable extends Migration
{
    public function up()
    {
        Schema::create('balance_sheet_dump', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');
            $table->double('value',15,4);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('balance_sheet_dump');
    }
}
