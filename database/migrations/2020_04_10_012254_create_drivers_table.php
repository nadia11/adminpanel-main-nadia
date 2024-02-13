<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->bigIncrements('driver_id');
            $table->string('driver_name', 100)->nullable();
            $table->string('mobile', 30)->unique();
            $table->string('email', 130)->unique()->nullable();
            $table->string('password')->nullable();
            $table->string('reset_code', 20)->nullable();
            $table->date('reset_date')->nullable();
            $table->date('password_change_date')->nullable();
            $table->string('country_name', 40)->nullable();
            $table->unsignedInteger('division_id')->index()->nullable();
            $table->unsignedInteger('district_id')->index()->nullable();
            $table->unsignedInteger('branch_id')->index()->nullable();
            $table->text('address')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('blood_group', 8)->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('nationality', 50)->nullable();
            $table->string('national_id', 30)->nullable();
            $table->string('driving_licence', 60);
            $table->string('driver_photo')->nullable();
            $table->string('driver_status', 30)->nullable();
            $table->string('approval_status', 30)->nullable();
            $table->string('profile_status', 30)->nullable();
            $table->string('trip_count', 20)->nullable();
            $table->string('referrer_commission_status', 20)->nullable();
            $table->float('wallet_balance', 12, 2)->nullable();
            $table->string('invitation_code', 100)->nullable()->index();
            $table->string('referral_code', 100)->nullable();
            $table->string('referral_name', 100)->nullable();
            $table->string('referral_mobile', 30)->nullable();
            $table->float('latitude', 10,7)->nullable();
            $table->float('longitude', 10,7)->nullable();
            $table->float('marker_heading', 10,7)->nullable();
            $table->string('ratings', 30)->nullable();
            $table->text('note')->nullable();
            $table->unsignedInteger('user_id')->index()->nullable();
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
        Schema::dropIfExists('drivers');
    }
}
