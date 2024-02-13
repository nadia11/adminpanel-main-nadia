@extends('layouts.app')
@section('login_content')

<div class="container" style="margin: 3% auto; min-width: 350px; max-width: 50%;">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('update-profile-save') }}" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
            @csrf

                <div class="card">
                    <div class="card-header bg-warning text-white">
                        <h1 class="card-title text-center text-uppercase">Update User Profile</h1>
                    </div>

                    <div class="card-body" style="padding: 5px 50px;">
                        <div class="form-group">
                            <label for="name" class="control-label" >User Name</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                                </div>
                                <input type="text" name="name" id="name" placeholder="User Name" value="{{ $user_data->name }}" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="mobile" class="control-label" >User Mobile No.</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                </div>
                                <input type="tel" name="mobile" id="mobile" placeholder="User Mobile No" value="{{ $user_data->mobile }}" class="form-control" max="13">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="dob" class="control-label">Date of Birth</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                                <input type="datetime" name="dob" id="dob" placeholder="Date of Birth" class="form-control" value="{{ date_format(date_create( $user_data->dob ),"d/m/Y") }}" required="required" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="control-label">E-Mail</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                </div>
                                <input type="email" name="email" id="email" placeholder="example@domain.com" class="form-control" value="{{ $user_data->email }}" required="required" />
                            </div>
                        </div>

                        <div class="form-group has-feedback">
                            <label for="photo" class="col-form-label">Upload User Photo</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fa fa-upload" aria-hidden="true"></i></div>
                                </div>
                                <div class="custom-file">
                                    <input type="file" name="user_photo" id="user_photo" class="custom-file-input">
                                    <label class="custom-file-label" for="user_photo">{{ $user_data->user_photo ?: 'Choose User Photo'}}</label>
                                </div>
                            </div>
                            <img src="{{ $user_data->user_photo ? upload_url('user-photo/'. $user_data->user_photo) : ''}}" width="100" />
                        </div>

                        <div class="alert alert-success" role="alert" id="success_message">Success <i class="glyphicon glyphicon-thumbs-up"></i> Thanks for contacting us, we will get back to you shortly.</div>
                    </div><!-- ./card-body -->

                    <div class="card-footer text-center">
                        <input type="hidden" name="id" value="{{ $user_data->id }}" />
                        <input type="hidden" name="user_photo_prev" value="{{ $user_data->user_photo }}" />
                        <button type="submit" class="btn btn-success" style="width: 65%; background: #202F3E; border: 1px solid #202F3E; margin: 15px auto;">Update Account</button>
                        <div>Already have an Account? <a href="{{ URL::to('login') }}" class="btn btn-link"><i class="fa fa-lock"></i> Login</a></div>
                    </div><!-- ./card-footer -->
                </div><!-- ./card-wrapper -->
            </form>
        </div>
    </div><!-- ./row -->
</div><!-- ./container -->

@endsection
