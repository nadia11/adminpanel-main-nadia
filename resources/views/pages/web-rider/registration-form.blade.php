@extends('web_api')
@section('main_content')

<style>
    * { box-sizing:border-box; }
    h1 {text-align:center; padding: 20px 10px; text-transform: uppercase; font-weight: 400; }
    form { padding: 20px; background: #fff;}
    .powered{ padding: 10px 10px 0; margin-top: 0px; line-height: 20px; border-top: 1px solid #ccc; }
    .powered a {color: #EF0C14; text-decoration: none; font-weight: bold;}

    .buttonui { position: relative; padding: 8px 45px; overflow: hidden; border: 1px solid transparent; outline: none; border-radius: 5px; box-shadow: 0 1px 3px rgba(0, 0, 0, .3); background-color: #EF0C14; color: #ecf0f1; transition: all 0.3s ease; cursor: pointer; margin: 10px auto 20px; }
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
    .divCenter { display: flex; flex-flow: row nowrap; justify-content: center; width: 70%; margin: 0 auto; color: #fff; box-shadow: 2px 0 5px -1px rgba(0,0,0,.30); }
    .brand { background: url("{{ asset('/login-assets/images/login-form-bg.png') }}") no-repeat center center/cover; width: 60%; border-radius: .5em 0 0 .5em; padding: 0 30px 130px; display: flex; justify-content: center; align-items: center; text-align: center; }
    .app-link { width: 70%; position: absolute; bottom: 2%; left: 0; right: 0; margin: 0 auto;}
    .app-link ul{ display: flex; flex-flow: row nowrap; justify-content: center; color: #fff; list-style-type: none; align-items: center; padding: 0; }
    .app-link ul li:last-child{ margin-left: 15px; }
    .app-link img{ width: 150px; height: auto; }
    .brand img.login-logo{ width: 60% !important; }
    .loginForm { background: #fff; color: #31455A; width: 40%; text-align: center; border-radius: 0 0 .5em 0; padding: 40px 15px 10px; position: relative; }
    .custom-file{ text-align: left;}

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

<div class="divCenter">
    @include('pages.web-driver.brand-contents')
    <div class="loginForm">
        <div class="btn-group btn-login-type btn-group-justified">
            <a class="btn {{ Request::segment(2) == "rider" ? "active" : "" }}" href="{{ url('web/rider/registration-form') }}">Rider Registration</a>
            <a class="btn {{ Request::segment(2) == "driver" ? "active" : "" }}" href="{{ url('web/driver/registration-form') }}">Driver Registration</a>
        </div>
        @include('includes.flash-message')
        <form role="form" name="rider-registration-form-save" action="{{ route('rider-registration-form-save') }}" method="POST" enctype="multipart/form-data" class="form-horizontal animated fadeInLeft">
        @csrf

            <div class="form-group">
                <label for="rider_name" class="control-label sr-only">Name (Block Letters)</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-user"></i></div>
                    </div>
                    <input type="text" class="form-control text-uppercase" name="rider_name" id="rider_name" placeholder="Rider Name" required />
                </div>
            </div>
            <div class="form-group">
                <label for="mobile" class="control-label sr-only">Mobile No</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-phone"></i></div>
                    </div>
                    <input type="tel" class="form-control" id="mobile" name="mobile" placeholder="+8801XXX-XXXXXX" required />
                </div>
            </div>

            <div class="form-group">
                <label for="email" class="control-label sr-only">E-mail</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-envelope"></i></div>
                    </div>
                    <input type="email" class="form-control" name="email" id="email" placeholder="example@domain.com" required />
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="control-label sr-only">Password</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-lock"></i></div>
                    </div>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off" required />
                    <div class="input-group-prepend"><button type="button" class="btn btn-outline-danger show_password" tabindex="-1"><i class="fa fa-eye" title="Show Password" aria-hidden="true"></i> <span class="showtext"></span></button></div>
                </div>
            </div>

            <div class="form-group">
                <label for="rider_photo" class="control-label sr-only">Photo Upload</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-upload" aria-hidden="true"></i></div>
                    </div>
                    <div class="custom-file">
                        <input type="file" name="user_photo" id="user_photo" style="display: none;" />
                        <input type="file" name="rider_photo" id="rider_photo" class="custom-file-input" accept=".png, .jpg, .jpeg" required>
                        <label class="custom-file-label" for="rider_photo">Choose Photo</label>
                    </div>
                </div>
            </div>

            <div class="custom-control custom-switch mb-2 text-left">
                <input type="checkbox" class="custom-control-input" id="referral_switch" checked="on">
                <label class="custom-control-label" for="referral_switch" style="cursor:pointer;">If you have no Reference, Please deactivate this. </label>
            </div>
            <div class="form-group referral_item">
                <label for="referral_name" class="control-label sr-only">Referral Name</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-user"></i></div>
                    </div>
                    <input type="text" class="form-control" name="referral_name" id="referral_name" placeholder="Referral Name" />
                </div>
            </div>
            <div class="form-group referral_item">
                <label for="referral_mobile" class="control-label sr-only">Referral Phone</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-phone"></i></div>
                    </div>
                    <input type="text" class="form-control" name="referral_mobile" id="referral_mobile" placeholder="Referral Phone" />
                </div>
            </div>

            <button type="submit" class="buttonui">Sign Up</button>
        </form>

        @include('pages.web-driver.poweredBy-link')
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

    $(document).on("change click", "input#referral_switch", function(){
        if($( this ).is( ":checked" )){
            $('.referral_item').slideDown('slow');
        }else{
            $('.referral_item').slideUp('slow');
        }
    }).change();

    $(document).on("change", "#rider_photo", function(){
        var val = $(this).val();

        $("#user_photo").val(val);
    }).change();



}); //End of Document Ready



</script>
@endsection

