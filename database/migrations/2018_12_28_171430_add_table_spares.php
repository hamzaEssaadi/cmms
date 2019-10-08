<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableSpares extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spares', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('equipment_id')->unsigned();
            $table->integer('article_id')->unsigned();
            $table->foreign('equipment_id')->references('id')->on('equipments');
            $table->foreign('article_id')->references('id')->on('articles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spares');
    }
}
