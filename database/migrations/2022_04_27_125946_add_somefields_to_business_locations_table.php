<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomefieldsToBusinessLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_locations', function (Blueprint $table) {
            if (!Schema::hasColumn('business_locations', 'created_by')) {

                $table->integer('created_by')->nullable()->after('created_at');
            }
            if (!Schema::hasColumn('business_locations', 'updated_by')) {
                $table->integer('updated_by')->nullable()->after('created_by');
            }

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
    }
}
