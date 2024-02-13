@extends('dashboard')
@section('main_content')

<section class="content-wrapper">
    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="fa fa-users"></i>
            <h2 class="box-title">Showing All Users</h2>
            <div class="box-tools float-right">
                {{--<a href="{{ route('log-viewer::dashboard') }}" class="btn btn-primary btn-sm"><i class="fa fa-dashboard"></i> LogViewer dashboard</a>--}}
                <a href="{{ URL::to('log-viewer') }}" class="btn btn-danger btn-sm" target="_blank"><i class="fa fa-life-ring"></i> <span>Log Viewer</span></a>
                <a href="{{ URL::to('activity-log') }}" class="btn btn-warning btn-sm" target="_blank"><i class="fa fa-eye"></i> <span>Activity Log</span></a>
                <a href="{{ URL('/admin/login-logs') }}" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-sign-out-alt"></i> <span>Login logs</span></a>

                <div class="float-left" style="margin-right: 5px; width: 125px;">
                    <select id="online_status_filter" class="custom-select custom-select-sm" onchange="filter_column_serverside(this.value, 'user_datatable')">
                        <option value="">--Online Status--</option>
                        <option value="Online">Online</option>
                        <option value="Offline">Offline</option>
                        <option value="Idle">Idle</option>
                    </select>
                </div>
                <div class="float-left" style="margin-right: 5px; width: 125px;">
                    <select id="user_status_filter" class="custom-select custom-select-sm" onchange="filter_column_serverside(this.value, 'user_datatable')">
                        <option value="">--User Status--</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="denied">Denied</option>
                    </select>
                </div>
                <div class="float-left" style="margin-right: 5px; width: 125px;">
                    <select id="user_role_filter" class="custom-select custom-select-sm" onchange="filter_column_serverside(this.value, 'user_datatable')">
                        @php $group_names = DB::table('user_roles')->orderBy('role_name', 'ASC')->pluck("role_name", "role_id") @endphp
                        <option value="">--Select Role--</option>
                        @foreach( $group_names as $key => $name )
                            <option value="{{ $name }}">{{ ucwords($name) }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#userRoleModal"><i class="fa fa-user-tag"></i> User Role</button>
                <button type="button" class="btn btn-dark btn-sm" data-toggle="modal" data-target="#newUserModal"><i class="fa fa-user-plus"></i> Add New User</button>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->

        <div class="box-body">
            <table id="user_datatable" class="table table-custom user_management_table">
                <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        {{--<th data-orderable="false" style="width: 5px;"><input type="checkbox" class="select-all filled-in" name="select_all" id="select-all" value="all" /><label for="select-all"></label></th>--}}
                        <th>User Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>User Role</th>
                        <th>Status</th>
                        <th>Online Status</th>
                        <th>Photo</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <!-- Details  -->
                </tbody>
            </table>
        </div><!-- /.box-body -->

        <div class="overlay" style="display: none;">
            <i class="fa fa-sync-alt fa-spin"></i>
        </div>
    </div>
</section>

@include('user.user-manage-by-admin.change-password-modal')
@include('user.user-manage-by-admin.user-status-modal')
@include('user.user-manage-by-admin.view-user-modal')
@include('user.user-manage-by-admin.user-role-modal')
@include('user.user-manage-by-admin.new-user-modal')
@include('user.user-manage-by-admin.generate-password-modal')
@include('user.user-manage-by-admin.update-user-modal')

@endsection



@section('custom_js')
<script type="text/javascript">
$(document).ready(function(){
    var topbarMenu = $(".topbar-menu").outerHeight(true);
    var header = $("header").outerHeight(true);
    var footer = $("footer").outerHeight(true);
    var division_name_url_param = window.location.href.slice(window.location.href.indexOf('?') + 1).split('division_name=')[1];
    var user_url_param = window.location.href.slice(window.location.href.indexOf('?') + 1).split('usership_number=')[1];
    var branch_name_url_param = window.location.href.slice(window.location.href.indexOf('?') + 1).split('branch_name=')[1];

    var table = $('#user_datatable').DataTable({
        processing: true,
        serverSide: true,
        "ajax": {
            "url": "{{ url('admin/user-management-list-data') }}",
            "dataType": "json",
            "type": "POST",
            cache: true,
            {{--"data":{ _token: "{{ csrf_token() }}"},--}}
            data: function (d) {
                d.online_status_filter = $('#online_status_filter').val(),
                d.user_status_filter = $('#user_status_filter').val(),
                d.user_role_filter = $('#user_role_filter').val(),
                //d.blood_group_filter = $('#blood_group_filter').val(),
                //d.gender_filter = $('#gender_filter').val(),
                //d.role_name_filter_from_url = role_name_filter_from_url,
                //d.user_status_url_param = user_status_url_param,
                d._token = "{{ csrf_token() }}"
            },
            dataFilter: function(data){
                //console.log(json);
                var json = jQuery.parseJSON( data );
                json.recordsTotal = json.recordsTotal;
                json.recordsFiltered = json.recordsFiltered;
                json.data = json.data;
                return JSON.stringify( json );
            },
        },
        columns: [
            {data: 'DT_RowClass', orderable:false, searchable:false, "class": ""}, /*DT_RowIndex, DT_RowId, DT_RowClass, DT_RowData */
            //{ data: 'user_id', orderable:false, searchable:false},
            //{ data: 'row_checkbox', },
            { data: 'user_name', },
            { data: 'mobile', },
            { data: 'email', },
            { data: 'role_name', },
            { data: 'user_status', },
            { data: 'online_status', },
            { data: 'user_photo', orderable:false, searchable:false },
            { data: 'action', orderable:false, searchable:false, "width": "190px", "class": "no-print" }
        ],
        // "createdRow": function( row, data, dataIndex ) {
        //     if ( data[9] >1000 ){ $('td', row).eq(9).css({'color':'red'}); }
        // },
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 1 },
            { responsivePriority: 3, targets: 2 },
            { responsivePriority: 4, targets: 4 },
            { responsivePriority: 5, targets: 5 },
            { responsivePriority: 6, targets: 6 },
            { responsivePriority: 7, targets: 8 },
            //{ responsivePriority: 8, targets: 9 },
            //{ responsivePriority: 10, targets: -1 }
        ],
        // search: { "regex": true },
        // fixedHeader: true,
        // scrollY: $( window ).outerHeight() - (topbarMenu + header + footer) - 180,
        // scrollCollapse: true,
        // scroller: { loadingIndicator: true },
        responsive: true,
        "autoWidth": false,
        paging: true,
        pagingType: "full_numbers", /*input, full_numbers*/
        "deferLoading": 50,
        //displayLength: 25,
        lengthMenu: [[10, 25, 50, 100, 200, 500, 1000, 10000, 20000, 1000000], [10, 25, 50, 100, 200, 500, 1000, 10000, 20000, "All"]],
        //dom: 'Blfrtip',
        dom: 'lBf<"custom_column_button">rtip',
        order: [[ 1, "desc" ], [ 4, "desc" ]],
        //stateSave: true,
        buttons: [
            { extend: "excel", text: '<i class="fa fa-file-excel"> Excel</i>', className: "btn-sm btn-info", title: $('h2:first').text() },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf"> PDF</i>',
                title: $('h2:first').text(),
                className: "btn-sm btn-danger",
                orientation: 'landscape', /*portrait*/
                pageSize: 'A4', /*A3 , A5 , A6 , legal , letter*/
                // download: 'open', /*open in new window*/
                exportOptions: { columns: ':not(.no-print)' },
            },
            {
                extend: "print",
                text: '<i class="fa fa-print"> Print</i>',
                title: $('h2:first').text(),
                className: "btn-sm btn-warning",
                footer: true,

                //messageTop: 'This print was produced using the Print button for DataTables',
                exportOptions: {
                    columns: ':not(.no-print)',
                    modifier: {
                        page: 'current',
                        columns: [2, 3, 4, 5, 6, 7, 8, 9, ':visible'],
                        orientation: 'landscape', /*portrait*/
                    }
                },
                customize: function (win) {
                    $(win.document.body).css('font-size', '10pt').prepend('<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />');
                    //$(win.document.body).find( 'table' ).addClass( 'compact' ).css( 'font-size', 'inherit' );
                    $(win.document.body).find('table').addClass('display').css('font-size', '9px');
                    $(win.document.body).find('table thead th').css({"background-color": "#666", "color": "#fff"});
                    $(win.document.body).find('tr:nth-child(odd) td').each(function (index) {
                        $(this).css('background-color', '#D0D0D0');
                    });
                    $(win.document.body).find('h1').css('text-align', 'center');
                }
            },
        ],
        language: {
            decimal: ".", thousands: ",",
            //emptyTable:     "No data available in table",
            info:           "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty:      "Showing 0 to 0 of 0 entries",
            infoFiltered:   "(filtered from _MAX_ total entries)",
            infoPostFix:    "",
            lengthMenu:     "Show _MENU_ entries",
            loadingRecords: "Loading...",
            processing:     "Processing, Please Wait...",
            search:         "Search:",
            zeroRecords:    "No matching records found",
            paginate: { first: "First", last: "Last", next: "<i class='fa fa-chevron-right'></i>", previous: "<i class='fa fa-chevron-left'></i>" },
            aria: { sortAscending:  ": activate to sort column ascending", sortDescending: ": activate to sort column descending" }
        },
    });

    //index counter (Serial No.)
    table.on( 'order.dt search.dt', function () {
        table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
            table.cell(cell).invalidate('dom'); //show number to print/ pdf page
        } );
    }).draw();
}); //End of Document ready

