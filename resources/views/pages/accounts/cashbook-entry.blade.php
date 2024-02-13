@extends('dashboard')
@section('main_content')

<section class="cashbook-content" style="margin: 0 0 15px;">
    <ul class="floating-widget">
        <li><button type="button" class="btn btn-danger btn-square" data-toggle="tooltip" data-placement="left" title="Close Register"><i class="fa fa-times"></i></button></li>
        <li><button type="button" class="btn bg-ash btn-square" id="tempLoanModal" data-toggle="tooltip" data-placement="left" title="Emporary Temporary Loan"><i class="fa fa-user-tag"></i></button></li>
    </ul>
    <div class="member-mgmt-list">
        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#daily_expense" onclick="pushstate('#daily_expense')"><i class="fa fa-dollar-sign fa-lg"></i> Daily Expense</a></li>
            <li class="nav-item"><a class="nav-link test" data-toggle="tab" href="#employee_payment" onclick="pushstate('#employee_payment')"><i class="fa fa-user fa-lg"></i> Employee Payment</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#vendor_payment" onclick="pushstate('#vendor_payment')"><i class="fas fa-user-tie fa-lg"></i> Vendor Payment</a></li>
            <li class="nav-item text-right"><a class="nav-link bg-info" data-toggle="tab" href="#cash_receive" onclick="pushstate('#cash_receive')" style="margin-left: 70px; color: #fff;"><i class="fa fa-hand-holding-usd fa-lg"></i> Cash Receive</a></li>
        </ul>
        <div class="tab-content">
            <i class="fa fa-spin fa-spinner" style="display: none;"></i>

            <div class="tab-pane fade show animated fadeInRight active" id="daily_expense">
                @include('pages.accounts.tab-daily-expense')
            </div>
            <div class="tab-pane fade animated fadeInRight" id="employee_payment">
                @include('pages.accounts.tab-employee-payment')
            </div>
            <div class="tab-pane fade animated fadeInRight" id="vendor_payment">
                @include('pages.accounts.tab-vendor-payment')
            </div>
            <div class="tab-pane fade animated fadeInRight" id="cash_receive">
                @include('pages.accounts.tab-cash-receive')
            </div>
        </div>
    </div>
</section>


<section class="content" style="margin: 0 auto 70px;">
    <div class="box box-success">
        <div class="box-header with-border">
            <h2 class="box-title">Daily Cash Flow Statement</h2>
            <div class="box-tools float-right" style="margin-right: 0; width: 75%;">
                <div class="float-right" style="margin-right: 5px;">
                    <a class="btn btn-outline-danger btn-sm" href="{{ URL::to('/account/account-headwise-summery') }}" target="_blank"><i class="fa fa-list"></i> Account Head wise Summery</a>
                </div>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->

        <div class="box-body">
            <table id="general_datatable" class="table table-bordered table-custom cashbook_table table-sm">
                <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        <th style="width: 14%">Entry Date</th>
                        <th>Voucher Number</th>
                        <th>Head of Accounts</th>
                        <th>Party Type</th>
                        <th>Paid to</th>
                        <th>Description</th>
                        <th>Debit (BDT)</th>
                        <th>Credit (BDT)</th>
                        <th>Balance (BDT)</th>
                        <th data-orderable="false" class="no-print">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><th></th><th></th><th></th><th>Balance B/F</th><th></th><th></th><th></th><th></th><th></th><th><?php $balance_bf_query = DB::table('cashbook_entries')->whereDate('cashbook_entries.created_at', '<>', date('Y-m-d'))->select(DB::raw('SUM(credit) as credit, SUM(debit) as debit'))->first(); $balance_bf = $balance_bf_query->credit - $balance_bf_query->debit; echo taka_format('', $balance_bf); ?></th><th></th></tr>

                    @foreach($cashbook_infos as $cashbook_info)
                        <tr id="{{ $cashbook_info->cashbook_id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>@if($cashbook_info->created_at > 0) {{ date('d/m/Y h:i:s A', strtotime($cashbook_info->entry_date)) }} @endif</td>
                            <td>{{ isset( $cashbook_info->voucher_number ) ? $cashbook_info->voucher_number : "-" }}</td>
                            <td>{{ $cashbook_info->account_head_name }}</td>
                            <td class="text-capitalize">{{ isset( $cashbook_info->party_type ) ? $cashbook_info->party_type : "-" }}</td>
                            <td>{{ isset( $cashbook_info->party_name ) ? $cashbook_info->party_name : "-" }}</td>
                            <td>{{ $cashbook_info->description }}</td>
                            <td>{{ isset( $cashbook_info->debit ) ? taka_format('', $cashbook_info->debit ) : "-" }}</td>
                            <td>{{ isset( $cashbook_info->credit ) ? taka_format('', $cashbook_info->credit ) : "-" }}</td>
                            <td data-balance="<?php $new_balance = $cashbook_info->credit - $cashbook_info->debit; $balance_bf += $new_balance; echo $balance_bf; ?>">{{ taka_format('', $balance_bf ) }}</td>
                            <td style="width:70px;">
                                <button type="button" class="btn btn-warning btn-sm edit-{{$cashbook_info->entry_type }}" id="{{ $cashbook_info->cashbook_id }}"><i class="fa fa-edit" aria-hidden="true"></i></button>
                                <button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="{{ URL::to('/account/delete-'. $cashbook_info->entry_type ."/". $cashbook_info->cashbook_id) }}" data-title="{{ $cashbook_info->account_head_name }} : {{ $cashbook_info->party_name }}" id="{{ $cashbook_info->cashbook_id }}"><i class="far fa-trash-alt" aria-hidden="true"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="total_row">
                    <tr>
                        <th colspan="7">Total </th>
                        <?php $balance_total = DB::table('cashbook_entries')->whereDate('cashbook_entries.created_at', date('Y-m-d'))->select(DB::raw('SUM(credit) as credit, SUM(debit) as debit'))->first(); ?>
                        <th class="today_debit"><?php echo taka_format('', $balance_total->debit ); ?></th>
                        <th class="today_credit"><?php echo taka_format('', $balance_total->credit ); ?></th>
                        <th class="total_balance"><?php echo taka_format('', $balance_bf ); ?></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div><!-- /.box-body -->

        <div class="overlay" style="display: none;">
            <i class="fa fa-sync-alt fa-spin"></i>
        </div>
    </div><!-- /.box -->
