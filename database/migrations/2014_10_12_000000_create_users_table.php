<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('business_address', 200)->nullable();
            $table->string('your_position', 200)->nullable();
            $table->string('city', 200)->nullable();
            $table->string('state_name', 200)->nullable();
            $table->string('zip_code', 200)->nullable();
            $table->string('country', 200)->nullable();
            $table->string('phone', 200)->nullable();
            $table->string('business_name', 200)->nullable();
            $table->string('business_logo', 200)->nullable();
            $table->tinyInteger('is_active')->nullable()->default(0);
            $table->string('profile_image', 200)->nullable();
            $table->dateTime('last_login')->nullable();
            $table->string('login_ip_address', 20)->nullable();
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
        Schema::dropIfExists('users');
    }
}
