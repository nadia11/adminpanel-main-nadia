<!-- Modal -->
<div class="modal fade" id="gen_password_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Secure Password Generator</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="form-group">
                    <?php $initial_password = isset( $_POST['password'] ) ? stripslashes( $_POST['password'] ) : $password = generate_password(18); ?>                                
                    <input id="gen_pwd_container" class="form-control" value="<?php echo $initial_password; ?>" readonly>
                </div>

                <div class="form-group">
                    <button type="button" name="gen_new_pwd" id="gen_new_pwd" class="btn btn-info"><i class="fa fa-sync-alt fa-spin"></i> Generate New Password</button>
                    <button type="button" name="select_n_copy" id="select_n_copy" class="btn btn-warning" style="position: relative;"><i class="fa fa-copy"></i> Select & Copy</button>
                    <span class="coppied_msg" style=" display: none; color: red; background: yellow; padding: 5px; border: 1px solid red; box-shadow: 0 0 3px 3px rgba(0,0,0,.5); position: absolute; right: 5px; top:10%; border-radius: 5px; z-index: 99;"></span>
                </div>

                <div class="form-group">
                    <label for="pwd_length" class="control-label">Password Length:</label>
                    <input type="number" class="form-control" value="12" id="pwd_length" name="pwd_length" min="8" max="32" />
                </div>

                <div class="form-group">
                    <div class="checkbox">
                        <label><input type="checkbox" id="alpha_lower" checked="checked" value="abcdefghijklmnopqrstuvwxyz" />Lowercase a-z</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" id="alpha_upper" checked="checked" value="ABCDEFGHIJKLMNOPQRSTUVWXYZ" />Uppercase A-Z</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" id="numeric" checked="checked" value="0123456789" />Numbers (0-9)</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" id="special" value="![]{}()%&*$#^<>~@|" />Special Characters (.-+=_,!@$#*%<>[]{})</label>
                    </div>
                </div><!-- Secure Option -->

                    <hr />

                <div class="checkbox">
                    <label><input type="checkbox" id="password_copied" />I have copied this password to a secure location.</label>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger mr-auto" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success" disabled="disabled" data-dismiss="modal" id="use_password">Use Password</button>
            </div>
        </div>
    </div>
</div>