</section>

@include('pages.accounts.accounts-head-modal')
@include('pages.accounts.cashbook-edit-modal')
{{--include('includes.temp-loan-modal')--}}

@endsection



@section('custom_js')
<script type="text/javascript">
function pushstate( id ) {
    var url = id.replace('#', '#tab=');
    //var currentState = history.state;

    return window.history.pushState(null, null, url);
};

$(window).on('hashchange', function () {
    var tab = window.location.hash != "" ? window.location.hash.split("#tab=")[1] : ""
    $("ul.nav").find("a[href='#" +tab + "']").trigger('click');
});


$(document).ready(function(){
    $("form#daily_expense_form").submit(function (event) {
        event.preventDefault();
        var row_count = $("table.cashbook_table").find('tbody').find('tr').length;
        //var rowCount = $('table.cashbook_table').find('tbody tr:last').index()+2;

        var form = $(this);
        var data = form.serialize();
        var url = form.attr("action");

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            url: url,
            method: "post",
            data: data,
            dataType: "json",
            success: function( response ) {
                $("table.cashbook_table").find('tbody').append(
                    '<tr id="'+ response.insert_id +'">'
                    + '<td>'+ (row_count+1) +'</td>'
                    + '<td>'+ response[0].entry_date +'</td>'
                    + '<td>'+ response[0].voucher_number +'</td>'
                    + '<td>'+ response.account_head_name +'</td>'
                    + '<td>'+ ( response[0].party_type ? response[0].party_type : '-') +'</td>'
                    + '<td>'+ response[0].party_name +'</td>'
                    + '<td>'+ (response[0].description ? response[0].description : '-') +'</td>'
                    + '<td>'+ (response[0].debit > 0 ? response[0].debit : '0.00') +'</td>'
                    + '<td>'+ (response[0].credit > 0 ? response[0].credit : '0.00') +'</td>'
                    + '<td data-balance="'+ response.total_balance +'">'+ response.total_balance +'</td>'
                    + '<td>'
                    + '<button type="button" class="btn btn-warning btn-sm edit-'+response[0].entry_type+'" id="'+ response.insert_id +'"><i class="fa fa-edit" aria-hidden="true"></i></button>'
                    + '<button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="<?php echo URL::to('/account'); ?>/delete-'+ response[0].entry_type +'/'+ response.insert_id +'" data-title="'+ response.account_head_name +': '+ response[0].party_name +'" id="'+ response.insert_id +'"><i class="far fa-trash-alt" aria-hidden="true"></i></button>'
                    + '</td>'
                    + '</tr>'
                );
                $(".dataTables_scrollFoot .today_debit").text(response.today_debit);
                $(".dataTables_scrollFoot .today_credit").text(response.today_credit);
                $(".dataTables_scrollFoot .total_balance").attr('data-balance', response.total_balance).text(response.total_balance);

                toastr.success( response.success );
                form.trigger('reset');
            },
            statusCode:{ 404: function(){ alert( "page not found" ); } },
            beforeSend: function( xhr ) { $(".ajax-loader").show(); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
        });
        return false;
    });


    $(document).on('click', 'button.edit-daily-expense', function (event) {
        event.preventDefault();

        var modal = $("#editCashbookModal");
        var id = $(this).attr('id');
        var row_index = $(this).closest('tr').index()+1;

        $.ajax({
            url: "{{ url('/account/edit-daily-expense') }}/"+id,
            method: "get",
            data: { row_index: row_index, cashbook_id:id },
            dataType: "json",
            success: function( response ) {
                modal.find('form').css('display', 'none')
                modal.find('form#update_daily_expense_form').show();
                modal.find('.modal-title').text( "Update Daily Expense" );

                modal.find('input[name="cashbook_id"]').val( response[0].cashbook_id );
                modal.find('input[name="row_index"]').val( response.row_index );
                modal.find('#entry_date').val( response[0].entry_date ).attr('disabled', 'disabled');
                modal.find('#voucher_number').val( response[0].voucher_number );
                modal.find("select#payment_method option[value=" + response[0].payment_method +"]").prop("selected", true);
                modal.find("select#account_head_id option[value=" + response[0].account_head_id +"]").prop("selected", true);
                modal.find('#party_name').val( response[0].party_name );
                modal.find('#paid_amount').val( response[0].debit );
                modal.find('#description').val( response[0].description );

                modal.modal({ backdrop: "static", keyboard: true });
                modal.on('shown.bs.modal', function(){ $(":input[type='text']:enabled:visible:first").focus(); });
            },
            statusCode:{ 404: function(){ alert( "page not found" ); } },
            beforeSend: function( xhr ) { $(".ajax-loader").show(); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
            error: function (xhr, textStatus, errorThrown) { alert(errorThrown); }
        });
    });


    $("form#update_daily_expense_form").submit(function (event) {
        event.preventDefault();

        var form = $(this);
        var data = form.serialize();
        var url = form.attr("action");

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            url: url,
            method: "post",
            data: data,
            dataType: "json",
            success: function( response ) {
                $("table.cashbook_table").find('tbody').find("tr#"+ response.cashbook_id).html(
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
                    + '<button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="<?php echo URL::to('/account/delete-daily-expense/'); ?>'+ response.cashbook_id +'" data-title="'+ response.account_head_name +'" id="'+ response.cashbook_id +'"><i class="far fa-trash-alt" aria-hidden="true"></i></button>'
                    + '</td>'
                );
                form.parents('.modal').modal("hide");
                form.trigger('reset');
                //form.css('display', 'none');
            },
            statusCode:{ 404: function(){ alert( "page not found" ); } },
            beforeSend: function( xhr ) { $(".ajax-loader").show(); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
        });
        return false;
    });
}); //End of Document ready


