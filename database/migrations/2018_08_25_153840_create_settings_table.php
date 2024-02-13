<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('setting_id');
            $table->string('company_name', 100)->nullable();
            $table->string('logo')->nullable();
            $table->string('company_phone', 25)->nullable();
            $table->string('company_email', 100)->nullable();
            $table->string('currency', 20)->nullable();
            $table->string('menu_position', 20)->nullable();
            $table->tinyInteger('keyboard')->nullable();
            $table->string('discount', 5)->nullable();
            $table->string('tax', 5)->nullable();
            $table->string('timezone', 255)->nullable();
            $table->string('language', 30)->nullable();
            $table->tinyInteger('decimals')->nullable();
            $table->text('receiptheader')->nullable();
            $table->text('receiptfooter')->nullable();
            $table->tinyInteger('stripe')->nullable();
            $table->string('stripe_secret_key', 150)->nullable();
            $table->string('stripe_publishable_key', 150)->nullable();
            $table->string('theme', 150)->nullable();
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
        Schema::dropIfExists('settings');
    }
}
