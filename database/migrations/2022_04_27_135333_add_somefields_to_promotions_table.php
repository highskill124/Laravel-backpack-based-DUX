<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomefieldsToPromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->text('promotion_description')->change();
            $table->text('promotion_fineprint')->change();
            $table->integer('location_ids')->nullable()->after('user_id');
            $table->text('category_id')->nullable()->after('location_ids');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->dropColumn('location_ids');
            $table->dropColumn('category_id');
        });
    }
}
