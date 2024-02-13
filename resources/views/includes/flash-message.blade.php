{{--<div class="container-fluid">--}}
    {{--<div class="flash-message-wrapper">--}}
        {{--@if (Session::has('success'))--}}
        {{--<div class="alert alert-success alert-block alert-dismissible fade show" role="alert">--}}
            {{--<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button>--}}
            {{--<strong>{{ Session::get('success') }}</strong>--}}
        {{--</div>--}}
        {{--@endif--}}

        {{--@if (Session::has('error'))--}}
        {{--<div class="alert alert-danger alert-block alert-dismissible fade show" role="alert">--}}
            {{--<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button>	--}}
            {{--<strong>{{ Session::get('error') }}</strong>--}}
        {{--</div>--}}
        {{--@endif--}}

        {{--@if (Session::has('warning'))--}}
        {{--<div class="alert alert-warning alert-block alert-dismissible fade show" role="alert">--}}
            {{--<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button>	--}}
            {{--<strong>{{ Session::get('warning') }}</strong>--}}
            {{--<!--<h4 class="alert-heading">Success!</h4>--}}
            {{--<strong>Success!</strong> You should <a href="#" class="alert-link">read this message</a>-->--}}
        {{--</div>--}}
        {{--@endif--}}

        {{--@if (Session::has('info'))--}}
        {{--<div class="alert alert-info alert-block alert-dismissible fade show" role="alert">--}}
            {{--<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button>	--}}
            {{--<strong>{{ Session::get('info') }}</strong>--}}
        {{--</div>--}}
        {{--@endif--}}

        {{--@if ($errors->any())--}}
        {{--<div class="alert alert-danger alert-dismissible fade show" role="alert">--}}
            {{--<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button>	--}}
            {{--Please check the form below for errors--}}
            {{--<ul>--}}
                {{--@foreach ($errors->all() as $error)--}}
                    {{--<li>{{ $error }}</li>--}}
                {{--@endforeach--}}
            {{--</ul>--}}
        {{--</div>--}}
        {{--@endif--}}

        {{--@if ($message = Session::get('confirmation-success'))--}}
        {{--<div class="alert alert-success alert-block alert-dismissible fade show" role="alert">--}}
            {{--<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button>--}}
            {{--<strong>{{ $message }}</strong>--}}
        {{--</div>--}}
        {{--@endif--}}

        {{--@if ($message = Session::get('confirmation-danger'))--}}
        {{--<div class="alert alert-danger alert-block alert-dismissible fade show" role="alert">--}}
            {{--<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button>--}}
            {{--<strong>{{ $message }}</strong>--}}
        {{--</div>--}}
        {{--@endif--}}
    {{--</div>--}}
{{--</div>--}}


<!--http://codeseven.github.io/toastr/demo.html-->
<script type="text/javascript">
    var toastrOption = {
        "closeButton": true, "progressBar": true, "positionClass": "toast-top-right", "preventDuplicates": true,
        "showDuration": "300", "hideDuration": "1000", "timeOut": "5000", "extendedTimeOut": "1000",
        "showEasing": "swing", "hideEasing": "linear", "showMethod": "fadeIn", "hideMethod": "fadeOut"
    }
    @if(Session::has('success'))
        toastr.success("{{ Session::get('success') }}", "Success! ", toastrOption);
    @endif

    @if(Session::has('info'))
        toastr.info("{{ Session::get('info') }}", "Info! ", toastrOption);
    @endif

    @if(Session::has('warning'))
        toastr.warning("{{ Session::get('warning') }}", "Warning! ", toastrOption);
    @endif

    @if(Session::has('error'))
        toastr.error("{{ Session::get('error') }}", "Error! ", toastrOption);
    @endif




    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
            toastr.info("{{ Session::get('message') }}", "Info! ", toastrOption);
            break;

        case 'warning':
            toastr.warning("{{ Session::get('message') }}", "Warning! ", toastrOption);
            break;

        case 'success':
            toastr.success("{{ Session::get('message') }}", "Success! ", toastrOption);
            break;

        case 'error':
            toastr.error("{{ Session::get('message') }}", "Error! ", toastrOption);
            break;
    }
    @endif
</script>
