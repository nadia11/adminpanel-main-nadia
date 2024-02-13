@extends('dashboard')
@section('main_content')

<div class="content-wrapper">
    <section class="content">
        <div class="box box-success animated fadeInRight">
            <div class="box-header with-border">
                <h2 class="box-title">Showing All Employee</h2>
                <div class="box-tools float-right">
                    <div class="float-left" style="margin-right: 5px; width: 110px;">
                        <select id="department_filter" class="custom-select custom-select-sm" onchange="filter_column_serverside(this.value, 'employee_datatable')">
                            <option value="">--Department--</option>
                            <?php $departments = DB::table('departments')->orderBy('department_name', 'ASC')->pluck("department_name", "department_id"); ?>

                            @foreach($departments as $id => $name )
                                <option value="{{ $name }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="float-left" style="margin-right: 5px; width: 120px;">
                        <select id="designation_filter" class="custom-select custom-select-sm" onchange="filter_column_serverside(this.value, 'employee_datatable')">
                            <option value="">--Designation--</option>
                            @php $designations = DB::table('designations')->orderBy('designation_name', 'ASC')->pluck("designation_name", "designation_id") @endphp

                            @foreach($designations as $id => $name )
                                <option value="{{ $name }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="float-left" style="margin-right: 5px; width: 80px;">
                        <select id="gender_filter" class="custom-select custom-select-sm" onchange="filter_column_serverside(this.value, 'employee_datatable')">
                            <option value="">--Gender--</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="others">Others</option>
                        </select>
                    </div>
                    <div class="float-left" style="margin-right: 5px; width: 115px;">
                        <select id="blood_group_filter" class="custom-select custom-select-sm" onchange="filter_column_serverside(this.value, 'employee_datatable')">
                            <option value="">--Blood Group--</option>
                            <option value="a_pos">A+</option>
                            <option value="a_neg">A-</option>
                            <option value="b_pos">B+</option>
                            <option value="b_neg">B-</option>
                            <option value="o_pos">O+</option>
                            <option value="o_neg">O-</option>
                            <option value="ab_pos">AB+</option>
                            <option value="ab_neg">AB-</option>
                            <option value="n_a">N/A</option>
                        </select>
                    </div>

                    <div class="float-left" style="margin-right: 5px; width: 120px;">
                        <select id="marital_status_filter" class="custom-select custom-select-sm" onchange="filter_column_serverside(this.value, 'employee_datatable')">
                            <option value="">--Marital Status--</option>
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Divorced">Divorced</option>
                        </select>
                    </div>

                    <div class="float-left" style="margin-right: 5px; width: 110px;">
                        <select id="employee_status_filter" class="custom-select custom-select-sm" onchange="filter_column_serverside(this.value, 'employee_datatable')">
                            <option value="">--User Status--</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="denied">Denied</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#departmentModal"><i class="fa fa-box"></i> Department</button>
                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#designationModal"><i class="fa fa-tags"></i> Designation</button>
                    <a href="{{ URL::to('/employee/employee-bank-account') }}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Employee Bank Account"><i class="fa fa-plus"></i> Employee Bank Account</a>
                    <button type="button" class="btn btn-dark btn-sm showNewEmployeeModal" data-toggle="tooltip" data-placement="top" title="Add New Employee Modal"><i class="fa fa-user-plus"></i> New Employee</button>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->

            <div class="box-body">
                <table id="employee_datatable" class="table table-custom">
                    <thead class="thead-inverse">
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            {{--<th>Card ID</th>--}}
                            <th>Employee Name</th>
                            <th>District Name</th>
                            <th>Mobile</th>
                            <th>Branch</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Gender</th>
                            <th>Joining Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <!-- Employee Data Here -->
                    </tbody>
                </table>
            </div><!-- /.box-body -->

            <div class="overlay" style="display: none;">
                <i class="fa fa-sync-alt fa-spin"></i>
            </div>
        </div><!-- /.box -->
    </section>
</div>

