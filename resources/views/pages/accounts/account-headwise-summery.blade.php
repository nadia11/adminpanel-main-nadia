@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="container-fluid">
        <div class="box box-success animated fadeInLeft">
            <div class="box-header">
                <h3 class="text-center">{{ settings('company_name') }}</h3>
                <h2 class="text-center">Account Head wise Summery</h2>
                <h4 class="text-center">Statement as on : {{ date('d/m/Y') }}</h4>
            </div><!-- /.box-header -->

            <div class="box-body">
                <table id="general_datatable" class="table table-bordered table-custom cashbook_table table-sm">
                    <thead class="thead-inverse">
                        <tr>
                            <th>#</th>
                            <th>Head of Accounts</th>
                            <th>Debit (BDT)</th>
                            <th>Credit (BDT)</th>
                            <th>Balance (BDT)</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $balance_bf = 0; ?>
                    @foreach($cashbook_infos as $cashbook_info)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $cashbook_info->account_head_name }}</td>
                            <td>{{ isset( $cashbook_info->debit ) ? taka_format('', $cashbook_info->debit ) : "-" }}</td>
                            <td>{{ isset( $cashbook_info->credit ) ? taka_format('', $cashbook_info->credit ) : "-" }}</td>
                            <td data-balance="<?php $new_balance = $cashbook_info->credit - $cashbook_info->debit; $balance_bf += $new_balance; echo $balance_bf; ?>">{{ taka_format('', $balance_bf ) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="total_row">
                        <tr>
                            <th colspan="2">Total </th>
                            <?php $balance_total = DB::table('cashbook_entries')->select(DB::raw('SUM(credit) as credit, SUM(debit) as debit'))->first(); ?>
                            <th class="today_debit"><?php echo taka_format('', $balance_total->debit ); ?></th>
                            <th class="today_credit"><?php echo taka_format('', $balance_total->credit ); ?></th>
                            <th class="total_balance"><?php echo taka_format('', $balance_total->credit -  $balance_total->debit); ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div><!-- /.box-body -->

            <div class="overlay" style="display: none;">
                <i class="fa fa-sync-alt fa-spin"></i>
            </div>
        </div><!-- /.box -->
    </div><!-- ./container -->
</section>

@endsection
