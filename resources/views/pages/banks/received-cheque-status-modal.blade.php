<div class="modal fade" id="received_cheque_status_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Change Status</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>

            <form action="{{ route('received-cheque-status') }}" id="received-cheque-status" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
            @csrf

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="received_cheque_status" class="control-label">{{ __('Cheque Status') }}</label>
                        <select name="received_cheque_status" id="received_cheque_status" class="custom-select" required>
                            <option value="on_hand">{{ __('On Hand') }}</option>
                            <option value="issued_to_bank">{{ __('Issued To Bank') }}</option>
                            <option value="dishonored">{{ __('Dishonored') }}</option>
                            <option value="cleared">{{ __('Cleared') }}</option>
                            <option value="returned_to_client">{{ __('Returned to Client') }}</option>
                        </select>
                    </div>
                </div><!-- Modal Body -->

                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" name="received_cheque_id" />
                    <button type="submit" class="btn btn-dark"><i class="fa fa-check"></i> {{ __('Change Status') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
