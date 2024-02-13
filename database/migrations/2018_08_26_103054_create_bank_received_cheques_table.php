<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankReceivedChequesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_received_cheques', function (Blueprint $table) {
            $table->bigIncrements('received_cheque_id');
            $table->date('received_date');
            $table->unsignedInteger('voucher_id')->nullable();
            $table->string('cheque_number', 55);
            $table->date('cheque_date');
            $table->string('cheque_type', 55);
            $table->unsignedInteger('client_id')->index()->nullable();
            $table->string('client_bank');
            $table->unsignedInteger('bank_account_id')->index()->nullable();
            $table->string('received_bank')->nullable();
            $table->string('received_branch', 100)->nullable();
            $table->string('money_receipt_no', 55)->nullable();
            $table->float('cheque_amount', 12, 2)->nullable();
            $table->string('collection_person')->nullable();
            $table->unsignedInteger('po_id')->index()->nullable();
            $table->unsignedInteger('client_bill_id')->index()->nullable();
            $table->text('description')->nullable();
            $table->string('received_cheque_status')->nullable();
            //$table->string('dr_account')->nullable(); //voucher account
            //$table->string('tag_so')->nullable();
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
        Schema::dropIfExists('bank_received_cheques');
    }
}
