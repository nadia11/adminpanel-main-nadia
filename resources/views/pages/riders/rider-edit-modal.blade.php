<div class="modal fade" id="editRiderModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Update Rider</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form role="form" name="" action="{{ route('edit-rider-save') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
            @csrf

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="rider_number" class="control-label">Rider Number:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" name="rider_number" id="rider_number" class="form-control" placeholder="Rider No" tabindex="1" autocomplete="off" required />
                                </div>
                            </div>
                            <div class="col">
                                <label for="rider_date" class="control-label">Rider Date:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="datetime" name="rider_date" id="rider_date" class="form-control" placeholder="DD/MM/YYYY" tabindex="2" required />
                                </div>
                            </div>
                            <div class="col">
                                <label for="delivery_date" class="control-label">Delivery Date:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="datetime" name="delivery_date" id="delivery_date" class="form-control" placeholder="DD/MM/YYYY" tabindex="3" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="client_id" class="control-label ">Client Name</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-warning"><i class="fa fa-users"></i></button>
                                    </div>
                                    <select id="client_id" name="client_id" class="custom-select" tabindex="4" required>
                                        <option value="">Select Client Name</option>
                                        <?php $clients = DB::table('clients')->pluck("client_name", "client_id"); ?>

                                        @foreach($clients as $id => $name )
                                        <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <button class="btn btn-dark" type="button" id="refreshClient" data-toggle="tooltip" data-placement="top" title="Click to reload Client"><i class="fa fa-sync-alt"></i></button>
                                        <a href="{{ URL::to('/client/client-management') }}" class="btn btn-info" target="_blank"  data-toggle="tooltip" data-placement="top" title="Create New Client"><i class="fa fa-plus fa-spin"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <label for="client_address" class="control-label">Client Address : </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" name="client_address" id="client_address" class="form-control" placeholder="Client Address" tabindex="5" required disabled />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="employee_id" class="control-label">Client Manager:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-success"><i class="fa fa-user"></i></button>
                                    </div>
                                    <input type="text" name="employee_name" id="employee_name" class="form-control" placeholder="Client Manager Name" tabindex="6" disabled />
                                    <input type="hidden" name="employee_id" id="employee_id" class="form-control" />
                                </div>
                            </div>
                            <div class="col">
                                <label for="employee_mobile" class="control-label">Mobile</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-phone" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" name="employee_mobile" id="employee_mobile" class="form-control" placeholder="8801XXXXXXXXX" tabindex="7" disabled />
                                </div>
                            </div>
                            <div class="col">
                                <label for="designation_name" class="control-label">Designation</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-tags" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" name="designation_name" id="designation_name" class="form-control" placeholder="Designation" tabindex="8" disabled />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-8">
                                <label for="project_name" class="control-label">Project name:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" name="project_name" id="project_name" class="form-control" placeholder="Project name" tabindex="9" required />
                                </div>
                            </div>
                            <div class="col-4">
                                <label for="job_status" class="control-label">Job Status:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-truck" aria-hidden="true"></i></span>
                                    </div>
                                    <datalist id="job_status_list"><option value="Pending" /><option value="Running" /><option value="Completed" /></datalist>
                                    <input type="text" name="job_status" id="job_status" class="form-control" placeholder="Job Status" list="job_status_list" tabindex="10" value="Pending" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-8">
                                <label for="description" class="control-label">Description:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" name="description" id="description" class="form-control" placeholder="Description" tabindex="11" />
                                </div>
                            </div>
                            <div class="col-4">
                                <label for="rider_attachment" class="control-label">Rider Attachment:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-upload" aria-hidden="true"></i></div>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" name="rider_attachment" id="rider_attachment" class="custom-file-input" accept="application/pdf">
                                        <label class="custom-file-label" for="rider_attachment">Choose Rider PDF file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Taka in word -->
                    <div class="form-group"><var class="in_word"></var></div>

                    <div class="form-group">
                        <label for="rider_note" class="control-label">Note:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                            </div>
                            <textarea name="rider_note" id="rider_note" cols="30" rows="3" class="form-control" placeholder="Note"></textarea>
                        </div>
                    </div>
                </div><!-- Modal Body -->

                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" name="rider_id" value="" />
                    <input type="hidden" name="rider_attachment_prev" id="rider_attachment_prev">
                    <button type="button" class="btn btn-outline-dark mr-auto" data-dismiss="modal">Close</button>
                    <button type="submit" name="update_rider" id="update_rider" class="btn btn-dark" tabindex="7"><i class="fa fa-plus" aria-hidden="true"></i> Update Rider</button>
                </div><!-- Modal footer -->
            </form>
        </div>
    </div>
</div>