$(document).ready(function(){
    $("form#cash_receive_form").submit(function (event) {
        event.preventDefault();
        var row_count = $("table.cashbook_table").find('tbody').find('tr').length;
        //var rowCount = $('table.cashbook_table').find('tbody tr:last').index()+2;

        var form = $(this);
        var data = form.serialize();
        var url = form.attr("action");

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            url: url,
            method: "post",
            data: data,
            dataType: "json",
            success: function( response ) {
                $("table.cashbook_table").find('tbody').append(
                    '<tr id="'+ response.insert_id +'">'
                    + '<td>'+ (row_count+1) +'</td>'
                    + '<td>'+ response[0].entry_date +'</td>'
                    + '<td>'+ ( response[0].voucher_number ? response[0].voucher_number : '-') +'</td>'
                    + '<td>'+ ( response.account_head_name ? response.account_head_name : '-') +'</td>'
                    + '<td>'+ ( response[0].party_type ? response[0].party_type : '-') +'</td>'
                    + '<td>'+ ( response[0].party_name ? response[0].party_name : '-') +'</td>'
                    + '<td>'+ (response[0].description ? response[0].description : '-') +'</td>'
                    + '<td>'+ '0.00' +'</td>'
                    + '<td>'+ (response[0].credit > 0 ? response[0].credit : '0.00') +'</td>'
                    + '<td data-balance="'+ response.total_balance +'">'+ response.total_balance +'</td>'
                    + '<td>'
                    + '<button type="button" class="btn btn-warning btn-sm edit-'+response[0].entry_type+'" id="'+ response.insert_id +'"><i class="fa fa-edit" aria-hidden="true"></i></button>'
                    + '<button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="<?php echo URL::to('/account'); ?>/delete-'+ response[0].entry_type +'/'+ response.insert_id +'" data-title="'+ response.account_head_name +': '+ response[0].party_name +'" id="'+ response.insert_id +'"><i class="far fa-trash-alt" aria-hidden="true"></i></button>'
                    + '</td>'
                    + '</tr>'
                );
                $(".dataTables_scrollFoot .today_debit").text(response.today_debit);
                $(".dataTables_scrollFoot .today_credit").text(response.today_credit);
                $(".dataTables_scrollFoot .total_balance").text(response.total_balance);

                toastr.success( response.success );
                form.trigger('reset');
            },
            statusCode:{ 404: function(){ alert( "page not found" ); } },
            beforeSend: function( xhr ) { $(".ajax-loader").show(); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
        });
        return false;
    });


    $(document).on('click', 'button.edit-cash-receive', function (event) {
        event.preventDefault();

        var modal = $("#editCashbookModal");
        var id = $(this).attr('id');
        var row_index = $(this).closest('tr').index()+1;
        var form = modal.find('form#update_cash_receive_form');

        $.ajax({
            url: "{{ url('/account/edit-cash-receive') }}/"+id,
            method: "get",
            data: { row_index: row_index, cashbook_id:id },
            dataType: "json",
            success: function( response ) {
                modal.find('.modal-title').text( "Update Cash Received" );
                modal.find('form').css('display', 'none')
                form.show();
                form.find('input[name="cashbook_id"]').val( response[0].cashbook_id );
                form.find('input[name="row_index"]').val( response.row_index );

                form.find('#cash_receive_date').val( response[0].entry_date ).attr('disabled', 'disabled');
                //form.find('#voucher_number').val( response[0].voucher_number );
                //form.find("select#payment_method option[value=" + response[0].payment_method +"]").prop("selected", true);
                form.find("select#account_head_id option[value=" + response[0].account_head_id +"]").prop("selected", true);
                form.find('#cash_receive_amount').val( response[0].credit );
                form.find('#description').val( response[0].description );
                if(response[0].entry_type){ form.find(".party_name").show(); form.find('#party_name').val( response[0].party_name ); }

                modal.modal({ backdrop: "static", keyboard: true });
                modal.on('shown.bs.modal', function(){ $(":input[type='text']:enabled:visible:first").focus(); });
            },
            statusCode:{ 404: function(){ alert( "page not found" ); } },
            beforeSend: function( xhr ) { $(".ajax-loader").show(); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
            error: function (xhr, textStatus, errorThrown) { alert(errorThrown); }
        });
    });

    $("form#update_cash_receive_form").submit(function (event) {
        event.preventDefault();

        var form = $(this);
        var data = form.serialize();
        var url = form.attr("action");

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            url: url,
            method: "post",
            data: data,
            dataType: "json",
            success: function( response ) {
                $("table.cashbook_table").find('tbody').find("tr#"+ response.cashbook_id).html(
                    '<td>'+ response.row_index +'</td>'
                    + '<td>'+ response[0].entry_date +'</td>'
                    + '<td>'+ ( response[0].voucher_number ? response[0].voucher_number : '-') +'</td>'
                    + '<td>'+ ( response.account_head_name ? response.account_head_name : '-') +'</td>'
                    + '<td>'+ ( response[0].party_type ? response[0].party_type : '-') +'</td>'
                    + '<td>'+ ( response[0].party_name ? response[0].party_name : '-') +'</td>'
                    + '<td>'+ (response[0].description ? response[0].description : '-') +'</td>'
                    + '<td>'+ (response[0].debit > 0 ? response[0].debit : '0.00') +'</td>'
                    + '<td>'+ (response[0].credit > 0 ? response[0].credit : '0.00') +'</td>'
                    + '<td data-balance="'+ response.total_balance +'">'+ response.total_balance +'</td>'
                    + '<td>'
                    + '<button type="button" class="btn btn-warning btn-sm edit-'+response[0].entry_type+'" id="'+ response.cashbook_id +'"><i class="fa fa-edit" aria-hidden="true"></i></button>'
                    + '<button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="<?php echo URL::to('/account'); ?>/delete-'+ response[0].entry_type +'/'+ response.cashbook_id +'" data-title="'+ response.account_head_name +': '+ response[0].party_name +'" id="'+ response.cashbook_id +'"><i class="far fa-trash-alt" aria-hidden="true"></i></button>'
                    + '</td>'
                );
                form.parents('.modal').modal("hide");
                form.trigger('reset');
                //form.css('display', 'none');
            },
            statusCode:{ 404: function(){ alert( "page not found" ); } },
            beforeSend: function( xhr ) { $(".ajax-loader").show(); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
        });
        return false;
    });



    $(document).on('change', 'select#bank_account_id', function () {
        var bank_account_id = $(this).find('option:selected').val();
        if(!bank_account_id) return;

        $.ajax({
            url : "{{ url('account/cash-withdraw/get-cheque-book-data') }}",
            type : "GET",
            dataType : "json",
            data: {bank_account_id: bank_account_id },
            success:function( data ){
                $("#account_number").val( data[0].account_number );
                $("#bank_name").val( data[0].bank_name );
                $("#branch").val( data[0].branch );

                $('select[name="cheque_book_id"]').empty();
                var book = '<option value="" selected="selected">--Select Book--</option>';

                $.each(data.cheque_book, function(key, value){
                    book += '<option value="'+ key +'">'+ value +'</option>';
                });
                $('select[name="cheque_book_id"]').append( book );
            },
            beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
        });
    });

    $(document).on('change', 'select#cheque_book_id', function () {
        var cheque_book_id = $(this).find('option:selected').val();
        if(!cheque_book_id) return;

        $.ajax({
            url : "{{ url('account/cash-withdraw/get-cheque-leaf') }}",
            type : "GET",
            dataType : "json",
            data: {id: cheque_book_id },
            success:function( data ){
                $('select[name="cheque_number"]').empty();
                $.each(data, function(key, value){
                    $('select[name="cheque_number"]').append('<option value="'+ value +'">'+ value +'</option>');
                });
            },
            beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
        });
    });
}); //End of Document ready




