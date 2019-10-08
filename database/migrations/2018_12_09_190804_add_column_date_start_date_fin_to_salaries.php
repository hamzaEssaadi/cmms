<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnDateStartDateFinToSalaries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('salaries', function (Blueprint $table) {
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->dateTime('payment_date')->nullable();
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
        Schema::table('salaries', function (Blueprint $table) {
            $table->dropForeign(['employee_id']);
            $table->dropColumn('payment_date');
            $table->dropColumn('end_date');
            $table->dropColumn('start_date');
        });
    }
}
