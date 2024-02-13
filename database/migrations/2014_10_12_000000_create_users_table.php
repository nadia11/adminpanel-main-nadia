<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('mobile', 130)->unique();
            //$table->string('role', 50)->default('user');
            $table->integer('role_id')->unsigned()->index();
            $table->date('dob')->nullable();
            $table->string('gender', 7)->nullable();
            $table->string('nid', 25)->nullable();
            $table->string('user_photo')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('status');
            $table->string('activation_key')->nullable();
            $table->string('ip_access', 10)->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->string('device')->nullable();
            $table->macAddress('mac_address')->nullable();
            $table->boolean('verified')->default(false);
            $table->time('user_start_time')->default('00:01');
            $table->time('user_end_time')->default('23:59');
            $table->datetime('last_login_at')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
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
        Schema::dropIfExists('users');
    }
}
