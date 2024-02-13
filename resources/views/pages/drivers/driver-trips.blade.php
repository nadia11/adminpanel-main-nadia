@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInLeft">
        <div class="box-header with-border">
            <h2 class="box-title"><i class="fa fa-file-alt" aria-hidden="true"></i> Showing Driver Trips</h2>
            <div class="box-tools float-right">
                <div class="float-left" style="margin-right: 5px; width: 125px;">
                    <select id="driver_status_filter" class="custom-select custom-select-sm" onchange="filter_column(this.value, 'general_datatable', 11)">
                        <option value="">--Trip Status--</option>
                        <option value="active">Active Trip</option>
                        <option value="completed">Completed Trips</option>
                        <option value="cancelled">Cancelled Trips</option>
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
                    <th class="hide">Driver ID</th>
                    <th class="hide">Driver Mobile</th>
                    <th>Driver Name</th>
                    <th>Trip From</th>
                    <th>Trip To</th>
                    <th>Start Date & Time</th>
                    <th>End Date & Time</th>
                    <th>Distance</th>
                    <th>Fare</th>
                    <th>Status</th>
                    <th data-orderable="false" class="no-print">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($all_driver_trip_info as $trip)
                    @php $status_class = array('completed'=>'text-success', 'active'=>'text-info', 'booked'=>'text-warning', 'cancelled'=>"text-danger") @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $trip->trip_number }}</td>
                        <td class="hide">{{ $trip->driver_id }}</td>
                        <td class="hide">{{ $trip->driver_mobile }}</td>
                        <td><a href="{{ url('driver/all-drivers?driver_mobile='.$trip->driver_mobile)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Go to see Driver's details">{{ $trip->driver_name }}</a></td>
                        <td>{{ Illuminate\Support\Str::limit($trip->trip_from, 30, '...') }}</td>
                        <td>{{ Illuminate\Support\Str::limit($trip->trip_to, 30, '...') }}</td>
                        <td>{{ date('d/m/y h:s A', strtotime($trip->start_time)) }}</td>
                        <td>{{ date('d/m/y h:s A', strtotime($trip->end_time)) }}</td>
                        <td>{{ $trip->distance }}</td>
                        <td>{{ taka_format("", $trip->fare) }}</td>
                        <td class="{{ $status_class[$trip->trip_status] }} text-bold">{{ str_snack($trip->trip_status) }}</td>
                        <td style="white-space: nowrap; width:60px;">
                            <a class="btn btn-outline-primary" href="{{ url('rider-trip/trip-route/'.$trip->trip_number)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Go to see Driver's details"><i class="fad fa-map-marker-alt fa-lg" aria-hidden="true"></i> View Route</a>
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