@include('pages.employees.employee-new-modal')
@include('pages.employees.employee-edit-modal')
@include('pages.employees.department-modal')
@include('pages.employees.designation-modal')

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

    var table = $('#employee_datatable').DataTable({
        processing: true,
        serverSide: true,
        "ajax": {
            url: "{{ url('/employee/employee-management-ajax-data') }}",
            dataType: "json",
            type: "POST",
            cache: true,
            {{--"data":{ _token: "{{ csrf_token() }}"},--}}
            data: function (d) {
                d.department_filter = $('#department_filter').val(),
                d.designation_filter = $('#designation_filter').val(),
                d.gender_filter = $('#gender_filter').val(),
                d.blood_group_filter = $('#blood_group_filter').val(),
                d.marital_status_filter = $('#marital_status_filter').val(),
                d.employee_status_filter = $('#employee_status_filter').val(),
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
            {data: 'DT_RowClass', orderable:false, searchable:false, "class": "hide"}, /*DT_RowIndex, DT_RowId, DT_RowClass, DT_RowData */
            { data: 'employee_id', orderable:false, searchable:false},
            { data: 'employee_name', },
            { data: 'district_name', },
            { data: 'employee_mobile', },
            { data: 'branch_id', },
            { data: 'department_name', },
            { data: 'designation_name', },
            { data: 'employee_gender', },
            { data: 'joining_date', },
            { data: 'employee_status', orderable:false, searchable:false },
            { data: 'action', orderable:false, searchable:false, "width": "130px", "class": "no-print" }
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
        order: [[ 5, "ASC" ], [ 6, "ASC" ]], /*desc*/
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
                    $(win.document.body).find('tr:nth-child(odd) td').each(function (index) { $(this).css('background-color', '#D0D0D0'); });
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
    $('button.showNewEmployeeModal').on('click', function () {
        var modal = $("#newEmployeeModal");
        modal.modal({ backdrop: "static", keyboard: true });
        modal.on('shown.bs.modal', function(){ $(":input[type='text']:enabled:visible:first").focus(); });
    });
}); //End of Document ready


$(document).ready(function (){
    $('select[name="division_id"]').on('change', function(){
       var division_id = $(this).val();

        $.ajax({
            url : "{{ url('/employee/get_district') }}/" + division_id,
            type : "GET",
            dataType : "json",
            data: {id: division_id },
            success:function( data ){
                $('select[name="district_id"]').empty();
                var district = '<option value="" selected="selected">--Select District--</option>';
                $.each(data, function(key, value){
                    district += '<option value="'+ key +'">'+ value +'</option>';
                });
                $('select[name="district_id"]').append( district );
            },
            beforeSend: function( xhr ) { $('select#district_id').parents(".input-group").append('<i class="loader-spin fa fa-spin fa-spinner fa-lg" style="position: absolute; left: 92%; top:28%; background: #fff;"></i>'); },
            complete: function( jqXHR, textStatus ) { $('.loader-spin').delay(1000).hide('slow'); $('.loader-spin').remove(); },
        });
    });

    $(document).on('click', 'button.editEmployee', function () {

        var id = $(this).attr('id');
        var modal = $("#editEmployeeModal");

        $.ajax({
            url: "{{ url('/employee/edit-employee/') }}",
            method: "get",
            data: { id: id },
            dataType: "json",
            success: function( response ) {
                modal.find('.modal-title').text( "Update Employee" );
                modal.find('input[name=employee_id]').val( response[0].employee_id );
                modal.find("select#employee_type option[value=" + response[0].employee_type +"]").prop("selected", true);
                modal.find('#employee_name').val( response[0].employee_name );
                modal.find('#employee_code').val( response[0].employee_code );
                modal.find('#cardID').val( response[0].cardID );
                modal.find('#employee_fathers_name').val( response[0].employee_fathers_name );
                modal.find('#employee_mothers_name').val( response[0].employee_mothers_name );
                modal.find('#employee_mobile').val( response[0].employee_mobile );
                modal.find('#employee_alt_mobile').val( response[0].employee_alt_mobile );
                modal.find('#employee_email').val( response[0].employee_email );
                modal.find("select#department_id option[value=" + response[0].department_id +"]").prop("selected", true);
                modal.find('select#designation_id').html('<option value="'+ response[0].designation_id+'">'+ response.designation_name +'</option>');
                modal.find("select#employee_gender option[value=" + response[0].employee_gender +"]").prop("selected", true);
                modal.find("select#marital_status option[value=" + response[0].marital_status +"]").prop("selected", true);
                if(response[0].employee_dob){ modal.find('#employee_dob').val( response[0].employee_dob.split('-')[2]+"/"+response[0].employee_dob.split('-')[1]+"/"+response[0].employee_dob.split('-')[0] ); }
                modal.find('#blood_group').val( response[0].blood_group );
                modal.find('#employee_religion').val( response[0].employee_religion );
                modal.find('#employee_nationality').val( response[0].employee_nationality );
                modal.find('#employee_nid').val( response[0].employee_nid );
                modal.find('#birth_certificate').val( response[0].birth_certificate );
                modal.find('#passport_no').val( response[0].passport_no );
                if(response[0].joining_date){ modal.find('#joining_date').val( response[0].joining_date.split('-')[2]+"/"+response[0].joining_date.split('-')[1]+"/"+response[0].joining_date.split('-')[0] ); }
                modal.find('#blood_group').val( response[0].blood_group );
                modal.find('#employee_photo_prev').val( response[0].employee_photo );
                modal.find('#employee_photo').parent('.custom-file').find('label.custom-file-label').html( response[0].employee_photo ? response[0].employee_photo : "No Attachment"  );

                modal.find('select#district_id').html( '<option value="'+response[0].district_id+'">'+response[0].district_name+'</option>' );
                modal.find("select#division_id option[value=" + response[0].division_id +"]").prop("selected", true);
                modal.find('#employee_address').val( response[0].employee_address );

                modal.modal({ backdrop: "static", keyboard: true });
                modal.on('shown.bs.modal', function(){ $(":input[type='text']:enabled:visible:first").focus(); });
            },
            statusCode:{ 404: function(){ alert( "page not found" ); } },
            beforeSend: function( xhr ) { $(".ajax-loader").show(); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
        });
    });
}); //End of Document ready


$(document).ready(function(){

    $(document).on("click", "button#create_department", function(event){
        event.preventDefault();
        var department_name = $(this).parents('.modal-footer').find('#department_name').val();
        var token = $('meta[name="csrf-token"]').attr('content');

        if(!department_name) return;

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            type: "POST",
            url: "{{ url('/employee/new-department-save') }}",
            data: {department_name: department_name, _token: token} ,
            dataType: 'json',
            success: function (data) {
                $("#department_table").find('tbody').prepend(
                    '<tr id="cat-'+ data[0].department_id +'">'
                    + '<td>'+ data[0].department_id +'</td>'
                    + '<td>'+ data[0].department_name +'</td>'
                    + '<td><a href="<?php echo URL::to('/employee/department/view-employee'); ?>/'+data[0].department_id+'" target="_blank">View Employee</a></td>'
                    + '<td>'+ 0 +'</td>'
                    + '<td>'
                    + '<button type="button" class="btn btn-warning btn-sm btn-flat editDepartment" id="'+ data[0].department_id +'" style="margin: 5px 0;"><i class="fa fa-edit" aria-hidden="true"> Edit</i></button>'
                    + '<button type="button" class="btn btn-danger btn-sm btn-flat ajaxDelete" data-href="<?php echo URL::to('/employee/delete-department'); ?>/'+ data[0].department_id +'" data-title="'+ data[0].department_name +'" id="'+ data[0].department_id +'" style="margin: 5px 0;"><i class="far fa-trash-alt" aria-hidden="true"> Delete</i></button>'
                    + '</td>'
                    + '</tr>'
                );
                $("#department_name").val('');
                $(":input[type='text']:enabled:visible:first").focus();
            },
            error: function (xhr, textStatus, errorThrown) { alert(errorThrown); }
        });
    });


    $(document).on('click', 'button.editDepartment', function () {
        var id = $(this).attr('id');

        $.ajax({
            url: "{{ url('employee/edit-department') }}/" + id,
            method: "get",
            dataType: "json",
            success: function( response ) {
                $("#department_table tr#cat-" + response.department_id).html(
                    '<td colspan="4"><input type="text" name="department_name" id="department_name" value="'+ response.department_name +'" class="form-control" /></td>'
                    + '<td>'
                    + '<button type="button" class="btn btn-purple btn-sm btn-flat updateDepartment" id="'+ response.department_id +'" style="margin: 5px 0;"><i class="fa fa-edit" aria-hidden="true"> Save</i></button>'
                    + '<button type="button" class="btn btn-tomato btn-sm btn-flat cancelUpdateDepartment" id="'+ response.department_id +'" style="margin: 5px 0;"><i class="fa fa-times" aria-hidden="true"> Cancel</i></button>'
                    + '</td>'
                );
            },
            statusCode:{ 404: function(){ alert( "page not found" ); } },
            beforeSend: function( xhr ) { $(".ajax-loader").show(); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
        });
    });


    $("body").on("click", "button.updateDepartment", function(){
        var id = $(this).attr('id');
        var department_name = $(this).closest('tr').find('#department_name').val();
        var token = $('meta[name="csrf-token"]').attr('content');

        if (!confirm("Are you sure want to update this record?")) return;

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            type: "POST",
            url: "{{ url('employee/update-department') }}",
            data: { id: id, department_name: department_name, _token: token },
            success: function (data) {
                $("#department_table tr#cat-" + data[0].department_id).html(
                    '<td>'+ data[0].department_id +'</td>'
                    + '<td>'+ data[0].department_name +'</td>'
                    + '<td><a href="<?php echo URL::to('/employee/department/view-employee'); ?>/'+data[0].department_id+'" target="_blank">View Employee</a></td>'
                    + '<td>'+ 0 +'</td>'
                    + '<td>'
                    + '<button type="button" class="btn btn-warning btn-sm btn-flat editDepartment" id="'+ data[0].department_id +'" data-url="{{ url('employee/edit-department') }}/'+ data[0].department_id +'" style="margin: 5px 0;"><i class="fa fa-edit" aria-hidden="true"> Edit</i></button>'
                    + '<button type="button" class="btn btn-danger btn-sm btn-flat ajaxDelete" data-href="{{ URL::to('/employee/delete-department') }}/'+ data[0].department_id +'" data-title="'+ data[0].department_name +'" id="'+ data[0].department_id +'" style="margin: 5px 0;"><i class="far fa-trash-alt" aria-hidden="true"> Delete</i></button>'
                    + '</td>'
                );
            },
            error: function (xhr, textStatus, errorThrown) { alert(errorThrown); }
        });
    });


    $("body").on("click", "button.cancelUpdateDepartment", function(){
        var id = $(this).attr('id');

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            type: "get",
            url: "{{ url('employee/cancel-update-department') }}",
            data: { id: id },
            success: function (data) {
                $("#department_table tr#cat-" + data.department_id).html(
                    '<td>'+ data.department_id +'</td>'
                    + '<td>'+ data.department_name +'</td>'
                    + '<td><a href="<?php echo URL::to('/employee/department/view-employee'); ?>/'+data.department_id+'" target="_blank">View Employee</a></td>'
                    + '<td>'+ 0 +'</td>'
                    + '<td>'
                    + '<button type="button" class="btn btn-warning btn-sm btn-flat editDepartment" id="'+ data.department_id +'" data-url="{{ url('employee/edit-department') }}/'+ data.department_id +'" style="margin: 5px 0;"><i class="fa fa-edit" aria-hidden="true"> Edit</i></button>'
                    + '<button type="button" class="btn btn-danger btn-sm btn-flat ajaxDelete" data-href="{{ URL::to('/employee/delete-department') }}/'+ data.department_id +'" data-title="'+ data.department_name +'" id="'+ data.department_id +'" style="margin: 5px 0;"><i class="far fa-trash-alt" aria-hidden="true"> Delete</i></button>'
                    + '</td>'
                );
            },
            error: function (xhr, textStatus, errorThrown) { alert(errorThrown); }
        });
    });
}); //End of Document ready



