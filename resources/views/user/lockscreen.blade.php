@extends('layouts.app')
@section('login_content')

<div class="wrapper divCenter">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header text-center">{{ __('Lock Screen') }}</div>
            <div class="card-body">

                <form id="form-signin" action="{{ url('lockscreen') }}" method="post" class="form-horizontal">
                @csrf

                @include('includes.flash-message') <!-- Flash Message -->
                    <div class="form-group">
                        <img src="<?php $user_photo = !empty( Auth::user()->photo ) ? upload_url("user-photo/". Auth::user()->user_photo ) : get_gravatar( Auth::user()->email ); echo $user_photo; ?>" class="lockscreen-image img-fluid" alt="Photo of {{ Auth::user()->name }}">
                        <h4 class="text-center">{{ Auth::user()->name }}</h4>
                    </div>

                    <div class="form-group">
                        <input type="hidden" name="username" value="{{ Auth::user()->name }}">
                        <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-key"></i></div>
                            </div>
                            <input type="password" name="password" id="user_password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="User Password" />
                            @if ($errors->has('password'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <label style="margin-top: 10px;">Enter your password to retrieve your session</label>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-success btn-lg btn-block" type="submit" id="sign-in"><i class="fa fa-unlock"></i> Unlock </button>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                           <input type="checkbox" name="remember" id="remember" class="custom-control-input" {{ old('remember') ? 'checked' : '' }}>
                           <label class="custom-control-label" for="remember">{{ __('Remember Me') }}</label>
                            <a href="{{ route('logout') }}" class="btn btn-link btn-sm float-right">{{ __('Switch account') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><!-- wrapper -->
@endsection
