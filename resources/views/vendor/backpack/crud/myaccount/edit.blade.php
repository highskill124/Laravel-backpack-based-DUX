@extends(backpack_view('blank'))

@section('content')
<div class="row">
  <div class="col-lg-12">
      <div class="register-box" id="register-frm">
          <div class="card mb-lg-0">
              <div class="card-body">
                  <div class="regbox-center">
                      <form id="regi-frm" class="mb-0" role="form" method="POST" action="{{ url('admin/edit-account-profile/'.backpack_user()->id) }}" onsubmit="return profileValidation();">
                          <input type="hidden" name="userid" value="<?= backpack_user()->id;?>">
                          {!! csrf_field() !!}
                          <div class="card-top d-flex mb-4">
                            <div class="ct-f ct-item">
                              <a class="btn btn-light" href="{{url('admin/account-profile')}}"> <i class="la la-arrow-left"></i> Back</a>
                            </div>
                            <div class="ct-s ct-item">
                            <h5 class="mb-0">Edit My Profile</h5>
                            </div>
                            <div class="ct-t ct-item">
                              <button class="btn btn-primary">Update profile</button>
                            </div>
                        </div>
                        @if(!empty($message))
                        <div class="alert alert-success alert-block">

                            <button type="button" class="close" data-dismiss="alert">×</button>

                            <strong>{{ $message }}</strong>

                        </div>
                        @endif

                          <div class="row">
                              <div class="col-md-6">
                                  <label>Full Name</label>
                                  <div class="form-group">
                                      <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Full name" value="<?= $userdata['name'];?>">
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                  <label>Phone Number</label>
                                  <div class="form-group">
                                      <input type="text" class="form-control" placeholder="Phone Number" name="phone" id="phone" value="<?= $userdata['phone'];?>">
                                  </div>
                              </div>
                              <div class="col-md-6">
                                <label>Your Position (Owner, Manager etc.)</label>
                                  <div class="form-group">
                                      <input type="text" class="form-control" placeholder="Company Position" name="position" id="position" value="<?= $userdata['your_position'];?>">
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                <label>Business Name</label>
                                  <div class="form-group">
                                      <input type="text" class="form-control" placeholder="Business Name" name="businessname" id="businessname" value="<?= $userdata['business_name'];?>">
                                  </div>
                              </div>
                              <div class="col-md-6">
                                <label>Business / Organization Street Address</label>
                                  <div class="form-group">
                                      <input type="text" class="form-control map-input" placeholder="Business Address" name="businessaddress" id="businessaddress"  value="<?= $userdata['business_address'];?>">
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                <label>City</label>
                                  <div class="form-group">
                                      <input type="text" class="form-control" placeholder="City" name="city" id="city" value="<?= $userdata['city'];?>">
                                  </div>
                              </div>
                              <div class="col-md-6">
                                <label>Province/State</label>
                                  <div class="form-group">
                                      <input type="text" class="form-control" placeholder="Province / State" name="state" id="state" value="<?= $userdata['state_name'];?>">
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                <label>Country</label>
                                  <div class="form-group">
                                      <input type="text" class="form-control" placeholder="Country" name="country" id="country" value="<?= $userdata['country'];?>">
                                  </div>
                              </div>
                              <div class="col-md-6">
                                <label>Postal Code / Zip</label>
                                  <div class="form-group">
                                      <input type="text" class="form-control" placeholder="Postal Code" name="postalcode" id="postalcode" value="<?= $userdata['zip_code'];?>">
                                  </div>
                              </div>
                          </div>
                          <div class="form-group row">
                              <div class="col-md-3 text-center" style="margin: 0px;padding: 0px;" >
                              </div>
                              <div style="width:35%;margin-left: 0px;padding-left: 0px;" >
                                  <input class="form-control" id="businessaddress-latitude" type="text"  name="latitude" placeholder="Enter Latitude" value="{{$entry->latitude}}" />
                              </div>
                              <div  style="width:35%;margin-left: 5%;margin-right: 0px;padding-right: 0px;" >
                                  <input class="form-control" id="businessaddress-longitude" type="text" name="longitude" placeholder="Enter Longitude" value="{{$entry->longitude}}" />
                              </div>
                          </div>
                          <div class="form-group row" style="padding-top: 20px;">
                              <div class="col-md-3 text-center" style="margin: 0px;padding: 0px;">

                                  <i class="fas fa-regular fa-location-dot" style="font-size:4em;"></i>
                              </div>
                              <div class="row" style="margin: 0px; padding: 0px; width: 75%; height: 400px; display: none" id="address-map">


                              </div>

                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                <label>Bussiness Address 2</label>
                                  <div class="form-group">
                                      <input type="text" class="form-control" placeholder="Address 2" name="businessaddress2" id="businessaddress2" value="<?= $userdata['business_address2'];?>">
                                  </div>
                              </div>
                          </div>

                         <!--  <div class="form-group text-center">
                              <button type="submit" class="btn btn-warning">Update Profile</button>
                          </div> -->
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
<script src="{{url('packages/backpack/base/js/google_address.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_API_KEY')}}
    &libraries=places&callback=initialize" async defer></script>
@endsection

