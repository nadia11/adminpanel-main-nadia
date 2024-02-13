<div class="modal fade" id="user_status_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Change User Status</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>

            <form action="{{ route('change-status') }}" id="change-status" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
            @csrf

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="user_status" class="control-label">User Status</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button type="button" class="btn btn-warning"><i class="fa fa-tags"></i></button>
                            </div>
                            <select name="user_status" id="user_status" class="custom-select">
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="denied">Denied</option>
                            </select>
                        </div>
                    </div>
                </div><!-- Modal Body -->

                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" name="user_id" />
                    <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
