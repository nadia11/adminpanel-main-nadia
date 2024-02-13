<div class="modal fade" id="editVehicleTypeModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Update Vehicle</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form role="form" name="" action="{{ route('update-vehicle-type-save') }}" method="POST" enctype="multipart/form-data" class="form-horizontal software-style-label">
            @csrf

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="vehicle_type" class="control-label">Vehicle Type</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="vehicle_type" id="vehicle_type" placeholder="Vehicle Type" class="form-control" required="required" autocomplete="off" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="seat_capacity" class="control-label">Seat Capacity</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                            </div>
                            <select id="seat_capacity" name="seat_capacity" class="custom-select" required>
                                <option value="">--Seat Capacity--</option>
                                <option value="2">2 Persons</option>
                                <option value="4">4 Persons</option>
                                <option value="6">6 Persons</option>
                                <option value="8">8 Persons</option>
                                <option value="10">10 Persons</option>
                                <option value="12">12 Persons</option>
                                <option value="14">14 Persons</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="vehicle_color" class="control-label">Minimum Fare</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                            </div>
                            <select id="vehicle_color" name="vehicle_color" class="custom-select" required>
                                <option value="">--Color--</option>
                                <option value="red">Red</option>
                                <option value="orange">Orange</option>
                                <option value="yellow">Yellow</option>
                                <option value="green">Green</option>
                                <option value="blue">Blue</option>
                                <option value="purple">Purple</option>
                                <option value="silver">Silver</option>
                                <option value="gray">Gray</option>
                                <option value="maroon">Maroon</option>
                                <option value="black">Black</option>
                                <option value="white">White</option>
                                <option value="golden">Golden</option>
                                <option value="pink">Pink</option>
                                <option value="brown">Brown</option>
                                <option value="tan">Tan</option>

                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="vehicle_photo" class="control-label">Vehicle Photo</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-upload" aria-hidden="true"></i></div>
                            </div>
                            <div class="custom-file">
                                <input type="file" name="vehicle_photo" id="vehicle_photo" class="custom-file-input" accept=".png, .jpg, .jpeg" required />
                                <label class="custom-file-label" for="vehicle_photo">Choose Vehicle Photo</label>
                            </div>
                            <small style="width: 100%; text-align: left;">Max: 45mm high and 35mm wide, below 100 kb</small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="note" class="control-label">Note:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                            </div>
                            <textarea name="note" id="note" class="form-control" cols="30" rows="2"></textarea>
                        </div>
                    </div>
                </div><!-- Modal Body -->


                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" name="vehicle_type_id" value="" />
                    <input type="hidden" name="vehicle_photo_prev" id="vehicle_photo_prev">
                    <button type="button" class="btn btn-outline-dark mr-auto" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-dark" tabindex="7"><i class="fa fa-plus" aria-hidden="true"></i> Update Vehicle</button>
                </div><!-- Modal footer -->
            </form>
        </div>
    </div>
</div>
