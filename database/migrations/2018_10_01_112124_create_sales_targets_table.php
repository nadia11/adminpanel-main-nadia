<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_targets', function (Blueprint $table) {
            $table->bigIncrements('sales_target_id');
            $table->string('target_name');
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedInteger('employee_id')->index()->nullable();
            $table->unsignedInteger('branch_id')->index()->nullable();
            $table->string('total_target', 20);
            $table->string('min_required_achievement', 20);
            $table->string('achievement', 20)->nullable();
            $table->float('total_commission', 12, 2)->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('sales_targets');
    }
}
