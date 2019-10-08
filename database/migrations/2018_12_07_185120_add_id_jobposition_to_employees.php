<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdJobpositionToEmployees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->integer('jobposition_id')->unsigned()->nullable();
            $table->foreign('jobposition_id')->references('id')->on('jobpositions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign(['jobposition_id']);
            $table->dropColumn('jobposition_id');
        });
    }
}
