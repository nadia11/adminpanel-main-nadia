<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventAndNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_and_news', function (Blueprint $table) {
            $table->bigIncrements('news_id');
            $table->string('news_title')->nullable();
            $table->longText('news_body')->nullable();
            $table->longText('news_body_short')->nullable();
            $table->float('view_count', 10,0)->default(0)->nullable();
            $table->string('news_picture')->nullable();
            $table->string('news_status', 30)->default('draft');
            $table->unsignedInteger('category_id')->index()->nullable();
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
        Schema::dropIfExists('event_and_news');
    }
}
