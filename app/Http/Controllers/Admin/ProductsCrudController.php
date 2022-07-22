<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductsRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Config;
use Auth;
/**
 * Class ProductsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductsCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Products::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/products');
        CRUD::setEntityNameStrings('products', 'products');
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
        $this->crud->addColumn([
            'name' => 'paypal_product_id',
            'label' => 'Paypal Product ID'
        ]);
        CRUD::column('status');
        //$data =$this->provider->showPlanDetails('P-3T043835H6918414HMJZ33YI');
        //echo "<PRE>";print_r($data);exit;
    }

    protected function setupShowOperation(){
        CRUD::column('title');
        CRUD::column('description');
        $this->crud->addColumn([
            'name' => 'paypal_product_id',
            'label' => 'Paypal Product ID'
        ]);
        CRUD::column('status');
        CRUD::column('created_at');
        CRUD::column('updated_at');
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ProductsRequest::class);
        //CRUD::field('id');
        /*CRUD::field('title');
        CRUD::field('description');
        CRUD::field('image-url');
        CRUD::field('home-url');
        CRUD::addField(['name'  => 'description',
            'label' => 'Description',
            'type'  => 'textarea'
        ]); */
        $this->addUserFields();
        //CRUD::field('paypal-product-id');
        //CRUD::field('created_at');
        //CRUD::field('updated_at');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    public function store(ProductsRequest $request)
    {
        $this->crud->setRequest($this->crud->validateRequest());
        $traitstore=$this->traitStore();
        $id = $this->crud->entry->id;
        $fileName='';
        /*if($request->hasFile('image_url')) {
            $uploadedFiles = $request->file('image_url');
            $fileNamewithExt = $uploadedFiles->getClientOriginalName();
            $fileName = pathinfo($fileNamewithExt, PATHINFO_FILENAME); 
            $fileExtension = $uploadedFiles->getClientOriginalExtension();
            $fileNameToStore = md5('pi_' . date('Y_m_d_Hi', time())) . '_' . md5(microtime(true)) . '.' . $fileExtension; 
            $path = $uploadedFiles->storeAs('public/product_image', $fileNameToStore);
            $fileName ='/product_image/'.$fileNameToStore;
            \App\Models\Products::where('id',$id)->update(['image_url'=>$fileName]);
        }*/
        $this->prouductCreate($request,$id,$fileName);
        return $traitstore;
    }

    public function update(ProductsRequest $request)
    {
        $this->crud->setRequest($this->crud->validateRequest());
        $updatedPromotions=$this->traitUpdate();
        $id = $this->crud->entry->id;
        $fileName='';
        /*if($request->hasFile('image_url')) {
            $uploadedFiles = $request->file('image_url');
            $fileNamewithExt = $uploadedFiles->getClientOriginalName();
            $fileName = pathinfo($fileNamewithExt, PATHINFO_FILENAME); 
            $fileExtension = $uploadedFiles->getClientOriginalExtension();
            $fileNameToStore = 'p' . $c_product_id . '_' . md5('pi_' . date('Y_m_d_Hi', time())) . '_' . md5(microtime(true)) . '.' . $fileExtension; 
            $path = $uploadedFiles->storeAs('public/product_image', $fileNameToStore);
            $fileName ='/product_image/'.$fileNameToStore;
            \App\Models\Products::where('id',$id)->update(['image_url'=>$fileName]);
        }*/
        $update=1;
        $this->prouductCreate($request,$id,$fileName);
        return $updatedPromotions;
    }

    protected function prouductCreate($postdata,$lastid,$fileName){
        if(!empty($this->token)){
            if(!empty($postdata)){
                $getProducts = \App\Models\Products::where('id',$lastid)->first();
                if(!empty($getProducts['paypal-product-id'])){
                    $data=array(
                      0 => 
                      array (
                        'op' => 'replace',
                        'path' => '/description',
                        'value' => $postdata['description'],
                      ),
                      /*1 => 
                      array (
                        'op' => 'replace',
                        'path' => '/image_url',
                        'value' => $this->imageurl.'/'.$fileName,
                      ),
                      2 => 
                      array (
                        'op' => 'replace',
                        'path' => '/home_url',
                        'value' => $postdata['home_url'],
                      ),*/
                    );
                    
                    $productId = $getProducts['paypal-product-id'];
                    $product = $this->provider->updateProduct($productId, $data);
                }else{
                    /*$imageurl = 'https://i.picsum.photos/id/319/536/354.jpg?hmac=ZzEILWavlsP9MWDCsCqQp3fxsbmTD48rzZWY5c57IPU';//$this->imageurl.'/'.$fileName;*/
                    $data =  array("name"=>$postdata['title'],"description"=>$postdata['description'],"type"=>"DIGITAL","category"=>"OTHER");
                    $request_id = 'create-product-'.time();
                    $product = $this->provider->createProduct($data, $request_id);
                    if(isset($product['id'])){
                        \App\Models\Products::where('id',$lastid)->update(['paypal_product_id'=>$product['id'],'status'=>'Active']);
                    }else{
                        \App\Models\Products::where('id',$lastid)->delete();
                    }
                }
            }
        }
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

    protected function addUserFields()
    {

        $this->crud->addFields([
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
            /*[
                'name'  => 'image_url',
                'label' => 'Image Url',
                'type'  => 'upload',
                'upload' => true,
                'disk' => 'uploads',
            ],
            [
                'name'  => 'home_url',
                'label' => 'Home Url',
                'type'  => 'textarea',
                'attributes' => [ 'placeholder' => 'e.g https://domain']
            ],*/
        ]);
    }
}
