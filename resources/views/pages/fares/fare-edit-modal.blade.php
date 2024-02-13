<div class="modal fade" id="editFareModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Update Fare</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form role="form" name="" action="{{ route('edit-fare-save') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
            @csrf

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="vehicle_type_id" class="control-label">Vehicle Type</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><div class="input-group-text"><i class="fa fa-th-large"></i></div></div>
                                    <select id="vehicle_type_id" name="vehicle_type_id" class="custom-select" required>
                                        <option value="" selected="selected">--select--</option>
                                        @php $vehicles = DB::table('vehicle_types')->orderBy('vehicle_type', 'ASC')->pluck("vehicle_type", "vehicle_type_id") @endphp

                                        @foreach( $vehicles as $key => $vehicle )
                                            <option value="{{ $key }}">{{ str_snack($vehicle) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <label for="minimum_fare" class="control-label">Minimum Fare</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="number" name="minimum_fare" id="minimum_fare" class="form-control" placeholder="" required />
                                </div>
                            </div>
                            <div class="col">
                                <label for="fare_per_km" class="control-label">Fare Per KM</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="number" name="fare_per_km" id="fare_per_km" class="form-control" placeholder="" required />
                                </div>
                            </div>
                            <div class="col">
                                <label for="waiting_fare" class="control-label">Waiting Fare</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="number" name="waiting_fare" id="waiting_fare" class="form-control" placeholder="" required />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="minimum_distance" class="control-label">Minimum Distance</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="number" name="minimum_distance" id="minimum_distance" class="form-control" placeholder="" required />
                                </div>
                            </div>
                            <div class="col">
                                <label for="destination_change_fee" class="control-label">Destination Change Fee</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="number" name="destination_change_fee" id="destination_change_fee" class="form-control" placeholder="" required />
                                </div>
                            </div>
                            <div class="col">
                                <label for="delay_cancellation_fee" class="control-label">Delay Cancellation Fee</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="number" name="delay_cancellation_fee" id="delay_cancellation_fee" class="form-control" placeholder="" required />
                                </div>
                            </div>
                            <div class="col">
                                <label for="delay_cancellation_time" class="control-label">Delay Can Time in Minute</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-clock" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="number" name="delay_cancellation_time" maxlength="2" id="delay_cancellation_time" class="form-control" placeholder="" required />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="period_type" class="control-label">Time Period</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><div class="input-group-text"><i class="fa fa-clock"></i></div></div>
                                    <select id="period_type" name="period_type" class="custom-select" required>
                                        <option value="" selected="selected">--select--</option>
                                        <option value="pick_hour">Pick Hour</option>
                                        <option value="off_pick_hour">Off Pick Hour</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <label for="start_time" class="control-label">Start Time</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><div class="input-group-text"><i class="fa fa-calendar"></i></div></div>
                                    <select name="start_time" id="start_time" class="custom-select" required>
                                        <option value="" selected="selected">--select--</option>
                                        <option value="0.00">0.00</option><option value="0.15">0.15</option><option value="0.30">0.30</option><option value="0.45">0.45</option><option value="1.00">1.00</option><option value="1.15">1.15</option><option value="1.30">1.30</option><option value="1.45">1.45</option><option value="2.00">2.00</option><option value="2.15">2.15</option><option value="2.30">2.30</option><option value="2.45">2.45</option><option value="3.00">3.00</option><option value="3.15">3.15</option><option value="3.30">3.30</option><option value="3.45">3.45</option><option value="4.00">4.00</option><option value="4.15">4.15</option><option value="4.30">4.30</option><option value="4.45">4.45</option><option value="5.00">5.00</option><option value="5.15">5.15</option><option value="5.30">5.30</option><option value="5.45">5.45</option><option value="6.00">6.00</option><option value="6.15">6.15</option><option value="6.30">6.30</option><option value="6.45">6.45</option><option value="7.00">7.00</option><option value="7.15">7.15</option><option value="7.30">7.30</option><option value="7.45">7.45</option><option value="8.00">8.00</option><option value="8.15">8.15</option><option value="8.30">8.30</option><option value="8.45">8.45</option><option value="9.00">9.00</option><option value="9.15">9.15</option><option value="9.30">9.30</option><option value="9.45">9.45</option><option value="10.00">10.00</option><option value="10.15">10.15</option><option value="10.30">10.30</option><option value="10.45">10.45</option><option value="11.00">11.00</option><option value="11.15">11.15</option><option value="11.30">11.30</option><option value="11.45">11.45</option><option value="12.00">12.00</option><option value="12.15">12.15</option><option value="12.30">12.30</option><option value="12.45">12.45</option><option value="13.00">13.00</option><option value="13.15">13.15</option><option value="13.30">13.30</option><option value="13.45">13.45</option><option value="14.00">14.00</option><option value="14.15">14.15</option><option value="14.30">14.30</option><option value="14.45">14.45</option><option value="15.00">15.00</option><option value="15.15">15.15</option><option value="15.30">15.30</option><option value="15.45">15.45</option><option value="16.00">16.00</option><option value="16.15">16.15</option><option value="16.30">16.30</option><option value="16.45">16.45</option><option value="17.00">17.00</option><option value="17.15">17.15</option><option value="17.30">17.30</option><option value="17.45">17.45</option><option value="18.00">18.00</option><option value="18.15">18.15</option><option value="18.30">18.30</option><option value="18.45">18.45</option><option value="19.00">19.00</option><option value="19.15">19.15</option><option value="19.30">19.30</option><option value="19.45">19.45</option><option value="20.00">20.00</option><option value="20.15">20.15</option><option value="20.30">20.30</option><option value="20.45">20.45</option><option value="21.00">21.00</option><option value="21.15">21.15</option><option value="21.30">21.30</option><option value="21.45">21.45</option><option value="22.00">22.00</option><option value="22.15">22.15</option><option value="22.30">22.30</option><option value="22.45">22.45</option><option value="23.00">23.00</option><option value="23.15">23.15</option><option value="23.30">23.30</option><option value="23.45">23.45</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <label for="end_time" class="control-label">End Time</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><div class="input-group-text"><i class="fa fa-calendar"></i></div></div>
                                    <select name="end_time" id="end_time" class="custom-select" required>
                                        <option value="" selected="selected">--select--</option>
                                        <option value="0:00">0:00</option><option value="0:15">0:15</option><option value="0:30">0:30</option><option value="0:45">0:45</option><option value="1:00">1:00</option><option value="1:15">1:15</option><option value="1:30">1:30</option><option value="1:45">1:45</option><option value="2:00">2:00</option><option value="2:15">2:15</option><option value="2:30">2:30</option><option value="2:45">2:45</option><option value="3:00">3:00</option><option value="3:15">3:15</option><option value="3:30">3:30</option><option value="3:45">3:45</option><option value="4:00">4:00</option><option value="4:15">4:15</option><option value="4:30">4:30</option><option value="4:45">4:45</option><option value="5:00">5:00</option><option value="5:15">5:15</option><option value="5:30">5:30</option><option value="5:45">5:45</option><option value="6:00">6:00</option><option value="6:15">6:15</option><option value="6:30">6:30</option><option value="6:45">6:45</option><option value="7:00">7:00</option><option value="7:15">7:15</option><option value="7:30">7:30</option><option value="7:45">7:45</option><option value="8:00">8:00</option><option value="8:15">8:15</option><option value="8:30">8:30</option><option value="8:45">8:45</option><option value="9:00">9:00</option><option value="9:15">9:15</option><option value="9:30">9:30</option><option value="9:45">9:45</option><option value="10:00">10:00</option><option value="10:15">10:15</option><option value="10:30">10:30</option><option value="10:45">10:45</option><option value="11:00">11:00</option><option value="11:15">11:15</option><option value="11:30">11:30</option><option value="11:45">11:45</option><option value="12:00">12:00</option><option value="12:15">12:15</option><option value="12:30">12:30</option><option value="12:45">12:45</option><option value="13:00">13:00</option><option value="13:15">13:15</option><option value="13:30">13:30</option><option value="13:45">13:45</option><option value="14:00">14:00</option><option value="14:15">14:15</option><option value="14:30">14:30</option><option value="14:45">14:45</option><option value="15:00">15:00</option><option value="15:15">15:15</option><option value="15:30">15:30</option><option value="15:45">15:45</option><option value="16:00">16:00</option><option value="16:15">16:15</option><option value="16:30">16:30</option><option value="16:45">16:45</option><option value="17:00">17:00</option><option value="17:15">17:15</option><option value="17:30">17:30</option><option value="17:45">17:45</option><option value="18:00">18:00</option><option value="18:15">18:15</option><option value="18:30">18:30</option><option value="18:45">18:45</option><option value="19:00">19:00</option><option value="19:15">19:15</option><option value="19:30">19:30</option><option value="19:45">19:45</option><option value="20:00">20:00</option><option value="20:15">20:15</option><option value="20:30">20:30</option><option value="20:45">20:45</option><option value="21:00">21:00</option><option value="21:15">21:15</option><option value="21:30">21:30</option><option value="21:45">21:45</option><option value="22:00">22:00</option><option value="22:15">22:15</option><option value="22:30">22:30</option><option value="22:45">22:45</option><option value="23:00">23:00</option><option value="23:15">23:15</option><option value="23:30">23:30</option><option value="23:45">23:45</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="fare_note" class="control-label">Note:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                            </div>
                            <textarea name="fare_note" id="fare_note" class="form-control" cols="30" rows="2"></textarea>
                        </div>
                    </div>
                </div><!-- Modal Body -->

                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" name="fare_id" value="" />
                    <button type="button" class="btn btn-outline-dark mr-auto" data-dismiss="modal">Close</button>
                    <button type="submit" name="update_fare" id="update_fare" class="btn btn-dark" tabindex="7"><i class="fa fa-plus" aria-hidden="true"></i> Update Fare</button>
                </div><!-- Modal footer -->
            </form>
        </div>
    </div>
</div>
