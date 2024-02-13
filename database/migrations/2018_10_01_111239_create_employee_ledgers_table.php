<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_ledgers', function (Blueprint $table) {
            $table->bigIncrements('employee_ledger_id');
            $table->date('entry_date');
            $table->string('voucher_number', 55);
            $table->string('payment_method', 55)->nullable();
            $table->unsignedInteger('account_head_id')->index()->nullable();
            $table->unsignedInteger('employee_id')->index()->nullable();
            $table->unsignedInteger('cashbook_id')->index()->nullable();
            $table->unsignedInteger('user_id')->index()->nullable();
            $table->date('month_name')->nullable();
            $table->string('entry_type', 100)->nullable();
            $table->float('amount', 10, 2);
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
        Schema::dropIfExists('employee_ledgers');
    }
}
