<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_transfers', function (Blueprint $table) {
            $table->bigIncrements('transfer_id');
            $table->date('transfer_date');
            $table->string('transfer_reference')->nullable();
            $table->unsignedInteger('client_id')->index();
            $table->string('account_number', 55);
            $table->string('beneficiary_name')->nullable();
            $table->unsignedInteger('bank_account_id')->index()->nullable();
            $table->string('bank_name', 100);
            $table->string('bank_branch', 100)->nullable();
            $table->float('transfer_amount', 12, 2);
            $table->unsignedInteger('po_id')->index()->nullable();
            //$table->string('po_number', 55)->nullable();
            //$table->date('po_date')->nullable();
            $table->unsignedInteger('client_bill_id')->index()->nullable();
            //$table->string('bill_no', 55);
            //$table->date('bill_date');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('bank_transfers');
    }
}