$(document).ready(function(){
    $("body").on("click", "button#create_designation", function(event){
        event.preventDefault();
        var designation_name = $(this).parents('.modal-footer').find('#designation_name').val();
        var department_id = $(this).parents('.modal-footer').find('#department_id').val();
        var token = $('meta[name="csrf-token"]').attr('content');

        if(!designation_name) return;

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            type: "POST",
            url: "{{ url('/employee/new-designation-save') }}",
            data: { designation_name: designation_name, department_id:department_id, _token: token } ,
            dataType: 'json',
            success: function (data) {
                $("#designation_table").find('tbody').prepend(
                    '<tr id="cat-'+ data[0].designation_id +'">'
                    + '<td>'+ data[0].designation_id +'</td>'
                    + '<td>'+ data.department_name +'</td>'
                    + '<td>'+ data[0].designation_name +'</td>'
                    + '<td><a href="<?php echo URL::to('/employee/designation/view-employee'); ?>/'+data[0].designation_id+'" target="_blank">View Employee</a></td>'
                    + '<td>'+ 0 +'</td>'
                    + '<td>'
                    + '<button type="button" class="btn btn-warning btn-sm btn-flat editDesignation" id="'+ data[0].designation_id +'" style="margin: 5px 0;"><i class="fa fa-edit" aria-hidden="true"> Edit</i></button>'
                    + '<button type="button" class="btn btn-danger btn-sm btn-flat ajaxDelete" data-href="{{ URL::to('/employee/delete-designation') }}/'+ data[0].designation_id +'" data-title="'+ data[0].designation_name +'" id="'+ data[0].designation_id +'" style="margin: 5px 0;"><i class="far fa-trash-alt" aria-hidden="true"> Delete</i></button>'
                    + '</td>'
                    + '</tr>'
                );

                $("#designation_name").val('');
                $("select#department_id").val('');
                $(":input[type='text']:enabled:visible:first").focus();
            },
            error: function (xhr, textStatus, errorThrown) { alert(errorThrown); }
        });
    });


    $(document).on('click', 'button.editDesignation', function () {
        var id = $(this).attr('id');

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            url: "{{ url('employee/edit-designation') }}/" + id,
            method: "get",
            data: { id: id },
            dataType: "json",
            success: function( response ) {
                var designation_edit_data = "";

                designation_edit_data += '<td colspan="2">'
                designation_edit_data += '<select id="department_id" name="department_id" class="custom-select" required>'
                designation_edit_data += '<option value="">--Select Designation--</option>';
                $.each(response.department_info, function(key, value){
                    designation_edit_data += '<option value="'+ key +'"'+(response[0].department_id == key ? 'selected="selected"' : "")+'>'+ value +'</option>';
                });
                designation_edit_data += '</select>'
                designation_edit_data += '</td>'

                designation_edit_data += '<td><input type="text" name="designation_name" id="designation_name" value="'+ response[0].designation_name +'" class="form-control" /></td>'
                designation_edit_data += '<td>-</td>'
                designation_edit_data += '<td>-</td>'
                designation_edit_data += '<td>'
                designation_edit_data += '<button type="button" class="btn btn-purple btn-sm btn-flat updateDesignation" id="'+ response[0].designation_id +'" style="margin: 5px 0;"><i class="fa fa-edit" aria-hidden="true"> Save</i></button>'
                designation_edit_data += '<button type="button" class="btn btn-tomato btn-sm btn-flat cancelUpdateDesignation" id="'+ response[0].designation_id +'" style="margin: 5px 0;"><i class="fa fa-times" aria-hidden="true"> Cancel</i></button>'
                designation_edit_data += '</td>'

                $("#designation_table tr#cat-" + response[0].designation_id).html( designation_edit_data );
            },
            statusCode:{ 404: function(){ alert( "page not found" ); } },
            beforeSend: function( xhr ) { $(".ajax-loader").show(); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
        });
    });


    $("body").on("click", "button.updateDesignation", function(){
        var id = $(this).attr('id');
        var designation_name = $(this).closest('tr').find('#designation_name').val();
        var department_id = $(this).closest('tr').find('#department_id').val();
        var token = $('meta[name="csrf-token"]').attr('content');

        if (!confirm("Are you sure want to update this record?")){ return }

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            type: "POST",
            url: "{{ url('employee/update-designation') }}",
            data: { id: id, designation_name: designation_name, department_id:department_id, _token: token },
            success: function (data) {
                $("#designation_table tr#cat-" + data[0].designation_id).html(
                    '<td>'+ data[0].designation_id +'</td>'
                    + '<td>'+ data.department_name +'</td>'
                    + '<td>'+ data[0].designation_name +'</td>'
                    + '<td><a href="<?php echo URL::to('/employee/designation/view-employee'); ?>/'+data[0].designation_id+'" target="_blank">View Employee</a></td>'
                    + '<td>'+ 0 +'</td>'
                    + '<td>'
                    + '<button type="button" class="btn btn-warning btn-sm btn-flat editDesignation" id="'+ data[0].designation_id +'" data-url="{{ url('employee/edit-designation') }}/'+ data[0].designation_id +'" style="margin: 5px 0;"><i class="fa fa-edit" aria-hidden="true"> Edit</i></button>'
                    + '<button type="button" class="btn btn-danger btn-sm btn-flat ajaxDelete" data-href="{{ URL::to('/employee/delete-designation') }}/'+ data[0].designation_id +'" data-title="'+ data[0].designation_name +'" id="'+ data[0].designation_id +'" style="margin: 5px 0;"><i class="far fa-trash-alt" aria-hidden="true"> Delete</i></button>'
                    + '</td>'
                );
            },
            error: function (xhr, textStatus, errorThrown) { alert(errorThrown); }
        });
    });


    $("body").on("click", "button.cancelUpdateDesignation", function(){
        var id = $(this).attr('id');

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            type: "get",
            url: "{{ url('employee/cancel-update-designation') }}",
            data: { id: id },
            success: function (data) {
                $("#designation_table tr#cat-" + data[0].designation_id).html(
                    '<td>'+ data[0].designation_id +'</td>'
                    + '<td>'+ data.department_name +'</td>'
                    + '<td>'+ data[0].designation_name +'</td>'
                    + '<td><a href="<?php echo URL::to('/employee/designation/view-employee'); ?>/'+data[0].designation_id+'" target="_blank">View Employee</a></td>'
                    + '<td>'+ 0 +'</td>'
                    + '<td>'
                    + '<button type="button" class="btn btn-warning btn-sm btn-flat editDesignation" id="'+ data[0].designation_id +'" data-url="{{ url('employee/edit-designation') }}/'+ data[0].designation_id +'" style="margin: 5px 0;"><i class="fa fa-edit" aria-hidden="true"> Edit</i></button>'
                    + '<button type="button" class="btn btn-danger btn-sm btn-flat ajaxDelete" data-href="{{ URL::to('/employee/delete-designation') }}/'+ data[0].designation_id +'" data-title="'+ data[0].designation_name +'" id="'+ data[0].designation_id +'" style="margin: 5px 0;"><i class="far fa-trash-alt" aria-hidden="true"> Delete</i></button>'
                    + '</td>'
                );
            },
            error: function (xhr, textStatus, errorThrown) { alert(errorThrown); }
        });
    });

    $('select[name="department_id"]').on('change', function(){
        var department_id = $(this).val();

        $.ajax({
            url : "{{ url('employee/get-designation') }}/" + department_id,
            type : "GET",
            dataType : "json",
            data: {id: department_id },
            success:function( data ){
                $('select[name="designation_id"]').empty();
                var designation = '<option value="" selected="selected">--Select Designation--</option>';
                $.each(data, function(key, value){
                    designation += '<option value="'+ key +'">'+ value +'</option>';
                });
                $('select[name="designation_id"]').append( designation );
            },
            beforeSend: function( xhr ) { $('select#designation_id').parents(".input-group").append('<i class="loader-spin fa fa-spin fa-spinner fa-lg" style="position: absolute; left: 92%; top:28%; background: #fff;"></i>'); },
            complete: function( jqXHR, textStatus ) { $('.loader-spin').delay(1000).hide('slow'); $('.loader-spin').remove(); },
        });
    });
}); //End of Document ready
</script>
@endsection

