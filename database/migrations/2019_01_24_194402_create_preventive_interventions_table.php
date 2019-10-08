<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreventiveInterventionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preventive_interventions', function (Blueprint $table) {
            $table->increments('id');
//            $table->dateTime('date');
            $table->string('status',10);
            $table->text('description');
            $table->dateTime('intervention_start');
            $table->dateTime('intervention_end');
            $table->integer('employee_id')->unsigned();
            $table->integer('equipment_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('preventive_interventions');
    }
}
