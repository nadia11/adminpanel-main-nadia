@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInRight">
        <div class="box-header with-border">
            <h2 class="box-title">Cash Withdraw List</h2>
            <div class="filter-button float-right box-tools" style="width: 100%;">
                <div class="float-right" style="margin-right: .5%;">
                    <button type="button" class="btn btn-info showWithdrawModal btn-sm" data-toggle="tooltip" data-placement="top" title="Withdraw Withdraw from bank"><i class="fa fa-reply"></i> Withdraw Withdraw</button>
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
                    <select id="withdraw_status" name="withdraw_status" class="custom-select custom-select-sm">
                        <option value="">Cheque Status</option>
                        <option value="Pending">Pending</option>
                        <option value="Complete">Complete</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                </div>
                <div class="float-right" style="margin-right: .5%; width: 100px;">
                    <input type="text" name="cheque_number" id="cheque_number" class="form-control form-control-sm" placeholder="Cheque Number" />
                </div>
            </div>
        </div><!-- /.box-header -->

        <div class="box-body">
            <table id="general_datatable" class="table table-striped table-custom">
                <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        <th>Voucher No</th>
                        <th>Withdraw Date</th>
                        <th>Debit Account Name</th>
                        <th>Account Number</th>
                        <th>Bank Name</th>
                        <th>Cheque Number</th>
                        <th>Cheque Date</th>
                        <th>Amount</th>
                        <th data-orderable="false">Cheque Status</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($cash_withdraw_info as $cash_withdraw)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><a href="{{ URL::to('/voucher/' . $cash_withdraw->bank_account_id) }}">{{ $cash_withdraw->bank_account_id }}</a></td>
                        <td>{{ date('d/m/Y', strtotime($cash_withdraw->withdraw_date)) }}</td>
                        <td>{{ $cash_withdraw->account_name }}</td>
                        <td>{{ $cash_withdraw->account_number }}</td>
                        <td>{{ $cash_withdraw->bank_name }}</td>
                        <td><a href="#" class="cheque-view" id="{{ $cash_withdraw->withdraw_id }}" data-cheque_number="{{ $cash_withdraw->cheque_number }}">{{ $cash_withdraw->cheque_number }}</a></td>
                        <td>{{ date('d/m/Y', strtotime($cash_withdraw->cheque_date)) }}</td>
                        <td data-index="currency">{{ $cash_withdraw->cheque_amount }}</td>
                        <td><button type="button" class="btn <?php if($cash_withdraw->withdraw_status == 'Pending'){ echo 'btn-warning'; }else if($cash_withdraw->withdraw_status == 'Reject'){ echo 'badge-danger'; }else{ echo 'badge-success'; } ?> btn-sm withdraw-status" id="{{ $cash_withdraw->withdraw_id }}" data-href="{{ URL::to( 'withdraw-status/' . $cash_withdraw->withdraw_id) }}"><?php if($cash_withdraw->withdraw_status == 'Pending'){ echo 'Pending'; }else if($cash_withdraw->withdraw_status == 'Reject'){ echo 'Reject'; }else{ echo 'Complete'; } ?></button></td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="total_row">
                <tr>
                    <th colspan="7">Total Amount</th>
                    <th><?php echo taka_format('', DB::table('cash_withdraws')->sum('cheque_amount') ); ?></th>
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

@include('pages.banks.cash-withdraw-new-modal')
@include('pages.banks.cash-withdraw-status-modal')
@include('pages.banks.view-cheque-leaf-modal')

@endsection


@section('custom_js')
<script type="text/javascript">
    $(document).ready(function(){
        $('button.showWithdrawModal').on('click', function () {
            var modal = $("#cashWithdrawModal");
            modal.modal({ backdrop: "static", keyboard: true });
            modal.on('shown.bs.modal', function(){ $(":input[type='text']:enabled:visible:first").focus(); });
        });

        $(document).on('change', 'select#bank_account_id', function () {
            var bank_account_id = $(this).find('option:selected').val();
            if(!bank_account_id) return;

            $.ajax({
                url : "{{ url('/bank/cash-withdraw/get-cheque-book-data') }}",
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
                url : "{{ url('/bank/cash-withdraw/get-cheque-leaf') }}",
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


        $(document).on('click', 'button.withdraw-status', function (e) {
            e.preventDefault();
            if( $(this).text() == "Complete" ) return;

            var modal = $("#withdraw_status_modal");
            modal.find('input[name=withdraw_id]').val( $(this).attr('id') );
            modal.modal('show');
        });

        $("form#withdraw-status").submit(function (event) {
            event.preventDefault();
            $("button[type=submit]").attr('disabled', 'disabled').html("<i class='fa fa-floppy-disk'></i> Saving...");

            var form = $(this);
            var withdraw_status = form.find('#withdraw_status').val();
            var id = form.find('input[name=withdraw_id]').val();
            var url = form.attr("action");

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $.ajax({
                type: "POST",
                url: url,
                data: {id: id, data: withdraw_status},
                dataType: 'json',
                success: function (data) {
                    $(".withdraw-status").text( data.status );
                    var status_class = data.status == 'Pending' ? "btn-warning" : (data.status == 'Reject' ? "btn-danger" : "btn-success" );
                    $(".withdraw-status").removeAttr('class').attr('class', 'btn btn-sm withdraw-status '+ status_class);
                    toastr.success( data.success );
                    $('#withdraw_status_modal').modal('hide');
                    $("button[type=submit]").removeAttr('disabled').html("<i class='fa fa-save'></i> Change Status");
                },
                statusCode:{ 404: function(){ alert( "page not found" ); } },
                error: function (xhr, textStatus, errorThrown) { alert(errorThrown); },
                beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
                complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
            });
            return false;
        });

        $(document).on('keyup', 'input.get_balance', function () {
            var bank_account_id = $(this).parents('.modal').find('select#bank_account_id').val();

            var value = $(this).val();
            var $this = $(this);

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
    }); //End of Document ready


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

