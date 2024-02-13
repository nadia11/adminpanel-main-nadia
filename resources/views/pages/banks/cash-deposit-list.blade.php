@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInRight">
        <div class="box-header with-border">
            <h2 class="box-title">Cash Deposit List</h2>
            <div class="filter-button float-right box-tools" style="width: 100%;">
                <div class="float-right" style="margin-right: .5%;">
                    <button type="button" class="btn btn-info showCashDepositModal btn-sm" data-toggle="tooltip" data-placement="top" title="Cash Deposit from bank"><i class="fa fa-reply"></i> Cash Deposit</button>
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
                    <select id="cash_deposit_status" name="cash_deposit_status" class="custom-select custom-select-sm">
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
            <table id="general_datatable" class="table table-striped table-custom">
                <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        <th>Deposit Date</th>
                        <th>Account Name</th>
                        <th>Account Number</th>
                        <th>Bank Name</th>
                        <th>Branch</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($cash_deposit_info as $cash_deposit)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ date('d/m/Y', strtotime($cash_deposit->cash_deposit_date)) }}</td>
                        <td>{{ $cash_deposit->account_name }}</td>
                        <td>{{ $cash_deposit->account_number }}</td>
                        <td>{{ $cash_deposit->bank_name }}</td>
                        <td>{{ $cash_deposit->branch }}</td>
                        <td data-index="currency">{{ $cash_deposit->cash_deposit_amount }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="total_row">
                <tr>
                    <th colspan="6">Total </th>
                    <th><?php echo taka_format('', DB::table('cash_deposits')->SUM('cash_deposit_amount') ); ?></th>
                </tr>
                </tfoot>
            </table>
        </div><!-- /.box-body -->

        <div class="overlay" style="display: none;">
            <i class="fa fa-sync-alt fa-spin"></i>
        </div>
    </div><!-- /.box -->
</section>

@include('pages.banks.cash-deposit-new-modal')
@include('pages.banks.cash-deposit-view-modal')

@endsection


@section('custom_js')
<script type="text/javascript">
    $(document).ready(function(){
        $('button.showCashDepositModal').on('click', function () {
            var modal = $("#showCashDepositModal");
            modal.modal({ backdrop: "static", keyboard: true });
            modal.on('shown.bs.modal', function(){ $(":input[type='text']:enabled:visible:first").focus(); });
        });

        $(document).on('change', 'select#bank_account_id', function () {
            var bank_account_id = $(this).find('option:selected').val();
            if(!bank_account_id) return;

            $.ajax({
                url : "{{ url('/bank/cash-deposit/get-account-data') }}",
                type : "GET",
                dataType : "json",
                data: {bank_account_id: bank_account_id },
                success:function( data ){
                    $("#account_number").val( data[0].account_number );
                    $("#bank_name").val( data.bank_name );
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
    }); //End of Document ready

    $(document).ready(function(){
        $(document).on('click', 'button.view-cash-deposit', function () {

            var url = $(this).data('url');
            var id = $(this).attr('id');
            var modal = $("#view_cash_deposit_modal");

            $.ajax({
                url: url,
                method: "get",
                //data: { id: id },
                dataType: "json",
                cache:false,
                async: false,
                success: function( data ) {
                    modal.find('.modal-title').text( "View Cheque Cash Deposit to ("+ data[0].party_type + ": " + data[0].party_name +")" );
                    modal.find('.Cash Deposit_date').text( data[0].cash_deposit_date.split('-')[2]+"/"+data[0].cash_deposit_date.split('-')[1]+"/"+data[0].cash_deposit_date.split('-')[0] );
                    modal.find('.party_type').text( data[0].party_type );
                    modal.find('.party_name').text( data[0].party_name );
                    modal.find('.account_name').text( data.account_name );
                    modal.find('.account_number').text( data[0].account_number );
                    modal.find('.bank_name_id').text( data[0].bank_name );
                    modal.find('.branch').text( data[0].branch );
                    modal.find('.cheque_number').text( data[0].cheque_number );
                    modal.find('.cheque_date').text( data[0].cheque_date );
                    modal.find('.cheque_amount').text( data[0].cheque_amount );
                    modal.find('.cash_deposit_status').text( data[0].cash_deposit_status );
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
    }); //End of Document ready
</script>
@endsection

