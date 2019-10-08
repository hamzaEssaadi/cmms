<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableEmployees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees',function (Blueprint $table)
        {
           $table->increments('id');
           $table->string('code');
           $table->string('name');
           $table->string('nationality');
           $table->date('birth_date');
           $table->date('hiring_date')->nullable();
           $table->string('address');
           $table->string('zip_code');
           $table->string('social_security_no');
           $table->string('image')->nullable();
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
        Schema::dropIfExists('employees');
    }
}