$(document).ready(function(){
    $("form#employee_payment_form").submit(function (event) {
        event.preventDefault();

        var row_count = $("table.cashbook_table").find('tbody').find('tr').length;
        var form = $(this);
        var data = form.serialize();
        var url = form.attr("action");

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            url: url,
            method: "post",
            data: data,
            dataType: "json",
            success: function( response ) {
                $("table.cashbook_table").find('tbody').append(
                    '<tr id="'+ response.insert_id +'">'
                    + '<td>'+ (row_count+1) +'</td>'
                    + '<td>'+ response[0].entry_date +'</td>'
                    + '<td>'+ ( response[0].voucher_number ? response[0].voucher_number : '-') +'</td>'
                    + '<td>'+ ( response.account_head_name ? response.account_head_name : '-') +'</td>'
                    + '<td>'+ ( response[0].party_type ? response[0].party_type : '-') +'</td>'
                    + '<td>'+ ( response[0].party_name ? response[0].party_name : '-') +'</td>'
                    + '<td>'+ (response[0].description ? response[0].description : '-') +'</td>'
                    + '<td>'+ (response[0].debit > 0 ? response[0].debit : '0.00') +'</td>'
                    + '<td>'+ (response[0].credit > 0 ? response[0].credit : '0.00') +'</td>'
                    + '<td data-balance="'+ response.total_balance +'">'+ response.total_balance +'</td>'
                    + '<td>'
                    + '<button type="button" class="btn btn-warning btn-sm edit-'+response[0].entry_type+'" id="'+ response.insert_id +'"><i class="fa fa-edit" aria-hidden="true"></i></button>'
                    + '<button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="<?php echo URL::to('/account'); ?>/delete-'+ response[0].entry_type +'/'+ response.insert_id +'" data-title="'+ response.account_head_name +': '+ response[0].party_name +'" id="'+ response.insert_id +'"><i class="far fa-trash-alt" aria-hidden="true"></i></button>'
                    + '</td>'
                    + '</tr>'
                );
                $(".dataTables_scrollFoot .today_debit").text(response.today_debit);
                $(".dataTables_scrollFoot .today_credit").text(response.today_credit);
                $(".dataTables_scrollFoot .total_balance").text(response.total_balance);

                toastr.success( response.success );
                form.trigger('reset');
            },
            statusCode:{ 404: function(){ alert( "page not found" ); } },
            beforeSend: function( xhr ) { $(".ajax-loader").show(); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
        });
        return false;
    });


    $(document).on('click', 'button.edit-employee-payment', function (event) {
        event.preventDefault();

        var modal = $("#editCashbookModal");
        var id = $(this).attr('id');
        var row_index = $(this).closest('tr').index()+1;
        var form = modal.find('form#update_employee_payment_form');

        //var tab_id = $("#employee_payment");
        //$('a[href="#employee_payment"]').trigger('click');

        $.ajax({
            url: "{{ url('/account/edit-employee-payment') }}/"+id,
            method: "get",
            data: { row_index: row_index, cashbook_id:id },
            dataType: "json",
            success: function( response ) {
                modal.find('.modal-title').text( "Update Employee Payment" );
                modal.find('form').css('display', 'none')
                form.show();
                form.find('input[name="cashbook_id"]').val( response[0].cashbook_id );
                form.find('input[name="row_index"]').val( response.row_index );

                form.find('#entry_date').val( response[0].entry_date );
                form.find('#voucher_number').val( response[0].voucher_number );
                form.find("select#payment_method option[value=" + response[0].payment_method +"]").prop("selected", true);
                form.find("select#account_head_id option[value=" + response[0].account_head_id +"]").prop("selected", true);
                form.find("select#employee_id option[value=" + response[0].party_id +"]").prop("selected", true);
                form.find("select#month_name option[value=" + parseInt(response.month_name.split('-')[1]) +"]").prop("selected", true);
                form.find('#party_name').val( response[0].party_name );
                form.find('#description').val( response[0].description );
                form.find('#paid_amount').val( response[0].debit );

                modal.modal({ backdrop: "static", keyboard: true });
                modal.on('shown.bs.modal', function(){ $(":input[type='text']:enabled:visible:first").focus(); });
            },
            statusCode:{ 404: function(){ alert( "page not found" ); } },
            beforeSend: function( xhr ) { $(".ajax-loader").show(); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
            error: function (xhr, textStatus, errorThrown) { alert(errorThrown); }
        });
    });

    $("form#update_employee_payment_form").submit(function (event) {
        event.preventDefault();

        var form = $(this);
        var data = form.serialize();
        var url = form.attr("action");

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            url: url,
            method: "post",
            data: data,
            dataType: "json",
            success: function( response ) {
                $("table.cashbook_table").find('tbody').find("tr#"+ response.cashbook_id).html(
                    '<td>'+ response.row_index +'</td>'
                    + '<td>'+ response[0].entry_date +'</td>'
                    + '<td>'+ ( response[0].voucher_number ? response[0].voucher_number : '-') +'</td>'
                    + '<td>'+ ( response.account_head_name ? response.account_head_name : '-') +'</td>'
                    + '<td>'+ ( response[0].party_type ? response[0].party_type : '-') +'</td>'
                    + '<td>'+ ( response[0].party_name ? response[0].party_name : '-') +'</td>'
                    + '<td>'+ (response[0].description ? response[0].description : '-') +'</td>'
                    + '<td>'+ (response[0].debit > 0 ? response[0].debit : '0.00') +'</td>'
                    + '<td>'+ (response[0].credit > 0 ? response[0].credit : '0.00') +'</td>'
                    + '<td data-balance="'+ response.total_balance +'">'+ response.total_balance +'</td>'
                    + '<td>'
                    + '<button type="button" class="btn btn-warning btn-sm edit-'+response[0].entry_type+'" id="'+ response.cashbook_id +'"><i class="fa fa-edit" aria-hidden="true"></i></button>'
                    + '<button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="<?php echo URL::to('/account'); ?>/delete-'+ response[0].entry_type +'/'+ response.cashbook_id +'" data-title="'+ response.account_head_name +': '+ response[0].party_name +'" id="'+ response.cashbook_id +'"><i class="far fa-trash-alt" aria-hidden="true"></i></button>'
                    + '</td>'
                );
                form.parents('.modal').modal("hide");
                form.trigger('reset');
                //form.css('display', 'none');
            },
            statusCode:{ 404: function(){ alert( "page not found" ); } },
            beforeSend: function( xhr ) { $(".ajax-loader").show(); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
        });
        return false;
    });

    $('form').on('change', 'select#month_name', function(){
        var parent = $(this).parents('form');
        var acc_head = parent.find('select#account_head_id option:selected').text();
        var month_name = $(this).find('option:selected').text();

        parent.find("#description").val( acc_head + " for " + month_name);
    });
}); //End of Document ready


