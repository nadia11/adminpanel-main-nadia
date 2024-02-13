<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>{{ config('app.name') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="Shortcut Icon" type="image/x-icon" href="{{ asset('/images/favicon.png') }}" />

    <!-- Load at first before load all document -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js"></script>
    <script>paceOptions = { ajax: true, document: true, eventLag: false }; Pace.on('done', function(){ $('#googleLoader').delay(0).fadeOut(300); });</script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	{{--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css">--}}
    <link rel="stylesheet" href="https://kit-pro.fontawesome.com/releases/v5.12.0/css/pro.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.6/css/fixedHeader.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.bootstrap4.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/plugin/databasic/summernote-ext-databasic.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/node-waves/0.7.6/waves.min.css">


    <!--<link rel="stylesheet" href="{ asset( '/plugins/iCheck/flat/green.css' ) }}">-->
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/flat/_all.css">-->
    <link rel="stylesheet" href="{{ asset( '/css/select2-bootstrap4.min.css' ) }}">
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">-->
    <link rel="stylesheet" href="{{ asset( '/css/animate-custom.min.css' ) }}">
    <link rel="stylesheet" href="{{ asset( '/css/app.core.css' ) }}"><!--  Theme style -->
    <link rel="stylesheet" href="{{ asset( '/css/skin-green.css' ) }}">

    @yield('custom_css')
</head>
<body class="hold-transition skin-green sidebar-mini {{ settings( 'menu_position' ) === 'header_menu' ? "header-menu" : "sidebar-menu" }}">
    {{--<div id="preloader"><div class="double-bounce1"></div><div class="double-bounce2"></div></div>--}}
    <!--<div id="preloader"><div class="loading-text"></div></div>-->
    <!--<div class="loading-container"><span class="fa fa-spinner fa-spin" style="font-size: 8em;" aria-hidden="true"></span> </div>-->

    <div id="progressbar-loading" style="display: none;">
        <strong>Processing, please wait ...</strong>
        <img src="{{ image_url('/progressbar-loading.gif') }}" alt="Progress Bar Image">
        <input type="BUTTON" value="Cancel" title="Cancel" class="birtviewer_progressbar_button" onclick="return confirm('Do you want to cancel current operation?'); ">
    </div>

    <div id="googleLoader" class="show fullscreen">
        <svg class="circular" width="60px" height="60px">
            <circle class="path-bg" cx="30" cy="30" r="28" fill="none" stroke-width="4" stroke="#eeeeee"></circle>
            <circle class="path" cx="30" cy="30" r="28" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#ff5e15"></circle>
        </svg>
    </div>

    <div class="wrapper" id="main_content">
        @include('layouts.header')
        @if( settings( 'menu_position' ) === 'header_menu' ) @include('layouts.top_menu') @else @include('layouts.sidebar') @endif

        <div class="ui-layout-center">
            @yield('main_content')
        </div><!-- ./layout center -->

        @include('layouts.footer')
    </div><!-- ./Main Content -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>

    <script src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script><!-- Button Supporting -->
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.colVis.min.js"></script><!-- show hide button  -->
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.2.1/jszip.min.js"></script><!-- Excel Supporting -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.41/pdfmake.min.js"></script><!-- Pdf Maker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.41/vfs_fonts.js"></script><!-- Pdf Maker Supporting -->
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script><!-- Button Supporting -->
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/keytable/2.5.1/js/dataTables.keyTable.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/node-waves/0.7.6/waves.min.js"></script><!-- Button Effect -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script> bloodhound.js + typeahead.jquery.js -->
    <?php echo '<script type="text/javascript">/*<![CDATA[*/ '.PHP_EOL.'; var tits_project = {"url":"'. url('/') . '", "name":"'. config('app.name') . '"}; '.PHP_EOL.' /*]]>*/ </script>' . PHP_EOL; ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.20/pagination/input.js"></script>


    <!--<script src="{{ asset( '/js/jquery.slimscroll.min.js' ) }}"></script>-->
    <!--<script src="{{ asset( '/js/jquery.maskedinput.min.js' ) }}"></script>-->
    <script src="{{ asset( '/js/app.core.js' ) }}"></script>
    <script src="{{ asset( '/js/basic-script.js' ) }}"></script><!-- Custom Script -->

    @include('includes.delete-modal')
    @include('includes.todo-modal')
    @include('includes.flash-message') <!-- Flash Message -->

    @yield('custom_js')

    <div id="" class="ui-layout-resizer ui-layout-resizer-right ui-layout-resizer-open ui-layout-resizer-right-open" aria-disabled="true" title="Slide Open" ><div id="" class="ui-layout-toggler ui-layout-toggler-west ui-layout-toggler-closed ui-layout-toggler-west-closed" title="Open" style="background: #CBE8F9; position: absolute; display: block; padding: 0px; margin: 0px; overflow: hidden; text-align: center; font-size: 1px; cursor: pointer; z-index: 1; visibility: visible; height: 50px; width: 6px; top: 230px; left: 0px;"></div></div>
    <div id="" class="ui-layout-resizer ui-layout-resizer-left ui-layout-resizer-open ui-layout-resizer-left-open" aria-disabled="true" title="Slide Open"><div id="" class="ui-layout-toggler ui-layout-toggler-east ui-layout-toggler-closed ui-layout-toggler-east-closed" title="Open" style="background: #CBE8F9; position: absolute; display: block; padding: 0px; margin: 0px; overflow: hidden; text-align: center; font-size: 1px; cursor: pointer; z-index: 1; visibility: visible; height: 50px; width: 6px; top: 230px; left: 0px;"></div></div>
    <div id="" class="ui-layout-resizer ui-layout-resizer-top ui-layout-resizer-closed ui-layout-resizer-top-closed ui-draggable-disabled"></div>
    <div id="" class="ui-layout-resizer ui-layout-resizer-bottom ui-layout-resizer-closed ui-layout-resizer-bottom-closed ui-draggable-disabled"></div>
</body>
</html>
