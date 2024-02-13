<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_certificates', function (Blueprint $table) {
            $table->bigIncrements('certificate_id');
            $table->string('certificate_name', 100);
            $table->string('certified_by');
            $table->year('certificate_year');
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
        Schema::dropIfExists('employee_certificates');
    }
}
