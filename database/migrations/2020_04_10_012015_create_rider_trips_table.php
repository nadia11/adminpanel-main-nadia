<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiderTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rider_trips', function (Blueprint $table) {
            $table->bigIncrements('rider_trip_id');
            $table->string('trip_number', 50)->nullable();
            $table->string('trip_from', 100)->nullable();
            $table->string('trip_to', 100)->nullable();
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->string('distance', 30)->nullable();
            $table->string('duration', 30)->nullable();
            $table->float('fare', 12, 2)->nullable();
            $table->string('trip_status', 30)->nullable();

            $table->string('cancelled_by', 30)->nullable();
            $table->string('reason_for_cancellation', 100)->nullable();
            $table->dateTime('cancellation_time')->nullable();
            $table->float('destination_change_fee', 12, 2);
            $table->integer('delay_cancellation_minute');
            $table->float('delay_cancellation_fee', 12, 2);

            $table->decimal('payment_amount', 10,2)->nullable();
            $table->string('payment_method', 30)->nullable();
            $table->string('payment_status', 30)->nullable();
            $table->string('end_drop_off_location')->nullable();
            $table->string('trip_map_screenshot')->nullable();
            $table->float('end_lat', 10,7)->nullable();
            $table->float('end_long', 10,7)->nullable();
            $table->float('origin_lat', 10,7)->nullable();
            $table->float('origin_long', 10,7)->nullable();
            $table->float('destination_lat', 10,7)->nullable();
            $table->float('destination_long', 10,7)->nullable();
            $table->string('trip_ratings', 30)->nullable();
            $table->string('rating_text')->nullable();
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
        Schema::dropIfExists('rider_trips');
    }
}
