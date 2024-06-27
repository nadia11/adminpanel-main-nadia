<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use File;
use Illuminate\Support\Facades\Hash;
use App\CustomClass\Sms;
use Illuminate\Support\Facades\Log;

class ApiAndroidDriverController extends Controller
{
    public function divisionJson(Request $request)
    {

        $divisions = DB::table("divisions")->select("division_name", "division_id")->get();
        foreach ($divisions as $division) {

            $dist = []; //empty district data in each loop
            $districts = DB::table('districts')->where('division_id', $division->division_id)->select('district_name', 'district_id', 'division_id')->get();
            foreach ($districts as $district) {
                $dist[] = array('district_id' => $district->district_id, 'district_name' => $district->district_name);
            }

            $br = []; //empty district data in each loop
            $branches = DB::table('branches')->where('division_id', $division->division_id)->select('branch_name', 'branch_id')->get();
            foreach ($branches as $branch) {
                $br[] = array('branch_id' => $branch->branch_id, 'branch_name' => $branch->branch_name);
            }

            //Create JSON array with nested
            $div[] = array('division_id' => $division->division_id, 'division_name' => $division->division_name, 'districts' => $dist, 'branches' => $br);
        }
        return response()->json(['divisions' => $div], 200, ['Content-type' => 'application/json; charset=utf-8'], JSON_PRETTY_PRINT);
        //return response()->json( ['divisions'=>$div]);
    }



    public function login_by_mobile(Request $request)
    {
        if (DB::table('drivers')->where('mobile', $request->mobile)->doesntExist()) {
            return response()->json([
                'message' => "Incorrect Mobile Number. Please try again.",
                'code' => 501
            ]);
        } else {
            $driver = DB::table('drivers')->where('mobile', $request->mobile)->select('driver_id', 'driver_name', 'email', 'mobile', 'driver_photo')->first();

            if ($request->mobile === $driver->mobile) {
                return response()->json(
                    array(
                        'message' => "Login Successful.",
                        'code' => 200,
                        'user_id' => $driver->driver_id,
                        'user_name' => $driver->driver_name,
                        'user_email' => $driver->email, /*** from request ***/
                        'user_mobile' => $driver->mobile,
                        'user_image' => isset($driver->driver_photo) ? url("/storage/driver-photo/" . $driver->driver_photo) : image_url('defaultAvatar.jpg'),
                        'driver_status' => $driver->driver_status,
                        'profile_status' => $driver->profile_status
                    )
                );
            }
        }
    }


    //    public function login(Request $request){
//        $loginDetails = $request->only('email', 'password');
//        //Auth::attempt(['email' => 'someemail', 'password' => 'myplainpassword']);
//
//        if(Auth::attempt($loginDetails)){
//            return response()->json(['message'=>'Login successful', 'code'=>200]);
//        }else{
//            return response()->json(['message'=> 'Incorrect Username or Password. Please try again.', 'code'=>501]);
//        }
//    }


    public function login_by_email(Request $request)
    {
        if (DB::table('drivers')->where('email', $request->email)->doesntExist()) {
            return response()->json(['code' => 501, 'message' => "Incorrect Username or Password. Please try again."]);
        }

        $driver = DB::table('drivers')->where('email', $request->email)->select('driver_id', 'driver_name', 'email', 'mobile', 'driver_photo', 'driver_status', 'profile_status', 'password')->first();

        if (Hash::check($request->password, $driver->password) && $request->email === $driver->email) {
            return response()->json(
                array(
                    'message' => "Login Successful.",
                    'code' => 200,
                    'user_id' => $driver->driver_id,
                    'user_name' => $driver->driver_name,
                    'user_email' => $driver->email, /*** from request ***/
                    'user_mobile' => $driver->mobile,
                    'user_image' => isset($driver->driver_photo) ? url("/storage/driver-photo/" . $driver->driver_photo) : image_url('defaultAvatar.jpg'),
                    'driver_status' => $driver->driver_status,
                    'profile_status' => $driver->profile_status
                )
            );
        } else {
            return response()->json([
                'code' => 501,
                'message' => "Incorrect Username or Password. Please try again."
            ]);
        }
    }

    public function registration_by_mobile(Request $request)
    {
        error_log($request);
        $mobile = json_encode($request->mobile);

        if (DB::table('drivers')->where('mobile', $mobile)->exists()) {
            $driver = DB::table('drivers')->where('mobile', $mobile)->select('driver_name', 'driver_status', 'profile_status')->first();

            return response()->json([
                'message' => "Already registered this Mobile Number. Please Login.",
                'code' => 501,
                'user_name' => $driver->driver_name,
                'mobile' => $mobile,
                'driver_status' => $driver->driver_status,
                'profile_status' => $driver->profile_status
            ]);
        } else {
            return response()->json(
                array(
                    'message' => "Checking Successful. Mobile number not exist.",
                    'code' => 200,
                )
            );
        }
    }


