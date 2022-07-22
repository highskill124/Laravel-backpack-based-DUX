@extends(backpack_view('blank'))
@php
    $defaultBreadcrumbs = [
      trans('backpack::crud.admin') => backpack_url('dashboard'),
      $crud->entity_name_plural => url($crud->route),
      trans('backpack::crud.edit') => false,
    ];

    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;

    //var_dump($errors->has('category'));

@endphp

@section('header')
	<section class="container-fluid">
	  <h2>
        <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
        <small>{!! $crud->getSubheading() ?? trans('backpack::crud.add').' '.$crud->entity_name !!}.</small>

        @if ($crud->hasAccess('list'))
          <small><a href="{{ url($crud->route) }}" class="d-print-none font-sm"><i class="la la-angle-double-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
        @endif
	  </h2>
	</section>
@endsection

@section('content')

<div class="row">

	<div class="{{ $crud->getEditContentClass() }}">
{{--        <div class="col-md-10 bold-labels">--}}
		<!-- Default box -->



		@include('crud::inc.grouped_errors')

        {!! csrf_field() !!}
        {!! method_field('PUT') !!}

		  <form method="post" action="{{ url($crud->route.'/'.$entry->getKey()) }}"	enctype="multipart/form-data" id="location-form"  >
			  {!! csrf_field() !!}
              {!! method_field('PUT') !!}
              <input type="hidden" id="location-id" value="{{$entry->getKey()}}" />
             @php
              $limages=null;
              foreach ($location_images as $l)
              {
                 echo "<input type='hidden' name='limages[]' value='".basename($l['location_image'])."'/>";

              }

              @endphp
             <div class="col-md-12">
                      <div class="card">
                          <div class="card-body">
                              <div class="card-body">
                                  <div class="form-group row" style="height:fit-content; display:flex;flex-direction: row;">
                                      <label class="col-md-3 text-center" ><i class='nav-icon la la-camera-retro' style="font-size:4em;"></i></label>

                                      <div class="col-md-9" style="margin: 0px;padding: 0px;">
                                            <input type="file" class="my-pond" name="filepond[]" multiple/>
                                      </div>
                                  </div>

                                  <div class="form-group row">
                                  <div class="col-md-3 text-center" style="margin: 0px;padding: 0px;">
                                        <i class='nav-icon la la-building' style="font-size:4em;"></i>
                                  </div>
                                  <div class="col-md-9" style="margin: 0px;padding: 0px;">
                                      <input class="form-control{{($errors->first('location_name') ? " is-invalid" : "")}}" id="location_name" type="text" name="location_name" placeholder="Enter Location Name" value="{{$entry->location_name}}" required/>
                                      {!! $errors->first('location_name', '<p class="invalid-feedback">:message</p>') !!}

                                      </br>
                                      <input class="form-control map-input {{($errors->first('location_address') ? " is-invalid" : "")}}" id="address-input" type="text" name="location_address" placeholder="Enter Location Address"  value="{{$entry->location_address}}"/>
                                      {!! $errors->first('location_address', '<p class="invalid-feedback">:message</p>') !!}
                                        </br>
                                      <textarea class="form-control" name="by_line" type="text" placeholder="Enter Byline">{{$entry->by_line}}</textarea>
                                      </br>
                                      <textarea class="form-control{{($errors->first('location_description') ? " is-invalid" : "")}}" name="location_description" type="text"  placeholder="Enter Location Description">{{$entry->location_description}}</textarea>
                                      {!! $errors->first('location_description', '<p class="invalid-feedback">:message</p>') !!}
                                  </div>

                              </div>

                              <div class="form-group row">
                                      <label class="col-md-3 col-form-label" for="hf-email"></label>
                                      <div style="width:35%;margin-left: 0px;padding-left: 0px;" >
                                          <input class="form-control{{($errors->first('email_id') ? " is-invalid" : "")}}" id="email_id" type="text" name="email_id" placeholder="Enter Email" value="{{$entry->email_id}}" />
                                          {!! $errors->first('email_id', '<p class="invalid-feedback">:message</p>') !!}
                                      </div>
                                     <div  style="width:35%;margin-left: 5%;margin-right: 0px;padding-right: 0px;" >
                                        <input class="form-control" id="website" type="text" name="website" placeholder="Enter Website" value="{{$entry->website}}" />
                                    </div>
                              </div>
                                  <div class="form-group row" style="margin-bottom: 20px;">
                                      <label class="col-md-3 col-form-label" for="hf-email"></label>
                                      <div style="width:35%;margin-left: 0px;padding-left: 0px;" >
                                          <input class="form-control{{($errors->first('phone_number') ? " is-invalid" : "")}}" id="phone_number" type="text" name="phone_number" placeholder="Enter Phone Number" value="{{$entry->phone_number}}" />
                                          {!! $errors->first('phone_number', '<p class="invalid-feedback">:message</p>') !!}
                                      </div>
                                      <div  style="width:35%;margin-left: 5%;margin-right: 0px;padding-right: 0px;" >
                                          <label style="width: 50px">Status </label>
                                          <div class="form-check form-check-inline" style="margin-top: 2px;">
                                              <input class="form-check-input" type="radio" name="is_active" id="is_active" value="1" {{$entry->is_active ? "checked" : ""}}>
                                              <label class="form-check-label" for="inlineRadio1">Active</label>
                                                &nbsp;&nbsp;
                                              <input class="form-check-input" type="radio" name="is_active" id="is_active" value="0" {{$entry->is_active==0 ? "checked" : ""}}>
                                              <label class="form-check-label" for="inlineRadio2">Inactive</label>
                                          </div>
                                      </div>
                                  </div>

                                  <div class="form-group row" style="padding-top: 20px;">
                                      <div class="col-md-3 text-center" style="margin: 0px;padding: 0px;">
                                          <i class='icon la la-users' style="font-size:4em;"></i>
                                      </div>
                                      <div class="row" style="margin: 0px;padding: 0px;width: 75%;">
                                        <div style="width:46.5%;margin-left: 0px;padding-left: 0px;" >
                                           <input class="form-control" id="facebook_url" type="text" name="facebook_url" placeholder="Enter Facebook URL"  value="{{$entry->facebook_url}}"/>
                                        </div>
                                         <div style="width:46.5%;margin-left: 7%;" >
                                              <input class="form-control" id="twitter_url" type="text" name="twitter_url" placeholder="Enter Twitter URl" value="{{$entry->twitter_url}}" />
                                         </div>
                                      </div>
                                      <label class="col-md-3 text-center" for="hf-email"></label>
                                      <div style="width:35%;margin-left: 0px;padding-left: 0px;" >
                                          <input class="form-control" id="instagram_url" type="text" name="instagram_url" placeholder="Enter Instagram URl" value="{{$entry->facebook_url}}" />
                                      </div>
                                      <div  style="width:35%;margin-left: 5%;margin-right: 0px;padding-right: 0px;" >
                                          <input class="form-control" id="youtube_url" type="text" name="youtube_url" placeholder="Enter Youtube URl" value="{{$entry->youtube_url}}" />

                                      </div>
                                  </div>

                                  <div class="form-group row" style="padding-top: 20px;">
                                      <div class="col-md-3 text-center" style="margin: 0px;padding: 0px;">

                                          <i class="fas fa-regular fa-location-dot" style="font-size:4em;"></i>
                                      </div>
                                      <div class="row" style="margin: 0px;padding: 0px;width: 75%;height: 400px;" id="address-map">


                                      </div>

                                  </div>

                                  <div class="form-group row">
                                      <div class="col-md-3 text-center" style="margin: 0px;padding: 0px;" >
                                      </div>
                                      <div style="width:35%;margin-left: 0px;padding-left: 0px;" >
                                          <input class="form-control" id="address-latitude" type="text"  name="latitude" placeholder="Enter Latitude" value="{{$entry->latitude}}" />
                                      </div>
                                      <div  style="width:35%;margin-left: 5%;margin-right: 0px;padding-right: 0px;" >
                                          <input class="form-control" id="address-longitude" type="text" name="longitude" placeholder="Enter Longitude" value="{{$entry->longitude}}" />
                                      </div>
                                  </div>
                                  <div class="form-group row">
                                      <div class="col-md-3 text-center" style="margin: 0px;padding: 0px;">
                                          &nbsp;
                                      </div>
                                      <div class="row" style="margin-left: 15px;padding: 5px;width: 75%;">
                                          <input class="form-check-input" type="checkbox"  value="0" id="map_changed" name="map_changed" {{$entry->map_changed ? "checked" : ""}}>
                                          <label class="form-check-label" id="map_changedlbl" for="flexCheckDefault">
                                              By clicking the checkbox, I confirm that the above is correct and the pointer is positioned properly on my location. I acknowledge that it is my responsibility to assure the accuracy of this information. I understand that this information will be used to direct visitors to my location.
                                         </label>

                                      </div>
                                  </div>
                                  <div class="form-group row">
                                      <div class="col-md-3 text-center" style="margin: 0px;padding: 0px;">
                                          <i class='icon la la-building-o' style="font-size:4em;"></i>
                                      </div>
                                      <div style="margin: 0px;padding: 0px;width: 75%;{{ ($errors->has('category') ? ";color:red;" : '') }}">
                                          <div style="margin: 0px;padding: 0px;width: 100%;">
                                              <label  >Location Category</label>
                                          </div>
                                          <div class="form-group" >
                                          @foreach ($categories as $lcategory)
                                                   <div class="form-check">
                                                    <input name="category[]" type="checkbox" value="{{ $lcategory['id'] }}" {{ $lcategory['lid'] ? "checked" : " "}} > {{ $lcategory['value'] }}
                                                   </div>

                                          @endforeach
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-group row">
                                      <div class="col-md-3 text-center" style="margin: 0px;padding: 0px;">
                                          <i class='icon la la-stopwatch' style="font-size:4em;"></i>
                                      </div>
                                      <div class="form-group row" style="margin: 0px;padding: 0px;width: 75%;">
                                          <div class="form custom-control-inline" style="width: 100%;margin-bottom: 10px;">
                                              <div class="col-md-2">
                                                  <label>Sunday</label>
                                              </div>
                                              <div class="col-md-3" >
                                                  <div class="form-check form-check-inline">
                                                      <input class="form-check-input" type="radio" name="is_open_sunday"  value="1"  {{ $entry->is_open_sunday ? "checked" : " "}}>
                                                      <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                  </div>
                                                  <div class="form-check form-check-inline">
                                                      <input class="form-check-input" type="radio" name="is_open_sunday"  value="0" {{ !$entry->is_open_sunday ? "checked" : " "}}>
                                                      <label class="form-check-label" for="inlineRadio2">No</label>
                                                  </div>
                                              </div>
                                              <div class="col-md-9">
                                                  <div class="form custom-control-inline" id="sunday" style="display: none;">
                                                      <input type="text"  name="from_sun_hr" min="1" max="12" maxlength="2" style="width: 40px;margin: 0px;" placeholder="HH" value="{{ $entry->start_time_sunday!="00:00:00" ? substr($entry->start_time_sunday,0, 2):''}}"
                                                             onchange="leadingZeroshours(this,'from_sun_ampm')"
                                                             onclick="leadingZeroshours(this,'from_sun_ampm')"> &nbsp;&nbsp; : &nbsp;&nbsp;
                                                      <input type="text"   name="from_sun_min" min="1" max="59" style="width: 40px;" placeholder="MM" maxlength="2" value="{{ $entry->start_time_sunday!="00:00:00" ? substr($entry->start_time_sunday,3, 2):''}}"
                                                             onchange="leadingZeros(this)"
                                                             onclick="leadingZeros(this)"> &nbsp;&nbsp;
                                                      <input id="from_sun_ampm" name="from_sun_ampm" type="checkbox" checked="true" data-toggle="toggle" data-on="AM" data-off="PM" data-onstyle="success" data-offstyle="danger">
                                                      &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; - &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                                                      <input type="text"  name="to_sun_hr" min="1" max="12" maxlength="2" style="width: 40px;margin: 0px;" placeholder="HH" value="{{ $entry->end_time_sunday!="00:00:00" ? substr($entry->end_time_sunday,0, 2):''}}"
                                                             onchange="leadingZeroshours(this,'to_sun_ampm')"
                                                             onclick="leadingZeroshours(this,'to_sun_ampm')"> &nbsp;&nbsp; : &nbsp;&nbsp;
                                                      <input type="text"   name="to_sun_min" min="1" max="59" style="width: 40px;" placeholder="MM" maxlength="2" value="{{ $entry->end_time_sunday!="00:00:00" ? substr($entry->end_time_sunday,3, 2):''}}"
                                                             onchange="leadingZeros(this)"
                                                             onclick="leadingZeros(this)"> &nbsp;&nbsp;
                                                      <input id="to_sun_ampm" name="to_sun_ampm" type="checkbox" checked data-toggle="toggle" data-on="AM" data-off="PM" data-onstyle="success" data-offstyle="danger">
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="form custom-control-inline" style="width: 100%;margin-bottom: 10px;" >
                                              <div class="col-md-2">
                                                  <label>Monday</label>
                                              </div>
                                              <div class="col-md-3" >
                                                  <div class="form-check form-check-inline">
                                                      <input class="form-check-input" type="radio" name="is_open_monday"  value="1" {{ $entry->is_open_monday ? "checked" : " "}}>
                                                      <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                  </div>
                                                  <div class="form-check form-check-inline">
                                                      <input class="form-check-input" type="radio" name="is_open_monday"  value="0" {{ !$entry->is_open_monday ? "checked" : " "}} >
                                                      <label class="form-check-label" for="inlineRadio2">No</label>
                                                  </div>
                                              </div>
                                              <div class="col-md-9">
                                                  <div class="form custom-control-inline" id="monday" style="display: none;">
                                                      <input type="text"  name="from_mon_hr" min="1" max="12" maxlength="2" style="width: 40px;margin: 0px;" placeholder="HH" value="{{ $entry->start_time_monday!="00:00:00" ? substr($entry->start_time_monday,0, 2):''}}"
                                                             onchange="leadingZeroshours(this,'from_mon_ampm')"
                                                             onclick="leadingZeroshours(this,'from_mon_ampm')"> &nbsp;&nbsp; : &nbsp;&nbsp;
                                                      <input type="text"   name="from_mon_min" min="1" max="59" style="width: 40px;" placeholder="MM" maxlength="2" value="{{ $entry->start_time_monday!="00:00:00" ? substr($entry->start_time_monday,3, 2):''}}"
                                                             onchange="leadingZeros(this)"
                                                             onclick="leadingZeros(this)"> &nbsp;&nbsp;
                                                      <input id="from_mon_ampm" name="from_mon_ampm" type="checkbox" checked data-toggle="toggle" data-on="AM" data-off="PM" data-onstyle="success" data-offstyle="danger">
                                                      &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; - &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                                                      <input type="text"  name="to_mon_hr" min="1" max="12" maxlength="2" style="width: 40px;margin: 0px;" placeholder="HH"  value="{{ $entry->end_time_monday!="00:00:00" ? substr($entry->end_time_monday,0, 2):''}}"
                                                             onchange="leadingZeroshours(this,'to_mon_ampm')"
                                                             onclick="leadingZeroshours(this,'to_mon_ampm')"> &nbsp;&nbsp; : &nbsp;&nbsp;
                                                      <input type="text"   name="to_mon_min" min="1" max="59" style="width: 40px;" placeholder="MM" maxlength="2"  value="{{ $entry->end_time_monday!="00:00:00" ? substr($entry->end_time_monday,3, 2):''}}"
                                                             onchange="leadingZeros(this)"
                                                             onclick="leadingZeros(this)"> &nbsp; &nbsp;&nbsp;
                                                      <input id="to_mon_ampm" name="to_mon_ampm" type="checkbox" checked data-toggle="toggle" data-on="AM" data-off="PM" data-onstyle="success" data-offstyle="danger">
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="form custom-control-inline" style="width: 100%;margin-bottom: 10px;" >
                                              <div class="col-md-2">
                                                  <label>Tuesday</label>
                                              </div>
                                              <div class="col-md-3" >
                                                  <div class="form-check form-check-inline">
                                                      <input class="form-check-input" type="radio" name="is_open_tuesday"  value="1" {{ $entry->is_open_tuesday ? "checked" : " "}}>
                                                      <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                  </div>
                                                  <div class="form-check form-check-inline">
                                                      <input class="form-check-input" type="radio" name="is_open_tuesday"  value="0" {{ !$entry->is_open_tuesday ? "checked" : " "}}>
                                                      <label class="form-check-label" for="inlineRadio2">No</label>
                                                  </div>
                                              </div>
                                              <div class="col-md-9">
                                                  <div class="form custom-control-inline" id="tuesday" style="display: none;">
                                                      <input type="text"  name="from_tue_hr" min="1" max="12" maxlength="2" style="width: 40px;margin: 0px;" placeholder="HH" value="{{ $entry->start_time_tuesday!="00:00:00" ? substr($entry->start_time_tuesday,0, 2):''}}"
                                                             onchange="leadingZeroshours(this,'from_tue_ampm')"
                                                             onclick="leadingZeroshours(this,'from_tue_ampm')"> &nbsp;&nbsp; : &nbsp;&nbsp;
                                                      <input type="text"   name="from_tue_min" min="1" max="59" style="width: 40px;" placeholder="MM" maxlength="2" value="{{ $entry->start_time_tuesday!="00:00:00" ? substr($entry->start_time_tuesday,3, 2):''}}"
                                                             onchange="leadingZeros(this)"
                                                             onclick="leadingZeros(this)"> &nbsp;&nbsp;
                                                      <input id="from_tue_ampm" name="from_tue_ampm" type="checkbox" checked data-toggle="toggle" data-on="AM" data-off="PM" data-onstyle="success" data-offstyle="danger">
                                                      &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; - &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                                                      <input type="text"  name="to_tue_hr" min="1" max="12" maxlength="2" style="width: 40px;margin: 0px;" placeholder="HH" value="{{ $entry->end_time_tuesday!="00:00:00" ? substr($entry->end_time_tuesday,0, 2):''}}"
                                                             onchange="leadingZeroshours(this,'to_tue_ampm')"
                                                             onclick="leadingZeroshours(this,'to_tue_ampm')"> &nbsp;&nbsp; : &nbsp;&nbsp;
                                                      <input type="text"   name="to_tue_min" min="1" max="59" style="width: 40px;" placeholder="MM" maxlength="2" value="{{ $entry->end_time_tuesday!="00:00:00" ? substr($entry->end_time_tuesday,3, 2):''}}"
                                                             onchange="leadingZeros(this)"
                                                             onclick="leadingZeros(this)" > &nbsp;&nbsp;
                                                      <input id="to_tue_ampm" name="to_tue_ampm" type="checkbox" checked data-toggle="toggle" data-on="AM" data-off="PM" data-onstyle="success" data-offstyle="danger">
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="form custom-control-inline" style="width: 100%;margin-bottom: 10px;" >
                                              <div class="col-md-2">
                                                  <label>Wednesday</label>
                                              </div>
                                              <div class="col-md-3" >
                                                  <div class="form-check form-check-inline">
                                                      <input class="form-check-input" type="radio" name="is_open_wednesday"  value="1" {{ $entry->is_open_wednesday ? "checked" : " "}}>
                                                      <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                  </div>
                                                  <div class="form-check form-check-inline">
                                                      <input class="form-check-input" type="radio" name="is_open_wednesday"  value="0" {{ !$entry->is_open_wednesday ? "checked" : " "}}>
                                                      <label class="form-check-label" for="inlineRadio2">No</label>
                                                  </div>
                                              </div>
                                              <div class="col-md-9">
                                                  <div class="form custom-control-inline" id="wednesday" style="display: none;">
                                                      <input type="text"  name="from_wed_hr" min="1" max="12" maxlength="2" style="width: 40px;margin: 0px;" placeholder="HH" value="{{ $entry->start_time_wednesday!="00:00:00" ? substr($entry->start_time_wednesday,0, 2):''}}"
                                                             onchange="leadingZeroshours(this,'from_wed_ampm')"
                                                             onclick="leadingZeroshours(this,'from_wed_ampm')">  &nbsp;&nbsp; : &nbsp;&nbsp;
                                                      <input type="text"   name="from_wed_min" min="1" max="59" style="width: 40px;" placeholder="MM" maxlength="2" value="{{ $entry->start_time_wednesday!="00:00:00" ? substr($entry->start_time_wednesday,3, 2):''}}"
                                                             onchange="leadingZeros(this)"
                                                             onclick="leadingZeros(this)"> &nbsp;&nbsp;
                                                      <input id="from_wed_ampm" name="from_wed_ampm" type="checkbox" checked data-toggle="toggle" data-on="AM" data-off="PM" data-onstyle="success" data-offstyle="danger">
                                                      &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; - &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                                                      <input type="text"  name="to_wed_hr" min="1" max="12" maxlength="2" style="width: 40px;margin: 0px;" placeholder="HH" value="{{ $entry->end_time_wednesday!="00:00:00" ? substr($entry->end_time_wednesday,0, 2):''}}"
                                                             onchange="leadingZeroshours(this,'to_wed_ampm')"
                                                             onclick="leadingZeroshours(this,'to_wed_ampm')"> &nbsp;&nbsp; : &nbsp;&nbsp;
                                                      <input type="text"   name="to_wed_min" min="1" max="59" style="width: 40px;" placeholder="MM" maxlength="2" value="{{ $entry->end_time_wednesday!="00:00:00" ? substr($entry->end_time_wednesday,3, 2):''}}"
                                                             onchange="leadingZeros(this)"
                                                             onclick="leadingZeros(this)">  &nbsp;&nbsp;
                                                      <input id="to_wed_ampm" name="to_wed_ampm" type="checkbox" checked data-toggle="toggle" data-on="AM" data-off="PM" data-onstyle="success" data-offstyle="danger">
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="form custom-control-inline" style="width: 100%;margin-bottom: 10px;" >
                                              <div class="col-md-2">
                                                  <label>Thursday</label>
                                              </div>
                                              <div class="col-md-3" >
                                                  <div class="form-check form-check-inline">
                                                      <input class="form-check-input" type="radio" name="is_open_thursday"  value="1" {{ $entry->is_open_thursday ? "checked" : " "}}>
                                                      <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                  </div>
                                                  <div class="form-check form-check-inline">
                                                      <input class="form-check-input" type="radio" name="is_open_thursday"  value="0" {{ !$entry->is_open_thursday ? "checked" : " "}}>
                                                      <label class="form-check-label" for="inlineRadio2">No</label>
                                                  </div>
                                              </div>
                                              <div class="col-md-9">
                                                  <div class="form custom-control-inline" id="thursday" style="display: none;">
                                                      <input type="text"  name="from_thu_hr" min="1" max="12" maxlength="2" style="width: 40px;margin: 0px;" placeholder="HH" value="{{ $entry->start_time_thrusday!="00:00:00" ? substr($entry->start_time_thrusday,0, 2):''}}"
                                                             onchange="leadingZeroshours(this,'from_thu_ampm')"
                                                             onclick="leadingZeroshours(this,'from_thu_ampm')"> &nbsp;&nbsp; : &nbsp;&nbsp;
                                                      <input type="text"   name="from_thu_min" min="1" max="59" style="width: 40px;" placeholder="MM" maxlength="2" value="{{ $entry->start_time_thrusday!="00:00:00" ? substr($entry->start_time_thrusday,3, 2):''}}"
                                                             onchange="leadingZeros(this)"
                                                             onclick="leadingZeros(this)"> &nbsp;&nbsp;
                                                      <input id="from_thu_ampm" name="from_thu_ampm" type="checkbox" checked data-toggle="toggle" data-on="AM" data-off="PM" data-onstyle="success" data-offstyle="danger">
                                                      &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; - &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                                                      <input type="text"  name="to_thu_hr" min="1" max="12" maxlength="2" style="width: 40px;margin: 0px;" placeholder="HH" value="{{ $entry->end_time_thrusday!="00:00:00" ? substr($entry->end_time_thrusday,0, 2):''}}"
                                                             onchange="leadingZeroshours(this,'to_thu_ampm')"
                                                             onclick="leadingZeroshours(this,'to_thu_ampm')"> &nbsp;&nbsp; : &nbsp;&nbsp;
                                                      <input type="text"   name="to_thu_min" min="1" max="59" style="width: 40px;" placeholder="MM" maxlength="2" value="{{ $entry->end_time_thrusday!="00:00:00" ? substr($entry->end_time_thrusday,3, 2):''}}"
                                                             onchange="leadingZeros(this)"
                                                             onclick="leadingZeros(this)"> &nbsp;&nbsp;
                                                      <input id="to_thu_ampm" name="to_thu_ampm" type="checkbox" checked data-toggle="toggle" data-on="AM" data-off="PM" data-onstyle="success" data-offstyle="danger">
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="form custom-control-inline" style="width: 100%;margin-bottom: 10px;" >
                                              <div class="col-md-2">
                                                  <label>Friday</label>
                                              </div>
                                              <div class="col-md-3" >
                                                  <div class="form-check form-check-inline">
                                                      <input class="form-check-input" type="radio" name="is_open_friday"  value="1" {{ $entry->is_open_friday ? "checked" : " "}}>
                                                      <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                  </div>
                                                  <div class="form-check form-check-inline">
                                                      <input class="form-check-input" type="radio" name="is_open_friday"  value="0" {{ !$entry->is_open_friday ? "checked" : " "}}>
                                                      <label class="form-check-label" for="inlineRadio2">No</label>
                                                  </div>
                                              </div>
                                              <div class="col-md-9">
                                                  <div class="form custom-control-inline" id="friday" style="display: none;">
                                                      <input type="text"  name="from_fri_hr" min="1" max="12" maxlength="2" style="width: 40px;margin: 0px;" placeholder="HH" value="{{ $entry->start_time_friday!="00:00:00" ? substr($entry->start_time_friday,0, 2):''}}"
                                                             onchange="leadingZeroshours(this,'from_fri_ampm')"
                                                             onclick="leadingZeroshours(this,'from_fri_ampm')"> &nbsp;&nbsp; : &nbsp;&nbsp;
                                                      <input type="text"   name="from_fri_min" min="1" max="59" style="width: 40px;" placeholder="MM" maxlength="2" value="{{ $entry->start_time_friday!="00:00:00" ? substr($entry->start_time_friday,3, 2):''}}"
                                                             onchange="leadingZeros(this)"
                                                             onclick="leadingZeros(this)"> &nbsp;&nbsp;
                                                      <input id="from_fri_ampm" name="from_fri_ampm" type="checkbox" checked data-toggle="toggle" data-on="AM" data-off="PM" data-onstyle="success" data-offstyle="danger">
                                                      &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; - &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                                                      <input type="text"  name="to_fri_hr" min="1" max="12" maxlength="2" style="width: 40px;margin: 0px;" placeholder="HH" value="{{ $entry->end_time_friday!="00:00:00" ? substr($entry->end_time_friday,0, 2):''}}"
                                                             onchange="leadingZeroshours(this,'to_fri_ampm')"
                                                             onclick="leadingZeroshours(this,'to_fri_ampm')"> &nbsp;&nbsp; : &nbsp;&nbsp;
                                                      <input type="text"   name="to_fri_min" min="1" max="59" style="width: 40px;" placeholder="MM" maxlength="2"  value="{{ $entry->end_time_friday!="00:00:00" ? substr($entry->end_time_friday,3, 2):''}}"
                                                             onchange="leadingZeros(this)"
                                                             onclick="leadingZeros(this)"> &nbsp;&nbsp;
                                                      <input id="to_fri_ampm" name="to_fri_ampm" type="checkbox" checked data-toggle="toggle" data-on="AM" data-off="PM" data-onstyle="success" data-offstyle="danger">
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="form custom-control-inline" style="width: 100%;margin-bottom: 10px;" >
                                              <div class="col-md-2">
                                                  <label>Saturday</label>
                                              </div>
                                              <div class="col-md-3" >
                                                  <div class="form-check form-check-inline">
                                                      <input class="form-check-input" type="radio" name="is_open_saturday"  value="1" {{ $entry->is_open_saturday ? "checked" : " "}}>
                                                      <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                  </div>
                                                  <div class="form-check form-check-inline">
                                                      <input class="form-check-input" type="radio" name="is_open_saturday"  value="0" {{ !$entry->is_open_saturday ? "checked" : " "}}>
                                                      <label class="form-check-label" for="inlineRadio2">No</label>
                                                  </div>
                                              </div>
                                              <div class="col-md-9">
                                                  <div class="form custom-control-inline" id="saturday" style="display: none;">
                                                      <input type="text"  name="from_sat_hr" min="1" max="12" maxlength="2" style="width: 40px;margin: 0px;" placeholder="HH" value="{{ $entry->start_time_saturday!="00:00:00" ? substr($entry->start_time_saturday,0, 2):''}}"
                                                             onchange="leadingZeroshours(this,'from_sat_ampm')"
                                                             onclick="leadingZeroshours(this,'from_sat_ampm')"> &nbsp;&nbsp; : &nbsp;&nbsp;
                                                      <input type="text"   name="from_sat_min" min="1" max="59" style="width: 40px;" placeholder="MM" maxlength="2" value="{{ $entry->start_time_saturday!="00:00:00" ? substr($entry->start_time_saturday,3, 2):''}}"
                                                             onchange="leadingZeros(this)"
                                                             onclick="leadingZeros(this)"> &nbsp;&nbsp;
                                                      <input id="from_sat_ampm" name="from_sat_ampm" type="checkbox" checked data-toggle="toggle" data-on="AM" data-off="PM" data-onstyle="success" data-offstyle="danger">
                                                      &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; - &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                                                      <input type="text"  name="to_sat_hr" min="1" max="12" maxlength="2" style="width: 40px;margin: 0px;" placeholder="HH" value="{{ $entry->end_time_saturday!="00:00:00" ? substr($entry->end_time_saturday,0, 2):''}}"
                                                             onchange="leadingZeroshours(this,'to_sat_ampm')"
                                                             onclick="leadingZeroshours(this,'to_sat_ampm')"> &nbsp;&nbsp; : &nbsp;&nbsp;
                                                      <input type="text"   name="to_sat_min" min="1" max="59" style="width: 40px;" placeholder="MM" maxlength="2" value="{{ $entry->end_time_saturday!="00:00:00" ? substr($entry->end_time_saturday,3, 2):''}}"
                                                             onchange="leadingZeros(this)"
                                                             onclick="leadingZeros(this)"> &nbsp;&nbsp;
                                                      <input id="to_sat_ampm" name="to_sat_ampm" type="checkbox" checked data-toggle="toggle" data-on="AM" data-off="PM" data-onstyle="success" data-offstyle="danger">
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-group row">
                                      <div class="col-md-3 text-center" style="margin: 0px;padding: 0px;">

                                          <i class='nav-icon la la-sticky-note' style="font-size:4em;"></i>
                                      </div>
                                      <div class="col-md-9" style="margin: 0px;padding: 0px;">
                                          <textarea class="form-control " id="notes" type="text" name="notes" placeholder="Enter Notes">{{$entry->notes}}</textarea>

                                      </div>

                                  </div>
                          </div>
                      </div>
                      </div>

                      <div class="d-none" id="parentLoadedAssets">{{ json_encode(Assets::loaded()) }}</div>
	                  @include('crud::inc.form_save_buttons')
              </form>
        </div>
	</div>
</div>
<!-- Async script executes immediately and must be after any DOM elements used in callback. -->
    <script src="{{url('packages/backpack/base/js/google_address.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_API_KEY')}}
        &libraries=places&callback=initialize" async defer></script>

@endsection

