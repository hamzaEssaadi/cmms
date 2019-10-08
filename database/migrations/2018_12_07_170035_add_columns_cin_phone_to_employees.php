<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsCinPhoneToEmployees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
           $table->string('cin' ,30);
           $table->string('phone',30)->nullable();
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
           $table->dropColumn('cin');
           $table->dropColumn('phone');
        });
    }
}
