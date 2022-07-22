<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SubscriptionsRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Subscriptions;
use App\Models\User;
use App\Models\BillingPlan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;

class SubscriptionsCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Subscriptions::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/subscriptions');
        CRUD::setEntityNameStrings('subscriptions', 'subscriptions');
        $this->imageurl  = asset('storage/');
        $this->provider = new PayPalClient;
        if(env('PAYPAL_SANDBOX_CLIENT_ID')){
            $config=[
                'mode'    => env('PAYPAL_MODE'),
                'sandbox' => [
                    'client_id'         => env('PAYPAL_SANDBOX_CLIENT_ID'),
                    'client_secret'     => env('PAYPAL_SANDBOX_CLIENT_SECRET')
                ],
                'live' => [
                    'client_id'         => env('PAYPAL_LIVE_CLIENT_ID'),
                    'client_secret'     => env('PAYPAL_LIVE_CLIENT_SECRET')
                ],
                'payment_action' => env('PAYPAL_PAYMENT_ACTION', 'Sale'),
                'currency'       => env('PAYPAL_CURRENCY', 'CAD'),
                'notify_url'     => env('PAYPAL_NOTIFY_URL', ''),
                'locale'         => env('PAYPAL_LOCALE', 'en_US'),
                'validate_ssl'   => env('PAYPAL_VALIDATE_SSL', true),
            ];
            $this->provider->setApiCredentials($config);
            $this->token=$this->provider->getAccessToken();
        }
        if(Auth::check()){
            if (!Auth::user()->hasRole('admin')) {
               $this->crud->addClause('where', 'user_id', '=', Auth::user()->id);
            }
        }
        $this->crud->addClause('where', 'status', '!=', 'APPROVAL_PENDING');
    }
    protected function setupListOperation()
    {
        $this->crud->addColumn([
            'type' => 'date',
            'name' => 'start_time',
            'label' => 'Start Date'
        ]);
        $this->crud->addColumn([
            'type' => 'date',
            'name' => 'next_billing_date',
            'label' => 'Next Billing Date'
        ]);
        $this->crud->addColumn([
            'name' => 'auto_renew',
            'label' => 'Auto Renew'
        ]);
        $this->crud->addColumns(['subscription']);
        CRUD::column('customer_name');
        CRUD::column('status');
        $this->crud->addColumns(['frequency']);
        $this->crud->addColumns(['price']);

        $this->crud->setColumnDetails('frequency',[
            'label' => 'Frequency',
            'entity' => 'plans',
            'attribute'=>'frequency_interval_unit',
            'model' => 'App\Models\Subscriptions',
            'type' => 'select',
            'name'  => 'plan_id'
        ]);


        $this->crud->setColumnDetails('subscription',[
            'label' => 'Subscription',
            'entity' => 'plans',
            'attribute'=>'title',
            'model' => 'App\Models\Subscriptions',
            'type' => 'select',
            'name'  => 'plan_id'
        ]);

        $this->crud->setColumnDetails('price', [
            'label' => 'Price',
            'entity' => 'plans',
            'attribute'=>'price',
            'model' => 'App\Models\Subscriptions',
            'type' => 'select',
            'name'  => 'plan_id',
            'prefix'=>'$'
        ]);
        $this->crud->removeButton('create');
        $this->crud->removeButton('update');
        $this->crud->removeButton('delete');
        /*if(Auth::check()){
            if (!\Auth::user()->hasRole('admin')) {*/
                $this->crud->addButtonFromModelFunction('line', 'subscription_onoff', 'subscriptionOnOff', 'beginning');

                $this->crud->addButtonFromModelFunction('line', 'subscription_cancel', 'subscriptionCancel', 'beginning');
            /*}
        }*/
        /*$data=$this->provider->showSubscriptionDetails('I-5DSMFUWCNEF4');
        echo "<PRE>";print_r($data);exit;*/
    }

    protected function cancelSubscription($subscriptionID){
        if(!empty($this->token)){
           $reason = 'Not satisfied with the service';
           $cancelResponse = $this->provider->cancelSubscription($subscriptionID,$reason);
           Subscriptions::where('subscription_id',$subscriptionID)->update(['status'=>'Cancelled','auto_renew'=>'Off']);
           return redirect('admin/subscriptions');
        }
    }

    protected function activeSubscription($subscriptionID){
        if(!empty($this->token)){
           $reason = 'Reactivating the subscription';
           $cancelResponse = $this->provider->activateSubscription($subscriptionID,$reason);
           Subscriptions::where('subscription_id',$subscriptionID)->update(['status'=>'ACTIVE','auto_renew'=>'On']);
           return redirect('admin/subscriptions');
        }
    }

    protected function suspendSubscription($subscriptionID){
        if(!empty($this->token)){
           $reason = 'Subscription not available';
           $cancelResponse = $this->provider->suspendSubscription($subscriptionID,$reason);
           Subscriptions::where('subscription_id',$subscriptionID)->update(['status'=>'SUSPEND','auto_renew'=>'Off']);
           return redirect('admin/subscriptions');
        }
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(SubscriptionsRequest::class);
        CRUD::field('start_time');
        CRUD::field('quantity');
        CRUD::field('shipping_amount');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    protected function setupShowOperation()
    {

        $this->crud->addColumn([
            'type' => 'date',
            'name' => 'start_time',
            'label' => 'Start Time'
        ]);
        $this->crud->addColumn([
            'type' => 'date',
            'name' => 'next_billing_date',
            'label' => 'Next Billing Date'
        ]);
        $this->crud->addColumn([
            'name' => 'subscription_id',
            'label' => 'Subscription ID'
        ]);
        $this->crud->addColumns(['paypalid']);
        $this->crud->addColumns(['title']);
        $this->crud->addColumns(['description']);
        $this->crud->addColumns(['username']);
        $this->crud->addColumn([
            'name' => 'customer_name',
            'label' => 'Paypal Buyer Customer'
        ]);

        $this->crud->addColumn([
            'name' => 'payer_id',
            'label' => 'Payer ID'
        ]);
        CRUD::column('status');
        $this->crud->addColumns(['frequency']);
        $this->crud->addColumns(['price']);
        CRUD::column('currency_code');
        $this->crud->addColumns(['tenure_type']);
        $this->crud->addColumn([
            'name' => 'created_at',
            'label' => 'Create Date'
        ]);
        $this->crud->setColumnDetails('paypalid',[
            'label' => 'Plan ID',
            'entity' => 'plans',
            'attribute'=>'paypal_plan_id',
            'model' => 'App\Models\Subscriptions',
            'type' => 'select',
            'name'  => 'plan_id'
        ]);

         $this->crud->setColumnDetails('username',[
            'label' => 'User Name',
            'entity' => 'users',
            'attribute'=>'username',
            'model' => 'App\Models\Subscriptions',
            'type' => 'select',
            'name'  => 'user_id'
        ]);

        $this->crud->setColumnDetails('description',[
            'label' => 'Description',
            'entity' => 'plans',
            'attribute'=>'description',
            'model' => 'App\Models\Subscriptions',
            'type' => 'select',
            'name'  => 'plan_id'
        ]);

        $this->crud->setColumnDetails('frequency',[
            'label' => 'Frequency',
            'entity' => 'plans',
            'attribute'=>'frequency_interval_unit',
            'model' => 'App\Models\Subscriptions',
            'type' => 'select',
            'name'  => 'plan_id'
        ]);

        $this->crud->setColumnDetails('tenure_type',[
            'label' => 'Tenure Type',
            'entity' => 'plans',
            'attribute'=>'tenure_type',
            'model' => 'App\Models\Subscriptions',
            'type' => 'select',
            'name'  => 'plan_id'
        ]);

        $this->crud->setColumnDetails('title',[
            'label' => 'Title',
            'entity' => 'plans',
            'attribute'=>'title',
            'model' => 'App\Models\Subscriptions',
            'type' => 'select',
            'name'  => 'plan_id'
        ]);

        $this->crud->setColumnDetails('price', [
            'label'=>'Price',
            'entity'=>'plans',
            'attribute'=>'price',
            'model'=>'App\Models\Subscriptions',
            'type' =>'select',
            'name' =>'plan_id',
            'prefix'=>'$'
        ]);
        $this->crud->removeButton('update');
        $this->crud->removeButton('delete');
    }

    protected function createSubscriptions($planid,$userid){
        if($this->token){
            if(!empty($planid)){
                $userid1 = base64_decode(base64_decode($userid));
                $getUser = User::where('id',$userid1)->first();
                $getBilling=BillingPlan::where('paypal_plan_id',$planid)->first();
                if(!empty($getBilling)){
                    $userId = $getUser['id'];
                    $frequency = $getBilling['frequency_interval_unit'];
                    $date = '';//date('Y-m-d').'T00:05:30Z';
                    if($getBilling['interval_count']>1){
                        if($frequency=='days'){
                            $frequency = 'day';
                        }else{
                            $frequency=$frequency.'s';
                        }
                        $count = ($getBilling['interval_count']-1);
                        //$date = date('Y-m-d',strtotime('+1 '.$frequency)).'T00:05:30Z';
                    }
                    $quantity=1;
                    $subscription=array(
                        'plan_id'=>$planid,
                        'quantity'=>$quantity,
                        'application_context' => array(
                            'return_url' => env('APP_URL').'/admin/returnUrl?id='.$userId,
                            'cancel_url' => env('APP_URL').'/admin/cancelUrl?id='.$userId,
                            'shipping_preference'=>'NO_SHIPPING'
                        ),
                    );
                    if(!empty($date)){
                        $subscription = array_merge($subscription,array('start_time'=>$date));
                    }
                    $response = $this->provider->createSubscription($subscription);
                    if(isset($response['status'])){
                        if($response['status']=='APPROVAL_PENDING'){
                            Subscriptions::create(['plan_id'=>$getBilling['id'],'status'=>'APPROVAL_PENDING','subscription_id'=>$response['id'],'quantity'=>$quantity,'shipping_amount'=>'0','user_id'=>$userId]);
                            return redirect($response['links'][0]['href']);
                        }
                    }else{
                        return redirect('admin/checkout/'.$planid.'/'.$userid)->with('error','Paypal plan not found');
                    }
                }else{
                   return redirect('admin/checkout/'.$planid.'/'.$userid)->with('error','Paypal plan not found');
                }
            }
        }
    }
}
