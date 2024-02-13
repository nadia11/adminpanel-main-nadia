<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayscaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payscale', function (Blueprint $table) {
            $table->increments('payroll_id');
            $table->string('payscale');
            $table->string('payroll_grade', 55);
            $table->string('payroll_period', 55);
            $table->float('payroll_Amount', 10, 2)->nullable();
            $table->date('appraisal_date');
            $table->text('Description');
            $table->unsignedInteger('employee_id')->index();
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
        Schema::dropIfExists('payscale');
    }
}
