<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddArticleIdToStocks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->integer('article_id')->unsigned();
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
        Schema::table('stocks', function (Blueprint $table) {
            $table->dropForeign(['article_id']);
            $table->dropColumn('article_id');
        });
    }
}
