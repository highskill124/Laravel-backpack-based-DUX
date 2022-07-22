<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserProfileRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserProfileCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserProfileCrudController extends CrudController
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
    public function setup()
    {
        error_reporting(0);
        CRUD::setModel(\App\Models\UserProfile::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user-profile');
        CRUD::setEntityNameStrings('user profile', 'user profiles');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupMyprofileOperation()
    {

        return view('vendor.backpack.crud.myaccount.myprofile');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {

        CRUD::setValidation(UserProfileRequest::class);



        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function editProfile($id)
    {
        $message='';
        if(!empty($_POST)){
            \App\Models\User::where('id',$_POST['userid'])->update(['name'=>$_POST['fullname'],'business_name'=>$_POST['businessname'],'city'=>$_POST['city'],'zip_code'=>$_POST['postalcode'],'country'=>$_POST['country'],'phone'=>$_POST['phone'],'your_position'=>$_POST['position'],'business_address'=>$_POST['businessaddress'],'state_name'=>$_POST['state'],'business_address2'=>$_POST['businessaddress2']]);
            $message = 'Successfully profile updated...!';
        }
        $userdata = \App\Models\User::where('id',$id)->first();
        return view('vendor.backpack.crud.myaccount.edit')->with('userdata',$userdata)->with('message',$message);
    }

    protected function passwordChange($id)
    {
        $message=$flag='';
        if(!empty($_POST)){
            $getuser = \App\Models\User::where('id',$_POST['userid'])->first();
            $message ='Password change successfully';
            $flag='success';
            if(!Hash::check(trim($_POST['currentpassword']),$getuser['password'])){
                $message ='Current password is wrong';
                $flag='error';
            }else{
                \App\Models\User::where('id',$_POST['userid'])->update(['password'=>Hash::make($_POST['password'])]);
            }
        }
        return view('vendor.backpack.crud.myaccount.password')->with('flag',$flag)->with('message',$message);
    }

    protected function addUserFields()
    {

        $this->crud->addFields([
            [
                'name'  => 'name',
                'label' => 'Full Name',
                'type'  => 'text',
                'attributes' => [ 'placeholder' => 'Full Name'],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]


            ],
            [
                'name'  => 'username',
                'label' => 'User Name',
                'type'  => 'text',
                'attributes' => [ 'placeholder' => 'User Name'],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]


            ],
            [
                'name'  => 'email',
                'label' => 'Email Address',
                'type'  => 'email',
                'attributes' => [ 'placeholder' => 'Enter Email'],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]

            ],
            [
                'name'  => 'phone',
                'label' => "Phone Number",
                'type'  => 'text',
                'attributes' => [ 'placeholder' => 'Enter Phone Number'],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]

            ],
            [
                'name'  => 'your_position',
                'label' => "Your position",
                'type'  => 'text',
                'attributes' => [ 'placeholder' => 'Enter Phone Number'],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]

            ],
            [
                'name'  => 'business_name',
                'label' => "Business Name",
                'type'  => 'text',
                'attributes' => [ 'placeholder' => 'Enter Business Name'],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]

            ],

            [
                'name'  => 'business_address',
                'label' => "Business/Organization Street address",
                'type'  => 'address_google',
                'store_as_json' => false,
                'attributes' => [ 'placeholder' => 'Enter Business Address'],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]

            ],
            [
                'name'  => 'city',
                'label' => "City",
                'type'  => 'text',
                'attributes' => [ 'placeholder' => 'Enter City'],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]

            ],
            [
                'name'  => 'state_name',
                'label' => "Province/State",
                'type'  => 'text',
                'attributes' => [ 'placeholder' => 'Enter State Name'],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]

            ],
            [
                'name'  => 'country',
                'label' => "Country",
                'type'  => 'text',
                'attributes' => [ 'placeholder' => 'Enter Country'],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]

            ],
            [
                'name'  => 'zip_code',
                'label' => "Postal Code / Zip",
                'type'  => 'text',
                'attributes' => [ 'placeholder' => 'Enter Postal Code / Zip'],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]

            ]
        ]);
    }
}
