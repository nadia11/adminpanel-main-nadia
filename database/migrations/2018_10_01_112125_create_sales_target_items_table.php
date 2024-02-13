<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTargetItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_target_items', function (Blueprint $table) {
            $table->bigIncrements('sales_target_item_id');
            $table->unsignedInteger('sales_target_id')->index()->nullable();
            $table->string('sti_product_name');
            $table->string('sti_brand', 100)->nullable();
            $table->integer('sti_qty');
            $table->string('sti_uom', 25);
            $table->float('sti_rate', 12, 2);
            $table->float('sti_target', 12, 2);
            $table->float('commission_rate', 12, 2);
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
        Schema::dropIfExists('sales_target_items');
    }
}
