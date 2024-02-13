@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInLeft">
        <div class="box-header with-border">
            <h2 class="box-title"><i class="fa fa-file-alt" aria-hidden="true"></i> Showing All Vehicle</h2>
            <div class="box-tools float-right">
                <div class="float-left" style="margin-right: 5px; width: 125px;">
                    <select id="vehicle_id" name="vehicle_id" class="custom-select">
                        <option value="" selected="selected">--Vehicle Type--</option>
                        @php $vehicles = DB::table('vehicle_types')->orderBy('vehicle_type', 'ASC')->pluck("vehicle_type", "vehicle_type_id") @endphp

                        @foreach( $vehicles as $key => $vehicle )
                            <option value="{{ $key }}">{{ str_snack($vehicle) }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="button" class="btn btn-box-tool" id="refresh" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-sync-alt"></i></button>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->

        <div class="box-body table-responsive">
            <table id="general_datatable" class="table table-custom">
                <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        <th>Vehicle Type</th>
                        <th>Seat Capacity</th>
                        <th >Division Name</th>
                        <th>Color</th>
                        <th>Vehicle Model</th>
                        <th>Reg. Number</th>
                        {{--<th>Tax Token</th>--}}
                        {{--<th>Tax Renewal Date</th>--}}
                        {{--<th>Insurance</th>--}}
                        {{--<th>Insurance Renewal Date</th>--}}
                        {{--<th>Fitness Certificate</th>--}}
                        <th>Trip Qty.</th>
                        <th>Driver Name</th>
                        <th data-orderable="false">Vehicle Photo</th>
                        <th data-orderable="false" class="no-print" style="width:60px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($all_vehicle_info as $vehicle)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ str_snack($vehicle->vehicle_type) }}</td>
                        <td>{{ $vehicle->seat_capacity }} Persons</td>
                        <td>{{ $vehicle->division_id ? DB::table('divisions')->where('division_id', $vehicle->division_id)->value('division_name') : "" }}</td>
                        <td style="color: {{$vehicle->vehicle_color}}">{{ str_snack($vehicle->vehicle_color) ?: "-" }}</td>
                        <td>{{ $vehicle->vehicle_model }}</td>
                        <td>{{ $vehicle->vehicle_reg_number }}</td>
                        {{--<td>{{ $vehicle->vehicle_tax_token }}</td>--}}
                        {{--<td>{{ date('d/m/Y', strtotime($vehicle->tax_renewal_date)) }}</td>--}}
                        {{--<td>{{ $vehicle->insurance_number }}</td>--}}
                        {{--<td>{{ date('d/m/Y', strtotime($vehicle->insurance_renewal_date)) }}</td>--}}
                        {{--<td>{{ $vehicle->fitness_certificate }}</td>--}}
                        <td>{{ get_single_vehicle_trip_count($vehicle->vehicle_id) }}</td>
                        <td><a href="{{ url('driver/all-drivers?driver_mobile='.$vehicle->driver_mobile)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Go to see Driver's details">{{ $vehicle->driver_name }}</a></td>
                        <td><img src="<?php if(!empty($vehicle->vehicle_photo)){ echo upload_url( "vehicle-photo/". $vehicle->vehicle_photo ); }else{ echo image_url('defaultAvatar.jpg'); } ?>" style="border-radius: 50%; width: 40px; height: 40px; border: 1px solid #eee; box-shadow: 0 0 3px rgba(0,0,0,.3); padding: 1px; margin: 0px;" /></td>
                        <td style="white-space: nowrap;">
                            <button type="button" class="btn btn-info btn-sm view-vehicle" id="{{ $vehicle->vehicle_id }}"><i class="fa fa-eye" aria-hidden="true"></i> View</button>
                            {{-- <button type="button" class="btn btn-warning btn-sm editVehicle" id="{{ $vehicle->vehicle_id }}"><i class="fa fa-edit" aria-hidden="true"></i></button>--}}
                            {{--<button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="{{ URL::to('/vehicle/delete-vehicle/' . $vehicle->vehicle_id) }}" data-title="{{ $vehicle->vehicle_number }} - {{ $vehicle->project_name }}" id="{{ $vehicle->vehicle_id }}"><i class="far fa-trash-alt" aria-hidden="true"></i></button>--}}
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

@include('pages.vehicles.vehicle-view-modal')
@endsection


@section('custom_js')
<script type="text/javascript">
$(document).ready(function(){
    $(document).on('click', 'button.view-vehicle', function () {
        var id = $(this).attr('id');
        var modal = $("#view_vehicle_modal");

        $.ajax({
            url: "{{ url('/vehicle/view-vehicle') }}/" + id,
            method: "get",
            dataType: "json",
            cache:false,
            async: false,
            success: function( response ) {
                modal.find('.modal-title').text( "View Details of Vehicle No: " + (response['vehicle_type_data'] ? response['vehicle_type_data'].vehicle_type : "") +" - "+ response[0].vehicle_reg_number);
                if( response['vehicle_type_data'] ){ modal.find('.vehicle_type').text( response['vehicle_type_data'].vehicle_type ); }
                if( response['vehicle_type_data'] ){ modal.find('.seat_capacity').text( response['vehicle_type_data'].seat_capacity +" persons" ); }
                if( response['vehicle_type_data'] ){ modal.find('.color').html('<span style="color: '+response['vehicle_type_data'].vehicle_color+'">'+response['vehicle_type_data'].vehicle_color+'</span>'); }
                modal.find('.vehicle_model').text( response[0].vehicle_model );
                modal.find('.driver_mobile').text( response[0].driver_mobile );
                modal.find('.vehicle_reg_number').text( response[0].vehicle_reg_number );
                modal.find('.vehicle_tax_token').text( response[0].vehicle_tax_token );
                modal.find('.tax_renewal_date').text( response[0].tax_renewal_date.split('-')[2]+"/"+response[0].tax_renewal_date.split('-')[1]+"/"+response[0].tax_renewal_date.split('-')[0] );
                modal.find('.insurance_number').text( response[0].insurance_number );
                modal.find('.insurance_renewal_date').text( response[0].insurance_renewal_date.split('-')[2]+"/"+response[0].insurance_renewal_date.split('-')[1]+"/"+response[0].insurance_renewal_date.split('-')[0] );
                modal.find('.fitness_certificate').text( response[0].fitness_certificate );
                if( response['driver_data'] ){ modal.find('.driver_name').html( '<a href="'+"{{ url('driver/all-drivers?driver_mobile=') }}"+ response['driver_data'].mobile +'" target="_blank">'+ response['driver_data'].driver_name +'</a>' ); }
                modal.modal("show");
            },
            beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
        });
    });
}); //End of Document ready
</script>
@endsection

