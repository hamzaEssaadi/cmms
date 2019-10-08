<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('name');
            $table->string('country');
            $table->string('city');
            $table->string('zip_code');
            $table->string('phone');
            $table->string('address');
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->string('web_site')->nullable();
            $table->string('director');
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
        Schema::dropIfExists('providers');
    }
}
