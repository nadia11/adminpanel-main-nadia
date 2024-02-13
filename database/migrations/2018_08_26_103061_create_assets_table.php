<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->increments('asset_id');
            $table->string('asset_name', 150);
            $table->string('asset_type', 55);
            $table->date('asset_opening_date');
            $table->integer('asset_qty');
            $table->string('asset_uom', 55);
            $table->float('asset_rate', 12, 2);
            $table->float('asset_total_amount', 12, 2);
            $table->text('asset_description')->nullable();
            $table->unsignedInteger('user_id')->index()->nullable();
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
        Schema::dropIfExists('assets');
    }
}
