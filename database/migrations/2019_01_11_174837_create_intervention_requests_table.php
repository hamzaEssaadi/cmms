<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterventionRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intervention_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');// first
            $table->string('status');//first pending
            $table->integer('employee_id')->unsigned()->nullable();// first writer
            $table->date('date');//first
            $table->text('description');//first
            $table->integer('equipment_id')->unsigned(); // machine first
            $table->integer('disfunction_id')->nullable()->unsigned() ;
            $table->text('action')->nullable();
            $table->dateTime('stopping_hour'); //first
            $table->dateTime('start_hour')->nullable();
            $table->dateTime('end_hour')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('intervention_requests');
    }
}
