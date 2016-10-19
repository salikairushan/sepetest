<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBatchesTable extends Migration
{
    public $timestamps = false;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->increments('id');
            $table->string('batch_id')->nullable();
            $table->tinyInteger('stream');
            $table->tinyInteger('type');
            $table->integer('student_count');
            $table->integer('year');
            $table->tinyInteger('batch_no');
            $table->boolean('active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('batches');
    }
}
