<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddArticleIdToCommands extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('commands', function (Blueprint $table) {
            $table->integer('article_id')->unsigned()->after('status');
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
        Schema::table('commands', function (Blueprint $table) {
            $table->dropForeign(['article_id']);
            $table->dropColumn('article_id');
        });
    }
}
