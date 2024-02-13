<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSearchingTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('searching_trips', function (Blueprint $table) {
            $table->bigIncrements('searching_trip_id');
            $table->string('trip_number', 50)->nullable();
            $table->string('trip_from', 100)->nullable();
            $table->string('trip_to', 100)->nullable();
            $table->dateTime('searching_time')->nullable();
            $table->string('distance', 30)->nullable();
            $table->string('duration', 30)->nullable();
            $table->float('fare', 12, 2)->nullable();
            $table->string('platform', 60)->nullable();
            $table->float('origin_lat', 10,7)->nullable();
            $table->float('origin_long', 10,7)->nullable();
            $table->float('destination_lat', 10,7)->nullable();
            $table->float('destination_long', 10,7)->nullable();
            $table->unsignedInteger('rider_id')->index()->nullable();
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
        Schema::dropIfExists('searching_trips');
    }
}
