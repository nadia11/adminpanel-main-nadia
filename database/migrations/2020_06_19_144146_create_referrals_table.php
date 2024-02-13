<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referrals', function (Blueprint $table) {
            $table->bigIncrements('referral_id');
            $table->string('referral_code', 30)->nullable();
            $table->string('referral_nid')->index()->nullable();
            $table->string('referral_links')->nullable();
            $table->string('referrer_type', 30)->nullable();
            $table->float('referral_count', 12, 2)->nullable();
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
        Schema::dropIfExists('referrals');
    }
}
