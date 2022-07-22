<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0);
            $table->string('location_name', 250)->default('');
            $table->text('by_line')->nullable();
            $table->text('location_description')->nullable();
            $table->string('location_address', 500)->default('');
            $table->string('website', 250)->default('');
            $table->string('email_id', 250)->default('');
            $table->string('phone_number', 100)->default('');
            $table->string('facebook_url', 500)->default('');
            $table->string('twitter_url', 500)->default('');
            $table->string('instagram_url', 500)->default('');
            $table->string('youtube_url', 500)->default('');
            $table->decimal('latitude', 14, 10)->default(0);
            $table->decimal('longitude', 14, 10)->default(0);
            $table->string('category_id', 250)->default('0');
            $table->tinyInteger('is_active')->default(0)->comment('0: in-active, 1: active, 2: suspended, 3: delete');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->tinyInteger('is_open_sunday')->default(0);
            $table->tinyInteger('is_open_monday')->default(0);
            $table->tinyInteger('is_open_tuesday')->default(0);
            $table->tinyInteger('is_open_wednesday')->default(0);
            $table->tinyInteger('is_open_thrusday')->default(0);
            $table->tinyInteger('is_open_friday')->default(0);
            $table->tinyInteger('is_open_saturday')->default(0);
            $table->time('start_time_sunday')->default('00:00:00');
            $table->time('end_time_sunday')->default('00:00:00');
            $table->time('start_time_monday')->default('00:00:00');
            $table->time('end_time_monday')->default('00:00:00');
            $table->time('start_time_tuesday')->default('00:00:00');
            $table->time('end_time_tuesday')->default('00:00:00');
            $table->time('start_time_wednesday')->default('00:00:00');
            $table->time('end_time_wednesday')->default('00:00:00');
            $table->time('start_time_thrusday')->default('00:00:00');
            $table->time('end_time_thrusday')->default('00:00:00');
            $table->time('start_time_friday')->default('00:00:00');
            $table->time('end_time_friday')->default('00:00:00');
            $table->time('start_time_saturday')->default('00:00:00');
            $table->time('end_time_saturday')->default('00:00:00');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business_locations');
    }
}
