<div class="modal fade" id="newLoanModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Create New Loan</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form role="form" name="" action="{{ route('new-loan-save') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
            @csrf

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="employee_id" class="control-label">Employee Name</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-warning"><i class="fa fa-users"></i></button>
                                    </div>
                                    <select id="employee_id" name="employee_id" class="custom-select" tabindex="1" required>
                                        <option value="">--Select Employee--</option>
                                        <?php $employees = DB::table('employees')->join('designations', 'employees.designation_id', '=', 'designations.designation_id')->select("designations.designation_name", 'employees.employee_id', "employees.employee_name")->orderBy('employees.employee_name', 'ASC')->get(); ?>

                                        @foreach($employees as $employee )
                                            <option value="{{ $employee->employee_id }}">{{ $employee->employee_name }} - {{ $employee->designation_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <label for="designation_name" class="control-label">Designation</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-tags" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" name="designation_name" id="designation_name" class="form-control" placeholder="Designation" disabled />
                                </div>
                            </div>
                            <div class="col">
                                <label for="employee_mobile" class="control-label">Mobile</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-phone" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" name="employee_mobile" id="employee_mobile" class="form-control" placeholder="8801XXXXXXXXX" disabled />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="employee_gender" class="control-label">Gender</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-transgender" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" name="employee_gender" id="employee_gender" class="form-control" placeholder="Gender" disabled />
                                </div>
                            </div>
                            <div class="col">
                                <label for="cardID" class="control-label">Card ID:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-id-card" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" name="cardID" id="cardID" class="form-control" placeholder="Card ID" disabled />
                                </div>
                            </div>
                            <div class="col">
                                <label for="department_name" class="control-label">Department</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-id-card" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" name="department_name" id="department_name" class="form-control" placeholder="Department" disabled />
                                </div>
                            </div>
                            <div class="col">
                                <label for="joining_date" class="control-label">Joining Date:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="datetime" name="joining_date" id="joining_date" class="form-control" placeholder="YYYY/MM/DD" disabled />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="loan_type" class="control-label">Loan Type:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-info"><i class="fa fa-tags"></i></button>
                                    </div>
                                    <select id="loan_type" name="loan_type" class="custom-select" required>
                                        <option value="">--Loan Type--</option>
                                        <option value="salary_loan">Salary Loan</option>
                                        <option value="salary_advance">Salary Advance</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <label for="application_date" class="control-label">Application Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input type="datetime" name="application_date" id="application_date" placeholder="DD/MM/YYYY" class="form-control" autocomplete="off" value="<?php echo date('d/m/Y'); ?>" required />
                                </div>
                            </div>
                            <div class="col">
                                <label for="disburse_date" class="control-label">Disburse Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input type="datetime" name="disburse_date" id="disburse_date" placeholder="DD/MM/YYYY" class="form-control" autocomplete="off" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="loan_amount" class="control-label">Loan Amount</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-dollar-sign" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" name="loan_amount" id="loan_amount" class="form-control" placeholder="0.00" />
                                </div>
                            </div>
                            <div class="col">
                                <label for="no_of_installment" class="control-label">No of Installment</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-list-ol" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" name="no_of_installment" id="no_of_installment" class="form-control" placeholder="0.00" />
                                </div>
                            </div>
                            <div class="col">
                                <label for="installment_amount" class="control-label">Installment Amount</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-dollar-sign" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" name="installment_amount" id="installment_amount" class="form-control" placeholder="0.00" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="control-label">Description:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="description" id="description" class="form-control" placeholder="Description" />
                        </div>
                    </div>
                </div><!-- Modal Body -->

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark mr-auto" data-dismiss="modal" tabindex="-1">Close</button>
                    <button type="submit" name="create_loan" id="create_loan" class="btn btn-dark float-right" tabindex="9"><i class="fa fa-plus" aria-hidden="true"></i> Create New Loan</button>
                </div><!-- Modal footer -->
            </form>
        </div>
    </div>
</div>
