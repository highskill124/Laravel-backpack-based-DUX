<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LocationRequest;
use App\Models\Category;
use App\Models\Location;
use App\Models\LocationGallery;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;


/**
 * Class LocationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class LocationCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation { destroy as traitDestroy; }

    use ListOperation;
    use CreateOperation;
    use UpdateOperation;
    use DeleteOperation;
    use ShowOperation;
    use CreateOperation {
        store as traitStore;
    }

    public $categories;
    public $popup;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {

        Widget::add()->type('style')->content('packages/filepond/filepond.css');
        Widget::add()->type('style')->content('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css');
        Widget::add()->type('style')->content('packages/bootstrap-toggle/css/bootstrap-toggle.min.css');
        Widget::add()->type('style')->content('packages/backpack/base/css/jq_validation.css');
        Widget::add()->type('style')->content('https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css');
        Widget::add()->type('script')->content('https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js');
        Widget::add()->type('script')->content('https://unpkg.com/filepond/dist/filepond.js');
        Widget::add()->type('script')->content('https://unpkg.com/jquery-filepond/filepond.jquery.js');
        Widget::add()->type('script')->content('packages/backpack/base/js/filepond/location_edit.js');
        Widget::add()->type('script')->content('packages/bootstrap-toggle/js/bootstrap-toggle.min.js');
        Widget::add()->type('script')->content('https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js');


        CRUD::setModel(Location::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/location');
        CRUD::setEntityNameStrings('location', 'locations');
        $this->categories = Category::pluck('category_name', 'id')->all();

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

        if(backpack_user()->hasRole('admin')==false) {

            $this->crud->addClause('whereHas', 'user', function ($query) {

                $creator = backpack_user()->id;
                $query->where('user_id', $creator);
            });
        }

        CRUD::column('location_name');
        CRUD::column('location_address');
        CRUD::column('website');
        CRUD::column('email_id');
        CRUD::column('phone_number');

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
        $this->data['categories']= $this->categories;
        $this->crud->setCreateView('backpack::crud.locations.create', $this->data);



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

        $this->crud->setEditContentClass('col-md-12');
        $location_cateories= new Category() ;
        $category_list = $location_cateories->getLocations($this->crud->getCurrentEntry()->id);
        $location_images = LocationGallery::where('location_id', $this->crud->getCurrentEntry()->id)->get()->toArray();
        $this->data['location_images'] = $location_images;

        if(count($category_list)>0)
            $this->data['categories']= $category_list;
        else
            $this->data['categories']= Null;

        $this->crud->setEditView('backpack::crud.locations.edit', $this->data);

    }


    /**
     * Store a newly created resource in the database.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(LocationRequest $request)
    {

        $validated = $request->validated();

        $pinput=$this->processFields($request->all());
        $pinput['created_by'] = backpack_user()->id;
        $new_location = Location::create($pinput);
        $ctg=$request['category'];
        $new_location->categories()->attach($ctg);


        if($request->hasFile('filepond')) {
            $uploadedFiles = $request->file('filepond');
            foreach ($uploadedFiles as $photo) {
                $locGallery = new LocationGallery();
                $locGallery->location_id = $new_location->id;
                $locGallery->is_active = 1;
                $locGallery->addLocationImageAttribute($photo);
                $locGallery->save();
            }
        }

        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($new_location->id);
    }
    public function update(LocationRequest $request)
    {
        $validated = $request->validated();

        $input = $request->except(['_token','_method']);
        $pinput=$this->processFields($input);
        $pinput['updated_by'] = backpack_user()->id;


        $updated_location=Location::with('categories')->whereId($this->crud->getCurrentEntry()->id)->first();

        //get previous location ids
        $detach=Arr::pluck($updated_location->categories->toArray(),'id');
        $updated_location->update($pinput);

        if(isset($input['category'])) {
            $ctg = $input['category'];
            $updated_location->categories()->sync($ctg);
        }
        else
        {
            $updated_location->categories()->detach($detach);
        }

        $this->uploadPhoto($request);



        $this->crud->setSaveAction();
        return $this->crud->performSaveAction($updated_location->id);
    }

    /**
     * Process all post values to save in db
     * @param $request
     * @return array
     */
    public function processFields($request)
    {
       // dd($request);
        $edit_location=array();
        $edit_location['location_name']=$request["location_name"];
        $edit_location['location_address']=$request["location_address"];
        $edit_location['location_description']=$request["location_description"];
        $edit_location['by_line']=$request["by_line"];
        $edit_location['email_id']=$request["email_id"];
        $edit_location['website']=$request["website"];
        $edit_location['facebook_url']=$request["facebook_url"];
        $edit_location['phone_number']=$request["phone_number"];
        $edit_location['twitter_url']=$request["twitter_url"];
        $edit_location['instagram_url']=$request["instagram_url"];
        $edit_location['youtube_url']=$request["youtube_url"];
        $edit_location['latitude']=$request["latitude"];
        $edit_location['longitude']=$request["longitude"];
        $edit_location['is_open_sunday']=$request["is_open_sunday"];
        $edit_location['is_open_monday']=$request["is_open_monday"];
        $edit_location['is_open_tuesday']=$request["is_open_tuesday"];
        $edit_location['is_open_wednesday']=$request["is_open_wednesday"];
        $edit_location['is_open_thrusday']=$request["is_open_thursday"];
        $edit_location['is_open_saturday']=$request["is_open_saturday"];
        $edit_location['is_active']=$request["is_active"];
        $edit_location['map_changed']=isset($request["map_changed"]) ? 1 : 0;
        $edit_location['notes']=$request["notes"];
        $edit_location['user_id']=backpack_user()->id;


        $from_sun_ampm= !isset($request["from_sun_ampm"]) ? "PM" : "AM";
        $to_sun_ampm= !isset($request["to_sun_ampm"]) ? "PM" : "AM";
        $from_mon_ampm= !isset($request["from_mon_ampm"]) ? "PM" : "AM";
        $to_mon_ampm= !isset($request["to_mon_ampm"]) ? "PM" : "AM";
        $from_tue_ampm= !isset($request["from_tue_ampm"]) ? "PM" : "AM";
        $to_tue_ampm= !isset($request["to_mon_ampm"]) ? "PM" : "AM";
        $from_wed_ampm= !isset($request["from_wed_ampm"]) ? "PM" : "AM";
        $to_wed_ampm= !isset($request["to_wed_ampm"]) ? "PM" : "AM";
        $from_thu_ampm= !isset($request["from_thu_ampm"]) ? "PM" : "AM";
        $to_thu_ampm= !isset($request["to_thu_ampm"]) ? "PM" : "AM";
        $from_fri_ampm= !isset($request["from_fri_ampm"]) ? "PM" : "AM";
        $to_fri_ampm= !isset($request["to_fri_ampm"]) ? "PM" : "AM";
        $from_sat_ampm= !isset($request["from_sat_ampm"]) ? "PM" : "AM";
        $to_sat_ampm= !isset($request["to_sat_ampm"]) ? "PM" : "AM";


        $edit_location['start_time_sunday']=date("H:i",strtotime($request["from_sun_hr"].":".$request["from_sun_min"]." ".$from_sun_ampm));
        $edit_location['end_time_sunday']=date("H:i",strtotime($request["to_sun_hr"].":".$request["to_sun_min"]." ".$to_sun_ampm));

        $edit_location['start_time_monday']=date("H:i",strtotime($request["from_mon_hr"].":".$request["from_mon_min"]." ".$from_mon_ampm));
        $edit_location['end_time_monday']=date("H:i",strtotime($request["to_mon_hr"].":".$request["to_mon_min"]." ".$to_mon_ampm));

        $edit_location['start_time_tuesday']=date("H:i",strtotime($request["from_tue_hr"].":".$request["from_tue_min"]." ".$from_tue_ampm));
        $edit_location['end_time_tuesday']=date("H:i",strtotime($request["to_tue_hr"].":".$request["to_tue_min"]." ".$to_tue_ampm));

        $edit_location['start_time_wednesday']=date("H:i",strtotime($request["from_wed_hr"].":".$request["from_wed_min"]." ".$from_wed_ampm));
        $edit_location['end_time_wednesday']=date("H:i",strtotime($request["to_wed_hr"].":".$request["to_wed_min"]." ".$to_wed_ampm));

        $edit_location['start_time_thrusday']=date("H:i",strtotime($request["from_thu_hr"].":".$request["from_thu_min"]." ".$from_thu_ampm));
        $edit_location['end_time_thrusday']=date("H:i",strtotime($request["to_thu_hr"].":".$request["to_thu_min"]." ".$to_thu_ampm));

        $edit_location['start_time_friday']=date("H:i",strtotime($request["from_fri_hr"].":".$request["from_fri_min"]." ".$from_fri_ampm));
        $edit_location['end_time_friday']=date("H:i",strtotime($request["to_fri_hr"].":".$request["to_fri_min"]." ".$to_fri_ampm));

        $edit_location['start_time_saturday']=date("H:i",strtotime($request["from_sat_hr"].":".$request["from_sat_min"]." ".$from_sat_ampm));
        $edit_location['end_time_saturday']=date("H:i",strtotime($request["to_sat_hr"].":".$request["to_sat_min"]." ".$to_sat_ampm));


        return  $edit_location;

    }

    /**
     * Upload location image file and save file info in database
     * @param LocationRequest $request
     * @return mixed
     */
    public function uploadPhoto(LocationRequest $request ) {

        //get previously saved images
        $savedImages = LocationGallery::where('location_id', $this->crud->getCurrentEntry()->id)->get()->toArray();
        if(count($savedImages)>0)
            $savedImages=Arr::pluck($savedImages,'location_image');

        $locGallery = new LocationGallery();

        $this->cleanDirectory('location/'.$this->crud->getCurrentEntry()->id);
        $locGallery->where('location_id',$this->crud->getCurrentEntry()->id)->delete();

       // dd($request->file('filepond'));

        if($request->hasFile('filepond')) {

            $uploadedFiles = $request->file('filepond');
            foreach ($uploadedFiles as $photo) {
                $locGallery = new LocationGallery();
                $locGallery->location_id = $this->crud->getCurrentEntry()->id;
                    $locGallery->is_active = 1;
                    $locGallery->addLocationImageAttribute($photo);
                    $locGallery->save();

            }
        }
    }

    /**
     * remove all images files of a location storage
     * @param $path
     * @param bool $recursive
     */
    public function cleanDirectory($path, $recursive = false)
    {
        $storage = Storage::disk('public');

        foreach($storage->files($path, $recursive) as $file) {
            $storage->delete($file);
        }
    }

//    public function edit($id) {
//
//        if ($this->crud->getEntry($id)->user_id != backpack_user()->id && !backpack_user()->hasRole('admin'))
//        { abort(503); }
//
//        return parent::edit($id);
//    }

    public function destroy($id) {
        if ($this->crud->getEntry($this->crud->getCurrentEntry()->id)->user_id != backpack_user()->id && !backpack_user()->hasRole('admin'))
        {
            abort(403, 'Unauthorized action');
        }
        return $this->crud->delete($id);
    }
}
