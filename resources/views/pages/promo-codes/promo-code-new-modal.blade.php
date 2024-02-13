<div class="modal fade" id="showNewPromoCodeModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Create New Promo Code</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form role="form" name="" action="{{ route('new-promo-code-save') }}" method="POST" enctype="multipart/form-data" class="form-horizontal software-style-label">
            @csrf

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="promo_name" class="control-label">Promo Name</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="promo_name" id="promo_name" class="form-control" placeholder="Promo Name" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="promo_code" class="control-label">Promo Code</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="promo_code" id="promo_code" class="form-control" placeholder="Promo Code" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="create_date" class="control-label">Create Date</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                            </div>
                            <input type="datetime" name="create_date" id="create_date" class="form-control" placeholder="Create Date" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="expiry_date" class="control-label">Expiry Date</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                            </div>
                            <input type="datetime" name="expiry_date" id="expiry_date" class="form-control" placeholder="Expiry Date" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="promo_amount" class="control-label">Promo Amount</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="promo_amount" id="promo_amount" class="form-control" placeholder="Promo Amount" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="promo_code_count" class="control-label">Promo Code Count</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="promo_code_count" id="promo_code_count" class="form-control" placeholder="Promo Code Count" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="promo_code_note" class="control-label">Note:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                            </div>
                            <textarea name="promo_code_note" id="promo_code_note" class="form-control" cols="30" rows="2"></textarea>
                        </div>
                    </div>
                </div><!-- Modal Body -->

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark mr-auto" data-dismiss="modal" tabindex="-1">Close</button>
                    <button type="submit" id="create_promo_code" class="btn btn-dark float-right"><i class="fa fa-plus" aria-hidden="true"></i> Create New Promo Code</button>
                </div><!-- Modal footer -->
            </form>
        </div>
    </div>
</div>
