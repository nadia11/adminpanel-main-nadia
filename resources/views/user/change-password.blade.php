@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-primary animated fadeInRight col-6 offset-3 mt-5">
        <div class="box-header with-border">
            <i class="fa fa-wrench"></i>
            <h2 class="box-title">Change Password</h2>
            <div class="box-tools float-right">
                <button type="button" class="btn btn-box-tool" id="refresh" data-widget="Refresh" data-toggle="tooltip" title="Refresh"><i class="fa fa-sync-alt"></i></button>
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->

        <div class="box-body">
            <form action="{{ route('change-password') }}" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
            @csrf @method('put')

            @if(Session::pull('change_password'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <b><i class="fa fa-ok-sign"></i> Congratulation!</b> You have successfully changed your password.
                </div>
            @endif

                <div class="form-group">
                    <label for="old_password" class="control-label">Old Password</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fad fa-lock-open-alt" aria-hidden="true"></i></span>
                        </div>
                        <input type="password" name="old_password" id="old_password" placeholder="Enter Old Password" class="form-control" autocomplete="off" tabindex="1" required>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-default" id="show_profile_password" tabindex="-1"><i class="fa fa-eye" title="Show Password" aria-hidden="true"></i> <span class="text">Show Password</span></button>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="control-label">New Password</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-key" aria-hidden="true"></i></span>
                        </div>
                        <input type="password" name="password" id="password" placeholder="Enter New Password" class="form-control" autocomplete="off" tabindex="2" required>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-info" id="gen_password" tabindex="-1"><i class="fa fa-sync-alt fa-spin" title="Password Generator"  aria-hidden="true"></i></button>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirm_password" class="control-label">Confirm New Password</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-key"></i></span>
                        </div>
                        <input type="password" name="confirm_password" id="confirm_password" placeholder="Enter Confirm New Password" class="form-control" tabindex="3" required>
                    </div>
                </div>

            <div class="box-footer">
                <div class="col-sm-12 text-right">
                    <a class="btn btn-warning float-left" href="{{ URL::to('/user/user-profile') }}"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back to User Profile</a>
                    <button type="reset" id="reset" class="btn btn-danger"><i class="fa fa-times fa-lg" aria-hidden="true"></i> Clear Data</button>
                    <button type="submit" id="change_password" class="btn btn-success" tabindex="5"><i class="fa fa-plus" aria-hidden="true"></i> Change Password</button>
                </div>
            </div>
        </form>
    </div><!-- /.box-body -->

        <div class="overlay" style="display: none;">
            <i class="fa fa-sync-alt fa-spin"></i>
        </div>
    </div>
</section>

@include('user.user-manage-by-admin.generate-password-modal')
<!--load Password Generator Modal-->

@endsection
