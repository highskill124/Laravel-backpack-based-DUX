<?php

namespace App\Http\Controllers\Admin;
use App\Http\Requests\PromotionRequest;
use App\Models\Location;
use App\Models\Promotion;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use Illuminate\Support\Arr;

/**
 * Class PromotionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PromotionCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    public $locations;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {

        //Check CRUD permission for user and grant access
        // if(!backpack_user()->hasPermissionTo('create-promotion'))
        // {
        //     $this->crud->denyAccess('create');
        // }
        // if(!backpack_user()->hasPermissionTo('edit-promotion'))
        // {
        //     $this->crud->denyAccess('update');
        // }
        // if(!backpack_user()->hasPermissionTo('delete-promotion'))
        // {
        //     $this->crud->denyAccess('delete');
        // }
        // if(!backpack_user()->hasPermissionTo('list-promotion'))
        // {
        //     $this->crud->denyAccess('list');
        // }

        Widget::add()->type('style')->content('packages/backpack/base/css/jq_validation.css');
        Widget::add()->type('script')->content('packages/backpack/base/js/custom_ui.js');
        Widget::add()->type('script')->content('https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js');

        CRUD::setModel(Promotion::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/promotion');
        CRUD::setEntityNameStrings('promotion', 'promotions');
        $this->crud->promotion_locations = Location::where('user_id',backpack_user()->id)->get(['location_name', 'id'])->all();


    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {

        if(backpack_user()->hasRole('admin')==false) {

            $this->crud->addClause('whereHas', 'user', function ($query) {

                $creator = backpack_user()->id;
                $query->where('user_id', $creator);
            });
        }
        $this->crud->addColumn([

            'name' => 'status',
            'label'=> 'Status',
            'type' => 'statusdot',

        ]);
        CRUD::column('promotion_title');
        CRUD::column('promotion_description');

        CRUD::column('start_date');
        CRUD::column('end_date');
        CRUD::column('vip_promotion_description');

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
        $this->crud->setCreateContentClass('col-md-12');
       // $this->crud->setCreateView('backpack::crud.promotions.create', $this->data);
        $this->crud->addField([
            'name'  => 'user_id',
            'type'  => 'hidden',
            'value' => ''

        ]);

        $this->crud->addField(['type' => 'hidden', 'name' => 'updated_by']);

        $this->crud->addField([
                'name'  => 'promotion_title',
                'label' => 'Promotion title',
                'type'  => 'text',
                'attributes' => [ 'placeholder' => 'Enter promotion title']

            ]);


        $this->crud->addField([
            'name' => 'is_ongoing_promotion',
            'label' => 'Ongoing Promotion',
            'type'        => 'radio',
            'options'     => [
                1 => "Yes",
                0 => "No"
            ],
            'default' => true,
            'inline'  => true,
            'attributes' => [ 'name' =>'is_ongoing_promotion'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]

        ]);
        $this->crud->addField([
            'name' => 'is_active',
            'label' => 'Status',
            'type'        => 'radio',
            'options'     => [
                1 => "Yes",
                0 => "No"
            ],
            'default' => true,
            'inline'  => true,
            'attributes' => [ 'name' =>'is_active'],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]

        ]);

        $this->crud->addField([
            'name'  => ['start_date', 'end_date'], // db columns for start_date & end_date
            'label' => 'Event Date Range',
            'type'  => 'date_range',
            'attributes' => [ 'id' =>'date_range'],

            // OPTIONALS
            // default values for start_date & end_date
            'default'            => [date('Y-m-d'), date("Y-m-d")],
            // options sent to daterangepicker.js
            'date_range_options' => [
                'drops' => 'down', // can be one of [down/up/auto]
                'timePicker' => false,
                'locale' => ['format' => 'YYYY-MM-DD']
            ]

        ]);


        $this->crud->addField([
            'name'  => 'promotion_description',
            'label' => 'Promotion description',
            'type'  => 'textarea',
            'attributes' => [ 'placeholder' => 'Enter promotion description']

        ]);

        $this->crud->addField([
            'name'  => 'promotion_fineprint',
            'label' => 'Promotion fineprint',
            'type'  => 'textarea',
            'attributes' => [ 'placeholder' => 'Enter promotion fineprint']

        ]);


        CRUD::field('promotion_fineprint');

        $this->crud->addField([
            'name' => 'vip_promotion',
            'label' => 'VIP promotion',
            'type'  => 'radio',
            'options' => [
                1 => "Yes",
                0 => "No"
            ],
            'default' => 0,
            'inline'  => true,
            'attributes' => ['name' =>'vip_promotion'],

          ]);



        $this->crud->addField([
            'name' => 'vip_promotion_description',
            'type' => 'textarea', // 10
            'attributes' => [
                'placeholder' => 'Enter VIP promotion description',
                'class'       => 'form-control some-class',
                'id'    => 'vip_promotion_description',
            ]

        ]);

        $this->crud->addField([
            'name' => 'locations[]',
            'label' => "Locations",
            'type' => 'location_picker', // 10

        ]);


       $this->crud->setValidation(PromotionRequest::class);


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
    protected function setupUpdateOperation()
    {
        if ($this->crud->getEntry($this->crud->getCurrentEntry()->id)->user_id != backpack_user()->id && !backpack_user()->hasRole('admin'))
        {
            abort(403, 'Unauthorized action');
        }
        $promotion_locations= new Location();
        $this->crud->promotion_locations=$promotion_locations->getPromotions($this->crud->getCurrentEntry()->id);
       // $this->crud->setUpdateView('backpack::crud.promotions.create', $this->data);

        $this->setupCreateOperation();
    }

    public function store(PromotionRequest $request)
    {

        $this->crud->getRequest()->request->add(['user_id' => backpack_user()->id]);
        $this->crud->getRequest()->request->add(['created_by' => backpack_user()->id]);

        $this->crud->setRequest($this->crud->validateRequest());

        $traitstore=$this->traitStore();

        $id = $this->crud->entry->id;
        $create_promotion=Promotion::whereId($id)->first();
        $create_promotion->locations()->attach($request['locations']);

        return $traitstore;
    }
    public function update(PromotionRequest $request)
    {

        $this->crud->getRequest()->request->add(['user_id' => backpack_user()->id]);
        $this->crud->getRequest()->request->add(['updated_by' => backpack_user()->id]);


        $this->crud->setRequest($this->crud->validateRequest());


        $updatedPromotions=$this->traitUpdate();
       // $updated_location->update($pinput);

        $updated_promotion=Promotion::with('locations')->whereId($this->crud->getCurrentEntry()->id)->first();
        //get previous location ids
        $detach=Arr::pluck($updated_promotion->locations->toArray(),'id');

        //dd($request['locations']);
        if(isset($request['locations'])) {
            $ctg = $request['locations'];
            $updated_promotion->locations()->sync($ctg);
        }
        else
        {
            $updated_promotion->locations()->detach($detach);
        }


        return $updatedPromotions;
    }



    public function destroy($id) {
        if ($this->crud->getEntry($this->crud->getCurrentEntry()->id)->user_id != backpack_user()->id && !backpack_user()->hasRole('admin'))
        {
            abort(403, 'Unauthorized action');
        }

        return $this->crud->delete($id);
    }


}
