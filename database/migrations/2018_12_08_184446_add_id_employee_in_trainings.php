<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdEmployeeInTrainings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->integer('employee_id')->unsigned()->nullable();
            $table->foreign('employee_id')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->dropForeign(['employee_id']);
            $table->dropColumn('employee_id');
        });
    }
}
