<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Attempting;
use Illuminate\Http\Request;
use Session;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class ApiAndroidRiderController extends Controller
{
    public function login_by_mobile(Request $request)
    {
        //if($request->mobile == null || ""){
        //return response()->json(['message'=>"Please enter your Mobile Number.", 'code'=> 'empty']);
        //}
        if (DB::table('riders')->where('mobile', $request->mobile)->doesntExist()) {
            return response()->json([
                'message' => "Incorrect Mobile Number. Please try again.",
                'code' => 501
            ]);
        } else {
            $riders = DB::table('riders')->where('mobile', $request->mobile)->select('rider_id', 'rider_name', 'email', 'mobile', 'rider_photo')->first();

            if ($request->mobile === $riders->mobile) {
                return response()->json(
                    array(
                        'message' => "Login Successful.",
                        'code' => 200,
                        'user_id' => $riders->rider_id,
                        'user_name' => $riders->rider_name,
                        'user_email' => $riders->email,
                        'user_mobile' => $request->mobile, /*** from request ***/
                        'user_image' => isset($riders->rider_photo) ? url("/storage/rider-photo/" . $riders->rider_photo) : image_url('defaultAvatar.jpg'),
                    )
                );
            }
        }
    }

    public function get_invitation_data($mobile)
    {
        $invitation_code = DB::table('riders')->where('mobile', $mobile)->value('invitation_code');
        return response()->json(
            array(
                'code' => 200,
                'invitation_code' => $invitation_code,
            )
        );
    }


    //    public function login(Request $request){
//        $loginDetails = $request->only('email', 'password');
//        if(Auth::attempt($loginDetails)){
//            return response()->json(['message'=>'Login successful', 'code'=>200]);
//        }else{
//            return response()->json(['message'=> 'Incorrect Username or Password. Please try again.', 'code'=>501]);
//        }
//    }


    //    public function login_by_email(Request $request){
//        if(DB::table('riders')->where('email', $request->email)->doesntExist()){
//            return response()->json([
//                'message' => "Incorrect Username or Password. Please try again.",
//                'code' => 501
//            ]);
//        }else{
//            $riders = DB::table('riders')->where('email', $request->email)->select('id', 'name', 'email', 'mobile', 'user_photo')->first();
//
//            if ($request->email === $riders->email) {
//                return response()->json(array(
//                    'message'     => "Login Successful.",
//                    'code'        => 200,
//                    'user_id'     => $riders->rider_id,
//                    'user_name'   => $riders->rider_name,
//                    'user_email'  => $request->email, /*** from request ***/
//                    'user_mobile' => $riders->mobile,
//                    'user_photo'  => isset($riders->rider_photo) ? url( "/storage/rider-photo/").$riders->rider_photo : image_url('defaultAvatar.jpg'),
//                ));
//            }
//        }
//    }

    public function registration_by_mobile(Request $request)
    {

        if (DB::table('riders')->where('mobile', json_encode($request->mobile))->exists()) {
            return response()->json([
                'message' => "Already registered this Mobile Number. Please Login.",
                'code' => 501
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

    public function submit_registration_form(Request $request)
    {
        if (DB::table('riders')->where('email', $request->email)->exists()) {
            return response()->json([
                'message' => "Already Exist this Email. Change this.",
                'code' => 501
            ]);
        }

        $data = array(
            'rider_name' => $request->full_name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rider_status' => "active",
            //'referral_name'   => $request->referral_name,
            'referral_code' => $request->referral_code,
            'referral_mobile' => $request->referral_mobile,
            'referrer_commission_status' => "Not Received",
            'invitation_code' => "RD" . GENERATE_INVITATION_CODE(8),
            'gender' => $request->gender,
            'date_of_birth' => Carbon::createFromFormat('d/m/Y', $request->date_of_birth)->format('Y-m-d H:i:s'),
            //'rider_photo'     => $request->user_photo,
            'reg_date' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
        );
        $rider_id = DB::table('riders')->insertGetId($data);

        if ($rider_id) {
            DB::table('referrals')->insert(
                array(
                    'referral_code' => DB::table('riders')->where('rider_id', $rider_id)->value('invitation_code'),
                    'referral_nid' => $request->referral_nid,
                    'referrer_type' => "Rider",
                    'created_at' => date('Y-m-d H:i:s'),
                )
            );
            return response()->json(
                array(
                    'message' => "User registered successfully. Redirecting to Home Page.",
                    'code' => 200,
                )
            );
        }
    }

    public function get_rider_data($mobile)
    {
        $riders = DB::table('riders')->where('mobile', $mobile)->select('rider_name', 'mobile', 'email', 'date_of_birth', 'blood_group', 'gender', 'rider_photo', 'wallet_balance')->first();

        if ($riders) {
            return response()->json(
                array(
                    'code' => 200,
                    'user_name' => $riders->rider_name,
                    'mobile' => $riders->mobile,
                    'email' => $riders->email,
                    'date_of_birth' => $riders->date_of_birth ? $riders->date_of_birth : "",
                    //'date_of_birth'  => $riders->date_of_birth ? Carbon::createFromFormat('Y-m-d', $riders->date_of_birth )->format('d/m/Y') : "",
                    'blood_group' => $riders->blood_group,
                    'gender' => $riders->gender,
                    'user_image' => $riders->rider_photo ? url("/storage/rider-photo/" . $riders->rider_photo) : "",
                    'wallet_balance' => $riders->wallet_balance,
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

    public function update_profile_form(Request $request)
    {
        $max_id = DB::table('riders')->max('rider_id');
        $rd_max_id = $max_id < 1 ? '01' : ($max_id <= 9 ? "0" . ($max_id + 1) : $max_id + 1);

        $data = array(
            'rider_name' => $request->user_name,
            'date_of_birth' => $request->date_of_birth ? Carbon::createFromFormat('d/m/Y', $request->date_of_birth)->format('Y-m-d H:i:s') : "",
            //'blood_group'   => $request->blood_group,
            'gender' => $request->gender,
            'updated_at' => date('Y-m-d H:i:s'),
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
            $file_name = $max_id . "_" . title_to_slug($request->user_name) . "." . $extension;

            //Storage::put('public/uploads/driver-photo/'.$file_name, base64_decode($image));
            Storage::disk('local')->put("/public/rider-photo/" . $file_name, base64_decode($image));
            $data['rider_photo'] = $file_name;
        }
        DB::table('riders')->where('mobile', $request->mobile)->update($data);

        return response()->json(
            array(
                'message' => "Update profile Successfully.",
                'user_image' => $request->file_name !== 'no_image' ? url("/storage/rider-photo/" . $data['rider_photo']) : "",
                'code' => 200
            )
        );
    }

    public function get_fares_from_database(Request $request)
    {
        $fare_array = [];
        $vehicle_types = DB::table('vehicle_types')->get();
        foreach ($vehicle_types as $vehicle_type) {

            $fares = DB::table('fares')->leftjoin('vehicle_types', 'fares.vehicle_type_id', '=', 'vehicle_types.vehicle_type_id')->select('fares.*', 'vehicle_types.vehicle_type', 'vehicle_types.vehicle_type_id')->where('vehicle_types.vehicle_type_id', $vehicle_type->vehicle_type_id)->orderBy('created_at', 'DESC')->get();
            foreach ($fares as $fare) {
                $fare_array[ucwords($fare->vehicle_type)] = array(
                    'baseFare' => $fare->minimum_fare,
                    'timeRate' => $fare->waiting_fare,
                    'distanceRatePerKm' => $fare->fare_per_km
                );
            }
        }

        return response()->json(
            array(
                'message' => $fare_array,
                '' => $fares,
                'code' => 200,
            )
        );
    }

    public function get_wallet_balance($mobile)
    {
        if (DB::table('riders')->where('mobile', $mobile)->doesntExist()) {
            return response()->json([
                'message' => "Rider not exist.",
                'code' => 501
            ]);
        } else {
            $wallet_balance = DB::table('riders')->where('mobile', $mobile)->value('wallet_balance');

            return response()->json(
                array(
                    'wallet_balance' => taka_format("", $wallet_balance),
                    'code' => 200,
                )
            );
        }
    }

    public function new_rider_favorite_place(Request $request)
    {
        $rider_id = DB::table('riders')->where('mobile', $request->mobile)->value('rider_id');

        DB::table('rider_favorite_places')->insert(
            array(
                'rider_id' => $rider_id,
                'main_text' => $request->main_text,
                'secondary_text' => $request->secondary_text,
                'latitude' => number_format($request->latitude, 7),
                'longitude' => number_format($request->longitude, 7),
                'place_id' => $request->place_id,
                'created_at' => date('Y-m-d H:i:s'),
            )
        );

        return response()->json(
            array(
                'message' => "Location Saved successfully.",
                'code' => 200
            )
        );
    }

    public function get_rider_favorite_place_list($mobile)
    {
        $rider_id = DB::table('riders')->where('mobile', $mobile)->value('rider_id');
        $rider_favorite_place_info = DB::table('rider_favorite_places')->where('rider_id', $rider_id)->orderBy('created_at', 'DESC')->get();

        return response()->json(
            array(
                'code' => 200,
                'message' => $rider_favorite_place_info,
                'total_record' => count($rider_favorite_place_info),
            )
        );
    }

    public function delete_favorite_place($favorite_place_id)
    {
        $success = DB::table('rider_favorite_places')->where('favorite_place_id', $favorite_place_id)->delete();
        if ($success) {
            return response()->json(
                array(
                    'code' => 200,
                    'message' => 'Favourite Place Deleted Successfully.'
                )
            );
        }
    }


    public function update_rider_favorite_place(Request $request)
    {
        DB::table('rider_favorite_places')->where('favorite_place_id', $request->favorite_place_id)->update(
            array(
                'secondary_text' => $request->secondary_text,
                'latitude' => number_format($request->latitude, 7),
                'longitude' => number_format($request->longitude, 7),
                'place_id' => $request->place_id,
                'updated_at' => date('Y-m-d H:i:s')
            )
        );

        return response()->json(
            array(
                'message' => "Location Updated successfully.",
                'code' => 200,
            )
        );
    }


    public function new_credit_card(Request $request)
    {
        $rider_id = DB::table('riders')->where('mobile', $request->mobile)->value('rider_id');
        DB::table('credit_cards')->insert(
            array(
                'rider_id' => $rider_id,
                'card_type' => $request->card_type,
                'card_holder_name' => $request->card_holder_name,
                'card_number' => $request->card_number,
                'expires_at' => $request->expires_at,
                'cvv_number' => $request->cvv_number,
                'icon' => $request->icon,
                'created_at' => date('Y-m-d H:i:s')
            )
        );

        return response()->json(
            array(
                'message' => "Credit Card Saved successfully.",
                'code' => 200
            )
        );
    }

    public function get_credit_card_list($mobile)
    {
        $rider_id = DB::table('riders')->where('mobile', $mobile)->value('rider_id');
        $credit_card_info = DB::table('credit_cards')->where('rider_id', $rider_id)->orderBy('created_at', 'DESC')->get();

        return response()->json(
            array(
                'code' => 200,
                'message' => $credit_card_info,
                'total_record' => count($credit_card_info),
            )
        );
    }

    public function delete_credit_card($credit_card_id)
    {
        $success = DB::table('credit_cards')->where('credit_card_id', $credit_card_id)->delete();
        if ($success) {
            return response()->json(
                array(
                    'code' => 200,
                    'message' => 'Credit Card Deleted Successfully.'
                )
            );
        }
    }

    public function ride_request_send(Request $request)
    {
        Log::info($request);
        try {
            $rider_id = DB::table('riders')->where('mobile', $request->mobile)->value('rider_id');

            $data = array(
                'trip_number' => "TR" . GENERATE_INVITATION_CODE(10),
                'trip_from' => $request->trip_from,
                'trip_to' => $request->trip_to,
                'start_time' => date('Y-m-d H:i:s'),
                'end_time' => null,
                'distance' => $request->distance,
                'duration' => $request->duration,
                'fare' => $request->fare,
                'trip_status' => "ride_request",
                'origin_lat' => number_format($request->startLocationLat, 7),
                'origin_long' => number_format($request->startLocationLong, 7),
                'destination_lat' => number_format($request->endLocationLat, 7),
                'destination_long' => number_format($request->endLocationLong, 7),
                'rider_id' => $rider_id,
                'destination_change_fee' => '0.00',
                'created_at' => date('Y-m-d H:i:s'),
                'delay_cancellation_minute' => 1,
                'delay_cancellation_fee' => '0.00',
            );
            DB::table('rider_trips')->insert($data);


            $input = Arr::except($data, array('start_time', 'end_time', 'trip_status', 'destination_change_fee', 'delay_cancellation_minute', 'delay_cancellation_fee'));
            $input['searching_time'] = date('Y-m-d H:i:s');
            $input['platform'] = 'android';
            DB::table('searching_trips')->insert($input);


            DB::table('driver_trip_steps')->insert(
                array(
                    'trip_number' => $data['trip_number'],
                    'step_name' => 'Ride Request',
                    'specification' => 'Rider Requested for Trip from: ' . $request->trip_from . " To: " . $request->trip_to,
                    'step_time' => date('Y-m-d H:i:s'),
                    'location_name' => $request->trip_from,
                    'latitude' => number_format($request->startLocationLat, 7),
                    'longitude' => number_format($request->startLocationLong, 7),
                    'created_at' => date('Y-m-d H:i:s'),
                )
            );
            $firstDriverTripStep = DB::table('driver_trip_steps')->orderBy('created_at', 'desc')->first();

            // Log the first row
            Log::info('First driver trip step:', (array) $firstDriverTripStep);
            return response()->json(
                array(
                    'message' => "Ride request sent successfully. Please wait for driver.",
                    'trip_number' => $data['trip_number'],
                    'code' => 200,
                )
            );
        } catch (\Exception $e) {
            Log::error('Error creating ride request', [
                'error' => $e->getMessage(),
                'data' => $data ?? [],
            ]);

            return response()->json([
                'message' => "Failed to send ride request.",
                'error' => $e->getMessage(),
                'code' => 500,
            ]);
        }
    }

    public function cancel_request_by_rider(Request $request)
    {
        Log::Info($request);
        $cancellation_data = array(
            'reason_for_cancellation' => $request->reason_for_cancellation,
            'trip_status' => 'cancelled',
            'cancelled_by' => 'Rider',
            'delay_cancellation_minute' => $request->delay_cancellation_minute || 0,
            'delay_cancellation_fee' => $request->delay_cancellation_fee || '0.00',
            'cancellation_time' => date('Y-m-d H:i:s'),
        );
        DB::table('driver_trips')->where('trip_number', $request->trip_number)->update($cancellation_data);
        DB::table('rider_trips')->where('trip_number', $request->trip_number)->update($cancellation_data);


        DB::table('driver_trip_steps')->insert(
            array(
                'trip_number' => $request->trip_number,
                'step_name' => 'Cancelled By Rider',
                'specification' => $request->reason_for_cancellation,
                'step_time' => date('Y-m-d H:i:s'),
                'location_name' => '',
                'latitude' => number_format($request->latitude, 7),
                'longitude' => number_format($request->longitude, 7),
                'created_at' => date('Y-m-d H:i:s'),
            )
        );

        if (DB::table('driver_trips')->where('trip_number', $request->trip_number)->exists()) {
            $driver_id = DB::table('driver_trips')->where('trip_number', $request->trip_number)->value('driver_id');
            DB::table('drivers')->where('driver_id', $driver_id)->update(array('driver_status' => "active"));
        }

        return response()->json(
            array(
                'message' => "Ride request cancelled successfully.",
                'code' => 200,
            )
        );
    }

    public function get_trip_assigned_driver_info($trip_number)
    {
        $trips = DB::table('rider_trips')->where('trip_number', $trip_number)->select('driver_id', 'start_time', 'rider_id')->first();
        $rider_name = DB::table('riders')->where('rider_id', $trips->rider_id)->value('rider_name');
        $drivers = DB::table('drivers')->where('driver_id', $trips->driver_id)->select('driver_name', 'mobile', 'driver_photo', 'ratings')->first();
        $vehicles = DB::table('vehicles')->where('driver_id', $trips->driver_id)->select('vehicle_reg_number', 'manufacturer', 'vehicle_type_id')->first();
        $vehicle_types = DB::table('vehicle_types')->where('vehicle_type_id', $vehicles->vehicle_type_id)->select('vehicle_type', 'seat_capacity', 'vehicle_color', 'vehicle_photo')->first();
        $fares = DB::table('fares')->where('vehicle_type_id', $vehicles->vehicle_type_id)->select('destination_change_fee', 'delay_cancellation_fee', 'delay_cancellation_minute')->first();

        if ($drivers) {
            return response()->json(
                array(
                    'code' => 200,
                    'message' => "",
                    'rider_name' => $rider_name,
                    'trip_info' => $trips,
                    'driver_info' => $drivers,
                    'fare_info' => $fares,
                    'vehicle_info' => $vehicles,
                    'vehicle_type' => $vehicle_types,
                    'driver_picture_path' => url("/storage/driver-photo")
                )
            );
        } else {
            return response()->json(array('code' => 501, "message" => 'No Data Found in this table.'));
        }
    }

    public function change_trip_destination(Request $request)
    {
        $data = array(
            //'distance'        => $request->distance,
            //'duration'        => $request->duration,
            //'fare'            => $request->fare,
            'destination_lat' => number_format($request->destination_lat, 7),
            'destination_long' => number_format($request->destination_long, 7),
            'updated_at' => date('Y-m-d H:i:s'),
        );
        DB::table('rider_trips')->where('trip_number', $request->trip_number)->update($data);


        DB::table('driver_trip_steps')->insert(
            array(
                'trip_number' => $request->trip_number,
                'step_name' => 'Change Destination',
                'specification' => 'Rider has changed his trip destination location.',
                'step_time' => date('Y-m-d H:i:s'),
                'location_name' => '',
                'latitude' => number_format($request->destination_lat, 7),
                'longitude' => number_format($request->destination_long, 7),
                'created_at' => date('Y-m-d H:i:s'),
            )
        );

        return response()->json(
            array(
                'message' => "Location Changed successfully.",
                'trip_number' => $request->trip_number,
                'code' => 200,
            )
        );
    }

    public function get_trip_completed_data_to_payment_screen($trip_number)
    {
        $trip_data = DB::table('rider_trips')->where('trip_number', $trip_number)->first();

        if ($trip_data) {
            return response()->json(
                array(
                    'code' => 200,
                    'distance' => $trip_data->distance,
                    'duration' => $trip_data->duration,
                    'total_fare' => $trip_data->fare,
                    'pickup_location' => $trip_data->trip_from,
                    'end_drop_off_location' => $trip_data->end_drop_off_location,
                    'payment_method' => $trip_data->payment_method ?? "Cash Payment",
                    'delay_cancellation_fee' => $trip_data->delay_cancellation_fee,
                    'destination_change_fee' => $trip_data->destination_change_fee
                )
            );
        } else {
            return response()->json(array('code' => 501, "message" => 'No Data Found in this table.'));
        }
    }

    public function send_feedback_to_driver(Request $request)
    {
        DB::table('driver_trips')->where('trip_number', $request->trip_number)->update(
            array(
                'trip_ratings' => number_format($request->trip_ratings, 2),
                'rating_text' => number_format($request->trip_ratings, 2)
            )
        );
        $driver_id = DB::table('driver_trips')->where('trip_number', $request->trip_number)->value('driver_id');

        DB::table('drivers')->where('driver_id', $driver_id)->update(
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

    public function get_nearby_drivers($latitude, $longitude)
    {
        $driver_list = DB::table('drivers')
            ->where('driver_status', 'active')
            ->orWhere('driver_status', 'on_trip')
            ->leftjoin('vehicles', 'drivers.driver_id', '=', 'vehicles.driver_id')
            ->leftjoin('vehicle_types', 'vehicles.vehicle_type_id', '=', 'vehicle_types.vehicle_type_id')
            ->select('vehicle_types.vehicle_type', 'latitude', 'longitude', 'vehicle_types.vehicle_type_id', 'marker_heading', 'drivers.driver_id')
            ->get();

        return response()->json(
            array(
                'message' => "",
                'code' => 200,
                'driver_list' => $driver_list
            )
        );
    }

    public function save_android_device_token_to_database(Request $request)
    {
        if (DB::table('notification_devices')->where('mobile', $request->mobile)->doesntExist()) {
            $email = DB::table('riders')->where('mobile', $request->mobile)->value('email');

            DB::table('notification_devices')->insert(
                array(
                    'mobile' => $request->mobile,
                    'email' => $email,
                    'device_user_type' => 'rider',
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

            return response()->json(['code' => 200, 'message' => "Successfully updated fcm token to database."]);
        }
    }


    public function rider_trip_list($rider_mobile, $hide_canceled_ride = null)
    {
        $rider_id = DB::table('riders')->where('mobile', $rider_mobile)->value('rider_id');

        $rider_trip_info = DB::table('rider_trips')
            ->leftjoin('vehicle_types', 'rider_trips.vehicle_type_id', '=', 'vehicle_types.vehicle_type_id')
            ->where('rider_id', $rider_id)
            ->where('start_time', '>=', Carbon::now()->subMonth(3)->toDateString())
            ->where('trip_status', '!=', ($hide_canceled_ride ? 'cancelled' : ""))
            ->select('rider_trip_id AS trip_id', 'rider_id', DB::raw("DATE_FORMAT(start_time, '%M %d, %Y %h:%i %p') as trip_date"), 'start_time', 'trip_number', 'trip_from', 'trip_to', 'distance', 'fare', 'trip_status', 'cancelled_by', 'reason_for_cancellation', 'origin_lat', 'origin_long', 'vehicle_type', 'payment_amount', 'payment_method', 'end_drop_off_location', 'end_lat', 'end_long', 'duration', 'trip_map_screenshot', 'delay_cancellation_fee', 'destination_change_fee')
            ->orderBy('start_time', 'DESC')->get();

        return response()->json(
            array(
                'message' => $rider_trip_info,
                'trip_map_path' => url("/storage/trip-map/"),
                'total_record' => count($rider_trip_info),
                'code' => 200,
            )
        );
    }

    // public function rider_transactions($rider_mobile)
    // {
    //     $driver_id = DB::table('drivers')->where('mobile', $rider_mobile)->value('driver_id');

    //     $todays_earnings = DB::table('driver_earnings')
    //         ->where('driver_id', $driver_id)
    //         ->where('created_at', '>=', Carbon::now()->subMonth(3)->toDateString())
    //         ->select('driver_earning_id AS transaction_id', 'driver_id', DB::raw("DATE_FORMAT(created_at, '%M %d %Y, %h:%i %p') as transaction_date"), 'total_earnings', 'trip_number', 'payment_status')
    //         ->orderBy('created_at', 'DESC')
    //         ->get();

    //     return response()->json(
    //         array(
    //             'message' => $todays_earnings,
    //             'total_record' => count($todays_earnings),
    //             'code' => 200,
    //         )
    //     );
    // }
    public function rider_transactions($rider_mobile)
    {
        $rider_id = DB::table('riders')->where('mobile', $rider_mobile)->value('rider_id');

        $todays_earnings = DB::table('rider_trips')
            ->where('rider_id', $rider_id)
            ->where('created_at', '>=', Carbon::now()->subMonth(3)->toDateString())
            ->select('rider_trip_id AS transaction_id', 'rider_id', DB::raw("DATE_FORMAT(created_at, '%M %d %Y, %h:%i %p') as transaction_date"), 'payment_amount', 'trip_number', 'payment_status')
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
    public function add_news_view_count(Request $request)
    {
        DB::table('event_and_news')->where('news_id', $request->news_id)->increment('view_count', 1);
        return response()->json(['code' => 200, 'message' => "Successfully added view count to database."]);
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
