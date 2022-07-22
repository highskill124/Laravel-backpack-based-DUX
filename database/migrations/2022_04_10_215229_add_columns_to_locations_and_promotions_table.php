<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToLocationsAndPromotionsTable extends Migration
{
    public function up()
    {
        Schema::table('business_locations', function (Blueprint $table) {
            $table->integer('created_by')->unsigned()->nullable()->after('created_at');
            $table->integer('updated_by')->unsigned()->nullable()->after('created_by');
        });

        Schema::table('promotions', function (Blueprint $table) {
            $table->integer('created_by')->unsigned()->nullable()->after('created_at');
            $table->integer('updated_by')->unsigned()->nullable()->after('created_by');
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
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
        });
        Schema::table('promotions', function (Blueprint $table) {
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
        });
    }
}
