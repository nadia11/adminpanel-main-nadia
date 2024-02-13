@extends('dashboard')
@section('main_content')

<!-- Main content -->
<div class="content-wrapper" style="padding: 5px 15px; overflow: visible;">
    <section>
        @include('includes.widget-info-box')
        @include('includes.widget-divisionwise-summery')
        @include('includes.widget-svg-map')
    </section><!-- /.content -->
</div>
@endsection
