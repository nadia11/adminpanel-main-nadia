<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankReceivedChequeChangeHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_received_cheque_change_histories', function (Blueprint $table) {
            $table->bigIncrements('change_history_id');
            $table->string('received_cheque_status', 55)->nullable();
            $table->date('transaction_date')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('received_cheque_id')->nullable();
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
        Schema::dropIfExists('bank_received_cheque_change_histories');
    }
}
