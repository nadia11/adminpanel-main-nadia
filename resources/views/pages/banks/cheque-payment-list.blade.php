@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInRight">
        <div class="box-header with-border">
            <h2 class="box-title">Cheque Payment List</h2>
            <div class="filter-button float-right box-tools" style="width: 100%;">
                <div class="float-right" style="margin-right: .5%;">
                    <button type="button" class="btn btn-info showNewChequePaymentModal btn-sm" data-toggle="tooltip" data-placement="top" title="New Cheque Payment"><i class="fa fa-plus"></i> New Cheque Payment</button>
                </div>
                <div class="float-right" style="margin-right: .5%;">
                    <button type="button" class="btn btn-warning btn-sm" id="daterange-btn">
                       <span>Date range picker </span><i class="fa fa-caret-down"></i>
                    </button>
                </div>
                <div class="float-right" style="margin-right: .5%; width: 150px;">
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text" style="padding: 2px;">To</span></div>
                        <input type="datetime-locale" name="custom_date_end" id="custom_date_end" class="form-control form-control-sm" value="<?php echo date('Y-m-d'); ?>" />
                    </div>
                </div>
                <div class="float-right" style="margin-right: .5%; width: 150px;">
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text" style="padding: 2px;">From</span></div>
                        <input type="datetime-locale" name="custom_date_begin" id="custom_date_begin" class="form-control form-control-sm" value="<?php echo date('Y-m-d'); ?>" />
                    </div>
                </div>
                <div class="float-right" style="margin-right: .5%">
                    <select id="cheque_payment_status" name="cheque_payment_status" class="custom-select custom-select-sm">
                        <option value="">Cheque Status</option>
                        <option value="Pending">Pending</option>
                        <option value="Complete">Complete</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                </div>
                <div class="float-right" style="margin-right: .5%; width: 100px;">
                    <input type="text" name="cheque_number" id="cheque_number" class="form-control form-control-sm" placeholder="Cheque No" />
                </div>
            </div>
        </div><!-- /.box-header -->

        <div class="box-body">
            <table id="general_datatable" class="table table-custom">
                <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        <th>Payment Date</th>
                        <th>Party Type</th>
                        <th>Party Name</th>
                        <th>Debit Account</th>
                        <th>Bank Name</th>
                        <th>Cheque No</th>
                        <th>Cheque Date</th>
                        <th>Cheque Amount</th>
                        <th>Cheque Status</th>
                        <th>Voucher No</th>
                        <th data-orderable="false" class="no-print">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($cheque_payment_info as $cheque_payment)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $cheque_payment->payment_date }}</td>
                        <td>{{ $cheque_payment->party_type }}</td>
                        <td><a href="{{ URL::to('/'. $cheque_payment->party_type .'/view/'.$cheque_payment->party_id ) }}" target="_blank">{{ $cheque_payment->party_name }}</a></td>
                        <td>{{ $cheque_payment->account_name }}</td>
                        <td>{{ $cheque_payment->bank_name }}</td>
                        <td><a href="#" class="cheque-view" id="{{ $cheque_payment->cheque_payment_id }}" data-cheque_number="{{ $cheque_payment->cheque_number }}">{{ $cheque_payment->cheque_number }}</a></td>
                        <td>{{ $cheque_payment->cheque_date }}</td>
                        <td>{{ taka_format('', $cheque_payment->cheque_amount ) }}</td>
                        <td><button type="button" class="btn <?php if($cheque_payment->cheque_payment_status == 'Pending'){ echo 'btn-warning'; }else if($cheque_payment->cheque_payment_status == 'Rejected'){ echo 'badge-danger'; }else{ echo 'badge-success'; } ?> btn-sm cheque-payment-status" id="{{ $cheque_payment->cheque_payment_id }}" data-href="{{ URL::to( 'cheque-payment-status/' . $cheque_payment->cheque_payment_id) }}"><?php if($cheque_payment->cheque_payment_status == 'Pending'){ echo 'Pending'; }else if($cheque_payment->cheque_payment_status == 'Reject'){ echo 'Reject'; }else{ echo 'Complete'; } ?></button></td>
                        <td><a href="{{ URL::to('/voucher/' . $cheque_payment->bank_account_id) }}">{{ $cheque_payment->bank_account_id }}</a></td>
                        <td style="width:70px;">
                            <button type="button" class="btn btn-warning btn-sm edit-cheque-payment" id="{{ $cheque_payment->cheque_payment_id }}" data-url="{{ url('/bank/edit-cheque-payment/' .  $cheque_payment->cheque_payment_id) }}">PO</button>
                            <button type="button" class="btn btn-info btn-sm view-cheque-payment" id="{{ $cheque_payment->cheque_payment_id }}" data-url="{{ url('/bank/view-cheque-payment/' . $cheque_payment->cheque_payment_id) }}"><i class="fa fa-eye" aria-hidden="true"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="total_row">
                    <tr>
                        <th colspan="8">Total </th>
                        <th><?php echo taka_format('', DB::table('bank_cheque_payments')->sum('cheque_amount') ); ?></th>
                        <th></th>
                        <th></th>
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

