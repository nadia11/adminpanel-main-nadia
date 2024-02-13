<div class="modal fade" id="newChequeBookModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">New Cheque Book</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form role="form" name="" action="{{ route('new-cheque-book-save') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
            @csrf
            
            <!-- Modal body -->
            <div class="modal-body">
                <div class="form-group">
                    <label for="cheque_book_no" class="control-label sr-only">Cheque Book No:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-book" aria-hidden="true"></i></span>
                        </div>
                        <input type="text" name="cheque_book_no" id="cheque_book_no" class="form-control" placeholder="Cheque Book No" tabindex="1" required />
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="account_name" class="control-label sr-only">Account Name:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                        </div>
                        <select id="bank_account_id" name="bank_account_id" required class="custom-select" tabindex="2">
                            <option value="">-- Account Name --</option>
                            <?php $bank_accounts = DB::table('bank_accounts')->select('account_name', 'account_number', 'bank_account_id')->get(); ?>

                            @foreach($bank_accounts as $bank_account )
                            <option value="{{ $bank_account->bank_account_id }}">{{ $bank_account->account_name . " (" . $bank_account->account_number . ")" }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="account_number" class="control-label sr-only">Account Number: </label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-tags" aria-hidden="true"></i></span>
                        </div>
                        <input type="text" name="account_number" id="account_number" maxlength="13" class="form-control" placeholder="Account No" tabindex="3" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="bank_name" class="control-label sr-only">Bank Name:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-building" aria-hidden="true"></i></span>
                        </div>
                        <input type="text" name="bank_name" id="bank_name" class="form-control" placeholder="Bank Name" tabindex="4" required />
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                            <label for="branch" class="control-label sr-only">Branch: </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                                </div>
                                <input type="text" name="branch" id="branch" class="form-control" placeholder="Branch" tabindex="5" required />
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="issue_date" class="control-label sr-only">Issue Date: </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                                </div>
                                <input type="datetime" name="issue_date" id="issue_date" class="form-control" placeholder="DD/MM/YYYY" value="<?php echo date('d/m/Y'); ?>" tabindex="5" required />
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                            <label for="leaf_prefix" class="control-label sr-only">Leaf Prefix: </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-code" aria-hidden="true"></i></span>
                                </div>
                                <input type="text" name="leaf_prefix" id="leaf_prefix" class="form-control" placeholder="Leaf Prefix" tabindex="6" />
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="number_of_leafs" class="control-label sr-only">Number of Leafs: </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-leaf" aria-hidden="true"></i></span>
                                </div>
                                <input type="text" name="number_of_leafs" id="number_of_leafs" class="form-control" placeholder="Number of Leafs" tabindex="7" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                            <label for="first_cheque_no" class="control-label sr-only">First Cheque No: </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-star" aria-hidden="true"></i></span>
                                </div>
                                <input type="text" name="first_cheque_no" id="first_cheque_no" class="form-control" placeholder="First Cheque No" tabindex="8" />
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="last_cheque_no" class="control-label sr-only">Last Cheque No: </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-sun" aria-hidden="true"></i></span>
                                </div>
                                <input type="text" name="last_cheque_no" id="last_cheque_no" class="form-control" placeholder="Last Cheque No" tabindex="9" />
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- Modal Body -->

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-dark mr-auto" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
                <button type="submit" name="create_cheque_book" id="create_cheque_book" class="btn btn-dark float-right" tabindex="10"><i class="fa fa-plus" aria-hidden="true"></i> Create New Cheque Book</button>
            </div><!-- Modal footer -->
            </form>
        </div>
    </div>
</div>