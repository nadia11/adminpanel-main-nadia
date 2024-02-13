@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInLeft">
        <div class="box-header with-border">
            <h2 class="box-title"><i class="fad fa-steering-wheel text-danger" aria-hidden="true"></i> Live Vehicle Tracking == Today: {{ date("D, d M-Y") }}</h2>

            <div class="box-tools float-right">
                <div class="float-left" style="margin-right: 5px; width: 120px;">
                    <select id="division_filter" class="custom-select custom-select-sm" onchange="filter_column(this.value, 'general_datatable', 1)">
                        <option value="0" selected="selected">--Select Division--</option>
                        @php $divisions = DB::table('divisions')->orderBy('division_name', 'ASC')->pluck("division_name", "division_id") @endphp
                        @foreach( $divisions as $key => $division )
                            <option value="{{ $division }}">{{ $division }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="float-left district_filter_loader" style="margin-right: 5px; width: 115px; position: relative;">
                    <select id="district_filter" class="custom-select custom-select-sm" onchange="filter_column(this.value, 'general_datatable', 2)">
                        <option value="0">--Select District--</option>
                        @php $districts = DB::table("districts")->select("district_name", "district_id")->orderBy('district_name', 'ASC')->pluck("district_name", 'district_id'); @endphp
                        @foreach( $districts as $key => $district )
                            <option value="{{ $district }}">{{ $district }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="float-left branch_filter_loader" style="margin-right: 5px; width: 115px; position: relative;">
                    <select id="branch_filter" class="custom-select custom-select-sm" onchange="filter_column(this.value, 'general_datatable', 2)">
                        <option value="0">--Select Branch--</option>
                        @php $branches = DB::table("branches")->select("branch_name", "branch_id")->orderBy('branch_name', 'ASC')->pluck("branch_name", 'branch_id'); @endphp
                        @foreach( $branches as $key => $branch )
                            <option value="{{ $branch }}">{{ $branch }}</option>
                        @endforeach
                    </select>
                </div>

                {{--<div style="margin: 0 5px; width: 100px;" class="float-left culumn_search_wrap">--}}
                {{--    <input type="text" class="form-control form-control-sm" id="culumn_search" onkeyup="filter_column_serverside(this.value, 'live_tracking_datatable')" placeholder="Driver Mobile" />--}}
                {{--</div>--}}

                {{--<div style="margin: 0 5px; width: 100px;" class="float-left culumn_search_wrap">--}}
                {{--    <input type="text" class="form-control form-control-sm" id="culumn_search" onkeyup="filter_column_serverside(this.value, 'live_tracking_datatable')" placeholder="Driver Name" />--}}
                {{--</div>--}}

                {{--<button type="button" class="btn btn-sm btn-danger btn-square" id="filter_idle_drivers"><i class="fa fa-lg fa-car"></i> IDLE</button>--}}
                {{--<button type="button" class="btn btn-sm btn-danger btn-square" id="refresh_marker"><i class="fa fa-lg fa-car"></i> Refresh Marker</button>--}}
                <button type="button" class="btn btn-sm btn-danger btn-square" id="filter_online_drivers"><i class="fa fa-lg fa-car"></i> ONLINE</button>
                <button type="button" class="btn btn-sm btn-success btn-square" id="filter_ontrip_drivers"><i class="fa fa-lg fa-car"></i> ON TRIP</button>
                <button type="button" class="btn btn-sm btn-outline-primary" id="refresh" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-sync-alt"></i> Reload</button>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="row">
                <div class="col-3">
                    <table class="table table-custom" style="margin-bottom: 0;">
                        <thead style="background: dodgerblue;color: #fff;">
                            <tr>
                                <th>#</th>
                                <th>Trip Number</th>
                                <th>Active Driver</th>
                            </tr>
                        </thead>
                    </table>

                    <div class="custom-scroll" style="max-height: 410px; border-bottom: 2px solid #eee;">
                        <table id="drivers_table" class="table table-custom">
                            <tbody>
                            <?php $drivers = DB::table('rider_trips')
                                ->leftjoin('drivers', 'rider_trips.driver_id', '=', 'drivers.driver_id')
                                ->select('rider_trips.trip_number', 'drivers.driver_name', 'drivers.mobile as driver_mobile', 'drivers.latitude', 'drivers.longitude', 'drivers.driver_status')
                                ->whereDate('start_time', date('Y-m-d'))->orderBy('start_time', 'DESC')->get(); ?>

                            @foreach($drivers as $driver)
                            <tr class="{{ $driver->driver_status }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $driver->trip_number }}</td>
                                <td class="text-right"><a href="#" class="viewDriverInMap" data-loop_count="{{ $loop->iteration }}" id="TR{{ $driver->trip_number }}" data-latitude="{{ $driver->latitude }}" data-longitude="{{ $driver->longitude }}">{{ $driver->driver_name ?? "Not Assigned." }}</a> <i class="far fa-map-marker text-danger"></i></td>
                            </tr>
                            @endforeach

                            @if(DB::table('rider_trips')->whereDate('start_time', date('Y-m-d'))->doesntExist())
                                <tr><td colspan="3" style="text-align: center; font-size: 16px;">No Trip Data found.</td></tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-9">
                    <div class="mapouter">
                        <div id="googleMap" style="margin: 0 auto 20px; overflow: hidden; background: none!important; height: 420px; width: 100%;" class="gmap_canvas"></div>
                        <style>.mapouter{position:relative;text-align:right;height:480px;width:100%;}.gmap_canvas {overflow:hidden;background:none!important;height:470px;width:1000px;}</style>

                        <div class="map-callout-wrap">
                            <div class="map-callout">
                                <a href="{{ url('/rider-trip/rider-all-trips?trip_date='.date('d/m/Y')) }}" class="btn-effect" target="_blank">
                                    <span class="callout-icon text-info"><i class="fa fa-suitcase-rolling" aria-hidden="true"></i></span>
                                    <div class="callout-content">
                                        <span class="callout-number">{{ DB::table('rider_trips')->whereDate('start_time', date('Y-m-d'))->count() }}</span>
                                        <span class="callout-title">Total Trips</span>
                                    </div>
                                </a>
                            </div><!-- ./ map-callout -->

                            <div class="map-callout">
                                <a href="{{ url('/rider-trip/active-rider-trips?trip_date='.date('d/m/Y')) }}" class="btn-effect" target="_blank">
                                    <span class="callout-icon text-warning"><i class="fad fa-running" aria-hidden="true"></i></span>
                                    <div class="callout-content">
                                        <span class="callout-number">{{ DB::table('rider_trips')->where('trip_status', 'on_trip')->whereDate('start_time', date('Y-m-d'))->count() }}</span>
                                        <span class="callout-title">Active Trips</span>
                                    </div>
                                </a>
                            </div><!-- ./ map-callout -->

                            <div class="map-callout">
                                <a href="#" class="btn-effect" target="_blank">
                                    <span class="callout-icon text-primary"><i class="fa fa-car" aria-hidden="true"></i></span>
                                    <div class="callout-content">
                                        <span class="callout-number">{{ DB::table('drivers')->where('approval_status', 'approved')->whereIn('driver_status', ['online', 'on_trip'])->count() }}</span>
                                        <span class="callout-title">Available Vehicle</span>
                                    </div>
                                </a>
                            </div><!-- ./ map-callout -->

                            <div class="map-callout">
                                <a href="{{ url('/rider-trip/completed-rider-trips?trip_date='.date('d/m/Y')) }}" class="btn-effect" target="_blank">
                                    <span class="callout-icon"><i class="fa fa-biking" aria-hidden="true"></i></span>
                                    <div class="callout-content">
                                        <span class="callout-number">{{ DB::table('rider_trips')->where('trip_status', 'completed')->whereDate('start_time', date('Y-m-d'))->count() }}</span>
                                        <span class="callout-title">Completed Trips</span>
                                    </div>
                                </a>
                            </div><!-- ./ map-callout -->

                            <div class="map-callout">
                                <a href="{{ url('/rider-trip/cancelled-rider-trips?trip_date='.date('d/m/Y')) }}" class="btn-effect" target="_blank">
                                    <span class="callout-icon text-danger"><i class="far fa-address-card" aria-hidden="true"></i></span>
                                    <div class="callout-content">
                                        <span class="callout-number">{{ DB::table('rider_trips')->where('trip_status', 'cancelled')->whereDate('start_time', date('Y-m-d'))->count() }}</span>
                                        <span class="callout-title">Cancelled by Rider</span>
                                    </div>
                                </a>
                            </div><!-- ./ map-callout -->

                            <div class="map-callout">
                                <a href="{{ url('/driver/trip/driver-cancelled-trip?trip_date='.date('d/m/Y')) }}" class="btn-effect" target="_blank">
                                    <span class="callout-icon text-danger"><i class="fa fa-biking" aria-hidden="true"></i></span>
                                    <div class="callout-content">
                                        <span class="callout-number">{{ DB::table('driver_trips')->where('trip_status', 'cancelled')->whereDate('start_time', date('Y-m-d'))->count() }}</span>
                                        <span class="callout-title">Cancelled by Driver</span>
                                    </div>
                                </a>
                            </div><!-- ./ map-callout -->
                        </div>
                    </div>
                </div>
            </div>

            @php $status_class = array('completed'=>'text-success', 'active'=>'text-info', 'ride_request'=>'text-warning', 'cancelled'=>"text-danger") @endphp
            <?php $rider_trip_info = DB::table('rider_trips')
                ->leftjoin('drivers', 'rider_trips.driver_id', '=', 'drivers.driver_id')
                ->leftjoin('riders', 'rider_trips.rider_id', '=', 'riders.rider_id')
                ->leftjoin('vehicles', 'rider_trips.vehicle_id', '=', 'vehicles.vehicle_id')
                ->leftjoin('vehicle_types', 'vehicles.vehicle_type_id', '=', 'vehicle_types.vehicle_type_id')
                ->select('rider_trips.*', 'drivers.driver_name', 'drivers.mobile as driver_mobile', 'riders.rider_name', 'riders.mobile as rider_mobile', 'vehicle_types.vehicle_type_id', 'vehicle_types.vehicle_type' )
                ->whereDate('start_time', date('Y-m-d'))
                ->orderBy('start_time', 'DESC')->get(); ?>

            <div class="col-12">
            <table id="live_tracking_datatable" class="table table-custom table-center">
                <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        <th>Trip Number</th>
                        <th>Rider</th>
                        <th>Driver</th>
                        <th>Vehicle</th>
                        <th>Trip From</th>
                        <th>Trip To</th>
                        <th>Trip Time</th>
                        <th>Distance</th>
                        <th>Fare</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th data-orderable="false" class="no-print">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($rider_trip_info as $trip)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $trip->trip_number }}</td>
                        <td><a href="{{ url('rider/all-riders?rider_mobile='.$trip->rider_mobile)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Go to see Riders's details">{{ $trip->rider_name }}</a></td>
                        <td>@if($trip->driver_mobile)<a href="{{ url('driver/all-drivers?driver_mobile='.$trip->driver_mobile)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Go to see Driver's details">{{ $trip->driver_name ?? "." }}</a>@else Not Assigned @endif</td>
                        <td>@if($trip->vehicle_type_id)<a href="{{ url('vehicle/vehicle-management?vehicle_type_id='.$trip->vehicle_type_id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Go to see Vehicle's details">{{ $trip->vehicle_type ?? "-" }}</a>@else - @endif</td>
                        <td>{{ $trip->trip_from }}</td>
                        <td>{{ $trip->trip_to }}</td>
                        <td>{{ date('h:i A', strtotime($trip->start_time)) }} - {{ date('h:i A', strtotime($trip->end_time)) }}</td>
                        <td>{{ $trip->distance }}</td>
                        <td>{{ taka_format("", $trip->fare) }}</td>
                        <td>
                            <p>{{ taka_format("", $trip->payment_amount) }}</p>
                            <span class="text-danger">{{ $trip->payment_status ?? "Not Paid" }}</span>
                            <p class="text-success">Via: {{ $trip->payment_method ?? "-" }}</p>
                        </td>
                        <td class="{{ $status_class[$trip->trip_status] }}">{{ str_snack($trip->trip_status) }}</td>
                        <td style="white-space: nowrap; width:60px;">
                            <a class="btn btn-outline-primary btn-sm" href="{{ url('rider-trip/rider-trip-route/'.$trip->rider_trip_id) }}" target="_blank" data-toggle="tooltip" data-placement="top" title="Go to see View Route's details"><i class="fad fa-map-marker-alt fa-lg" aria-hidden="true"></i> View Route</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
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
        "upload_url":"{{ upload_url() }}",
        "image_url":"{{ image_url() }}",
        "site_name":"{{ config('app.name') }}",
        'maps_icon': "{{ asset('/images/map-marker.png') }}",
        'gmap_latitude': 23.713444,
        'gmap_longitude': 90.4702305,
        "driver_markers": <?php echo $driver_markers; ?>
    }
    /*]]>*/
</script>

<script src="{{ asset( '/js/google-maps.js' ) }}" type="text/javascript"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('app.GOOGLE_MAPS_API_KEY') }}&sensor=false&callback=liveTrackingMapInit" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function(){
    $('#live_tracking_datatable').DataTable( {
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "pageLength": 5,
        "autoWidth": false
    });
});
</script>
@endsection

