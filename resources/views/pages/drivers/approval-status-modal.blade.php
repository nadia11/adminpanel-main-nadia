<div class="modal fade" id="approval_status_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Approval Status</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>

            <form action="{{ route('change-approval-status') }}" id="changeApprovalStatus" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
            @csrf

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="approval_status" class="control-label">Approval Status</label>
                        <select name="approval_status" id="approval_status" class="custom-select" required>
                            <option value="">--Approval Status--</option>
                            <option value="approved" style="display: none;">Approved</option>
                            <option value="suspend">Suspend</option>
                            <option value="banned">Banned</option>
                        </select>
                    </div>
                </div><!-- Modal Body -->

                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" name="driver_id" />
                    <input type="hidden" name="mobile" />
                    <button type="submit" class="btn btn-dark"><i class="fa fa-check"></i> Change Status</button>
                </div>
            </form>
        </div>
    </div>
</div>
