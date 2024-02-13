@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInLeft">
        <div class="box-header with-border">
            <h2 class="box-title"><i class="fad fa-steering-wheel text-danger" aria-hidden="true"></i> Route Detail</h2>

            <div class="box-tools float-right">
                <button type="button" class="btn btn-sm btn-outline-primary" id="refresh" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-sync-alt"></i> Reload</button>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->

        <div class="box-body">
            <table class="table table-bordered table-verticle">
                <tr>
                    <th style="width: 15%;">Rider Name</th>
                    <td style="width: 1px;">:</td>
                    <td><a href="{{ url('rider/all-riders?rider_mobile='.$rider_trip_info->rider_mobile)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Go to see Riders's details">{{ $rider_trip_info->rider_name }}</a></td>

                    <th>Trip Number</th>
                    <td>:</td>
                    <td>{{ $rider_trip_info->trip_number }}</td>
                </tr>
                <tr>
                    <th style="width: 15%;">Driver Name</th>
                    <td style="width: 1px;">:</td>
                    <td><a href="{{ url('driver/all-drivers?driver_mobile='.$rider_trip_info->driver_mobile)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Go to see Driver's details">{{ $rider_trip_info->driver_name }}</a></td>

                    <th>Vehicle Type</th>
                    <td>:</td>
                    <td><a href="{{ url('vehicle/vehicle-management?vehicle_reg_number='.$rider_trip_info->vehicle_reg_number)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Go to see Vehicle's details">{{ str_snack($rider_trip_info->vehicle_type) ?? "-" }}</a></td>
                </tr>
                <tr>
                    <th>Trip From</th>
                    <td>:</td>
                    <td>{{ $rider_trip_info->trip_from }}</td>

                    <th>Trip To</th>
                    <td>:</td>
                    <td>{{ $rider_trip_info->trip_to }}</td>
                </tr>
                <tr>
                    <th>Start Time</th>
                    <td>:</td>
                    <td>{{ date('d.m.Y h:i:s A', strtotime($rider_trip_info->start_time)) }}</td>

                    <th>End Time</th>
                    <td>:</td>
                    <td>{{ date('d.m.Y h:i:s A', strtotime($rider_trip_info->end_time)) }}</td>
                </tr>
                <tr>
                    <th>Distance</th>
                    <td>:</td>
                    <td>{{ $rider_trip_info->distance }} KM</td>
                    <th>Duration</th>
                    <td>:</td>
                    <td>{{ $rider_trip_info->duration }} Min</td>
                </tr>
                <tr>
                    <th>Trip Status</th>
                    <td>:</td>
                    <td>{{ str_snack($rider_trip_info->trip_status) }}</td>
                    <th>Reason for Cancellation</th>
                    <td>:</td>
                    <td>{{ $rider_trip_info->reason_for_cancellation }}</td>
                </tr>
                <tr>
                    <th>Cancelled By</th>
                    <td>:</td>
                    <td>{{ $rider_trip_info->cancelled_by }}</td>=
                    <th>Cancelled Time</th>
                    <td>:</td>
                    <td>{{ $rider_trip_info->cancellation_time }}</td>
                </tr>
                <tr>
                    <th>Delay Cancellation Time (in Minutes)</th>
                    <td>:</td>
                    <td>{{ $rider_trip_info->delay_cancellation_time ?? 0 }} Minutes</td>
                    <th>Delay Cancellation Fee</th>
                    <td>:</td>
                    <td>{{ taka_format("", $rider_trip_info->delay_cancellation_fee) }}</td>
                </tr>
                <tr>
                    <th>Destination Change Time</th>
                    <td>:</td>
                    <td>{{ date('d.m.Y h:i:s A', strtotime($rider_trip_info->destination_change_time)) }}</td>
                    <th>Destination Change Fee</th>
                    <td>:</td>
                    <td>{{ taka_format("", $rider_trip_info->destination_change_fee) }}</td>
                </tr>
                <tr>
                    <th>Rider Ratings & Feedback</th>
                    <td>:</td>
                    <td>----</td>
                    <th>Driver Ratings & Feedback</th>
                    <td>:</td>
                    <td>------</td>
                </tr>
                <tr>
                    <th>Promo Code (if any)</th>
                    <td>:</td>
                    <td>000</td>
                    <th>Promo Amount</th>
                    <td>:</td>
                    <td>{{ taka_format("৳ ", '') }}</td>
                </tr>
                <tr>
                    <th>Payment Method</th>
                    <td>:</td>
                    <td>{{ str_snack($rider_trip_info->payment_method) }}</td>
                    <th>Fare</th>
                    <td>:</td>
                    <td>{{ taka_format("৳ ", $rider_trip_info->fare) }}</td>
                </tr>
                <tr>
                    <th>Payment Amount</th>
                    <td>:</td>
                    <td>{{ taka_format("", $rider_trip_info->payment_amount) }}</td>
                    <th>Payment Status</th>
                    <td>:</td>
                    <td>{{ $rider_trip_info->payment_status ? str_snack($rider_trip_info->payment_status) : "-" }}</td>
                </tr>
            </table>
        </div><!-- /.box-body -->
    </div><!-- /.box -->

    <div class="box box-success animated fadeInLeft">
        <div class="box-header with-border">
            <h2 class="box-title"><i class="fad fa-shoe-prints text-primary" aria-hidden="true"></i> Driver Trip Steps</h2>
        </div><!-- /.box-header -->

        <div class="box-body">
            <table class="table table-custom table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Step Name</th>
                        <th>Specification</th>
                        <th>Location Name</th>
                        <th>LatLong</th>
                    </tr>
                </thead>
                <tbody>
                @php $steps_data = DB::table('driver_trip_steps')->where('trip_number', $rider_trip_info->trip_number)->orderBy('created_at', 'ASC')->get() @endphp
                @foreach($steps_data as $step)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $step->step_name }}</td>
                        <td>{{ $step->specification }}</td>
                        <td>{{ $step->location_name }}</td>
                        <td>{{ $step->latitude .",". $step->longitude }}</td>
                    </tr>
                @endforeach
                @if (count($steps_data) < 1) <tr><td class="py-5 text-center" colspan="5">No Items Found</td></tr> @endif
                </tbody>
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
            'origin_lat': "{{ $rider_trip_info->origin_lat }}",
            'origin_long': "{{ $rider_trip_info->origin_long }}",
            'destination_lat': "{{ $rider_trip_info->destination_lat }}",
            'destination_long': "{{ $rider_trip_info->destination_long }}",
            'trip_from': "{{ $rider_trip_info->trip_from }}",
            'trip_to': "{{ $rider_trip_info->trip_to }}",
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