    public function submit_driver_partial_form(Request $request)
    {
        if (DB::table('drivers')->where('mobile', $request->mobile)->exists()) {
            return response()->json([
                'message' => "Already registered this Mobile Number. Please Login.",
                'code' => 501
            ]);
        } else {
            $driver_data = array(
                'mobile' => $request->mobile,
                'gender' => $request->gender,
                'division_id' => $request->division_id,
                'district_id' => $request->district_id,
                'branch_id' => $request->branch_id,
                'driving_licence' => $request->driving_licence,
                'referrer_commission_status' => "Not Assigned",
                'driver_status' => "pending",
                'profile_status' => "incomplete",
                'approval_status' => "unapproved",
                'reg_date' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
            );
            $driver_id = DB::table('drivers')->insertGetId($driver_data);

            $vehicle_data = array(
                'driver_id' => $driver_id,
                'vehicle_type_id' => $request->vehicle_type_id,
                'manufacturer' => $request->manufacturer,
                'vehicle_model' => $request->model,
                'model_year' => $request->year,
                'vehicle_reg_number' => $request->vehicle_reg_number,
                'vehicle_tax_token' => $request->vehicle_tax_token,
                'tax_renewal_date' => Carbon::createFromFormat('d/m/Y', $request->tax_renewal_date)->format('Y-m-d H:i:s'),
                'insurance_number' => $request->insurance_number,
                'insurance_renewal_date' => Carbon::createFromFormat('d/m/Y', $request->insurance_renewal_date)->format('Y-m-d H:i:s'),
                'fitness_certificate' => $request->fitness_certificate,
                'created_at' => date('Y-m-d H:i:s'),
            );
            $success = DB::table('vehicles')->insert($vehicle_data);

            if ($success) {
                return response()->json(
                    array(
                        'message' => "Partial Form submitted successfully. Redirecting to Sign up form.",
                        'code' => 200
                    )
                );
            }
        }
    }


