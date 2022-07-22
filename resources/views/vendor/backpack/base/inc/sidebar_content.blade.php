<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('location') }}'><i class='nav-icon la la-map-marked'></i> Locations</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('promotion') }}'><i class='nav-icon la la-building'></i> Promotions</a></li>


<?php
if (\Auth::user()->hasRole('admin')) {?>
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> User Management</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i> <span>Users</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i class="nav-icon la la-id-badge"></i> <span>Roles</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i class="nav-icon la la-key"></i> <span>Permissions</span></a></li>
    </ul>
</li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('category') }}'><i class='nav-icon la la-cart-plus'></i> Categories</a></li>






<!-- <li class='nav-item'><a class='nav-link' href='{{ backpack_url('paypal-payment') }}'><i class='nav-icon la la-question'></i> Paypal payments</a></li> -->
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('products') }}'><i class='nav-icon la la-question'></i> Products</a></li>
<!-- <li class='nav-item'><a class='nav-link' href='{{ backpack_url('user-profile') }}'><i class='nav-icon la la-question'></i> User profiles</a></li> -->
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('billing-plan') }}'><i class='nav-icon la la-question'></i> Billing plans</a></li>
<?php
}?>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('subscriptions') }}'><i class='nav-icon la la-question'></i> User Subscriptions</a></li>