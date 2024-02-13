<div class="modal fade" id="newChequeReceivedModal">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 700px;">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">New Cheque Receive</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form role="form" name="" action="{{ route('new-received-cheque') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
            @csrf

            <!-- Modal body -->
            <div class="modal-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                            <label for="received_date" class="control-label">Receive Date: </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                </div>
                                <input type="datetime" name="received_date" id="received_date" class="form-control" placeholder="DD/MM/YYYY" tabindex="1" value="<?php echo date('d/m/Y'); ?>" required />
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="client_name" class="control-label">Client Name</label>
                            <div class="input-group" style="flex-wrap: nowrap;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-users" aria-hidden="true"></i></span>
                                </div>
                                <select id="client_id" name="client_id" class="custom-select select2" placeholder="Choose one thing" tabindex="2" style="width: 72%;">
                                    <option value="">Select Clients Name</option>
                                    <?php $clients = DB::table('clients')->pluck("client_name", "client_id"); ?>

                                    @foreach($clients as $id => $name )
                                    <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-dark" type="button" id="refreshClient" data-toggle="tooltip" data-placement="top" title="Click to reload Client"><i class="fa fa-sync-alt"></i></button>
                                    <a href="{{ URL::to('/client/client-management') }}" class="btn btn-info" target="_blank"  data-toggle="tooltip" data-placement="top" title="Create New Client"><i class="fa fa-plus fa-spin"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                            <label for="cheque_number" class="control-label">Cheque Number:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-leaf" aria-hidden="true"></i></span>
                                </div>
                                <input type="text" name="cheque_number" id="cheque_number" class="form-control" placeholder="Cheque No" tabindex="3" required />
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="cheque_date" class="control-label">Cheque Date: </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                </div>
                                <input type="datetime" name="cheque_date" id="cheque_date" class="form-control" placeholder="DD/MM/YYYY" value="<?php echo date('d/m/Y'); ?>" tabindex="4" required />
                            </div>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                            <label for="cheque_type" class="control-label">Cheque Type: </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-tags" aria-hidden="true"></i></span>
                                </div>
                                <input type="text" name="cheque_type" id="cheque_type" list="cheque_type_list" class="form-control" placeholder="Cheque Type" tabindex="5" required />
                                <datalist id="cheque_type_list">
                                    <option value="Cash Cheque"><option value="A/C Payee only"><option value="Bearer Cheque"><option value="Order Cheque"><option value="Crossed Cheque">
                                </datalist>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="client_bank" class="control-label">Client Bank:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-building" aria-hidden="true"></i></span>
                                </div>
                                <input type="text" name="client_bank" id="client_bank" list="bank_name_list" class="form-control" placeholder="Client Bank" autocomplete="off" tabindex="6" required />
                                <datalist id="bank_name_list">
                                    <?php $bank_name_lists = DB::table('bank_name_lists')->pluck("bank_name"); ?>
                                    @foreach($bank_name_lists as $bank_name )
                                    <option value="{{ $bank_name }}">
                                    @endforeach
                                </datalist>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                            <label for="bank_account_id" class="control-label">Credit Account Name:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                                </div>
                                <select id="bank_account_id" name="bank_account_id" class="custom-select" tabindex="7" required>
                                    <option value="">-- Credit Account Name --</option>
                                    <?php $bank_accounts = DB::table('bank_cheque_books')->join('bank_accounts', 'bank_cheque_books.bank_account_id', '=', 'bank_accounts.bank_account_id')->select('bank_accounts.account_name', 'bank_accounts.account_number', 'bank_accounts.bank_account_id')->distinct()->get(); ?>

                                    @foreach($bank_accounts as $bank_account )
                                    <option value="{{ $bank_account->bank_account_id }}">{{ $bank_account->account_name . " (" . $bank_account->account_number . ")" }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="account_number" class="control-label">Account No: </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-tags" aria-hidden="true"></i></span>
                                </div>
                                <input type="text" name="account_number" id="account_number" class="form-control" placeholder="Account Number" tabindex="8" readonly />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-4">
                            <label for="received_bank" class="control-label">Received Bank:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-building" aria-hidden="true"></i></span>
                                </div>
                                <input type="text" name="received_bank" id="received_bank" class="form-control" placeholder="Received Bank" tabindex="9" readonly />
                            </div>
                        </div>
                        <div class="col-4">
                            <label for="received_branch" class="control-label">Received Branch: </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-code-branch" aria-hidden="true"></i></span>
                                </div>
                                <input type="text" name="received_branch" id="received_branch" class="form-control" placeholder="Received Branch" tabindex="10" readonly />
                            </div>
                        </div>
                        <div class="col-4">
                            <label for="cheque_amount" class="control-label">Cheque Amount: </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-dollar-sign" aria-hidden="true"></i></span>
                                </div>
                                <input type="text" name="cheque_amount" id="cheque_amount" class="form-control" placeholder="Cheque Amount" tabindex="11" required />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-4">
                            <label for="money_receipt_no" class="control-label">Money Receipt No: </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-money-check" aria-hidden="true"></i></span>
                                </div>
                                <input type="text" name="money_receipt_no" id="money_receipt_no" class="form-control" placeholder="Money Receipt No" tabindex="12" />
                            </div>
                        </div>
                        <div class="col-8">
                            <label for="collection_person" class="control-label">Collection Person: </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                                </div>
                                <input type="text" name="collection_person" id="collection_person" class="form-control" list="employee_list" placeholder="Collection Person" tabindex="13" required />
                                <datalist id="employee_list">
                                    <?php $employees = DB::table('employees')->leftJoin('designations', 'employees.designation_id', '=', 'designations.designation_id')->select("designation_name", "employee_name")->get(); ?>
                                    @foreach($employees as $employee )
                                        <option value="{{ $employee->employee_name }} - {{ $employee->designation_name }}">
                                    @endforeach
                                </datalist>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-4">
                            <label for="bill_no" class="control-label">Bill No:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-leaf" aria-hidden="true"></i></span>
                                </div>
                                <select id="bill_no" name="bill_no" class="custom-select" tabindex="14" required>
                                    <option value="">-- Select Bill No --</option>
                                </select>
                                <input type="hidden" name="client_bill_id" id="client_bill_id">
                            </div>
                        </div>
                        <div class="col-4">
                            <label for="bill_date" class="control-label">Bill Date: </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                </div>
                                <input type="datetime" name="bill_date" id="bill_date" class="form-control" placeholder="DD/MM/YYYY" tabindex="15" readonly />
                            </div>
                        </div>
                        <div class="col-4">
                            <label for="bill_status" class="control-label">Bill Status</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-tags" aria-hidden="true"></i></span>
                                </div>
                                <select id="bill_status" name="bill_status" class="custom-select" required>
                                    <option value="">--Select Bill Status--</option>
                                    <option value="Full Bill Received">Full Bill Received</option>
                                    <option value="Partial Bill Received">Partial Bill Received</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-3">
                            <label for="po_number" class="control-label">PO Number: </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>
                                </div>
                                <input type="hidden" name="po_id" id="po_id" class="form-control" tabindex="15" readonly />
                                <input type="text" name="po_number" id="po_number" class="form-control" list="po_list" placeholder="PO Number" tabindex="16" readonly />
                            </div>
                        </div>
                        <div class="col-3">
                            <label for="po_date" class="control-label">PO Date: </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                </div>
                                <input type="datetime" name="po_date" id="po_date" class="form-control" placeholder="DD/MM/YYYY" tabindex="17" readonly />
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="project_name" class="control-label">Project Name: </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>
                                </div>
                                <input type="text" name="project_name" id="project_name" class="form-control" placeholder="Project Name" tabindex="18" readonly />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description" class="control-label">Description: </label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-square" aria-hidden="true"></i></span>
                        </div>
                        <textarea name="description" id="description" class="form-control" cols="30" rows="3" tabindex="19"></textarea>
                    </div>
                </div>
            </div><!-- Modal Body -->

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-dark mr-auto" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
                <button type="submit" name="create_cheque_receive" id="create_cheque_receive" class="btn btn-dark float-right" tabindex="20"><i class="fa fa-plus" aria-hidden="true"></i> Create New Cheque Receive</button>
            </div><!-- Modal footer -->
            </form>
        </div>
    </div>
</div>
