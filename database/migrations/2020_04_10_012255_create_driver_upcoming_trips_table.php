<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverUpcomingTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_upcoming_trips', function (Blueprint $table) {
            $table->bigIncrements('upcoming_trip_id');
            $table->string('trip_number', 30)->nullable();
            $table->string('trip_from', 100);
            $table->string('trip_to', 100);
            $table->dateTime('start_date_time');
            $table->string('distance', 100);
            $table->float('fare', 12, 2);
            $table->float('origin_lat', 10,7)->nullable();
            $table->float('origin_lon', 10,7)->nullable();
            $table->float('destination_lat', 10,7)->nullable();
            $table->float('destination_lon', 10,7)->nullable();
            $table->unsignedInteger('rider_id')->index()->nullable();
            $table->unsignedInteger('driver_id')->index()->nullable();
            $table->unsignedInteger('vehicle_id')->index()->nullable();
            $table->unsignedInteger('vehicle_type_id')->index()->nullable();
            $table->unsignedInteger('user_id')->index()->nullable();
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
        Schema::dropIfExists('driver_upcoming_trips');
    }
}
