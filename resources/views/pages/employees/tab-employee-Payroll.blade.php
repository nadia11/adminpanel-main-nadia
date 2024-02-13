<div class="row">
    <div class="col-3">
        <h2>Payroll Items</h2>
        <div style="background: rgba(164,224,245,0.22); padding: 10px;">
            <table class="w-100">
                <thead style="border-bottom: 1px solid #333; color: darkcyan;">
                    <tr>
                        <th>Item</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Basic Salary</td><td class="text-right">18,166.67</td></tr>
                    <tr><td>House Rent 75%</td><td class="text-right">9,083.33</td></tr>
                    <tr><td>Medical Allowance 15%</td><td class="text-right">750.00</td></tr>
                    <tr style="border-top: 1px solid #333; font-weight: bold;">
                        <td>Gross Salary</td>
                        <td class="text-right">31,000.00</td>
                    </tr>
                    <tr><td>Absent Deduction</td><td class="text-right">0.00</td></tr>
                    <tr><td>Motor Cycle Loan</td><td class="text-right">0.00</td></tr>
                    <tr><td>Loan deduction</td><td class="text-right">0.00</td></tr>
                    <tr><td>Salary Refund</td><td class="text-right">0.00</td></tr>
                    <tr  style="border-top: 1px solid #333; font-weight: bold;">
                        <td>Total Deduction</td>
                        <td class="text-right">(-)0.00</td>
                    </tr>
                    <tr><td>Conveyance/Transport</td><td class="text-right">1,000.00</td></tr>
                    <tr><td>Mobile Bill</td><td class="text-right">1,000.00</td></tr>
                    <tr><td>TADA</td><td class="text-right">0.00</td></tr>
                    <tr><td>Medical</td><td class="text-right">0.00</td></tr>
                    <tr><td>Food</td><td class="text-right">0.00</td></tr>
                    <tr><td>Overtime</td><td class="text-right">0.00</td></tr>
                    <tr><td>Others</td><td class="text-right">0.00</td></tr>
                    <tr><td>Attendance Bonus</td><td class="text-right">0.00</td></tr>
                    <tr><td>Festival Bonus</td><td class="text-right">0.00</td></tr>
                    <tr style="border-top: 1px solid #333; font-weight: bold;">
                        <td>Total Addition</td>
                        <td class="text-right">(+) 0.00</td>
                    </tr>
                    <tr class="bp">
                        <td style="border-top: 1px solid #333; font-weight: bold;">Tax Deduction</td>
                        <td style="border-top: 1px solid #333;" class="text-right">(-) 0.00</td>
                    </tr>
                    <tr  style="border-top: 1px solid #333; font-weight: bold;">
                        <td>Salary Payable</td>
                        <td class="text-right">31,000.00</td>
                    </tr>
                    <tr style="border-top: 1px solid #333; font-weight: bold;">
                        <td>Net Amount</td>
                        <td class="text-right">31,000.00</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div><!-- col-6 -->
<!--    <div class="col-8">
        <h2>Pay Scale history</h2>
        <div class="table-responsive" style="min-height: 250px; border: 1px solid #ddd;">
            <table class="table table-striped table-custom">
                <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        <th>Payscale</th>
                        <th>Grade</th>
                        <th>Period</th>
                        <th>Amount</th>
                        <th>Appraisal Date</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>-->
    <div class="col-9">
        <div class="d-flex flex-row justify-content-between">
            <h2>Salary Received history</h2>
            <a href="{{ URL::to('/payroll/employee-ledger') }}" class="btn btn-warning btn-sm d-table" data-toggle="tooltip" data-placement="top" title="View More Detail about Salary"><i class="fa fa-reply"></i> View Details</a>
        </div>
        <div class="table-responsive" style="min-height: 250px; border: 1px solid #ddd;">
            <table class="table table-input-form" style="font-size: 12px;">
                <thead>
                    <tr>
                        <th>Year</th>
                        <th>Month Name</th>
                        <th>Basic Salary</th>
                        <th>House Rent</th>
                        <th>Medical Allowance</th>
                        <th>Gross Salary</th>
                        <th>Conveyance</th>
                        <th>Mobile Bill</th>
                        <th>Overtime</th>
                        <th>Food</th>
                        <th>Medical Benefit</th>
                        <th>Festival Bonus</th>
                        <th>Total Deduction</th>
                        <th>Total Taka</th>
                    </tr>
                </thead>
                <tbody>
                <!--foreach($salary_sheet_info as $salary)
                    <tr>
                        <td>{ $salary->basic_salary }}</td>
                        <td>{ $salary->house_rent }}</td>
                        <td>{ $salary->medical_allowance }}</td>
                        <td>{ $salary->basic_salary }}</td>
                        <td>{ $salary->basic_salary }}</td>
                        <td>{ $salary->basic_salary }}</td>
                        <td>{ $salary->basic_salary }}</td>
                        <td>{ $salary->basic_salary }}</td>
                        <td>{ $salary->basic_salary }}</td>
                        <td>{ $salary->basic_salary }}</td>
                    </tr>
                    endforeach-->
                </tbody>
                <tfoot class="total_row">
                    <tr>
                        <th colspan="2">Total</th>
                        <th><?php //echo taka_format('', DB::table('bank_cheque_leafs')->where('cheque_book_id', $cheque_book_id)->sum('cheque_leaf_amount') ); ?></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
