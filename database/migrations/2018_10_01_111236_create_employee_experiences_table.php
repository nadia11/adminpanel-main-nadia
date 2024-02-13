<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_experiences', function (Blueprint $table) {
            $table->bigIncrements('experience_id');
            $table->string('company_name', 100);
            $table->string('position', 100);
            $table->date('start_date');
            $table->date('end_date');
            $table->string('experience_duration', 55);
            $table->string('responsibilities');
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
        Schema::dropIfExists('employee_experiences');
    }
}
