<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->bigIncrements('vehicle_id');
            $table->string('manufacturer', 100)->nullable();
            $table->string('vehicle_model', 100)->nullable();
            $table->string('model_year', 20)->nullable();
            $table->string('vehicle_reg_number', 100)->nullable();
            $table->string('vehicle_tax_token', 100)->nullable();
            $table->date('tax_renewal_date')->nullable();
            $table->string('insurance_number', 100)->nullable();
            $table->date('insurance_renewal_date')->nullable();
            $table->string('fitness_certificate', 100)->nullable();
            $table->unsignedInteger('vehicle_type_id')->index()->nullable();
            $table->unsignedInteger('driver_id')->index()->nullable();
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
        Schema::dropIfExists('vehicles');
    }
}
