<div class="modal fade" id="showNewAgentModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Create New Agent</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form role="form" name="" action="{{ route('new-agent-save') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
            @csrf

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="agent_name" class="control-label">Agent Name</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" name="agent_name" id="agent_name" class="form-control" placeholder="Agent Name" required />
                                </div>
                            </div>
                            <div class="col">
                                <label for="fathers_name" class="control-label">Father's Name</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-user"></i></div>
                                    </div>
                                    <input type="text" class="form-control text-capitalize" name="fathers_name" id="fathers_name" placeholder="Father's Name" required />
                                </div>
                            </div>
                            <div class="col">
                                <label for="mothers_name" class="control-label">Mother's Name</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-female"></i></div>
                                    </div>
                                    <input type="text" class="form-control text-capitalize" name="mothers_name" id="mothers_name" placeholder="Mother's Name" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="country_name" class="control-label">Country</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="far fa-globe-europe"></i></div>
                                    </div>
                                    <input type="text" name="country_name" id="country_name" class="form-control" placeholder="Country Name" value="Bangladesh" readonly />
                                </div>
                            </div>
                            <div class="col">
                                <label for="division_id" class="control-label">Division</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-th-large"></i></div>
                                    </div>
                                    <select id="division_id" name="division_id" class="custom-select" required>
                                        <option value="" selected="selected">--Division--</option>
                                        @php $divisions = DB::table('divisions')->orderBy('division_name', 'ASC')->pluck("division_name", "division_id") @endphp

                                        @foreach( $divisions as $key => $division )
                                            <option value="{{ $key }}">{{ $division }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <label for="district_id" class="control-label">District</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-th"></i></div>
                                    </div>
                                    <select id="district_id" name="district_id" class="custom-select" required>
                                        <option value="">--District--</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="branch_name" class="control-label">Branch Name</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-map-marker"></i></div>
                                    </div>
                                    <input type="text" name="branch_name" id="branch_name" class="form-control" placeholder="Branch Name" required />
                                </div>
                            </div>
                            <div class="col-8">
                                <label for="branch_address" class="control-label">Branch Address</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-map-marker"></i></div>
                                    </div>
                                    <textarea name="branch_address" id="branch_address" cols="30" rows="1" class="form-control" placeholder="Branch Address" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="date_of_birth" class="control-label">Date of Birth</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="datetime" name="date_of_birth" id="date_of_birth" class="form-control" placeholder="DD/MM/YYYY" required />
                                </div>
                            </div>
                            <div class="col">
                                <label for="blood_group" class="control-label">Blood Group</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-heart"></i></div>
                                    </div>
                                    <select name="blood_group" id="blood_group" class="custom-select" required>
                                        <option value="">--Select--</option>
                                        <option value="A_pos">A+</option>
                                        <option value="A_neg">A-</option>
                                        <option value="B_pos">B+</option>
                                        <option value="B_neg">B-</option>
                                        <option value="O_pos">O+</option>
                                        <option value="O_neg">O-</option>
                                        <option value="AB_pos">AB+</option>
                                        <option value="AB_neg">AB-</option>
                                        <option value="n_a">N/A</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <label for="gender" class="control-label">Gender</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-transgender-alt"></i></div>
                                    </div>
                                    <select name="gender" id="gender" class="custom-select" required>
                                        <option value="">--Select--</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <label for="religion" class="control-label">Religion</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fab fa-pagelines" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" name="religion" list="religion_list" id="religion" class="form-control" placeholder="Religion" required />
                                    <datalist id="religion_list"><option value="Islam"><option value="Hinduism"><option value="Buddhism"><option value="Unaffiliated"><option value="Christianity"><option value="Others"></option></datalist>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="mobile" class="control-label">Mobile</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-phone" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" name="mobile" id="mobile" class="form-control" placeholder="8801XXXXXXXXX" required />
                                </div>
                            </div>
                            <div class="col">
                                <label for="alt_mobile" class="control-label">Alt. Mobile</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-phone" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" name="alt_mobile" id="alt_mobile" class="form-control" placeholder="8801XXXXXXXXX" />
                                </div>
                            </div>
                            <div class="col">
                                <label for="nationality" class="control-label">Nationality</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" name="nationality" id="nationality" class="form-control" placeholder="Nationality" value="Bangladeshi" required />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="email" class="control-label">Email</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" name="email" id="email" class="form-control" placeholder="Email" required />
                                </div>
                            </div>
                            <div class="col">
                                <label for="password" class="control-label">Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-lock" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="********" required />
                                </div>
                            </div>
                            <div class="col">
                                <label for="agent_photo" class="control-label">Agent Photo</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-upload" aria-hidden="true"></i></div>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" name="agent_photo" id="agent_photo" class="custom-file-input" accept=".png, .jpg, .jpeg" required />
                                        <label class="custom-file-label" for="agent_photo">Choose Photo</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="national_id" class="control-label">National ID</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-address-card" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="number" name="national_id" id="national_id" class="form-control" placeholder="National ID" required />
                                </div>
                            </div>
                            <div class="col-8">
                                <label for="nid_copy" class="control-label">NID Copy (Front & Back)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-upload" aria-hidden="true"></i></div>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" name="nid_copy" id="nid_copy" class="custom-file-input" accept=".png, .jpg, .jpeg" required />
                                        <label class="custom-file-label" for="nid_copy">Choose NID Copy</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="trade_licence_number" class="control-label">Trade Licence Number</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-address-card" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="number" name="trade_licence_number" id="trade_licence_number" class="form-control" placeholder="Trade Licence Number" required />
                                </div>
                            </div>
                            <div class="col-8">
                                <label for="trade_licence" class="control-label">Trade Licence</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-upload" aria-hidden="true"></i></div>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" name="trade_licence" id="trade_licence" class="custom-file-input" accept="application/pdf" required />
                                        <label class="custom-file-label" for="trade_licence">Choose Trade Licence</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                     <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="tin_number" class="control-label">Tin Number</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-address-card" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="number" name="tin_number" id="tin_number" class="form-control" placeholder="Tin Number" required />
                                </div>
                            </div>
                            <div class="col-8">
                                <label for="tin_certificate" class="control-label">Tin Certificate</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-upload" aria-hidden="true"></i></div>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" name="tin_certificate" id="tin_certificate" class="custom-file-input" required />
                                        <label class="custom-file-label" for="tin_certificate">Choose Tin Certificate</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                     <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="vat_number" class="control-label">VAT Number</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-address-card" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="number" name="vat_number" id="vat_number" class="form-control" placeholder="VAT Number" required />
                                </div>
                            </div>
                            <div class="col-8">
                                <label for="vat_certificate" class="control-label">VAT Certificate</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-upload" aria-hidden="true"></i></div>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" name="vat_certificate" id="vat_certificate" class="custom-file-input" required />
                                        <label class="custom-file-label" for="vat_certificate">Choose VAT Certificate</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="latitude" class="control-label">Latitude</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="number" name="latitude" id="latitude" class="form-control" placeholder="Latitude" step="any" required />
                                </div>
                            </div>
                            <div class="col">
                                <label for="longitude" class="control-label">Longitude</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-map-marker"></i></div>
                                    </div>
                                    <input type="number" class="form-control" name="longitude" id="longitude" placeholder="Longitude" step="any" required />
                                </div>
                            </div>
                            <div class="col">
                                <label for="mapLocation" class="control-label">Type Map Location</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-map"></i></div>
                                    </div>
                                    <input type="text" class="form-control" name="mapLocation" id="mapLocation" />
                                    <div class="input-group-prepend">
                                        <a href="#" class="btn btn-outline-primary" target="_blank" data-toggle="tooltip" data-placement="top" title="Get LatLng from Map"><i class="fa fa-location"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="note" class="control-label">Note:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" name="note" id="note" class="form-control" placeholder="Note" />
                        </div>
                    </div>
                </div><!-- Modal Body -->

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark mr-auto" data-dismiss="modal" tabindex="-1">Close</button>
                    <button type="submit" id="create_agent" class="btn btn-dark float-right"><i class="fa fa-plus" aria-hidden="true"></i> Save</button>
                </div><!-- Modal footer -->
            </form>
        </div>
    </div>
</div>
