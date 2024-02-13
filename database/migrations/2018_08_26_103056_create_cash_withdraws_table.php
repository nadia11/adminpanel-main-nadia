<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashWithdrawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_withdraws', function (Blueprint $table) {
            $table->bigIncrements('withdraw_id');
            $table->date('withdraw_date');
            //$table->unsignedInteger('party_id')->index()->nullable();
            //$table->string('party_type')->nullable();
            //$table->string('party_name')->nullable();
            $table->unsignedInteger('bank_account_id')->index()->nullable();
            $table->string('account_number', 55);
            $table->string('bank_name');
            $table->string('branch', 55);
            $table->string('cheque_book_id', 55);
            $table->string('cheque_leaf_id', 55)->nullable();
            $table->string('cheque_number', 55);
            $table->date('cheque_date');
            $table->float('cheque_amount', 12, 2);
            $table->text('withdraw_desc')->nullable();
            $table->string('withdraw_status');
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
        Schema::dropIfExists('cash_withdraws');
    }
}
