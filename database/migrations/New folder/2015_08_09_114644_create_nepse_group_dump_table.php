<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNepseGroupDumpTable extends Migration
{
    public function up()
    {
        Schema::create('nepse_group_dump', function (Blueprint $table) {
            $table->increments('id');
            $table->string('quote');
            $table->string('grade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('nepse_group_dump');
    }
}
