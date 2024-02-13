<div class="modal fade" id="newGroupModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Create New Group</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form role="form" name="" action="{{ route('new-group-save') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
            @csrf

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="group_name" class="control-label">Group Name</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="group_name" id="group_name" class="form-control" placeholder="Group Name" required />
                        </div>
                    </div>
                </div><!-- Modal Body -->

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark mr-auto" data-dismiss="modal" tabindex="-1">Close</button>
                    <button type="submit" class="btn btn-dark float-right"><i class="fa fa-plus" aria-hidden="true"></i> Save</button>
                </div><!-- Modal footer -->
            </form>
        </div>
    </div>
</div>
