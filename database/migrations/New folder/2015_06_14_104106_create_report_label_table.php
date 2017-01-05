<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportLabelTable extends Migration
{
    public function up()
    {
        Schema::create('report_label', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');
            $table->string('type');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('report_label');
    }
}
