@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInLeft">
        <div class="box-header with-border">
            <h2 class="box-title"><i class="fa fa-file-alt" aria-hidden="true"></i> Showing Driver's Pending Approval </h2>
            <div class="box-tools float-right">
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
                        <th>Email</th>
                        <th>Driving License</th>
                        <th>National ID</th>
                        <th>Status</th>
                        <th>Referral Code</th>
                        <th>Driver Photo</th>
                        <th data-orderable="false" class="no-print">Action</th>
                    </tr>
                </thead>
                <tbody>
                @php $status_class = array('unapproved'=>'btn-danger', 'approved'=>'btn-success') @endphp
                @foreach($all_driver_info as $driver)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $driver->driver_name }}</td>
                        <td><a href="tel:{{ $driver->mobile }}">{{ $driver->mobile }}</a></td>
                        <td>@if($driver->email)<a href="mailto:{{ $driver->email }}">{{ $driver->email }}</a>@else - @endif</td>
                        <td>{{ $driver->driving_licence ?: "-" }}</td>
                        <td>{{ $driver->national_id ?: "-" }}</td>
                        <td><button type="button" class="btn {{ $status_class[$driver->approval_status] }} btn-sm approval-status" data-status="{{ $driver->approval_status }}" data-approval_status="{{ $driver->approval_status }}" data-mobile="88{{$driver->mobile}}" id="{{ $driver->driver_id }}" data-href="{{ URL::to('approval-status/'. $driver->driver_id) }}">{{ str_snack($driver->approval_status) }}</button></td>
                        <td>-</td>
                        <td><img src="<?php if(!empty($driver->driver_photo)){ echo storage_url( "driver-photo/". $driver->driver_photo ); }else{ echo image_url('defaultAvatar.jpg'); } ?>" style="border-radius: 50%; width: 40px; height: 40px; border: 1px solid #eee; box-shadow: 0 0 3px rgba(0,0,0,.3); padding: 1px; margin: 0px;" /></td>
                        <td style="white-space: nowrap; width:60px;">
                            <a href="{{ url('/driver/view-driver-in-map/' . $driver->driver_id) }}" class="btn btn-success btn-sm view-in-map" target="_blank"><i class="fa fa-map-marker-alt" aria-hidden="true"></i> Map</a>
                            <button type="button" class="btn btn-outline-danger btn-sm view-driver-docs" id="{{ $driver->driver_id }}"><i class="fa fa-paperclip fa-lg" aria-hidden="true"></i> Docs</button>
                            <button type="button" class="btn btn-info btn-sm view-driver" id="{{ $driver->driver_id }}"><i class="fa fa-eye" aria-hidden="true"></i> View</button>
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
@include('pages.drivers.approval-status-modal')

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
                modal.find('.approval_status').text( response[0].approval_status );
                modal.find('.mobile').html('<a href="tel:'+response[0].mobile+'">'+response[0].mobile+'</a>');
                modal.find('.email').html('<a href="mailto:'+response[0].email+'">'+response[0].email+'</a>');
                modal.find('.country_name').text( response[0].country_name );
                modal.find('.division_name ').text( response.division_name );
                modal.find('.district_name ').text( response.district_name );
                modal.find('.branch_name ').text( response['branch'].branch_name );
                modal.find('.branch_address ').text( response['branch'].address );
                modal.find('.latlng').find('var').text( response[0].latitude +", "+ response[0].longitude );
                modal.find('.latlng').find('.attachment-btn a').attr("href", "{{ url('/view-in-map/') }}/"+ response[0].latitude).addClass( response[0].latitude ? "btn-outline-info" : "disabled btn-outline-info");
                modal.find('.national_id').find('var').text( response[0].national_id );
                modal.find('.national_id').find('.attachment-btn a').attr("href", "{{ url('storage/uploads/driver-photo/') }}/"+ response[0].national_id).addClass( response[0].national_id ? "btn-info" : "disabled btn-outline-info");
                modal.find('.driving_licence').find('var').text( response[0].driving_licence );
                modal.find('.driving_licence').find('.attachment-btn a').attr("href", "{{ url('storage/uploads/driver-photo/') }}/"+ response[0].driving_licence).addClass( response[0].driving_licence ? "btn-info" : "disabled btn-outline-info");
                modal.find('.gender').text( response[0].gender );
                modal.find('.nationality').text( response[0].nationality );
                modal.find('.date_of_birth').text( response[0].date_of_birth ? (response[0].date_of_birth.split('-')[2]+"/"+response[0].date_of_birth.split('-')[1]+"/"+response[0].date_of_birth.split('-')[0]) : "-" );
                modal.find('.blood_group').text( response[0].blood_group );
                modal.find('.trip_count').html('<a href="{{ url('/driver/trip/driver-trips') }}'+"?driver_mobile="+response[0].mobile+'" target="_blank">'+response[0].trip_count +" times"+'</a>');
                modal.find('.wallet_balance').val( takaFormat(response[0].wallet_balance ?? "-") );
                modal.find('.ratings').text( response[0].ratings );
                modal.find('.referral_code').html('<a href="{{ url('/referrals') }}'+"?referral_code="+response[0].referral_code+'" target="_blank">'+response[0].referral_code+'</a>');
                modal.find('.referral_name').text( response[0].referral_name );
                modal.find('.referral_mobile').text( response[0].referral_mobile );
                modal.find('.reg_date').text( response[0].reg_date.split('-')[2]+"/"+response[0].reg_date.split('-')[1]+"/"+response[0].reg_date.split('-')[0] );
                modal.find('.driver_note').text( response[0].note );
                modal.modal("show");
            },
            beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
        });
    });


    $(document).on('click', 'button.approval-status', function (e) {
        e.preventDefault();
        var modal = $("#approval_status_modal");

        modal.find("select#approval_status option[value="+ $(this).data('status') +"]").prop("selected", true);
        if($(this).data('approval_status') === 'unapproved'){ modal.find('select#approval_status option[value="approved"]').css("display", "block"); }
        modal.find('input[name=driver_id]').val( $(this).attr('id') );
        modal.find('input[name=mobile]').val( $(this).data('mobile') );
        modal.modal('show');
    });

    $("form#changeApprovalStatus").submit(function (event) {
        event.preventDefault();
        $("button[type=submit]").attr('disabled', 'disabled').html("<i class='fa fa-floppy-disk'></i> Saving...");

        var form = $(this);
        var approval_status = form.find('select#approval_status').val();
        var driver_id = form.find('input[name=driver_id]').val();
        var mobile = form.find('input[name=mobile]').val();
        var url = form.attr("action");
        var status_class_array = { 'banned':"btn-danger", 'suspend':"btn-outline-danger", 'approved':'btn-success' };

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            type: "POST",
            url: url,
            data: {driver_id: driver_id, approval_status: approval_status, mobile: mobile},
            dataType: 'json',
            success: function (response) {
                $("button#"+driver_id+".approval-status").text( capitalizeFirstLetter(response.approval_status.replace('_', ' ').replace('_', ' ')) );
                $("button#"+driver_id+".approval-status").attr('data-status', response.approval_status.replace('_', ' ').replace('_', ' ') );
                $("button#"+driver_id+".approval-status").removeAttr('class').attr('class', 'btn btn-sm approval-status '+ status_class_array[response.approval_status]);

                toastr.success( response.success );
                $('#approval_status_modal').modal('hide');
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

