<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurposesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purposes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('usage_note');
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
        Schema::dropIfExists('purposes');
    }
}
