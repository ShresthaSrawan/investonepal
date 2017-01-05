<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('sector_id')->unsigned();
            $table->integer('detail_id')->unsigned();
            $table->integer('listed_shares')->default(0);
            $table->integer('face_value')->default(0);
            $table->integer('total_paid_up_value')->default(0);
            $table->string('quote');
            $table->string('name');
            $table->boolean('listed');
            $table->text('logo');
            $table->boolean('issue_status');
            $table->foreign('sector_id')
                ->references('id')
                ->on('sector')
                ->onDelete('cascade');
            $table->foreign('detail_id')
                ->references('id')
                ->on('company_detail')
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
        Schema::table('company',function (Blueprint $table) {
            $table->dropForeign('company_detail_id_foreign');
            $table->dropForeign('company_sector_id_foreign');
        });
        Schema::drop('company');
    }
}