$(document).ready(function(){
    $("form#vendor_payment_form").submit(function (event) {
        event.preventDefault();

        var row_count = $("table.cashbook_table").find('tbody').find('tr').length;
        var form = $(this);
        var data = form.serialize();
        var url = form.attr("action");

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            url: url,
            method: "post",
            data: data,
            dataType: "json",
            success: function( response ) {
                $("table.cashbook_table").find('tbody').append(
                    '<tr id="'+ response.insert_id +'">'
                    + '<td>'+ (row_count+1) +'</td>'
                    + '<td>'+ response[0].entry_date +'</td>'
                    + '<td>'+ ( response[0].voucher_number ? response[0].voucher_number : '-') +'</td>'
                    + '<td>'+ ( response.account_head_name ? response.account_head_name : '-') +'</td>'
                    + '<td>'+ ( response[0].party_type ? response[0].party_type : '-') +'</td>'
                    + '<td>'+ ( response[0].party_name ? response[0].party_name : '-') +'</td>'
                    + '<td>'+ (response[0].description ? response[0].description : '-') +'</td>'
                    + '<td>'+ (response[0].debit > 0 ? response[0].debit : '0.00') +'</td>'
                    + '<td>'+ (response[0].credit > 0 ? response[0].credit : '0.00') +'</td>'
                    + '<td data-balance="'+ response.total_balance +'">'+ response.total_balance +'</td>'
                    + '<td>'
                    + '<button type="button" class="btn btn-warning btn-sm edit-'+response[0].entry_type+'" id="'+ response.insert_id +'"><i class="fa fa-edit" aria-hidden="true"></i></button>'
                    + '<button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="<?php echo URL::to('/account'); ?>/delete-'+ response[0].entry_type +'/'+ response.insert_id +'" data-title="'+ response.account_head_name +': '+ response[0].party_name +'" id="'+ response.insert_id +'"><i class="far fa-trash-alt" aria-hidden="true"></i></button>'
                    + '</td>'
                    + '</tr>'
                );
                $(".dataTables_scrollFoot .today_debit").text(response.today_debit);
                $(".dataTables_scrollFoot .today_credit").text(response.today_credit);
                $(".dataTables_scrollFoot .total_balance").text(response.total_balance);

                toastr.success( response.success );
                form.trigger('reset');
            },
            statusCode:{ 404: function(){ alert( "page not found" ); } },
            beforeSend: function( xhr ) { $(".ajax-loader").show(); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
        });
        return false;
    });

    $(document).on('click', 'button.edit-vendor-payment', function (event) {
        event.preventDefault();

        var modal = $("#editCashbookModal");
        var id = $(this).attr('id');
        var row_index = $(this).closest('tr').index()+1;
        var form = modal.find('form#update_vendor_payment_form');

        $.ajax({
            url: "{{ url('/account/edit-vendor-payment') }}/"+id,
            method: "get",
            data: { row_index: row_index, cashbook_id:id },
            dataType: "json",
            success: function( response ) {
                modal.find('.modal-title').text( "Update Vendor Payment" );
                modal.find('form').css('display', 'none')
                form.show();
                form.find('input[name="cashbook_id"]').val( response[0].cashbook_id );
                form.find('input[name="row_index"]').val( response.row_index );

                form.find('#entry_date').val( response[0].entry_date ).attr('disabled', 'disabled');
                form.find('#voucher_number').val( response[0].voucher_number );
                form.find("select#payment_method option[value=" + response[0].payment_method +"]").prop("selected", true);
                form.find("select#account_head_id option[value=" + response[0].account_head_id +"]").prop("selected", true);
                form.find("select#vendor_id option[value=" + response[0].vendor_id +"]").prop("selected", true);
                form.find("select#bill_no option[value=" + response[0].bill_no +"]").prop("selected", true);
                if(response[0].bill_date){ form.find('#bill_date').val( response[0].bill_date.split('-')[2]+"/"+response[0].bill_date.split('-')[1]+"/"+response[0].bill_date.split('-')[0] ); }
                form.find("select#po_id option[value=" + response[0].po_id +"]").prop("selected", true);
                form.find('#project_name').val( response.project_name );
                form.find('#client_id').val( response[0].client_id );
                form.find('#client_name').val( response.client_name );
                form.find('#paid_amount').val( response[0].received_amount );
                form.find('#description').val( response[0].description );

                modal.modal({ backdrop: "static", keyboard: true });
                modal.on('shown.bs.modal', function(){ $(":input[type='text']:enabled:visible:first").focus(); });
            },
            statusCode:{ 404: function(){ alert( "page not found" ); } },
            beforeSend: function( xhr ) { $(".ajax-loader").show(); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
            error: function (xhr, textStatus, errorThrown) { alert(errorThrown); }
        });
    });

    $("form#update_vendor_payment_form").submit(function (event) {
        event.preventDefault();

        var form = $(this);
        var data = form.serialize();
        var url = form.attr("action");

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            url: url,
            method: "post",
            data: data,
            dataType: "json",
            success: function( response ) {
                $("table.cashbook_table").find('tbody').find("tr#"+ response.cashbook_id).html(
                    '<td>'+ response.row_index +'</td>'

                    + '<td>'+ response[0].entry_date +'</td>'
                    + '<td>'+ ( response[0].voucher_number ? response[0].voucher_number : '-') +'</td>'
                    + '<td>'+ ( response.account_head_name ? response.account_head_name : '-') +'</td>'
                    + '<td>'+ ( response[0].party_type ? response[0].party_type : '-') +'</td>'
                    + '<td>'+ ( response[0].party_name ? response[0].party_name : '-') +'</td>'
                    + '<td>'+ (response[0].description ? response[0].description : '-') +'</td>'
                    + '<td>'+ (response[0].debit > 0 ? response[0].debit : '0.00') +'</td>'
                    + '<td>'+ (response[0].credit > 0 ? response[0].credit : '0.00') +'</td>'
                    + '<td data-balance="'+ response.total_balance +'">'+ response.total_balance +'</td>'
                    + '<td>'
                    + '<button type="button" class="btn btn-warning btn-sm edit-'+response[0].entry_type+'" id="'+ response.cashbook_id +'"><i class="fa fa-edit" aria-hidden="true"></i></button>'
                    + '<button type="button" class="ajaxDelete btn btn-danger btn-sm" data-href="<?php echo URL::to('/account'); ?>/delete-'+ response[0].entry_type +'/'+ response.cashbook_id +'" data-title="'+ response.account_head_name +': '+ response[0].party_name +'" id="'+ response.cashbook_id +'"><i class="far fa-trash-alt" aria-hidden="true"></i></button>'
                    + '</td>'
                );
                form.parents('.modal').modal("hide");
                form.trigger('reset');
            },
            statusCode:{ 404: function(){ alert( "page not found" ); } },
            beforeSend: function( xhr ) { $(".ajax-loader").show(); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
        });
        return false;
    });

    $('form#vendor_payment_form').on('change', 'select#vendor_id', function () {
        var vendor_id = $(this).find('option:selected').val();
        var tab = $('form#vendor_payment_form');
        if(!vendor_id) return;

        $.ajax({
            url : "{{ url('/account/get-vendor-data') }}",
            type : "GET",
            dataType : "json",
            data: { vendor_id: vendor_id },
            success:function( response ){
                $(".vendor-balance").html('Balance: <span data-balance="'+response.vendor_bill_balance+'">'+ takaFormat(response.vendor_bill_balance) + "</span>" );

                //For get vendor bill number to select box
                var bill_no = '<option value="" selected="selected">--Select Bill--</option>';
                $.each(response.vendor_bill_list, function(key, value){
                    bill_no += '<option value="'+ key +'">'+ value +'</option>';
                });
                $('select[name="bill_no"]').html( bill_no );


                var po_number = '<option value="" selected="selected">--Select Bill--</option>';
                $.each(response.po_data, function(key, value){
                    po_number += '<option value="'+ key +'">'+ value +'</option>';
                });
                $('select[name="po_id"]').html( po_number );
            },
        beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
        });
    });


    $('form#vendor_payment_form').on('change', 'select#bill_no', function () {
        var bill_no = $(this).find('option:selected').val();
        var tab = $('form#vendor_payment_form');
        if(!bill_no) return;

        $.ajax({
            url : "{{ url('/account/get-po-from-bill') }}",
            type : "GET",
            dataType : "json",
            data: { bill_no: bill_no },
            success:function( response ){
                tab.find('select#po_id').html( '<option value="'+response['po_data'].po_id+'">'+response['po_data'].po_number+" - "+response['po_data'].project_name +'</option>' );
                if(response.bill_date){ tab.find('#bill_date').val( response.bill_date.split('-')[2]+"/"+response.bill_date.split('-')[1]+"/"+response.bill_date.split('-')[0] ); }
                tab.find('#project_name').val( response['po_data'].project_name );
                tab.find("#client_id").val( response.client_id );
                tab.find('#client_name').val( response.client_name );
            },
            beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
        });
    });


    $('form#vendor_payment_form').on('change', 'select#po_id', function () {
        var po_id = $(this).find('option:selected').val();
        if(!po_id) return;

        $.ajax({
            url : "{{ url('/account/get-po-data') }}",
            type : "GET",
            dataType : "json",
            data: { po_id: po_id },
            success:function( data ){
                $("#project_name").val( data[0].project_name );
                $("#client_id").val( data[0].client_id );
                $("#client_name").val( data.client_name );
            },
            beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
        });
    });
}); //End of Document ready



