<div class="modal fade" id="promo_code_status_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Change Promo Code Status</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>

            <form action="{{ route('change-promo-code-status') }}" id="changePromoCodeStatus" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
            @csrf

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="promo_code_status" class="control-label">{{ __('Promo Code Status') }}</label>
                        <select name="promo_code_status" id="promo_code_status" class="custom-select" required>
                            <option value="active">{{ __('Active') }}</option>
                            <option value="pending">{{ __('Pending') }}</option>
                            <option value="expired">{{ __('Expired') }}</option>
                            <option value="hold">{{ __('Hold') }}</option>
                        </select>
                    </div>
                </div><!-- Modal Body -->

                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" name="promo_code_id" />
                    <button type="submit" class="btn btn-dark"><i class="fa fa-check"></i> {{ __('Change Status') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
