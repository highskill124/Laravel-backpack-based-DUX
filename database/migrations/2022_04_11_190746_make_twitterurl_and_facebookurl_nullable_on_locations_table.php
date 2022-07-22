<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeTwitterurlAndFacebookurlNullableOnLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_locations', function (Blueprint $table) {
            $table->string('twitter_url')->nullable()->change();
            $table->string('instagram_url')->nullable()->change();
            $table->string('youtube_url')->nullable()->change();
            $table->string('facebook_url')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business_locations', function (Blueprint $table) {
            $table->string('twitter_url')->nullable(false)->change();
            $table->string('instagram_url')->nullable(false)->change();
            $table->string('youtube_url')->nullable(false)->change();
            $table->string('facebook_url')->nullable(false)->change();
        });
    }
}
