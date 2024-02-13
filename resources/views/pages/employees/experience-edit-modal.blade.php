<div class="modal fade" id="editExperienceModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Edit Experience Information of Mr. {{ $employee_data->employee_name }}</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form role="form" name="edit_employee_experience_form" id="edit_employee_experience_form" action="{{ route('edit-employee-experience-save') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                @csrf

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="company_name" class="control-label">Company Name</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-graduation-cap" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="company_name" id="company_name" class="form-control" placeholder="Company Name" tabindex="1" required />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="position" class="control-label">Position</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-graduation-cap" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="position" id="position" class="form-control" placeholder="Position" tabindex="1" required />
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="start_date" class="control-label">Start Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="datetime" name="start_date" id="start_date" class="form-control" autocomplete="off" placeholder="DD/MM/YYYY" tabindex="2" required />
                                </div>
                            </div>
                            <div class="col">
                                <label for="end_date" class="control-label">End Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="datetime" name="end_date" id="end_date" class="form-control" autocomplete="off" placeholder="DD/MM/YYYY" tabindex="3" required />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="experience_duration" class="control-label">Duration (Hours)</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-clock" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="experience_duration" id="experience_duration" class="form-control" placeholder="Duration (Hours)" tabindex="4" required />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="responsibilities" class="control-label">Responsibilities</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-university" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="responsibilities" id="responsibilities" class="form-control" placeholder="Responsibilities" tabindex="6" required />
                        </div>
                    </div>
                </div><!-- Modal Body -->

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark mr-auto" data-dismiss="modal">Close</button>
                    <button type="submit" name="update_employee_experience" id="update_employee_experience" class="btn btn-dark float-right" tabindex="7"><i class="fa fa-plus" aria-hidden="true"></i> Update Experience</button>
                    <input type="hidden" name="employee_id" value="{{ $employee_data->employee_id }}" />
                    <input type="hidden" name="experience_id" value="" />
                </div><!-- Modal footer -->
            </form>
        </div>
    </div>
</div>
