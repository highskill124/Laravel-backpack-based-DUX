@extends(backpack_view('layouts.plain'))

@section('content')
    <div class="row">
        <div class="col-12">
            <h3 class="text-right pt-3 pb-4 mb-0"> <img class="img-fluid" src="{{url('packages/dux/duxtheme/img/dux_login_logo.png')}}" width="260" height=""/></h3>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-7">
            <div class="register-box" id="register-frm">
                <div class="card mb-lg-0">
                    <div class="card-header ch-bg">
                        <h5 class="mb-0">Account / Contact Information</h5>
                    </div>
                    <div class="card-body">
                        <?php
                        if(Session::has('error')){?>
                            <div class="alert alert-danger">
                                <?= Session::get('error');?>     
                            </div>
                        <?php
                        }?>
                        <div class="regbox-center">
                            <form id="regi-frm" class="mb-0" role="form" method="POST" action="#">
                                {!! csrf_field() !!}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Full name" onblur="blurValidation(1)">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="username" name="username" placeholder="User Name" onblur="blurValidation(1)" onkeydown="checkUsername(this.value)" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Phone Number" name="phone" id="phone" onblur="blurValidation(1)">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="email" class="form-control" placeholder="Email" name="email" id="email" onblur="checkUser(this.value)" onkeydown="checkUser(this.value)" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="password" class="form-control" placeholder="Password" name="password" id="password" onblur="blurValidation(1)">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="password" class="form-control" placeholder="Confrim Password" name="cpassword" id="cpassword" onblur="blurValidation(1)">
                                        </div>
                                    </div>
                                </div>
                                <h5 class="mt-2">Business Information</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Business Name" name="businessname" id="businessname" onblur="blurValidation(1)">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="City" name="city" id="city" onblur="blurValidation(1)">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Company Position" name="position" id="position" onblur="blurValidation(1)">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Country" name="country" id="country" onblur="blurValidation(1)">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Business Address" name="businessaddress" id="businessaddress" onblur="blurValidation(1)">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Postal Code" name="postalcode" id="postalcode" onblur="blurValidation(1)">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Address 2" name="businessaddress2" id="businessaddress2">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <button type="button" onclick="createLogin(1)" class="btn btn-warning">Create Account</button>
                                </div>
                                <div style="display:none;" class="alert alert-primary success" role="alert">
                                    Successfully registered now you can payment button is enabled
                                </div>
                                <input type="hidden" name="clickregister" id="clickregister" value="0">
                                <div class="form-group text-center mb-0">
                                    <a href="javascript:void(0);" onclick="clickLogin(1)">Already have an account?</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div style="display:none;" id="login-frm" class="login-box">
                <div class="card mb-lg-0">
                    <div class="card-header text-center ch-bg">
                        <h5 class="mb-0">Already have an account?</h5>
                    </div>
                    <div class="card-body pt-lg-5 pt-md-4">
                        <div class="logbox-center">
                            <div class="alert alert-danger error-login" role="alert" style="display:none;">
                                Username or password is wrong
                            </div>
                            <div class="alert alert-success success-login" role="alert" style="display:none;">
                                You have successfully logged in
                            </div>
                            <form role="form" method="POST" action="#">
                                {!! csrf_field() !!}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="email" class="form-control" name="email" placeholder="Email" id="emaillog">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="password" class="form-control" name="password" id="passwordlog" placeholder="Password">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <button type="button" class="btn btn-primary" onclick="loginUser()">
                                        {{ trans('backpack::base.login') }}
                                    </button>
                                </div>
                                <div class="form-group mb-0 text-center">
                                    <a href="javascript:void(0);" onclick="clickLogin(2)">Don't have account?</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div style="display:none;" id="username-detail" class="login-box">
                <div class="card mb-lg-0">
                    <div class="card-header text-center ch-bg">
                        <h5 class="mb-0">Welcome to Dux!</h5>
                    </div>
                    <div class="card-body pt-lg-5 pt-md-4">
                        <div class="logbox-center">
                            <h5 class="username success-msg">Username logged in</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div style="display:none;" id="register-detail" class="login-box">
                <div class="card mb-lg-0">
                    <div class="card-header text-center ch-bg">
                        <h5 class="mb-0">Welcome to Dux!</h5>
                    </div>
                    <div class="card-body pt-lg-5 pt-md-4">
                        <div class="logbox-center">
                            <h5 class="success-msg">You have successfully created an account</h5>
                        </div>
                        <div class="logbox-center">
                            <ul style="list-style-type: none;">
                                <li><b>Username:</b> <span id="usernametxt"></span></li>
                                <li><b>Full Name:</b> <span id="fullnametxt"></span></li>
                                <li><b>Email:</b> <span id="emailtxt"></span></li>
                                <li><b>Phone:</b> <span id="phonetxt"></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if(!empty($subscription)){
            $tax = (($subscription['price']*env('BILLING_TAX_PER'))/100);
            ?>
            <div class="col-lg-5">
                <div class="payment-box">
                    <div class="card mb-lg-0">
                        <div class="card-header ch-bg">
                            <div class="position-relative cp-title text-center"><label><b>Payment</b></label>   <span>Currency CAD</span></div>
                        </div>
                        <div class="card-body">
                            <form class="mb-0" role="form" method="POST" action="{{ route('backpack.paypal.payment') }}">
                                <input type="hidden" name="amount" id="amount" value="1">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <input type="hidden" name="plan_url" value="{{url('admin/create-subscription').'/'.Request::segment(2).Request::segment(3)}}">   
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <th><span><?= $subscription['title'];?> <?= $subscription['description'];?></span>  <?= ucwords($subscription['frequency_interval_unit']).'ly';?> subscription</th>
                                            <td>$<?= number_format($subscription['price'],2);?></td>
                                        </tr>
                                        <tr>
                                            <th>Tax:</th>
                                            <td>$<?= number_format($tax,2);?></td>
                                        </tr>
                                        <tr>
                                            <th><b>Total:</b></th>
                                            <td><b>$<?= number_format(($subscription['price']+$tax),2);?></b></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <?php
                                if(!empty($subscription)){?>
                                    <div class="btn-checkout form-group mt-lg-0 mt-5 text-center" style="display:none;">
                                        <a id="pay-btn" disabled="disabled" class="btn btn-warning btn-disabled" href="javascript:void(0);">Checkout With Paypal</a>
                                    </div>
                                <?php
                                }?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }?>
    </div>
@endsection