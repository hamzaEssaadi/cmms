<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableCosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('costs', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->double('cost');
            $table->integer('qte');
            $table->integer('article_id')->nullable();
            $table->foreign('article_id')->references('id')->on('articles');
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
        Schema::dropIfExists('costs');
    }
}
