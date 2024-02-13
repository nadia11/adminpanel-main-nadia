<div class="modal fade" id="cheque_leaf_status_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Change Cheque Leaf Status</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            
            <form action="{{ route('change-cheque-leaf-status') }}" id="change_cheque_leaf_status" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
            @csrf

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-5">
                            <label for="cheque_leaf_status" class="control-label">{{ __('What is the reason?') }}</label>
                            <select name="cheque_leaf_status" id="cheque_leaf_status" class="custom-select" required>
                                <option value="Unused">{{ __('Release') }}</option>
                                <option value="Wasted">{{ __('Wasted') }}</option>
                                <option value="Error">{{ __('Error') }}</option>
                            </select>
                        </div><!--  -->
                        <div class="col-md-7">
                            <label class="control-label" for="leaf_reason">{{ __('Reason') }}<span class="require-field">*</span></label>
                            <input type="text" name="leaf_reason" id="leaf_reason" class="form-control" required>
                        </div>
                    </div>
                </div><!-- Modal Body -->
                
                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" name="cheque_leaf_id" />
                    <button type="button" class="btn btn-outline-dark mr-auto" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
                    <button type="submit" class="btn btn-dark"><i class="fa fa-check"></i> {{ __('Change Status') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
