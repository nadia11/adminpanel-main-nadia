@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInLeft">
        <div class="box-header with-border">
            <h2 class="box-title"><i class="fa fa-file-alt" aria-hidden="true"></i> Showing {{ slug_to_title(last(request()->segments())) }}</h2>
            <div class="box-tools float-right">
                <div class="float-left" style="margin-right: 5px; width: 125px;">
                    <select id="rider_status_filter" class="custom-select custom-select-sm" onchange="window.document.location.href=this.options[this.selectedIndex].value;">
                        <option value="">--Rider Status--</option>
                        <option value="pending" {{ last(request()->segments())=='pending'?"selected":"" }}>Pending Riders</option>
                        <option value="active" {{ last(request()->segments())=='active'?"selected":"" }}>Active Riders</option>
                        <option value="deactive" {{ last(request()->segments())=='deactive'?"selected":"" }}>Deactive Riders</option>
                        <option value="banned" {{ last(request()->segments())=='banned'?"selected":"" }}>Banned Riders</option>
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
                        <th>Rider Name</th>
                        <th>Mobile</th>
                        <th class="hide">Division ID</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Wallet Balance</th>
                        <th>Trip Count</th>
                        <th>Invitation Code</th>
                        <th data-orderable="false">Rider Photo</th>
                        <th data-orderable="false" class="no-print" style="width:60px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                @php $status_class = array('pending'=>'btn-warning', 'banned'=>"btn-danger", 'suspend'=>"btn-outline-danger", 'active'=>'btn-info', 'on_trip'=>'btn-success') @endphp
                @foreach($all_rider_info as $rider)
                    <?php $trip_count = DB::table('rider_trips')->where('rider_id', $rider->rider_id)->COUNT(); ?>

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $rider->rider_name }}</td>
                        <td><a href="tel:{{ $rider->mobile }}">{{ $rider->mobile }}</a></td>
                        <td class="hide">{{ $rider->division_id ? $rider->division_id : "" }}</td>
                        <td>@if($rider->email)<a href="mailto:{{ $rider->email }}">{{ $rider->email }}</a>@else - @endif</td>
                        <td><button type="button" class="btn {{ $status_class[$rider->rider_status] }} btn-sm rider-status" data-status="{{ $rider->rider_status }}" id="{{ $rider->rider_id }}" data-href="{{ URL::to('rider-status/'. $rider->rider_id) }}">{{ str_snack($rider->rider_status) }}</button></td>
                        <td>{{ $rider->wallet_balance ? taka_format('', $rider->wallet_balance) : "0.00" }}</td>
                        <td>@if($trip_count)<a href="{{ url('/rider-trip/rider-all-trips?trip_rider_mobile=' . $rider->mobile) }}" target="_blank">{{ $trip_count }}</a>@else 0 @endif</td>
                        <td>{{ $rider->invitation_code ?? "-" }}</td>
                        <td><img src="<?php if(!empty($rider->rider_photo)){ echo url( "storage/rider-photo/". $rider->rider_photo ); }else{ echo image_url('defaultAvatar.jpg'); } ?>" style="border-radius: 50%; width: 40px; height: 40px; border: 1px solid #eee; box-shadow: 0 0 3px rgba(0,0,0,.3); padding: 1px; margin: 0px;" /></td>
                        <td style="white-space: nowrap;">
                            {{--<a href="{{ url('/view-in-map/rider/' . $rider->rider_id) }}" class="btn btn-success btn-sm view-in-map" target="_blank"><i class="fa fa-map-marker-alt" aria-hidden="true"></i></a>--}}
                            <a href="{{ url('/rider-trip/rider-all-trips?rider_mobile='.$rider->mobile) }}" class="btn btn-warning btn-sm" target="_blank"><i class="fa fa-biking" aria-hidden="true"></i></a>
                            <button type="button" class="btn btn-info btn-sm view-rider" id="{{ $rider->rider_id }}"><i class="fa fa-eye" aria-hidden="true"></i> View</button>
                            {{--<button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="{{ URL::to('/rider/delete-rider/' . $rider->rider_id) }}" data-title="{{ $rider->rider_number }} - {{ $rider->project_name }}" id="{{ $rider->rider_id }}"><i class="far fa-trash-alt" aria-hidden="true"></i></button>--}}
                            {{--<button type="button" class="btn btn-warning btn-sm editRider" id="{{ $rider->rider_id }}"><i class="fa fa-edit" aria-hidden="true"></i></button>--}}
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

@include('pages.riders.rider-view-modal')
@include('pages.riders.rider-status-modal')

@endsection


