<div class="modal fade" id="editEducationModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form role="form" name="edit_employee_edu_form" id="edit_employee_edu_form" action="{{ route('edit-employee-education-save') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                @csrf

                <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="degree_level" class="control-label">Degree Level</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn btn-info"><i class="fa fa-tags"></i></button>
                                </div>
                                <select id="degree_level" name="degree_level" required class="custom-select" tabindex="1" required>
                                    <option value="under_psc">Under PSC</option>
                                    <option value="pcs">PSC</option>
                                    <option value="jsc">JSC</option>
                                    <option value="a-level">SSC/ A- Level</option>
                                    <option value="diploma">Diploma</option>
                                    <option value="hsc">HSC/ O- Level</option>
                                    <option value="graduation">Graduation</option>
                                    <option value="post_graduation">Post Graduation</option>
                                    <option value="phd">PhD</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="degree_name" class="control-label">Degree Name</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-graduation-cap" aria-hidden="true"></i></span>
                                </div>
                                <input type="text" name="degree_name" id="degree_name" class="form-control" placeholder="Degree Name" tabindex="2" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="major_subject" class="control-label">Major Subject:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-tags" aria-hidden="true"></i></span>
                                </div>
                                <input type="text" name="major_subject" id="major_subject" class="form-control" placeholder="Major Subject" tabindex="3" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="board_university" class="control-label">Board/University</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-university" aria-hidden="true"></i></span>
                                </div>
                                <datalist id="education_board_list"><option value="Barisal Board"><option value="Chittagong Board"><option value="Comilla Board"><option value="Dhaka Board"><option value="Dinajpur Board"><option value="Jessore Board"><option value="Mymensingh Board"><option value="Rajshahi Board"><option value="Sylhet Board"><option value="Technical Education Board"><option value="Madrasah Education Board"><option value="DIBS(Dhaka)"></datalist>
                                <input type="text" name="board_university" id="board_university" list="education_board_list" class="form-control" placeholder="Board/University" tabindex="4" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="passing_year" class="control-label">Passing Year</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                </div>
                                <select id="passing_year" name="passing_year" class="custom-select" tabindex="5" required>
                                    <option value="">Passing Year</option>
                                    <?php foreach( array_reverse( range(1969, date('Y')) ) as $year){ echo '<option value="'.$year.'">'.$year.'</option>'; } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="education_result" class="control-label">Education Result</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-certificate" aria-hidden="true"></i></span>
                                </div>
                                <input type="text" name="education_result" id="education_result" class="form-control" placeholder="Education Result" tabindex="6" required />
                            </div>
                        </div>
                    </div><!-- Modal Body -->

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark mr-auto" data-dismiss="modal">Close</button>
                    <button type="submit" name="update_employee_education" id="update_employee_education" class="btn btn-dark float-right" tabindex="7"><i class="fa fa-plus" aria-hidden="true"></i> Update Employee</button>
                    <input type="hidden" name="employee_id" value="{{ $employee_data->employee_id }}" />
                    <input type="hidden" name="education_id" value="" />
                </div><!-- Modal footer -->
            </form>
        </div>
    </div>
</div>
