<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_trainings', function (Blueprint $table) {
            $table->bigIncrements('training_id');
            $table->string('training_name', 100);
            $table->date('start_date');
            $table->date('end_date');
            $table->string('training_duration', 55);
            $table->string('training_result', 55);
            $table->string('certified_by', 55);
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
        Schema::dropIfExists('employee_trainings');
    }
}