@include('pages.banks.cheque-payment-new-modal')
@include('pages.banks.cheque-payment-status-modal')
@include('pages.banks.cheque-payment-view-modal')
@include('pages.banks.view-cheque-leaf-modal')

@endsection


@section('custom_js')
<script type="text/javascript">
$(document).ready(function(){
    $('button.showNewChequePaymentModal').on('click', function () {
        var modal = $("#NewChequePaymentModal");
        modal.modal({ backdrop: "static", keyboard: true });
        modal.on('shown.bs.modal', function(){ $(":input[type='text']:enabled:visible:first").focus(); });
    });

    $(document).on('change', 'select#bank_account_id', function () {
        var bank_account_id = $(this).find('option:selected').val();
        if(!bank_account_id) return;

        $.ajax({
            url : "{{ url('/bank/get-cheque-book-data') }}",
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
            url : "{{ url('/bank/get-cheque-leaf') }}",
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


    $(document).on('click', 'button.cheque-payment-status', function (e) {
        e.preventDefault();

        var modal = $("#cheque_payment_status_modal");
        if( $(this).text() == "Complete" ) return;

        modal.find('input[name=cheque_payment_id]').val( $(this).attr('id') );
        modal.modal('show');
    });


    $("form#cheque-payment-status").submit(function (event) {
        event.preventDefault();
        $("button[type=submit]").attr('disabled', 'disabled').html("<i class='fa fa-floppy-disk'></i> Saving...");

        var form = $(this);
        var cheque_payment_status = form.find('#cheque_payment_status').val();
        var id = form.find('input[name=cheque_payment_id]').val();
        var url = form.attr("action");

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $.ajax({
            type: "POST",
            url: url,
            data: {id: id, data: cheque_payment_status},
            dataType: 'json',
            success: function (data) {

                $("button#"+id+".cheque-payment-status").text( data.status );
                var status_class = data.status == 'Pending' ? "btn-warning" : (data.status == 'Reject' ? "btn-danger" : "btn-success" );
                $("button#"+id+".cheque-payment-status").removeAttr('class').attr('class', 'btn btn-sm cheque-payment-status '+ status_class);
                toastr.success( data.success );
                $('#cheque_payment_status_modal').modal('hide');
                $("button[type=submit]").removeAttr('disabled').html("<i class='fa fa-save'></i> Change Status");
            },
            statusCode:{ 404: function(){ alert( "page not found" ); } },
            error: function (xhr, textStatus, errorThrown) { alert(errorThrown); },
            beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
        });
        return false;
    });


    $(document).on('click', 'button.view-cheque-payment', function () {

        var url = $(this).data('url');
        var id = $(this).attr('id');
        var modal = $("#view_cheque_payment_modal");

        $.ajax({
            url: url,
            method: "get",
            //data: { id: id },
            dataType: "json",
            cache:false,
            async: false,
            success: function( data ) {
                modal.find('.modal-title').text( "View Cheque payment to ("+ data[0].party_type + ": " + data[0].party_name +")" );
                modal.find('.payment_date').text( data[0].payment_date.split('-')[2]+"/"+data[0].payment_date.split('-')[1]+"/"+data[0].payment_date.split('-')[0] );
                modal.find('.party_type').text( data[0].party_type );
                modal.find('.party_name').text( data[0].party_name );
                modal.find('.account_name').text( data.account_name );
                modal.find('.account_number').text( data[0].account_number );
                modal.find('.bank_name_id').text( data[0].bank_name );
                modal.find('.branch').text( data[0].branch );
                modal.find('.cheque_number').text( data[0].cheque_number );
                modal.find('.cheque_type').text( data[0].cheque_type );
                modal.find('.cheque_amount').text( data[0].cheque_amount.toFixed(2) );
                modal.find('.cheque_date').text( data[0].cheque_date.split('-')[2]+"/"+data[0].cheque_date.split('-')[1]+"/"+data[0].cheque_date.split('-')[0] );
                modal.find('.cheque_payment_status').text( data[0].cheque_payment_status );
                modal.find('.voucher_status').text( data[0].voucher_status );
                modal.find('.description').text( data[0].description );
                modal.find('.voucher_no').text( data[0].voucher_no );
                modal.find('.tag_PO').text( data[0].tag_PO );

                modal.modal("show");
            },
            beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
        });
    });


    $('select[name="party_type"]').on('change', function(){
       var type = $(this).val();

        $.ajax({
            url : "{{ url('/bank/get-party-name') }}",
            type : "GET",
            dataType : "json",
            data: { type: type },
            success:function( data ){

                $(".party-name").find('label').text((data.type == null ? "Party " : data.type) + " Name");
                $('select[name="party_id"]').empty();
                $('select[name="party_id"]').append('<option value="">-- Select --</option>');

                $.each(data[0], function(key, value){
                    $('select[name="party_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                    $('select[name="party_id"]').after('<input type="hidden" name="party_name" disabled id="party_name-'+ key +'" value="'+ value +'">');
                });
            },
            beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
        });
    });

    $(document).on('change', 'select#party_id', function () {
        var party_id = $(this).find('option:selected').val();
        if(!party_id) return;

        $('input[type=party_name]').attr('disabled', 'disabled').removeAttr('checked');
        $('input[type=hidden]#party_name-'+ party_id).removeAttr('disabled').attr('checked', 'checked');
    });


    $(document).on('keyup', 'input.get_balance', function () {
        var bank_account_id = $(this).parents('.modal').find('select#bank_account_id').val();

        var value = $(this).val();
        var $this = $(this);

        if(!bank_account_id){ alert('Select Account First'); }

        $.ajax({
            url: $(this).data('url'),
            type: "GET",
            data: {value: value, bank_account_id: bank_account_id},
            dataType: "json",
            async: true,
            cache: false,
            success:function( data ){
                if(value > parseInt( data ) ){
                    $this.css({border: '1px solid red', boxShadow: '0px 0px 3px 1px red'});
                    $('.get_balanceMsg').html( "Current Balance: <strong>"+ data + "</strong>, you have over entered: <strong>" + (parseInt( data ) - parseInt( value )) + "</strong>" );
                }
            },
            beforeSend: function( xhr ) {
                $('.get_balanceMsg').remove();
                    $this.css({border: '1px solid #ccc', boxShadow: 'inset 0 1px 1px rgba(0, 0, 0, .075)'});
                $('.get_balance').parents('.input-group').append('<span class="text-danger w-100 get_balanceMsg"></span>');
                //$('.get_balanceMsg').delay(1000).slideUp('slow');
            },
            complete: function( jqXHR, textStatus ) {},
        });
    });
});


$(document).ready(function(){
    $(document).on('click', 'a.cheque-view', function () {

        var cheque_number = $(this).data('cheque_number');
        var id = $(this).attr('id');
        var modal = $("#cheque_view_modal");

        $.ajax({
            url: "{{ url('/bank/view-cheque') }}/"+cheque_number,
            method: "get",
            //data: { id: id },
            dataType: "json",
            cache:false,
            async: false,
            success: function( data ) {
                modal.find('.modal-title').text( "View Account ("+ data.account_data.account_name +")" );
                modal.find('#account_name').text( data.account_data.account_name );
                modal.find('.bank_name').text( data.bank_name );
                modal.find('.branch span').text( data.account_data.branch );
                modal.find('.swift_code').text( data.account_data.swift_code );
                modal.find('#account_number').text( data[0].account_number );
                modal.find('.chequeQRCode').attr("src", "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl="+"Bank Name: "+data.bank_name+", branch: "+data.account_data.branch+", A/C Name: "+data.account_data.account_name+", A/C No. "+data[0].account_number+", Cheque Number: "+data[0].cheque_number+"&choe=UTF-8" );
                modal.find('#cheque_number').text( data[0].cheque_number );
                modal.find('#cheque_type').text( data[0].cheque_type );
                modal.find('.cheque-right .cheque_type').text( data[0].cheque_type );
                modal.find('#cheque_date').text( data[0].cheque_date.split('-')[2]+"/"+data[0].cheque_date.split('-')[1]+"/"+data[0].cheque_date.split('-')[0] );
                modal.find('.date_span span:eq(0)').text( data.date_span[0] );
                modal.find('.date_span span:eq(1)').text( data.date_span[1] );
                modal.find('.date_span span:eq(2)').text( data.date_span[2] );
                modal.find('.date_span span:eq(3)').text( data.date_span[3] );
                modal.find('.date_span span:eq(4)').text( data.date_span[4] );
                modal.find('.date_span span:eq(5)').text( data.date_span[5] );
                modal.find('.date_span span:eq(6)').text( data.date_span[6] );
                modal.find('.date_span span:eq(7)').text( data.date_span[7] );
                modal.find('#cheque_amount').text( takaFormat( data[0].debit ) );
                modal.find('#party_name').text( data[0].party_name );
                modal.find('#party_name2').text( data[0].party_name );
                modal.find('#in_word').text( data.in_word );

                modal.modal("show");
            },
            beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
            complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
        });
    });
}); //End of Document ready
</script>
@endsection

