<form action="{{ route('daily-expense-save') }}" name="daily_expense_form" id="daily_expense_form" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
@csrf

    <div class="form-group">
        <div class="row">
            <div class="col-2">
                <label for="entry_date" class="control-label">Entry Date</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt" aria-hidden="true"></i></span>
                    </div>
                    <input type="datetime" name="entry_date" id="entry_date" class="form-control" placeholder="DD/MM/YYYY" value="<?php echo date('d/m/Y'); ?>" required />
                </div>
            </div>
            <div class="col-2">
                <label for="voucher_number" class="control-label">Voucher Number.</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-dot-circle" aria-hidden="true"></i></span>
                    </div>
                    <input type="text" name="voucher_number" id="voucher_number" value="<?php $max_id = DB::table('cashbook_entries')->max('cashbook_id'); $id = $max_id < 1 ? '01' : ($max_id <= 9 ? "0" . ($max_id + 1) : $max_id + 1); echo "VC-". $id .'/'. date('Y'); ?>" class="form-control" placeholder="Voucher No" required />
                </div>
            </div>
            <div class="col-2">
                <label for="payment_method" class="control-label">Payment Method:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-university" aria-hidden="true"></i></span>
                    </div>
                    <select id="payment_method" name="payment_method" class="custom-select">
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
                    <select id="account_head_id" name="account_head_id" class="custom-select" required>
                        <option value="">-- Account Head --</option>
                        <?php $account_heads = DB::table('account_heads')->where('account_head_type', 'daily_expense_tab')->pluck('account_head_name', 'account_head_id'); ?>

                        @foreach($account_heads as $account_head_id => $account_head_name )
                        <option value="{{ $account_head_id }}">{{ $account_head_name }}</option>
                        @endforeach
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-info" type="button" id="showAccountsHead" data-toggle="modal" data-target="#accountsHeadModal" tabindex="-1"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <label for="party_name" class="control-label">Paid to: </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                    </div>
                    <input type="text" name="party_name" id="party_name" list="employee_list" class="form-control" placeholder="Paid to" required />
                    <datalist id="employee_list">
                        <?php $employees = DB::table('employees')->pluck("employee_name"); ?>
                        @foreach($employees as $employee )
                        <option value="{{ $employee }}">
                        @endforeach
                    </datalist>
                </div>
            </div>
            <div class="col-2">
                <label for="expense_for" class="control-label">Expense for <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="Need this for Clientwise Loss/Profie Report"></i>: </label>
                <select id="expense_for" name="expense_for" class="custom-select" required>
                    <option value="0">Azad Art Hall</option>
                    <?php $clients = DB::table('clients')->pluck('client_name', 'client_id'); ?>

                    @foreach($clients as $client_id => $client_name )
                        <option value="{{ $client_id }}">{{ $client_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-8">
                <label for="description" class="control-label">Description</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-bookmark" aria-hidden="true"></i></span>
                    </div>
                    <textarea class="form-control" name="description" id="description" placeholder="Description" rows="1"></textarea>
                </div>
            </div>
            <div class="col-2">
                <label for="paid_amount" class="control-label">Paid Amount: </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-dollar-sign" aria-hidden="true"></i></span>
                    </div>
                    <input type="text" name="paid_amount" id="paid_amount" class="form-control" placeholder="Paid Amount" required />
                </div>
            </div>
            <div class="col-2">
                <label for="save_daily_expense" class="control-label">.</label>
                <div class="input-group" id="save_daily_expense_wrap">
                    <button type="submit" name="save_daily_expense" id="save_daily_expense" class="btn btn-success btn-block"><i class="fa fa-save"> Save</i></button>
                </div>
            </div>
        </div>
    </div>
</form>
