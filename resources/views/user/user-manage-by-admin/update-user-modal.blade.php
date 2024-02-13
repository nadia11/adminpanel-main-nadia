<div class="modal fade" id="editUserModal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Update User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>

            <form action="#" id="update_user_form" method="post" enctype="multipart/form-data" class="form-horizontal software-style-label" role="form">
            @csrf

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="username" class="control-label" >User Name</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-user"></i></span>
                            </div>
                            <input type="text" name="username" id="username" placeholder="User Name" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mobile" class="control-label" >User Mobile No.</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-phone"></i></span>
                            </div>
                            <input type="tel" name="mobile" id="mobile" placeholder="User Mobile No" class="form-control" max="13">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="role_id" class="control-label">User Role</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-heart"></i></span>
                            </div>
                            <select name="role_id" id="role_id" class="custom-select" required>
                                <option value="">-- Select Role --</option>
                                <?php $roles = DB::table('user_roles')->pluck('role_name', 'role_id'); ?>

                                @foreach($roles as $role_id => $role_name )
                                    <option value="{{ $role_id }}">{{ $role_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="dob_edit" class="control-label">Date of Birth</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                            <input type="datetime" name="dob" id="dob_edit" placeholder="Date of Birth" class="form-control" required="required" autocomplete="off" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="gender" class="control-label">Gender</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></div>
                            </div>
                            <select name="gender" id="gender" class="custom-select" required>
                                <option value="">--Gender--</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="national_id" class="control-label">National ID No</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-id-card" aria-hidden="true"></i></div>
                            </div>
                            <input type="text" class="form-control" id="national_id" name="national_id" maxlength="17" placeholder="XXXXXXXXXXXXXXXXX" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label">E-Mail</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                            </div>
                            <input type="email" name="email" id="email" placeholder="example@domain.com" class="form-control" required="required" />
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="user_photo" class="control-label">User Photo</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-upload" aria-hidden="true"></i></div>
                            </div>
                            <div class="custom-file">
                                <input type="file" name="user_photo" id="user_photo" class="custom-file-input">
                                <label class="custom-file-label" for="user_photo">Choose User Photo</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12" id="pwd-container">
                            <div class="pwstrength_viewport_progress"></div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between" style="padding: 5px 0; margin: 25px 15px 10px; border-top: 1px solid #DDE; border-bottom: 1px solid #DDE;">
                        <h4 style="color: #06C; font-size: 18px; margin: 0;">Time Restriction</h4>
                        <div class="custom-control custom-switch" style="white-space: nowrap;">
                            <input type="checkbox" class="custom-control-input" id="ip_access_edit" name="ip_access">
                            <label class="custom-control-label" for="ip_access_edit" style="cursor:pointer;">Active IP Access</label>
                        </div>
                    </div>

                    <div class="form-group row ip_access_item" style="display:none;">
                        <div class="col-6">
                            <label for="user_start_time" class="control-label" style="float: none; width: 100%;">Start Time</label>
                            <div class="input-group" style="width: 100%;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-clock"></i></span>
                                </div>
                                <input type="text" name="user_start_time" id="user_start_time" class="form-control" value="00:01" autocomplete="off" />
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="user_end_time" class="control-label" style="float: none; width: 100%;">End Time</label>
                            <div class="input-group" style="width: 100%;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-clock"></i></span>
                                </div>
                                <input type="text" name="user_end_time" id="user_end_time" class="form-control" value="23:59" autocomplete="off" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group row ip_access_item" style="display:none;">
                        <div class="col-6">
                            <label for="ip_address" class="control-label" style="float: none; width: 100%;">IP Address</label>
                            <div class="input-group" style="width: 100%;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-map-marker"></i></span>
                                </div>
                                <input type="text" name="ip_address" id="ip_address" class="form-control" autocomplete="off" />
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="mac_address" class="control-label" style="float: none; width: 100%;">MAC Address</label>
                            <div class="input-group" style="width: 100%;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-laptop-code"></i></span>
                                </div>
                                <input type="text" name="mac_address" id="mac_address" class="form-control" autocomplete="off" />
                            </div>
                        </div>
                    </div>
                </div><!-- Modal Body -->

                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" name="user_id" />
                    <input type="hidden" name="user_photo_prev" value="" />
                    <button type="button" class="btn btn-danger mr-auto" data-dismiss="modal" tabindex="-1"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
                    <button type="submit" name="submit" class="btn btn-success">Update Account</button>
                </div>
            </form>
        </div>
    </div>
</div>
