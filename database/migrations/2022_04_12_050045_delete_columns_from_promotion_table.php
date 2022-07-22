<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteColumnsFromPromotionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotions', function (Blueprint $table) {


                $table->dropColumn('location_id');
                $table->dropColumn('category_id');
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

                $table->integer('location_id')->unsigned()->nullable()->after('created_at');
                $table->integer('category_id')->unsigned()->nullable()->after('location_id');
            });

    }
}
