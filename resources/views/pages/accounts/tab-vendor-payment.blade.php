<form action="{{ route('vendor-payment-save') }}" name="vendor_payment_form" id="vendor_payment_form" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
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
            <div class="col-1">
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
            <div class="col-2">
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
            <div class="col-2">
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
            <div class="col-1">
                <label for="bill_no" class="control-label">Bill No</label>
                <select id="bill_no" name="bill_no" class="custom-select" tabindex="6">
                    <option value="">-- Bill No --</option>
                </select>
            </div>
            <div class="col-2">
                <label for="bill_date" class="control-label">Bill Date</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt" aria-hidden="true"></i></span>
                    </div>
                    <input type="datetime" name="bill_date" id="bill_date" class="form-control" placeholder="DD/MM/YYYY" readonly tabindex="7" />
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-2">
                <label for="po_id" class="control-label">PO:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-star" aria-hidden="true"></i></span>
                    </div>
                    <select id="po_id" name="po_id" class="custom-select" tabindex="8" required>
                        <option value="">-- PO No --</option>
                    </select>
                </div>
            </div>
            <div class="col-2">
                <label for="project_name" class="control-label">Project Name: </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-tags" aria-hidden="true"></i></span>
                    </div>
                    <input type="text" name="project_name" id="project_name" class="form-control" placeholder="Project Name" tabindex="98" readonly />
                </div>
            </div>
            <div class="col-2">
                <label for="client_name" class="control-label">Client Name: </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-user-tie" aria-hidden="true"></i></span>
                    </div>
                    <input type="text" name="client_name" id="client_name" class="form-control" placeholder="Client Name" tabindex="10" readonly />
                    <input type="hidden" name="client_id" id="client_id" />
                </div>
            </div>
            <div class="col-3">
                <label for="description" class="control-label">Description</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-bookmark" aria-hidden="true"></i></span>
                    </div>
                    <textarea class="form-control" name="description" id="description" placeholder="Description" rows="1" tabindex="11"></textarea>
                </div>
            </div>
            <div class="col-2">
                <label for="paid_amount" class="control-label">Paid Amount: </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-dollar-sign" aria-hidden="true"></i></span>
                    </div>
                    <input type="text" name="paid_amount" id="paid_amount" class="form-control" placeholder="Paid Amount" tabindex="12" required />
                </div>
                <p class="text-right vendor-balance">Balance: 0.00</p>
            </div>
            <div class="col-1">
                <label for="save_vendor_payment" class="control-label">.</label>
                <div class="input-group">
                    <button type="submit" name="save_vendor_payment" id="save_vendor_payment" class="btn btn-success btn-block" tabindex="13"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
