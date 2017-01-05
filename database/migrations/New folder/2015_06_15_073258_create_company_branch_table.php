<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyBranchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_branch', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->text('address');
            $table->string('phone');
            $table->string('email');
            $table->timestamps();
            $table->foreign('company_id')
                ->references('id')
                ->on('company')
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
        Schema::table('company_branch', function (Blueprint $table) {
            $table->dropForeign('company_branch_company_id_foreign');
        });
        Schema::drop('company_branch');
    }
}
