<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;

/**
 * Class CategoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class CategoryCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation;
    use UpdateOperation;
    use DeleteOperation;
    use ShowOperation;


    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        //Check CRUD permission for user and grant access
        if(!backpack_user()->hasPermissionTo('create-promotion'))
        {
            $this->crud->denyAccess('create');
        }
        if(!backpack_user()->hasPermissionTo('edit-promotion'))
        {
            $this->crud->denyAccess('update');
        }
        if(!backpack_user()->hasPermissionTo('delete-promotion'))
        {
            $this->crud->denyAccess('delete');
        }
        if(!backpack_user()->hasPermissionTo('list-promotion'))
        {
            $this->crud->denyAccess('list');
        }

        CRUD::setModel(Category::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/category');
        CRUD::setEntityNameStrings('category', 'categories');
        Widget::add()->type('style')->content('packages/filepond/filepond1.css');
        Widget::add()->type('style')->content('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css');
        Widget::add()->type('style')->content('https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css');
        Widget::add()->type('script')->content('https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js');
        Widget::add()->type('script')->content('https://unpkg.com/filepond/dist/filepond.js');
        Widget::add()->type('script')->content('https://unpkg.com/jquery-filepond/filepond.jquery.js');

    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {



        $this->crud->addColumns([
            [
                'name' => 'status',
                'label'=> 'Status',
                'type' => 'statusdot',

            ],
            [
                'name' => 'category_image',
                'label'=> 'Image',
                'type' => 'image',
                'prefix' => '/storage/',
                 'height' => '80px',
                 'width'  => '80px',

            ]

        ]);

        CRUD::column('category_image');
        CRUD::column('category_name');

    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        //this widget turns the image field (with the class my-pond) into a "filepond" so user can drag and drop
        Widget::add()->type('script')->content('packages/backpack/base/js/filepond/category_create.js');
        $this->crud->setCreateContentClass('col-md-12 bold-labels');

        $this->crud->addFields([
            [
                'name'  => 'category_image',
                'type'  => 'upload',
                'disk'   => 'public',
                'attributes' => [
                    'class'       => 'my-pond',
                ],
                'upload'    => true,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-12',
                    'style' => 'height:195px;'
                ],


            ],
            [
                'name'  => 'category_name',
                'label' => 'Category name',
                'type'  => 'text',
                'attributes' => [ 'placeholder' => 'Enter Category name'],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-12',

                ]
            ],
            [
                'name'  => 'category_description',
                'label' => 'Category Description',
                'type'  => 'textarea',
                'attributes' => [ 'placeholder' => 'Enter Category Description'],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-12'
                ]
            ],
            [   // radio
                'name'        => 'is_active', // the name of the db column
                'label'       => 'Status', // the input label
                'type'        => 'radio',

                'options'     => [
                    // the key will be stored in the db, the value will be shown as label;
                    0 => "Inactive",
                    1 => "Active"
                ],
                // optional
                'inline'      => true, // show the radios all on the same line?
            ],


        ]);

        $this->crud->setValidation(CategoryRequest::class);

    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        Widget::add()->type('script')->content('packages/backpack/base/js/filepond/category_edit.js');
        $this->crud->setUpdateContentClass('col-md-12 bold-labels');
        $this->crud->addFields([
            [
                'name'  => 'category_image',
                'type'  => 'imageedit',
                'disk'   => 'public',
                'attributes' => [
                    'class'       => 'my-pond',
                ],
                'upload'    => true,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-12',
                    'style' => 'height:200px;'
                ]

            ],
            [
                'name'  => 'category_name',
                'label' => 'Category name',
                'type'  => 'text',
                'attributes' => [ 'placeholder' => 'Enter Category name'],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-12',

                ]
            ],
            [
                'name'  => 'category_description',
                'label' => 'Category Description',
                'type'  => 'textarea',
                'attributes' => [ 'placeholder' => 'Enter Category Description'],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-12'
                ]
            ],
            [   // radio
                'name'        => 'is_active', // the name of the db column
                'label'       => 'Status', // the input label
                'type'        => 'radio',

                'options'     => [
                    // the key will be stored in the db, the value will be shown as label;
                    0 => "Inactive",
                    1 => "Active"
                ],
                // optional
                'inline'      => true, // show the radios all on the same line?
            ],


        ]);
        $this->crud->setValidation(CategoryRequest::class);
    }


}
