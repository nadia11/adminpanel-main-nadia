@extends('dashboard')
@section('main_content')

<section class="content-wrapper">
    @if(Auth::user()->verified == 0)
    <div class="alert alert-warning alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success!</strong> Your Password has been sent to your email (<a href="mailto: {{ Auth::user()->email }}" target="_blank">{{ Auth::user()->email }}</a>). Please active & verify your email.
    </div>
    @endif

        <?php $ua_settings = DB::table('user_account_settings')->where('user_id', Auth::id())->first(); ?>

        <div class="row">
        <div class="col-md-4 animated fadeInLeft">
            <aside class="user-profile-image">
                <div class="about-me-content">
                    <div class="profile-image-wrap">
                        <img class="img-thumbnail" id="preview_image" src="<?php $user_photo = !empty( Auth::user()->user_photo ) ? upload_url("user-photo/". Auth::user()->user_photo ) : image_url('defaultAvatar.jpg'); echo $user_photo; ?>" alt="Photo of {{ Auth::user()->name }}">
                        <i id="loading" class="fa fa-spinner fa-spin fa-3x fa-fw" style="position:absolute; left:40%; top:40%; display:none;"></i>
                        <div style="position: absolute; top: 103%; left: 50%; transform: translate(-50%); width: 100%;">
                            <a href="javascript:changeProfile()" class="btn btn-info btn-sm"> <i class="fa fa-camera"></i> {{ Auth::user()->user_photo ? "Change Photo" : "Upload Photo" }}</a>
                            <a href="#" class="btn btn-danger btn-sm removeProfilePic {{ Auth::user()->user_photo ? "" : "disabled" }}" data-user_photo="{{ Auth::user()->user_photo }}"> <i class="fa fa-times"></i> Remove</a>
                            <input type="file" id="user_photo" name="user_photo" style="display: none;" />
                            <input type="hidden" id="user_photo_prev" name="user_photo_prev" value="{{ Auth::user()->user_photo }}" />
                        </div>
                    </div>
                    <h2 class="text-uppercase">{{ Auth::user()->name }}</h2>
                    <p>Kotha Smith is an enthusiastic and passionate Story Teller. He loves to do different home-made things and share to the world.</p>
                </div>
                <div class="social-share">
                    <ul>
                        <li class="facebook"><a href="https://facebook.com/{{ $ua_settings->facebook ?? "" }}" target="_blank" title="Facebook"><span class="fab fa-facebook-f"></span></a></li>
                        <li class="twitter"><a href="https://twitter.com/{{ $ua_settings->twitter ?? "" }}" target="_blank" title="Twitter"><span class="fab fa-twitter"></span></a></li>
                        <li class="linkedin"><a href="https://www.linkedin.com/{{ $ua_settings->linkedin ?? "" }}" target="_blank" title="Linkedin"><span class="fab fa-linkedin-in"></span></a></li>
                        <li class="instagram"><a href="https://www.instagram.com/{{ $ua_settings->instagram ?? "" }}" target="_blank" title="Instagram"><span class="fab fa-instagram"></span></a></li>
                        <li class="whatsapp"><a href="https://web.whatsapp.com/{{ $ua_settings->whatsapp ?? "" }}" target="_blank" title="Whatsapp"><span class="fab fa-whatsapp"></span></a></li>
                        <li class="skype"><a href="https://web.skype.com/{{ $ua_settings->skype ?? "" }}" target="_blank" title="Skype"><span class="fab fa-skype"></span></a></li>
                        <li class="youtube"><a href="https://www.youtube.com/{{ $ua_settings->youtube ?? "" }}" target="_blank" title="Youtube"><span class="fab fa-youtube"></span></a></li>
                    </ul>
                </div>
            </aside>
        </div>

        <div class="col-md-8 animated fadeInRight">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <i class="fa fa-user"></i>
                    <h2 class="box-title">Your Profile</h2>
                </div><!-- /.box-header -->

                <?php $user = DB::table('users')->join('user_roles', 'users.role_id', '=', 'user_roles.role_id')->select('users.*', 'user_roles.role_name')->where('id', Auth::id())->first(); ?>
                <div class="box-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 175px;">Full Name</th>
                            <td style="width: 5px;">:</td>
                            <td>{{ str_snack($user->name) }}</td>
                        </tr>
                        <tr>
                            <th>Date of Birth</th>
                            <td>:</td>
                            <td><?php if($user->dob > 0): echo "<strong>". htmlspecialchars( date('d/m/Y', strtotime($user->dob))) . "</strong>";  echo " (" . get_age( $user->dob ) . ")"; else: echo ''; endif; ?></td>
                        </tr>
                        <tr>
                            <th>Email Address</th>
                            <td>:</td>
                            <td><a href="mailto:{{ $user->email }}" target="_blank">{{ $user->email }} </a><?php $active = Auth::user()->verified >0 ? '<span class="badge badge-success" style="font-size: 12px; padding: 5px 10px; vertical-align: middle;">Verified</span>' : '<span class="badge badge-danger" style="font-size: 12px; padding: 5px 10px; vertical-align: middle;">Not Verified</span>'; echo $active; ?></td>
                        </tr>
                        <tr>
                            <th>Mobile No.</th>
                            <td>:</td>
                            <td><a href="tel:{{ $user->mobile }}">{{ $user->mobile }}</a></td>
                        </tr>
                        <tr>
                            <th>User Role</th>
                            <td>:</td>
                            <td>{{ str_snack($user->role_name) }}</td>
                        </tr>
                        <tr>
                            <th>Account Create Date</th>
                            <td>:</td>
                            <td><?php echo human_date( $user->created_at ) . " (" . htmlspecialchars( date('d/m/Y', strtotime($user->created_at))) . ")"; ?></td>
                        </tr>
                    </table>
                </div><!-- /.box-body -->

                <div class="box-footer">
                    <div class="col-md-12">
                        <a href="{{ url( '/user/update-profile/' ) }}" class="btn btn-warning btn-sm float-left"><i class="fa fa-edit"></i> Update Profile</a>
                        <a href="{{ url( '/user/change-password/' ) }}" class="btn btn-danger btn-sm float-right"><i class="fa fa-sync-alt"></i> Change Password</a>
                    </div>
                </div><!-- box-footer -->
            </div>
        </div><!-- /.row -->

        <div class="overlay" style="display: none;">
            <i class="fa fa-sync-alt fa-spin"></i>
        </div>
    </div><!-- ./box-warning -->
