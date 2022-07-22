<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0);
            $table->integer('location_id')->nullable();
            $table->string('category_id', 100)->default('');
            $table->string('promotion_title', 200)->default('');
            $table->text('promotion_description');
            $table->text('promotion_fineprint');
            $table->boolean('is_ongoing_promotion')->default(false);
            $table->date('start_date');
            $table->date('end_date');
            $table->tinyInteger('is_active')->default(0)->comment('0: in-active, 1: active, 2: suspended, 3: delete');
            $table->timestamps();
            $table->tinyInteger('vip_promotion')->nullable()->default(0);
            $table->text('vip_promotion_description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promotions');
    }
}
