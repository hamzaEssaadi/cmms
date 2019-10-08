<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableSuppliersArticles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers_articles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('supplier_id')->unsigned()->nullable();
            $table->foreign('supplier_id')->references('id')->on('providers');
            $table->integer('article_id')->unsigned()->nullable();
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
        Schema::dropIfExists('suppliers_articles');
    }
}
