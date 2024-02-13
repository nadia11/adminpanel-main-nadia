<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverEarningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_earnings', function (Blueprint $table) {
            $table->bigIncrements('driver_earning_id');
            $table->string('trip_number', 30)->nullable();
            $table->string('distance', 30)->nullable();
            $table->float('total_fare', 12, 2)->nullable();
            $table->float('agency_commission', 12, 2)->nullable();
            $table->float('agent_commission', 12, 2)->nullable();
            $table->float('total_earnings', 12, 2)->nullable();
            $table->string('payment_mode', 30)->nullable();
            $table->string('payment_status', 30)->nullable();
            $table->unsignedInteger('trip_id')->index()->nullable();
            $table->unsignedInteger('vehicle_type_id')->index()->nullable();
            $table->unsignedInteger('vehicle_id')->index()->nullable();
            $table->unsignedInteger('driver_id')->index()->nullable();
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
        Schema::dropIfExists('driver_earnings');
    }
}
