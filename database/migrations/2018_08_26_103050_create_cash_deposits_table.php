<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_deposits', function (Blueprint $table) {
            $table->increments('cash_deposit_id');
            $table->date('cash_deposit_date');
            $table->unsignedInteger('bank_account_id')->index()->nullable();
            $table->string('account_number', 55);
            $table->string('bank_name');
            $table->string('branch');
            $table->float('cash_deposit_amount', 12, 2);
            $table->text('cash_deposit_desc')->nullable();
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
        Schema::dropIfExists('cash_deposits');
    }
}