$(document).ready(function(){
    $(document).on('click', 'button.editUser', function () {
        var id = $(this).attr('id');
        var modal = $("#editUserModal");

        $.ajax({
            url: "{{ url('/admin/edit-user') }}/"+id,
            method: "get",
            dataType: "json",
            success: function( response ) {
                modal.find('.modal-title').text( "Update User" );
                modal.find('input[name=user_id]').val( response[0].id );
                modal.find('input[name=user_photo_prev]').val( response[0].user_photo );
                modal.find('#username').val( response[0].name );
                modal.find('#mobile').val( response[0].mobile );
                modal.find("select#role_id option[value=" + response[0].role_id +"]").prop("selected", true);
                modal.find('#dob_edit').val( response[0].dob ? response[0].dob.split('-')[2]+"/"+response[0].dob.split('-')[1]+"/"+response[0].dob.split('-')[0] : "" );
                modal.find("select#gender option[value=" + response[0].gender +"]").prop("selected", true);
                modal.find('#national_id').val( response[0].nid );
                modal.find('#email').val( response[0].email );
                modal.find('#user_photo_prev').val( response[0].user_photo );
                modal.find('#user_photo').parent('.custom-file').find('label.custom-file-label').html( response[0].user_photo ? response[0].user_photo : "No Attachment"  );
                if(response[0].ip_access === "on"){
                    modal.find('input#ip_access_edit').attr('checked', true);
                    modal.find('.ip_access_item').slideDown('slow');
                } else {
                    modal.find('input#ip_access_edit').attr('checked', false);
                    modal.find('.ip_access_item').slideUp('slow');
                }
                modal.find('#user_start_time').val( response[0].user_start_time );
                modal.find('#user_end_time').val( response[0].user_end_time );
                modal.find('#ip_address').val( response[0].ip_address );
                modal.find('#mac_address').val( response[0].mac_address );

                modal.modal({ backdrop: "static", keyboard: true });
                modal.on('shown.bs.modal', function(){ $(":input[type='text']:enabled:visible:first").focus(); });
            },
            statusCode:{ 404: function(){ alert( "page not found" ); } },
            beforeSend: function( xhr ) { $(".ajax-loader").show(); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
        });
    });


    $("form#update_user_form").submit(function (event) {
        event.preventDefault();

        var form = $(this);
        var data = form.serialize();
        var user_id = form.find('input[name="user_id"]').val();

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            url: "{{ URL('/admin/update-user-save') }}/"+user_id,
            method: "post",
            data: data,
            dataType: "json",
            success: function( response ) {
                $("table.user_management_table").find('tbody').find("tr#"+ response[0].id).html(
                    '<td>'+ response.row_index +'</td>'
                    + '<td>'+ response[0].entry_date +'</td>'
                    + '<td>'+ response[0].voucher_number +'</td>'
                    + '<td>'+ response.account_head_name +'</td>'
                    + '<td>'+ ( response[0].party_type ? response[0].party_type : '-') +'</td>'
                    + '<td>'+ response[0].party_name +'</td>'
                    + '<td>'+ (response[0].description ? response[0].description : '-') +'</td>'
                    + '<td>'+ (response[0].debit > 0 ? response[0].debit : '-') +'</td>'
                    + '<td>'+ '-' +'</td>'
                    + '<td data-balance="'+ response.total_balance +'">'+ response.total_balance +'</td>'
                    + '<td>'
                    + '<button type="button" class="btn btn-warning btn-sm edit-daily-expense" id="'+ response.cashbook_id +'"><i class="fa fa-edit" aria-hidden="true"></i></button>'
                    + '<button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="<?php echo URL::to('/account/delete-daily-expense/'); ?>'+ response.cashbook_id +'" data-title="'+ response.account_head_name +'" id="'+ response.cashbook_id +'"><i class="fa fa-trash" aria-hidden="true"></i></button>'
                    + '</td>'
                );
                toastr.success( response.success );
                form.parents('.modal').modal("hide");
                form.trigger('reset');
            },
            statusCode:{ 404: function(){ alert( "page not found" ); } },
            beforeSend: function( xhr ) { $(".ajax-loader").show(); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
        });
        return false;
    });


    $(document).on('click', 'button.view-user', function () {
        var url = $(this).data('url');
        var id = $(this).attr('id');
        var modal = $("#view_user_modal");

        $.ajax({
            url: url,
            method: "get",
            //data: { id: id },
            dataType: "json",
            cache:false,
            async: false,
            success: function( response ) {
                modal.find('.modal-title').text( "View User ("+ response[0].name +")" );
                modal.find('#preview_image').attr('src', (response[0].user_photo ? '{{ upload_url("user-photo") }}' +"/"+ response[0].user_photo : "{{ image_url('defaultAvatar.jpg') }}" ));
                modal.find('.username').text( response[0].name ? response[0].name : "" );
                modal.find('.mobile').text( response[0].mobile ? response[0].mobile : "" );
                modal.find('.role_name').text( response.role_name ? response.role_name : "" );
                modal.find('.dob').text( response[0].dob ? response[0].dob.split('-')[2]+"/"+response[0].dob.split('-')[1]+"/"+response[0].dob.split('-')[0] : "" );
                modal.find('.email').text( response[0].email ? response[0].email : "" );
                modal.find('.account_create_date').text( response[0].created_at ? response[0].created_at.split('-')[2]+"/"+response[0].created_at.split('-')[1]+"/"+response[0].created_at.split('-')[0] : "" );
                modal.find('.gender').text( response[0].gender ? response[0].gender : "" );
                modal.find('.nid').text( response[0].nid ? response[0].nid : "" );
                modal.find('.nid').html( response[0].nid ? response[0].nid +'<a class="btn btn-sm btn-outline-info ml-5" href="https://services.nidw.gov.bd/voter_center" target="_blank">Check NID</a>' : "");
                modal.find('.device').text( response[0].device ? response[0].device : "" );
                modal.find('.last_login_date').text( response[0].last_login_at ? response[0].last_login_at : "" );
                modal.find('.last_login_ip').text( response[0].last_login_ip ? response[0].last_login_ip : "" );

                modal.find('.ip_access').html( response[0].ip_access !== "on" ? "<p class='text-danger'>IP Access & Time Restriction is deactivated.</p>" : "<p class='text-info'>IP Access & Time Restriction is activated</p>");
                modal.find('.user_start_time').text( response[0].user_start_time ? response[0].user_start_time : "" );
                modal.find('.user_end_time').text( response[0].user_end_time ? response[0].user_end_time : "" );
                modal.find('.ip_address').text( response[0].ip_address ? response[0].ip_address : "" );
                modal.find('.mac_address').text( response[0].mac_address ? response[0].mac_address : "" );

                modal.modal("show");
            },
            beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
        });
    });
}); //End of Document ready


