<div class="modal fade" id="cashWithdrawModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Cash Withdraw</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form role="form" name="" action="{{ route('cash-withdraw-save') }}" method="POST" enctype="multipart/form-data" class="form-horizontal software-style-label">
            @csrf

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="bank_account_id" class="control-label">Credit Account Name:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                            </div>
                            <select id="bank_account_id" name="bank_account_id" class="custom-select" tabindex="5" required>
                                <option value="">-- Credit Account Name --</option>
                                <?php $bank_accounts = DB::table('bank_cheque_books')->join('bank_accounts', 'bank_cheque_books.bank_account_id', '=', 'bank_accounts.bank_account_id')->select('bank_accounts.account_name', 'bank_accounts.account_number', 'bank_accounts.bank_account_id')->distinct()->get(); ?>

                                @foreach($bank_accounts as $bank_account )
                                <option value="{{ $bank_account->bank_account_id }}">{{ $bank_account->account_name . " (" . $bank_account->account_number . ")" }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="account_number" class="control-label">Account Number: </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-tags" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="account_number" id="account_number" maxlength="13" class="form-control" placeholder="Account No" tabindex="6" required />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="bank_name" class="control-label">Bank Name:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-building" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="bank_name" id="bank_name" class="form-control" placeholder="Bank Name" tabindex="7" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="branch" class="control-label">Branch: </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-code-branch" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="branch" id="branch" class="form-control" placeholder="Branch" tabindex="8" required />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cheque_book_id" class="control-label">Cheque Book:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-book" aria-hidden="true"></i></span>
                            </div>
                            <select id="cheque_book_id" name="cheque_book_id" class="custom-select" tabindex="9" required >
                                <option value="" selected="selected">{{ __('Cheque Book') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cheque_number" class="control-label">Cheque Number: </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-leaf" aria-hidden="true"></i></span>
                            </div>
                            <select id="cheque_number" name="cheque_number" class="custom-select" tabindex="10" required>
                                <option value="" selected="selected">{{ __('Cheque Number') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="withdraw_date" class="control-label">Withdraw Date:</label>
                        <div class="input-group required">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                            </div>
                            <input type="datetime" name="withdraw_date" id="withdraw_date" class="form-control" placeholder="Withdraw Date" value="<?php echo date('d/m/Y'); ?>" tabindex="1" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cheque_amount" class="control-label">Cheque Amount: </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-dollar-sign" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="cheque_amount" id="cheque_amount" class="form-control get_balance" placeholder="Cheque Amount" data-url="{{ url('/bank/get_balance/') }}" autocomplete="off" tabindex="12" required />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="withdraw_desc" class="control-label">Description:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-tags" aria-hidden="true"></i></span>
                            </div>
                            <textarea name="withdraw_desc" id="withdraw_desc" cols="30" rows="1" class="form-control" placeholder="Description" tabindex="13"></textarea>
                        </div>
                    </div>
                </div><!-- Modal Body -->

                <!-- Modal footer -->
                <div class="modal-footer">
                <button type="button" class="btn btn-outline-dark mr-auto" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
                    <button type="submit" name="create_new_cash_withdraw" id="create_new_cash_withdraw" class="btn btn-dark float-right" tabindex="14"><i class="fa fa-plus" aria-hidden="true"></i> Create New Cheque Withdraw</button>
                </div><!-- Modal footer -->
            </form>
        </div>
    </div>
</div>
