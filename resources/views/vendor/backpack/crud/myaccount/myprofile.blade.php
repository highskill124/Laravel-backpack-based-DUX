@extends(backpack_view('blank'))

@section('content')
<div class="account-dash pt-4">
    <div class="accdash-title text-center mb-4">
        <h1 class="h3">My Account</h1>
    </div>
    <div class="accdash-rows">
        <div class="row justify-content-between">
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <a class="acc-link" href="{{ url('admin/edit-account-profile/'.backpack_user()->id) }}">
                            <i><img class="img-fluid" src="{{ url('image/usermap.png') }}"
                                    alt="Edit My Business / User Info"></i>
                            <span>Edit My Business / User Info</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <a class="acc-link" href="{{ url('admin/password-change/'.backpack_user()->id) }}">
                            <i><img class="img-fluid" src="{{ url('image/password.png') }}" alt="Change password"></i>
                            <span>Change password</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <a class="acc-link" href="javascript:void(0);">
                            <i><img class="img-fluid" src="{{ url('image/paymeny.png') }}"
                                    alt="View my payment history"></i>
                            <span>View my payment history</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <a class="acc-link" href="javascript:void(0);">
                            <i><img class="img-fluid" src="{{ url('image/addaddress.png') }}"
                                    alt="Change my biling address"></i>
                            <span>Change my biling address</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

