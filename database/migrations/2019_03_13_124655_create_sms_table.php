<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms', function (Blueprint $table) {
            $table->bigIncrements('sms_id');
            $table->string('trx_id', 100);
            $table->string('sender', 30);
            $table->string('receiver');
            $table->timestamp('sent_time')->nullable();
            $table->string('subject');
            $table->text('message_body');
            $table->string('sms_prefix', 30);
            $table->string('sms_type', 30);
            $table->integer('user_id')->unsigned()->index();
            //$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('status', 191);
            $table->string('masking_status', 30);
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
        Schema::dropIfExists('sms');
    }
}
