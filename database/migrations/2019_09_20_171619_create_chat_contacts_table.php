<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_contacts', function (Blueprint $table) {
            $table->bigIncrements('chat_contact_id');
            $table->string('star_status', 30)->default('NotStarred');
            $table->string('archive_status', 30)->default('NotArchive');
            $table->string('spam_status', 30)->default('NotSpam');
            $table->string('block_status', 30)->default('unblock');
            $table->unsignedInteger('user_id')->index()->nullable();
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
        Schema::dropIfExists('chat_contacts');
    }
}
