<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrateDriverTripStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_trip_steps', function (Blueprint $table) {
            $table->id('step_id');
            $table->string('trip_number', 30)->nullable();
            $table->dateTime('step_time')->nullable();
            $table->string('step_name', 50)->nullable();
            $table->text('specification')->nullable();
            $table->string('location_name')->nullable();
            $table->float('latitude', 10,7)->nullable();
            $table->float('longitude', 10,7)->nullable();
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
        Schema::dropIfExists('driver_trip_steps');
    }
}
