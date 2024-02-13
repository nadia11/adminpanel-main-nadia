<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('notification_id');
            $table->string('notification_title')->nullable();
            $table->text('notification_body')->nullable();
            $table->string('notification_icon')->nullable();
            $table->text('notification_url')->nullable();
            $table->string('platform', 50)->nullable();
            $table->string('recipient', 100)->nullable();
            $table->string('type', 10)->nullable();
            $table->string('recipient_qty', 10)->nullable();
            $table->string('status', 10)->default('draft');
            $table->string('reading_status', 10)->default('unread');
            $table->unsignedInteger('reading_user_id')->index()->nullable();
            $table->unsignedInteger('user_id')->index()->nullable();
            //$table->uuid('user_id');
            $table->date('read_at')->nullable();
            $table->date('sent_at')->nullable();
            //$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('notifications');
    }
}
