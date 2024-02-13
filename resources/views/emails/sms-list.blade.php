@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInRight">
        <div class="box-header with-border">
            <h2 class="box-title">SMS List</h2>
            <div class="box-tools float-right">
                <div class="float-left" style="margin-right: 5px; width: 130px;">
                    <select id="phone_prefix_filter" class="custom-select custom-select-sm" onchange="filter_column_serverside(this.value, 'sms_datatable')">
                        <option value="">--Select Operator--</option>
                        <option value="GP - 017">GP - 017</option>
                        <option value="GP - 013">GP - 013</option>
                        <option value="BL - 019">BL - 019</option>
                        <option value="BL - 014">BL - 014</option>
                        <option value="Robi - 018">Robi - 018</option>
                        <option value="Robi - 016">Robi - 016</option>
                        <option value="Teletalk - 015">Teletalk - 015</option>
                    </select>
                </div>
                <div class="float-left" style="margin-right: 5px; width: 150px;">
                    <select id="recipient_filter" class="custom-select custom-select-sm" onchange="filter_column_serverside(this.value, 'sms_datatable')">
                        @php $group_names = DB::table('contact_groups')->orderBy('group_name', 'ASC')->pluck("group_name", "group_id") @endphp
                        <option value="">--Select Recipient--</option>
                        <option value="all-Riders">All Riders</option>
                        <option value="all-drivers">All Drivers</option>
                        <option value="all-agents">All Agents</option>
                        @foreach( $group_names as $key => $name )
                            <option value="{{ $name }}">{{ ucwords($name) }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="button" class="btn btn-dark btn-sm showNewsmsModal" data-toggle="tooltip" data-placement="top" title="Add New sms Modal"><i class="fa fa-user-plus"></i> New SMS</button>
                <button type="button" class="btn btn-box-tool" id="refreshDatatable" data-toggle="tooltip" data-placement="top" title="Refresh Datatable"><i class="fa fa-sync-alt"></i></button>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->

        <div class="box-body">
            <table id="sms_datatable" class="table table-striped table-custom">
                <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        <th>Trx ID</th>
                        <th style="width: 200px;">Subject</th>
                        <th>Sender ID</th>
                        <th>Receiver</th>
                        <th>SMS Time</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <!--  -->
                </tbody>
            </table>
        </div><!-- /.box-body -->

        <div class="overlay" style="display: none;">
            <i class="fa fa-sync-alt fa-spin"></i>
        </div>
    </div><!-- /.box -->
</section>

@include('emails.sms-new-modal')
@include('emails.sms-view-modal')
@endsection


@section('custom_js')
<script type="text/javascript">
function moveCursorToEnd(input) {
    var originalValue = input.val();
    input.val('');
    input.blur().focus().val(originalValue);
}

$(document).ready(function(){
    var table = $('#sms_datatable').DataTable({
        processing: true,
        serverSide: true,
        "ajax": {
            "url": "{{ url('notification/sms-list-data') }}",
            "dataType": "json",
            "type": "POST",
            cache: true,
            {{--"data":{ _token: "{{ csrf_token() }}"},--}}
            data: function (d) {
                d.phone_prefix_filter = $('#phone_prefix_filter').val(),
                d.recipient_filter = $('#recipient_filter').val(),
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
            //{data: 'DT_RowClass', orderable:false, searchable:false, "class": "hide"}, /*DT_RowIndex, DT_RowId, DT_RowClass, DT_RowData */
            { data: 'sms_id', orderable:false, searchable:false},
            { data: 'trx_id', },
            { data: 'subject', },
            { data: 'sender', },
            { data: 'receiver', },
            { data: 'sent_time', },
            { data: 'status', },
            { data: 'action', orderable:false, searchable:false, "width": "60px", "class": "no-print" }
        ],
        // "createdRow": function( row, data, dataIndex ) {
        //     if ( data[9] >1000 ){ $('td', row).eq(9).css({'color':'red'}); }
        // },
        // columnDefs: [
        //     { responsivePriority: 1, targets: 0 },
        //     { responsivePriority: 2, targets: 1 },
        //     { responsivePriority: 3, targets: 2 },
        //     { responsivePriority: 4, targets: 4 },
        //     { responsivePriority: 5, targets: 5 },
        //     { responsivePriority: 6, targets: 6 },
        //     { responsivePriority: 7, targets: 8 },
        //     { responsivePriority: 8, targets: 9 },
        //     { responsivePriority: 10, targets: -1 }
        // ],
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
        order: [[ 5, "desc" ]],
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


    $(document).on('click', '#refreshDatatable', function () {
        table.ajax.reload();
        //table.ajax.reload( null, false );
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
    $('button.showNewsmsModal').on('click', function () {
        var modal = $("#newsmsModal");

        modal.modal({ backdrop: "static", keyboard: true });
        modal.on('shown.bs.modal', function(){ moveCursorToEnd($("input[type='number']")); });
    });


    $("form#send-sms-form").submit(function (event) {
        event.preventDefault();
        //$("button[type=submit]").attr('disabled', 'disabled').html("<i class='fa fa-paper-plane'></i> Sending Message...");

        var form = $(this);

        $.ajax({
            type: "POST",
            url: form.attr("action"),
            data: form.serialize(),
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (response) {
                var sms_table_tr = '<tr>';
                sms_table_tr += '<td>0</td>';
                sms_table_tr += '<td><input type="checkbox" name="id[]" id="{ $sms->sms_id }}" class="filled-in" value="{ $sms->sms_id }}" /><label for="{ $sms->sms_id }}"></label></td>';
                sms_table_tr += '<td>'+response[0].sender+'</td>';
                sms_table_tr += '<td>'+response[0].receiver+'</td>';
                sms_table_tr += '<td>'+response[0].sms_date+'</td>';
                sms_table_tr += '<td>'+response[0].subject+'</td>';
                sms_table_tr += '<td>'+response[0].message_body+'</td>';
                sms_table_tr += '<td>'+response[0].sms_type+'</td>';
                sms_table_tr += '<td>'+response[0].user_id+'</td>';
                sms_table_tr += "</tr>";

                $("table.sms-list-table tbody").prepend(sms_table_tr);
                $("table.sms-list-table tbody tr:first").hide().delay("slow").fadeIn();

                toastr.success( response.success );
                $('#newsmsModal').modal('hide');
                $("button[type=submit]").removeAttr('disabled').html("<i class='fa fa-paper-plane'></i> Send Message");
            },
            statusCode:{ 404: function(){ alert( "page not found" ); } },
            error: function (xhr, textStatus, errorThrown) { alert(errorThrown); },
            beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
        });
        return false;
    });


    $(document).on('keyup', '#message_body', function(e) {
        var len = $(this).val().length + 1;
        var total = 1500;

        if(len > 1) { $(".sms-counter-wrap").slideDown('slow'); }else{ $(".sms-counter-wrap").slideUp('5000'); }
        $('.charCount').text(len +" Characters | "+ parseInt(total - len) +" Characters Left");
        $('.smsCount').text(" | "+ parseInt((len/153)+1) +" SMS (153 Char./SMS)");
    });


    $(document).on("change", "#recipient_type", function(){
        if($(this).val() === 'group_recipient'){
            $('.phone_number').slideUp('slow');
            $('.contact_group').slideDown('slow');
            $('#phone_number').removeAttr('required');
            $('#contact_group').attr({required: 'required'});
        }
        else {
            $('.phone_number').slideDown('slow');
            $('.contact_group').slideUp('slow');
            $('#contact_group').removeAttr('required');
            $('#phone_number').attr({required: 'required'});
        }
    }).change();


    $(document).on("change", "#contact_group", function(){
        if($(this).val() === '') {
            $("#smsCheckMessage").hide();
            $("#smsCheckMessage").find('#smsRecipientCount').text('');
        } else {
            $("#smsCheckMessage").show();
            $("#smsCheckMessage").find('#smsRecipientCount').text($(this).find(':selected').data('recipient_count'));
        }
    }).change();


    $(document).on('click', 'button.viewSMS', function () {
        var id = $(this).attr('id');
        var modal = $("#view_sms_modal");
        modal.modal("show");

        $.ajax({
            url: "{{ url('/notification/view-sms') }}/" + id,
            method: "get",
            dataType: "json",
            success: function( response ) {
                modal.find('.modal-title').text( "View Details of SMS ("+ response[0].subject +")" );
                modal.find('.sms_title').text( response[0].subject );
                modal.find('.message_body').text( response[0] ? response[0].message_body : "-" );
                modal.find('.sender').text( response[0] ? response[0].sender : "-" );
                modal.find('.receiver').text( response[0].receiver ? response[0].receiver.replace('_', ' ').replace('-', ' ') : "-" );
                modal.find('.sms_type').text( response[0] ? response[0].sms_type : "-" );
                modal.find('.user').text( response[0] ? response[0].user_name : "-" );
                modal.find('.sms_sent_time').text( response[0].sent_time ? response[0].sent_time.split('-')[2]+"/"+response[0].sent_time.split('-')[1]+"/"+response[0].sent_time.split('-')[0] : "-" );

                modal.modal("show");
            },
            beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
        });
    });
}); //End of Document ready

</script>
@endsection
