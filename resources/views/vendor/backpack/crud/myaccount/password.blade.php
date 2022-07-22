@extends(backpack_view('blank'))

@section('content')
<div class="row">
  <div class="col-lg-12">
      <div class="register-box" id="register-frm">
          <div class="card mb-lg-0">
              <div class="card-body">
                  <div class="regbox-center">
                      <form id="regi-frm" class="mb-0" role="form" method="POST" action="{{ url('admin/password-change/'.backpack_user()->id) }}" onsubmit="return validationPassword()">
                          <input type="hidden" name="userid" value="<?= backpack_user()->id;?>">
                          {!! csrf_field() !!}
                          <div class="card-top d-flex mb-4">
                            <div class="ct-f ct-item">
                              <a class="btn btn-light" href="{{url('admin/account-profile')}}"> <i class="la la-arrow-left"></i> Back</a>
                            </div>
                            <div class="ct-s ct-item">
                            <h5 class="mb-0">Change Password</h5>
                            </div>
                            <div class="ct-t ct-item">
                              <button class="btn btn-primary">Change Password</button>
                            </div>
                        </div>
                        @if ($flag == 'success')
                          <div class="alert alert-success alert-block">
                              <button type="button" class="close" data-dismiss="alert">×</button> 
                              <strong>{{ $message }}</strong>
                          </div>
                          @elseif($flag =='error')
                          <div class="alert alert-danger alert-block">
                              <button type="button" class="close" data-dismiss="alert">×</button>    
                              <strong>{{ $message }}</strong>
                          </div>
                        @endif
                          <div class="row">
                              <div class="col-md-6">
                                  <label>Current Password</label>
                                  <div class="form-group">
                                      <input type="password" class="form-control" id="currentpassword" name="currentpassword" placeholder="Current Password">
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                  <label>New Password</label>
                                  <div class="form-group">
                                      <input type="password" class="form-control" id="password" name="password" placeholder="New Password" >
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                  <label>Confrim Password</label>
                                  <div class="form-group">
                                      <input type="password" class="form-control" id="confrimpassword" name="confrimpassword" placeholder="Confrim Password" onblur="checkPassword()">
                                  </div>
                              </div>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
@endsection