$(document).ready(function(){
    $("body").on("click", "button#create_accounts_head", function(event){
        event.preventDefault();
        var account_head_type = $(this).parents('.modal-footer').find('#account_head_type').val();
        var account_head_name = $(this).parents('.modal-footer').find('#account_head_name').val();
        var token = $('meta[name="csrf-token"]').attr('content');

        if(!account_head_name) return;

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            type: "POST",
            url: "{{ url('/account/new-account-head-save') }}",
            data: {account_head_name: account_head_name, account_head_type:account_head_type, _token: token} ,
            dataType: 'json',
            success: function (data) {
                $("#account_head_table").find('tbody').prepend(
                    '<tr id="cat-'+ data[0].account_head_id +'">'
                    + '<td>'+ data[0].account_head_id +'</td>'
                    + '<td class="text-capitalize">'+ data[0].account_head_type.replace('_', ' ').replace('_', ' ') +'</td>'
                    + '<td style="text-align: left; padding-left: 10px;">'+ data[0].account_head_name +'</td>'
                    + '<td>'
                    + '<button type="button" class="btn btn-warning btn-sm btn-flat editAccountHead" id="'+ data[0].account_head_id +'" style="margin: 5px 0;"><i class="fa fa-edit" aria-hidden="true"> Edit</i></button>'
                    + '<button type="button" class="btn btn-danger btn-sm btn-flat ajaxDelete" data-href="<?php echo URL::to('/account/delete-account-head'); ?>/'+ data[0].account_head_id +'" data-title="'+ data[0].account_head_name +'" id="'+ data[0].account_head_id +'" style="margin: 5px 0;"><i class="far fa-trash-alt" aria-hidden="true"> Delete</i></button>'
                    + '</td>'
                    + '</tr>'
                );

                $("#account_head_name").val('');
                $(":input[type='text']:enabled:visible:first").focus();
            },
            error: function (xhr, textStatus, errorThrown) { alert(errorThrown); }
        });
    });


    $(document).on('click', 'button.editAccountHead', function () {
        var id = $(this).attr('id');

        $.ajax({
            url: "{{ url('account/edit-account-head') }}/" + id,
            method: "get",
            //data: { id: id },
            dataType: "json",
            success: function( response ) {
                $("#account_head_table tr#cat-" + response.account_head_id).html(
                    '<td colspan="2">'
                    + '<select id="account_head_type" name="account_head_type" class="custom-select" style="border: 1px solid lightcoral;">'
                    + '<option value="daily_expense_tab" '+ (response.account_head_type == "daily_expense_tab" ? 'selected="selected"' : "") +'>Daily Expense Tab</option>'
                    + '<option value="employee_expense_tab" '+ (response.account_head_type == "employee_expense_tab" ? 'selected="selected"' : "") +'>Employee Expense Tab</option>'
                    + '<option value="vendor_expense_tab" '+ (response.account_head_type == "vendor_expense_tab" ? 'selected="selected"' : "") +'>Vendor Expense Tab</option>'
                    + '<option value="cash_receive_tab" '+ (response.account_head_type == "cash_receive_tab" ? 'selected="selected"' : "") +'>Cash Receive Tab</option>'
                    + '</select>'
                    + '</td>'
                    + '<td><input type="text" name="account_head_name" id="account_head_name" value="'+ response.account_head_name +'" class="form-control" style="border: 1px solid lightcoral;" /></td>'
                    + '<td>'
                    + '<button type="button" class="btn btn-purple btn-sm btn-flat updateAccountHead" id="'+ response.account_head_id +'" style="margin: 5px 0;"><i class="fa fa-edit" aria-hidden="true"> Save</i></button>'
                    + '<button type="button" class="btn btn-tomato btn-sm btn-flat cancelUpdateAccountHead" id="'+ response.account_head_id +'" style="margin: 5px 0;"><i class="fa fa-times" aria-hidden="true"> Cancel</i></button>'
                    + '</td>'
                );
            },
            statusCode:{ 404: function(){ alert( "page not found" ); } },
            beforeSend: function( xhr ) { $(".ajax-loader").show(); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
        });
    });


    $("body").on("click", "button.updateAccountHead", function(){
        var id = $(this).attr('id');
        var account_head_type = $(this).closest('tr').find('#account_head_type').val();
        var account_head_name = $(this).closest('tr').find('#account_head_name').val();
        var token = $('meta[name="csrf-token"]').attr('content');

        if (!confirm("Are you sure want to update this record?")) return;

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            type: "POST",
            url: "{{ url('account/update-account-head') }}",
            data: { id: id, account_head_name: account_head_name, account_head_type:account_head_type, _token: token },
            success: function (data) {
                $("#account_head_table tr#cat-" + data[0].account_head_id).html(
                    '<td>'+ data[0].account_head_id +'</td>'
                    + '<td class="text-capitalize">'+ data[0].account_head_type.replace('_', ' ').replace('_', ' ') +'</td>'
                    + '<td style="text-align: left; padding-left: 10px;">'+ data[0].account_head_name +'</td>'
                    + '<td>'
                    + '<button type="button" class="btn btn-warning btn-sm btn-flat editAccountHead" id="'+ data[0].account_head_id +'" data-url="{{ url('employee/edit-department') }}/'+ data[0].account_head_id +'" style="margin: 5px 0;"><i class="fa fa-edit" aria-hidden="true"> Edit</i></button>'
                    + '<button type="button" class="btn btn-danger btn-sm btn-flat ajaxDelete" data-href="<?php echo URL::to('/account/delete-account-head'); ?>/'+ data[0].account_head_id +'" data-title="'+ data[0].account_head_name +'" id="'+ data[0].account_head_id +'" style="margin: 5px 0;"><i class="far fa-trash-alt" aria-hidden="true"> Delete</i></button>'
                    + '</td>'
                );
            },
            error: function (xhr, textStatus, errorThrown) { alert(errorThrown); }
        });
    });


    $("body").on("click", "button.cancelUpdateAccountHead", function(){
        var id = $(this).attr('id');

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            type: "get",
            url: "{{ url('account/cancel-update-account-head') }}",
            data: { id: id },
            success: function (data) {
                $("#account_head_table tr#cat-" + data.account_head_id).html(
                    '<td>'+ data.account_head_id +'</td>'
                    + '<td class="text-capitalize">'+ data.account_head_type.replace('_', ' ').replace('_', ' ') +'</td>'
                    + '<td style="text-align: left; padding-left: 10px;">'+ data.account_head_name +'</td>'
                    + '<td>'
                    + '<button type="button" class="btn btn-warning btn-sm btn-flat editAccountHead" id="'+ data.account_head_id +'" data-url="{{ url('account/edit-department') }}/'+ data.account_head_id +'" style="margin: 5px 0;"><i class="fa fa-edit" aria-hidden="true"> Edit</i></button>'
                    + '<button type="button" class="btn btn-danger btn-sm btn-flat ajaxDelete" data-href="<?php echo URL::to('/account/delete-account-head'); ?>/'+ data.account_head_id +'" data-title="'+ data.account_head_name +'" id="'+ data.account_head_id +'" style="margin: 5px 0;"><i class="far fa-trash-alt" aria-hidden="true"> Delete</i></button>'
                    + '</td>'
                );
            },
            error: function (xhr, textStatus, errorThrown) { alert(errorThrown); }
        });
    });


    $("form#cash_receive_form").on('change', 'select#account_head_id', function () {
        var account_head_id = $(this).find('option:selected').val();
        var account_head = $(this).find('option:selected').text();
        if(!account_head_id) return;
        var form = $("form#cash_receive_form");

        //For bank: Cash Withdraw/ otherwise: client Name

        $.ajax({
            url : "{{ url('/account/get-party-list') }}",
            type : "GET",
            dataType : "json",
            data: { account_head:account_head },
            success:function( data ){
                if(data.account_head == "Cash Bill") {
                    $("input#party_name").val();
                    $('datalist#client_list').html(data.client_list);
                    form.find(".party_name").show();
                    form.find("#description_cash_receive_wrap").removeClass('col-4').addClass('col-3');
                    form.find("#save_cash_receive_wrap").removeClass('col-2').addClass('col-1');
                }else{
                    form.find(".party_name").hide();
                    form.find("#description_cash_receive_wrap").removeClass('col-3').addClass('col-4');
                    form.find("#save_cash_receive_wrap").removeClass('col-1').addClass('col-2');
                }

                if(data.account_head == "Cash Withdraw"){
                    form.find(".account-info").show();
                    form.find("#bank_account_id").attr('required', 'required');
                    form.find("#cheque_book_id").attr('required', 'required');
                    form.find("#cheque_number").attr('required', 'required');
                }else{
                    form.find(".account-info").hide();
                    form.find("#bank_account_id").removeAttr('required');
                    form.find("#cheque_book_id").removeAttr('required');
                    form.find("#cheque_number").removeAttr('required');
                }
            },
            beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
        });
    });
}); //End of Document ready
</script>
@endsection

