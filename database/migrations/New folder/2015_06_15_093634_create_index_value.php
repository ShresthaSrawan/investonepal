<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndexValue extends Migration
{
    public function up()
    {
        Schema::create('index_value', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type_id')->unsigned();
            $table->integer('index_id')->unsigned();
            $table->double('value',11,3);
            $table->foreign('type_id')
                ->references('id')
                ->on('index_type')
                ->onDelete('cascade');
            $table->foreign('index_id')
                ->references('id')
                ->on('index')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('index_value',function (Blueprint $table) {
            $table->dropForeign('index_value_type_id_foreign');
            $table->dropForeign('index_value_index_id_foreign');
        });
        Schema::drop('index_value');
    }
}
