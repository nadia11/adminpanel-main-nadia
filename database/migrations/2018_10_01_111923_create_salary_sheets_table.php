<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalarySheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_sheets', function (Blueprint $table) {
            $table->bigIncrements('salary_sheet_id');
            $table->unsignedInteger('employee_id')->index();
            $table->date('month_name');
            $table->float('basic_salary', 12, 2);
            $table->float('house_rent', 12, 2);
            $table->float('medical_allowance', 12, 2);
            $table->float('conveyance', 12, 2)->nullable();
            $table->float('mobile_bill', 12, 2)->nullable();
            $table->float('absent_deduction', 12, 2)->nullable();
            $table->float('motor_cycle_loan', 12, 2)->nullable();
            $table->float('loan_deduction', 12, 2)->nullable();
            $table->float('salary_refund', 12, 2)->nullable();
            $table->float('tada_pay', 12, 2)->nullable();
            $table->float('medical_pay', 12, 2)->nullable();
            $table->float('food_pay', 12, 2)->nullable();
            $table->float('overtime_pay', 12, 2)->nullable();
            $table->float('others_pay', 12, 2)->nullable();
            $table->float('attendance_bonus_pay', 12, 2)->nullable();
            $table->float('festival_bonus_pay', 12, 2)->nullable();
            $table->text('salary_sheet_description')->nullable();
            $table->integer('user_id')->unsigned()->index();
            //$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('salary_sheets');
    }
}
