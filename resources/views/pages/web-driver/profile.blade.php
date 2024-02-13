@extends('web_api')
@section('main_content')

<?php if(Session::get('user_id')){ $driver_info = DB::table('drivers')->where('user_id', Session::get('user_id'))->first(); } ?>
@if(!$driver_info)
@include('pages.web-driver.notfound')
@else

<section class="content-wrapper">
    <div class="container-fluid" style="margin: 10px auto; padding: 15px 30px;">
        <div class="row">
            <div class="col-md-3">
                <aside class="profile-sidebar">
                    <div class="usericon">
                        <?php if( isset($driver_info->driver_photo)): ?><img src="{{ upload_url('driver-photo/') .$driver_info->driver_photo }}" alt="{{ $driver_info->driver_name }}" class="img-thumbnail profile-image-print" /><?php else: ?><img src="{{ image_url('defaultAvatar.jpg') }}" class="img-thumbnail profile-image-print" /> <?php endif; ?>
                    </div>
                    <div class="userinfo">
                        <h3></h3>
                        <h2>{{ $driver_info->driver_name ?? "" }}</h2>
                        <p class="driver_id">Driver ID No: {{ $driver_info->driver_id_number ?? "" }}</p>
                    </div>

                    <nav class="profile-navigation">
                        <ul class="">
                            <li class="profile-navigation-link {{ last(request()->segments()) == 'profile' ? 'active' : ''}}"><a href="{{ url('web/driver/profile') }}"><i class="fa fa-dashboard" aria-hidden="true"></i> My Profile</a></li>
                            <li class="profile-navigation-link {{ last(request()->segments()) == 'my-earnings' ? 'active' : ''}}"><a href="{{ url('web/driver/my-earnings') }}"><i class="fa fa-dollar" aria-hidden="true"></i> My Earnings</a></li>
                            <li class="profile-navigation-link {{ last(request()->segments()) == 'trip-history' ? 'active' : ''}}"><a href="{{ url('web/driver/trip-history') }}"><i class="fa fa-dashboard" aria-hidden="true"></i> Trip</a></li>
                            <li class="profile-navigation-link {{ last(request()->segments()) == 'upcoming-trips' ? 'active' : ''}}"><a href="{{ url('web/driver/upcoming-trips') }}"><i class="fa fa-road" aria-hidden="true"></i> Upcoming Trips</a></li>
                            <li class="profile-navigation-link {{ last(request()->segments()) == 'documents' ? 'active' : ''}}"><a href="#url('web/driver/documents') }}"><i class="fa fa-file-alt" aria-hidden="true"></i> Documents</a></li>
                            <li class="profile-navigation-link {{ last(request()->segments()) == 'tax-and-insurance' ? 'active' : ''}}"><a href="{{ url('web/driver/tax-and-insurance') }}"><i class="fa fa-id-card" aria-hidden="true"></i> Tax & Insurance</a></li>
                            <li class="profile-navigation-link {{ last(request()->segments()) == 'edit-profile' ? 'active' : ''}}"><a href="{{ url('web/driver/edit-profile') }}"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Profile</a></li>
                            <li class="profile-navigation-link {{ last(request()->segments()) == 'change-password' ? 'active' : ''}}"><a href="{{ url('web/driver/change-password') }}"><i class="fa fa-key" aria-hidden="true"></i> Change Password</a></li>
                            <li class="profile-navigation-link"><a href="{{ route('driver-logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
                        </ul>
                    </nav>
                </aside>
            </div>
            <div class="col-md-9">
                @include('pages.web-driver.'.$profile_content)
            </div><!-- Col-md-12 -->
        </div><!-- ./row -->
    </div><!-- /.box-body -->
</section>

@endif
@endsection


@section('custom_web_api_js')
<script type="text/javascript">
$(document).ready(function(){

}); //End of Document Ready
</script>
@endsection

