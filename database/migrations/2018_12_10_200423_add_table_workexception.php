<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableWorkexception extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workexceptions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('exception');
            $table->string('begin_date');
            $table->string('end_date');
            $table->integer('employee_id')->unsigned();
            $table->foreign('employee_id')->references('id')->on('employees');
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
        Schema::dropIfExists('workexceptions');
    }
}
