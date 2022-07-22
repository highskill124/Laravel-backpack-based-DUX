<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeysToPromotionLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotion_location', function (Blueprint $table) {

            //$table->dropForeign('fk_location_id');
            //$table->foreign(['location_id'], 'fk_location_id')->references(['id'])->on('business_locations')->onDelete('RESTRICT');
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

            //$table->dropForeign('fk_location_id');
        });
    }
}
