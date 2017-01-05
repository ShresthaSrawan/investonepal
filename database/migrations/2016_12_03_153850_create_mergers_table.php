<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMergersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mergers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->index()->unsigned();
            $table->string('companies');
            $table->string('remarks')->nullable();
            $table->date('loi_date')->nullable();
            $table->date('deadline_date')->nullable();
            $table->date('mou_date')->nullable();
            $table->date('application_date')->nullable();
            $table->date('approved_date')->nullable();
            $table->date('join_transaction_date')->nullable();
            $table->string('swap_ratio')->nullable();
            $table->enum('trading', ['YES', 'NO', 'SUSPEND']);
            $table->enum('type', ['MERGER', 'ACQUISITION']);
            $table->enum('status', ['COMPLETED', 'ON PROCESS']);
            $table->foreign('company_id')
                ->references('id')
                ->on('company')
                ->onDelete('restrict');
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
        Schema::drop('mergers');
    }
}
