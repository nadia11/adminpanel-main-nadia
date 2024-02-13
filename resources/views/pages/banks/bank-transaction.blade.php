@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInLeft">
        <div class="box-header with-border">
            <h2 class="box-title">Bank Transaction</h2>
            <div class="filter-button float-right box-tools" style="margin-right: 3%; width: 80%;">
                <div class="float-right" style="margin-right: .5%;">
                    <button type="button" class="btn btn-warning" id="daterange-btn">
                       <span>Date range picker </span><i class="fa fa-caret-down"></i>
                    </button>
                </div>
                <div class="float-right" style="margin-right: .5%; width: 150px;">
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">To</span></div>
                        <input type="datetime-locale" name="custom_date_end" id="custom_date_end" class="form-control" value="<?php echo date('Y-m-d'); ?>" />
                    </div>
                </div>
                <div class="float-right" style="margin-right: .5%; width: 150px;">
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">From</span></div>
                        <input type="datetime-locale" name="custom_date_begin" id="custom_date_begin" class="form-control" value="<?php echo date('Y-m-d'); ?>" />
                    </div>
                </div>
                <div class="float-right" style="margin-right: 1%">
                    <select id="bank_account_id" name="bank_account_id" class="custom-select" tabindex="6">
                        <option value="">-- Account Name --</option>
                        <?php $bank_accounts = DB::table('bank_accounts')->select('account_name', 'account_number', 'bank_account_id')->get(); ?>

                        @foreach($bank_accounts as $bank_account )
                        <option value="{{ $bank_account->bank_account_id }}">{{ $bank_account->account_name . " (" . $bank_account->account_number . ")" }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="box-tools float-right">
                <button type="button" class="btn btn-box-tool" id="refresh" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-sync-alt"></i></button>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->

        <div class="box-body">
            <table id="general_datatable" class="table table-striped table-custom">
            <thead class="thead-inverse">
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Trx Type</th>
                    <th>Party Type</th>
                    <th>Party Name</th>
                    <th>Voucher</th>
                    <th>A/C Name</th>
                    <th>Cheque No</th>
                    <th>Cheque Date</th>
                    <th>Bank Date</th>
                    <th>Cheque Type</th>
                    <th>Debit</th>
                    <th>Credit</th>
                    <th>Balance</th>
                </tr>
            </thead>
            <tbody>
            <?php $prev_balance = 0; ?>
            @foreach($transaction_info as $trx)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ date('d/m/Y', strtotime($trx->trx_date)) }}</td>
                    <td>{{ ucwords(str_replace("_", " ", $trx->trx_type)) }}</td>
                    <td>{{ $trx->party_type }}</td>
                    <?php $url = $trx->party_type =="Self" ? "#" : URL::to('/'. $trx->party_type .'/view/'.$trx->party_id ); ?>
                    <td><a href="{{ $url }}" target="_blank">{{ $trx->party_name }}</a></td>
                    <td>{{ $trx->voucher_id }}</td>
                    <td>{{ $trx->account_name }} ({{ $trx->account_number }})</td>
                    <td><a href="#" class="cheque-view" id="{{ $trx->trx_id }}" data-cheque_number="{{ $trx->cheque_number }}">{{ $trx->cheque_number }}</a></td>
                    <td>@if($trx->cheque_date > 0) {{ date('d/m/Y', strtotime($trx->cheque_date)) }} @endif</td>
                    <td>@if($trx->bank_date > 0) {{ date('d/m/Y', strtotime($trx->bank_date)) }} @endif</td>
                    <td>{{ $trx->cheque_type }}</td>
                    <td>{{ taka_format('', isset( $trx->debit ) ? $trx->debit : "0" ) }}</td>
                    <td>{{ taka_format('', isset( $trx->credit ) ? $trx->credit : "0" ) }}</td>
                    <td data-balance="<?php $new_balance = $trx->credit - $trx->debit; $prev_balance += $new_balance; echo $prev_balance; ?>">{{ taka_format('', $prev_balance ) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="total_row">
            <tr>
                <th colspan="11">Total </th>
                <th><?php $debit = DB::table('bank_transactions')->sum('debit'); echo taka_format('', $debit ); ?></th>
                <th><?php $credit = DB::table('bank_transactions')->sum('credit'); echo taka_format('', $credit ); ?></th>
                <th><?php echo taka_format('', $credit - $debit ); ?></th>
            </tr>
        </tfoot>
        </table>
        </div><!-- /.box-body -->

        <div class="overlay" style="display: none;">
            <i class="fa fa-sync-alt fa-spin"></i>
        </div>
    </div><!-- /.box -->
</section>

@include('pages.banks.view-cheque-leaf-modal')

@endsection


@section('custom_js')
<script type="text/javascript">
    $(document).ready(function(){
        $('button.showNewBankModal').on('click', function () {
            var modal = $("#newBankModal");
            modal.modal({ backdrop: "static", keyboard: true });
            modal.on('shown.bs.modal', function(){ $(":input[type='text']:enabled:visible:first").focus(); });
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

