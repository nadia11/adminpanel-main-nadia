<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_ledgers', function (Blueprint $table) {
            $table->bigIncrements('client_ledger_id');
            $table->string('bill_status', 100);
            $table->unsignedInteger('client_bill_id')->index()->nullable();
            $table->string('bill_no', 150)->nullable();
            $table->date('bill_date')->nullable();
            $table->unsignedInteger('po_id')->index()->nullable();
            //$table->string('po_number', 100);
            //$table->string('project_name')->nullable();

            $table->unsignedInteger('client_id')->index()->nullable();
            $table->unsignedInteger('user_id')->index()->nullable();
            $table->unsignedInteger('employee_id')->index()->nullable();

            $table->float('billing_amount', 12, 2)->nullable();
            $table->float('received_amount', 12, 2)->nullable();
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
        Schema::dropIfExists('client_ledgers');
    }
}
