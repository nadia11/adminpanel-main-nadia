@extends('layouts.app')
@section('login_content')

<style>
    * { box-sizing:border-box; }
    h1 {text-align:center; padding: 20px 10px; color: #fff; text-transform: uppercase; font-weight: 400; }
    form { padding: 20px; padding-top: 30px; background: #fff;}
    .powered{padding: 10px; margin-top: 0px; line-height: 25px;}
    .powered a {color: #ddd; text-decoration: none;}
    .powered a:hover {font-style:italic;}
    .group {position: relative;  margin-bottom: 25px; }

    input{font-size: 18px;  padding: 10px 10px 10px 5px; -webkit-appearance: none; display: block;  background: transparent;  color: #03a9f4;  width: 100%;  border: none;  border-radius: 0;  border-bottom: 1px solid #ddd;}

    input:focus{outline: none; }

    /* Label */
    label {display: none; color: #999; font-weight: normal; position: absolute; pointer-events: none; left: 5px; top: 10px; -webkit-transition:all 0.2s ease; transition: all 0.2s ease;}

    /* active */
    input:focus ~ label, input.used ~ label {top: -20px; -webkit-transform: scale(.75); transform: scale(.75); left: -2px; color: #4a89dc; display: block; }

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
    .buttonui { position: relative; padding: 8px 45px; line-height: 30px; overflow: hidden; border-width: 0; outline: none; border-radius: 2px; box-shadow: 0 1px 3px rgba(0, 0, 0, .3); background-color: #1593e0; color: #ecf0f1; transition: all 0.3s ease; cursor: pointer; margin-bottom: 20px; }
    .buttonui:before { content: ""; position: absolute; top: 50%; left: 50%; display: block; width: 0; padding-top: 0; border-radius: 100%; background-color: rgba(236, 240, 241, .3); -webkit-transform: translate(-50%, -50%); -moz-transform: translate(-50%, -50%); -ms-transform: translate(-50%, -50%); -o-transform: translate(-50%, -50%); transform: translate(-50%, -50%);}
    .buttonui span{ padding: 12px 24px; font-size:16px;}
    .buttonui:hover{ background-color: #fff; border: 1px solid #1593e0; color: #1593e0; }
    .loginForm { background: url("{{ asset('login-assets/images/login-form-bg.png') }}") no-repeat center center/cover; width: 25%; margin: 0 auto; z-index: 99; display: block; margin-top: 5%; border-radius: .25em .25em .4em .4em; text-align: center; color: #fff; box-shadow: 2px 0 5px -1px rgba(0,0,0,.30); }
    /* Ripples container */

    .ripples {  position: absolute;  top: 0;  left: 0;  width: 100%;  height: 100%;  overflow: hidden;  background: transparent;}
    .ripplesCircle {  position: absolute;  top: 50%;  left: 50%;  -webkit-transform: translate(-50%, -50%);          transform: translate(-50%, -50%);  opacity: 0;  width: 0;  height: 0;  border-radius: 50%;  background: rgba(255, 255, 255, 0.25);}
    .ripples.is-active .ripplesCircle {  -webkit-animation: ripples .4s ease-in;          animation: ripples .4s ease-in;}
    .remember-wrap{ overflow: hidden; margin: -20px auto 20px; position: relative;}
    .remember-wrap label{ float: left; margin-left: 21px; position: static; display: block; color: #333; pointer-events: auto; cursor: pointer; }
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
        img.login-logo {margin: 20px auto 5px !important;}
        form{padding: 15px 20px 5px;}
        .group { margin-bottom: 15px; }
    }
    img.login-logo{ width: 100%; margin: 30px 0px 0px; padding: 5px 20px; background: #fff; max-height: 120px; }
    input[type=checkbox]{ -webkit-appearance: checkbox; pointer-events: auto; float: left; width: auto; position: absolute; left: 0; top: 20%; }
    .loginForm input[type='password']{ border-bottom: 1px solid #0098d8; font-size: 20px; color: #369; }
    .loginForm input::placeholder { color: #0098d8!important; }

    /*Remove Autoculor input field*/
    #__lpform_email,
    #__lpform_user_password_icon{
        display: none !important;
    }
    input:-webkit-autofill,
    input:-webkit-autofill:hover,
    input:-webkit-autofill:focus,
    input:-webkit-autofill:active  {
        -webkit-box-shadow: 0 0 0 30px #fff inset !important;
        background: none;
    }
</style>
<div class="loginForm divCenter">
    @include('includes.flash-message')
    <img src="{{ asset('login-assets/images/login-logo.png') }}" alt="" class="login-logo" />
    <h1>User Login</h1>

    <form role="form" class="form-horizontal" action="{{ url('login') }}" method="post">
        @csrf

        <div class="group">
            <input type="text" name="email" id="email" class="{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" tabindex="1" required autofocus />
            @if ($errors->has('email'))
            <span class="invalid-feedback"><strong>{{ $errors->first('email') }}</strong></span>
            @endif

            <span class="highlight"></span><span class="bar"></span>
            <label for="email" class="">{{ __('User Email:') }}</label>
        </div>
        <div class="group">
            <input type="password" name="password" id="user_password" class="<?php //echo $errors->has('password') ? ' is-invalid' : ''; ?>" placeholder="* * * * * *" tabindex="2" required />
            @if ($errors->has('password'))
            <span class="invalid-feedback"><strong>{{ $errors->first('password') }}</strong></span>
            @endif
            <span class="highlight"></span><span class="bar"></span>
            <label for="user_password">{{ __('Password:') }}</label>
        </div>
        <div class="remember-wrap">
            <label for="remember">{{ __('Remember Me') }}</label>
            <input type="checkbox" name="remember" id="remember" <?php //old('remember') ? 'checked' : ''; ?> class="" tabindex="-1" />
            <a href="{{ route('password.request') }}" class="btn btn-link btn-sm" tabindex="-1">{{ __('Forgot password?') }}</a>
        </div>
        <button type="submit" class="buttonui" tabindex="3"> <span> Sign in </span>
            <div class="ripples buttonRipples"><span class="ripplesCircle"></span></div>
        </button>
    </form>
    <div class="powered">
    </div>
</div>

<script>
    $(window, document, undefined).ready(function () {
        $('input').blur(function () {
            var $this = $(this);
            if ($this.val())
                $this.addClass('used');
            else
                $this.removeClass('used');
        });

        var $ripples = $('.ripples');

        $ripples.on('click.Ripples', function (e) {

            var $this = $(this);
            var $offset = $this.parent().offset();
            var $circle = $this.find('.ripplesCircle');

            var x = e.pageX - $offset.left;
            var y = e.pageY - $offset.top;

            $circle.css({ top: y + 'px', left: x + 'px' });
            $this.addClass('is-active');
        });

        $ripples.on('animationend webkitAnimationEnd mozAnimationEnd oanimationend MSAnimationEnd', function (e) {
            $(this).removeClass('is-active');
        });
    });
</script>
@endsection
