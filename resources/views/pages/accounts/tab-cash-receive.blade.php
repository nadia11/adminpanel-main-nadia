<form action="{{ route('cash-receive-save') }}" name="cash_receive_form" id="cash_receive_form" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
@csrf

    <div class="form-group">
        <div class="row">
            <div class="col-2">
                <label for="cash_receive_date" class="control-label">Receive Date</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt" aria-hidden="true"></i></span>
                    </div>
                    <input type="datetime" name="cash_receive_date" id="cash_receive_date" class="form-control" placeholder="DD/MM/YYYY" value="<?php echo date('d/m/Y'); ?>" required />
                </div>
            </div>
            <div class="col-2">
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
            <div class="col-2 party_name animated fadeInLeft" style="display: none;">
                <label for="party_name" class="control-label">Cash Receive From:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                    </div>
                    <input type="text" name="party_name" id="party_name" list="client_list" class="form-control" placeholder="Cash Receive From" autocomplete="off" />
                    <datalist id="client_list"></datalist>
                </div>
            </div>

            <div class="col-2 account-info animated fadeInLeft" style="display: none;">
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
            <div class="col-2 account-info animated fadeInLeft" style="display: none;">
                <label for="account_number" class="control-label">Account Number: </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-tags" aria-hidden="true"></i></span>
                    </div>
                    <input type="text" name="account_number" id="account_number" maxlength="13" class="form-control" placeholder="Account No" />
                </div>
            </div>

            <div class="col-2 account-info animated fadeInLeft" style="display: none;">
                <label for="bank_name" class="control-label">Bank Name:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-building" aria-hidden="true"></i></span>
                    </div>
                    <input type="text" name="bank_name" id="bank_name" class="form-control" placeholder="Bank Name" />
                </div>
            </div>
            <div class="col-2 account-info animated fadeInLeft" style="display: none;">
                <label for="branch" class="control-label">Branch: </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-code-branch" aria-hidden="true"></i></span>
                    </div>
                    <input type="text" name="branch" id="branch" class="form-control" placeholder="Branch" />
                </div>
            </div>

            <div class="col-2 account-info animated fadeInLeft" style="display: none;">
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
            <div class="col-2 account-info animated fadeInLeft" style="display: none;">
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

            <div class="col-2">
                <label for="cash_receive_amount" class="control-label">Amount: </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-dollar-sign" aria-hidden="true"></i></span>
                    </div>
                    <input type="text" name="cash_receive_amount" id="cash_receive_amount" class="form-control" placeholder="Amount" required />
                </div>
            </div>
            <div class="col-4" id="description_cash_receive_wrap">
                <label for="description" class="control-label">Description</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-bookmark" aria-hidden="true"></i></span>
                    </div>
                    <textarea class="form-control" name="description" id="description" placeholder="Description" rows="1"></textarea>
                </div>
            </div>
            <div class="col-2" id="save_cash_receive_wrap">
                <label for="save_cash_receive" class="control-label">.</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                    </div>
                    <button type="submit" name="save_cash_receive" id="save_cash_receive" class="btn btn-success btn-block"><i class="fa fa-save"> Save</i></button>
                </div>
            </div>
        </div>
    </div>
</form>
