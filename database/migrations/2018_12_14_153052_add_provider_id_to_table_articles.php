<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProviderIdToTableArticles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->integer('manufacturer_id')->unsigned()->nullable();
            $table->foreign('manufacturer_id')->references('id')->on('providers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign(['manufacturer_id']);
            $table->dropColumn('manufacturer_id');
        });
    }
}
