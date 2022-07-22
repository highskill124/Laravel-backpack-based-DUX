<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotion_location', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('promotion_id');
            $table->unsignedInteger('location_id');
            // $table->unsignedInteger('promotion_id')->nullable()->index('fk_promotion_id');
            // $table->unsignedInteger('location_id')->nullable()->index('fk_location_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promotion_location');
    }
}
