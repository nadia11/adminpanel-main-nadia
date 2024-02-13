<div class="modal fade" id="newEmployeeModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Create New Employee</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form role="form" name="" action="{{ route('new-employee-save') }}" method="POST" enctype="multipart/form-data" class="form-horizontal software-style-label">
            @csrf

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="employee_type" class="control-label">Employment Type:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button type="button" class="btn btn-info"><i class="fa fa-tags"></i></button>
                            </div>
                            <select id="employee_type" name="employee_type" required class="custom-select" tabindex="1">
                                <option value="regular">Regular</option>
                                <option value="temporary">Temporary</option>
                                <option value="contractual">Contractual</option>
                                <option value="probational">Probational</option>
                                <option value="owner">Owner</option>
                                <option value="trainee">Trainee</option>
                                <option value="partTime">Part Time</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="employee_name" class="control-label">Employee Name:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="employee_name" id="employee_name" class="form-control" placeholder="Employee Name" tabindex="2" required />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="employee_code" class="control-label">Employee Code:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-code" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="employee_code" id="employee_code" class="form-control" placeholder="Employee Code" tabindex="3" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cardID" class="control-label">Card ID:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-id-card" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="cardID" id="cardID" class="form-control" placeholder="Card ID" tabindex="4" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="employee_fathers_name" class="control-label">Father's Name:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="employee_fathers_name" id="employee_fathers_name" class="form-control" placeholder="Father's Name" tabindex="5" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="employee_mothers_name" class="control-label">Mother's Name:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-female" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="employee_mothers_name" id="employee_mothers_name" class="form-control" placeholder="Mother's Name" tabindex="6" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="employee_mobile" class="control-label">Mobile:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-phone" aria-hidden="true"></i></span>
                            </div>
                            <input type="tel" name="employee_mobile" id="employee_mobile" maxlength="13" class="form-control" placeholder="8801XXXXXXXXX" tabindex="7" required />
                            <div class="input-group-append">
                                <button class="btn btn-dark characterCount" type="button">13</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="employee_alt_mobile" class="control-label">Alt Mobile:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-phone" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="employee_alt_mobile" id="employee_alt_mobile" maxlength="13" class="form-control" placeholder="8801XXXXXXXXX" tabindex="8" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="employee_email" class="control-label">Email:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-phone" aria-hidden="true"></i></span>
                            </div>
                            <input type="email" name="employee_email" id="employee_email" class="form-control" placeholder="example@domain.com" tabindex="9" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="department_id" class="control-label">Department:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button type="button" class="btn btn-warning"><i class="fa fa-box"></i></button>
                            </div>

                            <select id="department_id" name="department_id" class="custom-select" tabindex="10" required>
                                <option value="">Select Department</option>
                                <?php $departments = DB::table('departments')->orderBy('department_name', 'ASC')->pluck("department_name", "department_id"); ?>

                                @foreach($departments as $id => $name )
                                <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="designation_id" class="control-label">Designation:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button type="button" class="btn btn-success"><i class="fa fa-tags"></i></button>
                            </div>
                            <select id="designation_id" name="designation_id" class="custom-select" tabindex="11" required>
                                <option value="">--Select Designation--</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="employee_gender" class="control-label">Gender</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-transgender"></i></span>
                            </div>
                            <select name="employee_gender" id="employee_gender" class="custom-select" tabindex="12" required>
                                <option value="" selected="selected">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="marital_status" class="control-label">Marital Status</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-heart"></i></span>
                            </div>
                            <select name="marital_status" id="marital_status" class="custom-select" tabindex="13">
                                <option value="" selected="selected">--Select--</option>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Divorced">Divorced</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="employee_dob" class="control-label">Date of Birth</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                            <input type="datetime" name="employee_dob" id="employee_dob" placeholder="DD/MM/YYYY" class="form-control" autocomplete="off" tabindex="14" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="employee_religion" class="control-label">Religion:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fab fa-pagelines" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="employee_religion" id="employee_religion" class="form-control" placeholder="Religion" tabindex="15" required />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="employee_nationality" class="control-label">Nationality:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="employee_nationality" id="employee_nationality" class="form-control" placeholder="Nationality" value="Bangladeshi" tabindex="16" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="employee_nid" class="control-label">National ID:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-address-card" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="employee_nid" id="employee_nid" class="form-control" placeholder="National ID" tabindex="17" required />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="birth_certificate" class="control-label">Birth Certificate No.</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-certificate"></i></span>
                            </div>
                            <input type="text" name="birth_certificate" id="birth_certificate" placeholder="Birth Certificate No." class="form-control" autocomplete="off" tabindex="18" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="passport_no" class="control-label">Passport No:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="passport_no" id="passport_no" class="form-control" placeholder="Passport No" tabindex="19"  />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="joining_date" class="control-label">Joining Date:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fab fa-pagelines" aria-hidden="true"></i></span>
                            </div>
                            <input type="datetime" name="joining_date" id="joining_date" class="form-control" placeholder="YYYY/MM/DD" tabindex="20" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="blood_group" class="control-label">Blood Group:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fal fa-syringe" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="blood_group" id="blood_group" class="form-control" placeholder="Blood Group" tabindex="21" required />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="employee_photo" class="control-label">Employee Photo:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-upload" aria-hidden="true"></i></div>
                            </div>
                            <div class="custom-file">
                                <input type="file" name="employee_photo" id="employee_photo" class="custom-file-input" tabindex="22">
                                <label class="custom-file-label" for="employee_photo">Choose Photo</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="division_id" class="control-label">Division</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button type="button" class="btn btn-info"><i class="fa fa-th-large"></i></button>
                            </div>

                            <select id="division_id" name="division_id" class="custom-select" tabindex="23" required>
                                <option value="" selected="selected">--Select Division--</option>
                                @php $divisions = DB::table('divisions')->orderBy('division_name', 'ASC')->pluck("division_name", "division_id") @endphp

                                @foreach( $divisions as $key => $division )
                                <option value="{{ $key }}">{{ $division }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="district_id" class="control-label">District</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-th"></i></div>
                            </div>
                            <select id="district_id" name="district_id" class="custom-select" tabindex="24" required>
                                <option value="">--select District--</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="employee_address" class="control-label">Address:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                            </div>
                            <textarea name="employee_address" id="employee_address" cols="30" rows="2" class="form-control" placeholder="Employee Address" placeholder="Employee Address" tabindex="25"></textarea>
                        </div>
                    </div>
                </div><!-- Modal Body -->

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark mr-auto" data-dismiss="modal">Close</button>
                    <button type="submit" name="create_employee" id="create_employee" class="btn btn-dark float-right" tabindex="26"><i class="fa fa-plus" aria-hidden="true"></i> Create New Employee</button>
                </div><!-- Modal footer -->
            </form>
        </div>
    </div>
</div>
