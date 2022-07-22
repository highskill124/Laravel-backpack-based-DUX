<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationGalleryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_gallery', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('location_id')->default(0);
            $table->string('location_image', 250)->default('');
            $table->tinyInteger('is_active')->default(0)->comment('0: in-active, 1: active, 2: delete');
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
        Schema::dropIfExists('location_gallery');
    }
}
