<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnnouncementSubtypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcement_subtype', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');
            $table->string('title');
            $table->text('description');
            $table->integer('announcement_type_id')->unsigned();
            $table->foreign('announcement_type_id')
                ->references('id')
                ->on('announcement_type')
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
        Schema::table('announcement_subtype', function(Blueprint $table){
            $table->dropForeign('announcement_subtype_announcement_type_id_foreign');
        });
        Schema::drop('announcement_subtype');
    }
}
