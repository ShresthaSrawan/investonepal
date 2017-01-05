<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('info_id')->unsigned();
            $table->integer('type_id')->unsigned();
            $table->string('username');
            $table->text('password');
            $table->string('email')->unique();
            $table->string('status',1);
            $table->text('profile_picture')->nullable();
            $table->date('expiry_date');
            $table->boolean('subscribed')->default(1);
            $table->boolean('confirmed')->default(0);
            $table->string('confirmation_code')->nullable();
            $table->rememberToken();
            $table->foreign('info_id')
                ->references('id')
                ->on('user_info')
                ->onDelete('cascade');
            $table->foreign('type_id')
                ->references('id')
                ->on('user_type')
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
        Schema::table('user',function (Blueprint $table) {
            $table->dropForeign('user_info_id_foreign');
            $table->dropForeign('user_type_id_foreign');
        });
        Schema::drop('user');
    }
}
