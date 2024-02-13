@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInLeft">
        <div class="box-header with-border">
            <h2 class="box-title"><i class="fa fa-file-alt" aria-hidden="true"></i> Showing All Rider Trips</h2>
            <div class="box-tools float-right">
                <div class="float-left" style="margin-right: 5px; width: 125px;">
                    <select id="rider_trip_status_filter" class="custom-select custom-select-sm custom-filtered-color" onchange="window.document.location.href=this.options[this.selectedIndex].value;">
                        <option value="{{ url('/rider-trip/rider-all-trips') }}">--Rider Trip Status--</option>
                        <option value="active-rider-trips" {{ last(request()->segments())=='active-rider-trips'?"selected":"" }}>On Trips</option>
                        <option value="completed-rider-trips" {{ last(request()->segments())=='completed-rider-trips'?"selected":"" }}>Completed Trips</option>
                        <option value="cancelled-rider-trips" {{ last(request()->segments())=='cancelled-rider-trips'?"selected":"" }}>Cancelled Trips</option>
                        <option value="booked-rider-trips" {{ last(request()->segments())=='booked-rider-trips'?"selected":"" }}>Booked Trips</option>
                        <option value="rating-pending-rider-trips" {{ last(request()->segments())=='rating-pending-rider-trips'?"selected":"" }}>Rating Pending</option>
                    </select>
                </div>
                <button type="button" class="btn btn-box-tool" id="refresh" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-sync-alt"></i></button>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->

        <div class="box-body">
            <table id="general_datatable" class="table table-custom table-center">
                <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        <th>Trip Number</th>
                        <th>Driver Name</th>
                        <th>Trip From</th>
                        <th>Trip To</th>
                        <th style="width: 70px;">Start Date & Time</th>
                        <th style="width: 70px;">End Date & Time</th>
                        <th>Distance</th>
                        <th>Fare</th>
                        <th>Status</th>
                        <th class="hide">Rider ID</th>
                        <th class="hide">Rider Mobile</th>
                        <th class="hide">Today's Trip Filter</th>
                        <th class="hide">This Month Trip Filter</th>
                        <th data-orderable="false" class="no-print">Action</th>
                    </tr>
                </thead>
                <tbody>
                @php $status_class = array('completed'=>'text-success', 'active'=>'text-info', 'ride_request'=> 'text-primary', 'booked'=>'text-warning', 'cancelled'=>"text-danger") @endphp
                @foreach($all_rider_trip_info as $trip)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $trip->trip_number }}</td>
                        <td>@if($trip->driver_name)<a href="{{ url('driver/all-drivers?driver_mobile='.$trip->driver_mobile)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Go to see Driver's details">{{ $trip->driver_name }}</a>@else - @endif</td>
                        <td>{{ Illuminate\Support\Str::limit($trip->trip_from, 30, '...') }}</td>
                        <td>{{ Illuminate\Support\Str::limit($trip->trip_to, 30, '...') }}</td>
                        <td>{{ date('d.m.y', strtotime($trip->start_time)) }} <br /> {{ date('h:s A', strtotime($trip->start_time)) }}</td>
                        <td>{{ date('d.m.y', strtotime($trip->end_time)) }} <br /> {{ date('h:s A', strtotime($trip->end_time)) }}</td>
                        <td>{{ $trip->distance }}</td>
                        <td>{{ $trip->fare ? taka_format('', $trip->fare) : "0.00" }}</td>
                        <td class="{{ $status_class[$trip->trip_status] }}">{{ str_snack($trip->trip_status) }}</td>
                        <td class="hide">{{ $trip->rider_id }}</td>
                        <td class="hide">{{ $trip->rider_mobile }}</td>
                        <td class="hide">{{ date('d/m/Y', strtotime($trip->start_time)) }}</td>
                        <td class="hide">{{ date('m/Y', strtotime($trip->start_time)) }}</td>
                        <td style="white-space: nowrap; width:60px;">
                            <a class="btn btn-outline-danger" href="{{ url('rider-trip/trip-route/'.$trip->trip_number) }}" data-toggle="tooltip" data-placement="top" title="Go to see Driver's details"><i class="fad fa-map-marker-alt fa-lg" aria-hidden="true"></i> View Route</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div><!-- /.box-body -->

        <div class="overlay" style="display: none;">
            <i class="fa fa-sync-alt fa-spin"></i>
        </div>
    </div><!-- /.box -->
</section>

@endsection


@section('custom_js')
<script type="text/javascript">
$(document).ready(function(){

}); //End of Document ready
</script>
@endsection

