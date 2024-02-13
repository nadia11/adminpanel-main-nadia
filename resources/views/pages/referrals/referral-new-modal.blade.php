<div class="modal fade" id="showNewReferralModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Create New Referral</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form role="form" name="" action="{{ route('new-referral-save') }}" method="POST" enctype="multipart/form-data" class="form-horizontal software-style-label">
            @csrf

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="vehicle_id" class="control-label">Vehicle</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-th-large"></i></div>
                            </div>
                            <select id="vehicle_id" name="vehicle_id" class="custom-select" required>
                                <option value="" selected="selected">--Vehicle--</option>
                                @php $vehicles = DB::table('vehicles')->orderBy('vehicle_model', 'ASC')->pluck("vehicle_model", "vehicle_id") @endphp

                                @foreach( $vehicles as $key => $vehicle )
                                    <option value="{{ $key }}">{{ $vehicle }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="referral_per_km" class="control-label">Referral Per KM</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="referral_per_km" id="referral_per_km" class="form-control" placeholder="Referral Per KM" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="waiting_referral" class="control-label">Waiting Referral</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="waiting_referral" id="waiting_referral" class="form-control" placeholder="Waiting Referral" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="minimum_referral" class="control-label">Minimum Referral</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="minimum_referral" id="minimum_referral" class="form-control" placeholder="Minimum Referral" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="minimum_distance" class="control-label">Minimum Distance</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="minimum_distance" id="minimum_distance" class="form-control" placeholder="Minimum Distance" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="referral_note" class="control-label">Note:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                            </div>
                            <textarea name="referral_note" id="referral_note" class="form-control" cols="30" rows="2"></textarea>
                        </div>
                    </div>
                </div><!-- Modal Body -->

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark mr-auto" data-dismiss="modal" tabindex="-1">Close</button>
                    <button type="submit" id="create_referral" class="btn btn-dark float-right"><i class="fa fa-plus" aria-hidden="true"></i> Create New Referral</button>
                </div><!-- Modal footer -->
            </form>
        </div>
    </div>
</div>
