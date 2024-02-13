<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_transactions', function (Blueprint $table) {
            $table->bigIncrements('trx_id');
            $table->date('trx_date');
            $table->string('trx_type', 100);
            $table->unsignedInteger('voucher_id')->nullable();
            $table->unsignedInteger('party_id')->index()->nullable();
            $table->string('party_type', 55)->nullable();
            $table->string('party_name', 150)->nullable();
            $table->unsignedInteger('bank_account_id')->index()->nullable();
            $table->string('account_number', 55);
            $table->string('cheque_number', 55)->nullable();
            $table->date('cheque_date')->nullable();
            $table->string('bank_name')->nullable();
            $table->date('bank_date')->nullable();
            $table->string('cheque_type', 55)->nullable();
            $table->float('debit', 12, 2)->nullable();
            $table->float('credit', 12, 2)->nullable();
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
        Schema::dropIfExists('bank_transactions');
    }
}
