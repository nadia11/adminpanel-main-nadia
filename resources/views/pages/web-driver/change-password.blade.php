<div class="profile-details">
    <p style="font-size: 30px; margin: 0 0 30px; font-weight: bold; color: #c0392b; border-bottom: 1px solid #ccc;">Change Password</p>

    <form action="{{ route('change-password-save') }}" id="changeMemberPassword" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
    @csrf
        <div class="form-group">
            <label for="old_password" class="control-label">Old Password</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fad fa-lock-open-alt" aria-hidden="true"></i></div>
                </div>
                <input type="password" name="old_password" id="old_password" placeholder="Enter Old Password" class="form-control" autocomplete="off" tabindex="1" required>
                <div class="input-group-prepend"><button type="button" class="btn btn-outline-danger show_password" tabindex="-1"><i class="fa fa-eye" title="Show Password" aria-hidden="true"></i> <span class="showtext"></span></button></div>
                <div class="input-group-prepend"><button type="button" class="btn btn-info gen_password_member" tabindex="-1"><i class="fa fa-sync-alt fa-spin" title="Password Generator" aria-hidden="true"></i></button></div>
            </div>
        </div>

        <div class="form-group">
            <label for="password" class="control-label">New Password</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-key"></i></div>
                </div>
                <input type="password" name="password" id="password" placeholder="Enter New Password" class="form-control" autocomplete="off" required>
            </div>
        </div>

        <div class="form-group">
            <label for="confirm_password" class="control-label">Confirm New Password</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-key"></i></span>
                </div>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Enter Confirm New Password" class="form-control" required>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" id="change_password" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> Change Password</button>
        </div>
    </form>
</div>

