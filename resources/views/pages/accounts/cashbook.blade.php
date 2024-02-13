@extends('dashboard')
@section('main_content')

<section class="content" style="margin: 0 auto 70px;">
    <div class="box box-success">
        <div class="box-header with-border">
            <h2 class="box-title"><i class="fa fa-cash-register"></i>Cashbook</h2>
            <div class="box-tools float-right" style="margin-right: 2%; width: 75%;">
                <div class="float-right" style="margin-right: .5%;">
                    <a class="btn btn-success btn-sm" href="{{ URL::to('/account/cashbook-entry') }}"><i class="fa fa-dollar-sign"></i> Cashbook Entry</a>
                </div>
                <div class="float-right" style="margin-right: .5%;">
                    <button type="button" class="btn btn-warning btn-sm" id="daterange-btn">
                       <span>Date range picker </span><i class="fa fa-caret-down"></i>
                    </button>
                </div>
                <div class="float-right" style="margin-right: .5%; width: 110px;">
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text" style="padding: 3px;">To</span></div>
                        <input type="datetime-locale" name="custom_date_end" id="custom_date_end" class="form-control btn-sm" value="<?php echo date('Y-m-d'); ?>" />
                    </div>
                </div>
                <div class="float-right" style="margin-right: .5%; width: 110px;">
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text" style="padding: 3px;">From</span></div>
                        <input type="datetime-locale" name="custom_date_begin" id="custom_date_begin" class="form-control btn-sm" value="<?php echo date('Y-m-d'); ?>" />
                    </div>
                </div>
                <div class="float-right" style="margin-right: 5px; width: 140px;">
                    <select id="employee_id" name="employee_id" class="custom-select custom-select-sm">
                        <option value="">-- Employee Name --</option>
                        <?php $employees = DB::table('employees')->join('designations', 'employees.designation_id', '=', 'designations.designation_id')->select("designations.designation_name", 'employees.employee_id', "employees.employee_name")->get(); ?>

                        @foreach($employees as $employee )
                        <option value="{{ $employee->employee_id }}">{{ $employee->employee_name }} - {{ $employee->designation_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="float-right" style="margin-right: 5px; width: 140px;">
                    <select id="bank_account_id" name="bank_account_id" class="custom-select custom-select-sm">
                        <option value="">-- Head of Accounts --</option>
                        <?php $account_heads = DB::table('account_heads')->pluck('account_head_name', 'account_head_id'); ?>

                        @foreach($account_heads as $id => $name )
                        <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div><!-- /.box-tools -->

            <div class="box-tools float-right">
                <button type="button" class="btn btn-box-tool" id="refresh" data-toggle="tooltip" data-placement="top" title="Refresh"><i class="fa fa-sync-alt"></i></button>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->

        <div class="box-body">
            <table id="general_datatable" class="table table-bordered table-custom cashbook_table table-sm">
                <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        <th class="row_group" style="width: 14%">Entry Date</th>
                        <th>Voucher Number</th>
                        <th>Head of Accounts</th>
                        <th>Party Type</th>
                        <th>Party Name</th>
                        <th>Description</th>
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
                        <td>@if($cashbook_info->created_at > 0) {{ date('d/m/Y h:i:s A', strtotime($cashbook_info->entry_date)) }} @endif</td>
                        <td>{{ isset( $cashbook_info->voucher_number ) ? $cashbook_info->voucher_number : "-" }}</td>
                        <td>{{ $cashbook_info->account_head_name }}</td>
                        <td class="text-capitalize">{{ isset( $cashbook_info->party_type ) ? $cashbook_info->party_type : "-" }}</td>
                        <td>{{ isset( $cashbook_info->party_name ) ? $cashbook_info->party_name : "-" }}</td>
                        <td>{{ $cashbook_info->description }}</td>
                        <td>{{ isset( $cashbook_info->debit ) ? taka_format('', $cashbook_info->debit ) : "-" }}</td>
                        <td>{{ isset( $cashbook_info->credit ) ? taka_format('', $cashbook_info->credit ) : "-" }}</td>
                        <td data-balance="<?php $new_balance = $cashbook_info->credit - $cashbook_info->debit; $balance_bf += $new_balance; echo $balance_bf; ?>">{{ taka_format('', $balance_bf ) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="total_row">
                    <tr>
                        <th colspan="7">Total </th>
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
</section>

@endsection

