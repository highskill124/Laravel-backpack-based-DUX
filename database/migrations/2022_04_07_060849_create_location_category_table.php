<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_category', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('business_locations_id')->nullable()->index('fk_blocations');
            $table->unsignedInteger('category_id')->nullable()->index('fk_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location_category');
    }
}
