<div class="modal fade" id="driver_status_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Change Driver Status</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>

            <form action="{{ route('change-driver-status') }}" id="changeDriverStatus" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
            @csrf

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="driver_status" class="control-label">Driver Status</label>
                        <select name="driver_status" id="driver_status" class="custom-select" required>
                            <option value="">--Driver Status--</option>
                            <option value="on_trip">On Trip</option>
                            <option value="active">Active</option>
                            <option value="available">Available</option>
                            <option value="pending">Pending</option>
                            <option value="leave">Leave</option>
                            <option value="suspend">Suspend</option>
                            <option value="banned">Banned</option>
                        </select>
                    </div>
                </div><!-- Modal Body -->

                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" name="driver_id" />
                    <button type="submit" class="btn btn-dark"><i class="fa fa-check"></i> Change Status</button>
                </div>
            </form>
        </div>
    </div>
</div>
