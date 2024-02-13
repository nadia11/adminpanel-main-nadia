<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fares', function (Blueprint $table) {
            $table->bigIncrements('fare_id');
            $table->unsignedInteger('vehicle_type_id')->index()->nullable();
            $table->string('period_type', 20)->nullable();
            $table->string('start_time', 10)->nullable();
            $table->string('end_time', 10)->nullable();
            $table->float('fare_per_km', 12, 2);
            $table->float('waiting_fare', 12, 2);
            $table->float('minimum_fare', 12, 2);
            $table->string('minimum_distance', 30);
            $table->float('destination_change_fee', 12, 2);
            $table->integer('delay_cancellation_minute');
            $table->float('delay_cancellation_fee', 12, 2);
            $table->text('note')->nullable();
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
        Schema::dropIfExists('fares');
    }
}
