<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->bigIncrements('chat_message_id');
            $table->text('message_body');
            $table->string('reading_status', 10)->default('unread');
            $table->boolean('deleted_from_sender')->default(0);
            $table->boolean('deleted_from_receiver')->default(0);
            $table->unsignedInteger('sender_id')->index()->nullable();
            $table->unsignedInteger('conversation_id')->index()->nullable();
            //$table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('chat_messages');
    }
}
