<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEquipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('serial_number');
            $table->string('model_number');
            $table->boolean('in_service');
            $table->date('purchase_date');
            $table->date('warranty_expiration_date');
            $table->date('starting_date');
            $table->integer('life_time')->unsigned();
            $table->text('security_note');
            $table->double('cost')->unsigned();
            $table->string('contract')->nullable();
            $table->integer('location_id')->unsigned();
            $table->integer('department_id')->unsigned();
            $table->integer('equipment_type_id')->unsigned();
            $table->integer('supplier_id')->unsigned();
            $table->integer('manufacturer_id')->unsigned();
            $table->integer('employee_id')->unsigned();
            $table->foreign('location_id')->references('id')->on('locations');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('equipment_type_id')->references('id')->on('equipment_types');
            $table->foreign('supplier_id')->references('id')->on('providers');
            $table->foreign('manufacturer_id')->references('id')->on('providers');
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
        Schema::dropIfExists('equipments');
    }
}
