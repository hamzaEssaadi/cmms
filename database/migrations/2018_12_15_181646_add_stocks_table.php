<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('site');
            $table->integer('location_id')->unsigned();
            $table->foreign('location_id')->references('id')->on('locations');
            $table->integer('qte')->unsigned();
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
        Schema::dropIfExists('stocks');
    }
}
