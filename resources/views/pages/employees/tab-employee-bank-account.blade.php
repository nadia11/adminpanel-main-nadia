<div class="row">

    @php $employee_id = $employee_data->employee_id @endphp
    <?php $exist_account = DB::table('employee_bank_accounts')->where('employee_id', $employee_id)->exists(); ?>

    @if( $exist_account )
    <div class="col-md-6">
        @php $account_data = DB::table('employee_bank_accounts')
            ->join('employees', 'employee_bank_accounts.employee_id', '=', 'employees.employee_id')
            ->join('bank_name_lists', 'employee_bank_accounts.bank_name_id', '=', 'bank_name_lists.bank_name_id')
            ->select('employee_bank_accounts.*', 'bank_name_lists.bank_name as bank_name', 'employees.employee_name', 'employees.employee_id')
            ->where('employees.employee_id', $employee_id)->first()@endphp

        <table class="table table-bordered table-verticle">
            <tr>
                <th style="width: 20%;">Account Name</th>
                <td style="width: 1%;">:</td>
                <td>{{ $account_data->employee_name }}</td>
            </tr>
            <tr>
                <th>Account Number</th>
                <td>:</td>
                <td>{{ $account_data->account_number }}</td>
            </tr>
            <tr>
                <th>Bank Name</th>
                <td>:</td>
                <td class="code">{{ $account_data->bank_name }}</td>
            </tr>
            <tr>
                <th>Branch</th>
                <td>:</td>
                <td class="code">{{ $account_data->branch }}</td>
            </tr>
            <tr>
                <th>Account Type</th>
                <td>:</td>
                <td class="code">{{ $account_data->account_type }}</td>
            </tr>
            <tr>
                <th>Opening Date</th>
                <td>:</td>
                <td><?php if($account_data->opening_date > 0): echo date('d/m/Y', strtotime($account_data->opening_date)); endif; ?></td>
            </tr>
        </table>
    </div>
    <div class="col-md-6">
        <table class="table table-bordered table-verticle">
            <tr>
                <th style="width: 20%;">Swift Code</th>
                <td style="width: 1%;">:</td>
                <td class="code">{{ $account_data->swift_code }}</td>
            </tr>
            <tr>
                <th>Phone</th>
                <td>:</td>
                <td>{{ $account_data->phone }}, {{ $account_data->alt_phone }}</td>
            </tr>
            <tr>
                <th>Address</th>
                <td>:</td>
                <td>{{ $account_data->bank_address }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>:</td>
                <td>{{ $account_data->email }}</td>
            </tr>
            <tr>
                <th>Website</th>
                <td>:</td>
                <td>{{ $account_data->website }}</td>
            </tr>
            <tr>
                <th>Note</th>
                <td>:</td>
                <td>{{ $account_data->bank_note }}</td>
            </tr>
        </table>
    </div>

    @else
    <div class="col-md-12">
        <div style="margin: 20px 0;">
            <h2 class="float-left">Account Information</h2>
            <a href="{{ URL::to('/employee/employee-bank-account') }}" class="btn btn-info btn-sm btn-square float-right" data-toggle="tooltip" data-placement="top" title="Employee with Salary"><i class="fa fa-plus"></i> Add Employee Bank Account</a>
            <table class="table table-bordered table-verticle">
                <tr>
                    <td>No Account Found. Please Create Account first.</td>
                </tr>
            </table>
        </div>
    </div>
    @endif

</div>
