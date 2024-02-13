@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInLeft">
        <div class="box-header with-border">
            <h2 class="box-title"><i class="fa fa-file-alt" aria-hidden="true"></i> Showing {{ slug_to_title(last(request()->segments())) }}</h2>
            <div class="box-tools float-right">
                <div class="float-left" style="margin-right: 5px; width: 125px;">
                    <select id="driver_status_filter" class="custom-select custom-select-sm" onchange="window.document.location.href=this.options[this.selectedIndex].value;">
                        <option value="">--Driver Status--</option>
                        <option value="pending-drivers" {{ last(request()->segments())=='pending-drivers'?"selected":"" }}>Pending Drivers</option>
                        <option value="active" {{ last(request()->segments())=='active'?"selected":"" }}>Active Drivers</option>
                        <option value="leave" {{ last(request()->segments())=='leave'?"selected":"" }}>Leave Drivers</option>
                        <option value="suspend" {{ last(request()->segments())=='suspend'?"selected":"" }}>Suspend Drivers</option>
                        <option value="banned" {{ last(request()->segments())=='banned'?"selected":"" }}>Banned Drivers</option>
                        <option value="available" {{ last(request()->segments())=='available'?"selected":"" }}>Available Drivers</option>
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
                        <th>Driver Name</th>
                        <th>Mobile</th>
                        <th class="hide">Division ID</th>
                        <th>Email</th>
                        <th>Driving License</th>
                        <th>Status</th>
                        <th>Wallet Balance</th>
                        <th>Ratings</th>
                        <th>Trip Count</th>
                        <th>Invitation Code</th>
                        <th>Driver Photo</th>
                        <th data-orderable="false" class="no-print">Action</th>
                    </tr>
                </thead>
                <tbody>
                @php $status_class = array('pending'=>'btn-warning', 'banned'=>"btn-danger", 'suspend'=>"btn-outline-danger", 'leave'=>'btn-outline-primary', 'active'=>'btn-info', 'online'=>'btn-info', 'offline'=>'btn-dark', 'available'=>'btn-primary', 'on_trip'=>'btn-success') @endphp
                @foreach($all_driver_info as $driver)
                    @php $trip_count = DB::table('driver_trips')->where('driver_id', $driver->driver_id)->COUNT() @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $driver->driver_name }}</td>
                        <td><a href="tel:{{ $driver->mobile }}">{{ $driver->mobile }}</a></td>
                        <td class="hide">{{ $driver->division_id ? $driver->division_id : "" }}</td>
                        <td>@if($driver->email)<a href="mailto:{{ $driver->email }}">{{ $driver->email }}</a>@else - @endif</td>
                        <td>{{ $driver->driving_licence ?: "-" }}</td>
                        <td><button type="button" class="btn {{ $status_class[$driver->driver_status] }} btn-sm driver-status" data-status="{{ $driver->driver_status }}" id="{{ $driver->driver_id }}" data-href="{{ URL::to('driver-status/'. $driver->driver_id) }}">{{ str_snack($driver->driver_status) }}</button></td>
                        <td>{{ $driver->wallet_balance ? taka_format('', $driver->wallet_balance) : "0.00" }}</td>
                        <td>{{ $driver->ratings }}</td>
                        <td>@if($trip_count)<a href="{{ url('/driver/trip/driver-trips?trip_driver_id=' . $driver->driver_id) }}" target="_blank">{{ $trip_count }}</a>@else 0 @endif</td>
                        <td>{{ $driver->invitation_code ?? "-" }}</td>
                        <td><img src="<?php if(!empty($driver->driver_photo)){ echo storage_url( "/driver-photo/". $driver->driver_photo ); }else{ echo image_url('defaultAvatar.jpg'); } ?>" style="border-radius: 50%; width: 40px; height: 40px; border: 1px solid #eee; box-shadow: 0 0 3px rgba(0,0,0,.3); padding: 1px; margin: 0px;" /></td>
                        <td style="white-space: nowrap; width:100px;">
                            {{--<a href="{{ url('/view-in-map/driver/' . $driver->driver_id) }}" class="btn btn-success btn-sm view-in-map" target="_blank"><i class="fa fa-map-marker-alt" aria-hidden="true"></i></a>--}}
                            <button type="button" class="btn btn-outline-danger btn-sm view-driver-docs" id="{{ $driver->driver_id }}"><i class="fa fa-paperclip fa-lg" aria-hidden="true"></i></button>
                            <a href="{{ url('/driver/earning/specific-driver-earnings/' . $driver->driver_id) }}" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-lg fa-dollar-sign" aria-hidden="true"></i></a>
                            <a href="{{ url('/driver/trip/driver-trips?driver_mobile='.$driver->mobile) }}" class="btn btn-warning btn-sm" target="_blank"><i class="fa fa-biking" aria-hidden="true"></i></a>
                            <button type="button" class="btn btn-info btn-sm view-driver" id="{{ $driver->driver_id }}"><i class="fa fa-eye" aria-hidden="true"></i></button>
                            {{--<button type="button" class="btn btn-warning btn-sm editDriver" id="{{ $driver->driver_id }}"><i class="fa fa-edit" aria-hidden="true"></i></button>--}}
                            {{--<button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="{{ URL::to('/driver/delete-driver/' . $driver->driver_id) }}" data-title="{{ $driver->driver_number }} - {{ $driver->project_name }}" id="{{ $driver->driver_id }}"><i class="far fa-trash-alt" aria-hidden="true"></i></button>--}}
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

