<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserprofilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userprofiles', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->unique('user_id', 'user_profiles_user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->char('bukrs',4)->index()->nullable();
            $table->foreign('bukrs')->references('bukrs')->on('companies');
            $table->integer('department_id')->unsigned()->index()->nullable();
            $table->foreign('department_id')->references('id')->on('departments');
            $table->integer('position_id')->unsigned()->index()->nullable();
            $table->foreign('position_id')->references('id')->on('positions');
            $table->string('telp_office')->nullable();
            $table->string('telp_mobile')->nullable();
            $table->string('avatar')->default('user.jpg');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('userprofiles');
    }
}
