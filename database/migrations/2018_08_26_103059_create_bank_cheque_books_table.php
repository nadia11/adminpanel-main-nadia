<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankChequeBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_cheque_books', function (Blueprint $table) {
            $table->bigIncrements('cheque_book_id');
            $table->string('cheque_book_no', 55);
            $table->string('bank_name');
            $table->string('branch', 55);
            $table->unsignedInteger('bank_account_id')->index()->nullable();
            $table->string('account_number', 55);
            $table->date('issue_date');
            $table->string('leaf_prefix')->nullable();
            $table->integer('number_of_leafs');
            $table->integer('first_cheque_no')->nullable();
            $table->integer('last_cheque_no')->nullable();
            $table->string('cheque_book_status', 55)->default('open');
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
        Schema::dropIfExists('bank_cheque_books');
    }
}
