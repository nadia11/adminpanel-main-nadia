<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->bigIncrements('email_id');
            $table->string('from');
            $table->string('to');
            $table->string('cc')->nullable();
            $table->string('bcc')->nullable();
            $table->timestamp('email_date')->nullable();
            $table->string('subject')->nullable();
            $table->text('message')->nullable();
            $table->string('attachment')->nullable();
            $table->string('email_type', 30);
            $table->string('email_attribute', 30)->default('Not starred');
            $table->string('email_status', 30)->nullable();
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
        Schema::dropIfExists('emails');
    }
}
