<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',150);
            $table->string('description',300);
            $table->date('date_start');
            $table->date('date_end');
            $table->string('note');
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
        Schema::dropIfExists('trainings');
    }
}