$(document).ready(function(){
    $(document).on('click', 'button.changePasswordByadmin', function (event) {
        event.preventDefault();

        var modal = $("#changePasswordByadminModal");

        modal.find('input[name=user_id]').val( $(this).attr('id') );
        modal.modal('show');
    });

    $("form#changePasswordByadmin").submit(function (event) {
        event.preventDefault();
        //$("button[type=submit]").attr('disabled', 'disabled').html("<i class='fa fa-floppy-disk'></i> Saving...");

        var form = $(this);
        var id = $(this).attr('id');
        var modal = $("#changePasswordByadminModal");

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            url: "{{ url('admin/change-password-byadmin') }}/"+id,
            method: form.attr('method'),
            data: form.serialize(),
            //data: { _method: 'PUT', id: id, data: data },
            dataType: "json",
            cache:false,
            async: false,
            success: function( response ) {
                if ( response.status === 'success' ) {
                    toastr.success( response.success );
                    modal.modal('hide');
                    //$("button[type=submit]").removeAttr('disabled').html("<i class='fa fa-save'></i> Change Status");
                }
                if ( response.fail ) { modal.find('input').addClass('error'); }
            },
            error: function( errorThrown, xhr, data ) {
                $('.alert.alert-danger').fadeIn('slow').delay(3000).hide('slide', {direction: 'down'}, 1000);
                console.log(xhr.responseText);
                if( data.status === 422 ) { toastr.error('Cannot delete the category'); }
            },
            beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
        });
        return false;
    });

    $(document).on("change click", "input#ip_access, input#ip_access_edit", function(){
        var modal = $(this).parents('.modal');
        if($( this ).is( ":checked" )){
            modal.find(".ip_access_item").slideDown('slow');
        }else{
            modal.find(".ip_access_item").slideUp('slow');
        }
    }).change();
}); //End of Document ready



