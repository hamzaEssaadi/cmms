<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCommandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commands', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->unsigned();
            $table->integer('stock_id')->unsigned();  //from
//            $table->integer('actual_qte')->unsigned(); //qte location stock
            $table->integer('qte_out')->unsigned();
            $table->integer('cost'); //adjusted unitary cost
            $table->date('date');
            $table->text('reason');
            $table->integer('location_id'); //to
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('stock_id')->references('id')->on('stocks');
            $table->foreign('location_id')->references('id')->on('locations');
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
        Schema::dropIfExists('commands');
    }
}
