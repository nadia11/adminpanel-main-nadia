<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashbookEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashbook_entries', function (Blueprint $table) {
            $table->bigIncrements('cashbook_id');
            $table->timestamp('entry_date')->nullable();
            $table->string('voucher_number', 55)->nullable();
            $table->unsignedInteger('account_head_id')->index()->nullable();
            $table->unsignedInteger('party_id')->index()->nullable();
            $table->string('party_type', 55)->nullable();
            $table->string('party_name', 100)->nullable();
            $table->string('payment_method', 55)->nullable();
            $table->text('description')->nullable();
            $table->float('debit', 12, 2)->nullable();
            $table->float('credit', 12, 2)->nullable();
            $table->unsignedInteger('client_id')->index()->nullable();
            $table->unsignedInteger('expense_for')->index()->nullable();
            $table->unsignedInteger('user_id')->index()->nullable();
            $table->string('entry_type', 100)->nullable();
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
        Schema::dropIfExists('cashbook_entries');
    }
}
