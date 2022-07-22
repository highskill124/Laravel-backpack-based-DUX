<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToLocationCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('location_category', function (Blueprint $table) {
            $table->unique(["business_locations_id", "category_id"], 'loc_cat_unique');
            $table->foreign(['category_id'], 'fk_categories')->references(['id'])->on('categories')->onDelete('CASCADE');
            $table->foreign(['business_locations_id'], 'fk_blocations')->references(['id'])->on('business_locations')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('location_category', function (Blueprint $table) {
            $table->dropForeign('fk_categories');
            $table->dropForeign('fk_blocations');
        });
    }
}
