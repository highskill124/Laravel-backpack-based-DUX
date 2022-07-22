<?php

namespace App\Http\Controllers\Admin;


use Backpack\PermissionManager\app\Http\Controllers\UserCrudController as BackpackUserCrudController;
use App\Http\Requests\UserStoreCrudRequest as StoreRequest;
use App\Http\Requests\UserUpdateCrudRequest as UpdateRequest;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\Types\False_;

class UserCrudControllerExtended extends BackpackUserCrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    public function setup()
    {

        //Check CRUD permission for the user and grant access
        if(!backpack_user()->hasPermissionTo('create-user'))
        {
            $this->crud->denyAccess('create');
        }
        if(!backpack_user()->hasPermissionTo('edit-user'))
        {
            $this->crud->denyAccess('update');
        }
        if(!backpack_user()->hasPermissionTo('delete-user'))
        {
            $this->crud->denyAccess('delete');
        }
        if(!backpack_user()->hasPermissionTo('list-user'))
        {
            $this->crud->denyAccess('list');
        }



        $this->crud->setModel(config('backpack.permissionmanager.models.user'));
        $this->crud->setEntityNameStrings(trans('backpack::permissionmanager.user'), trans('backpack::permissionmanager.users'));
        $this->crud->setRoute(backpack_url('user'));
    }

    public function setupListOperation()
    {
        $this->crud->addColumns([
            [
                'name'  => 'name',
                'label' => trans('backpack::permissionmanager.name'),
                'type'  => 'text',
            ],
            [
                'name'  => 'email',
                'label' => trans('backpack::permissionmanager.email'),
                'type'  => 'email',
            ],
            [
                'name'  => 'business_name',
                'label' => "Business",

            ],
            [ // n-n relationship (with pivot table)
                'label'     => trans('backpack::permissionmanager.roles'), // Table column heading
                'type'      => 'select_multiple',
                'name'      => 'roles', // the method that defines the relationship in your Model
                'entity'    => 'roles', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model'     => config('permission.models.role'), // foreign key model
            ],

        ]);

        if (backpack_pro()) {
            // Role Filter
            $this->crud->addFilter(
                [
                    'name'  => 'role',
                    'type'  => 'dropdown',
                    'label' => trans('backpack::permissionmanager.role'),
                ],
                config('permission.models.role')::all()->pluck('name', 'id')->toArray(),
                function ($value) { // if the filter is active
                    $this->crud->addClause('whereHas', 'roles', function ($query) use ($value) {
                        $query->where('role_id', '=', $value);
                    });
                }
            );

            // Extra Permission Filter
            $this->crud->addFilter(
                [
                    'name'  => 'permissions',
                    'type'  => 'select2',
                    'label' => trans('backpack::permissionmanager.extra_permissions'),
                ],
                config('permission.models.permission')::all()->pluck('name', 'id')->toArray(),
                function ($value) { // if the filter is active
                    $this->crud->addClause('whereHas', 'permissions', function ($query) use ($value) {
                        $query->where('permission_id', '=', $value);
                    });
                }
            );
        }
    }

    public function setupCreateOperation()
    {
        $this->crud->set('create.contentClass', 'col-md-12');

        $this->addUserFields();
        $this->crud->setValidation(StoreRequest::class);
    }

    public function setupUpdateOperation()
    {
        $this->crud->set('edit.contentClass', 'col-md-12');


        $this->addUserFields();
        $this->crud->setValidation(UpdateRequest::class);
    }

    /**
     * Store a newly created resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {

        $this->crud->setRequest($this->crud->validateRequest());
        $this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run
        return $this->traitStore();
    }

    /**
     * Update the specified resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update()
    {

        $this->crud->setRequest($this->crud->validateRequest());
        $this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        return $this->traitUpdate();
    }

    /**
     * Handle password input fields.
     */
    protected function handlePasswordInput($request)
    {

        // Remove fields not present on the user.
        $request->request->remove('password_confirmation');
        $request->request->remove('roles_show');
        $request->request->remove('permissions_show');

        // Encrypt password if specified.
        if ($request->input('password')) {
            $request->request->set('password', Hash::make($request->input('password')));
        } else {
            $request->request->remove('password');
        }

        return $request;
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
                'name'  => 'password',
                'label' => trans('backpack::permissionmanager.password'),
                'type'  => 'password',
                'attributes' => [ 'placeholder' => 'Account Password'],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ]

            ],
            [
                'name'  => 'password_confirmation',
                'label' => trans('backpack::permissionmanager.password_confirmation'),
                'type'  => 'password',
                'attributes' => [ 'placeholder' => 'Confirm Password'],
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

            ],
            [   // radio
                'name'        => 'is_active', // the name of the db column
                'label'       => 'Status', // the input label
                'type'        => 'radio',
                'attributes' => [ 'placeholder' => 'Enter Status'],

                'options'     => [
                    // the key will be stored in the db, the value will be shown as label;
                    0 => "Inactive",
                    1 => "Active"
                ],
                // optional
                'inline'      => true, // show the radios all on the same line?
            ],

            [
                // two interconnected entities
                'label'             => trans('backpack::permissionmanager.user_role_permission'),
                'field_unique_name' => 'user_role_permission',
                'type'              => 'checklist_dependency',
                'name'              => ['roles', 'permissions'],
                'subfields'         => [
                    'primary' => [
                        'label'            => trans('backpack::permissionmanager.roles'),
                        'name'             => 'roles', // the method that defines the relationship in your Model
                        'entity'           => 'roles', // the method that defines the relationship in your Model
                        'entity_secondary' => 'permissions', // the method that defines the relationship in your Model
                        'attribute'        => 'name', // foreign key attribute that is shown to user
                        'model'            => config('permission.models.role'), // foreign key model
                        'pivot'            => true, // on create&update, do you need to add/delete pivot table entries?]
                        'number_columns'   => 4, //can be 1,2,3,4,6
                    ],
                    'secondary' => [
                        'label'          => mb_ucfirst(trans('backpack::permissionmanager.permission_plural')),
                        'name'           => 'permissions', // the method that defines the relationship in your Model
                        'entity'         => 'permissions', // the method that defines the relationship in your Model
                        'entity_primary' => 'roles', // the method that defines the relationship in your Model
                        'attribute'      => 'name', // foreign key attribute that is shown to user
                        'model'          => config('permission.models.permission'), // foreign key model
                        'pivot'          => true, // on create&update, do you need to add/delete pivot table entries?]
                        'number_columns' => 4, //can be 1,2,3,4,6
                    ],
                ],
            ],
        ]);
    }
}
