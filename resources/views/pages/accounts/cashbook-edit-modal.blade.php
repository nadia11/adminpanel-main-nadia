<div class="modal fade" id="editCashbookModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form action="{{ route('update-daily-expense') }}" name="update_daily_expense_form" id="update_daily_expense_form" method="post" enctype="multipart/form-data" class="form-horizontal software-style-label" role="form" style="display: none;">
                @csrf
                    <div class="form-group">
                        <label for="entry_date" class="control-label">Entry Date</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-calendar-alt" aria-hidden="true"></i></span>
                            </div>
                            <input type="datetime" name="entry_date" id="entry_date" class="form-control" placeholder="DD/MM/YYYY" value="<?php echo date('d/m/Y'); ?>" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="voucher_number" class="control-label">Voucher Number.</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-dot-circle" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="voucher_number" id="voucher_number" value="<?php $max_id = DB::table('cashbook_entries')->max('cashbook_id'); $id = $max_id == 0 ? 1 : $max_id + 1; echo "VC-". $id .'/'. date('Y'); ?>" class="form-control" placeholder="Voucher No" required />
                        </div>
                    </div>
                    <div class="form-group">
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
                    <div class="form-group">
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
                    <div class="form-group">
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
                    <div class="form-group">
                        <label for="paid_amount" class="control-label">Paid Amount: </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-dollar-sign" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="paid_amount" id="paid_amount" class="form-control" placeholder="Paid Amount" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="control-label">Description</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-bookmark" aria-hidden="true"></i></span>
                            </div>
                            <textarea class="form-control" name="description" id="description" placeholder="Description" rows="1" tabindex="7"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="update_daily_expense" class="control-label">.</label>
                        <div class="input-group">
                            <button type="submit" name="update_daily_expense" id="update_daily_expense" class="btn btn-warning btn-block" tabindex="8"><i class="fa fa-save"> Update</i></button>
                            <input type="hidden" name="cashbook_id" value="">
                            <input type="hidden" name="row_index" value="">
                        </div>
                    </div>
                </form>



                <form action="{{ route('update-employee-payment') }}" name="update_employee_payment_form" id="update_employee_payment_form" method="post" enctype="multipart/form-data" class="form-horizontal software-style-label" role="form" style="display: none;">
                    @csrf
                    <div class="form-group">
                        <label for="entry_date" class="control-label">Entry Date</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-calendar-alt" aria-hidden="true"></i></span>
                            </div>
                            <input type="datetime" name="entry_date" id="entry_date" class="form-control" placeholder="DD/MM/YYYY" value="<?php echo date('d/m/Y'); ?>" tabindex="1" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="voucher_number" class="control-label">Voucher Number.</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-dot-circle" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="voucher_number" id="voucher_number" value="<?php $max_id = DB::table('cashbook_entries')->max('cashbook_id'); $id = $max_id == 0 ? 1 : $max_id + 1; echo "VC-". $id .'/'. date('Y'); ?>" class="form-control" placeholder="Voucher No" tabindex="2" required />
                        </div>
                    </div>
                    <div class="form-group">
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
                    <div class="form-group">
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
                    <div class="form-group">
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
                    <div class="form-group">
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
                    <div class="form-group">
                        <label for="description" class="control-label">Description</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-bookmark" aria-hidden="true"></i></span>
                            </div>
                            <textarea class="form-control" name="description" id="description" placeholder="Description" rows="1" tabindex="7"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="paid_amount" class="control-label">Paid Amount: </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-dollar-sign" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="paid_amount" id="paid_amount" class="form-control" placeholder="Paid Amount" tabindex="8" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="update_daily_expense" class="control-label">.</label>
                        <div class="input-group">
                            <button type="submit" name="update_daily_expense" id="update_daily_expense" class="btn btn-success btn-block" tabindex="9"><i class="fa fa-save"></i> Update</button>
                            <input type="hidden" name="cashbook_id" value="">
                            <input type="hidden" name="row_index" value="">
                        </div>
                    </div>
                </form>



                <form action="{{ route('update-vendor-payment') }}" name="update_vendor_payment_form" id="update_vendor_payment_form" method="post" enctype="multipart/form-data" class="form-horizontal software-style-label" role="form" style="display: none;">
                @csrf
                    <div class="form-group">
                        <label for="entry_date" class="control-label">Entry Date</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-calendar-alt" aria-hidden="true"></i></span>
                            </div>
                            <input type="datetime" name="entry_date" id="entry_date" class="form-control" placeholder="DD/MM/YYYY" value="<?php echo date('d/m/Y'); ?>" tabindex="1" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="voucher_number" class="control-label">Voucher Number.</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-dot-circle" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="voucher_number" id="voucher_number" value="<?php $max_id = DB::table('cashbook_entries')->max('cashbook_id'); $id = $max_id == 0 ? 1 : $max_id + 1; echo "VC-". $id .'/'. date('Y'); ?>" class="form-control" placeholder="Voucher No" tabindex="2" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="payment_method" class="control-label">Pay. Method:</label>
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
                    <div class="form-group">
                        <label for="account_head_id" class="control-label">Head of Accounts:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-tags" aria-hidden="true"></i></span>
                            </div>
                            <select id="account_head_id" name="account_head_id" class="custom-select" tabindex="4" required>
                                <option value="">-- Account Head --</option>
                                <?php $account_heads = DB::table('account_heads')->where('account_head_type', '=', 'vendor_expense_tab')->pluck('account_head_name', 'account_head_id'); ?>

                                @foreach($account_heads as $account_head_id => $account_head_name )
                                <option value="{{ $account_head_id }}">{{ $account_head_name }}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-info" type="button" id="showAccountsHead" data-toggle="modal" data-target="#accountsHeadModal"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="vendor_id" class="control-label">Paid to: </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                            </div>
                            <select id="vendor_id" name="vendor_id" class="custom-select" tabindex="5" required>
                                <option value="">-- Vendor Name --</option>
                                <?php $vendors = DB::table('vendors')->select('vendor_id', "vendor_name", "company_name")->get(); ?>

                                @foreach($vendors as $vendor )
                                <option value="{{ $vendor->vendor_id }}">{{ $vendor->vendor_name }} - {{ $vendor->company_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bill_no" class="control-label">Bill No</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-money-check-edit-alt" aria-hidden="true"></i></span>
                            </div>
                            <select id="bill_no" name="bill_no" class="custom-select" tabindex="7">
                                <option value="">-- Bill No --</option>
                                <?php $purchase_orders = DB::table('purchase_orders')->join('clients', 'purchase_orders.client_id', '=', 'clients.client_id')->select('purchase_orders.po_id', 'purchase_orders.po_number', 'purchase_orders.project_name', 'clients.client_name')->where('po_status', 'open')->get(); ?>

                                @foreach($purchase_orders as $purchase_order )
                                <option value="{{ $purchase_order->po_id }}">{{ $purchase_order->po_number ." - ". $purchase_order->client_name ." - ". $purchase_order->project_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bill_date" class="control-label">Bill Date</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-calendar-alt" aria-hidden="true"></i></span>
                            </div>
                            <input type="datetime" name="bill_date" id="bill_date" class="form-control" placeholder="DD/MM/YYYY" value="<?php echo date('d/m/Y'); ?>" tabindex="1" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="po_id" class="control-label">PO:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-star" aria-hidden="true"></i></span>
                            </div>
                            <select id="po_id" name="po_id" class="custom-select" tabindex="7" required>
                                <option value="">-- PO No --</option>
                                <?php $purchase_orders = DB::table('purchase_orders')->join('clients', 'purchase_orders.client_id', '=', 'clients.client_id')->select('purchase_orders.po_id', 'purchase_orders.po_number', 'purchase_orders.project_name', 'clients.client_name')->where('po_status', 'open')->get(); ?>

                                @foreach($purchase_orders as $purchase_order )
                                <option value="{{ $purchase_order->po_id }}">{{ $purchase_order->po_number ." - ". $purchase_order->client_name ." - ". $purchase_order->project_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="project_name" class="control-label">Project Name: </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-tags" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="project_name" id="project_name" class="form-control" placeholder="Project Name" tabindex="8" readonly />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="client_name" class="control-label">Client Name: </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-user-tie" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="client_name" id="client_name" class="form-control" placeholder="Client Name" tabindex="9" readonly />
                            <input type="hidden" name="client_id" id="client_id" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="paid_amount" class="control-label">Paid Amount: </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-dollar-sign" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="paid_amount" id="paid_amount" class="form-control" placeholder="Paid Amount" tabindex="6" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="control-label">Description</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-bookmark" aria-hidden="true"></i></span>
                            </div>
                            <textarea class="form-control" name="description" id="description" placeholder="Description" rows="1" tabindex="10"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="update_vendor_payment" class="control-label">.</label>
                        <div class="input-group">
                            <button type="submit" name="update_vendor_payment" id="update_vendor_payment" class="btn btn-success btn-block" tabindex="11"><i class="fa fa-save"></i> Update</button>
                            <input type="hidden" name="cashbook_id" value="">
                            <input type="hidden" name="row_index" value="">
                        </div>
                    </div>
                </form>


                <!-- Update Cash Received -->
                <form action="{{ route('update-cash-receive') }}" name="update_cash_receive_form" id="update_cash_receive_form" method="post" enctype="multipart/form-data" class="form-horizontal software-style-label" role="form" style="display: none;">
                    @csrf

                    <div class="form-group">
                        <label for="cash_receive_date" class="control-label">Receive Date</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-calendar-alt" aria-hidden="true"></i></span>
                            </div>
                            <input type="datetime" name="cash_receive_date" id="cash_receive_date" class="form-control" placeholder="DD/MM/YYYY" value="<?php echo date('d/m/Y'); ?>" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="account_head_id" class="control-label">Head of Accounts</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-tags" aria-hidden="true"></i></span>
                            </div>
                            <!-- Cash Withdraw/Cash Bill -->
                            <select id="account_head_id" name="account_head_id" class="custom-select" required>
                                <option value="">-- Account Head --</option>
                                <?php $account_heads = DB::table('account_heads')->where('account_head_type', 'cash_receive_tab')->pluck('account_head_name', 'account_head_id'); ?>

                                @foreach($account_heads as $account_head_id => $account_head_name )
                                    <option value="{{ $account_head_id }}">{{ $account_head_name }}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-info" type="button" id="showAccountsHead" data-toggle="modal" data-target="#accountsHeadModal" tabindex="-1"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group party_name animated fadeInLeft" style="display: none;">
                        <label for="party_name" class="control-label">Cash Receive From:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="party_name" id="party_name" list="client_list" class="form-control" placeholder="Cash Receive From" autocomplete="off" />
                            <datalist id="client_list"></datalist>
                        </div>
                    </div>

                    <div class="form-group account-info animated fadeInLeft" style="display: none;">
                        <label for="bank_account_id" class="control-label">Credit Account Name:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                            </div>
                            <select id="bank_account_id" name="bank_account_id" class="custom-select" required>
                                <option value="">-- Credit Account Name --</option>
                                <?php $bank_accounts = DB::table('bank_cheque_books')->join('bank_accounts', 'bank_cheque_books.bank_account_id', '=', 'bank_accounts.bank_account_id')->select('bank_accounts.account_name', 'bank_accounts.account_number', 'bank_accounts.bank_account_id')->distinct()->get(); ?>

                                @foreach($bank_accounts as $bank_account )
                                    <option value="{{ $bank_account->bank_account_id }}">{{ $bank_account->account_name . " (" . $bank_account->account_number . ")" }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group account-info animated fadeInLeft" style="display: none;">
                        <label for="account_number" class="control-label">Account Number: </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-tags" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="account_number" id="account_number" maxlength="13" class="form-control" placeholder="Account No" />
                        </div>
                    </div>

                    <div class="form-group account-info animated fadeInLeft" style="display: none;">
                        <label for="bank_name" class="control-label">Bank Name:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-building" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="bank_name" id="bank_name" class="form-control" placeholder="Bank Name" />
                        </div>
                    </div>
                    <div class="form-group account-info animated fadeInLeft" style="display: none;">
                        <label for="branch" class="control-label">Branch: </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-code-branch" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="branch" id="branch" class="form-control" placeholder="Branch" />
                        </div>
                    </div>

                    <div class="form-group account-info animated fadeInLeft" style="display: none;">
                        <label for="cheque_book_id" class="control-label">Cheque Book:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-book" aria-hidden="true"></i></span>
                            </div>
                            <select id="cheque_book_id" name="cheque_book_id" class="custom-select">
                                <option value="" selected="selected">{{ __('Cheque Book') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group account-info animated fadeInLeft" style="display: none;">
                        <label for="cheque_number" class="control-label">Cheque Number: </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-leaf" aria-hidden="true"></i></span>
                            </div>
                            <select id="cheque_number" name="cheque_number" class="custom-select">
                                <option value="" selected="selected">{{ __('Cheque Number') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cash_receive_amount" class="control-label">Amount: </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-dollar-sign" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="cash_receive_amount" id="cash_receive_amount" class="form-control" placeholder="Amount" required />
                        </div>
                    </div>
                    <div class="form-group" id="description_cash_receive_wrap">
                        <label for="description" class="control-label">Description</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-bookmark" aria-hidden="true"></i></span>
                            </div>
                            <textarea class="form-control" name="description" id="description" placeholder="Description" rows="1"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="update_cash_receive" class="control-label">.</label>
                        <div class="input-group">
                            <button type="submit" name="update_cash_receive" id="update_cash_receive" class="btn btn-success btn-block" tabindex="6"><i class="fa fa-save"> Update</i></button>
                            <input type="hidden" name="cashbook_id" value="">
                            <input type="hidden" name="row_index" value="">
                        </div>
                    </div>
                </form>
            </div><!-- Modal Body -->
        </div>
    </div>
</div>
