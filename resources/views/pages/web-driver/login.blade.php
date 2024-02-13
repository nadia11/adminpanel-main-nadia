@extends('web_api')
@section('main_content')

<style>
    * { box-sizing:border-box; }
    h1 {text-align:center; padding: 20px 10px; text-transform: uppercase; font-weight: 400; }
    form { padding: 20px; background: #fff;}
    .powered{ padding: 10px 10px 0; margin-top: 0px; line-height: 20px; border-top: 1px solid #ccc; }
    .powered a {color: #EF0C14; text-decoration: none; font-weight: bold;}

    .group {position: relative;  margin-bottom: 25px; }

    input{font-size: 18px;  padding: 10px 10px 10px 5px; -webkit-appearance: none; display: block;  background: transparent;  color: #03a9f4;  width: 100%;  border: none;  border-radius: 0;  border-bottom: 1px solid #ddd;}

    input:focus{outline: none; }

    /* Label */
    label {display: none; color: #999; font-weight: normal; position: absolute; pointer-events: none; left: 5px; top: 10px; -webkit-transition:all 0.2s ease; transition: all 0.2s ease;}

    /* active */
    input:focus ~ label, input.used ~ label {top: -20px; -webkit-transform: scale(.9); transform: scale(.9); left: -2px; color: #4a89dc; display: block; }

    /* Underline */
    .bar { position: relative; display: block; width: 100%;}
    .bar:before, .bar:after {content: ''; height: 2px; width: 0;  bottom: 1px; position: absolute; background: #4a89dc; -webkit-transition:all 0.2s ease; transition: all 0.2s ease;}
    .bar:before { left: 50%; }
    .bar:after { right: 50%; }

    /* active */
    input:focus ~ .bar:before, input:focus ~ .bar:after { width: 50%; }

    /* Highlight */
    .highlight { position: absolute; height: 60%; width: 100px; top: 25%; left: 0; pointer-events: none; opacity: 0.5; }

    /* active */
    input:focus ~ .highlight {-webkit-animation: inputHighlighter 0.3s ease; animation: inputHighlighter 0.3s ease;}

    /* Animations */
    @-webkit-keyframes inputHighlighter {
        from { background: #4a89dc; }
        to  { width: 0; background: transparent; }
    }

    @keyframes inputHighlighter {
        from { background: #4a89dc; }
        to  { width: 0; background: transparent; }
    }
    .buttonui { position: relative; padding: 8px 45px; line-height: 30px; overflow: hidden; border: 1px solid transparent; outline: none; border-radius: 5px; box-shadow: 0 1px 3px rgba(0, 0, 0, .3); background-color: #EF0C14; color: #ecf0f1; transition: all 0.3s ease; cursor: pointer; margin-bottom: 20px; }
    .buttonui:before { content: ""; position: absolute; top: 50%; left: 50%; display: block; width: 0; padding-top: 0; border-radius: 100%; background-color: rgba(236, 240, 241, .3); -webkit-transform: translate(-50%, -50%); -moz-transform: translate(-50%, -50%); -ms-transform: translate(-50%, -50%); -o-transform: translate(-50%, -50%); transform: translate(-50%, -50%);}
    .buttonui span{ padding: 12px 24px; font-size:16px;}
    .buttonui:hover{ background-color: #fff; border: 1px solid #EF0C14; color: #EF0C14; }
    .btn-login-type{ width: 100%; position: absolute; left: 0; bottom: 100%; }
    .btn-login-type a{
        background-color: #e9e9e9;
        color: #000;
        position: relative;
        border-radius: 3px;
        /*margin: 40px auto 20px;*/
        padding: 10px 5px;
        font-size: 14px;
    }
    .btn-login-type a.active{
        color: #fff;
        background-color: #d81517 !important;
        border-bottom: none;
        box-shadow: none;
    }
    .btn-login-type a.active:after {
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-top: 5px solid #d81416;
        bottom: -5px;
        content: "";
        left: 50%;
        margin-left: -2.5px;
        position: absolute;
    }
    .divCenter { width: 70%; margin: 0 auto; margin-top: 5%; text-align: center; color: #fff; box-shadow: 2px 0 5px -1px rgba(0,0,0,.30); }
    .brand { background: url("{{ asset('/login-assets/images/login-form-bg.png') }}") no-repeat center center/cover; width: 60%; border-radius: .5em 0 0 .5em; padding: 0 30px 130px; display: flex; justify-content: center; align-items: center; text-align: center; }
    .app-link { width: 70%; position: absolute; bottom: 2%; left: 0; right: 0; margin: 0 auto;}
    .app-link ul{ display: flex; flex-flow: row nowrap; justify-content: center; color: #fff; list-style-type: none; align-items: center; padding: 0; }
    .app-link ul li:last-child{ margin-left: 15px; }
    .app-link img{ width: 150px; height: auto; }
    .brand img.login-logo{ width: 60% !important; }
    .loginForm { background: #fff; color: #31455A; width: 40%; text-align: center; border-radius: 0 0 .5em 0; padding: 50px 15px 10px; position: relative; }
    /* Ripples container */

    .ripples {  position: absolute;  top: 0;  left: 0;  width: 100%;  height: 100%;  overflow: hidden;  background: transparent;}
    .ripplesCircle {  position: absolute;  top: 50%;  left: 50%;  -webkit-transform: translate(-50%, -50%); transform: translate(-50%, -50%); opacity: 0;  width: 0;  height: 0;  border-radius: 50%;  background: rgba(255, 255, 255, 0.25);}
    .ripples.is-active .ripplesCircle {  -webkit-animation: ripples .4s ease-in; animation: ripples .4s ease-in;}
    .remember-wrap{ overflow: hidden; margin: -20px auto 20px; position: relative;}
    .remember-wrap label{ font-size: 14px; float: left; margin-left: 21px; position: static; display: block; color: #333; pointer-events: auto; cursor: pointer; }
    .remember-wrap a{ float: right; }
    /* Ripples animation */

    @-webkit-keyframes ripples {
        0% { opacity: 0; }
        25% { opacity: 1; }
        100% { width: 200%; padding-bottom: 200%; opacity: 0; }
    }
    @keyframes ripples {
        0% { opacity: 0; }
        25% { opacity: 1; }
        100% { width: 200%; padding-bottom: 200%; opacity: 0; }
    }
    @media only screen and (min-width : 480px) and (max-width: 767px) {
        .loginForm{ width: 65%; max-width: 350px; }
    }
    @media screen and (max-width: 479px){
        .loginForm{ width: 65%; min-width: 250px; }
        .remember-wrap{ display: none; }
        .loginForm h1{ padding: 10px; font-size: 2em;}
        img.login-logo {margin: 0 auto 5px !important;}
        form{padding: 15px 20px 5px;}
        .group { margin-bottom: 15px; }
    }
    img.login-logo{ width: 100%; margin: 0 auto 30px; padding: 0 20px; max-height: 120px; }
    input[type=checkbox]{ -webkit-appearance: checkbox; pointer-events: auto; float: left; width: auto; position: absolute; left: 0; top: 20%; }
    .loginForm input[type='password']{ border-bottom: 1px solid #0098d8; font-size: 20px; color: #369; }
    .loginForm input::placeholder { color: #0098d8!important; }
    .loginForm input[type=text], input[type=password]{ border: 1px solid #ccc; border-radius: 5px; padding-left: 10px }

    /*Remove Autoculor input field*/
    #__lpform_email,
    #__lpform_user_password_icon{
        display: none !important;
    }
    input:-webkit-autofill,
    input:-webkit-autofill:hover,
    input:-webkit-autofill:focus,
    input:-webkit-autofill:active  {
        -webkit-box-shadow: 0 0 0 30px #F2FBF8 inset !important;
        background: none;
    }
</style>

<div class="divCenter" style="display: flex; flex-flow: row nowrap; justify-content: center">
    @include('pages.web-driver.brand-contents')
    <div class="loginForm animated fadeInLeft">
        <div class="btn-group btn-login-type btn-group-justified">
            <a class="btn {{ Request::segment(2) == "rider" ? "active" : "" }}" href="{{ url('web/rider/login-form') }}">Rider Login</a>
            <a class="btn {{ Request::segment(2) == "driver" ? "active" : "" }}" href="{{ url('web/driver/login-form') }}">Driver Login</a>
        </div>
        @include('includes.flash-message')
        <h4 style="text-align: center; text-transform: uppercase; font-size: 16px; margin: 0;">Welcome to</h4>
        <img src="{{ asset('login-assets/images/login-logo.png') }}" alt="" class="login-logo" />


        <form role="form" class="form-horizontal" action="{{ Request::segment(2) == "rider" ? route('rider-login-check') : route('driver-login-check') }}" method="post">
            @csrf

            <div class="group">
                <input type="text" name="email" id="email" value="{{ old('email') }}" required autofocus />
                <span class="highlight"></span><span class="bar"></span>
                <label for="email" class="">{{ __('User Email:') }}</label>
            </div>
            <div class="group">
                <input type="password" name="password" id="user_password" placeholder="* * * * * *" required />
                <span class="highlight"></span><span class="bar"></span>
                <label for="user_password">{{ __('Password:') }}</label>
            </div>
            <div class="remember-wrap">
                <label for="remember">{{ __('Remember Me') }}</label>
                <input type="checkbox" name="remember" id="remember" class="" tabindex="-1" />
                <a href="{{ route('driver.password.request') }}" class="btn btn-link btn-sm" tabindex="-1">{{ __('Forgot password?') }}</a>
            </div>
            <button type="submit" class="buttonui"> <span> Sign in </span>
                <div class="ripples buttonRipples"><span class="ripplesCircle"></span></div>
            </button>
        </form>

        @include('pages.web-driver.poweredBy-link')
    </div>
</div>
@endsection


@section('custom_web_api_js')
<script type="text/javascript">
$(document).ready(function(){

}); //End of Document Ready
</script>
@endsection

