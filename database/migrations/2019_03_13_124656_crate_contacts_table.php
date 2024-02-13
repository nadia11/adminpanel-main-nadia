<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('contact_id');
            $table->string('contact_name', 100)->nullable();
            $table->string('contact_mobile', 30)->unique();
            $table->string('contact_email', 30)->unique()->nullable();
            $table->string('operator', 50)->nullable();
            $table->string('contact_status', 30)->nullable();
            $table->unsignedInteger('group_id')->index()->nullable();
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
        Schema::dropIfExists('contacts');
    }
}
