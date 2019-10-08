<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationsRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('intervention_requests', function (Blueprint $table) {
            $table->foreign('equipment_id')->references('id')->on('equipments');
            $table->foreign('disfunction_id')->references('id')->on('disfunctions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('intervention_requests', function (Blueprint $table) {
            $table->dropForeign(['equipment_id','disfunction_id']);
        });
    }
}
