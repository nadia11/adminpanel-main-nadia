<div class="modal fade" id="view_user_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3 text-center">
                        <img class="img-thumbnail" id="preview_image" src="{{ image_url('defaultAvatar.jpg') }}" style="width:250px; border: 1px solid whitesmoke ;text-align: center; position: relative">
                        <i id="loading" class="fa fa-spinner fa-spin fa-3x fa-fw" style="position: absolute;left: 40%;top: 40%;display: none"></i>
                    </div>

                    <div class="col-md-9">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 25%;">Full Name</th>
                                <td style="width: 2%;">:</td>
                                <td class="username text-capitalize"></td>
                            </tr>
                            <tr>
                                <th>Mobile No.</th>
                                <td>:</td>
                                <td class="mobile"><a href="tel: "></a></td>
                            </tr>
                            <tr>
                                <th>User Role</th>
                                <td>:</td>
                                <td class="role_name"></td>
                            </tr>
                            <tr>
                                <th>Date of Birth</th>
                                <td>:</td>
                                <td class="dob"></td>
                            </tr>
                            <tr>
                                <th>Email Address</th>
                                <td>:</td>
                                <td class="email"><a href="mailto: " target="_blank"></a></td>
                            </tr>
                            <tr>
                                <th>Account Create Date</th>
                                <td>:</td>
                                <td class="account_create_date"></td>
                            </tr>
                            <tr>
                                <th>Gender</th>
                                <td>:</td>
                                <td class="gender"></td>
                            </tr>
                            <tr>
                                <th>National ID</th>
                                <td>:</td>
                                <td class="nid"></td>
                            </tr>
                            <tr>
                                <th>Device</th>
                                <td>:</td>
                                <td class="device"></td>
                            </tr>
                            <tr>
                                <th>Last Login Date</th>
                                <td>:</td>
                                <td class="last_login_date"></td>
                            </tr>
                            <tr>
                                <th>Last Login IP</th>
                                <td>:</td>
                                <td class="last_login_ip"></td>
                            </tr>
                            <tr>
                                <th>Time Restriction</th>
                                <td>:</td>
                                <td class="ip_access"></td>
                            </tr>
                            <tr>
                                <th>User Start Time</th>
                                <td>:</td>
                                <td class="user_start_time"></td>
                            </tr>
                            <tr>
                                <th>User End Time</th>
                                <td>:</td>
                                <td class="user_end_time"></td>
                            </tr>
                            <tr>
                                <th>IP Address</th>
                                <td>:</td>
                                <td class="ip_address"></td>
                            </tr>
                            <tr>
                                <th>MAC Address</th>
                                <td>:</td>
                                <td class="mac_address"></td>
                            </tr>
                        </table>
                    </div>
                </div><!-- /.row -->
            </div>
        </div>
    </div>
</div>
