<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInterventionIdToOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->integer('intervention_request_id')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropColumn('intervention_request_id');
        });
    }
}
