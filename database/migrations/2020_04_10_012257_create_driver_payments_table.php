<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_payments', function (Blueprint $table) {
            $table->bigIncrements('payment_id');
            $table->string('trx_id', 30)->nullable();
            $table->date('payment_date')->nullable();
            $table->float('payment_amount', 12, 2)->nullable();
            $table->string('payment_status', 30)->nullable();
            $table->string('commission', 20)->nullable();
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
        Schema::dropIfExists('driver_payments');
    }
}