$(document).ready(function(){
    $(document).on('click', 'button.change-status', function (e) {
        e.preventDefault();

        var modal = $("#user_status_modal");
        //if( $(this).text() == "Approved" ) return;

         modal.find("select#user_status option[value=" + $(this).text().toLowerCase() +"]").prop("selected", true);
        modal.find('input[name=user_id]').val( $(this).attr('id') );
        modal.modal('show');
    });

    $("form#change-status").submit(function (event) {
        event.preventDefault();
        $("button[type=submit]").attr('disabled', 'disabled').html("<i class='fa fa-floppy-disk'></i> Saving...");

        var form = $(this);
        var user_status = form.find('#user_status').val();
        var id = form.find('input[name=user_id]').val();
        var url = form.attr("action");

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            type: "POST",
            url: "{{ URL::to('/admin/change-status') }}",
            data: {user_id: id, user_status: user_status},
            dataType: 'json',
            success: function (data) {
                $("button#"+id+".change-status").text( data.status );
                var status_class = data.status == 'pending' ? "btn-warning" : (data.status == 'denied' ? "btn-danger" : "btn-success" );
                $("button#"+id+".change-status").removeAttr('class').attr('class', 'btn btn-sm change-status '+ status_class);
                toastr.success( data.success );
                $('#user_status_modal').modal('hide');
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
