<?php

namespace App\Providers;

use App\Http\Controllers\Admin\PermissionCrudController;
use App\Http\Controllers\Admin\RoleCrudController;
use App\Http\Controllers\Admin\UserCrudControllerExtended;
use Backpack\PermissionManager\app\Http\Controllers\UserCrudController;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            UserCrudController::class, //this is package controller
            UserCrudControllerExtended::class //this should be your own controller
        );

        $this->app->bind(
            \Backpack\PermissionManager\app\Http\Controllers\RoleCrudController::class, //this is package controller
            RoleCrudController::class //this should be your own controller
        );

        $this->app->bind(
            \Backpack\PermissionManager\app\Http\Controllers\PermissionCrudController::class, //this is package controller
            PermissionCrudController::class //this should be your own controller
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
