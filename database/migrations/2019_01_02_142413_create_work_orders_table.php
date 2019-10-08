<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code') ;
            $table->text('description');
            $table->date('demand_at');
            $table->integer('employee_id')->unsigned();
            $table->integer('work_order_type_id')->unsigned();
            $table->boolean('billable');
            $table->double('cost');
            $table->string('status',50);
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('work_order_type_id')->references('id')->on('work_order_types');
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
        Schema::dropIfExists('work_orders');
    }
}
