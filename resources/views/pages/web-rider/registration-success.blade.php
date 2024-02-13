@extends('web_api')
@section('main_content')

<style>
    h1 {text-align:center; padding: 20px 10px; text-transform: uppercase; font-weight: 400; }
    .divCenter { width: 70%; margin: 0 auto; margin-top: 5%; color: #fff; box-shadow: 2px 0 5px -1px rgba(0,0,0,.30); }
    .brand { background: url("{{ asset('/public/login-assets/images/login-form-bg.png') }}") no-repeat center center/cover; width: 60%; border-radius: .5em 0 0 .5em; padding: 30px; display: flex; justify-content: center; align-items: center; text-align: center; }
    .brand img{ width: 60% !important; }
    .form_success { background: #fff; color: #31455A; width: 40%; text-align: center; border-radius: 0 .5em .5em 0; padding: 30px 15px 10px; }
    .custom-file{ text-align: left;}
    .buttonui { position: relative; color: #fff !important; padding: 3px 45px; margin-top: 30px; line-height: 30px; overflow: hidden; border-width: 0; outline: none; border-radius: 5px; box-shadow: 0 1px 3px rgba(0, 0, 0, .3); background-color: #EF0C14; transition: all 0.3s ease; cursor: pointer; margin-bottom: 20px; }

    .ripples {  position: absolute;  top: 0;  left: 0;  width: 100%;  height: 100%;  overflow: hidden;  background: transparent;}
    .ripplesCircle {  position: absolute;  top: 50%;  left: 50%;  -webkit-transform: translate(-50%, -50%);          transform: translate(-50%, -50%); opacity: 0;  width: 0;  height: 0;  border-radius: 50%;  background: rgba(255, 255, 255, 0.25);}
    .ripples.is-active .ripplesCircle {  -webkit-animation: ripples .4s ease-in;          animation: ripples .4s ease-in;}
    .remember-wrap{ overflow: hidden; margin: -20px auto 20px; position: relative;}
    .remember-wrap label{ font-size: 14px; float: left; margin-left: 21px; position: static; display: block; color: #333; pointer-events: auto; cursor: pointer; }
    .remember-wrap a{ float: right; }
    input:-webkit-autofill,
    input:-webkit-autofill:hover,
    input:-webkit-autofill:focus,
    input:-webkit-autofill:active  {
        -webkit-box-shadow: 0 0 0 30px #fff inset !important;
        background: none;
    }

</style>

<div class="divCenter" style="display: flex; flex-flow: row nowrap; justify-content: center">
    @include('pages.web-driver.brand-contents')
    <div class="form_success">
        <h1>Congratulation!</h1>
        <p>You are successfuly registered to Esojai Ltd.</p>
        <p>A verification link sent to your Email. Please verify fist & then login to your profile.</p>

        <a class="buttonui btn" href="{{ Request::segment(2) == "rider" ? url('web/rider/login-form') : url('web/driver/login-form') }}" style="background: #fff; border: 1px solid #EF0C14; color: #EF0C14 !important; font-weight: bold;">Go to Login Page</a>
        <a class="buttonui btn" href="https://www.esojai.com">Back to Website</a>
    </div>
</div>
@endsection


@section('custom_web_api_js')
<script type="text/javascript">
$(document).ready(function(){
    $('form').on("click", 'button.show_password', function(e) {
        e.preventDefault();

        if( $(this).hasClass("active") ){
            $("input#password").attr("type", "text");
            $(this).addClass('btn-danger active');
            $(this).find("i").addClass("fa-eye");
        }else{
            $("input#password").attr("type", "password");
            $(this).find("i").addClass("fa-eye-slash");
        }
    });
}); //End of Document Ready



</script>
@endsection

