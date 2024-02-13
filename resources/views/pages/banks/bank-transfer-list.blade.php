@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInRight">
        <div class="box-header with-border">
            <h2 class="box-title float-left">Bank Transfers</h2>
            <div class="box-tools float-right">
                <div class="float-left" style="margin-right: 5px; width: 100px;">
                    <label for="bank_name" class="control-label sr-only">Bank Name:</label>
                    <select id="bank_name" name="bank_name" class="custom-select custom-select-sm">
                        <option value="" selected="selected">{{ __('Bank Name') }}</option>
                        <?php $bank_name_lists = DB::table('bank_name_lists')->pluck("bank_name", "bank_name_id"); ?>
                        @foreach( $bank_name_lists as $key => $bank_name )
                        <option value="{{ $key }}">{{ $bank_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="float-left" style="margin-right: 5px; width: 130px;">
                    <select id="bank_account_id" name="bank_account_id" class="custom-select custom-select-sm">
                        <option value="">-- Account Name --</option>
                        <?php $bank_accounts = DB::table('bank_accounts')->select('account_name', 'account_number', 'bank_account_id')->get(); ?>

                        @foreach($bank_accounts as $bank_account )
                        <option value="{{ $bank_account->bank_account_id }}">{{ $bank_account->account_name . " (" . $bank_account->account_number . ")" }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="float-left" style="margin-right: 5px; position: relative; width: 120px;">
                    <label for="cheque_book_no" class="control-label sr-only">Issued to Bank:</label>
                    <input type="datetime" name="cheque_book_no" id="cheque_book_no" class="form-control form-control-sm" placeholder="DD/MM/YYYY" />
                </div>
                <div class="float-left" style="margin-right: 5px; width: 80px;">
                    <label for="cheque_book_no" class="control-label sr-only">Amount (>):</label>
                    <input type="text" name="cheque_book_no" id="cheque_book_no" class="form-control form-control-sm" placeholder="Amount (>)" />
                </div>
                <div class="float-left" style="margin-right: 5px; width: 80px;">
                    <label for="cheque_book_no" class="control-label sr-only">Amount (<):</label>
                    <input type="text" name="cheque_book_no" id="cheque_book_no" class="form-control form-control-sm" placeholder="Amount (<)" />
                </div>
                <button type="button" class="btn btn-info btn-sm showNewBankTransferModal" data-toggle="tooltip" data-placement="top" title="New Bank Transfer"><i class="fa fa-plus"></i> New Bank Transfer</button>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->

        <div class="box-body table-responsive">
            <table id="general_datatable" class="table table-custom">
                <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        <th>Transfer Date</th>
                        <th>Trx Reference</th>
                        <th>Client</th>
                        <th>Beneficiary Name</th>
                        <th>Account Number</th>
                        <th>Bank Name</th>
                        <th>Branch</th>
                        <th>Transfer Amount</th>
                        <th data-orderable="false" class="no-print" style="width:60px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($bank_transfer_info as $bank_transfer)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ date('d/m/Y', strtotime($bank_transfer->transfer_date)) }}</td>
                        <td>{{ $bank_transfer->transfer_reference }}</td>
                        <td>{{ $bank_transfer->client_name }}</td>
                        <td>{{ $bank_transfer->account_name }}</td>
                        <td>{{ $bank_transfer->account_number }}</td>
                        <td>{{ $bank_transfer->bank_name }}</td>
                        <td>{{ $bank_transfer->bank_branch }}</td>
                        <td>{{ taka_format('', $bank_transfer->transfer_amount ) }}</td>
                        <td>
                            <button type="button" class="btn btn-info btn-sm view-bank-transfer" id="{{ $bank_transfer->transfer_id }}"><i class="fa fa-eye" aria-hidden="true"></i></button>
                            <button type="button" class="btn btn-warning btn-sm editReceivedCheque" id="{{ $bank_transfer->transfer_id }}" data-url="{{ url('/bank/edit-bank-transfer/' .  $bank_transfer->transfer_id) }}"><i class="fa fa-edit" aria-hidden="true"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="total_row">
                    <tr>
                        <th colspan="8">Total Amount</th>
                        <th><?php echo taka_format('', DB::table('bank_transfers')->sum('transfer_amount') ); ?></th>
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

@include('pages.banks.bank-transfer-new-modal')
@include('pages.banks.bank-transfer-edit-modal')
@include('pages.banks.bank-transfer-view-modal')

@endsection


@section('custom_js')
<script type="text/javascript">
    $(document).ready(function(){
        $('button.showNewBankTransferModal').on('click', function () {
            var modal = $("#newBankTransferModal");
            modal.modal({ backdrop: "static", keyboard: true });
            modal.on('shown.bs.modal', function(){ $(":input[type='text']:enabled:visible:first").focus(); });
        });
    }); //End of Document ready


    $(document).ready(function(){
        $(document).on('click', 'button.edit-cheque-receive', function () {

            var url = $(this).data('url');
            var id = $(this).attr('id');
            var modal = $("#EditChequePaymentModal");

            $.ajax({
                url: url,
                method: "get",
                data: { id: id },
                dataType: "json",
                success: function( response ) {
                    modal.find('.modal-title').text( "Update Bank" );
                    modal.find('input[name=bank_account_id]').val( response.bank_account_id );
                    modal.find('#bank_name').val( response.bank_name );
                    modal.find('#branch').val( response.branch );
                    modal.find('#account_name').val( response.account_name );
                    modal.find('#account_number').val( response.account_number );
                    modal.find('#percent').val( response.percent );
                    modal.find('#bank_address').val( response.bank_address );

                    modal.modal({ backdrop: "static", keyboard: true });
                    modal.on('shown.bs.modal', function(){ $(":input[type='text']:enabled:visible:first").focus(); });
                },
                statusCode:{ 404: function(){ alert( "page not found" ); } },
                beforeSend: function( xhr ) { $(".ajax-loader").show(); },
                complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide(); },
            });
        });


        $(document).on('click', 'button.view-bank-transfer', function () {

            var id = $(this).attr('id');
            var modal = $("#view_bank_transfer_modal");

            $.ajax({
                url: "{{ url('/bank/view-bank-transfer') }}/" + id,
                method: "get",
                //data: { id: id },
                dataType: "json",
                cache:false,
                async: false,
                success: function( data ) {
                    modal.find('.modal-title').text( "View Bank Transfer from ("+ data.client_name +")" );
                    if( data[0].transfer_date ){ modal.find('.transfer_date').text( data[0].transfer_date.split('-')[2]+"/"+data[0].transfer_date.split('-')[1]+"/"+data[0].transfer_date.split('-')[0] ); }
                    modal.find('.transfer_reference').text( data[0].transfer_reference );
                    modal.find('.client_name').text( data.client_name );
                    modal.find('.account_name').text( data['account'].account_name );
                    modal.find('.account_number').text( data['account'].account_number );
                    modal.find('.bank_name').text( data[0].bank_name );
                    modal.find('.bank_branch').text( data[0].bank_branch );
                    modal.find('.transfer_amount').text( data[0].transfer_amount.toFixed(2) );
                    modal.find('.po_number').text( data['po'].po_number );
                    if( data['po'].po_date ){ modal.find('.po_date').text( data['po'].po_date.split('-')[2]+"/"+data['po'].po_date.split('-')[1]+"/"+data['po'].po_date.split('-')[0] ); }
                    modal.find('.bill_no').text( data['client_bill'].bill_no );
                    if( data['client_bill'].bill_date ){ modal.find('.bill_date').text( data['client_bill'].bill_date.split('-')[2]+"/"+data['client_bill'].bill_date.split('-')[1]+"/"+data['client_bill'].bill_date.split('-')[0] ); }
                    modal.find('.description').text( data[0].description );

                    modal.modal("show");
                },
                beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
                complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
            });
        });


        $(document).on('change', 'select#bank_account_id', function () {
            var bank_account_id = $(this).find('option:selected').val();
            if(!bank_account_id) return;

            $.ajax({
                url : "{{ url('/bank/bank-transfer/get-account-data') }}",
                type : "GET",
                dataType : "json",
                data: {bank_account_id: bank_account_id },
                success:function( data ){
                    $("#account_number").val( data[0].account_number );
                    $("#bank_transfer_bank").val( data.bank_name );
                    $("#bank_transfer_branch").val( data[0].branch );
                },
                beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
                complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
            });
        });

        $(document).on('change', 'select#client_id', function () {
            var client_id = $(this).find('option:selected').val();
            if(!client_id) return;

            $.ajax({
                url: "{{ url('/bank/get-bill-list') }}",
                type: "GET",
                dataType: "json",
                data: { client_id: client_id },
                success:function( data ){
                    $('select#bill_no').empty();
                    $('select#bill_no').append('<option value="">Select Bill No</option>');

                    $.each(data, function(key, value){
                        $('select#bill_no').append('<option value="'+ value +'">'+ value +'</option>');
                    });
                },
                beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
                complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
            });
        });

        $(document).on('change', 'select#bill_no', function () {
            var bill_no = $(this).find('option:selected').val();
            if(!bill_no) return;
            var modal = $(this).parents('.modal');

            $.ajax({
                url: "{{ url('/bank/get-po-and-bill-data') }}",
                type: "GET",
                dataType: "json",
                data: { bill_no: bill_no },
                success:function( data ){
                    modal.find('#bill_date').val( data.bill_date.split('-')[2]+"/"+data.bill_date.split('-')[1]+"/"+data.bill_date.split('-')[0] );
                    modal.find('#client_bill_id').val( data.client_bill_id );
                    modal.find('#po_number').val( data[0].po_number );
                    modal.find('#po_date').val( data[0].po_date.split('-')[2]+"/"+data[0].po_date.split('-')[1]+"/"+data[0].po_date.split('-')[0] );
                    modal.find('#po_id').val( data[0].po_id );
                    modal.find('#project_name').val( data[0].project_name );
                },
                beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
                complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
            });
        });

        $('button#refreshClient').on('click', function () {
            $.ajax({
                url: "{{ url('/bank/received-cheque/reload-client') }}",
                type: "GET",
                dataType: "json",
                success:function( data ){
                    $('select#client_id').empty();
                    $('select#client_id').append('<option value="">Select Client Name</option>');

                    $.each(data, function(key, value){
                        $('select#client_id').append('<option value="'+ key +'">'+ value +'</option>');
                    });
                },
                beforeSend: function( xhr ) { $("button#refreshClient i").addClass('fa-spin'); },
                complete: function( jqXHR, textStatus ) {
                    $('.reloadedMsg').remove();
                    $("button#refreshClient i").removeClass('fa-spin');
                    $('select#client_id').parents(".col-6").append('<span class="text-success reloadedMsg">Client list reloaded successfully!</span>');
                    $('.reloadedMsg').delay(1000).slideUp('slow');
                },
            });
        });
    }); //End of Document ready
</script>
@endsection

