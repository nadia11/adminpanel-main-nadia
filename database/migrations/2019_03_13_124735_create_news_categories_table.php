<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNewsCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create table for storing categories
        Schema::create('news_categories', function (Blueprint $table) {
            $table->increments('category_id');
            $table->integer('parent_id')->unsigned()->nullable()->default(null);
            //$table->foreign('parent_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('set null');
            $table->integer('category_order')->default(1);
            $table->string('category_name');
            $table->string('category_slug')->unique();
            $table->string('category_icon')->nullable();
            $table->string('category_image')->nullable();
            $table->boolean('category_status')->default(1);
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
        Schema::drop('news_categories');
    }
}
