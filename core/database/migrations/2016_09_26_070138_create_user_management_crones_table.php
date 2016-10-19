<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserManagementCronesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_management_crones', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('fname');
            $table->string('lname');
            $table->string('email');
            $table->string('subject');
            $table->string('message');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_management_crones');
    }
}
