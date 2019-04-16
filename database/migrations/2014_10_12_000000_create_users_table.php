<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->text('roles')->nullable();
            $table->char('bukrs',4)->index()->nullable();
            $table->foreign('bukrs')->references('bukrs')->on('companies');
            $table->integer('department_id')->unsigned()->index()->nullable();
            $table->foreign('department_id')->references('id')->on('departments');
            $table->integer('position_id')->unsigned()->index()->nullable();
            $table->foreign('position_id')->references('id')->on('positions');
            $table->string('avatar')->default('user.jpg');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
