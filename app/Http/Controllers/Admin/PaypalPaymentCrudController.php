<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PaypalPaymentRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use URL;
use Session;
use Redirect;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Srmklive\PayPal\Services\ExpressCheckout;
use App\Models\Subscriptions;
use Config;
use Auth;
use Illuminate\Http\Request; 
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use DB;

/**
 * Class PaypalPaymentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PaypalPaymentCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    private $_api_context;

    public $provider;

    public function setup()
    {
        CRUD::setModel(\App\Models\PaypalPayment::class);
        //CRUD::setRoute(config('backpack.base.route_prefix') . '/paypal-payment');
        CRUD::setEntityNameStrings('paypal payment', 'paypal payments');
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
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(PaypalPaymentRequest::class);

        $this->crud->setCreateContentClass('col-md-12');
        $this->crud->setCreateView('backpack::crud.locations.create');
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function create(){
        $flag=0;
        if(!empty($_POST['data'])){
            $params = array();
            parse_str($_POST['data'], $params);
            $checkEmail=User::where('email',$params['email'])->first();
            $checkUser=User::where('username',$params['username'])->first();
            if(empty($checkEmail)){
                if(empty($checkUser)){
                    $userId=User::create(['email'=>$params['email'],'username'=>$params['username'],'password'=>Hash::make($params['password']),'original_password'=>base64_encode(base64_encode($params['password'])),'name'=>$params['fullname'],'business_name'=>$params['businessname'],'city'=>$params['city'],'zip_code'=>$params['postalcode'],'country'=>$params['country'],'phone'=>$params['phone'],'your_position'=>$params['position'],'is_active'=>1,'business_address'=>$params['businessaddress'],'business_address2'=>$params['businessaddress2']])->id;
                    $flag='1'.'###'.$userId.'###'.$params['username'].'@@@'.$params['fullname'].'@@@'.$params['email'].'@@@'.$params['phone'];
                }else{
                    $flag=3;
                }
            }else{
                $userId=$checkEmail['id'];
                $flag='2'.'###'.$userId.'###'.$checkEmail['username'].'@@@'.$checkEmail['fullname'].'@@@'.$checkEmail['email'].'@@@'.$checkEmail['phone'];;
            }
            //Session::set('user_id',$userId);
        }
        echo $flag;exit;
    }   

    public function checkEmail(){
        if(!empty($_POST['email'])){
            $checkEmail=User::where('email',$_POST['email'])->first();
            return $checkEmail;
        }
    }

    public function checkUsername(){
        if(!empty($_POST['username'])){
            $checkUser=User::where('username',$_POST['username'])->first();
            return $checkUser;
        }
    }   

    public function returnUrl(){
        if(!empty($_GET['subscription_id'])){
            $getSubscription=$this->provider->showSubscriptionDetails($_GET['subscription_id']);
            //echo "<PRE>";print_r($getSubscription);exit;
            $getUser = User::where('id',$_GET['id'])->first();
            if(!empty($getSubscription)){
                $shipamount = 0;
                $currencyCode = 'CAD';
                if(isset($getSubscription['shipping_amount'])){
                    $shipamount = $getSubscription['shipping_amount']['value'];
                    $currencyCode = $getSubscription['shipping_amount']['currency_code'];
                }
                $customerName = $payerId = '';
                if(isset($getSubscription['subscriber']['name'])){
                    $customerName.=$getSubscription['subscriber']['name']['given_name'];
                    if(!empty($getSubscription['subscriber']['name']['surname'])){
                        $customerName.=' '.$getSubscription['subscriber']['name']['surname'];
                    }
                }
                if(isset($getSubscription['subscriber']['payer_id'])){
                    $payerId=$getSubscription['subscriber']['payer_id'];
                }
                $nextbillDate = '';
                if(isset($getSubscription['billing_info']['next_billing_time'])){
                    $nextbillDate = $getSubscription['billing_info']['next_billing_time'];
                }
                $autoRenew='Off';
                $status = $getSubscription['status'];
                if($getSubscription['status']=='ACTIVE'){
                    $autoRenew='On';
                }else if($getSubscription['status']=='EXPIRED'){
                    $status='ACTIVE';
                }
                //When user make successfully payment then we update the subscription table
                Subscriptions::where('subscription_id',$_GET['subscription_id'])->update(['ba_token'=>$_GET['ba_token'],'token'=>$_GET['token'],'status'=>$status,'start_time'=>$getSubscription['status_update_time'],'shipping_amount'=>$shipamount,'currency_code'=>$currencyCode,'customer_name'=>$customerName,'auto_renew'=>$autoRenew,'next_billing_date'=>$nextbillDate,'payer_id'=>$payerId,'subscriptions_response'=>json_encode($getSubscription)]);
                if(!empty($getUser)){
                    $email = $getUser['email'];
                    $password = base64_decode(base64_decode($getUser['original_password']));
                    if (Auth::attempt(array('email'=>$email,'password' =>$password))){
                        $user = User::where('email',$email)->first();
                        Auth::login($user, true);
                        backpack_auth()->login($user);
                        return redirect('thank-you');
                    }else{
                        return redirect("login")->withSuccess('Oppes! You have entered invalid credentials');
                    }
                }else{
                    return redirect('admin/login');
                }
            }
        }else{
            //If the user cancels the payment on PayPal then we delete this entry in our DB
            Subscriptions::where('status','APPROVAL_PENDING')->delete();
        }
    }

    public function checkSubscription()
    {
        $flag=0;
        if(!empty($_POST)){
            $email = $_POST['email'];
            $user = User::where('email',$email)->where('is_active','1')->first();
            if(!empty($user)){
                $getsubscription = Subscriptions::where('user_id',$user['id'])->where('status','ACTIVE')->orderBy('id','desc')->first();
                if(!empty($getsubscription)){
                    $startArr = explode('T',$getsubscription['start_time']);
                    $date1=date('Y-m-d');
                    $dateTimestamp1 = strtotime($date1);
                    $dateTimestamp2 = strtotime($startArr[0]);
                    if($dateTimestamp1<$dateTimestamp2){
                        $flag='1'.'###'.$user['id'];
                    }else{
                        $flag='3'.'###'.$user['id'];
                    }
                }else{
                    $flag='3'.'###'.$user['id'].'###'.$user['username'];
                }
            }else{
                $flag=2;
            }
        }
        echo $flag;exit;
    }

    public function paypalIpn(Request $request){
        $request->merge(['cmd' => '_notify-validate']);
        $post = $request->all();
       // $response = (string) $this->provider->verifyIPN($post);
        //if (strcmp($response, "VERIFIED")){
            $customerName = $_POST['first_name'];
            if(!empty($_POST['last_name'])){
                $customerName.=$_POST['first_name'];
            }
            $checkSubscription = Subscriptions::where('subscription_id',$_POST['recurring_payment_id'])->first();
            if(!empty($checkSubscription)){
                Subscriptions::where('subscription_id',$_POST['recurring_payment_id'])->update(['shipping_amount'=>$_POST['initial_payment_amount'],'customer_name'=>$customerName,'status'=>strtoupper($_POST['profile_status']),'next_payment_date'=>$_POST['next_payment_date'],'ipn_response'=>json_encode($post)]);
            }
        //}
    }

    public function cancelUrl(){
        /*if(!empty($_GET['subscription_id'])){
            $getSubscription=$this->provider->showSubscriptionDetails($_GET['subscription_id']);
            User::where('id',$_GET['id'])->update(['status'=>0]);
            if(!empty($getSubscription)){
                $shipamount = 0;
                $currencyCode = 'CAD';
                if(isset($getSubscription['shipping_amount'])){
                    $shipamount = $getSubscription['shipping_amount']['value'];
                    $currencyCode = $getSubscription['shipping_amount']['currency_code'];
                }
                $customerName = $payerId = '';
                if(isset($getSubscription['subscriber']['name'])){
                    $customerName.=$getSubscription['subscriber']['name']['given_name'];
                    if(!empty($getSubscription['subscriber']['name']['surname'])){
                        $customerName.=' '.$getSubscription['subscriber']['name']['surname'];
                    }
                }
                if(isset($getSubscription['subscriber']['payer_id'])){
                    $payerId=$getSubscription['subscriber']['payer_id'];
                }
                Subscriptions::where('subscription_id',$_GET['subscription_id'])->update(['ba_token'=>$_GET['ba_token'],'token'=>$_GET['token'],'status'=>$getSubscription['status'],'start_time'=>$getSubscription['start_time'],'shipping_amount'=>$shipamount,'currency_code'=>$currencyCode,'customer_name'=>$customerName,'payer_id'=>$payerId,'subscriptions_response'=>json_encode($getSubscription)]);*
                return redirect('admin/login');
            }
        }*/
        //If the user cancels the payment on PayPal then we delete this entry in our DB
        Subscriptions::where('status','APPROVAL_PENDING')->delete();
        return redirect('cancel-payment');
    }
}
