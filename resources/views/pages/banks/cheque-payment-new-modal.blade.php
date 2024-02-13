<div class="modal fade" id="NewChequePaymentModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">New Cheque Payment</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form role="form" name="" action="{{ route('new-cheque-payment') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
            @csrf

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="payment_date" class="control-label">Payment Date:</label>
                                <div class="input-group required">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="datetime" name="payment_date" id="payment_date" class="form-control" placeholder="Payment Date" value="<?php echo date('d/m/Y'); ?>" tabindex="1" required />
                                </div>
                            </div>
                            <div class="col-4">
                                <label for="party_type" class="control-label">Party Type:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                                    </div>
                                    <select id="party_type" name="party_type" class="custom-select" tabindex="2" required>
                                        <option value="">-- Party Type --</option>
                                        <option value="vendor">Vendor</option>
                                        <!--<option value="supplier">Supplier</option>-->
                                        <option value="employee">Employee</option>
                                        <option value="customer">Customer</option>
                                        <option value="other_party">Other Party</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4 party-name">
                                <label for="party_id" class="control-label text-capitalize">Party Name</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                                    </div>
                                    <select id="party_id" name="party_id" class="custom-select" tabindex="3" required >
                                        <option value="">-- Party Name --</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr /><hr />

                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="bank_account_id" class="control-label">Credit Account Name:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                                    </div>
                                    <select id="bank_account_id" name="bank_account_id" class="custom-select" tabindex="4" required>
                                        <option value="">-- Credit Account Name --</option>
                                        <?php $bank_accounts = DB::table('bank_cheque_books')->join('bank_accounts', 'bank_cheque_books.bank_account_id', '=', 'bank_accounts.bank_account_id')->select('bank_accounts.account_name', 'bank_accounts.account_number', 'bank_accounts.bank_account_id')->distinct()->get(); ?>

                                        @foreach($bank_accounts as $bank_account )
                                        <option value="{{ $bank_account->bank_account_id }}">{{ $bank_account->account_name . " (" . $bank_account->account_number . ")" }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="account_number" class="control-label">Account Number: </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-tags" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" name="account_number" id="account_number" maxlength="13" class="form-control" placeholder="Account No" tabindex="5" readonly />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="bank_name" class="control-label">Bank Name:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-building" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" name="bank_name" id="bank_name" class="form-control" placeholder="Bank Name" tabindex="6" readonly />
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="branch" class="control-label">Branch: </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-code-branch" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" name="branch" id="branch" class="form-control" placeholder="Branch" tabindex="7" readonly />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="cheque_book_id" class="control-label">Cheque Book:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-book" aria-hidden="true"></i></span>
                                    </div>
                                    <select id="cheque_book_id" name="cheque_book_id" class="custom-select" tabindex="8" required >
                                        <option value="" selected="selected">{{ __('Cheque Book') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="cheque_number" class="control-label">Cheque Number: </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-leaf" aria-hidden="true"></i></span>
                                    </div>
                                    <select id="cheque_number" name="cheque_number" class="custom-select" tabindex="9" required>
                                        <option value="" selected="selected">{{ __('Cheque Number') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="cheque_type" class="control-label">Cheque Type: </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-tags" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" name="cheque_type" id="cheque_type" list="cheque_type_list" class="form-control" placeholder="Cheque Type" value="Cash Cheque" tabindex="10" required />
                                    <datalist id="cheque_type_list">
                                        <option value="Cash Cheque"><option value="Bearer Cheque"><option value="Order Cheque"><option value="Crossed Cheque">
                                    </datalist>
                                </div>
                            </div>
                            <div class="col-4">
                                <label for="cheque_date" class="control-label">Cheque Date:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="datetime" name="cheque_date" id="cheque_date" class="form-control" placeholder="Cheque Date" value="<?php echo date('d/m/Y'); ?>" tabindex="11" required />
                                </div>
                            </div>
                            <div class="col-4">
                                <label for="cheque_amount" class="control-label">Cheque Amount: </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-dollar-sign" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" name="cheque_amount" id="cheque_amount" class="form-control get_balance" placeholder="Cheque Amount" tabindex="12" data-url="{{ url('/bank/get_balance/') }}" autocomplete="off" required />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cheque_payment_desc" class="control-label">Description:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-tags" aria-hidden="true"></i></span>
                            </div>
                            <textarea name="cheque_payment_desc" id="cheque_payment_desc" cols="30" rows="3" class="form-control" placeholder="Description" tabindex="13"></textarea>
                        </div>
                    </div>
                </div><!-- Modal Body -->

                <!-- Modal footer -->
                <div class="modal-footer">
                <button type="button" class="btn btn-outline-dark mr-auto" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
                    <button type="submit" name="create_new_cheque_payment" id="create_new_cheque_payment" class="btn btn-dark float-right" tabindex="14"><i class="fa fa-plus" aria-hidden="true"></i> Create New Cheque Payment</button>
                </div><!-- Modal footer -->
            </form>
        </div>
    </div>
</div>
