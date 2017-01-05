<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIaExternalDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ia_external_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('interview_article_id')->unsigned();
            $table->string('name');
            $table->string('organization');
            $table->string('position');
            $table->string('address');
            $table->string('contact');
            $table->text('photo');
            $table->foreign('interview_article_id')
            	->references('id')
            	->on('interview_article')
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
    	Schema::table('ia_external_detail', function(Blueprint $table){
    		$table->dropForeign('ia_external_detail_interview_article_id_foreign');	
    	});
        Schema::drop('ia_external_detail');
    }
}
