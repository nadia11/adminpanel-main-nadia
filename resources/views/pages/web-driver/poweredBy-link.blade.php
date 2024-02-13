@php $second_segment = Request::segment(2) @endphp
@php $last_segment = last(request()->segments()) @endphp

@if($last_segment == 'login-form')
<div class="powered">Don't have an account<a class="btn" href="{{ $second_segment == "rider" ? url("web/rider/registration-form") : url("web/driver/registration-form") }}">Sign Up</a></div>
@else
<div class="powered">Already have an account<a class="btn" href="{{ $second_segment == "rider" ? url("web/rider/login-form") : url("web/driver/login-form") }}">Sign in</a></div>
@endif