    public function submit_driver_form(Request $request)
    {
        if (DB::table('drivers')->where('email', $request->email)->doesntExist()) {
            $max_id = DB::table('drivers')->where('mobile', $request->mobile)->value('driver_id');

            $data = array(
                'driver_name' => $request->full_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'gender' => $request->gender,
                'date_of_birth' => Carbon::createFromFormat('d/m/Y', $request->date_of_birth)->format('Y-m-d H:i:s'),
                'national_id' => $request->national_id,
                //'referral_name'   => $request->referral_name,
                'referral_code' => $request->referral_code,
                'referral_mobile' => $request->referral_mobile,
                'referrer_commission_status' => "Not Received",
                'invitation_code' => "DR" . GENERATE_INVITATION_CODE(8),
                'driver_status' => "pending",
                'profile_status' => "complete",
                'approval_status' => "unapproved",
                'reg_date' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
            );

            //your base64 encoded
            if ($request->file_name !== 'no_image') {
                $image = $request->user_image;
                $image = str_replace('data:image/jpeg;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                //$imageName = str_random(10).'.'.'jpg';

                $request_file = $request->file_name;
                $info = pathinfo($request_file);
                //$file_name =  basename($file,'.'.$info['extension']);
                //dd(end(explode('.', $request->file_name)));
                $extension = $info['extension'];
                $file_name = $max_id . "_" . strtolower(slug_to_title($request->user_name)) . "." . $extension;

                //Storage::put('public/uploads/driver-photo/'.$file_name, base64_decode($image));
                Storage::disk('local')->put("/public/driver-photo/" . $file_name, base64_decode($image));
                $data['driver_photo'] = $file_name;
            }

            DB::table('drivers')->where('mobile', $request->mobile)->update($data);


            DB::table('referrals')->insert(
                array(
                    'referral_code' => DB::table('drivers')->where('national_id', $request->national_id)->value('invitation_code'),
                    'referral_nid' => $request->referral_nid,
                    'referrer_type' => "Driver",
                    'created_at' => date('Y-m-d H:i:s'),
                )
            );

            return response()->json(
                array(
                    'message' => "User Registration Completed Successfully.",
                    'user_image' => $request->file_name !== 'no_image' ? url("/storage/driver-photo/" . $data['driver_photo']) : "",
                    'code' => 200
                )
            );
        } else {
            return response()->json([
                'message' => "Email already registered. Please change this.",
                'code' => 501
            ]);
        }
    }


    public function send_password_reset_code_email(Request $request)
    {
        $reset_code = generateRandomString(10);

        if (DB::table('drivers')->where('email', $request->email)->doesntExist()) {
            return response()->json([
                'message' => "Incorrect Email Address. Please try again.",
                'code' => 501
            ]);
        } else {
            $data = array(
                'reset_code' => $reset_code,
                'updated_at' => date('Y-m-d H:i:s'),
            );
            DB::table('drivers')->where('email', $request->email)->update($data);

            /************* Send Email ********/
            /************* d ********/
            /************* d ********/
            /************* d ********/
            /************* d ********/

            return response()->json(
                array(
                    'message' => "Send Password Reset Link to Your Email. (" . $request->email . ") Successfully.",
                    'code' => 200,
                    'reset_code' => $reset_code,
                    'user_email' => $request->email,
                )
            );

        }
    }

    public function verify_password_reset_code(Request $request)
    {
        $reset_code = DB::table('drivers')->where('email', $request->email)->value('reset_code');

        if ($request->reset_code === $reset_code) {
            return response()->json([
                'message' => "You have successfully verified your email address.",
                'code' => 200,
                'user_email' => $request->email,
            ]);
        } else {
            return response()->json(
                array(
                    'message' => "Invalid Reset Code. Please try again.",
                    'code' => 501
                )
            );
        }
    }

    public function password_reset_form_submit(Request $request)
    {
        $data = array(
            'password' => bcrypt($request->password),
            'reset_date' => date('Y-m-d H:i:s'),
        );
        $success = DB::table('drivers')->where('email', $request->email)->update($data);

        if ($success) {
            return response()->json(
                array(
                    'message' => "Your Password changed successfully. Redirecting to Login Page.",
                    'code' => 200
                )
            );
        }
    }


    public function change_password_form_submit(Request $request)
    {
        if (DB::table('drivers')->where('email', $request->email)->doesntExist()) {
            return response()->json(['code' => 501, 'message' => "Invalid Email Address. Please try again."]);
        }

        $drivers = DB::table('drivers')->where('email', $request->email)->select('driver_id', 'driver_name', 'email', 'mobile', 'password')->first();

        if (Hash::check($request->oldPassword, $drivers->password) && $request->email === $drivers->email) {
            $success = DB::table('drivers')->where('email', $request->email)->update(
                array(
                    'password' => bcrypt($request->password),
                    'password_change_date' => date('Y-m-d H:i:s'),
                )
            );

            if ($success) {
                return response()->json(['message' => "Your Password changed successfully.", 'code' => 200]);
            }
        } else {
            return response()->json([
                'code' => 501,
                'message' => "Incorrect Old Password. Please try again."
            ]);
        }
    }


    public function get_driver_data_to_update_form($mobile)
    {
        $drivers = DB::table('drivers')->where('mobile', $mobile)->select('driver_name', 'mobile', 'email', 'date_of_birth', 'gender', 'driver_photo')->first();

        if ($drivers) {
            return response()->json(
                array(
                    'code' => 200,
                    'user_name' => $drivers->driver_name,
                    'mobile' => $drivers->mobile,
                    'email' => $drivers->email,
                    'date_of_birth' => $drivers->date_of_birth ? $drivers->date_of_birth : "",
                    //'date_of_birth'         => $drivers->date_of_birth ? Carbon::createFromFormat('Y-m-d', $drivers->date_of_birth )->format('d/m/Y') : "",
                    'gender' => $drivers->gender,
                    'user_image' => url("storage/driver-photo/" . $drivers->driver_photo),
                )
            );
        } else {
            return response()->json(
                array(
                    'code' => 501,
                    'message' => 'No Data Found in this table.'
                )
            );
        }
    }


    public function update_profile_form(Request $request)
    {
        $max_id = DB::table('drivers')->where('mobile', $request->mobile)->value('driver_id');
        Log::info($max_id);
        $data = array(
            'driver_name' => $request->user_name,
            'date_of_birth' => $request->date_of_birth ? Carbon::createFromFormat('d/m/Y', $request->date_of_birth)->format('Y-m-d H:i:s') : "",
            //'blood_group'   => $request->blood_group,
            'gender' => $request->gender,
            'updated_at' => date('Y-m-d H:i:s'),
        );
        Log::info($request->file_name);
        //your base64 encoded   
        if ($request->file_name !== 'no_image') {
            $image = $request->user_image;
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            //$imageName = str_random(10).'.'.'jpg';
            Log::info($image);
            $request_file = $request->file_name;
            $info = pathinfo($request_file);
            Log::info($info);
            //$file_name =  basename($file,'.'.$info['extension']);
            //dd(end(explode('.', $request->file_name)));
            $extension = $info['extension'];
            $file_name = $max_id . "_" . strtolower(slug_to_title($request->user_name)) . "." . $extension;
            Log::info($file_name);
            //Storage::put('public/uploads/driver-photo/'.$file_name, base64_decode($image));
            Storage::disk('local')->put("/public/driver-photo/" . $file_name, base64_decode($image));
            $data['driver_photo'] = $file_name;
        }

        DB::table('drivers')->where('mobile', $request->mobile)->update($data);
        return response()->json(
            array(
                'message' => "Update profile Successfully.",
                'user_image' => $request->file_name !== 'no_image' ? url("/storage/driver-photo/" . $data['driver_photo']) : "",
                'code' => 200
            )
        );
    }

    public function change_driver_status(Request $request)
    {
        DB::table('drivers')->where('email', $request->email)->update(
            array(
                'driver_status' => $request->driver_status,
                'latitude' => number_format($request->latitude, 7),
                'longitude' => number_format($request->longitude, 7),
                'marker_heading' => number_format($request->marker_heading, 7)
            )
        );

        return response()->json(
            array(
                'message' => "Driver Status changed successfully.",
                'code' => 200,
                'driver_status' => $request->driver_status
            )
        );
    }

    public function get_driver_data($mobile)
    {
        $drivers = DB::table('drivers')->where('mobile', $mobile)->select('driver_name', 'mobile', 'email', 'date_of_birth', 'blood_group', 'gender', 'driver_photo', 'wallet_balance')->first();

        if ($drivers) {
            return response()->json(
                array(
                    'code' => 200,
                    'driver_name' => $drivers->driver_name,
                    'mobile' => $drivers->mobile,
                    'email' => $drivers->email,
                    'date_of_birth' => $drivers->date_of_birth,
                    'blood_group' => $drivers->blood_group,
                    'gender' => $drivers->gender,
                    'driver_photo' => $drivers->driver_photo,
                    'wallet_balance' => $drivers->wallet_balance,
                )
            );
        } else {
            return response()->json(
                array(
                    'code' => 501,
                    "message" => 'No Data Found in this table.'
                )
            );
        }
    }

    public function get_requested_rider_info($trip_number)
    {
        $trip_info = DB::table('rider_trips')->where('trip_number', $trip_number)->first();
        $rider_data = DB::table('riders')->where('rider_id', $trip_info->rider_id)->select('rider_name', 'mobile', 'rider_photo', 'ratings', 'gender')->first();

        if ($rider_data) {
            return response()->json(
                array(
                    'code' => 200,
                    'rider_name' => $rider_data->rider_name,
                    'rider_mobile' => $rider_data->mobile,
                    'rider_photo' => $rider_data->rider_photo ? url("/storage/rider-photo/" . $rider_data->rider_photo) : "",
                    'rider_ratings' => $rider_data->ratings,
                    'pickup_location' => $trip_info->trip_from,
                    'drop_off_location' => $trip_info->trip_to,
                    'distance' => $trip_info->distance,
                    'total_fare' => $trip_info->fare
                )
            );
        } else {
            return response()->json(array('code' => 501, "message" => 'No Data Found in this table.'));
        }
    }

    public function cancel_request_by_driver(Request $request)
    {
        $cancellation_data = array(
            'reason_for_cancellation' => $request->reason_for_cancellation,
            'trip_status' => 'cancelled',
            'cancelled_by' => 'Driver',
            'cancellation_time' => date('Y-m-d H:i:s'),
        );
        DB::table('driver_trips')->where('trip_number', $request->trip_number)->update($cancellation_data);
        DB::table('rider_trips')->where('trip_number', $request->trip_number)->update($cancellation_data);


        DB::table('driver_trip_steps')->insert(
            array(
                'trip_number' => $request->trip_number,
                'step_name' => 'Cancelled By Driver',
                'specification' => $request->reason_for_cancellation,
                'step_time' => date('Y-m-d H:i:s'),
                'location_name' => '',
                'latitude' => number_format($request->latitude, 7),
                'longitude' => number_format($request->longitude, 7),
                'created_at' => date('Y-m-d H:i:s'),
            )
        );

        DB::table('drivers')->where('email', $request->email)->update(
            array(
                'driver_status' => "active",
                'latitude' => number_format($request->latitude, 7),
                'longitude' => number_format($request->longitude, 7),
                'marker_heading' => number_format($request->marker_heading, 7)
            )
        );

        return response()->json(
            array(
                'message' => "Cancelled Trip by Driver successfully.",
                'code' => 200,
                'driver_status' => 'active'
            )
        );
    }

    public function assign_driver_to_rider_trip(Request $request)
    {
        Log::info($request);
        $driver_info = DB::table('drivers')->where('email', $request->email)->select('driver_id', 'driver_name', 'mobile')->first();
        $vehicles = DB::table('vehicles')->where('driver_id', $driver_info->driver_id)->select('vehicle_id', 'vehicle_type_id', 'vehicle_reg_number')->first();
        $trip_data = DB::table('rider_trips')->where('trip_number', $request->trip_number)->first();
        $rider_data = DB::table('riders')->where('rider_id', $trip_data->rider_id)->select('rider_name', 'mobile', 'rider_photo', 'ratings', 'gender')->first();

        DB::table('rider_trips')->where('trip_number', $request->trip_number)->update(
            array(
                'driver_id' => $driver_info->driver_id,
                'trip_status' => "active",
                'vehicle_id' => $vehicles->vehicle_id,
                'vehicle_type_id' => $vehicles->vehicle_type_id
            )
        );

        DB::table('driver_trips')->insert(
            array(
                'trip_number' => $request->trip_number,
                'trip_from' => $trip_data->trip_from,
                'trip_to' => $trip_data->trip_to,
                'start_time' => $trip_data->start_time,
                'end_time' => null,
                'distance' => $trip_data->distance,
                'fare' => $trip_data->fare,
                'payment_method' => $trip_data->payment_method,
                'payment_amount' => $trip_data->payment_amount,
                'payment_status' => $trip_data->payment_status,
                'origin_lat' => number_format($trip_data->origin_lat, 7),
                'origin_long' => number_format($trip_data->origin_long, 7),
                'destination_lat' => number_format($trip_data->destination_lat, 7),
                'destination_long' => number_format($trip_data->destination_long, 7),
                'rider_id' => $trip_data->rider_id,
                'driver_id' => $driver_info->driver_id,
                'trip_status' => "active",
                'vehicle_id' => $vehicles->vehicle_id,
                'vehicle_type_id' => $vehicles->vehicle_type_id,
                'created_at' => date('Y-m-d H:i:s'),
                'destination_change_fee' => $trip_data->destination_change_fee,
                'delay_cancellation_minute' => $trip_data->delay_cancellation_minute,
                'delay_cancellation_fee' => $trip_data->delay_cancellation_fee,
                'cancelled_by' => $trip_data->cancelled_by,
                'reason_for_cancellation' => $trip_data->reason_for_cancellation,
                'cancellation_time' => $trip_data->cancellation_time,
            )
        );

        DB::table('driver_trip_steps')->insert(
            array(
                'trip_number' => $request->trip_number,
                'step_name' => 'Driver Assigned',
                'specification' => 'Assign Driver to Trip ' . $request->trip_number,
                'step_time' => date('Y-m-d H:i:s'),
                'location_name' => '',
                'latitude' => number_format($request->latitude, 7),
                'longitude' => number_format($request->longitude, 7),
                'created_at' => date('Y-m-d H:i:s'),
            )
        );

        DB::table('drivers')->where('email', $request->email)->update(
            array(
                'driver_status' => 'on_trip',
                'latitude' => number_format($request->latitude, 7),
                'longitude' => number_format($request->longitude, 7),
                'marker_heading' => number_format($request->marker_heading, 7)
            )
        );

        if ($rider_data) {
            //Send Driver Information to rider through SMS.
            Sms::send_sms('Esojai Driver Info', $rider_data->mobile, "Driver Accept your Ride Request. Driver Name: " . $driver_info->driver_name . ", Mobile: " . $driver_info->mobile . ", Date: " . date('d.m.Y h:i A', strtotime($trip_data->start_time)) . ", Trip Number: " . $request->trip_number . ', Vehicle:' . $vehicles->vehicle_reg_number . ', Distance:' . $trip_data->distance . ', Duration:' . $trip_data->duration . ', Fare: Tk.' . $trip_data->fare);

            //Send Rider Information to Driver through SMS.
            Sms::send_sms('Rider Trip Info', $driver_info->mobile, "Rider Information. Name:" . $rider_data->rider_name . ", Mobile:" . $rider_data->mobile . ", Date: " . date('d.m.Y h:i A', strtotime($trip_data->start_time)) . ", Trip Number:" . $request->trip_number . ', Trip From:' . $trip_data->trip_from . ", Trip to:" . $trip_data->trip_to . ', Distance:' . $trip_data->distance . ', Duration:' . $trip_data->duration . ', Fare: Tk.' . $trip_data->fare);

            return response()->json(
                array(
                    'code' => 200,
                    'message' => 'Driver assigned successful.',
                    'rider_name' => $rider_data->rider_name,
                    'rider_mobile' => $rider_data->mobile,
                    'rider_gender' => $rider_data->gender,
                    'rider_photo' => $rider_data->rider_photo ? url("/storage/rider-photo/" . $rider_data->rider_photo) : "",
                    'rider_ratings' => $rider_data->ratings,

                    'distance' => $trip_data->distance,
                    'duration' => $trip_data->duration,
                    'total_fare' => $trip_data->fare,
                    'pickup_location' => $trip_data->trip_from,
                    'drop_off_location' => $trip_data->trip_to,
                    'origin_lat' => $trip_data->origin_lat,
                    'origin_long' => $trip_data->origin_long,
                    'destination_lat' => $trip_data->destination_lat,
                    'destination_long' => $trip_data->destination_long,
                    'rider_picture_path' => url("/storage/rider-photo")
                )
            );
        } else {
            return response()->json(array('code' => 501, "message" => 'No Data Found in this table.'));
        }
    }

    public function arrive_driver_to_rider_location(Request $request)
    {
        DB::table('drivers')->where('email', $request->email)->update(
            array(
                'driver_status' => 'on_trip',
                'latitude' => number_format($request->latitude, 7),
                'longitude' => number_format($request->longitude, 7),
                'marker_heading' => number_format($request->marker_heading, 7),
            )
        );

        DB::table('driver_trip_steps')->insert(
            array(
                'trip_number' => $request->trip_number,
                'step_name' => 'Driver Arrived',
                'specification' => 'Driver arrived to Rider Location.',
                'step_time' => date('Y-m-d H:i:s'),
                'location_name' => '',
                'latitude' => number_format($request->latitude, 7),
                'longitude' => number_format($request->longitude, 7),
                'created_at' => date('Y-m-d H:i:s'),
            )
        );

        return response()->json(
            array(
                'message' => "Driver Arrived to Rider Location.",
                'code' => 200,
                'driver_status' => 'on_trip'
            )
        );
    }

    public function start_trip(Request $request)
    {
        DB::table('rider_trips')->where('trip_number', $request->trip_number)->update(
            array(
                'trip_status' => 'active'
            )
        );

        DB::table('drivers')->where('email', $request->email)->update(
            array(
                'driver_status' => 'on_trip',
                'latitude' => number_format($request->latitude, 7),
                'longitude' => number_format($request->longitude, 7),
                'marker_heading' => number_format($request->marker_heading, 7)
            )
        );

        DB::table('driver_trip_steps')->insert(
            array(
                'trip_number' => $request->trip_number,
                'step_name' => 'Start Trip',
                'specification' => 'Trip Started from Rider Location.',
                'step_time' => date('Y-m-d H:i:s'),
                'location_name' => '',
                'latitude' => number_format($request->latitude, 7),
                'longitude' => number_format($request->longitude, 7),
                'created_at' => date('Y-m-d H:i:s'),
            )
        );

        return response()->json(
            array(
                'message' => "Start Trip successfully.",
                'code' => 200,
                'driver_status' => 'on_trip'
            )
        );
    }

    public function calculateFare($baseFare, $timeRate, $distanceRate, $time, $distance, $surge)
    {
        $distanceInKm = $distance * 0.001; /*1KM 1000 Meter --  1÷1000 */
        $pricePerKm = $distanceRate * $distanceInKm;
        $timeInMin = $time * 0.0166667; /* 1÷60 */
        $pricePerMinute = $timeRate * $timeInMin;
        $totalFare = ($baseFare + $pricePerKm + $pricePerMinute) * $surge;
        return floor($totalFare);
    }

    public function complete_trip(Request $request)
    {
        $vehicle_type_id = DB::table('driver_trips')->where('trip_number', $request->trip_number)->value('vehicle_type_id');
        $fares = DB::table('fares')->where('vehicle_type_id', $vehicle_type_id)->first();

        $total_fare = $fares !== null ? $this->calculateFare($fares->minimum_fare, $fares->waiting_fare, $fares->fare_per_km, $request->end_duration_value, $request->end_distance_value, 1) : "";

        $last_data = array(
            'trip_status' => 'completed',
            'distance' => $request->end_distance_text,
            'duration' => $request->end_duration_text,
            'fare' => $total_fare,
            'end_lat' => number_format($request->end_latitude, 7),
            'end_long' => number_format($request->end_longitude, 7),
            'end_drop_off_location' => $request->end_drop_off_location,
            'end_time' => date('Y-m-d H:i:s'),
        );

        DB::table('rider_trips')->where('trip_number', $request->trip_number)->update($last_data);
        DB::table('driver_trips')->where('trip_number', $request->trip_number)->update($last_data);

        DB::table('drivers')->where('email', $request->email)->update(
            array(
                'driver_status' => 'active',
                'latitude' => number_format($request->end_latitude, 7),
                'longitude' => number_format($request->end_longitude, 7),
                'marker_heading' => number_format($request->marker_heading, 7)
            )
        );

        DB::table('driver_trip_steps')->insert(
            array(
                'trip_number' => $request->trip_number,
                'step_name' => 'Trip Completed',
                'specification' => 'Trip Started from Rider Location.',
                'step_time' => date('Y-m-d H:i:s'),
                'location_name' => $request->end_drop_off_location,
                'latitude' => number_format($request->end_latitude, 7),
                'longitude' => number_format($request->end_longitude, 7),
                'created_at' => date('Y-m-d H:i:s'),
            )
        );


        $trip_data_payment_screen = DB::table('driver_trips')->where('trip_number', $request->trip_number)->first();
        $trip_data = DB::table('rider_trips')->where('trip_number', $request->trip_number)->first();
        $branch_id = DB::table('drivers')->where('driver_id', $trip_data_payment_screen->driver_id)->value('branch_id');
        $agent_id = DB::table('agents')->where('branch_id', $branch_id)->first();

        $agency_commission_percent = DB::table('commissions')->where('commission_name', 'Agency Commission')->value('commission_percent');
        $agent_commission_percent = DB::table('commissions')->where('commission_name', 'Agent Commission')->value('commission_percent');
        $agency_commission_amount = ($total_fare * $agency_commission_percent) / 100;
        $agent_commission_amount = ($total_fare * $agent_commission_percent) / 100;

        DB::table('driver_earnings')->insert(
            array(
                'driver_id' => $trip_data_payment_screen->driver_id,
                'trip_number' => $request->trip_number,
                'payment_mode' => $trip_data->payment_method,
                'created_at' => date('Y-m-d H:i:s'),
                'distance' => $request->end_distance_text,
                'payment_status' => 'unpaid',
                'vehicle_id' => $trip_data->vehicle_id,
                'vehicle_type_id' => $vehicle_type_id,
                'total_fare' => $total_fare,
                'agent_commission' => number_format($agent_commission_amount, 2),
                'agency_commission' => number_format($agency_commission_amount, 2),
                'total_earnings' => number_format($total_fare - $agent_commission_amount - $agency_commission_amount, 2)
            )
        );

        DB::table('agency_commissions')->insert(
            array(
                'trip_number' => $request->trip_number,
                'trip_from' => $trip_data->trip_from,
                'trip_to' => $trip_data->trip_to,
                'origin_lat' => number_format($trip_data->origin_lat, 7),
                'origin_long' => number_format($trip_data->origin_long, 7),
                'distance' => $request->end_distance_text,
                'duration' => $request->end_duration_text,
                'end_lat' => number_format($request->end_latitude, 7),
                'end_long' => number_format($request->end_longitude, 7),
                'end_drop_off_location' => $request->end_drop_off_location,
                'total_fare' => $total_fare,
                'commission_percent' => $agency_commission_percent,
                'commission' => number_format($agency_commission_amount, 2),
                'trip_date' => date('Y-m-d H:i:s'),
                'rider_id' => $trip_data->rider_id,
                'driver_id' => $trip_data->driver_id,
                'vehicle_id' => $trip_data->vehicle_id,
                'vehicle_type_id' => $trip_data->vehicle_type_id,
                'payment_status' => 'unpaid',
                'created_at' => date('Y-m-d H:i:s')
            )
        );

        DB::table('agent_commissions')->insert(
            array(
                'agent_id' => $agent_id,
                'branch_id' => $branch_id,
                'trip_number' => $request->trip_number,
                'trip_from' => $trip_data->trip_from,
                'trip_to' => $trip_data->trip_to,
                'origin_lat' => number_format($trip_data->origin_lat, 7),
                'origin_long' => number_format($trip_data->origin_long, 7),
                'distance' => $request->end_distance_text,
                'duration' => $request->end_duration_text,
                'end_lat' => number_format($request->end_latitude, 7),
                'end_long' => number_format($request->end_longitude, 7),
                'end_drop_off_location' => $request->end_drop_off_location,
                'total_fare' => $total_fare,
                'commission_percent' => $agency_commission_percent,
                'commission' => number_format($agency_commission_amount, 2),
                'trip_date' => date('Y-m-d H:i:s'),
                'rider_id' => $trip_data->rider_id,
                'driver_id' => $trip_data->driver_id,
                'vehicle_id' => $trip_data->vehicle_id,
                'vehicle_type_id' => $trip_data->vehicle_type_id,
                'payment_status' => 'unpaid',
                'created_at' => date('Y-m-d H:i:s'),
            )
        );

        return response()->json(
            array(
                'code' => 200,
                'message' => $trip_data_payment_screen,
                'delay_cancellation_fee' => $trip_data->delay_cancellation_fee,
                'destination_change_fee' => $trip_data->destination_change_fee,
                'driver_status' => 'active',
            )
        );
    }

    public function payment_collect(Request $request)
    {
        if (DB::table('driver_trips')->where('trip_number', $request->trip_number)->doesntExist()) {
            return response()->json([
                'message' => "Trip Number does not exist.",
                'code' => 501
            ]);
        } else {
            $last_data = array(
                'payment_status' => 'paid',
                'payment_amount' => $request->payment_amount,
                'payment_method' => $request->payment_method,
            );

            DB::table('rider_trips')->where('trip_number', $request->trip_number)->update($last_data);
            DB::table('driver_trips')->where('trip_number', $request->trip_number)->update($last_data);

            return response()->json(
                array(
                    'message' => "Payment Collected successfully.",
                    'code' => 200
                )
            );
        }
    }

    public function send_feedback_to_rider(Request $request)
    {
        DB::table('rider_trips')->where('trip_number', $request->trip_number)->update(
            array(
                'trip_ratings' => number_format($request->trip_ratings, 2),
                'rating_text' => number_format($request->trip_ratings, 2)
            )
        );
        $rider_id = DB::table('rider_trips')->where('trip_number', $request->trip_number)->value('rider_id');

        DB::table('riders')->where('rider_id', $rider_id)->update(
            array(
                'ratings' => number_format($request->trip_ratings / 5, 2),
            )
        );

        return response()->json(
            array(
                'message' => "Send Feedback successfully.",
                'code' => 200
            )
        );
    }

    public function get_wallet_balance($mobile)
    {
        if (DB::table('drivers')->where('mobile', $mobile)->doesntExist()) {
            return response()->json([
                'message' => "Drivers not exist.",
                'code' => 501
            ]);
        } else {
            $wallet_balance = DB::table('drivers')->where('mobile', $mobile)->value('wallet_balance');

            return response()->json(
                array(
                    'wallet_balance' => taka_format("", $wallet_balance),
                    'code' => 200,
                )
            );
        }
    }

    public function save_android_device_token_to_database(Request $request)
    {
        if (DB::table('notification_devices')->where('mobile', $request->mobile)->doesntExist()) {
            $email = DB::table('drivers')->where('mobile', $request->mobile)->value('email');

            DB::table('notification_devices')->insert(
                array(
                    'mobile' => $request->mobile,
                    'email' => $email,
                    'device_user_type' => 'driver',
                    'fcm_token' => $request->fcm_token,
                    'device_status' => 'active',
                    'created_at' => date('Y-m-d H:i:s'),
                )
            );

            return response()->json(['code' => 200, 'message' => "Successfully saved fcm token to database."]);
        } else {
            DB::table('notification_devices')->where('mobile', $request->mobile)->update(
                array(
                    'fcm_token' => $request->fcm_token,
                    'device_status' => 'active',
                )
            );

            return response()->json(['code' => 501, 'message' => "Successfully updated fcm token to database."]);
        }
    }

    public function update_all_driver_route(Request $request)
    {

        DB::table('drivers')->where('email', $request->email)->update(
            array(
                'latitude' => number_format($request->latitude, 7),
                'longitude' => number_format($request->longitude, 7),
                'marker_heading' => number_format($request->marker_heading, 7)
            )
        );

        return response()->json(
            array(
                'message' => "Driver Location Updated successfully.",
                'code' => 200
            )
        );
    }

    public function save_trip_map_snapshot(Request $request)
    {
        if ($request->trip_number) {
            $image = $request->snaphot_url;
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $file_name = $request->trip_number . "." . $request->extension;
            Storage::put('/public/trip-map/' . $file_name, base64_decode($image));
            //Storage::disk('local')->put("/storage/trip-map/".$file_name, base64_decode($image));
        }

        return response()->json(
            array(
                'message' => "Update Driver Location Successfully.",
                'code' => 200
            )
        );
    }

    public function get_driver_todays_summery($mobile)
    {
        $driver_id = DB::table('drivers')->where('mobile', $mobile)->value('driver_id');
        $todays_earnings = DB::table('driver_earnings')->where('driver_id', $driver_id)->whereDate('created_at', Carbon::today()->format('Y-m-d'))->sum('total_earnings');
        $driver_trips = DB::table('driver_trips')->where('driver_id', $driver_id)->whereDate('created_at', Carbon::today()->format('Y-m-d'));
        $todays_trips = $driver_trips->count();
        $todays_distance = $driver_trips->sum('distance');
        $todays_ratings = $driver_trips->avg('trip_ratings') ?? 0;

        return response()->json(
            array(
                'code' => 200,
                'todays_trips' => $todays_trips,
                'todays_ratings' => $todays_ratings,
                'todays_distance' => $todays_distance,
                'todays_earnings' => $todays_earnings,
            )
        );
    }

    public function get_nearby_agents($latitude, $longitude)
    {
        $agent_list = DB::table('agents')
            ->where('agent_status', 'active')
            ->select('agent_id', 'agent_name', 'latitude', 'longitude', 'branch_id', 'branch_name', 'branch_address', 'mobile', 'agent_photo')
            ->get();

        return response()->json(
            array(
                'message' => "",
                'code' => 200,
                'photo_path' => url("/storage/uploads/agents/"),
                'agent_list' => $agent_list
            )
        );
    }

    public function driver_trip_list($driver_mobile, $hide_canceled_ride = null)
    {
        Log::info($driver_mobile);
        $driver_id = DB::table('drivers')->where('mobile', $driver_mobile)->value('driver_id');

        $driver_trip_info = DB::table('driver_trips')
            ->leftjoin('vehicle_types', 'driver_trips.vehicle_type_id', '=', 'vehicle_types.vehicle_type_id')
            ->where('driver_id', $driver_id)
            ->where('start_time', '>=', Carbon::now()->subMonth(3)->toDateString())
            ->where('trip_status', '!=', ($hide_canceled_ride ? 'cancelled' : ""))
            ->select('driver_trip_id AS trip_id', 'driver_id', DB::raw("DATE_FORMAT(start_time, '%M %d, %Y %h:%i %p') as trip_date"), 'start_time', 'trip_number', 'trip_from', 'trip_to', 'distance', 'fare', 'trip_status', 'cancelled_by', 'reason_for_cancellation', 'origin_lat', 'origin_long', 'vehicle_type', 'payment_amount', 'payment_method', 'end_drop_off_location', 'end_lat', 'end_long', 'duration', 'trip_map_screenshot', 'delay_cancellation_fee', 'destination_change_fee')
            ->orderBy('start_time', 'DESC')
            ->get();

        return response()->json(
            array(
                'message' => $driver_trip_info,
                'trip_map_path' => url("/storage/trip-map/"),
                'total_record' => count($driver_trip_info),
                'code' => 200,
            )
        );
    }

    public function driver_transactions($driver_mobile)
    {
        $driver_id = DB::table('drivers')->where('mobile', $driver_mobile)->value('driver_id');

        $todays_earnings = DB::table('driver_earnings')
            ->where('driver_id', $driver_id)
            ->where('created_at', '>=', Carbon::now()->subMonth(3)->toDateString())
            ->select('driver_earning_id AS transaction_id', 'driver_id', DB::raw("DATE_FORMAT(created_at, '%M %d %Y, %h:%i %p') as transaction_date"), 'total_earnings', 'trip_number', 'payment_status')
            ->orderBy('created_at', 'DESC')
            ->get();

        return response()->json(
            array(
                'message' => $todays_earnings,
                'total_record' => count($todays_earnings),
                'code' => 200,
            )
        );
    }

    public function get_invitation_data($mobile)
    {
        $invitation_code = DB::table('drivers')->where('mobile', $mobile)->value('invitation_code');
        return response()->json(
            array(
                'code' => 200,
                'invitation_code' => $invitation_code,
            )
        );
    }

    public function add_news_view_count(Request $request)
    {
        DB::table('event_and_news')->where('news_id', $request->news_id)->increment('view_count', 1);

        return response()->json(['code' => 200, 'message' => "Successfully added veiw count to database."]);
    }

    public function get_events_and_news()
    {
        $news_info = DB::table('event_and_news')
            ->where('news_status', 'published')
            ->select('news_id', 'news_title', 'news_body', 'news_body_short', DB::raw("DATE_FORMAT(created_at, '%M %d %Y') as news_date"), 'news_picture', 'category_id', 'view_count', 'created_at')
            ->orderBy('created_at', 'DESC')->get();

        return response()->json(
            array(
                'message' => $news_info,
                'news_picture_path' => url("/storage/uploads/news/"),
                'default_image' => url("/images/logo-mini.png"),
                'total_record' => count($news_info),
                'code' => 200,
            )
        );
    }

    public function get_promocode_info()
    {
        $promo_code_info = DB::table('promo_codes')
            ->select('promo_code_id', 'promo_name', 'promo_code', DB::raw("DATE_FORMAT(expiry_date, '%d.%m.%Y') as expiry_date"), 'promo_amount', 'promo_code_status')
            ->where('promo_code_status', 'active')
            ->orderBy('created_at', 'DESC')->get();

        return response()->json(
            array(
                'code' => 200,
                'message' => $promo_code_info,
                'total_record' => count($promo_code_info),
            )
        );
    }
}
