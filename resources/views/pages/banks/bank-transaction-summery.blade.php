@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="box box-success animated fadeInLeft">
        <div class="box-header with-border">
            <h2 class="box-title">Bank Transaction Summery (Receipts and Payments) in this month (From {{ $first_day->format('d-m-Y') }} To {{ $last_day->format('d-m-Y') }})</h2>
            <div class="filter-button float-right box-tools" style="margin-right: 3%; width: 80%;">
                <div class="float-right" style="margin-right: 5px; width: 80px;">
                    <label for="cheque_book_no" class="control-label sr-only">Amount (>):</label>
                    <input type="text" name="cheque_book_no" id="cheque_book_no" class="form-control form-control-sm" placeholder="Amount (>)" />
                </div>
                <div class="float-right" style="margin-right: 5px; width: 80px;">
                    <label for="cheque_book_no" class="control-label sr-only">Amount (<):</label>
                    <input type="text" name="cheque_book_no" id="cheque_book_no" class="form-control form-control-sm" placeholder="Amount (<)" />
                </div>
                <div class="float-right" style="margin-right: 1%">
                    <select id="bank_account_id" name="bank_account_id" class="custom-select custom-select-sm">
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
                        <th>A/C Name</th>
                        <th>A/C Number</th>
                        <th>Bank Name</th>
                        <th>Payment Amount</th>
                        <th>Received Amount</th>
                        <th>Balance Amount</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($transaction_summery as $bank)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $bank->account_name }}</td>
                        <td>{{ $bank->account_number }}</td>
                        <td>{{ $bank->bank_name }}</td>
                        <td>{{ taka_format('', $bank->debit) }}</td>
                        <td>{{ taka_format('', $bank->credit) }}</td>
                        <td>{{ taka_format('', $bank->credit - $bank->debit) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="total_row">
                    <tr>
                        <th colspan="4">Total </th>
                        <th class="today_debit"><?php echo taka_format('', $total_query->debit ); ?></th>
                        <th class="today_credit"><?php echo taka_format('', $total_query->credit ); ?></th>
                        <th class="total_balance"><?php echo taka_format('', $total_query->credit - $total_query->debit ); ?></th>
                    </tr>
                </tfoot>
            </table>
        </div><!-- /.box-body -->

        <div class="overlay" style="display: none;">
            <i class="fa fa-sync-alt fa-spin"></i>
        </div>
    </div><!-- /.box -->
</section>

<!--include('pages.banks.new-bank-modal')-->
<!--include('pages.banks.edit-bank-modal')-->

@endsection


@section('custom_js')
<script type="text/javascript">

</script>
@endsection

