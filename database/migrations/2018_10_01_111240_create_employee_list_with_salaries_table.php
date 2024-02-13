<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeListWithSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_list_with_salaries', function (Blueprint $table) {
            $table->bigIncrements('emp_w_salary_id');
            $table->unsignedInteger('employee_id')->index();
            $table->float('basic_salary', 12, 2);
            $table->float('house_rent', 12, 2);
            $table->float('medical_allowance', 12, 2);
            $table->text('description')->nullable();
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
        Schema::dropIfExists('employee_list_with_salaries');
    }
}
