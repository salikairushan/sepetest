<?php

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
            $table->engine = "InnoDB";
            $table->increments('id');
            $table->string('fname');
            $table->string('lname');
            $table->string('email');
            $table->string('password');
            $table->tinyInteger('gender');
            //1 - Male , 2 - Female
            $table->tinyInteger('priority');
            //1 - none , 2 - lecturer , 3 - OP
            $table->tinyInteger('role');
            //1 - user, 2 - lv2user, 3 - operator, 4 - admin, 5 - super admin
            $table->boolean('verified')->default(false);
            $table->boolean('active')->default(false);
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
        Schema::drop('users');
    }
}
