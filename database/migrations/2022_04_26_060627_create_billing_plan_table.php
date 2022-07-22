<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_plans', function (Blueprint $table) {
            $table->id();
            $table->string('title',250);
            $table->text('description')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->string('tenure_type',100)->nullable();
            $table->enum('frequency_interval_unit',['day','week','month','year']);
            $table->string('interval_count',50)->nullable();
            $table->string('total_cycles',10)->nullable();
            $table->text('paypal_plan_link')->nullable();
            $table->string('paypal_plan_id',255)->nullable();
            $table->enum('status',['Created','Active','Inactive']);
            $table->string('taxes_percentage',10)->nullable();
            $table->string('taxes_inclusive',10)->nullable();
            $table->float('price',8,2)->default(0);
            $table->string('currency',10)->nullable();
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
        Schema::dropIfExists('billing_plan');
    }
}
