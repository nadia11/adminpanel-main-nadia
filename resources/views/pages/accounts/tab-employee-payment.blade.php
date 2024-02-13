<form action="{{ route('employee-payment-save') }}" name="employee_payment_form" id="employee_payment_form" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
@csrf

    <div class="form-group">
        <div class="row">
            <div class="col-2">
                <label for="entry_date" class="control-label">Entry Date</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt" aria-hidden="true"></i></span>
                    </div>
                    <input type="datetime" name="entry_date" id="entry_date" class="form-control" placeholder="DD/MM/YYYY" value="<?php echo date('d/m/Y'); ?>" tabindex="1" required />
                </div>
            </div>
            <div class="col-2">
                <label for="voucher_number" class="control-label">Voucher Number.</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-dot-circle" aria-hidden="true"></i></span>
                    </div>
                    <input type="text" name="voucher_number" id="voucher_number" value="<?php $max_id = DB::table('cashbook_entries')->max('cashbook_id'); $id = $max_id < 1 ? '01' : ($max_id <= 9 ? "0" . ($max_id + 1) : $max_id + 1); echo "VC-". $id .'/'. date('Y'); ?>" class="form-control" placeholder="Voucher No" tabindex="2" required />
                </div>
            </div>
            <div class="col-2">
                <label for="payment_method" class="control-label">Payment Method:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-university" aria-hidden="true"></i></span>
                    </div>
                    <select id="payment_method" name="payment_method" class="custom-select" tabindex="3">
                        <option value="cash">Cash</option>
                        <option value="bkash">bkash</option>
                        <option value="bank_deposit">Bank Deposit</option>
                        <option value="card_payment">Card Payment</option>
                        <option value="internet_banking">Internet banking</option>
                    </select>
                </div>
            </div>
            <div class="col-2">
                <label for="account_head_id" class="control-label">Head of Accounts:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-tags" aria-hidden="true"></i></span>
                    </div>
                    <select id="account_head_id" name="account_head_id" class="custom-select" tabindex="4" required>
                        <option value="">-- Account Head --</option>
                        <?php $account_heads = DB::table('account_heads')->where('account_head_type', '=', 'employee_expense_tab')->pluck('account_head_name', 'account_head_id'); ?>

                        @foreach($account_heads as $account_head_id => $account_head_name )
                        <option value="{{ $account_head_id }}">{{ $account_head_name }}</option>
                        @endforeach
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-info" type="button" id="showAccountsHead" data-toggle="modal" data-target="#accountsHeadModal"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <label for="month_name" class="control-label">Month Name</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button type="button" class="btn btn-warning"><i class="fa fa-calendar-alt"></i></button>
                    </div>
                    <select id="month_name" name="month_name" class="custom-select" tabindex="5">
                        <option value="">--Select Month Name--</option>
                        <?php foreach (range(1,'12') as $month){ echo '<option value="'.$month.'">'. date("F Y", mktime(0,0,0,$month,10)) .'</option>'; } ?>
                        <?php //foreach( array_reverse( range(12, date('F')) ) as $year){ echo '<option value="'.$year.'">'.$year.'</option>'; } ?>
                    </select>
                </div>
            </div>
            <div class="col-2">
                <label for="employee_id" class="control-label">Paid to: </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                    </div>
                    <select id="employee_id" name="employee_id" required class="custom-select" tabindex="6">
                        <option value="">-- Employee Name --</option>
                        <?php $employees = DB::table('employees')->join('designations', 'employees.designation_id', '=', 'designations.designation_id')->select("designations.designation_name", 'employees.employee_id', "employees.employee_name")->get(); ?>

                        @foreach($employees as $employee )
                        <option value="{{ $employee->employee_id }}">{{ $employee->employee_name }} - {{ $employee->designation_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-9">
                <label for="description" class="control-label">Description</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-bookmark" aria-hidden="true"></i></span>
                    </div>
                    <textarea class="form-control" name="description" id="description" placeholder="Description" rows="1" tabindex="7"></textarea>
                </div>
            </div>
            <div class="col-2">
                <label for="paid_amount" class="control-label">Paid Amount: </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-dollar-sign" aria-hidden="true"></i></span>
                    </div>
                    <input type="text" name="paid_amount" id="paid_amount" class="form-control" placeholder="Paid Amount" tabindex="8" required />
                </div>
            </div>
            <div class="col-1">
                <label for="save_daily_expense" class="control-label">.</label>
                <div class="input-group">
                    <button type="submit" name="save_daily_expense" id="save_daily_expense" class="btn btn-success btn-block" tabindex="9"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