@include('pages.drivers.driver-view-modal')
@include('pages.drivers.driver-status-modal')

@endsection


@section('custom_js')
<script type="text/javascript">
$(document).ready(function(){
    $(document).on('click', 'button.view-driver', function () {
        var id = $(this).attr('id');
        var modal = $("#view_driver_modal");

        $.ajax({
            url: "{{ url('/driver/view-driver') }}/" + id,
            method: "get",
            dataType: "json",
            success: function( response ) {
                modal.find('.modal-title').text( "View Details of Driver ("+ response[0].driver_name +")" );
                modal.find('.driver_name').text( response[0].driver_name );
                modal.find('.driver_status').text( response[0].driver_status.replace('_', ' ').replace('_', ' ') );
                modal.find('.mobile').html('<a href="tel:'+response[0].mobile+'">'+response[0].mobile+'</a>');
                modal.find('.email').html('<a href="mailto:'+response[0].email+'">'+response[0].email+'</a>');
                modal.find('.country_name').text( response[0].country_name );
                modal.find('.division_name ').text( response.division_name );
                modal.find('.district_name ').text( response.district_name );
                modal.find('.branch_name').text( response['branch'] ? response['branch'].branch_name : "" );
                modal.find('.branch_address').text( response['branch'] ? response['branch'].address : "" );
                modal.find('.latlng').find('var').text( response[0].latitude +", "+ response[0].longitude );
                modal.find('.latlng').find('.attachment-btn a').attr("href", "{{ url('/map/view-in-map/driver/') }}?lat="+ response[0].latitude+"&lng="+response[0].longitude).removeClass('disabled btn-outline-success btn-success').addClass( response[0].latitude ? "btn-outline-success" : "disabled btn-outline-success");
                modal.find('.national_id').find('var').text( response[0].national_id );
                modal.find('.national_id').find('.attachment-btn a').attr("href", "{{ url('storage/uploads/driver-photo/') }}/"+ response[0].national_id).removeClass('disabled btn-outline-info btn-info').addClass( response[0].national_id ? "btn-info" : "disabled btn-outline-info");
                modal.find('.driving_licence').find('var').text( response[0].driving_licence );
                modal.find('.driving_licence').find('.attachment-btn a').attr("href", "{{ url('storage/uploads/driver-photo/') }}/"+ response[0].driving_licence).removeClass('disabled btn-outline-warning btn-warning').addClass( response[0].driving_licence ? "btn-warning" : "disabled btn-outline-warning");
                modal.find('.gender').text( response[0].gender );
                modal.find('.nationality').text( response[0].nationality );
                modal.find('.date_of_birth').text( response[0].date_of_birth ? (response[0].date_of_birth.split('-')[2]+"/"+response[0].date_of_birth.split('-')[1]+"/"+response[0].date_of_birth.split('-')[0]) : "-" );
                modal.find('.blood_group').text( response[0].blood_group );
                modal.find('.trip_count').html('<a href="{{ url('/driver/trip/driver-trips') }}'+"?trip_driver_mobile="+response[0].mobile+'" target="_blank">'+ (response.trip_count ?? "0") +" Trips"+'</a>');
                modal.find('.wallet_balance').val( takaFormat(response[0].wallet_balance ?? "-") );
                modal.find('.ratings').text( response[0].ratings );
                modal.find('.referral_code').html(response[0].referral_code ? '<a href="{{ url('/referral/referral-management/') }}'+"?referral_code="+response[0].referral_code+'" target="_blank">'+response[0].referral_code+'</a>' : "-");
                modal.find('.referral_name').text( response[0].referral_name ?? "-" );
                modal.find('.referral_mobile').text( response[0].referral_mobile ?? "-" );
                modal.find('.invitation_code').text( response[0].invitation_code );
                modal.find('.reg_date').text( response[0].reg_date ? response[0].reg_date.split('-')[2]+"/"+response[0].reg_date.split('-')[1]+"/"+response[0].reg_date.split('-')[0] : "-" );
                modal.find('.driver_note').text( response[0].note );

                if( response['vehicle_types'] ){ modal.find('.vehicle_type').text( response['vehicle_types'].vehicle_type ); }
                if( response['vehicle_types'] ){ modal.find('.seat_capacity').text( response['vehicle_types'].seat_capacity +" persons" ); }
                if( response['vehicle_types'] ){ modal.find('.vehicle_color').html('<span style="color: '+response['vehicle_types'].vehicle_color+'">'+response['vehicle_types'].vehicle_color+'</span>'); }
                modal.find('.manufacturer').text( response['vehicles'] ? response['vehicles'].manufacturer : "-" );
                modal.find('.model_year').text( response['vehicles'] ? response['vehicles'].model_year : "-" );
                modal.find('.vehicle_model').text( response['vehicles'] ? response['vehicles'].vehicle_model : "-" );
                modal.find('.vehicle_reg_number').text( response['vehicles'] ? response['vehicles'].vehicle_reg_number : "-" );
                modal.find('.vehicle_tax_token').text( response['vehicles'] ? response['vehicles'].vehicle_tax_token : "-" );
                modal.find('.tax_renewal_date').text( response['vehicles'] ? (response['vehicles'].tax_renewal_date.split('-')[2]+"/"+response['vehicles'].tax_renewal_date.split('-')[1]+"/"+response['vehicles'].tax_renewal_date.split('-')[0]) : "-" );
                modal.find('.insurance_number').text( response['vehicles'] ? response['vehicles'].insurance_number : "-" );
                modal.find('.insurance_renewal_date').text( response['vehicles'] ? (response['vehicles'].insurance_renewal_date.split('-')[2]+"/"+response['vehicles'].insurance_renewal_date.split('-')[1]+"/"+response['vehicles'].insurance_renewal_date.split('-')[0]) : "-" );
                modal.find('.fitness_certificate').text( response['vehicles'] ? response['vehicles'].fitness_certificate : "-" );

                modal.modal("show");
            },
            beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
        });
    });


    $(document).on('click', 'button.driver-status', function (e) {
        e.preventDefault();
        var modal = $("#driver_status_modal");

        modal.find("select#driver_status option[value="+ $(this).data('status') +"]").prop("selected", true);
        modal.find('input[name=driver_id]').val( $(this).attr('id') );
        modal.modal('show');
    });

    $("form#changeDriverStatus").submit(function (event) {
        event.preventDefault();
        $("button[type=submit]").attr('disabled', 'disabled').html("<i class='fa fa-floppy-disk'></i> Saving...");

        var form = $(this);
        var driver_status = form.find('select#driver_status').val();
        var driver_id = form.find('input[name=driver_id]').val();
        var url = form.attr("action");
        var status_class_array = { 'pending':'btn-warning', 'banned':"btn-danger", 'suspend':"btn-outline-danger", 'leave':'btn-primary', 'available':'btn-info', 'on_trip':'btn-success' };

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            type: "POST",
            url: url,
            data: {driver_id: driver_id, driver_status: driver_status},
            dataType: 'json',
            success: function (response) {
                $("button#"+driver_id+".driver-status").text( capitalizeFirstLetter(response.driver_status.replace('_', ' ').replace('_', ' ')) );
                $("button#"+driver_id+".driver-status").attr('data-status', response.driver_status.replace('_', ' ').replace('_', ' ') );
                $("button#"+driver_id+".driver-status").removeAttr('class').attr('class', 'btn btn-sm driver-status '+ status_class_array[response.driver_status]);

                toastr.success( response.success );
                $('#driver_status_modal').modal('hide');
                $("button[type=submit]").removeAttr('disabled').html("<i class='fa fa-save'></i> Change Status");
            },
            statusCode:{ 404: function(){ alert( "page not found" ); } },
            error: function (xhr, textStatus, errorThrown) { alert(errorThrown); },
            beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
        });
        return false;
    });
}); //End of Document ready
</script>
@endsection