</section>

@endsection


@section('custom_js')
<script>
function changeProfile() {
    $('#user_photo').click();
}
$(document).ready(function(){
    $(document).on('change', '#user_photo', function () {
        var data = $(this);
        var form_data = new FormData();
        form_data.append('user_photo', data[0].files[0]);
        form_data.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: "{{ url('/user/upload-user-photo') }}",
            data: form_data,
            type: 'POST',
            contentType: false,
            processData: false,
            success: function (data) {
                if (data) {
                    $('#user_photo_prev').val( $.trim(data) );
                    $('#preview_image').attr('src', '{{ upload_url("user-photo")  }}/' + $.trim( data) );
                }else {
                    $('#preview_image').attr('src', "{{ image_url('defaultAvatar.jpg') }}");
                }
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
                $('#preview_image').attr('src', "{{ image_url('defaultAvatar.jpg') }}");
            },
            beforeSend: function( xhr ) { $('#loading').css('display', 'block'); },
            complete: function( jqXHR, textStatus ) { $('#loading').css('display', 'none'); },
        });
    });



    $(document).on('click', 'a.removeProfilePic', function () {
        var user_photo = $(this).data('user_photo');

        if (!confirm('Are you sure want to remove profile picture?')) { return; }

        $.ajax({
            url: "{{ url('/user/remove-user-photo') }}",
            method: 'POST',
            data: { _method: 'DELETE', id: '{{ Auth::id() }}', user_photo: user_photo },
            dataType: "json",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (data) {
                $('#preview_image').attr('src', "{{ image_url('defaultAvatar.jpg') }}");
                $('#user_photo').val('');
            },
            error: function (xhr, status, error) { alert(xhr.responseText); },
            beforeSend: function( xhr ) { $('#loading').css('display', 'block'); },
            complete: function( jqXHR, textStatus ) { $('#loading').css('display', 'none'); },
        });
    });
});
</script>
@endsection
