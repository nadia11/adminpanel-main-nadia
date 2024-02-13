<div class="modal fade" id="editCertificateModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Edit Professional Certificate of Mr. {{ $employee_data->employee_name }}</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form role="form" name="edit_employee_certificate_form" id="edit_employee_certificate_form" action="{{ route('edit-employee-certificate-save') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                @csrf

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="certificate_name" class="control-label">Certificate Name</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-graduation-cap" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="certificate_name" id="certificate_name" class="form-control" placeholder="Certificate Name" tabindex="1" required />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="certificate_no" class="control-label">Certificate No</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-graduation-cap" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="certificate_no" id="certificate_no" class="form-control" placeholder="Certificate No" tabindex="2" required />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="certified_by" class="control-label">certified by</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-clock" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="certified_by" id="certified_by" class="form-control" placeholder="certified by" tabindex="3" required />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="certificate_year" class="control-label">Certificate Year</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-university" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="certificate_year" id="certificate_year" class="form-control" placeholder="Certificate Year" tabindex="4" required />
                        </div>
                    </div>
                </div><!-- Modal Body -->

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark mr-auto" data-dismiss="modal">Close</button>
                    <button type="submit" name="update_employee_certificate" id="update_employee_certificate" class="btn btn-dark float-right" tabindex="5"><i class="fa fa-plus" aria-hidden="true"></i> Update Certificate</button>
                    <input type="hidden" name="employee_id" value="{{ $employee_data->employee_id }}" />
                    <input type="hidden" name="certificate_id" value="" />
                </div><!-- Modal footer -->
            </form>
        </div>
    </div>
</div>
