<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('promotion', 'PromotionCrudController');
    Route::crud('location', 'LocationCrudController');
    Route::crud('category', 'CategoryCrudController');
    Route::crud('locationpopup', 'LocationPopupCrudController');
    Route::crud('paypal-payment', 'PaypalPaymentCrudController');
    Route::crud('products', 'ProductsCrudController');
    Route::crud('user-profile', 'UserProfileCrudController');
    Route::get('account-profile', 'UserProfileCrudController@setupMyprofileOperation')->name('backpack.account.profile');
    Route::get('edit-account-profile/{id}', 'UserProfileCrudController@editProfile')->name('edit-account-profile');
    Route::post('edit-account-profile/{id}', 'UserProfileCrudController@editProfile')->name('edit-account-profile');

    Route::get('password-change/{id}', 'UserProfileCrudController@passwordChange')->name('password-change');
    Route::post('password-change/{id}', 'UserProfileCrudController@passwordChange')->name('password-change');
    Route::crud('billing-plan', 'BillingPlanCrudController');
    Route::crud('subscriptions', 'SubscriptionsCrudController');
}); // this should be the absolute last line of this file