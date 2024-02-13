<!-- Change Password by Admin Modal -->
<div class="modal fade" id="changePasswordByadminModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Change Password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>

            <form action="#" id="changePasswordByadmin" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="password" class="control-label">New Password</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-lock" aria-hidden="true"></i></span>
                            </div>
                            <input type="password" name="password" id="password" placeholder="Enter New Password" class="form-control" autocomplete="off">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-danger show_password"><i class="fa fa-eye" title="Show Password" aria-hidden="true"></i> </button>
                                <button type="button" class="btn btn-info" id="gen_password_byadmin" data-toggle="tooltip" data-placement="bottom" title="Keep in Safe Place"><i class="fa fa-sync-alt fa-spin" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password" class="control-label">Confirm New Password</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            </div>
                            <input type="password" name="confirm_password" id="confirm_password" placeholder="Enter Confirm New Password" class="form-control">
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" name="user_id" value="">
                    <button type="button" class="btn btn-danger mr-auto" data-dismiss="modal"><i class="fa fa-times fa-lg" aria-hidden="true"></i> Cancel</button>
                    <button type="submit" class="btn btn-success" name="changePasswordByadminSave" id="changePasswordByadminSave"><i class="fa fa-plus" aria-hidden="true"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
