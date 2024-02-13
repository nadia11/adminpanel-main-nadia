<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankChequeLeafsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_cheque_leafs', function (Blueprint $table) {
            $table->bigIncrements('cheque_leaf_id');
            $table->unsignedInteger('cheque_book_id')->index();
            $table->string('cheque_number', 55);
            $table->string('cheque_leaf_status', 55)->nullable();
            $table->string('leaf_unused_reason')->nullable();
            $table->date('leaf_issue_date')->nullable();
            $table->float('cheque_leaf_amount', 12, 2)->nullable();
            $table->unsignedInteger('voucher_id')->index()->nullable();
            $table->unsignedInteger('party_id')->index()->nullable();
            $table->string('party_type', 55)->nullable();
            $table->string('party_name', 100)->nullable();
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
        Schema::dropIfExists('bank_cheque_leafs');
    }
}
