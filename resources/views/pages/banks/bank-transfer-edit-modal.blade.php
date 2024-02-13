<div class="modal fade" id="EditChequePaymentModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Update Bank Transfer</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form role="form" name="" action="{{ route('update-bank-transfer') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
            @csrf

                <!-- Modal body -->
                <div class="modal-body">
                    
                </div><!-- Modal Body -->

                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" name="bank_transfer_id" value="" />
                    <button type="button" class="btn btn-outline-dark mr-auto" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
                    <button type="submit" name="update_bank_transfer" id="update_bank_transfer" class="btn btn-dark float-right" tabindex="14"><i class="fa fa-plus" aria-hidden="true"></i> Update Cheque Payment</button>
                </div><!-- Modal footer -->
            </form>
        </div>
    </div>
</div>