@section('custom_js')
<script type="text/javascript">
$(document).ready(function(){
    $(document).on('click', 'button.view-rider', function () {
        var id = $(this).attr('id');
        var modal = $("#view_rider_modal");

        $.ajax({
            url: "{{ url('/rider/view-rider') }}/" + id,
            method: "get",
            dataType: "json",
            cache:false,
            async: false,
            success: function( response ) {
                modal.find('.modal-title').text( "View Details of Rider No: " + response[0].rider_number );
                modal.find('.modal-title').text( "View Details of Rider ("+ response[0].rider_name +")" );
                modal.find('.rider_name').text( response[0].rider_name );
                modal.find('.rider_status').text( response[0].rider_status );
                modal.find('.mobile').html('<a href="tel:'+response[0].mobile+'">'+response[0].mobile+'</a>');
                modal.find('.email').html('<a href="mailto:'+response[0].email+'">'+response[0].email+'</a>');
                modal.find('.latlng').find('var').text( (response[0].latitude ? response[0].latitude : 0) +", "+ (response[0].longitude ? response[0].longitude : 0) );
                modal.find('.latlng').find('.attachment-btn a').attr("href", "{{ url('/map/view-in-map/rider/') }}?lat="+ response[0].latitude+"&lng="+response[0].longitude).addClass( response[0].latitude ? "btn-outline-success" : "disabled btn-outline-success");
                modal.find('.national_id').find('var').text( response[0].national_id );
                modal.find('.national_id').find('.attachment-btn a').attr("href", "{{ url('storage/uploads/rider-photo/') }}/"+ response[0].national_id).addClass( response[0].national_id ? "btn-info" : "disabled btn-outline-info");
                modal.find('.driving_licence').find('var').text( response[0].driving_licence );
                modal.find('.driving_licence').find('.attachment-btn a').attr("href", "{{ url('storage/uploads/rider-photo/') }}/"+ response[0].driving_licence).addClass( response[0].driving_licence ? "btn-warning" : "disabled btn-outline-warning");
                modal.find('.gender').text( response[0].gender );
                modal.find('.nationality').text( response[0].nationality );
                modal.find('.date_of_birth').text( response[0].date_of_birth ? (response[0].date_of_birth.split('-')[2]+"/"+response[0].date_of_birth.split('-')[1]+"/"+response[0].date_of_birth.split('-')[0]) : "-" );
                modal.find('.blood_group').text( response[0].blood_group );
                modal.find('.trip_count').html('<a href="{{ url('/rider-trip/rider-all-trips') }}'+"?trip_rider_mobile="+response[0].mobile+'" target="_blank">'+(response.trip_count ?? "0") +" Trips"+'</a>');
                modal.find('.wallet_balance').val( takaFormat(response[0].wallet_balance ?? "-") );
                modal.find('.ratings').text( response[0].ratings );
                modal.find('.referral_code').html(response[0].referral_code ? '<a href="{{ url('/referrals') }}'+"?referral_code="+response[0].referral_code+'" target="_blank">'+response[0].referral_code+'</a>' : "-");
                modal.find('.referral_name').text( response[0].referral_name ?? "-" );
                modal.find('.referral_mobile').text( response[0].referral_mobile ?? "-" );
                modal.find('.invitation_code').text( response[0].invitation_code );
                modal.find('.reg_date').text( response[0].reg_date ? (response[0].reg_date.split('-')[2]+"/"+response[0].reg_date.split('-')[1]+"/"+response[0].reg_date.split('-')[0]) : "-" );
                modal.find('.rider_note').text( response[0].note );


                modal.modal("show");
            },
            beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
        });
    });

    $(document).on('click', 'button.rider-status', function (e) {
        e.preventDefault();
        var modal = $("#rider_status_modal");

        modal.find("select#rider_status option[value="+ $(this).data('status') +"]").prop("selected", true);
        modal.find('input[name=rider_id]').val( $(this).attr('id') );
        modal.modal('show');
    });

    $("form#changeRiderStatus").submit(function (event) {
        event.preventDefault();
        $("button[type=submit]").attr('disabled', 'disabled').html("<i class='fa fa-floppy-disk'></i> Saving...");

        var form = $(this);
        var rider_status = form.find('select#rider_status').val();
        var rider_id = form.find('input[name=rider_id]').val();
        var url = form.attr("action");
        var status_class_array = { 'pending':'btn-warning', 'banned':"btn-danger", 'suspend':"btn-outline-danger", 'leave':'btn-primary', 'available':'btn-info', 'on_trip':'btn-success' };

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            type: "POST",
            url: url,
            data: {rider_id: rider_id, rider_status: rider_status},
            dataType: 'json',
            success: function (response) {
                $("button#"+rider_id+".rider-status").text( capitalizeFirstLetter(response.rider_status.replace('_', ' ').replace('_', ' ')) );
                $("button#"+rider_id+".rider-status").attr('data-status', response.rider_status.replace('_', ' ').replace('_', ' ') );
                $("button#"+rider_id+".rider-status").removeAttr('class').attr('class', 'btn btn-sm rider-status '+ status_class_array[response.rider_status]);

                toastr.success( response.success );
                $('#rider_status_modal').modal('hide');
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

