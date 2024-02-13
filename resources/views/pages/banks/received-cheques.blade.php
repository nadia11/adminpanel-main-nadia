@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInRight">
        <div class="box-header with-border">
            <h2 class="box-title float-left">Received Cheques</h2>
            <div class="box-tools float-right">
                <div class="float-left" style="margin-right: 5px; position: relative; width: 90px;">
                    <label for="voucher_no" class="control-label sr-only">Voucher No</label>
                    <input type="text" name="voucher_no" id="voucher_no" class="form-control form-control-sm" placeholder="Voucher No" />
                </div>
                <div class="float-left" style="margin-right: 5px; position: relative; width: 90px;">
                    <label for="cheque_number" class="control-label sr-only">Cheque No</label>
                    <input type="text" name="cheque_number" id="cheque_number" class="form-control form-control-sm" placeholder="Cheque No" />
                </div>
                <div class="float-left" style="margin-right: 5px; position: relative; width: 90px;">
                    <label for="money_receipt" class="control-label sr-only">Money Receipt</label>
                    <input type="text" name="money_receipt" id="money_receipt" class="form-control form-control-sm" placeholder="Money Receipt" />
                </div>
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
                        <?php $bank_accounts = DB::table('bank_cheque_books')->join('bank_accounts', 'bank_cheque_books.bank_account_id', '=', 'bank_accounts.bank_account_id')->select('bank_accounts.account_name', 'bank_accounts.account_number', 'bank_accounts.bank_account_id')->distinct()->get(); ?>

                        @foreach($bank_accounts as $bank_account )
                        <option value="{{ $bank_account->bank_account_id }}">{{ $bank_account->account_name . " (" . $bank_account->account_number . ")" }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="float-left" style="margin-right: 5px; width: 110px;">
                    <select id="division_id" name="division_id" class="custom-select custom-select-sm">
                        <option value="" selected="selected">{{ __('Cheque Status') }}</option>
                        <option value="0">Cleared</option>
                        <option value="2">Issued To Bank</option>
                        <option value="3">Rejected</option>
                        <option value="1">Dishonored</option>
                        <option value="1">On Hand</option>
                        <option value="1">Returned to Client</option>
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
                <button type="button" class="btn btn-info btn-sm showNewChequeReceivedModal" data-toggle="tooltip" data-placement="top" title="New Cheque Receipt"><i class="fa fa-plus"></i> New Cheque Receive</button>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->

        <div class="box-body table-responsive">
            <table id="general_datatable" class="table table-custom">
                <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        <th>Voucher</th>
                        <th>Received Date</th>
                        <th>Client</th>
                        <th>Cheque Number</th>
                        <th>Cheque Date</th>
                        <th>Client Bank</th>
                        <th>MR No</th>
                        <th>Amount</th>
                        <th>Cheque Status</th>
                        <th data-orderable="false" class="no-print" style="width:80px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($received_cheque_info as $received_cheque)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><a href="{{ URL::to('/voucher/' . $received_cheque->received_cheque_id) }}">{{ $received_cheque->voucher_id }}</a></td>
                        <td>{{ date('d/m/Y', strtotime($received_cheque->received_date)) }}</td>
                        <td>{{ $received_cheque->client_name }}</td>
                        <td>{{ $received_cheque->cheque_number }}</td>
                        <td>{{ date('d/m/Y', strtotime($received_cheque->cheque_date)) }}</td>
                        <td>{{ $received_cheque->client_bank }}</td>
                        <td>{{ $received_cheque->money_receipt_no }}</td>
                        <td>{{ taka_format('', $received_cheque->cheque_amount ) }}</td>
                        <td><button type="button" class="btn <?php if($received_cheque->received_cheque_status == 'issued_to_bank'){ echo 'btn-info'; }else if($received_cheque->received_cheque_status == 'dishonored'){ echo 'btn-danger'; }else if($received_cheque->received_cheque_status == 'cleared'){ echo 'btn-success'; }else if($received_cheque->received_cheque_status == 'returned_to_client'){ echo 'btn-warning'; }else{ echo 'btn-light'; } ?> btn-sm change-received-cheque-status" id="{{ $received_cheque->received_cheque_id }}" data-href="{{ URL::to( 'received-cheque-status/' . $received_cheque->received_cheque_id) }}"><?php if($received_cheque->received_cheque_status == 'issued_to_bank'){ echo 'Issued To Bank'; }else if($received_cheque->received_cheque_status == 'dishonored'){ echo 'Dishonored'; }else if($received_cheque->received_cheque_status == 'cleared'){ echo 'Cleared'; }else if($received_cheque->received_cheque_status == 'returned_to_client'){ echo 'Returned to Client'; }else{ echo 'On Hand'; } ?></button></td>
                        <td>
                            <button type="button" class="btn btn-info btn-sm view-change-history" id="{{ $received_cheque->received_cheque_id }}" title="View Change History"><i class="fa fa-history" aria-hidden="true"></i></button>
                            <button type="button" class="btn btn-outline-info btn-sm view-received-cheque" id="{{ $received_cheque->received_cheque_id }}"><i class="fa fa-eye fa-lg" aria-hidden="true"></i></button>
                            <button type="button" class="btn btn-warning btn-sm editReceivedCheque" id="{{ $received_cheque->received_cheque_id }}" data-url="{{ url('/bank/edit-received-cheque/' .  $received_cheque->received_cheque_id) }}"><i class="fa fa-edit" aria-hidden="true"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="total_row">
                    <tr>
                        <th colspan="8">Total Amount</th>
                        <th><?php echo taka_format('', DB::table('bank_received_cheques')->sum('cheque_amount') ); ?></th>
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

@include('pages.banks.received-cheque-new-modal')
@include('pages.banks.received-cheque-edit-modal')
@include('pages.banks.received-cheque-view-modal')
@include('pages.banks.received-cheque-status-modal')
@include('pages.banks.received-cheque-change-history-modal')

@endsection


@section('custom_js')
<script type="text/javascript">
    $(document).ready(function(){
        $('button.showNewChequeReceivedModal').on('click', function () {
            var modal = $("#newChequeReceivedModal");
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


        $(document).on('click', 'button.view-received-cheque', function () {

            var id = $(this).attr('id');
            var modal = $("#view_received_cheque_modal");

            $.ajax({
                url: "{{ url('/bank/view-received-cheque') }}/" + id,
                method: "get",
                //data: { id: id },
                dataType: "json",
                cache:false,
                async: false,
                success: function( data ) {
                    modal.find('.modal-title').text( "View Received Cheque from ("+ data.client_name +")" );
                    modal.find('.voucher_id').text( data[0].voucher_id );
                    modal.find('.client_name').text( data.client_name );
                    modal.find('.cheque_number').text( data[0].cheque_number );
                    if( data[0].cheque_date ){ modal.find('.cheque_date').text( data[0].cheque_date.split('-')[2]+"/"+data[0].cheque_date.split('-')[1]+"/"+data[0].cheque_date.split('-')[0] ); }
                    modal.find('.cheque_amount').text( data[0].cheque_amount.toFixed(2) );
                    modal.find('.received_cheque_status').text( data[0].received_cheque_status.replace('_', ' ').replace('_', ' ') );
                    if( data[0].received_date ){ modal.find('.received_date').text( data[0].received_date.split('-')[2]+"/"+data[0].received_date.split('-')[1]+"/"+data[0].received_date.split('-')[0] ); }
                    modal.find('.client_bank').text( data[0].client_bank );
                    modal.find('.money_receipt_no').text( data[0].money_receipt_no );
                    modal.find('.collection_person').text( data[0].collection_person );
                    modal.find('.account_name').text( data['account'].account_name );
                    modal.find('.account_number').text( data['account'].account_number );
                    modal.find('.received_bank').text( data[0].received_bank );
                    modal.find('.received_branch').text( data[0].received_branch );
                    modal.find('.po_number').text( data['po'].po_number );
                    if( data['po'].po_date ){ modal.find('.po_date').text( data['po'].po_date.split('-')[2]+"/"+data['po'].po_date.split('-')[1]+"/"+data['po'].po_date.split('-')[0] ); }
                    modal.find('.bill_no').text( data['client_bill'].bill_no );
                    if( data['client_bill'].bill_date ){ modal.find('.bill_date').text( data['client_bill'].bill_date.split('-')[2]+"/"+data['client_bill'].bill_date.split('-')[1]+"/"+data['client_bill'].bill_date.split('-')[0] ); }

                    modal.find('.dr_account').text( data[0].dr_account );
                    modal.find('.description').text( data[0].description );

                    modal.modal("show");
                },
                beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
                complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
            });
        });


        $(document).on('click', 'button.change-received-cheque-status', function (e) {
            e.preventDefault();

            if( $(this).text() == "Cleared" ) return;
            var modal = $("#received_cheque_status_modal");

            modal.find('input[name=received_cheque_id]').val( $(this).attr('id') );
            modal.modal('show');
        });

        $("form#received-cheque-status").submit(function (event) {
            event.preventDefault();
            $("button[type=submit]").attr('disabled', 'disabled').html("<i class='fa fa-floppy-disk'></i> Saving...");

            var form = $(this);
            var received_cheque_status = form.find('#received_cheque_status').val();
            var received_cheque_id = form.find('input[name=received_cheque_id]').val();
            var url = form.attr("action");

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $.ajax({
                type: "POST",
                url: url,
                data: {received_cheque_id: received_cheque_id, received_cheque_status: received_cheque_status},
                dataType: 'json',
                success: function (data) {
                    var status_class = data.status == 'issued_to_bank' ? "btn-info" : (data.status == 'dishonored' ? "btn-danger" : (data.status == 'cleared' ? "btn-success" : (data.status == 'returned_to_client' ? "btn-warning" : "btn-light" )));
                    var status_text = data.status == 'issued_to_bank' ? "Issued To Bank" : (data.status == 'dishonored' ? "Dishonored" : (data.status == 'cleared' ? "Cleared" : (data.status == 'returned_to_client' ? "Returned to Client" : "On Hand" )));

                    $('button#' + received_cheque_id).text( status_text );
                    $('button#' + received_cheque_id).removeAttr('class').attr('class', 'btn btn-sm change-received-cheque-status '+ status_class);

                    toastr.success( data.success );
                    $('#received_cheque_status_modal').modal('hide');
                    $("button[type=submit]").removeAttr('disabled').html("<i class='fa fa-save'></i> Change Status");
                },
                statusCode:{ 404: function(){ alert( "page not found" ); } },
                error: function (xhr, textStatus, errorThrown) { alert(errorThrown); },
                beforeSend: function( xhr ) { $(".ajax-loader").show('slow'); },
                complete: function( jqXHR, textStatus ) { $(".ajax-loader").hide('fast'); },
            });
            return false;
        });

        $(document).on('click', 'button.view-change-history', function (){
            var id = $(this).attr('id');
            var modal = $("#change_history_modal");

            $.ajax({
                url: "{{ url('/bank/view-change-history') }}/" + id,
                method: "get",
                dataType: "json",
                cache:false,
                async: false,
                success: function( data ) {
                    modal.find('.cheque_number').text( data[0].cheque_number );
                    modal.find('.client_name').text( data.client_name );
                    if( data[0].cheque_date ){ modal.find('.cheque_date').text( data[0].cheque_date.split('-')[2]+"/"+data[0].cheque_date.split('-')[1]+"/"+data[0].cheque_date.split('-')[0] ); }
                    modal.find('.cheque_amount').text( data[0].cheque_amount.toFixed(2) );
                    modal.find('.voucher_id').text( data[0].voucher_id !== null | "" ? data[0].voucher_id : "0" );
                    modal.find('.client_bank').text( data[0].client_bank );
                    modal.find('.client_name').text( data.client_name );

                    if(data.change_histories.length){
                        modal.find('table').find('tbody').empty();
                        $.each(data.change_histories, function(key, value){
                            key=key+1;
                            modal.find('table').find('tbody').append( '<tr><td>'+ key +'</td><td class="text-capitalize">'+ value.received_cheque_status.replace('_', ' ').replace('_', ' ') +'</td><td>'+ value.transaction_date.split('-')[2]+"/"+value.transaction_date.split('-')[1]+"/"+value.transaction_date.split('-')[0] +'</td><td>'+ value.description +'</td></tr>' );
                        });
                    }else{
                        modal.find('table').find('tbody').empty();
                        modal.find('table').find('tbody').append( '<tr><td colspan="4" class="py-5 display-4">No records to view</td></tr>' );
                    }
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
                url : "{{ url('/bank/received-cheque/get-account-data') }}",
                type : "GET",
                dataType : "json",
                data: {bank_account_id: bank_account_id },
                success:function( data ){
                    $("#account_number").val( data[0].account_number );
                    $("#received_bank").val( data.bank_name );
                    $("#received_branch").val( data[0].branch );
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

