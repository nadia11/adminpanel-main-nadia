@extends('web_api')
@section('main_content')

    <style>
        * { box-sizing:border-box; }
        h1 {text-align:center; padding: 20px 10px; text-transform: uppercase; font-weight: 400; }
        form { padding: 20px; background: #fff;}
        .powered{ padding: 10px 10px 0; margin-top: 0px; line-height: 20px; border-top: 1px solid #ccc; }
        .powered a {color: #EF0C14; text-decoration: none; font-weight: bold;}

        .buttonui { position: relative; padding: 8px 45px; overflow: hidden; border: 1px solid transparent; outline: none; border-radius: 5px; box-shadow: 0 1px 3px rgba(0, 0, 0, .3); background-color: #EF0C14; color: #ecf0f1; transition: all 0.3s ease; cursor: pointer; margin: 10px auto; }
        .buttonui:before { content: ""; position: absolute; top: 50%; left: 50%; display: block; width: 0; padding-top: 0; border-radius: 100%; background-color: rgba(236, 240, 241, .3); -webkit-transform: translate(-50%, -50%); -moz-transform: translate(-50%, -50%); -ms-transform: translate(-50%, -50%); -o-transform: translate(-50%, -50%); transform: translate(-50%, -50%);}
        .buttonui span{ padding: 12px 24px; font-size:16px;}
        .buttonui:hover{ background-color: #fff; border: 1px solid #EF0C14; color: #EF0C14; }
        .buttonui.disabled { color: #fff; background-color: #dc3545; border-color: #dc3545; opacity: .5 }
        .buttonui.disabled:hover { color: #fff; background-color: #dc3545; border-color: #dc3545; opacity: .5 }
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
        .divCenter { width: 80%; margin: 0 auto; margin-top: 5%; color: #fff; box-shadow: 2px 0 5px -1px rgba(0,0,0,.30); }
        .brand { background: url("{{ asset('/login-assets/images/login-form-bg.png') }}") no-repeat center center/cover; width: 60%; border-radius: .5em 0 0 .5em; padding: 0 30px 130px; display: flex; justify-content: center; align-items: center; text-align: center; }
        .app-link { width: 70%; position: absolute; bottom: 2%; left: 0; right: 0; margin: 0 auto;}
        .app-link ul{ display: flex; flex-flow: row nowrap; justify-content: center; color: #fff; list-style-type: none; align-items: center; padding: 0; }
        .app-link ul li:last-child{ margin-left: 15px; }
        .app-link img{ width: 150px; height: auto; }
        .brand img.login-logo{ width: 60% !important; }
        .loginForm { background: #fff; color: #31455A; width: 40%; text-align: center; border-radius: 0 0 .5em 0; padding: 15px 10px; position: relative; }
        .custom-file{ text-align: left;}

        .ripples {  position: absolute;  top: 0;  left: 0;  width: 100%;  height: 100%;  overflow: hidden;  background: transparent;}
        .ripplesCircle {  position: absolute;  top: 50%;  left: 50%;  -webkit-transform: translate(-50%, -50%); transform: translate(-50%, -50%); opacity: 0;  width: 0;  height: 0;  border-radius: 50%;  background: rgba(255, 255, 255, 0.25);}
        .ripples.is-active .ripplesCircle {  -webkit-animation: ripples .4s ease-in; animation: ripples .4s ease-in;}
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
        .row .col-6:first-child{ padding-right: 5px; }
        .row .col-6:last-child{ padding-left: 5px; }

        .loginForm .alert {
            text-align: left !important;;
        }
    </style>

    <div class="divCenter" style="display: flex; flex-flow: row nowrap; justify-content: center">
        @include('pages.web-driver.brand-contents')
        <div class="loginForm">
            <div class="btn-group btn-login-type btn-group-justified">
                <a class="btn {{ Request::segment(2) == "rider" ? "active" : "" }}" href="{{ url('web/rider/registration-form') }}">Rider Registration</a>
                <a class="btn {{ Request::segment(2) == "driver" ? "active" : "" }}" href="{{ url('web/driver/registration-form') }}">Driver Registration</a>
            </div>
            @include('includes.flash-message')

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form role="form" name="" action="{{ route('driver-registration-form-save') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                @csrf

                <div class="part-one animated fadeInLeft">
                    <div class="form-group">
                        <label for="driver_name" class="control-label sr-only">Name (Block Letters)</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-user"></i></div>
                            </div>
                            <input type="text" class="form-control text-uppercase" name="driver_name" id="driver_name" placeholder="Driver Name" required />
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="division_id" class="control-label sr-only">Division</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-th-large"></i></div>
                                    </div>
                                    <select id="division_id" name="division_id" class="custom-select" required>
                                        <option value="" selected="selected">--Division--</option>
                                        @php $divisions = DB::table('divisions')->orderBy('division_name', 'ASC')->pluck("division_name", "division_id") @endphp

                                        @foreach( $divisions as $key => $division )
                                            <option value="{{ $key }}">{{ $division }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="district_id" class="control-label sr-only">District</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-th"></i></div>
                                    </div>
                                    <select id="district_id" name="district_id" class="custom-select" required>
                                        <option value="">--District--</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="branch_id" class="control-label sr-only">Name of the Branch</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-tag"></i></div>
                            </div>
                            <select id="branch_id" name="branch_id" class="custom-select" required>
                                <option value="">--Select Branch Name--</option>
                                <?php //$branches = array('Bagerhat', 'Bandarban', 'Barguna', 'Barishal', 'Bhola', 'Bogura', 'Brahmanbaria', 'Chandpur', 'Chapai_Nawabganj', 'Chattogram', 'Chuadanga', 'Cumilla', 'Coxs_Bazar', 'Dhaka_City', 'Dinajpur', 'Dohar_Nobabgonj', 'Faridpur', 'Feni', 'Gaibandha', 'Gazipur', 'Gopalgonj', 'Hobigonj', 'Jamalpur', 'Jashore', 'Jhalakati', 'Jhenaidah', 'Joypurhat', 'Khagrachari', 'Khulna', 'Kishoregonj', 'Kurigram', 'Kushtia', 'Lalmonirhat', 'Laxmipur', 'Madaripur', 'Magura', 'Manikgonj', 'Meherpur', 'Moulovibazar', 'Munshigonj', 'Naogaon', 'Narail', 'Narayangonj', 'Narsingdi', 'Natore', 'Netrakona', 'Nilphamari', 'Noakhali', 'Pabna', 'Panchagarh', 'Patuakhali', 'Pirojpur', 'Rajbari', 'Rajshahi', 'Rangamati', 'Rangpur', 'Sayedpur', 'Satkhira', 'Shariatpur', 'Sherpur', 'Sirajgonj', 'Sreemongal', 'Sunamgonj', 'Sylhet', 'Tangail', 'Thakurgaon'); asort($branches); ?>
                                {{--@php $branches = DB::table("bma_branches")->select("branch_name", "branch_id")->orderBy('branch_name', 'ASC')->pluck("branch_name", 'branch_id'); @endphp--}}
                                {{--@foreach( $branches as $branch )--}}
                                {{--<option value="{{ $branch }}">{{ $branch }}</option>--}}
                                {{--@endforeach--}}
                            </select>
                            {{--<datalist id="branch_list"><option value="Bagerhat"><option value="Bandarban"><option value="Barguna"><option value="Barishal"><option value="Bhola"><option value="Bogura"><option value="Brahmanbaria"><option value="Chandpur"><option value="Chapai Nawabganj"><option value="Chattogram"><option value="Chuadanga"><option value="Cumilla"><option value="Coxs Bazar"><option value="Dhaka City"><option value="Dinajpur"><option value="Dohar"><option value="Faridpur"><option value="Feni"><option value="Gaibandha"><option value="Gazipur"><option value="Gopalgonj"><option value="Hobigonj"><option value="Jamalpur"><option value="Jashore"><option value="Jhalakati"><option value="Jhenaidah"><option value="Joypurhat"><option value="Khagrachari"><option value="Khulna"><option value="Kishoregonj"><option value="Kurigram"><option value="Kushtia"><option value="Lalmonirhat"><option value="Laxmipur"><option value="Madaripur"><option value="Magura"><option value="Manikgonj"><option value="Meherpur"><option value="Moulvibazar"><option value="Munshigonj"><option value="Naogaon"><option value="Narail"><option value="Narayangonj"><option value="Narsingdi"><option value="Natore"><option value="Netrakona"><option value="Nilphamari"><option value="Noakhali"><option value="Pabna"><option value="Panchagarh"><option value="Patuakhali"><option value="Pirojpur"><option value="Rajbari"><option value="Rajshahi"><option value="Rangamati"><option value="Rangpur"><option value="Sayedpur"><option value="Satkhira"><option value="Shariatpur"><option value="Sherpur"><option value="Sirajgonj"><option value="Sreemongal"><option value="Sunamgonj"><option value="Sylhet"><option value="Tangail"><option value="Thakurgaon"></datalist>--}}
                            {{--<input type="text" class="form-control" name="branch_id" id="branch_id" list="branch_list" placeholder="BM&Name of the Branch" required />--}}
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
                            <input type="email" class="form-control" name="email" id="email" placeholder="example@domain.com" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="control-label sr-only">Password</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-lock"></i></div>
                            </div>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off" />
                            <div class="input-group-prepend"><button type="button" class="btn btn-outline-danger show_password" tabindex="-1"><i class="fa fa-eye" title="Show Password" aria-hidden="true"></i> <span class="showtext"></span></button></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="national_id" class="control-label sr-only">National ID</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-mobile"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="national_id" name="national_id" placeholder="National ID" required />
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="driving_licence" class="control-label sr-only">Driving Licence</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-mobile"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="driving_licence" name="driving_licence" placeholder="Driving Licence" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="driver_photo" class="control-label sr-only">Driver Photo Upload</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-upload" aria-hidden="true"></i></div>
                            </div>
                            <div class="custom-file">
                                <input type="file" name="driver_photo" id="driver_photo" class="custom-file-input" accept=".png, .jpg, .jpeg">
                                <label class="custom-file-label" for="driver_photo">Choose Driver Photo</label>
                            </div>
                            <small style="width: 100%; text-align: left;">Max: 45mm high and 35mm wide, below 100 kb</small>
                        </div>
                    </div>

                    <button type="button" class="buttonui continue-button disabled" disabled="disabled">Continue</button>
                </div>

                <div class="part-two animated fadeInLeft" style="display: none;">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="vehicle_type_id" class="control-label sr-only">Vehicle Type</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-tags"></i></div>
                                    </div>
                                    <select id="vehicle_type_id" name="vehicle_type_id" class="custom-select" required>
                                        @php $vehicle_types = DB::table('vehicle_types')->orderBy('vehicle_type', 'ASC')->pluck("vehicle_type", "vehicle_type_id") @endphp

                                        <option value="">--Vehicle Type--</option>
                                        @foreach( $vehicle_types as $key => $type )
                                            <option value="{{ $key }}">{{ ucwords($type) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="vehicle_model" class="control-label sr-only">Vehicle Model</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-motorcycle"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="vehicle_model" name="vehicle_model" placeholder="Vehicle Model" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="seat_capacity" class="control-label sr-only">Seat Capacity</label>
                                <select id="seat_capacity" name="seat_capacity" class="custom-select" required>
                                    <option value="">--Seat Capacity--</option>
                                    <option value="2">2 Persons</option>
                                    <option value="4">4 Persons</option>
                                    <option value="6">6 Persons</option>
                                    <option value="8">8 Persons</option>
                                    <option value="10">10 Persons</option>
                                    <option value="12">12 Persons</option>
                                    <option value="14">14 Persons</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="vehicle_reg_number" class="control-label sr-only">Vehicle Reg. Number</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-tag"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="vehicle_reg_number" name="vehicle_reg_number" placeholder="Vehicle Reg. Number" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="vehicle_tax_token" class="control-label sr-only">Tax Token Number</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-tag"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="vehicle_tax_token" name="vehicle_tax_token" placeholder="Tax Token Number" required />
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="tax_renewal_date" class="control-label sr-only">Tax Renewal Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    <input type="datetime" class="form-control" id="tax_renewal_date" name="tax_renewal_date" placeholder="Tax Renewal Date" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="insurance_number" class="control-label sr-only">Insurance Number</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-tag"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="insurance_number" name="insurance_number" placeholder="Insurance Number" required />
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="insurance_renewal_date" class="control-label sr-only">Insurance Renewal Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    <input type="datetime" class="form-control" id="insurance_renewal_date" name="insurance_renewal_date" placeholder="Insurance Renewal Date" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12">
                                <label for="fitness_certificate" class="control-label sr-only">Fitness Certificate</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-mobile"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="fitness_certificate" name="fitness_certificate" placeholder="Fitness Certificate" required />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="vehicle_photo" class="control-label sr-only">Vehicle Photo Upload</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-upload" aria-hidden="true"></i></div>
                            </div>
                            <div class="custom-file">
                                <input type="file" name="vehicle_photo" id="vehicle_photo" class="custom-file-input" accept=".png, .jpg, .jpeg" required>
                                <label class="custom-file-label" for="vehicle_photo">Choose Vehicle Photo</label>
                            </div>
                            <small style="width: 100%; text-align: left;">Max: 45mm high and 35mm wide, below 100 kb</small>
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

                    <button type="button" class="buttonui previous-button" style="background: #fff; border: 1px solid #EF0C14; color: #EF0C14 !important; font-weight: bold; margin-right: 10px;">Previous</button>
                    <button type="submit" class="buttonui">Sign Up</button>
                </div>
            </form>
            @include('pages.web-driver.poweredBy-link')
        </div>
    </div>
@endsection


@section('custom_web_api_js')
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('blur change keyup', "#driver_name, #division_id, #district_id, #branch_id, #mobile, #email, #password, #national_id, #driving_licence, #driver_photo", function(){
            var driver_name = $("#driver_name").val();
            var division_id = $("#division_id").val();
            var district_id = $("#district_id").val();
            var branch_id = $("#branch_id").val();
            var mobile = $("#mobile").val();
            var email = $("#email").val();
            var password = $("#password").val();
            var driver_photo = $("#driver_photo").val();
            var national_id = $("#national_id").val();
            var driving_licence = $("#driving_licence").val();

            if(!driver_name || !division_id || !district_id || !branch_id || !mobile || !email || !password || !national_id || !driving_licence || !driver_photo){
                $('.buttonui.continue-button').attr({class: "buttonui continue-button disabled", disabled: "disabled"});
                $('.buttonui.continue-button').prop('disabled', true);
            }else{
                $('.buttonui.continue-button').removeClass("disabled");
                $('.buttonui.continue-button').removeAttr("disabled");
                $('.buttonui.continue-button').prop('disabled',false);
            };
        });

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

    $(document).on('click', '.continue-button', function () {
        $('.powered').fadeOut('slow');
        $('.part-one').fadeOut('slow');
        $('.part-two').show('slow');
    });

    $(document).on('click', '.previous-button', function () {
        $('.part-two').fadeOut('slow');
        $('.powered').show('slow');
        $('.part-one').show('slow');
    });

    $(document).on("change click", "input#referral_switch", function(){
        if($( this ).is( ":checked" )){
            $('.referral_item').slideDown('slow');
        }else{
            $('.referral_item').slideUp('slow');
        }
    }).change();

    $('select[name="division_id"]').on('change', function(){
        var division_id = $(this).val();

        $.ajax({
            url : "{{ url('/web/driver/get-district-branch') }}/" + division_id,
            type : "GET",
            dataType : "json",
            data: {id: division_id },
            success:function( data ){
                var district = '<option value="" selected="selected">--Select District--</option>';
                $.each(data.districts, function(key, value){
                    district += '<option value="'+ key +'">'+ value +'</option>';
                });
                $('select[name="district_id"]').html( district );

                /******Branch Dropdown*****/
                var branch_id = '<option value="" selected="selected">--Select Branch--</option>';
                $.each(data.branches, function(key, value){
                    branch_id += '<option value="'+ key +'">'+ value +' Branch</option>';
                });
                $('select[name="branch_id"]').html( branch_id );
            },
            beforeSend: function( xhr ) { $('select#district_id, select#branch_id').parents(".input-group").append('<i class="loader-spin fa fa-spin fa-spinner fa-lg" style="position: absolute; left: 85%; top:28%; background: #fff;"></i>'); },
            complete: function( jqXHR, textStatus ) { $('.loader-spin').delay(1000).hide('slow'); $('.loader-spin').remove(); },
        });
    });
</script>
@endsection

