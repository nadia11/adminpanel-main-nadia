<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_taxes', function (Blueprint $table) {
            $table->bigIncrements('tax_id');
            $table->string('year', 10)->nullable();
            $table->date('payment_date')->nullable();
            $table->string('tax_type', 30)->nullable();
            $table->string('tax_status', 30)->nullable();
            $table->float('payment_amount', 12, 2)->nullable();
            $table->unsignedInteger('driver_id')->index()->nullable();
            $table->unsignedInteger('vehicle_id')->index()->nullable();
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
        Schema::dropIfExists('driver_taxes');
    }
}
