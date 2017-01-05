<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issue', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned()->nullable();
            $table->integer('announcement_id')->unsigned();
            $table->integer('fiscal_year_id')->unsigned();
            $table->double('face_value',15,4);
            //$table->double('operating_profit',15,4)->nullable();
            $table->double('kitta',15,4)->nullable();
            $table->date('issue_date');
            $table->date('close_date');
            $table->string('ratio')->nullable();
            $table->foreign('company_id')
                ->references('id')
                ->on('company')
                ->onDelete('cascade');
            $table->foreign('announcement_id')
                ->references('id')
                ->on('announcement')
                ->onDelete('cascade');
            $table->foreign('fiscal_year_id')
                ->references('id')
                ->on('fiscal_year')
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
        Schema::table('issue', function(Blueprint $table){
            $table->dropForeign('issue_company_id_foreign');
            $table->dropForeign('issue_announcement_id_foreign');
            $table->dropForeign('issue_fiscal_year_id_foreign');
        });
        Schema::drop('issue');
    }
}
