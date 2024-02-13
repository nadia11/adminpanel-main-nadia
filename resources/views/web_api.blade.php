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
    <script>paceOptions = { ajax: true, document: true, eventLag: false }; Pace.on('done', function(){ $('#preloader').delay(0).fadeOut(300); });</script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
{{--    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css">--}}
    <link rel="stylesheet" href="https://kit-pro.fontawesome.com/releases/v5.12.0/css/pro.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.6/css/fixedHeader.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.bootstrap4.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/node-waves/0.7.6/waves.min.css">


    <link rel="stylesheet" href="{{ asset( '/css/select2-bootstrap4.min.css' ) }}">
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">-->
    <link rel="stylesheet" href="{{ asset( '/css/animate-custom.min.css' ) }}">
    <link rel="stylesheet" href="{{ asset( '/frontend/css/frontend.css' ) }}"><!--  Theme style -->

    @yield('custom_web_api_css')
</head>
<body class="hold-transition">
    <div id="preloader"><div class="double-bounce1"></div><div class="double-bounce2"></div></div>

    <div class="wrapper" id="main_content">
        @yield('main_content')
    </div><!-- ./Main Content -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/node-waves/0.7.6/waves.min.js"></script><!-- Button Effect -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.20/pagination/input.js"></script>

    <script type="text/javascript" src="{{ asset('/frontend/js/jquery.backstretch.min.js') }}"></script>
    <script src="{{ asset( '/frontend/js/frontend-script.js' ) }}"></script>
    <?php echo '<script type="text/javascript">/*<![CDATA[*/ '.PHP_EOL.'; var tits_project = {"url":"'. url('/') . '", "name":"'. config('app.name') . '"}; '.PHP_EOL.' /*]]>*/ </script>' . PHP_EOL; ?>

    @include('includes.flash-message') <!-- Flash Message -->
    @yield('custom_web_api_js')
</body>
</html>
