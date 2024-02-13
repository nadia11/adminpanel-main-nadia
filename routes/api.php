<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->group(function () {
    Route::middleware('throttle:120,1,default')->group(function () {
        Route::get('/servers', function (Request $request) {
            return $request->user();
        });
    });

    Route::middleware('throttle:60,1,deletes')->group(function () {
        Route::delete('/servers/{id}', function () {
            //
        });
    });
});


//Route::post('send-sms', 'SmsController@nexmoSms')


Route::prefix('android/rider')->group(function () {
    Route::post('login', 'ApiAndroidRiderController@login');
    Route::post('send-sms', 'SmsController@nexmoSms');
    Route::post('login-by-mobile', 'ApiAndroidRiderController@login_by_mobile');
    Route::post('login-by-email', 'ApiAndroidRiderController@login_by_email');
    Route::post('registration-by-mobile', 'ApiAndroidRiderController@registration_by_mobile');
    Route::post('submit-registration-form', 'ApiAndroidRiderController@submit_registration_form');
    Route::post('update-profile-form', 'ApiAndroidRiderController@update_profile_form');

    Route::post('/new-rider-favorite-place', 'ApiAndroidRiderController@new_rider_favorite_place');
    Route::post('/update-rider-favorite-place', 'ApiAndroidRiderController@update_rider_favorite_place');
    Route::get('/get-rider-favorite-place-list/{rider_mobile}', 'ApiAndroidRiderController@get_rider_favorite_place_list');
    Route::delete('/delete-favorite-place/{favorite_place_id}', 'ApiAndroidRiderController@delete_favorite_place');
    Route::post('/new-credit-card', 'ApiAndroidRiderController@new_credit_card');
    Route::get('/get-credit-card-list/{rider_mobile}', 'ApiAndroidRiderController@get_credit_card_list');
    Route::delete('/delete-credit-card/{credit_card_id}', 'ApiAndroidRiderController@delete_credit_card');

    Route::get('/get-wallet-balance/{rider_mobile}', 'ApiAndroidRiderController@get_wallet_balance');
    Route::get('/get-promocode-info', 'ApiAndroidRiderController@get_promocode_info');
    Route::get('/get-event-and-news', 'ApiAndroidRiderController@get_events_and_news');
    Route::post('/add-news-view-count', 'ApiAndroidRiderController@add_news_view_count');
    Route::get('/rider-trip-list/{rider_mobile}/{hide_canceled_ride?}', 'ApiAndroidRiderController@rider_trip_list');
    Route::get('/rider-transactions/{rider_mobile}', 'ApiAndroidRiderController@rider_transactions');

    //Get Data
    Route::get('/get-rider-data/{mobile}', 'ApiAndroidRiderController@get_rider_data');
    Route::get('/get-invitation-code/{mobile}', 'ApiAndroidRiderController@get_invitation_data');
    Route::post('/ride-request-send', 'ApiAndroidRiderController@ride_request_send');
    Route::get('/get-trip-assigned-driver-info/{trip_number}', 'ApiAndroidRiderController@get_trip_assigned_driver_info');
    Route::post('/cancel-request-by-rider', 'ApiAndroidRiderController@cancel_request_by_rider');
    Route::post('/change-trip-destination-again', 'ApiAndroidRiderController@change_trip_destination');
    Route::get('/get-fares-from-database', 'ApiAndroidRiderController@get_fares_from_database');
    Route::get('/get-final-trip-fare-from-database/{rider_email}', 'ApiAndroidRiderController@get_final_trip_fare_from_database');
    Route::get('/get-trip-completed-data-to-payment-screen/{trip_number}', 'ApiAndroidRiderController@get_trip_completed_data_to_payment_screen');
    Route::post('/send-feedback-to-driver', 'ApiAndroidRiderController@send_feedback_to_driver');
    Route::post('/save-android-device-token-to-database', 'ApiAndroidRiderController@save_android_device_token_to_database');
    Route::get('/get-nearby-drivers/{latitude}/{longitude}', 'ApiAndroidRiderController@get_nearby_drivers');
});



