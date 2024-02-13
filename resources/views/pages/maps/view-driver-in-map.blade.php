@extends('dashboard')
@section('main_content')

    <section class="content">
        <div class="box box-success animated fadeInLeft">
            <div class="box-header with-border">
                <h2 class="box-title"><i class="fad fa-steering-wheel text-danger" aria-hidden="true"></i> Driver Detail</h2>

                <div class="box-tools float-right">
                    <button type="button" class="btn btn-sm btn-outline-primary" id="refresh" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-sync-alt"></i> Reload</button>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->

            <div class="box-body">
                <table class="table table-bordered table-verticle">
                    <tr>
                        <th style="width: 15%;">Driver Name</th>
                        <td style="width: 1px;">:</td>
                        <td><a href="{{ url('driver/all-drivers?driver_mobile='.$driver_info->driver_mobile)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Go to see Drivers's details">{{ $driver_info->driver_name }}</a></td>

                        <th style="width: 15%;">Vehicle Type</th>
                        <td style="width: 1px;">:</td>
                        <td><a href="{{ url('vehicle/vehicle-management?vehicle_type='.$driver_info->vehicle_type)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Go to see Vehicle's details">{{ str_snack($driver_info->vehicle_type) ?? "-" }}</a></td>
                    </tr>
                    <tr>
                    </tr>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->


        <div class="box box-success animated fadeInLeft">
            <div class="box-header with-border">
                <h2 class="box-title"><i class="fad fa-steering-wheel text-danger" aria-hidden="true"></i> Route</h2>

                <div class="box-tools float-right">
                    <button type="button" class="btn btn-sm btn-outline-primary" id="refresh" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-sync-alt"></i> Reload</button>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->

            <div class="box-body">
                <div class="mapouter">
                    <div id="googleMap" style="margin: 0 auto 20px; overflow: hidden; background: none!important; width: 100%;" class="gmap_canvas"></div>
                    <style>.mapouter{position:relative;text-align:right;height:480px;width:100%;}.gmap_canvas {overflow:hidden;background:none!important;height:480px;width:1000px;}</style>
                </div>
            </div><!-- /.box-body -->

            <div class="overlay" style="display: none;">
                <i class="fa fa-sync-alt fa-spin"></i>
            </div>
        </div><!-- /.box -->
    </section>
@endsection

@section('custom_js')
    <script type="text/javascript">
        /*<![CDATA[*/
        var gmap_info = {
            "ajax_url":"{{ url('/') }}",
            "site_name":"{{ config('app.name') }}",
            {{--'origin_lat': "{{ $driver_info->origin_lat }}",--}}
            {{--'origin_long': "{{ $driver_info->origin_long }}",--}}
            {{--'destination_lat': "{{ $driver_info->destination_lat }}",--}}
            {{--'destination_long': "{{ $driver_info->destination_long }}",--}}
            {{--'from': "{{ $driver_info->trip_from }}",--}}
            {{--'trip_to': "{{ $driver_info->trip_to }}",--}}
            "start_icon": "{{ image_url('/start_marker.png') }}",
            "end_icon": "{{ image_url('/end_marker.png') }}",
        }
        /*]]>*/
    </script>

    <script src="{{ asset( '/js/view-trip-route-google-maps.js' ) }}"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('app.GOOGLE_MAPS_API_KEY') }}&callback=viewInMapInit"></script>

    <script type="text/javascript">
        $(document).ready(function(){

        });
    </script>
@endsection
