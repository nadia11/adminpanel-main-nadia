<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_loans', function (Blueprint $table) {
            $table->bigIncrements('loan_id');
            $table->string('loan_no');
            $table->string('loan_type', 55);
            $table->date('application_date');
            $table->date('possible_disburse_date');
            $table->date('disburse_date');
            $table->integer('total_installment');
            $table->integer('paid_installment');
            $table->float('paid_amount', 12, 2)->nullable();
            $table->date('verified_date');
            $table->string('verified_by', 55);
            $table->float('verified_amount', 12, 2)->nullable();
            $table->float('verified_installment_amount', 12, 2)->nullable();
            $table->integer('verified_total_installment');
            $table->date('approved_date');
            $table->string('approved_by', 55);
            $table->float('approved_amount', 12, 2)->nullable();
            $table->float('approved_installment_amount', 12, 2)->nullable();
            $table->integer('approved_total_installment');
            $table->string('paid');
            $table->tinyInteger('status');
            $table->unsignedInteger('employee_id')->index()->nullable();
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
        Schema::dropIfExists('employee_loans');
    }
}
