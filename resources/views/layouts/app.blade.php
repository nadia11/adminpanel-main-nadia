<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title>@yield('Login Form')</title>
    <!--<title>{ config('app.name', 'Laravel') }}</title>-->

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="Shortcut Icon" type="image/x-icon" href="{{ image_url('/favicon.png') }}" />
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('/login-assets/css/style-login.css') }}" />
</head>
<body>

    @yield('login_content')

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ asset('/login-assets/js/jquery.form.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/login-assets/js/jquery.modal.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/login-assets/js/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/login-assets/js/bootstrapvalidator.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/login-assets/js/jquery.backstretch.min.js') }}"></script>
    <!--<script type="text/javascript" src="{{ asset('/login-assets/js/jquery.placeholder.label.min.js') }}"></script>-->
    <script type="text/javascript" src="{{ asset('/login-assets/js/password-strength-meter.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/login-assets/js/login-script.js') }}"></script>

    <?php echo '<script type="text/javascript">/*<![CDATA[*/ '.PHP_EOL.'; var tits_project = {"url":"'. url('/') . '", "name":""}; '.PHP_EOL.' /*]]>*/ </script>' . PHP_EOL; ?>

    @yield('custom_js')
</body>
</html>
