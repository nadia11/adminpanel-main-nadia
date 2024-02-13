<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeBankAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_bank_accounts', function (Blueprint $table) {
            $table->bigIncrements('bank_account_id');
            $table->unsignedInteger('employee_id')->index()->nullable();
            $table->string('account_number', 55);
            $table->unsignedInteger('bank_name_id')->index()->nullable();
            $table->string('branch', 100);
            $table->string('account_type', 55);
            $table->string('swift_code');
            $table->date('opening_date')->nullable();
            $table->string('website', 150)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('phone', 30);
            $table->string('alt_phone', 30)->nullable();
            $table->text('bank_address')->nullable();
            $table->text('bank_note')->nullable();
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
        Schema::dropIfExists('employee_bank_accounts');
    }
}
