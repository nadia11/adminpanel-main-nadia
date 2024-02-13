<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('employee_id');
            $table->string('employee_type', 50)->nullable();
            $table->string('employee_code', 100)->nullable();
            $table->string('cardID', 100)->nullable();
            $table->string('employee_name', 100);
            $table->string('employee_fathers_name', 100)->nullable();
            $table->string('employee_mothers_name', 100)->nullable();
            $table->string('employee_mobile', 30);
            $table->string('employee_alt_mobile', 30)->nullable();
            $table->string('employee_email', 100)->nullable();
            $table->unsignedInteger('designation_id')->index();
            $table->unsignedInteger('department_id')->index();
            $table->unsignedInteger('branch_id')->nullable()->index();
            $table->text('employee_address')->nullable();
            $table->date('employee_dob')->nullable();
            $table->string('marital_status', 10)->nullable();
            $table->string('employee_religion', 30)->nullable();
            $table->string('employee_nationality', 55)->nullable();
            $table->string('employee_nid', 25)->nullable();
            $table->string('employee_gender', 20)->nullable();
            $table->string('birth_certificate', 100)->nullable();
            $table->string('passport_no', 50)->nullable();
            $table->string('blood_group', 20)->nullable();
            $table->string('employee_status', 15)->nullable();
            $table->string('employee_photo')->nullable();
            $table->date('joining_date')->nullable();
            $table->unsignedInteger('division_id')->index()->nullable();
            $table->unsignedInteger('district_id')->index()->nullable();
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
        Schema::dropIfExists('employees');
    }
}
