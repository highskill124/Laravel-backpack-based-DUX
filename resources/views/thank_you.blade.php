@extends(backpack_view('layouts.plain'))

@section('content')
    <div class="row">
        <div class="col-12">
            <h3 class="text-center pt-3 pb-4 mb-0"> <img class="img-fluid" src="{{url('packages/dux/duxtheme/img/dux_login_logo.png')}}" width="260" height=""/></h3>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="text-center success-msg">
                <span>Your payment successfully completed</span>
                <br><a href="{{url('admin/dashboard')}}">Go to dashboard</a>
            </div>
        </div>
    </div>
@endsection