<div class="modal fade" id="editCommissionModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Update Commission</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form role="form" name="" action="{{ route('edit-commission-save') }}" method="POST" enctype="multipart/form-data" class="form-horizontal software-style-label">
            @csrf

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="commission_name" class="control-label">Commission Name</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="commission_name" id="commission_name" class="form-control" placeholder="Commission Name" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="commission_percent" class="control-label">Percent</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                            </div>
                            <input type="number" name="commission_percent" id="commission_percent" class="form-control" placeholder="Percent" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="note" class="control-label">Description</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                            </div>
                            <textarea name="note" id="note" cols="30" rows="2" class="form-control"></textarea>
                        </div>
                    </div>
                </div><!-- Modal Body -->

                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" name="commission_id" value="" />
                    <button type="button" class="btn btn-outline-dark mr-auto" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-dark float-right" tabindex="7"><i class="fa fa-plus" aria-hidden="true"></i> Update Commission</button>
                </div><!-- Modal footer -->
            </form>
        </div>
    </div>
</div>
