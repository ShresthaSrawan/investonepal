<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnnouncementMisc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcement_misc', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type_id')->unsigned();
            $table->integer('subtype_id')->unsigned();
            $table->text('title');
            $table->text('description');
            $table->timestamps();

            $table->foreign('type_id')
                ->references('id')
                ->on('announcement_type')
                ->onDelete('cascade');

            $table->foreign('subtype_id')
                ->references('id')
                ->on('announcement_subtype')
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
        Schema::table('announcement_misc',function (Blueprint $table) {
            $table->dropForeign('announcement_misc_type_id_foreign');
            $table->dropForeign('announcement_misc_subtype_id_foreign');
        });
        Schema::drop('announcement_misc');
    }
}
