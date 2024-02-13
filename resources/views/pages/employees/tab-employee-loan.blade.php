<table class="table table-striped table-custom">
    <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Loan No.</th>
            <th>Type</th>
            <th>App. Date</th>
            <th>Possible Disburse Date</th>
            <th>Disburse Date</th>
            <th>Total Installment</th>
            <th>Paid Installment</th>
            <th>Amount</th>
            <th>Verification</th>
            <th>Approval</th>
            <th>Paid</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
    foreach( $all_employee_info as $employee )
        <tr>
            <td>{ $loop->iteration }}</td>
            <td><a href="{ URL::to('/loan/' . $employee->employee_id) }}">{ $employee->employee_name }}</a></td>
            <td>{ $employee->employee_address }}</td>
            <td>{ $employee->district_id }}</td>
            <td>{ $employee->employee_mobile }}</td>
            <td>{ $employee->employee_email }}</td>
            <td>{ $employee->employee_mobile }}</td>
            <td>{ $employee->employee_mobile }}</td>
            <td>{ $employee->employee_mobile }}</td>
            <td>
                <b data-toggle="tooltip" data-placement="left" title="Verified Date">Date: </b>2018-04-18<br>
                <b data-toggle="tooltip" data-placement="left" title="Verified By">By: </b>king<br>
                <b data-toggle="tooltip" data-placement="left" title="Verified Amount">Amount: </b>2,000<br>
                <b data-toggle="tooltip" data-placement="left" title="Verified Installment Amount">Installment Amount: </b>2,000<br>
                <b data-toggle="tooltip" data-placement="left" title="Verified Total Installment">Total Installment: </b>1
            </td>
            <td>
                <b data-toggle="tooltip" data-placement="left" title="Approved Date">Date: </b>2018-04-18<br>
                <b data-toggle="tooltip" data-placement="left" title="Approved By">By: </b>king<br>
                <b data-toggle="tooltip" data-placement="left" title="Approved Amount">Amount: </b>2,000<br>
                <b data-toggle="tooltip" data-placement="left" title="Approved Installment Amount">Installment Amount: </b>2,000<br>
                <b data-toggle="tooltip" data-placement="left" title="Approved Total Installment">Total Installment: </b>1
            </td>
            <td>{ $employee->employee_mobile }}</td>
            <td>{ $employee->employee_mobile }}</td>
        </tr>
        endforeach
    </tbody>
</table>

