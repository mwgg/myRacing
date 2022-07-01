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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->integer('series_id');
            $table->integer('license_group');
            $table->integer('season_id');
            $table->integer('season_year');
            $table->integer('season_quarter');
            $table->integer('race_week_num');
            $table->integer('track_id');
            $table->string('track_name');
            $table->string('config_name');
            $table->integer('current_week');
            $table->boolean('favorite')->default(false);
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
        Schema::dropIfExists('schedules');
    }
};