Route::prefix('android/driver')->group(function () {
    Route::post('login-by-mobile', 'ApiAndroidDriverController@login_by_mobile');
    Route::post('login-by-email', 'ApiAndroidDriverController@login_by_email');
    Route::post('registration-by-mobile', 'ApiAndroidDriverController@registration_by_mobile');
    Route::get('divisions', 'ApiAndroidDriverController@divisionJson');
    Route::post('submit-driver-partial-form', 'ApiAndroidDriverController@submit_driver_partial_form');
    Route::post('submit-driver-form', 'ApiAndroidDriverController@submit_driver_form');

    Route::post('send-password-reset-code-email', 'ApiAndroidDriverController@send_password_reset_code_email');
    Route::post('verify-password-reset-code', 'ApiAndroidDriverController@verify_password_reset_code');
    Route::post('password-reset-form-submit', 'ApiAndroidDriverController@password_reset_form_submit');
    Route::post('change-password-form-submit', 'ApiAndroidDriverController@change_password_form_submit');
    Route::get('get-user-update-form-data/{mobile}', 'ApiAndroidDriverController@get_driver_data_to_update_form');
    Route::post('update-profile-form', 'ApiAndroidDriverController@update_profile_form');
    Route::get('get-invitation-code/{mobile}', 'ApiAndroidDriverController@get_invitation_data');

    Route::post('/change-driver-status', 'ApiAndroidDriverController@change_driver_status');
    Route::get('/get-driver-data/{mobile}', 'ApiAndroidDriverController@get_driver_data');
    Route::get('/get-driver-todays-summery/{ndriver_mobile}', 'ApiAndroidDriverController@get_driver_todays_summery');
    Route::get('/get-wallet-balance/{driver_mobile}', 'ApiAndroidDriverController@get_wallet_balance');
    Route::get('/driver-trip-list/{driver_mobile}/{hide_canceled_ride?}', 'ApiAndroidDriverController@driver_trip_list');
    Route::get('/driver-transactions/{driver_mobile}', 'ApiAndroidDriverController@driver_transactions');
    Route::get('/get-promocode-info', 'ApiAndroidDriverController@get_promocode_info');
    Route::get('/get-event-and-news', 'ApiAndroidDriverController@get_events_and_news');
    Route::post('/add-news-view-count', 'ApiAndroidDriverController@add_news_view_count');

    Route::get('/get-requested-rider-info/{trip_number}', 'ApiAndroidDriverController@get_requested_rider_info');
    Route::post('/cancel-request-by-driver', 'ApiAndroidDriverController@cancel_request_by_driver');
    Route::post('/assign-driver-to-rider-trip', 'ApiAndroidDriverController@assign_driver_to_rider_trip');
    Route::post('/arrive-driver-to-rider-location', 'ApiAndroidDriverController@arrive_driver_to_rider_location');
    Route::post('/start-trip', 'ApiAndroidDriverController@start_trip');
    Route::post('/complete-trip', 'ApiAndroidDriverController@complete_trip');
    Route::get('/get-final-trip-fare-from-database/{driver_email}', 'ApiAndroidDriverController@get_final_trip_fare_from_database');
    Route::get('/get-trip-completed-data-to-payment-screen/{trip_number}', 'ApiAndroidDriverController@get_trip_completed_data_to_payment_screen');
    Route::post('/payment-collect', 'ApiAndroidDriverController@payment_collect');
    Route::post('/send-feedback-to-rider', 'ApiAndroidDriverController@send_feedback_to_rider');
    Route::post('/save-android-device-token-to-database', 'ApiAndroidDriverController@save_android_device_token_to_database');
    Route::post('/update-all-driver-route', 'ApiAndroidDriverController@update_all_driver_route');
    Route::post('/save-trip-map-snapshot', 'ApiAndroidDriverController@save_trip_map_snapshot');
    Route::get('/get-nearby-agents/{latitude}/{longitude}', 'ApiAndroidDriverController@get_nearby_agents');
});

