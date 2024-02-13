<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTodoListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todo_lists', function (Blueprint $table) {
            $table->increments('todo_id');
            $table->string('todo_name', 55);
            $table->integer('list_order')->default(0);
            $table->string('status', 20)->default('active')->nullable();
            $table->string('archived_status', 20)->default('active')->nullable();
            //$table->boolean('status')->default(false); //same as $table->tinyInteger('status')->default(0);
            $table->text('todo_description')->nullable();
            $table->string('color_name', 20)->nullable();
            $table->integer('user_id')->unsigned()->index();
            //$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('todo_lists');
    }
}
