<form action="{{ route('updateSettings') }}" role="form" name="" method="post" class="form-horizontal software-style-label" enctype="multipart/form-data">
    @csrf
    <?php $settings = DB::table('settings')->where('setting_id', 1)->first(); ?>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="company_name" class="control-label">Company Name</label>
            <input type="text" value="<?php echo $settings->company_name; ?>" name="company_name" class="form-control" id="company_name" placeholder="Company Name" required>
        </div>
        <div class="form-group col-md-6 text-right">
            <label for="logo" class="control-label">Company Logo</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-upload" aria-hidden="true"></i></div>
                </div>
                <div class="custom-file">
                    <label class="custom-file-label" for="upload-html-file">Upload Logo</label>
                    <input type="file" name="logo" id="logo" class="custom-file-input" accept=".png, .jpg, .jpeg" />
                </div>
            </div>
            <?php if ($settings->logo) { ?><img src="<?php echo image_url() .$settings->logo; ?>" alt="" class="img-fluid img-thumbnail" width="250px" /><?php } else { ?><img src="<?php echo image_url(); ?>/logo.png" alt="logo" class="img-fluid img-thumbnail" width="250px"><?php } ?>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="company_phone" class="control-label">Phone</label>
            <div class="input-group">
                <input type="text" value="<?php echo $settings->company_phone; ?>" name="company_phone" class="form-control" id="company_phone" placeholder="Company Phone">
                <div class="input-group-append">
                    <button type="button" class="btn verify-mobile waves-effect btn-warning">Verify</button>
                </div>
            </div>
        </div>
        <div class="form-group col-md-6">
            <label for="company_email" class="control-label">Email</label>
            <div class="input-group">
                <input type="email" value="<?php echo $settings->company_email; ?>" name="company_email" class="form-control" id="company_email" placeholder="Company Email" required>
                <div class="input-group-append">
                    <button type="button" class="btn verify-email waves-effect btn-warning">Verify</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="menu_position" class="control-label">Menu Position</label>
            <select class="custom-select" name="menu_position" id="menu_position">
                <option value="header_menu" <?php echo $settings->menu_position === 'header_menu' ? 'selected' : ''; ?>>Header Menu</option>
                <option value="sidebar_menu" <?php echo $settings->menu_position === 'sidebar_menu' ? 'selected' : ''; ?>>Sidebar Menu</option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="timezone" class="control-label">Time Zone</label>
            <select name="timezone" id="timezone" class="custom-select">
                <option value="0">Time Zone</option>
                <?php foreach($Timezones as $t) { ?>
                  <option value="<?php echo $t['zone']; ?>" <?php echo $t['zone'] === settings( 'timezone' ) ? 'selected="selected"' : ''; ?>><?php echo $t['diff_from_GMT'] . ' - ' . $t['zone']; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="form-group col-md-12">
        <h4>themes Pick</h4>
        <label class="themesPick col-md-3">
            <input type="radio" name="theme" value="Light" checked <?php echo $settings->theme === 'Light' ? 'checked' : ''; ?> />
            <img src="<?php echo base_url(); ?>/images/Light-theme.jpg" alt="Light-theme" style="width: 100px;">
        </label>
        <label class="themesPick col-md-3">
            <input type="radio" name="theme" value="Dark" <?php echo $settings->theme === 'Dark' ? 'checked' : ''; ?> />
            <img src="<?php echo base_url(); ?>/images/Dark-theme.jpg" alt="Dark-theme" style="width: 100px;">
        </label>
    </div>

    <div class="row col-md-12">
        <button type="submit" class="btn btn-success btn-lg" style="padding: 3px 40px;">Save Settings</button>
    </div>
</form>
