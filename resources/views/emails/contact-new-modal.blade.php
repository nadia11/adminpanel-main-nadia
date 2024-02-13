<div class="modal fade" id="newContactModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Create New Contact</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form role="form" name="" action="{{ route('new-contact-save') }}" method="post" enctype="multipart/form-data" class="form-horizontal software-style-label">
            @csrf

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="contact_name" class="control-label">Contact Name</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="contact_name" id="contact_name" class="form-control" placeholder="Contact Name" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="contact_mobile" class="control-label">Mobile</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-phone" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="contact_mobile" id="contact_mobile" class="form-control" placeholder="Mobile" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="contact_email" class="control-label">Email</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="contact_email" id="contact_email" class="form-control" placeholder="Email" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="operator_id" class="control-label">Operator</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-tags" aria-hidden="true"></i></span>
                            </div>
                            <select id="operator" name="operator" class="custom-select" required>
                                <option value="">--Select Operator--</option>
                                <option value="017">GP - 017</option>
                                <option value="013">GP - 013</option>
                                <option value="019">BL - 019</option>
                                <option value="014">BL - 014</option>
                                <option value="018">Robi - 018</option>
                                <option value="016">Robi - 016</option>
                                <option value="015">Teletalk - 015</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="contact_type" class="control-label">Group</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-user-friends" aria-hidden="true"></i></span>
                            </div>
                            <select id="group_id" name="group_id" class="custom-select">
                                @php $group_names = DB::table('contact_groups')->orderBy('group_name', 'ASC')->pluck("group_name", "group_id") @endphp

                                <option value="">--Select Group--</option>
                                @foreach( $group_names as $key => $name )
                                    <option value="{{ $key }}">{{ ucwords($name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div><!-- Modal Body -->

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark mr-auto" data-dismiss="modal" tabindex="-1">Close</button>
                    <button type="submit" class="btn btn-dark float-right" tabindex="9"><i class="fa fa-plus" aria-hidden="true"></i> Save</button>
                </div><!-- Modal footer -->
            </form>
        </div>
    </div>
</div>
