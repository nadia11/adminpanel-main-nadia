<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('client_id');
            $table->string('client_name', 120);
            $table->string('client_short_name', 30);
            $table->text('client_address');
            $table->string('contract_person_name', 100)->nullable();
            $table->string('contract_person_mobile', 25)->nullable();
            $table->string('contract_person_email', 150)->nullable();
            $table->string('client_website', 100)->nullable();
            $table->unsignedInteger('employee_id')->index()->nullable();
            $table->unsignedInteger('division_id')->index()->nullable();
            $table->unsignedInteger('district_id')->index()->nullable();
            $table->string('client_whatsapp', 25)->nullable();
            $table->string('client_facebook', 150)->nullable();
            $table->string('bill_format')->nullable();
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
        Schema::dropIfExists('clients');
    }
}
