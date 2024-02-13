<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAccountSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_account_settings', function (Blueprint $table) {
            $table->bigIncrements('ua_setting_id');
            $table->string('currency', 20)->nullable();
            $table->string('language', 30)->nullable();
            $table->string('menu_position', 20)->nullable();
            $table->string('theme', 150)->nullable();
            $table->unsignedInteger('user_id')->index()->nullable();
            //$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('facebook', 150)->nullable();
            $table->string('twitter', 150)->nullable();
            $table->string('googleplus', 150)->nullable();
            $table->string('linkedin', 150)->nullable();
            $table->string('instagram', 150)->nullable();
            $table->string('whatsapp', 150)->nullable();
            $table->string('skype', 150)->nullable();
            $table->string('youtube', 150)->nullable();
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
        Schema::dropIfExists('user_account_settings');
    }
}
