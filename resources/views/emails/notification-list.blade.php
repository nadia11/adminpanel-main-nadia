@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInRight">
        <div class="box-header with-border">
            <h2 class="box-title">Notification List</h2>
            <div class="box-tools float-right">
                <div class="float-left" style="margin-right: 5px; width: 150px;">
                    <select class="custom-select custom-select-sm" onchange="filter_column(this.value, 'general_datatable', 3)">
                        @php $group_names = DB::table('contact_groups')->orderBy('group_name', 'ASC')->pluck("group_name", "group_id") @endphp
                        <option value="">--Select Recipient--</option>
                        <option value="All Riders">All Riders</option>
                        <option value="All Drivers">All Drivers</option>
                        <option value="All Agents">All Agents</option>
                        @foreach( $group_names as $key => $name )
                            <option value="{{ $key }}">{{ ucwords($name) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="float-left" style="margin-right: 5px; width: 130px;">
                    <select id="notification_type" class="custom-select custom-select-sm" onchange="filter_column(this.value, 'general_datatable', 4)">
                        <option value="">--select Type--</option>
                        <option value="general">General Notification</option>
                        <option value="notice">Notice</option>
                        <option value="info">Info</option>
                    </select>
                </div>
                <div class="float-left" style="margin-right: 5px; width: 130px;">
                    <select id="platform" class="custom-select custom-select-sm" onchange="filter_column(this.value, 'general_datatable', 6)">
                        <option value="All Platform">All Platform</option>
                        <option value="Android">Android</option>
                        <option value="IOS">IOS</option>
                        <option value="Eeb">Web</option>
                    </select>
                </div>

                <button type="button" class="btn btn-outline-danger btn-sm showNewNotificationModal" data-toggle="tooltip" data-placement="top" title="Add New Notification Modal"><i class="fa fa-user-plus"></i> New Notification</button>
                <button type="button" class="btn btn-box-tool" id="refresh" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-sync-alt"></i></button>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->

        <div class="box-body">
            <table id="general_datatable" class="table table-striped table-custom notification-list-table">
                <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        {{--<th data-orderable="false" class="no-print" style="width: 5px;"><input type="checkbox" class="select-all filled-in" name="select_all" id="select-all" value="all" /><label for="select-all"></label></th>--}}
                        <th style="width:150px;">Notification Title</th>
                        <th>Notification Body</th>
                        <th style="width:100px;">Recipient</th>
                        <th style="width:50px;">Type</th>
                        <th style="width:50px;">Recipient Qty.</th>
                        <th style="width:100px;">Platform</th>
                        <th style="width:80px;">Time</th>
                        <th data-orderable="false" class="no-print" style="width:80px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                @php $status_class = array('general'=>'', 'info'=>'text-info', 'notice'=>"btn-danger") @endphp
                @foreach($notification_info as $notification)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        {{--<td><input type="checkbox" name="id[]" id="{{ $notification->notification_id }}" class="filled-in" data-orderable="false" value="{{ $notification->notification_id }}" /><label for="{{ $notification->notification_id }}"></label></td>--}}
                        <td class="text-left">{{ $notification->notification_title }}</td>
                        <td class="text-left">{{ $notification->notification_body }}</td>
                        <td>{{ slug_to_title($notification->recipient) }}</td>
                        <td class="{{ $status_class[$notification->type] }}">{{ str_snack($notification->type) }}</td>
                        <td>{{ $notification->recipient_qty }}</td>
                        <td>{{ str_snack($notification->platform) }}</td>
                        <td>{{ $notification->created_at ? date('d/m/Y h:m:s A', strtotime($notification->created_at)) : "" }}</td>
                        <td style="white-space: nowrap;">
                            <button type="button" class="btn btn-info btn-sm viewNotification" id="{{ $notification->notification_id }}"><i class="fa fa-eye" aria-hidden="true"></i></button>
                            <button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="{{ URL::to('/notification/delete-notification/' . $notification->notification_id) }}" data-title="{{ $notification->notification_title }}" id="{{ $notification->notification_id }}"><i class="far fa-trash-alt" aria-hidden="true"></i> </button>
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

@include('emails.notification-new-modal')
@include('emails.notification-view-modal')
@endsection


@section('custom_js')
<script type="text/javascript">
$(document).ready(function(){
    $('button.showNewNotificationModal').on('click', function () {
        var modal = $("#newNotificationModal");

        modal.modal({ backdrop: "static", keyboard: true });
    });

    {{--$("form#send-notification-form").submit(function (event) {--}}
    {{--    event.preventDefault();--}}
    {{--    //$("button[type=submit]").attr('disabled', 'disabled').html("<i class='fa fa-paper-plane'></i> Sending Message...");--}}

    {{--    var form = $(this);--}}

    {{--    $.ajax({--}}
    {{--        type: "POST",--}}
    {{--        url: form.attr("action"),--}}
    {{--        data: form.serialize(),--}}
    {{--        dataType: 'json',--}}
    {{--        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },--}}
    {{--        success: function (response) {--}}
    {{--            var notification_table_tr = '<tr>';--}}
    {{--            notification_table_tr += '<td>0</td>';--}}
    {{--            notification_table_tr += '<td><input type="checkbox" name="id[]" id="{ $notification->notification_id }}" class="filled-in" value="{ $notification->notification_id }}" /><label for="{ $notification->notification_id }}"></label></td>';--}}
    {{--            notification_table_tr += '<td>'+response[0].sender+'</td>';--}}
    {{--            notification_table_tr += '<td>'+response[0].receiver+'</td>';--}}
    {{--            notification_table_tr += '<td>'+response[0].notification_date+'</td>';--}}
    {{--            notification_table_tr += '<td>'+response[0].subject+'</td>';--}}
    {{--            notification_table_tr += '<td>'+response[0].message_body+'</td>';--}}
    {{--            notification_table_tr += '<td>'+response[0].notification_type+'</td>';--}}
    {{--            notification_table_tr += '<td>'+response[0].user_id+'</td>';--}}
    {{--            notification_table_tr += "</tr>";--}}

    {{--            $("table.notification-list-table tbody").prepend(notification_table_tr);--}}
    {{--            $("table.notification-list-table tbody tr:first").hide().delay("slow").fadeIn();--}}

    {{--            toastr.success( response.success );--}}
    {{--            $('#newNotificationModal').modal('hide');--}}
    {{--            $("button[type=submit]").removeAttr('disabled').html("<i class='fa fa-paper-plane'></i> Send Message");--}}
    {{--        },--}}
    {{--        statusCode:{ 404: function(){ alert( "page not found" ); } },--}}
    {{--        error: function (xhr, textStatus, errorThrown) { alert(errorThrown); },--}}
    {{--        beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },--}}
    {{--        complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },--}}
    {{--    });--}}
    {{--    return false;--}}
    {{--});--}}

    $(document).on('keyup', '#message_body', function(e) {
        var len = $(this).val().length + 1;
        var total = 1500;

        if(len > 1) { $(".notification-counter-wrap").slideDown('slow'); }else{ $(".notification-counter-wrap").slideUp('5000'); }
        $('.charCount').text(len +" Characters | "+ parseInt(total - len) +" Characters Left");
        $('.notificationCount').text(" | "+ parseInt((len/153)+1) +" Notification (153 Char./Notification)");
    });


    $(document).on('click', 'button.viewNotification', function () {
        var id = $(this).attr('id');
        var modal = $("#view_notification_modal");
        modal.modal("show");

        $.ajax({
            url: "{{ url('/notification/view-notification') }}/" + id,
            method: "get",
            dataType: "json",
            success: function( response ) {
                modal.find('.modal-title').text( "View Details of Notification ("+ response[0].notification_title +")" );
                modal.find('.notification_title').text( response[0].notification_title );
                //modal.find('.trip_count').html('<a href="{ url('/notification/trip/notification-trips') }}'+"?trip_notification_mobile="+response[0].mobile+'" target="_blank">'+ (response[0].trip_count ?? "0") +" times"+'</a>');
                modal.find('.notification_body').text( response[0] ? response[0].notification_body : "-" );
                modal.find('.recipient').text( response[0].recipient ? response[0].recipient.replace('_', ' ').replace('-', ' ') : "-" );
                modal.find('.type').text( response[0] ? response[0].type : "-" );
                modal.find('.platform').text( response[0].platform ? response[0].platform.replace('_', ' ').replace('-', ' ') : "-" );
                modal.find('.datetime').text( response[0].created_at ? response[0].created_at.split('-')[2]+"/"+response[0].created_at.split('-')[1]+"/"+response[0].created_at.split('-')[0] : "-" );

               modal.modal("show");
           },
           beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
           complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
       });
    });
}); //End of Document ready

</script>
@endsection
