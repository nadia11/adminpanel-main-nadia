@extends('dashboard')
@section('main_content')

<section class="content">
    <div class="container-fluid">
        <div class="box box-success animated fadeInLeft">
            <div class="box-header">
                <h3 class="text-center">{{ settings('company_name') }}</h3>
                <h2 class="text-center">Balance Sheet</h2>
                <h4 class="text-center">Statement as on : {{ date('d/m/Y') }}</h4>
            </div><!-- /.box-header -->

            <div class="box-body">
                <table class="table table-custom">
                    <thead class="thead-dark">
                        <tr>
                            <th>Asset Type</th>
                            <th>Asset Name</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $fixed_assets = DB::table('assets')->select('asset_type', 'asset_name', 'asset_total_amount')->get(); ?>
                    @foreach($fixed_assets as $asset )
                        <td>{{ $asset->asset_type }}</td>
                        <td>{{ $asset->asset_name }}</td>
                        <td class="text-right">{{ taka_format("", $asset->asset_total_amount ) }}</td>
                    </tr>
                    @endforeach

                    <tr class="bg-gray-light"><th colspan="2">Total Fixed Assets</th><th class="text-right"><?php echo taka_format("", DB::table('assets')->SUM('asset_total_amount')); ?></th></tr>

                    @foreach($bank_balance as $bank)
                        <tr>
                            <td>Current Assets</td>
                            <td>Bank A/C: {{ $bank->account_name }} - {{ $bank->account_number }}</td>
                            <td class="text-right">{{ taka_format("", $bank->credit - $bank->debit ) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td>Current Assets</td>
                        <td>Account Receivable</td>
                        <td class="text-right"></td>
                    </tr>
                    <tr>
                        <td>Current Assets</td>
                        <td>Purchased Goods</td>
                        <td class="text-right"></td>
                    </tr>
                    <tr>
                        <td>Current Assets</td>
                        <td>Work in Process</td>
                        <td class="text-right"></td>
                    </tr>
                    <tr>
                        <td>Current Assets</td>
                        <td>Head office cash</td>
                        <td class="text-right"></td>
                    </tr>
                    <tr>
                        <td>Current Assets</td>
                        <td>Office Cash</td>
                        <td class="text-right"></td>
                    </tr>
                    <tr>
                        <td>Current Assets</td>
                        <td>Petty Cash</td>
                        <td class="text-right"></td>
                    </tr>

                    <tr><th colspan="2">Total Current Assets</th><th></th></tr>
                    <tr class="table-success"><th colspan="2">Total Assets</th><th></th></tr>
                    </tbody>
                </table>

                <table class="table table-custom" style="margin-top: 30px;">
                    <thead class="thead-light">
                        <tr>
                            <th>Asset Type</th>
                            <th>Asset Name</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Equities</td>
                        <td>Capital</td>
                        <td class="text-right"></td>
                    </tr>
                    <tr>
                        <td>Equities</td>
                        <td>Share Holder</td>
                        <td class="text-right"></td>
                    </tr>
                    <tr>
                        <td>Equities</td>
                        <td>Current Year Income</td>
                        <td class="text-right"></td>
                    </tr>
                    <tr><th colspan="2">Total Equities</th><th></th></tr>

                    <tr>
                        <td>Long Term Liabilities</td>
                        <td>Project Loan</td>
                        <td class="text-right"></td>
                    </tr>
                    <tr><th colspan="2">Total Long Term Liabilities</th><th></th></tr>

                    <tr>
                        <td>Current Liabilities</td>
                        <td>Vendor bill payable</td>
                        <td class="text-right"></td>
                    </tr>
                    <tr>
                        <td>Current Liabilities</td>
                        <td>Salary Payable</td>
                        <td class="text-right"></td>
                    </tr>
                    <tr>
                        <td>Current Liabilities</td>
                        <td>Bonus Payable</td>
                        <td class="text-right"></td>
                    </tr>
                    <tr>
                        <td>Current Liabilities</td>
                        <td>Interest Payable</td>
                        <td class="text-right"></td>
                    </tr>
                    <tr>
                        <td>Current Liabilities</td>
                        <td>Tax Payable</td>
                        <td class="text-right"></td>
                    </tr>
                    <tr>
                        <td>Current Liabilities</td>
                        <td>VAT Payable</td>
                        <td class="text-right"></td>
                    </tr>
                    <tr><th colspan="2">Total Current Liabilities</th><th></th></tr>

                    <tr class="table-success"><th colspan="2">Total Equities & Liabilities</th><th></th></tr>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- ./container -->
</section>

@endsection


@section('custom_js')
<script type="text/javascript">

</script>
@endsection

