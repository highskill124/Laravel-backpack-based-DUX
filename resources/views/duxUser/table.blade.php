<div class="table-responsive">
    <table class="table" id="duxUsers-table">
        <thead>
        <tr>
            <th>Username</th>
        <th>Name</th>
        <th>Email</th>
        <th>Email Verified At</th>
        <th>Password</th>
        <th>Remember Token</th>
        <th>Business Address</th>
        <th>Business Address2</th>
        <th>Your Position</th>
        <th>City</th>
        <th>State Name</th>
        <th>Zip Code</th>
        <th>Country</th>
        <th>Phone</th>
        <th>Business Name</th>
        <th>Business Logo</th>
        <th>Is Active</th>
        <th>Profile Image</th>
        <th>Last Login</th>
        <th>Login Ip Address</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($duxUsers as $duxUsers)
            <tr>
                <td>{{ $duxUsers->username }}</td>
            <td>{{ $duxUsers->name }}</td>
            <td>{{ $duxUsers->email }}</td>
            <td>{{ $duxUsers->email_verified_at }}</td>
            <td>{{ $duxUsers->password }}</td>
            <td>{{ $duxUsers->remember_token }}</td>
            <td>{{ $duxUsers->business_address }}</td>
            <td>{{ $duxUsers->business_address2 }}</td>
            <td>{{ $duxUsers->your_position }}</td>
            <td>{{ $duxUsers->city }}</td>
            <td>{{ $duxUsers->state_name }}</td>
            <td>{{ $duxUsers->zip_code }}</td>
            <td>{{ $duxUsers->country }}</td>
            <td>{{ $duxUsers->phone }}</td>
            <td>{{ $duxUsers->business_name }}</td>
            <td>{{ $duxUsers->business_logo }}</td>
            <td>{{ $duxUsers->is_active }}</td>
            <td>{{ $duxUsers->profile_image }}</td>
            <td>{{ $duxUsers->last_login }}</td>
            <td>{{ $duxUsers->login_ip_address }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['duxUsers.destroy', $duxUsers->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('duxUsers.show', [$duxUsers->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('duxUsers.edit', [$duxUsers->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
