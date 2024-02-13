<div class="modal fade" id="editBankAccountModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Update Bank Account</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form role="form" name="" action="{{ route('edit-bank-account-save') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
            @csrf

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="account_name" class="control-label sr-only">Account Name:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" name="account_name" id="account_name" class="form-control" placeholder="Account Name" tabindex="1" required />
                              </div>
                            </div>
                            <div class="col">
                                <label for="account_number" class="control-label sr-only">Account Number</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-tags" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="number" name="account_number" id="account_number" maxlength="13" class="form-control" placeholder="Account No" tabindex="2" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="bank_name_id" class="control-label sr-only">Bank Name:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-university" aria-hidden="true"></i></span>
                                    </div>
                                    <select id="bank_name_id" name="bank_name_id" class="custom-select" tabindex="3">
                                        <option value="" selected="selected">{{ __('Bank Name') }}</option>
                                        <?php $bank_name_lists = DB::table('bank_name_lists')->pluck("bank_name", "bank_name_id"); ?>
                                        @foreach( $bank_name_lists as $key => $bank_name )
                                        <option value="{{ $key }}">{{ $bank_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <label for="branch" class="control-label sr-only">Branch</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" name="branch" id="branch" class="form-control" placeholder="Branch" tabindex="4" required />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="bank_address" class="control-label sr-only">Address</label>
                        <textarea id="bank_address" name="bank_address" class="form-control" placeholder="Bank Address" rows="1" tabindex="5"></textarea>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="account_type" class="control-label sr-only">Account Type</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-dot-circle" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" name="account_type" id="account_type" class="form-control" placeholder="Account Type" list="account_type_list" tabindex="6" required />
                                    <datalist id="account_type_list"><option value="Current Account"><option value="Savings Account"><option value="Salary Account"><option value="Student Account"><option value="Foreign Currency Account"><option value="FDR Account" title="Fixed Deposit Receipt"></option></datalist>
                                </div>
                            </div>
                            <div class="col">
                                <label for="swift_code" class="control-label sr-only">Swift Code</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-code" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" name="swift_code" id="swift_code" class="form-control" placeholder="Swift Code" tabindex="7" required />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="opening_date" class="control-label sr-only">Opening Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="datetime" list="opening_date" name="opening_date" id="opening_date" class="form-control" placeholder="DD/MM/YYYY" value="<?php echo date('d/m/Y'); ?>" tabindex="8" />
                                </div>
                            </div>
                            <div class="col">
                                <label for="percent" class="control-label sr-only">Percent %</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-square" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" name="percent" id="percent" maxlength="13" class="form-control" placeholder="Percent %" tabindex="14" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="website" class="control-label sr-only">Website</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-globe" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="url" name="website" id="website" class="form-control" placeholder="Website" tabindex="10" />
                                </div>
                            </div>
                            <div class="col">
                                <label for="email" class="control-label sr-only">E-mail</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="E-mail" tabindex="11" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="phone" class="control-label sr-only">Phone</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-phone" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone" tabindex="12" required />
                                </div>
                            </div>
                            <div class="col">
                                <label for="alt_phone" class="control-label sr-only">Alt Phone</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-phone" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" name="alt_phone" id="alt_phone" class="form-control" placeholder="Alt Phone" tabindex="13" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bank_note" class="control-label sr-only">Note</label>
                        <textarea id="bank_note" name="bank_note" class="form-control" placeholder="Note" rows="1" tabindex="15"></textarea>
                    </div>
                </div><!-- Modal Body -->

                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" name="bank_account_id" value="" />
                    <button type="button" class="btn btn-outline-dark mr-auto" data-dismiss="modal">Close</button>
                    <button type="submit" name="update_bank" id="update_bank" class="btn btn-dark float-right" tabindex="13"><i class="fa fa-plus" aria-hidden="true"></i> Update Bank</button>
                </div><!-- Modal footer -->
            </form>
        </div>
    </div>
</div>
