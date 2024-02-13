@extends('layouts.app')

@section('login_content')
<div class="wrapper divCenter">        
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">{{ __('Reset Password') }}</div>

            <div class="card-body">
                <strong>RETRIEVE YOUR PASSWORD HERE</strong>
                <p>Please enter your email address below. You will receive a link to reset your password.</p>
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">{{ __('Send Password Reset Link') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><!-- wrapper -->

@endsection