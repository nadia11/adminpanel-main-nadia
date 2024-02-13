<div class="profile-details">
    <p style="font-size: 30px; margin: 0 0 30px; font-weight: bold; color: #c0392b; border-bottom: 1px solid #ccc;">Edit Profile</p>

    <form action="{{ route('edit-profile-save') }}" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
    @csrf
        <div class="form-group">
            <label for="rider_name" class="control-label sr-only">Name (Block Letters)</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-user"></i></div>
                </div>
                <input type="text" class="form-control text-uppercase" name="rider_name" id="rider_name" placeholder="Rider Name" required />
            </div>
        </div>
        <div class="form-group">
            <label for="mobile" class="control-label sr-only">Mobile No</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-phone"></i></div>
                </div>
                <input type="tel" class="form-control" id="mobile" name="mobile" placeholder="+8801XXX-XXXXXX" required />
            </div>
        </div>

        <div class="form-group">
            <label for="email" class="control-label sr-only">E-mail</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-envelope"></i></div>
                </div>
                <input type="email" class="form-control" name="email" id="email" placeholder="example@domain.com" required />
            </div>
        </div>
        <div class="form-group">
            <label for="password" class="control-label sr-only">Password</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-lock"></i></div>
                </div>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off" required />
                <div class="input-group-prepend"><button type="button" class="btn btn-outline-danger show_password" tabindex="-1"><i class="fa fa-eye" title="Show Password" aria-hidden="true"></i> <span class="showtext"></span></button></div>
            </div>
        </div>

        <div class="form-group">
            <label for="rider_photo" class="control-label sr-only">Photo Upload</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-upload" aria-hidden="true"></i></div>
                </div>
                <div class="custom-file">
                    <input type="file" name="user_photo" id="user_photo" style="display: none;" />
                    <input type="file" name="rider_photo" id="rider_photo" class="custom-file-input" accept=".png, .jpg, .jpeg" required>
                    <label class="custom-file-label" for="rider_photo">Choose Photo</label>
                </div>
            </div>
        </div>

        <div class="custom-control custom-switch mb-2 text-left">
            <input type="checkbox" class="custom-control-input" id="referral_switch" checked="on">
            <label class="custom-control-label" for="referral_switch" style="cursor:pointer;">If you have no Reference, Please deactivate this. </label>
        </div>
        <div class="form-group referral_item">
            <label for="referral_name" class="control-label sr-only">Referral Name</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-user"></i></div>
                </div>
                <input type="text" class="form-control" name="referral_name" id="referral_name" placeholder="Referral Name" />
            </div>
        </div>
        <div class="form-group referral_item">
            <label for="referral_mobile" class="control-label sr-only">Referral Phone</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-phone"></i></div>
                </div>
                <input type="text" class="form-control" name="referral_mobile" id="referral_mobile" placeholder="Referral Phone" />
            </div>
        </div>

        <button type="submit" class="btn btn-success text-right">Update Profile</button>
    </form>
</div>