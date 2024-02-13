<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromoCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->bigIncrements('promo_code_id');
            $table->string('promo_name');
            $table->string('promo_code');
            $table->date('create_date');
            $table->date('expiry_date');
            $table->float('promo_amount', 12, 2);
            $table->string('promo_code_count', 15);
            $table->string('promo_code_used_count', 15)->nullable();
            $table->string('promo_code_status', 15);
            $table->text('promo_code_note')->nullable();
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
        Schema::dropIfExists('promo_codes');
    }
}
