<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->bigIncrements('agent_id');
            $table->string('agent_name', 100);
            $table->string('fathers_name', 100);
            $table->string('mothers_name', 100);
            $table->string('country_name', 40);
            $table->unsignedInteger('division_id')->index()->nullable();
            $table->unsignedInteger('district_id')->index()->nullable();
            $table->unsignedInteger('branch_id')->index()->nullable();
            $table->string('branch_name')->nullable();
            $table->text('branch_address')->nullable();
            $table->string('mobile', 30);
            $table->string('alt_mobile', 30)->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('reset_code', 20)->nullable();
            $table->date('reset_date')->nullable();
            $table->date('password_change_date')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('blood_group', 8);
            $table->string('gender', 20)->nullable();
            $table->string('religion', 30)->nullable();
            $table->string('nationality', 50)->nullable();
            $table->string('national_id', 30)->nullable();
            $table->string('nid_copy')->nullable();
            $table->string('agent_status', 30)->nullable();
            $table->float('commission', 12, 2)->nullable();
            $table->float('wallet_balance', 12, 2)->nullable();
            $table->double('total_earnings', 12, 2)->nullable();
            $table->date('reg_date')->nullable();
            $table->text('note')->nullable();
            $table->float('latitude', 10, 7)->nullable();
            $table->float('longitude', 10, 7)->nullable();
            $table->string('agent_photo')->nullable();
            $table->string('trade_licence_number', 30)->nullable();
            $table->string('trade_licence')->nullable();
            $table->string('tin_number', 30)->nullable();
            $table->string('tin_certificate')->nullable();
            $table->string('vat_number', 30)->nullable();
            $table->string('vat_certificate')->nullable();
            $table->unsignedInteger('user_id')->index()->nullable();
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
        Schema::dropIfExists('agents');
    }
}
