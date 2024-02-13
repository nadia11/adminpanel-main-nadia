<div class="modal fade" id="payment_status_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Change payment Status</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>

            <form action="{{ route('change-payment-status') }}" id="changePaymentStatus" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
            @csrf

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="payment_status" class="control-label">Payment Status</label>
                        <select name="payment_status" id="payment_status" class="custom-select" required>
                            <option value="">--Payment Status--</option>
                            <option value="unpaid">Unpaid</option>
                            <option value="paid">Paid</option>
                        </select>
                    </div>
                </div><!-- Modal Body -->

                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" name="driver_earning_id" />
                    <button type="submit" class="btn btn-dark"><i class="fa fa-check"></i> Change Status</button>
                </div>
            </form>
        </div>
    </div>
</div>
