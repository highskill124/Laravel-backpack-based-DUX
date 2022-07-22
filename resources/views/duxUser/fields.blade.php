<!-- Username Field -->
<div class="form-group col-sm-6">
    {!! Form::label('username', 'Username:') !!}
    {!! Form::text('username', null, ['class' => 'form-control','maxlength' => 30,'maxlength' => 30]) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::email('email', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Email Verified At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email_verified_at', 'Email Verified At:') !!}
    {!! Form::text('email_verified_at', null, ['class' => 'form-control','id'=>'email_verified_at']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#email_verified_at').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password', 'Password:') !!}
    {!! Form::password('password', ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Remember Token Field -->
<div class="form-group col-sm-6">
    {!! Form::label('remember_token', 'Remember Token:') !!}
    {!! Form::text('remember_token', null, ['class' => 'form-control','maxlength' => 100,'maxlength' => 100]) !!}
</div>

<!-- Business Address Field -->
<div class="form-group col-sm-6">
    {!! Form::label('business_address', 'Business Address:') !!}
    {!! Form::text('business_address', null, ['class' => 'form-control','maxlength' => 200,'maxlength' => 200]) !!}
</div>

<!-- Business Address2 Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('business_address2', 'Business Address2:') !!}
    {!! Form::textarea('business_address2', null, ['class' => 'form-control']) !!}
</div>

<!-- Your Position Field -->
<div class="form-group col-sm-6">
    {!! Form::label('your_position', 'Your Position:') !!}
    {!! Form::text('your_position', null, ['class' => 'form-control','maxlength' => 200,'maxlength' => 200]) !!}
</div>

<!-- City Field -->
<div class="form-group col-sm-6">
    {!! Form::label('city', 'City:') !!}
    {!! Form::text('city', null, ['class' => 'form-control','maxlength' => 200,'maxlength' => 200]) !!}
</div>

<!-- State Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('state_name', 'State Name:') !!}
    {!! Form::text('state_name', null, ['class' => 'form-control','maxlength' => 200,'maxlength' => 200]) !!}
</div>

<!-- Zip Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('zip_code', 'Zip Code:') !!}
    {!! Form::text('zip_code', null, ['class' => 'form-control','maxlength' => 200,'maxlength' => 200]) !!}
</div>

<!-- Country Field -->
<div class="form-group col-sm-6">
    {!! Form::label('country', 'Country:') !!}
    {!! Form::text('country', null, ['class' => 'form-control','maxlength' => 200,'maxlength' => 200]) !!}
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone', 'Phone:') !!}
    {!! Form::text('phone', null, ['class' => 'form-control','maxlength' => 200,'maxlength' => 200]) !!}
</div>

<!-- Business Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('business_name', 'Business Name:') !!}
    {!! Form::text('business_name', null, ['class' => 'form-control','maxlength' => 200,'maxlength' => 200]) !!}
</div>

<!-- Business Logo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('business_logo', 'Business Logo:') !!}
    {!! Form::text('business_logo', null, ['class' => 'form-control','maxlength' => 200,'maxlength' => 200]) !!}
</div>

<!-- Is Active Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('is_active', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('is_active', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('is_active', 'Is Active', ['class' => 'form-check-label']) !!}
    </div>
</div>


<!-- Profile Image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('profile_image', 'Profile Image:') !!}
    {!! Form::text('profile_image', null, ['class' => 'form-control','maxlength' => 200,'maxlength' => 200]) !!}
</div>

<!-- Last Login Field -->
<div class="form-group col-sm-6">
    {!! Form::label('last_login', 'Last Login:') !!}
    {!! Form::text('last_login', null, ['class' => 'form-control','id'=>'last_login']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#last_login').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Login Ip Address Field -->
<div class="form-group col-sm-6">
    {!! Form::label('login_ip_address', 'Login Ip Address:') !!}
    {!! Form::text('login_ip_address', null, ['class' => 'form-control','maxlength' => 20,'maxlength' => 20]) !!}
</div>