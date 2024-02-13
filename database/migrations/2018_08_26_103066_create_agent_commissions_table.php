<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_commissions', function (Blueprint $table) {
            $table->id('commission_id');
            $table->string('trip_number', 30)->nullable();
            $table->string('trip_from', 100)->nullable();
            $table->string('trip_to', 100)->nullable();
            $table->decimal('origin_lat', 10,7)->nullable();
            $table->decimal('origin_long', 10,7)->nullable();
            $table->string('distance', 30)->nullable();
            $table->string('duration', 30)->nullable();
            $table->decimal('end_lat', 10,7)->nullable();
            $table->decimal('end_long', 10,7)->nullable();
            $table->string('end_drop_off_location')->nullable();
            $table->float('total_fare', 12, 2)->nullable();
            $table->string('commission_percent', 5)->nullable();
            $table->float('commission', 12, 2)->nullable();
            $table->dateTime('trip_date')->nullable();
            $table->unsignedInteger('agent_id')->index()->nullable();
            $table->unsignedInteger('branch_id')->index()->nullable();
            $table->unsignedInteger('driver_id')->index()->nullable();
            $table->unsignedInteger('rider_id')->index()->nullable();
            $table->unsignedInteger('vehicle_id')->index()->nullable();
            $table->unsignedInteger('vehicle_type_id')->index()->nullable();
            $table->string('payment_status', 30)->nullable();
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
        Schema::dropIfExists('agent_commissions');
    }
}
