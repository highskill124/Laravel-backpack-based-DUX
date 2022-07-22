<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plan_id');
            $table->unsignedBigInteger('user_id');
            $table->string('start_time')->nullable();
            $table->integer('quantity');
            $table->decimal('shipping_amount',8,2)->nullable();
            $table->string('currency_code',10)->nullable();
            $table->string('customer_name',100)->nullable();
            $table->string('payer_id',100)->nullable();
            $table->string('subscription_id')->nullable();
            $table->string('ba_token')->nullable();
            $table->string('token')->nullable();
            $table->text('subscriptions_response')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
}
