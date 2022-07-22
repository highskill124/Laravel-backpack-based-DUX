<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChangeFldToBusinessLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_locations', function (Blueprint $table) {
            $table->text('facebook_url')->nullable()->change();
            $table->text('twitter_url')->nullable()->change();
            $table->text('instagram_url')->nullable()->change();
            $table->text('youtube_url')->nullable()->change();
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
            //
        });
    }
}
