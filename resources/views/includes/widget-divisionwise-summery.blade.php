<div class="row">
    <div class="col-md-12">
        <div class="box box-info" style="max-height: 475px;">
            <div class="box-header with-border">
                <h3 class="box-title">Division Wise Summery</h3>
                <div class="box-tools float-right">
                    <button type="button" class="btn btn-box-tool" id="refresh" data-widget="Refresh" data-toggle="tooltip" title="Refresh"><i class="fa fa-sync-alt"></i></button>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <table id="divisionwise_member_summery" class="table table-center" style="height: 415px;">
                    <thead class="table-info">
                        <tr>
                            <th>#</th>
                            <th>Division Name</th>
                            <th>Bike</th>
                            <th>Car</th>
                            <th>Micro</th>
                            <th>Pickup</th>
                            <th>Ambulance</th>
                            <th>Total Vehicle</th>
                            <th>Total Drivers</th>
                            <th>Total Riders</th>
                            <th>Total Agents</th>
                            <th>Total Agency Earnings</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php $divisions = DB::table('divisions')->orderBy('Division_name', "ASC")->get() @endphp

                    @foreach($divisions as $division)
                        @php $bike_qty = get_division_wise_vehicle_count($division->division_id, 'Bike') @endphp
                        @php $car_qty = get_division_wise_vehicle_count($division->division_id, 'Car') @endphp
                        @php $micro_qty = get_division_wise_vehicle_count($division->division_id, 'Micro') @endphp
                        @php $pickup_qty = get_division_wise_vehicle_count($division->division_id, 'Pickup') @endphp
                        @php $ambulance_qty = get_division_wise_vehicle_count($division->division_id, 'Ambulance') @endphp
                        @php $total_vehicle = get_division_wise_vehicle_count($division->division_id) @endphp
                        @php $driver_qty = DB::table('drivers')->where('division_id', $division->division_id)->COUNT() @endphp
                        @php $rider_qty = DB::table('riders')->where('division_id', $division->division_id)->COUNT() @endphp
                        @php $agent_qty = DB::table('agents')->where('division_id', $division->division_id)->COUNT() @endphp
                        @php $agent_earnings = DB::table('agents')->where('division_id', $division->division_id)->where('agent_status', 'active')->SUM('total_earnings') @endphp
                        @php $total_earnings = DB::table('agents')->where('agent_status', 'active')->SUM('total_earnings') @endphp

                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-left">{{ $division->division_name }} Division</td>
                            <td>@if($bike_qty)<a href="{{ url('vehicle/vehicle-management?division_id='.$division->division_id."&vehicle_type=Bike") }}" target="_blank">{{ $bike_qty }}</a>@else - @endif</td>
                            <td>@if($car_qty)<a href="{{ url('vehicle/vehicle-management?division_id='.$division->division_id."&vehicle_type=Car") }}" target="_blank">{{ $car_qty }}</a>@else - @endif</td>
                            <td>@if($micro_qty)<a href="{{ url('vehicle/vehicle-management?division_id='.$division->division_id."&vehicle_type=Micro") }}" target="_blank">{{ $micro_qty }}</a>@else - @endif</td>
                            <td>@if($pickup_qty)<a href="{{ url('vehicle/vehicle-management?division_id='.$division->division_id."&vehicle_type=Pickup") }}" target="_blank">{{ $pickup_qty }}</a>@else - @endif</td>
                            <td>@if($ambulance_qty)<a href="{{ url('vehicle/vehicle-management?division_id='.$division->division_id."&vehicle_type=Ambulance") }}" target="_blank">{{ $ambulance_qty }}</a>@else - @endif</td>
                            <td>@if($total_vehicle)<a href="{{ url('vehicle/vehicle-management?division_id='.$division->division_id) }}" target="_blank">{{ $total_vehicle }}</a>@else - @endif</td>

                            <td>@if($driver_qty)<a href="{{ url('driver/all-drivers?division_id='.$division->division_id) }}" target="_blank">{{ $driver_qty }}</a>@else - @endif</td>
                            <td>@if($rider_qty)<a href="{{ url('rider/all-riders?division_id='.$division->division_id) }}" target="_blank">{{ $rider_qty }}</a>@else - @endif</td>
                            <td>@if($agent_qty)<a href="{{ url('agent/agent-management?division_id='.$division->division_id) }}" target="_blank">{{ $agent_qty }}</a>@else - @endif</td>
                            <td>{{ $agent_earnings ? taka_format('', $agent_earnings) : "0.00" }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="text-right" colspan="2">Total Qty.</th>
                            <th>{{ get_vehicle_count('Bike') ." Nos" }}</th>
                            <th>{{ get_vehicle_count('Car') ." Nos" }}</th>
                            <th>{{ get_vehicle_count('Micro') ." Nos" }}</th>
                            <th>{{ get_vehicle_count('Pickup') ." Nos" }}</th>
                            <th>{{ get_vehicle_count('Ambulance') ." Nos" }}</th>
                            <th>{{ get_vehicle_count() ." Nos" }}</th>
                            <th>{{ DB::table('drivers')->COUNT() ." Nos" }}</th>
                            <th>{{ DB::table('riders')->COUNT() ." Nos" }}</th>
                            <th>{{ DB::table('agents')->COUNT() ." Nos" }}</th>
                            <th>{{ $total_earnings ? taka_format('', $total_earnings) : "0.00" }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div><!-- /.box -->
    </div>
</div>
