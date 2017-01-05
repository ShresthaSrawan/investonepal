<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIpoPipelineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ipo_pipeline', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->integer('fiscal_year_id')->unsigned();
            $table->integer('announcement_subtype_id')->unsigned();
            $table->double('amount_of_securities');
            $table->double('amount_of_public_issue');
            $table->date('approval_date');
            $table->date('application_date');
            $table->string('remarks');
            $table->foreign('company_id')
                ->references('id')
                ->on('company')
                ->onDelete('cascade');
            $table->foreign('fiscal_year_id')
                ->references('id')
                ->on('fiscal_year')
                ->onDelete('cascade');
            $table->foreign('announcement_subtype_id')
                ->references('id')
                ->on('announcement_subtype')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('ipo_pipeline', function(Blueprint $table){
            $table->dropForeign('ipo_pipeline_company_id_foreign');
            $table->dropForeign('ipo_pipeline_fiscal_year_id_foreign');
            $table->dropForeign('ipo_pipeline_announcement_subtype_id_foreign');
        });
        Schema::drop('ipo_pipeline');
    }
}
