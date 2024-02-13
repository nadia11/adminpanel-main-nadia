@extends('web_api')
@section('main_content')

<?php if(Session::get('user_id')){ $rider_info = DB::table('riders')->where('user_id', Session::get('user_id'))->first(); } ?>
@if(!$rider_info)
@include('pages.web-driver.notfound')
@else

<section class="content-wrapper">
    <div class="container-fluid" style="margin: 10px auto; padding: 15px 30px;">
        <div class="row">
            <div class="col-md-3">
                <aside class="profile-sidebar">
                    <div class="usericon">
                        <?php if( isset($rider_info->rider_photo)): ?><img src="{{ upload_url('rider-photo/') .$rider_info->rider_photo }}" alt="{{ $rider_info->rider_name }}" class="img-thumbnail profile-image-print" /><?php else: ?><img src="{{ image_url('defaultAvatar.jpg') }}" class="img-thumbnail profile-image-print" /> <?php endif; ?>
                    </div>
                    <div class="userinfo">
                        <h3></h3>
                        <h2>{{ $rider_info->rider_name ?? "" }}</h2>
                        <p class="rider_id">Rider ID No: {{ $rider_info->rider_id_number ?? "" }}</p>
                    </div>

                    <nav class="profile-navigation">
                        <ul class="">
                            <li class="profile-navigation-link {{ last(request()->segments()) == 'profile' ? 'active' : ''}}"><a href="{{ url('web/rider/profile') }}"><i class="fa fa-dashboard" aria-hidden="true"></i> My Profile</a></li>
                            <li class="profile-navigation-link {{ last(request()->segments()) == 'trip-history' ? 'active' : ''}}"><a href="{{ url('web/rider/trip-history') }}"><i class="fa fa-dashboard" aria-hidden="true"></i> Trip</a></li>
                            <li class="profile-navigation-link {{ last(request()->segments()) == 'scheduled-trips' ? 'active' : ''}}"><a href="{{ url('web/rider/scheduled-trips') }}"><i class="fa fa-dashboard" aria-hidden="true"></i> Scheduled Trips</a></li>
                            <li class="profile-navigation-link {{ last(request()->segments()) == 'my-wallet' ? 'active' : ''}}"><a href="{{ url('web/rider/my-wallet') }}"><i class="fa fa-dollar" aria-hidden="true"></i> My wallet</a></li>
                            <li class="profile-navigation-link {{ last(request()->segments()) == 'edit-profile' ? 'active' : ''}}"><a href="{{ url('web/rider/edit-profile') }}"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Profile</a></li>
                            <li class="profile-navigation-link {{ last(request()->segments()) == 'change-password' ? 'active' : ''}}"><a href="{{ url('web/rider/change-password') }}"><i class="fa fa-key" aria-hidden="true"></i> Change Password</a></li>
                            <li class="profile-navigation-link"><a href="{{ route('rider-logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
                        </ul>
                    </nav>
                </aside>
            </div>
            <div class="col-md-9">
                @include('pages.web-rider.'.$profile_content)
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

