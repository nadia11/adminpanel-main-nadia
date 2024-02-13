@extends('dashboard')
@section('main_content')

<section class="content-wrapper">
    <div class="box box-success animated fadeInLeft">
        <div class="box-header with-border">
            <h2 class="box-title">User Account Settings</h2>
        </div><!-- /.box-header -->

        <div class="box-body">
			<form action="{{ route('user-account-settings-save') }}" role="form" name="" method="post" class="form-horizontal" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="currency" class="control-label">Currency</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fa fa-dollar-sign fa-lg"></i></div>
                                </div>
                                <select id="currency" name="currency" class="custom-select">
                                    <option value="">--Select Currency--</option>
                                    @php $currency_array = json_decode(file_get_contents( "https://openexchangerates.org/api/currencies.json" ), true) @endphp
                                    <@php $currency_current = $ua_settings_data->currency === 'BDT' ? 'BDT' : $ua_settings_data->currency @endphp
                                    @foreach( $currency_array as $key =>$currency )
                                        <option value="{{ $key }}" {{ $key === $currency_current ? "Selected" : "" }}>{{ $key ." - ". $currency }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="language" class="control-label">Language</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fa fa-language fa-lg"></i></div>
                                </div>
                                <select id="language" name="language" class="custom-select" required>
                                    <option value="">--Select Language--</option>
                                    @php $language_array = json_decode(file_get_contents( resource_path()."/views/user/json-file/languages.json" ), true) @endphp
                                    {{-- ($characters[ab][name]); https://www.logisticinfotech.com/translate-language-files-online-json/--}}
                                    <@php $language = $ua_settings_data->language === 'Bengali' ? 'Bengali' : $ua_settings_data->language @endphp
                                    @foreach( $language_array as $lan )
                                        <option value="{{ $lan['name'] }}" {{ $lan['name'] === $language ? "Selected" : "" }}>{{ $lan['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="menu_position" class="control-label">Menu Position</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fa fa-th-large fa-lg"></i></div>
                                </div>
                                <select class="custom-select" name="menu_position" id="menu_position">
                                    <option value="header_menu" {{ $ua_settings_data->menu_position === 'header_menu' ? 'selected' : '' }}>Header Menu</option>
                                    <option value="sidebar_menu" {{ $ua_settings_data->menu_position === 'sidebar_menu' ? 'selected' : '' }}>Sidebar Menu</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="theme" class="control-label">Styles and Themes</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fa fa-paint-brush fa-lg"></i></div>
                                </div>
                                <select class="custom-select" name="theme" id="theme">
                                    <option value="light-theme" {{ $ua_settings_data->theme === 'light-theme' ? 'selected' : '' }}>Light Theme</option>
                                    <option value="dark-theme" {{ $ua_settings_data->theme === 'dark-theme' ? 'selected' : '' }}>Dark Theme</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div><!-- form-group -->

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="facebook" class="control-label">Facebook ID</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fab fa-facebook-f fa-lg"></i></div>
                                </div>
                                <input type="text" name="facebook" id="facebook" class="form-control" placeholder="Facebook" value="{{ $ua_settings_data->facebook ?: '' }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="twitter" class="control-label">Twitter Name</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fab fa-twitter fa-lg"></i></div>
                                </div>
                                <input type="text" name="twitter" id="twitter" class="form-control" placeholder="Twitter" value="{{ $ua_settings_data->twitter ?: '' }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="googleplus" class="control-label">Google+ Name</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fab fa-google-plus-g fa-lg"></i></div>
                                </div>
                                <input type="text" name="googleplus" id="googleplus" class="form-control" placeholder="Google+" value="{{ $ua_settings_data->googleplus ?: '' }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="linkedin" class="control-label">linked In Name</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fab fa-linkedin-in fa-lg"></i></div>
                                </div>
                                <input type="text" name="linkedin" id="linkedin" class="form-control" placeholder="linked In" value="{{ $ua_settings_data->linkedin ?: '' }}">
                            </div>
                        </div>
                    </div>
                </div><!-- form-group -->

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="instagram" class="control-label">Instagram Name</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fab fa-instagram fa-lg"></i></div>
                                </div>
                                <input type="text" name="instagram" id="instagram" class="form-control" placeholder="instagram" value="{{ $ua_settings_data->instagram ?: '' }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="whatsapp" class="control-label">whatsapp Name</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fab fa-whatsapp fa-lg"></i></div>
                                </div>
                                <input type="text" name="whatsapp" id="whatsapp" class="form-control" placeholder="whatsapp" value="{{ $ua_settings_data->whatsapp ?: '' }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="skype" class="control-label">Skype Name</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fab fa-skype fa-lg"></i></div>
                                </div>
                                <input type="text" name="skype" id="skype" class="form-control" placeholder="Skype" value="{{ $ua_settings_data->skype ?: '' }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="youtube" class="control-label">Youtube Channel Name</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fab fa-youtube fa-lg"></i></div>
                                </div>
                                <input type="text" name="youtube" id="youtube" class="form-control" placeholder="Youtube" value="{{ $ua_settings_data->youtube ?: '' }}">
                            </div>
                        </div>
                    </div>
                </div><!-- form-group -->

                <div class="row col-md-12">
                    <button type="submit" class="btn btn-success btn-lg" style="padding: 3px 40px;">Save Settings</button>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection


@section('custom_js')
<script type="text/javascript">
    jQuery.extend({
        getQueryParameters : function(str) { return (str || document.location.search).replace(/(^\?)/,'').split("&").map(function(n){return n = n.split("="),this[n[0]] = n[1],this}.bind({}))[0]; }
    });
    var queryParams = $.getQueryParameters();


    // var urlParams = new URLSearchParams(window.location.search);
    // console.log(urlParams.has('post')); // true
    // console.log(urlParams.get('action')); // "edit"
    // console.log(urlParams.getAll('action')); // ["edit"]
    // console.log(urlParams.toString()); // "?post=1234&action=edit"
    // console.log(urlParams.append('active', '1')); // "?post=1234&action=edit&active=1"


    // $(document).ready(function(){
    //     $.getJSON('https://openexchangerates.org/api/currencies.json', {base: 'BDT'}, function(data, status, xhr) {
    //         //console.log( data.BDT ); //http://country.io/names.json
    //         $.each(data, function(key, value){
    //             $('select[name="currency"]').append( '<option '+(key==="BDT" ? "selected" : "")+' value="'+ key +'">'+ key +" - "+value +'</option>' );
    //         });
    //         if (status === 200) {}
    //     });
    // });
</script>
@endsection
