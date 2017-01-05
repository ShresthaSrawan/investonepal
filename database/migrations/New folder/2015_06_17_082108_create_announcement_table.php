<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnnouncementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcement', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('type_id')->unsigned();
            $table->integer('subtype_id')->unsigned()->nullable();
            $table->integer('company_id')->unsigned()->nullable();
            $table->date('event_date')->nullable();
            $table->dateTime('pub_date');
            $table->string('source')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->text('details');
            $table->string('featured_image');
            $table->foreign('user_id')
                ->references('id')
                ->on('user')
                ->onDelete('cascade');
            $table->foreign('type_id')
                ->references('id')
                ->on('announcement_type')
                ->onDelete('cascade');
            $table->foreign('company_id')
                ->references('id')
                ->on('company')
                ->onDelete('cascade');
            $table->foreign('subtype_id')
                ->references('id')
                ->on('announcement_subtype')
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
        Schema::table('announcement', function(Blueprint $table){
            $table->dropForeign('announcement_user_id_foreign');
            $table->dropForeign('announcement_type_id_foreign');
            $table->dropForeign('announcement_subtype_id_foreign');
            $table->dropForeign('announcement_company_id_foreign');
        });
        Schema::drop('announcement');
    }
}
