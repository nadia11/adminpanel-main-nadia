<div class="row">
    <div class="col-lg-2 col-6 col-md-6">
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{ DB::table('drivers')->count() }}</h3>
                <p>Total Drivers</p>
            </div>
            <div class="icon"><i class="fad fa-biking"></i></div>
            <a href="{{ URL::to('driver/all-drivers') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->

    <div class="col-lg-2 col-6 col-md-6">
        <div class="small-box bg-tarquis">
            <div class="inner">
                <h3>{{ DB::table('drivers')->whereBetween('created_at', [Carbon\Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon\Carbon::now()->endOfWeek()->format('Y-m-d')])->count() }}</h3>
                <p>Driver Registered <br /> in this week</p>
            </div>
            <div class="icon"><i class="fa fa-biking"></i></div>
            <a href="{{ URL::to('driver/this-week-drivers') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->

    <div class="col-lg-2 col-6 col-md-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ DB::table('drivers')->where('approval_status', 'unapproved')->count() }}</h3>
                <p>Unapproved Drivers</p>
            </div>
            <div class="icon"><i class="fa fa-biking"></i></div>
            <a href="{{ URL::to('driver/unapproved-drivers') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->

    <div class="col-lg-2 col-6 col-md-6">
        <div class="small-box bg-primary-light">
            <div class="inner">
                <h3>{{ DB::table('riders')->where('rider_status', 'active')->count() }}</h3>
                <p>Total Riders</p>
            </div>
            <div class="icon"><i class="far fa-address-card"></i></div>
            <a href="{{ URL::to('rider/all-riders?rider_status=active') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->

    <div class="col-lg-2 col-6 col-md-6">
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{ DB::table('riders')->whereBetween('created_at', [Carbon\Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon\Carbon::now()->endOfWeek()->format('Y-m-d')])->count() }}</h3>
                <p>Riders Registered <br /> in this week</p>
            </div>
            <div class="icon"><i class="far fa-address-card"></i></div>
            <a href="{{ URL::to('rider/this-week-riders') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->

    <div class="col-lg-2 col-6 col-md-6">
        <div class="small-box bg-olive-active">
            <div class="inner">
                <h3>{{ DB::table('employees')->count() }}</h3>
                <p>Total Employees</p>
            </div>
            <div class="icon"><i class="fa fa-user-tie"></i></div>
            <a href="{{ URL::to('employee/employee-management') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->

    <div class="col-lg-2 col-6 col-md-6">
        <div class="small-box bg-coral box-multi-title">
            <div class="inner">
                <p>Total Bike <strong>{{ get_vehicle_count('Bike') }}</strong></p>
                <p>Bike Trips <strong>{{ get_vehicle_wise_trip_count('Bike') }}</strong></p>
            </div>
            <div class="icon"><i class="fad fa-motorcycle"></i></div>
            <a href="{{ URL::to('vehicle/vehicle-management?vehicle_type=Bike') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->

    <div class="col-lg-2 col-6 col-md-6">
        <div class="small-box bg-skirret-green box-multi-title">
            <div class="inner">
                <p>Total Car <strong>{{ get_vehicle_count('Car') }}</strong></p>
                <p>Car Trips <strong>{{ get_vehicle_wise_trip_count('Car') }}</strong></p>
            </div>
            <div class="icon"><i class="fa fa-cars"></i></div>
            <a href="{{ URL::to('vehicle/vehicle-management?vehicle_type=Car') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->

    <div class="col-lg-2 col-6 col-md-6">
        <div class="small-box bg-navy box-multi-title">
            <div class="inner">
                <p>Total Micro <strong>{{ get_vehicle_count('Micro') }}</strong></p>
                <p>Micro Trips <strong>{{ get_vehicle_wise_trip_count('Micro') }}</strong></p>
            </div>
            <div class="icon"><i class="fad fa-shuttle-van"></i></div>
            <a href="{{ URL::to('vehicle/vehicle-management?vehicle_type=Micro') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->

    <div class="col-lg-2 col-6 col-md-6">
        <div class="small-box bg-yellow box-multi-title">
            <div class="inner">
                <p>Total Pickup <strong>{{ get_vehicle_count('Pickup') }}</strong></p>
                <p>Pickup Trips <strong>{{ get_vehicle_wise_trip_count('Pickup') }}</strong></p>
            </div>
            <div class="icon"><i class="fad fa-truck-pickup"></i></div>
            <a href="{{ URL::to('vehicle/vehicle-management?vehicle_type=Pickup') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->

    <div class="col-lg-2 col-6 col-md-6">
        <div class="small-box bg-maroon-red box-multi-title">
            <div class="inner">
                <p>Total Ambulance <strong>{{ get_vehicle_count('Ambulance') }}</strong></p>
                <p>Ambulance Trips <strong>{{ get_vehicle_wise_trip_count('Ambulance') }}</strong></p>
            </div>
            <div class="icon"><i class="far fa-ambulance"></i></div>
            <a href="{{ URL::to('vehicle/vehicle-management?vehicle_type=Ambulance') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->

    <div class="col-lg-2 col-6 col-md-6">
        <div class="small-box bg-purple-light box-multi-title">
            <div class="inner">
                <h3>{{ DB::table('vehicles')->count() }}</h3>
                <p>Total Vehicles</p>
            </div>
            <div class="icon"><i class="fa fa-car"></i></div>
            <a href="{{ URL::to('vehicle/vehicle-management') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->

    <div class="col-lg-2 col-6 col-md-6">
        <div class="small-box bg-light-blue box-multi-title">
            <div class="inner">
                <p>Today's Trips <a href="{{ URL::to('rider-trip/rider-all-trips?todays_trip_filter='.date('d/m/Y')) }}" class="anchor">{{ DB::table('rider_trips')->whereDate('start_time', Carbon\Carbon::now()->format('Y-m-d'))->count() }}</a></p>
                <p>Today's Trip Search <a href="{{ URL::to('rider-trip/searching-trips?todays_trip_search_filter='.date('d/m/Y')) }}" class="anchor">{{ DB::table('searching_trips')->whereDate('searching_time', Carbon\Carbon::now()->format('Y-m-d'))->count() }}</a></p>
            </div>
        </div>
    </div><!-- ./col -->

    <div class="col-lg-2 col-6 col-md-6">
        <div class="small-box bg-aqua-light box-multi-title">
            <div class="inner">
                <p>This month's Trips <a href="{{ URL::to('rider-trip/rider-all-trips?this_month_trip_filter='.date('m/Y')) }}" class="anchor">{{ DB::table('rider_trips')->whereMonth('start_time', date('m'))->whereYear('start_time', date('Y'))->count() }}</a></p>
                <p>This month's Trip Search <a href="{{ URL::to('rider-trip/searching-trips?this_month_trip_search_filter='.date('m/Y')) }}" class="anchor">{{ DB::table('searching_trips')->whereMonth('searching_time', date('m'))->whereYear('searching_time', date('Y'))->count() }}</a></p>
            </div>
        </div>
    </div><!-- ./col -->

    <div class="col-lg-2 col-6 col-md-6">
        <div class="small-box bg-blue-active box-multi-title">
            <div class="inner">
                <p>Total Trips <a href="{{ URL::to('rider-trip/rider-all-trips') }}" class="anchor">{{ DB::table('rider_trips')->count() }}</a></p>
                <p>Total Trip Search <a href="{{ URL::to('rider-trip/searching-trips') }}" class="anchor">{{ DB::table('searching_trips')->count() }}</a></p>
            </div>
        </div>
    </div><!-- ./col -->

    <div class="col-lg-2 col-6 col-md-6">
        <div class="small-box bg-olive-deep">
            <div class="inner">
                <h3>{{ DB::table('rider_trips')->where('trip_status', 'booked')->count() }}</h3>
                <p>Booked Trips</p>
            </div>
            <div class="icon"><i class="fa fa-suitcase-rolling"></i></div>
            <a href="{{ URL::to('rider-trip/rider-all-trips?trip_status=booked') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->

    <div class="col-lg-2 col-6 col-md-6">
        <div class="small-box bg-purple">
            <div class="inner">
                <h3>{{ DB::table('rider_trips')->where('trip_status', 'completed')->count() }}</h3>
                <p>Completed Trips</p>
            </div>
            <div class="icon"><i class="fa fa-suitcase-rolling"></i></div>
            <a href="{{ URL::to('rider-trip/rider-all-trips?trip_status=completed') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->

    <div class="col-lg-2 col-6 col-md-6">
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{ DB::table('rider_trips')->where('trip_status', 'cancelled')->count() }}</h3>
                <p>Cancelled Trips</p>
            </div>
            <div class="icon"><i class="fa fa-suitcase-rolling"></i></div>
            <a href="{{ URL::to('rider-trip/rider-all-trips?trip_status=cancelled') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->

    <div class="col-lg-2 col-6 col-md-6">
        <div class="small-box bg-maroon">
            <div class="inner">
                <h3>{{ DB::table('agents')->count() }}</h3>
                <p>Total Agents</p>
            </div>
            <div class="icon"><i class="fa fa-handshake"></i></div>
            <a href="{{ URL::to('agent/agent-management') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->

    <div class="col-lg-2 col-6 col-md-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ DB::table('agents')->where('agent_status', 'pending')->count() }}</h3>
                <p>Pending Agents</p>
            </div>
            <div class="icon"><i class="fa fa-handshake"></i></div>
            <a href="{{ URL::to('agent/agent-management?agent_status=pending') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->

    <div class="col-lg-2 col-6 col-md-6">
        <div class="small-box bg-purple-deep">
            <div class="inner">
                <h3>৳0</h3>
                <p>Total Earnings</p>
            </div>
            <div class="icon"><i class="fa fa-dollar-sign"></i></div>
            <a href="{{ URL::to('') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->

    <div class="col-lg-2 col-6 col-md-6">
        <div class="small-box bg-aqua-light">
            <div class="inner">
                <h3><?php //$sms_balance = str_replace("Your Balance is:BDT ", "", file_get_contents('http://www.btssms.com/miscapi/'. 'C20000856085c9ce5b4456.32333811' .'/getBalance')); echo number_format($sms_balance / 0.60); ?></h3>
                <p>Remaining SMS</p>
            </div>
            <div class="icon"><i class="fal fa-sms"></i></div>
            <a href="{{ URL::to('/notification/sms') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->
</div>
