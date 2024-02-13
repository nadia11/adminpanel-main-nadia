<header class="main-header">
    <ul class="flex-container">
        <li>
            <a href="{{ URL::to('/dashboard') }}" class="logo" tabindex="-1"><!-- Logo -->
                <span class="logo-mini"><img src="{{ asset('/images/logo-mini.png') }}" alt="Apps Logo" /></span><!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-lg"><img src="{{ asset('/images/logo.png') }}" alt="Apps Logo" /></span><!-- logo for regular state and mobile devices -->
            </a>

        @if( settings( 'menu_position' ) !== 'header_menu' )
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button" title="Toggle Navigation" tabindex="-1">
                <i class="fa fa-bars"></i><span class="sr-only">Toggle navigation</span>
            </a>
        @endif
        </li>

        @include('includes.notification-icon')

        <li><a href="{{ url('map/driver-live-tracking') }}" class="btn btn-grid" style="margin-top: -10px;" tabindex="-1"><i class="fad fa-map-marker-alt text-danger"></i> Live Tracking</a></li>
        <li><a href="{{ url('driver/all-drivers') }}" class="btn btn-grid" style="margin-top: -10px;" tabindex="-1"><i class="fad fa-biking-mountain text-primary"></i> All Driver List</a></li>
        <li><a href="{{ url('driver/unapproved-drivers') }}" class="btn btn-grid" style="margin-top: -10px;" tabindex="-1"><i class="fad fa-user-slash text-danger"></i> Unapproved Drivers</a></li>
        <li><a href="{{ url('rider/all-riders') }}" class="btn btn-grid" style="margin-top: -10px;" tabindex="-1"><i class="fa fa-user-tie text-green"></i> All Rider List</a></li>

        <li><a href="#" class="btn btn-grid" style="margin-top: -10px;" id="todoModalShow" tabindex="-1"><i class="fa fa-tasks text-info"></i> Todo List</a></li>
        <li class="d-none">
            <form action="#" id="searchform" method="get" class="form-inline animated zoomIn" role="Search..." style="margin-top: 10px;">
                <div class="input-group">
                    <input type="search" class="form-control" id="navbar-search-input" placeholder="What are you looking for..." aria-label="Search">
                    <div class="input-group-append">
                        <button type="submit" name="search" id="search-btn" class="btn btn-info"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form><!-- search form -->
        </li>
        <li>
            <nav class="navbar navbar-expand-sm user-menu">
                <ul class="navbar-nav float-right" style="margin-right: 5px;">
                    <li class="nav-item dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?php $user_photo = !empty( Auth::user()->user_photo ) ? upload_url("user-photo/". Auth::user()->user_photo ) : get_gravatar( Auth::user()->email ); echo $user_photo; ?>" class="user-image" alt="Photo of {{ Auth::user()->name }}">
                            <span class="hidden-xs">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu icon-right animated flipInY" style="right: 0%; position: absolute; left: auto; width: 260px;">
                            <li>
                                <div class="user-box">
                                    <img src="<?php $user_photo = !empty( Auth::user()->user_photo ) ? upload_url("user-photo/". Auth::user()->user_photo ) : get_gravatar( Auth::user()->email ); echo $user_photo; ?>" alt="Photo of {{ Auth::user()->name }}">
                                    <div class="user-info">
                                        <h4>{{ Auth::user()->name }}</h4>
                                        <p>{{ Auth::user()->email }}</p>
                                        <p>{{ Auth::user()->designation }}</p>
                                        <p>{{ Auth::user()->mobile }}</p>
                                    </div>
                                </div>
                            </li>
                            @if(is_user_role('SuperAdmin'))
                                <li><a href="{{ URL::to('/admin/user-management') }}"><i class="fa fa-wrench text-info"></i> <span>User Management</span></a></li>
                                <li><a href="{{ url('settings/system-settings') }}" data-toggle="tooltip" data-placement="top" title="System Settings" class="setting-link"><i class="fa fa-cog text-info"></i> System Settings</a></li>
                            @endif
                            <li class="dropdown-divider"></li>
                            <li><a href="{{ URL::to('user/user-profile') }}"><i class="fa fa-user text-info"></i> My Profile</a></li>
                            <li><a href="{{ url('user/update-profile/' ) }}"><i class="fa fa-edit text-info"> </i> Update Profile</a></li>
                            <li>@if(Auth::user()) <a href="{{ URL::to( 'user/change-password') }}"><i class="fa fa-sync-alt text-info"> </i> Change Password</a> @endif</li>
                            <li class="dropdown-divider"></li>
                            <li><a href="{{ URL::to('user/user-account-settings') }}"><i class="fa fa-users-cog text-info"></i> Account Settings</a></li>
                            <li class="dropdown-divider"></li>
                            <li><a href="{{ url('lockscreen') }}"><i class="fa fa-eye-slash text-info"> </i> {{ __('Lock Screen') }}</a></li>
                            <li><a href="{{ url('logout') }}"><i class="fa fa-sign-out-alt text-danger"> </i> {{ __('Logout') }}</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </li>
    </ul>
    @include('layouts.breadcrumb')
</header>
