<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveFieldsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'image-url')) {
                $table->dropColumn('image-url');
            }
            if (Schema::hasColumn('products', 'image_url')) {
                $table->dropColumn('image_url');
            }
            if (Schema::hasColumn('products', 'home-url')) {
                $table->dropColumn('home-url');
            }
            if (Schema::hasColumn('products', 'home_url')) {
                $table->dropColumn('home_url');
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
        Schema::table('products', function (Blueprint $table) {
            
        });
    }
}
