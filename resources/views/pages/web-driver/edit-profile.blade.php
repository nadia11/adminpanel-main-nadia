<div class="profile-details">
    <p style="font-size: 30px; margin: 0 0 30px; font-weight: bold; color: #c0392b; border-bottom: 1px solid #ccc;">Edit Profile</p>

    <form action="{{ route('edit-profile-save') }}" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
    @csrf

        <div class="form-group">
            <label for="driver_name" class="control-label sr-only">Name (Block Letters)</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-user"></i></div>
                </div>
                <input type="text" class="form-control text-uppercase" name="driver_name" id="driver_name" placeholder="Driver Name" required />
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col">
                    <label for="division_id" class="control-label sr-only">Division</label>
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
                    <label for="district_id" class="control-label sr-only">District</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-th"></i></div>
                        </div>
                        <select id="district_id" name="district_id" class="custom-select" required>
                            <option value="">--District--</option>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <label for="branch_name" class="control-label sr-only">Name of the Branch</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-tag"></i></div>
                        </div>
                        <select id="branch_name" name="branch_name" class="custom-select" required>
                            <option value="">--Select Branch Name--</option>
                            <?php //$branches = array('Bagerhat', 'Bandarban', 'Barguna', 'Barishal', 'Bhola', 'Bogura', 'Brahmanbaria', 'Chandpur', 'Chapai_Nawabganj', 'Chattogram', 'Chuadanga', 'Cumilla', 'Coxs_Bazar', 'Dhaka_City', 'Dinajpur', 'Dohar_Nobabgonj', 'Faridpur', 'Feni', 'Gaibandha', 'Gazipur', 'Gopalgonj', 'Hobigonj', 'Jamalpur', 'Jashore', 'Jhalakati', 'Jhenaidah', 'Joypurhat', 'Khagrachari', 'Khulna', 'Kishoregonj', 'Kurigram', 'Kushtia', 'Lalmonirhat', 'Laxmipur', 'Madaripur', 'Magura', 'Manikgonj', 'Meherpur', 'Moulovibazar', 'Munshigonj', 'Naogaon', 'Narail', 'Narayangonj', 'Narsingdi', 'Natore', 'Netrakona', 'Nilphamari', 'Noakhali', 'Pabna', 'Panchagarh', 'Patuakhali', 'Pirojpur', 'Rajbari', 'Rajshahi', 'Rangamati', 'Rangpur', 'Sayedpur', 'Satkhira', 'Shariatpur', 'Sherpur', 'Sirajgonj', 'Sreemongal', 'Sunamgonj', 'Sylhet', 'Tangail', 'Thakurgaon'); asort($branches); ?>
                            {{--@php $branches = DB::table("bma_branches")->select("branch_name", "branch_id")->orderBy('branch_name', 'ASC')->pluck("branch_name", 'branch_id'); @endphp--}}
                            {{--@foreach( $branches as $branch )--}}
                            {{--<option value="{{ $branch }}">{{ $branch }}</option>--}}
                            {{--@endforeach--}}
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col">
                    <label for="mobile" class="control-label sr-only">Mobile No</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-phone"></i></div>
                        </div>
                        <input type="tel" class="form-control" id="mobile" name="mobile" placeholder="+8801XXX-XXXXXX" required />
                    </div>
                </div>
                <div class="col">
                    <label for="email" class="control-label sr-only">E-mail</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-envelope"></i></div>
                        </div>
                        <input type="email" class="form-control" name="email" id="email" placeholder="example@domain.com" />
                    </div>
                </div>
                <div class="col">
                    <label for="password" class="control-label sr-only">Password</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-lock"></i></div>
                        </div>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off" />
                        <div class="input-group-prepend"><button type="button" class="btn btn-outline-danger show_password" tabindex="-1"><i class="fa fa-eye" title="Show Password" aria-hidden="true"></i> <span class="showtext"></span></button></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col">
                    <label for="national_id" class="control-label sr-only">National ID</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-mobile"></i></div>
                        </div>
                        <input type="text" class="form-control" id="national_id" name="national_id" placeholder="National ID" required />
                    </div>
                </div>
                <div class="col">
                    <label for="driving_licence" class="control-label sr-only">Driving Licence</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-mobile"></i></div>
                        </div>
                        <input type="text" class="form-control" id="driving_licence" name="driving_licence" placeholder="Driving Licence" required />
                    </div>
                </div>
                <div class="col">
                    <label for="driver_photo" class="control-label sr-only">Driver Photo Upload</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-upload" aria-hidden="true"></i></div>
                        </div>
                        <div class="custom-file">
                            <input type="file" name="driver_photo" id="driver_photo" class="custom-file-input" accept=".png, .jpg, .jpeg">
                            <label class="custom-file-label" for="driver_photo">Choose Driver Photo</label>
                        </div>
                        <small style="width: 100%; text-align: left;">Max: 45mm high and 35mm wide, below 100 kb</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-6">
                    <label for="vehicle_type_id" class="control-label sr-only">Vehicle Type</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-tags"></i></div>
                        </div>
                        <select id="vehicle_type_id" name="vehicle_type_id" class="custom-select" required>
                            @php $vehicle_types = DB::table('vehicle_types')->orderBy('vehicle_type', 'ASC')->pluck("vehicle_type", "vehicle_type_id") @endphp

                            @foreach( $vehicle_types as $key => $type )
                                <option value="">--Vehicle Type--</option>
                                <option value="{{ $key }}">{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <label for="vehicle_model" class="control-label sr-only">Vehicle Model</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-motorcycle"></i></div>
                        </div>
                        <input type="text" class="form-control" id="vehicle_model" name="vehicle_model" placeholder="Vehicle Model" required />
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-6">

                </div>
                <div class="col-6">
                    <label for="vehicle_reg_number" class="control-label sr-only">Vehicle Reg. Number</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-tag"></i></div>
                        </div>
                        <input type="text" class="form-control" id="vehicle_reg_number" name="vehicle_reg_number" placeholder="Vehicle Reg. Number" required />
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-6">
                    <label for="vehicle_tax_token" class="control-label sr-only">Tax Token Number</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-tag"></i></div>
                        </div>
                        <input type="text" class="form-control" id="vehicle_tax_token" name="vehicle_tax_token" placeholder="Tax Token Number" required />
                    </div>
                </div>
                <div class="col-6">
                    <label for="tax_renewal_date" class="control-label sr-only">Tax Renewal Date</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                        <input type="datetime" class="form-control" id="tax_renewal_date" name="tax_renewal_date" placeholder="Tax Renewal Date" required />
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-6">
                    <label for="insurance_number" class="control-label sr-only">Insurance Number</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-tag"></i></div>
                        </div>
                        <input type="text" class="form-control" id="insurance_number" name="insurance_number" placeholder="Insurance Number" required />
                    </div>
                </div>
                <div class="col-6">
                    <label for="insurance_renewal_date" class="control-label sr-only">Insurance Renewal Date</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                        <input type="datetime" class="form-control" id="insurance_renewal_date" name="insurance_renewal_date" placeholder="Insurance Renewal Date" required />
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-6">
                    <label for="fitness_certificate" class="control-label sr-only">Fitness Certificate</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-mobile"></i></div>
                        </div>
                        <input type="text" class="form-control" id="fitness_certificate" name="fitness_certificate" placeholder="Fitness Certificate" required />
                    </div>
                </div>
                <div class="col-6">
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
        </div>

        <div class="form-group">
            <label for="vehicle_photo" class="control-label sr-only">Vehicle Photo Upload</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-upload" aria-hidden="true"></i></div>
                </div>
                <div class="custom-file">
                    <input type="file" name="vehicle_photo" id="vehicle_photo" class="custom-file-input" accept=".png, .jpg, .jpeg">
                    <label class="custom-file-label" for="vehicle_photo">Choose Vehicle Photo</label>
                </div>
                <small style="width: 100%; text-align: left;">Max: 45mm high and 35mm wide, below 100 kb</small>
            </div>
        </div>

        <button type="submit" class="btn btn-success text-right">Update Profile</button>
    </form>
</div>