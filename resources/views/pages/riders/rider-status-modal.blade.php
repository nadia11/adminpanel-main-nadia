<div class="modal fade" id="rider_status_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Change Rider Status</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>

            <form action="{{ route('change-rider-status') }}" id="change-rider-status" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
            @csrf

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="rider_status" class="control-label">{{ __('Rider Status') }}</label>
                        <select name="rider_status" id="rider_status" class="custom-select" required>
                            <option value="">--Rider Status--</option>
                            <option value="pending">Pending</option>
                            <option value="active">Active</option>
                            <option value="on_trip">On Trip</option>
                            <option value="suspend">Suspend</option>
                            <option value="banned">Banned</option>
                        </select>
                    </div>
                </div><!-- Modal Body -->

                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" name="rider_id" />
                    <button type="submit" class="btn btn-dark"><i class="fa fa-check"></i> {{ __('Change Status') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
