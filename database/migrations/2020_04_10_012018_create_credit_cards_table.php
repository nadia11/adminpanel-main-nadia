<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_cards', function (Blueprint $table) {
            $table->bigIncrements('credit_card_id');
            $table->string('card_type', 30)->nullable();
            $table->string('card_holder_name', 100)->nullable();
            $table->string('card_number', 50)->nullable();
            $table->string('expires_at', 15)->nullable();
            $table->string('cvv_number', 15)->nullable();
            $table->string('icon', 30)->nullable();
            $table->unsignedInteger('rider_id')->index()->nullable();
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
        Schema::dropIfExists('credit_cards');
    }
}
