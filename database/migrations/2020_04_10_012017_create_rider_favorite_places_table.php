<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiderFavoritePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rider_favorite_places', function (Blueprint $table) {
            $table->bigIncrements('favorite_place_id');
            $table->string('main_text', 100)->nullable();
            $table->string('secondary_text', 200)->nullable();
            $table->float('latitude', 10,7)->nullable();
            $table->float('longitude', 10,7)->nullable();
            $table->string('place_id', 150)->nullable();
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
        Schema::dropIfExists('rider_favorite_places');
    }
}
