<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeEducationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {                    
        Schema::create('employee_educations', function (Blueprint $table) {
            $table->increments('education_id');
            $table->string('degree_level', 55);
            $table->string('degree_name', 55);
            $table->string('major_subject', 100)->nullable();
            $table->string('board_university', 100);
            $table->year('passing_year');
            $table->string('education_result', 55);
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
        Schema::dropIfExists('employee_educations');
    }
}
