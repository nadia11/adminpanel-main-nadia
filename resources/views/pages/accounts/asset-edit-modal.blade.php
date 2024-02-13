<div class="modal fade" id="editAssetModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Update Asset</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form role="form" name="" action="{{ route('edit-asset-save') }}" method="POST" enctype="multipart/form-data" class="form-horizontal software-style-label">
            @csrf

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="asset_opening_date" class="control-label">Opening Date</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                            </div>
                            <input type="datetime" name="asset_opening_date" id="asset_opening_date" class="form-control" placeholder="DD/MM/YYYY" tabindex="1" value="<?php echo date('d/m/Y'); ?>" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="asset_type" class="control-label">Asset Type</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-tags" aria-hidden="true"></i></span>
                            </div>
                            <select id="asset_type" name="asset_type" class="custom-select" tabindex="2" required>
                                <option value="">--Asset Type--</option>
                                <option value="Fixed Assets">Fixed Assets</option>
                                <option value="Current Assets">Current Assets</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="asset_name" class="control-label">Asset Name</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="asset_name" id="asset_name" class="form-control" placeholder="Asset Name" tabindex="3" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="asset_uom" class="control-label">Asset UOM</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                            </div>
                            <datalist id="uom_list"><option value="Sft" /><option value="Rft" /><option value="Cft" /><option value="Pcs" /><option value="Each" /></datalist>
                            <input type="text" name="asset_uom" id="asset_uom" list="uom_list" class="form-control" placeholder="UOM" tabindex="4" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="asset_qty" class="control-label">Qty.</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                            </div>
                            <input type="number" name="asset_qty" id="asset_qty" class="form-control" placeholder="Qty" tabindex="5" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="asset_rate" class="control-label">Asset Rate</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                            </div>
                            <input type="number" name="asset_rate" id="asset_rate" class="form-control" placeholder="Asset Rate" tabindex="6" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="asset_total_amount" class="control-label">Total Amount</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-dollar-sign" aria-hidden="true"></i></span>
                            </div>
                            <input type="number" name="asset_total_amount" id="asset_total_amount" class="form-control" placeholder="Total Amount" tabindex="7" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="asset_description" class="control-label">Description</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                            </div>
                            <textarea name="asset_description" id="asset_description" cols="30" rows="2" class="form-control" tabindex="8"></textarea>
                        </div>
                    </div>
                </div><!-- Modal Body -->

                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" name="asset_id" value="" />
                    <button type="button" class="btn btn-outline-dark mr-auto" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-dark float-right" tabindex="7"><i class="fa fa-plus" aria-hidden="true"></i> Update Asset</button>
                </div><!-- Modal footer -->
            </form>
        </div>
    </div>
</div>
