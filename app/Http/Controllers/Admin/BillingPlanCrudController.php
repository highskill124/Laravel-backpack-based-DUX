<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BillingPlanRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
/**
 * Class BillingPlanCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BillingPlanCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        if(Auth::check()){
            if (!\Auth::user()->hasRole('admin')) {
                if(!backpack_user()->hasPermissionTo('create-products'))
                {
                    $this->crud->denyAccess('create');
                }
                if(!backpack_user()->hasPermissionTo('edit-products'))
                {
                    $this->crud->denyAccess('update');
                }
                if(!backpack_user()->hasPermissionTo('delete-products'))
                {
                    $this->crud->denyAccess('delete');
                }
                if(!backpack_user()->hasPermissionTo('list-products'))
                {
                    $this->crud->denyAccess('list');
                }
            }
        }
        CRUD::setModel(\App\Models\BillingPlan::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/billing-plan');
        CRUD::setEntityNameStrings('billing plan', 'billing plans');
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
        CRUD::column('title');
        CRUD::column('description');
        CRUD::column('paypal_plan_id');
        CRUD::column('status');
        CRUD::column('frequency_interval_unit');
        $this->crud->addColumn([
            'name' =>'price',
            'label' =>'Price',
            'prefix'=>'$'
        ]);
        $this->crud->addButtonFromModelFunction('line', 'open_google', 'copyLink', 'beginning');
    }

    public function store(BillingPlanRequest $request)
    {
        $this->crud->setRequest($this->crud->validateRequest());
        $traitstore=$this->traitStore();
        $id = $this->crud->entry->id;
        $this->createPlan($request,$id);
        return $traitstore;
    }

    public function update(BillingPlanRequest $request)
    {
        $this->crud->setRequest($this->crud->validateRequest());
        $updatedPromotions=$this->traitUpdate();
        $id = $this->crud->entry->id;
        $update=1;
        $this->createPlan($request,$id,$update);
        return $updatedPromotions;
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(BillingPlanRequest::class);
        $this->addUserFields();
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    protected function createPlan($postdata,$lastid,$update=''){
        if(!empty($this->token)){
            $checkProducts=\App\Models\Products::where('id',$postdata['product_id'])->first();
            $totalCycle=0;
            if(!empty($postdata) && !empty($checkProducts)){
                $intervalCount=0;
                $totalCycle=$postdata['interval_count'];
                $tax = (($postdata['price']*env('BILLING_TAX_PER'))/100);
                $totalPrice = number_format(($postdata['price']+$tax),2);
                $totalTax = env('BILLING_TAX_PER');
                $getplan=\App\Models\BillingPlan::where('id',$lastid)->first();
                if($update==1 && !empty($getplan['paypal_plan_id'])){
                    $data=array(
                        0 => array (
                        'op' => 'replace',
                        'path' => '/description',
                        'value' => $postdata['description']
                        ),
                        1 => array (
                        'op' => 'replace',
                        'path' => '/name',
                        'value' => $postdata['title'],
                        ),
                    );
                    $planid=$getplan['paypal_plan_id'];
                    $plan=$this->provider->updatePlan($planid,$data);
                    if($postdata['status']=='Inactive'){
                        $this->provider->deactivatePlan($planid);
                    }
                }else{
                    if($totalCycle>1){
                        $data=array(
                          'product_id' => $checkProducts['paypal_product_id'],
                          'name' => $postdata['title'],
                          'description' => $postdata['description'],
                          'status' => strtoupper($postdata['status']),
                          'billing_cycles'=> 
                          array (
                            0 => 
                            array (
                              'frequency'=> 
                              array (
                                'interval_unit'=>strtoupper($postdata['frequency_interval_unit']),
                                'interval_count'=>1,
                              ),
                              'tenure_type' => 'TRIAL',
                              'sequence' => 1,
                              'total_cycles'=>1,
                              'pricing_scheme'=> 
                              array (
                                'fixed_price' => 
                                array (
                                  'value' => $postdata['price'],
                                  'currency_code' => $postdata['currency'],
                                ),
                              ),
                            ),
                            1 => 
                            array (
                              'frequency' => 
                              array (
                                'interval_unit' => strtoupper($postdata['frequency_interval_unit']),
                                'interval_count' =>1,
                              ),
                              'tenure_type' =>strtoupper($postdata['tenure_type']),
                              'sequence'=>2,
                              'total_cycles' => ($totalCycle-1),
                              'pricing_scheme' => 
                              array (
                                'fixed_price' => 
                                array (
                                  'value' => $postdata['price'],
                                  'currency_code' => $postdata['currency'],
                                ),
                              ),
                            ),
                          ),
                          'payment_preferences' => 
                          array (
                            'auto_bill_outstanding' => true,
                            'setup_fee' => 
                            array (
                              'value' => '0',
                              'currency_code' => $postdata['currency'],
                            ),
                            'setup_fee_failure_action' => 'CONTINUE',
                            'payment_failure_threshold' => 3,
                          ),
                          'taxes' => 
                            array (
                                'percentage' => $totalTax,
                                'inclusive' => false,
                            ),
                        );
                    }else{
                        $data=array(
                          'product_id' => $checkProducts['paypal_product_id'],
                          'name' => $postdata['title'],
                          'description' => $postdata['description'],
                          'status' => strtoupper($postdata['status']),
                          'billing_cycles' => 
                          array (
                            0 => 
                            array (
                              'frequency' => 
                                array (
                                    'interval_unit' => strtoupper($postdata['frequency_interval_unit']),
                                    'interval_count' => 1,
                                ),
                                'tenure_type' => 'Regular',
                                'sequence' => 1,
                                'total_cycles' => 1,
                                'pricing_scheme' => 
                                  array (
                                    'fixed_price' => 
                                    array (
                                      'value' => $postdata['price'],
                                      'currency_code' => $postdata['currency'],
                                    ),
                                ),
                            ),
                          ),
                          'payment_preferences' => 
                          array (
                            'auto_bill_outstanding' => true,
                            'setup_fee' => 
                            array (
                              'value' =>'0',
                              'currency_code' =>$postdata['currency'],
                            ),
                            'setup_fee_failure_action' => 'CONTINUE',
                            'payment_failure_threshold' => 3,
                          ),
                          'taxes' => 
                            array (
                                'percentage' => $totalTax,
                                'inclusive' => false,
                            ),
                        );
                    }
                    $request_id = 'PLAN-'.time();
                    $plan=$this->provider->createPlan($data,$request_id);
                    if(!empty($plan['id'])){
                        \App\Models\BillingPlan::where('id',$lastid)->update(['paypal_plan_id'=>$plan['id'],'tax'=>number_format($tax,2)]);
                    }
                }
            }
        }
    }

    protected function setupShowOperation(){
        CRUD::column('title');
        CRUD::column('description');
        CRUD::column('tenure_type');
        CRUD::column('frequency_interval_unit');
        CRUD::column('interval_count');
        $this->crud->addColumn([
            'label' => 'Product Name',
            'entity' => 'productlist',
            'attribute'=>'title',
            'model' => 'App\Models\Products',
            'type' => 'select',
            'name'  => 'product_id'
        ]);
        $this->crud->addColumn([
            'name' => 'paypal_plan_id',
            'label' => 'Paypal Plan ID'
        ]);
        $this->crud->addColumn([
            'name' => 'price',
            'label' => 'Price',
            'prefix'=>'$'
        ]);
        $this->crud->addColumn([
            'name' => 'tax',
            'label' => 'Tax',
            'prefix'=>'$'
        ]);
        CRUD::column('status');
        CRUD::column('created_at');
        CRUD::column('updated_at');
    }

    protected function addUserFields()
    {
        $this->crud->addFields([
            [
                'label' => 'Product List',
                'entity' => 'productlist',
                'attribute'=>'title',
                'key' => 'id',
                'model' => 'App\Models\Products',
                'type' => 'select',
                'name'  => 'product_id'
            ],
            [
                'name'  => 'title',
                'label' => 'Title',
                'type'  => 'text',
                'attributes' => [ 'placeholder' => 'Title']
            ],
            [
                'name'  => 'description',
                'label' => 'Description',
                'type'  => 'textarea',
                'attributes' => [ 'placeholder' => 'Description']
            ],
            [
                'name'  => 'price',
                'label' => 'Price',
                'type'  => 'text',
                'attributes' => [ 'placeholder' => 'Price'],
                'wrapper'   => [ 
                    'class'      => 'form-group col-md-12 price-fld'
                ]
            ],
            [
                'name'  => 'currency',
                'label' => 'Currency',
                'type'  => 'radio',
                'options'=> [
                    "CAD" => "CAD",
                    "USD" => "USD"
                ],
                'default' => "CAD",
                'inline'  => true,
                'wrapper'   => [ 
                    'class'      => 'form-group col-md-12 currency-cls'
                ],
            ],
            [
                'name'  => 'status',
                'label' => 'Status',
                'type'  => 'radio',
                'options'=> [
                    "Active" => "Active",
                    "Inactive" => "Inactive"
                ],
                'default' => "Active",
                'inline'  => true,
            ],
            [
                'name'  => 'tenure_type',
                'label' => 'Tenure Type',
                'type'  => 'radio',
                'options'=> [
                    "Regular" => "Regular",
                    "Trial" => "Trial"
                ],
                'default' => "Regular",
                'inline'  => true,
            ],
            [
                'name'  => 'frequency_interval_unit',
                'label' => 'Frequency',
                'type'  => 'radio',
                'options'=> [
                    "day" => "Daily",
                    "week" => "Weekly",
                    "month" => "Monthly",
                    "year" => "Yearly"
                ],
                'default' => "month",
                'inline'  => true,
                'wrapper'   => [ 
                    'class'      => 'form-group col-md-12 frequency-interval'
                ],
            ],
            [
                'name'  => 'interval_count',
                'label' => 'Number of months for plan',
                'type'  => 'number',
                'decimals'=> 0,
                'wrapper'   => [ 
                    'class'      => 'form-group col-md-12 interval-count'
                ],
            ]
        ]);
    }
}
