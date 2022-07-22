<?php

use App\Http\Controllers\MobileController;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\LocationResource;
use App\Models\Category;
use App\Models\Location;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\LocationCollection;
use Illuminate\Support\Facades\Route;
use App\Models\BillingPlan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/admin');
});


Route::get('oldApi', [MobileController::class, 'oldApi']);
Route::get('/checkout/{id}', function ($id) {
    Auth::logout();

    $subscription=BillingPlan::where('paypal_plan_id',$id)->first();
    return view('checkout',compact('subscription'));
});
Route::post('/checkout', [App\Http\Controllers\Admin\PaypalPaymentCrudController::class, 'create'])->name('backpack.paypal.create');
Route::post('/check-email', [App\Http\Controllers\Admin\PaypalPaymentCrudController::class, 'checkEmail'])->name('backpack.paypal.checkemail');

Route::post('/check-username', [App\Http\Controllers\Admin\PaypalPaymentCrudController::class, 'checkUsername'])->name('backpack.paypal.checkusername');

Route::post('/paypal-payment', [App\Http\Controllers\Admin\PaypalPaymentCrudController::class, 'setRecurringPayment'])->name('backpack.paypal.payment');

Route::get('pay', [App\Http\Controllers\Admin\PaypalPaymentCrudController::class, 'setRecurringPay'])->name('backpack.paypal.pay');
Route::get('pay-success', [App\Http\Controllers\Admin\PaypalPaymentCrudController::class, 'setRecurringPay1'])->name('success.payment');
Route::get('pay-cancel', [App\Http\Controllers\Admin\PaypalPaymentCrudController::class, 'setRecurringPay1'])->name('cancel.payment');


Route::get('admin/create-subscription/{id}/{uid}', [App\Http\Controllers\Admin\SubscriptionsCrudController::class, 'createSubscriptions'])->name('admin.create-subscription');

Route::get('admin/returnUrl', [App\Http\Controllers\Admin\PaypalPaymentCrudController::class, 'returnUrl'])->name('admin.returnUrl');
Route::get('admin/cancelUrl', [App\Http\Controllers\Admin\PaypalPaymentCrudController::class, 'cancelUrl'])->name('admin.cancelUrl');

Route::get('admin/subscription/cancel/{id}', [App\Http\Controllers\Admin\SubscriptionsCrudController::class, 'cancelSubscription'])->name('admin.cancelSubscription');

Route::get('admin/subscription/active/{id}', [App\Http\Controllers\Admin\SubscriptionsCrudController::class, 'activeSubscription'])->name('admin.activeSubscription');

Route::get('admin/subscription/suspend/{id}', [App\Http\Controllers\Admin\SubscriptionsCrudController::class, 'suspendSubscription'])->name('admin.suspendSubscription');

Route::post('admin/checksubscription', [App\Http\Controllers\Admin\PaypalPaymentCrudController::class, 'checkSubscription'])->name('admin.checksubscription');

Route::any('ipn/notify', [App\Http\Controllers\Admin\PaypalPaymentCrudController::class, 'paypalIpn'])->name('ipn.notify');

Route::get('/thank-you', function () {
    return view('thank_you');
});
Route::get('/cancel-payment', function () {
    return view('cancel');
});