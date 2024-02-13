<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->bigIncrements('leave_id');
            $table->string('application_no', 55);
            $table->date('leave_date');
            $table->string('leave_type', 30);
            $table->string('leave_period', 55);
            $table->integer('applied_days');
            $table->integer('approved_days');
            $table->tinyInteger('status');
            $table->string('bill', 55);
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
        Schema::dropIfExists('leaves');
    }
}
