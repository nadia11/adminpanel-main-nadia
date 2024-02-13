<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riders', function (Blueprint $table) {
            $table->bigIncrements('rider_id');
            $table->string('rider_name', 100);
            $table->string('mobile', 30)->unique();
            $table->string('email', 130)->unique()->nullable();
            $table->string('password')->nullable();
            $table->string('reset_code', 20)->nullable();
            $table->date('reset_date')->nullable();
            $table->date('password_change_date')->nullable();
            $table->text('address')->nullable();
            $table->date('dob')->nullable();
            $table->string('blood_group', 8)->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('rider_photo')->nullable();
            $table->string('rider_status', 30)->nullable();
            $table->float('wallet_balance', 12,2 )->nullable();
            $table->string('trip_count', 20)->nullable();
            $table->string('referrer_commission_status', 20)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('national_id', 30)->nullable();
            $table->string('invitation_code', 100)->nullable()->index();
            $table->string('referral_code', 100)->nullable();
            $table->string('referral_name', 100)->nullable();
            $table->string('referral_mobile', 30)->nullable();
            $table->float('home_latitude', 10, 7)->nullable();
            $table->float('home_longitude', 10, 7)->nullable();
            $table->float('latitude', 10, 7)->nullable();
            $table->float('longitude', 10, 7)->nullable();
            $table->string('ratings', 30)->nullable();
            $table->unsignedInteger('user_id')->index()->nullable();
            $table->unsignedInteger('division_id')->index()->nullable();
            $table->unsignedInteger('district_id')->index()->nullable();
            $table->unsignedInteger('branch_id')->index()->nullable();
            $table->date('reg_date')->nullable();
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
        Schema::dropIfExists('riders');
    }
}
