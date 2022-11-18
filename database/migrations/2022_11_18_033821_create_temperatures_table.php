<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temperatures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->integer('dt');
            $table->string('dubai_time');
            $table->string('condition');
            $table->string('condition_icon');
            $table->float('temp');
            $table->float('feels_like_temp');
            $table->integer('humidity');
            $table->float('wind_speed');
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
        Schema::dropIfExists('temperatures');
    }
};
