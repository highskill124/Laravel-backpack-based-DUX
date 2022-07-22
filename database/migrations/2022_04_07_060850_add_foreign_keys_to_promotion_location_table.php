<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPromotionLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotion_location', function (Blueprint $table) {
            $table->unique(["promotion_id", "location_id"], 'prom_loc_unique');
            $table->foreign(['promotion_id'], 'fk_promotion_id')->references(['id'])->on('promotions')->onDelete('CASCADE');
            $table->foreign(['location_id'], 'fk_location_id')->references(['id'])->on('business_locations')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promotion_location', function (Blueprint $table) {
            $table->dropForeign('fk_promotion_id');
            $table->dropForeign('fk_location_id');
        });
    }
}
