<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NotificationDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_devices', function (Blueprint $table) {
            $table->bigIncrements('device_id');
            $table->string('email', 100)->index()->nullable();
            $table->string('mobile', 30)->index()->nullable();
            $table->string('device_user_type', 30)->nullable();
            $table->string('fcm_token', 255)->nullable();
            $table->string('device_status', 50)->nullable();
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
        Schema::dropIfExists('notification_devices');
    }
}
