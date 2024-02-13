<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//landing page, if exist
//Route::get('', function () { return view('welcome'); });

Auth::routes();
Route::get('user/verify/{token}', 'Auth\RegisterController@verifyUser');
Auth::routes(['verify' => true]);

Route::get('error', function () { return "Sorry, you are unauthorized to access this page."; });
Route::get('404', function(){ return view('errors.404'); });
Route::get('403', function(){ return view('errors.403'); });
//abort_if(! Auth::user()->isAdmin(), 403);
//abort_unless(Auth::user()->isAdmin(), 403);
//abort(403, 'Unauthorized.', $headers);



Route::get('/updateapp', function(){
    Artisan::call('dump-autoload');
    echo 'dump-autoload complete';
});


//Route::group(['middleware' => 'auth'], function () {
Route::middleware(['auth', 'web'])->group(function () {

    Route::get('', 'DashboardController@index'); //For landing page if any
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    //Route::get('admin-login', 'UserController@index'); //For admin panel secure user project name
    //Route::post('login-check', 'UserController@login_check');
    Route::get('logout', 'Auth\LoginController@logout');
    Route::match(['get', 'post'], 'lockscreen', 'UserController@lockscreen')->name('lockscreen');

    //Password Reset Routes...
    //Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    //Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    //Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    //Route::post('password/reset', 'Auth\ResetPasswordController@reset');


    Route::get('quick-search/{term}', 'QuickSearchController@quickSearch');
    Route::get('quick-search-result/{id}', 'QuickSearchController@quickSearchResult');


    Route::prefix('settings')->group(function () {
        Route::get('system-settings', 'SettingsController@system_settings');
        Route::post('settings/updateSettings', 'SettingsController@updateSettings')->name('updateSettings');
        Route::get('system-settings/{tab_id}', 'SettingsController@view_settings_tab')->where('id', '[0-9]+');

        Route::post('create-new-backup', 'SettingsController@create_new_backup');
        //Route::get('download-backup-db', 'SettingsController@download_backup_db');
        Route::get('restore-backup-db', 'SettingsController@restore_backup_db');
        Route::delete('delete-database-backup/{id}', 'SettingsController@delete_database_backup');

        Route::get('create-new-file-backup', 'SettingsController@create_new_file_backup')->name('create-new-file-backup');
        Route::get('extract-file-backup', 'SettingsController@extract_file_backup')->name('extract-file-backup');
        Route::delete('delete-file-backup/{id}', 'SettingsController@delete_file_backup');

        //Route::get('phone-verification', 'SettingsController@phone_verification')->name('phone-verification');


        Route::get('/clear-cache', function() {
            Artisan::call('cache:clear');
            return response(['message' => 'Application Cache cleared Successfully!']);
        });

        Route::get('/view-clear', function() {
            Artisan::call('view:clear');
            return response(['message' => 'View Cache cleared Successfully!']);
        });

        Route::get('/route-clear', function() {
            Artisan::call('route:clear');
            return response(['message' => 'Routes cache cleared Successfully!']);
        });

        Route::get('/config-clear', function() {
            Artisan::call('config:clear');
            return response(['message' => 'Config cache cleared Successfully!']);
        });

        Route::get('/clear-compiled', function() {
            Artisan::call('clear-compiled');
            return response(['message' => 'Compiled classes cleared Successfully!']);
        });

        Route::get('/optimized', function() {
            Artisan::call('cache:clear');
            Artisan::call('view:clear');
            Artisan::call('route:clear');
            Artisan::call('config:clear');
            Artisan::call('clear-compiled');

            return response(['message' => 'Optimized Successfully!']);
        });

        Route::get('/storage-link', function() {
            Artisan::call('storage:link');
            return response(['message' => 'Storage Folder Created Successfully!']);
        });

        Route::get('/set-cache', function() {
            Artisan::call('config:cache');
            Artisan::call('route:cache');
            return response(['message' => 'Set cached Successfully!']);
        });
    });

    /*
    Route::group(['prefix' => 'user', 'middleware' => 'super_admin'], function () {
        Route::get('', 'UserController@index');
        Route::match(['get', 'post'], 'create', 'UserController@create');
        Route::match(['get', 'put'], 'update/{id}', 'UserController@update');
        Route::delete('delete/{id}', 'UserController@delete');
    });
    */

    Route::middleware(['admin'])->prefix('admin')->group(function(){
        //Route::get('user-management', 'UserManageByAdminController@user_management');
        Route::get('user-management', 'UserManageByAdminController@user_management_ajax');
        Route::post('user-management-list-data', 'UserManageByAdminController@user_management_list_data');

        Route::post('new-user-save', 'UserManageByAdminController@new_user_save')->name('new-user-save');
        Route::get('edit-user/{user_id}', 'UserManageByAdminController@edit_user');
        Route::get('user-management-list-data', 'UserManageByAdminController@user_management_list_data');
        Route::post('update-user-save/{user_id}', 'UserManageByAdminController@update_user_save');
        Route::post('change-password-byadmin/{user_id}', 'UserManageByAdminController@changePassword')->name('change-password-byadmin');
        Route::post('change-status', 'UserManageByAdminController@change_status')->name('change-status');
        Route::get('view-user/{user_id}', 'UserManageByAdminController@view_user');
        Route::delete('delete-user/{user_id}', 'UserManageByAdminController@delete_user');
        Route::delete('delete-selected-user', 'UserManageByAdminController@delete_selected_user');

        Route::post('new-role-save', 'UserManageByAdminController@new_role_save');
        Route::get('edit-role/{role_id}', 'UserManageByAdminController@edit_role');
        Route::post('update-role', 'UserManageByAdminController@update_role');
        Route::get('cancel-update-role', 'UserManageByAdminController@cancel_update_role');
        Route::delete('delete-role/{role_id}', 'UserManageByAdminController@delete_role');
        Route::get('role-wise-users/{role_id}', 'UserManageByAdminController@role_wise_users');

        Route::get('login-logs', 'UserManageByAdminController@login_logs');
    });

    Route::prefix('user')->group(function () {
        Route::get('user-profile', 'UserController@user_profile');
        Route::redirect('/', URL::to('/user/user-profile'));
        Route::get('update-profile', 'UserController@update_profile');
        Route::post('update-profile-save', 'UserController@update_profile_save')->name('update-profile-save');
        Route::post('upload-user-photo', 'UserController@upload_user_photo');
        Route::delete('remove-user-photo', 'UserController@remove_user_photo');
        Route::match(['get', 'put'], 'change-password', 'UserController@changePassword')->name('change-password');
        Route::get('user-account-settings', 'UserController@user_account_settings');
        Route::post('user-account-settings-save', 'UserController@user_account_settings_save')->name('user-account-settings-save');
    });


    Route::prefix('email')->group(function () {
        Route::get('inbox', 'EmailController@inbox')->name('inbox');
        Route::redirect('/', URL::to('/email/inbox'));
        Route::get('compose', 'EmailController@compose');
        Route::get('sent', 'EmailController@sent');
        Route::post('send-email', 'EmailController@send_email')->name('send-email');
        Route::get('drafts', 'EmailController@drafts');
        Route::post('drafts-save', 'EmailController@drafts_save');
        Route::get('starred', 'EmailController@starred');
        Route::post('change-email-status/{email_id}/{email_status}', 'EmailController@change_email_status');
        Route::post('set-email-star/{email_id}/{attribute}', 'EmailController@set_email_star');
        Route::get('spam', 'EmailController@spam');
        Route::get('request_url/view/{email_id}', 'EmailController@request_view_email');
        Route::get('view/{email_id}', 'EmailController@view_email');
        Route::delete('soft-delete', 'EmailController@soft_delete');
        Route::get('trash', 'EmailController@trash');
        Route::post('empty-trash', 'EmailController@empty_trash');
    });

    Route::prefix('notification')->group(function () {
        Route::get('pending-bills-notification', function(){
            Auth()->user()->notify(new \App\Notifications\pending_bills());
        });

        Route::get('/sms', 'SmsController@sms_list');
        Route::post('/sms-list-data', 'SmsController@sms_list_data');
        Route::post('/send-sms', 'SmsController@send_sms')->name('send-sms');
        Route::get('view-sms/{sms_id}', 'SmsController@view_sms');
        Route::delete('delete-sms/{sms_id}', 'SmsController@delete_sms');

        Route::get('/contact-list', 'SmsContactsController@contact_list');
        Route::post('new-contact-save', 'SmsContactsController@new_contact_save')->name('new-contact-save');
        Route::get('edit-contact/{contact_id}', 'SmsContactsController@edit_contact');
        Route::post('update-contact', 'SmsContactsController@update_contact')->name('update-contact-save');
        Route::delete('delete-contact/{contact_id}', 'SmsContactsController@delete_contact');

        Route::get('/contact-group', 'SmsContactsController@contact_group');
        Route::post('new-group-save', 'SmsContactsController@new_group_save')->name('new-group-save');
        Route::get('edit-group/{group_id}', 'SmsContactsController@edit_group');
        Route::post('update-group', 'SmsContactsController@update_group')->name('update-group-save');
        Route::delete('delete-group/{group_id}', 'SmsContactsController@delete_group');

        Route::get('/notification-list', 'NotificationController@notification_list');
        Route::post('new-notification-save', 'NotificationController@new_notification_save')->name('new-notification-save');
        Route::post('change-notification-status', 'NotificationController@change_notification_status');
        Route::get('view-notification/{notification_id}', 'NotificationController@view_notification');
        Route::delete('delete-notification/{notification_id}', 'NotificationController@delete_notification');
    });

    Route::prefix('message')->group(function () {
        Route::get('{user_id?}', 'ChatMessageController@chat_room');
        Route::post('send-message', 'ChatMessageController@send_message')->name('send-message');
        Route::post('add-chat-contact/{chat_contact_id}', 'ChatMessageController@add_chat_contact')->name('add-chat-contact');
        Route::delete('delete-chat-contact', 'ChatMessageController@delete_chat_contact');
        Route::post('change-reading-status/{chat_contact_id}/{contact_status}', 'ChatMessageController@change_reading_status');
        Route::post('block-chat-contact/{chat_contact_id}', 'ChatMessageController@block_chat_contact');
        Route::post('change-star-status/{chat_contact_id}/{status}', 'ChatMessageController@change_star_status');
        //Route::get('quick-message', 'ChatMessageController@chat_message');
        //Route::delete('delete-chat-histry', 'ChatMessageController@delete_chat_histry')->where('id', '[0-9]+');
    });


    Route::prefix('news/')->group(function () {
        Route::get('/news-list', 'NewsController@news_list');
        Route::redirect('/', URL::to('/news/news-list'));
        Route::post('new-news-save', 'NewsController@new_news_save')->name('new-news-save');
        Route::get('edit-news/{news_id}', 'NewsController@edit_news');
        Route::post('update-news', 'NewsController@update_news')->name('edit-news-save');
        Route::delete('delete-news/{news_id}', 'NewsController@delete_news');
        Route::get('view-news/{agent_id}', 'NewsController@view_news');
        Route::delete('delete-news/{agent_id}', 'NewsController@delete_news')->where('id', '[0-9]+');
        Route::post('change-news-status', 'NewsController@change_news_status')->name('change-news-status');
    });


    Route::prefix('get_info')->group(function () {
        Route::get('get-district/{id}', 'GeneralInformationController@get_district')->name('get-district');
        Route::get('get-district-branch/{id}', 'GeneralInformationController@get_district_branch');
        Route::get('get-all-district', 'GeneralInformationController@get_all_district')->name('get-all-district');
        Route::get('get-district-filter/{division_name}', 'GeneralInformationController@get_district_filter')->name('get-district-filter');

        Route::get('reload-employee', 'GeneralInformationController@reload_employee')->name('reload-employee');
        Route::get('get-employee-data', 'GeneralInformationController@get_employee_data');

        Route::get('in-word', 'GeneralInformationController@in_word')->name('in-word');
    });

	Route::prefix('todo')->group(function () {
        Route::post('new-todo-save', 'ToDoListController@new_todo_save');
        Route::get('edit-todo/{todo_id}', 'ToDoListController@edit_todo');
        Route::post('update-todo', 'ToDoListController@update_todo');
        Route::post('update-todo-sorting', 'ToDoListController@update_todo_sorting');
        Route::post('change-todo-status', 'ToDoListController@change_todo_status')->name('change-todo-status');
        Route::get('cancel-update-todo', 'ToDoListController@cancel_update_todo');
        Route::delete('delete-todo/{todo_id}', 'ToDoListController@delete_todo');
        Route::post('archive-todo/{todo_id}', 'ToDoListController@archive_todo')->name('archive-todo');
    });


    Route::prefix('employee')->group(function () {
        Route::get('employee-management', 'EmployeeController@employee_management');
        Route::post('employee-management-ajax-data', 'EmployeeController@employee_management_ajax_data');
        Route::redirect('/', URL::to('/employee/employee-management'));

        Route::post('new-employee-save', 'EmployeeController@new_employee_save')->name('new-employee-save');
        Route::match(['get', 'post'], '/edit-employee/', 'EmployeeController@update_employee')->name('edit-employee');
        Route::get('get-designation/{id}', 'EmployeeController@get_designation')->name('get-designation');

        //Route::get('edit-employee/{employee_id}', 'EmployeeController@edit_employee')->where('id', '[0-9]+');
        //Route::post('edit-employee-save', 'EmployeeController@update_employee')->name('edit-employee-save');
        Route::get('get_district/{id}', 'EmployeeController@get_district');

        Route::get('view/{employee_id}', 'EmployeeController@view_employee');
        Route::get('view/{employee_id}/{tab_id}', 'EmployeeController@view_employee_tab')->where('id', '[0-9]+');
        Route::delete('delete-employee/{employee_id}', 'EmployeeController@delete_employee')->where('id', '[0-9]+');

        Route::post('add-employee-education', 'EmployeeController@add_employee_education')->name('add-employee-education');
        Route::get('edit-employee-education/{education_id}', 'EmployeeController@edit_employee_education')->where('id', '[0-9]+');
        Route::post('edit-employee-education-save', 'EmployeeController@update_employee_education')->name('edit-employee-education-save');
        Route::delete('delete-employee-education/{education_id}', 'EmployeeController@delete_employee_education')->where('id', '[0-9]+');

        Route::post('add-employee-training', 'EmployeeController@add_employee_training')->name('add-employee-training');
        Route::get('edit-employee-training/{training_id}', 'EmployeeController@edit_employee_training')->where('id', '[0-9]+');
        Route::post('edit-employee-training-save', 'EmployeeController@update_employee_training')->name('edit-employee-training-save');
        Route::delete('delete-employee-training/{training_id}', 'EmployeeController@delete_employee_training')->where('id', '[0-9]+');

        Route::post('add-employee-experience', 'EmployeeController@add_employee_experience')->name('add-employee-experience');
        Route::get('edit-employee-experience/{experience_id}', 'EmployeeController@edit_employee_experience')->where('id', '[0-9]+');
        Route::post('edit-employee-experience-save', 'EmployeeController@update_employee_experience')->name('edit-employee-experience-save');
        Route::delete('delete-employee-experience/{experience_id}', 'EmployeeController@delete_employee_experience')->where('id', '[0-9]+');

        Route::post('add-employee-certificate', 'EmployeeController@add_employee_certificate')->name('add-employee-certificate');
        Route::get('edit-employee-certificate/{certificate_id}', 'EmployeeController@edit_employee_certificate')->where('id', '[0-9]+');
        Route::post('edit-employee-certificate-save', 'EmployeeController@update_employee_certificate')->name('edit-employee-certificate-save');
        Route::delete('delete-employee-certificate/{certificate_id}', 'EmployeeController@delete_employee_certificate')->where('id', '[0-9]+');

        Route::post('new-designation-save', 'EmployeeController@new_designation_save');
        Route::get('edit-designation/{id}', 'EmployeeController@edit_designation');
        Route::post('update-designation', 'EmployeeController@update_designation');
        Route::get('cancel-update-designation', 'EmployeeController@cancel_update_designation');
        Route::get('designation/view-employee/{employee_id}', 'EmployeeController@view_designation_wise_employee');
        Route::delete('delete-designation/{id}', 'EmployeeController@delete_designation')->where('id', '[0-9]+');

        Route::post('new-department-save', 'EmployeeController@new_department_save');
        Route::get('edit-department/{id}', 'EmployeeController@edit_department');
        Route::post('update-department', 'EmployeeController@update_department');
        Route::get('cancel-update-department', 'EmployeeController@cancel_update_department');
        Route::get('department/view-employee/{employee_id}', 'EmployeeController@view_department_wise_employee');
        Route::delete('delete-department/{id}', 'EmployeeController@delete_department')->where('id', '[0-9]+');

        Route::get('employee-bank-account', 'EmployeeController@bank_account_management');
        Route::post('new-employee-bank-account-save', 'EmployeeController@new_bank_account_save')->name('new-employee-bank-account-save');
        Route::get('edit-bank-account/{id}', 'EmployeeController@edit_bank_account')->where('id', '[0-9]+');
        Route::post('edit-bank-account-save', 'EmployeeController@update_bank_account')->name('edit-bank-account-save');
        Route::get('view-bank-account/{bank_account_id}', 'EmployeeController@view_bank_account');
        Route::delete('delete-bank-account/{id}', 'EmployeeController@delete_bank_account')->where('id', '[0-9]+');
    });

    Route::prefix('sales-target')->group(function () {
        Route::get('sales-target-management', 'SalesTargetController@sales_target_management');
        Route::redirect('/', URL::to('/sales-target/sales-target-management'));
        Route::post('new-sales-target-save', 'SalesTargetController@new_sales_target_save')->name('new-sales-target-save');
        Route::post('achievement-save', 'SalesTargetController@achievement_save')->name('achievement-save');

        //Route::get('edit-employee/{employee_id}', 'SalesTargetController@edit_employee')->where('id', '[0-9]+');
        //Route::post('update-employee-save', 'SalesTargetController@update_employee')->name('edit-employee-save');

        Route::get('view-sales-target/{po_id}', 'SalesTargetController@view_sales_target');
        Route::delete('delete-sales-target/{employee_id}', 'SalesTargetController@delete_sales_target')->where('id', '[0-9]+');
    });

    Route::prefix('loan')->group(function () {
        Route::get('loan-management', 'EmployeeLoanController@loan_management');
        Route::post('new-loan-save', 'EmployeeLoanController@new_loan_save')->name('new-loan-save');
        Route::get('edit-loan/{id}', 'EmployeeLoanController@edit_loan')->where('id', '[0-9]+');
        Route::post('edit-loan-save', 'EmployeeLoanController@update_loan')->name('edit-loan-save');
        Route::delete('delete-loan/{id}', 'EmployeeLoanController@delete_loan')->where('id', '[0-9]+');
        Route::get('get-employee-data', 'EmployeeLoanController@get_employee_data');
    });


    Route::prefix('payroll')->group(function () {
        Route::get('employee-ledger', 'PayrollController@employee_ledger');
        Route::redirect('/', URL::to('/payroll/salary-payment-summery'));

        Route::post('add-employee-to-salary-sheet-save', 'PayrollController@add_employee_to_salary_sheet_save')->name('add-employee-to-salary-sheet-save');
        Route::get('refresh-employee', 'PayrollController@refresh_employee');
        Route::get('get-employee-data', 'PayrollController@get_employee_data');
        Route::get('make-salary-sheet/{month_name}', 'PayrollController@make_salary_sheet');
        Route::post('make-salary-sheet-save', 'PayrollController@make_salary_sheet_save')->name('make-salary-sheet-save');
        Route::get('employee-list-with-salary', 'PayrollController@employee_list_with_salary');

        Route::get('report-salary-payment-summery', 'PayrollController@salary_payment_summery');
        Route::get('report-detail-history', 'PayrollController@detail_salary_history');
        Route::get('report-employee-wise-history', 'PayrollController@employee_wise_history');
        Route::get('report-month-wise-history', 'PayrollController@month_wise_history');
    });

    Route::prefix('account')->group(function () {
        Route::get('cashbook', 'AccountsController@cashbook');
        Route::redirect('/', URL::to('/account/cashbook'));
        Route::get('cashbook-entry', 'AccountsController@cashbook_entry');
        Route::get('get-party-list', 'AccountsController@get_party_list');

        Route::post('daily-expense-save', 'AccountsController@daily_expense_save')->name('daily-expense-save');
        Route::get('edit-daily-expense/{id}', 'AccountsController@edit_daily_expense');
        Route::post('update-daily-expense', 'AccountsController@update_daily_expense')->name('update-daily-expense');
        Route::delete('delete-daily-expense/{id}', 'AccountsController@delete_daily_expense')->where('id', '[0-9]+');

        Route::post('cash-receive-save', 'AccountsController@cash_receive_save')->name('cash-receive-save');
        Route::get('edit-cash-receive/{id}', 'AccountsController@edit_cash_receive');
        Route::post('update-cash-receive', 'AccountsController@update_cash_receive')->name('update-cash-receive');
        Route::delete('delete-cash-receive/{id}', 'AccountsController@delete_daily_expense')->where('id', '[0-9]+');
        Route::get('cash-withdraw/get-cheque-book-data', 'AccountsController@get_cheque_book_data_to_cash_receive');
        Route::get('cash-withdraw/get-cheque-leaf', 'AccountsController@get_cheque_leaf_to_cash_receive');


        Route::post('employee-payment-save', 'AccountsController@employee_payment_save')->name('employee-payment-save');
        Route::get('edit-employee-payment/{id}', 'AccountsController@edit_employee_payment');
        Route::post('update-employee-payment', 'AccountsController@update_employee_payment')->name('update-employee-payment');
        Route::delete('delete-employee-payment/{id}', 'AccountsController@delete_employee_payment')->where('id', '[0-9]+');

        Route::post('vendor-payment-save', 'AccountsController@vendor_payment_save')->name('vendor-payment-save');
        Route::get('edit-vendor-payment/{id}', 'AccountsController@edit_vendor_payment');
        Route::post('update-vendor-payment', 'AccountsController@update_vendor_payment')->name('update-vendor-payment');
        Route::get('get-po-data', 'AccountsController@get_po_data');
        Route::get('get-vendor-data', 'AccountsController@get_vendor_data');
        Route::get('get-po-from-bill', 'AccountsController@get_po_from_bill');
        Route::delete('delete-vendor-payment/{id}', 'AccountsController@delete_vendor_payment')->where('id', '[0-9]+');

        Route::post('new-account-head-save', 'AccountsController@new_account_head_save');
        Route::get('edit-account-head/{id}', 'AccountsController@edit_account_head');
        Route::post('update-account-head', 'AccountsController@update_account_head');
        Route::get('cancel-update-account-head', 'AccountsController@cancel_update_account_head');
        Route::delete('delete-account-head/{id}', 'AccountsController@delete_account_head')->where('id', '[0-9]+');

        Route::get('asset-list', 'AccountsController@asset_list');
        Route::post('new-asset-save', 'AccountsController@new_asset_save')->name('new-asset-save');
        Route::get('edit-asset/{id}', 'AccountsController@edit_asset')->where('id', '[0-9]+');
        Route::post('edit-asset-save', 'AccountsController@update_asset')->name('edit-asset-save');
        Route::delete('delete-asset/{id}', 'AccountsController@delete_asset')->where('id', '[0-9]+');

        Route::get('account-headwise-summery', 'AccountsController@account_head_wise_summery');
        Route::get('balance-sheet', 'AccountsController@balance_sheet');



        Route::get('commission-settings', 'CommissionController@commission_settings');
        Route::post('new-commission-save', 'CommissionController@new_commission_save')->name('new-commission-save');
        Route::get('edit-commission/{id}', 'CommissionController@edit_commission')->where('id', '[0-9]+');
        Route::post('edit-commission-save', 'CommissionController@update_commission')->name('edit-commission-save');
        Route::delete('delete-commission/{id}', 'CommissionController@delete_commission')->where('id', '[0-9]+');
        Route::get('agent-commission-list', 'CommissionController@agent_commission_list');
        Route::get('agency-commission-list', 'CommissionController@agency_commission_list');
        Route::get('referral-commission-list', 'CommissionController@referral_commission_list');
    });

    Route::prefix('bank')->group(function () {
        Route::get('bank-account-management', 'BankController@bank_account_management');
        Route::redirect('/', URL::to('/bank/bank-account-management'));
        Route::post('new-bank-account-save', 'BankController@new_bank_account_save')->name('new-bank-account-save');
        Route::get('edit-bank-account/{id}', 'BankController@edit_bank_account')->where('id', '[0-9]+');
        Route::post('edit-bank-account-save', 'BankController@update_bank_account')->name('edit-bank-account-save');
        Route::delete('delete-bank-account/{id}', 'BankController@delete_bank_account')->where('id', '[0-9]+');
        Route::get('view-bank-account/{bank_account_id}', 'BankController@view_bank_account');
        Route::get('get_balance', 'BankController@get_balance');

        Route::post('new-bank-name-save', 'BankController@new_bank_name_save');
        Route::get('edit-bank-name/{id}', 'BankController@edit_bank_name');
        Route::post('update-bank-name', 'BankController@update_bank_name');
        Route::get('cancel-update-bank-name', 'BankController@cancel_update_bank_name');
        Route::delete('delete-bank-name/{id}', 'BankController@delete_bank_name')->where('id', '[0-9]+');

        Route::get('cheque-payment-list', 'BankController@cheque_payment_list');
        Route::post('new-cheque-payment', 'BankController@new_cheque_payment')->name('new-cheque-payment');
        Route::post('cheque-payment-status', 'BankController@cheque_payment_status')->name('cheque-payment-status');
        Route::get('get-cheque-book-data', 'BankController@get_cheque_book_data');
        Route::get('get-cheque-leaf', 'BankController@get_cheque_leaf');
        Route::get('edit-cheque-payment/{id}', 'BankController@edit_cheque_payment');
        Route::get('update-cheque-payment', 'BankController@update_cheque_payment')->name('update-cheque-payment');
        Route::get('view-cheque-payment/{cheque_payment_id}', 'BankController@view_cheque_payment');
        Route::get('get-party-name', 'BankController@get_party_name');

        Route::get('cash-deposit-list', 'BankController@cash_deposit_list');
        Route::post('cash-deposit-save', 'BankController@cash_deposit_save')->name('cash-deposit-save');
        Route::get('cash-deposit/get-account-data', 'BankController@get_account_data_to_cash_deposit');
        Route::get('view-cash-deposit/{cheque_withdraw_id}', 'BankController@view_cash_deposit');

        Route::get('cash-withdraw-list', 'BankController@cash_withdraw_list');
        Route::post('cash-withdraw-save', 'BankController@cash_withdraw_save')->name('cash-withdraw-save');
        Route::get('cash-withdraw/get-cheque-book-data', 'BankController@get_cheque_book_data_to_withdraw');
        Route::get('cash-withdraw/get-cheque-leaf', 'BankController@get_cheque_leaf_to_withdraw');
        Route::post('withdraw-status', 'BankController@withdraw_status')->name('withdraw-status');

        Route::get('received-cheques', 'BankController@received_cheques');
        Route::post('new-received-cheque', 'BankController@new_received_cheque')->name('new-received-cheque');
        Route::get('view-received-cheque/{received_cheque_id}', 'BankController@view_received_cheque');
        Route::get('update-received-cheque', 'BankController@update_received_cheque')->name('update-received-cheque');
        Route::post('received-cheque-status', 'BankController@received_cheque_status')->name('received-cheque-status');
        Route::get('view-change-history/{received_cheque_id}', 'BankController@view_change_history');
        Route::get('received-cheque/get-account-data', 'BankController@get_account_data_to_rec_cheque');
        Route::get('received-cheque/reload-client', 'BankController@reload_client');
        Route::get('get-bill-list', 'BankController@get_bill_list'); //get bill list to bill received modal
        Route::get('get-po-and-bill-data', 'BankController@get_po_and_bill_data'); //get bill list to bill received modal


        Route::get('bank-transfer-list', 'BankController@bank_transfer_list');
        Route::post('new-bank-transfer', 'BankController@new_bank_transfer')->name('new-bank-transfer');
        Route::get('update-bank-transfer', 'BankController@update_bank_transfer')->name('update-bank-transfer');
        Route::get('bank-transfer/get-account-data', 'BankController@get_account_data_to_rec_cheque');
        Route::get('view-bank-transfer/{bank_transfer_id}', 'BankController@view_bank_transfer');

        Route::get('cheque-book-list', 'BankController@cheque_book_list');
        Route::post('new-cheque-book-save', 'BankController@new_cheque_book')->name('new-cheque-book-save');
        Route::get('edit-cheque-book/{id}', 'BankController@edit_cheque_book');
        Route::post('update-cheque-book-save', 'BankController@update_cheque_book_save')->name('update-cheque-book-save');
        Route::get('get-account-data', 'BankController@get_account_data');
        Route::get('view-cheque-book/{cheque_book_id}', 'BankController@view_cheque_book')->name('view-cheque-book');
        Route::post('change-cheque-leaf-status', 'BankController@change_cheque_leaf_status')->name('change-cheque-leaf-status');
        Route::post('cheque-book-status/{id}/{cheque_book_status}', 'BankController@cheque_book_status');
        Route::get('view-cheque/{cheque_no}', 'BankController@view_cheque');
        Route::delete('delete-cheque-book/{id}', 'BankController@delete_cheque_book')->where('id', '[0-9]+');

        Route::get('bank-transaction', 'BankController@bank_transaction');
        Route::get('bank-transaction-summery', 'BankController@bank_transaction_summery');
    });

    Route::prefix('map')->group(function () {
        Route::get('/view-in-map/{userType}', 'MapController@view_in_map');
        Route::get('/load-driver-markers', 'MapController@load_driver_markers');
        Route::get('/get-map-infowindow-content/{driver_id}', 'MapController@get_map_infowindow_content');
        Route::get('/driver-live-tracking', 'MapController@driver_live_tracking');
    });

    Route::prefix('rider')->group(function () {
        Route::get('all-riders', 'RiderController@rider_management');
        //Route::post('rider-management-list-data', 'RiderController@rider_management_list_data');
        Route::redirect('/', URL::to('/rider/all-riders'));
        Route::get('/this-week-riders', 'RiderController@this_week_riders');
        //Route::post('new-rider-save', 'RiderController@new_rider_save')->name('new-rider-save');
        //Route::get('edit-rider/{rider_id}', 'RiderController@edit_rider')->where('id', '[0-9]+');
        //Route::post('update-rider-save', 'RiderController@update_rider')->name('update-rider-save');

        Route::get('view-rider/{rider_id}', 'RiderController@view_rider');
        Route::delete('delete-rider/{rider_id}', 'RiderController@delete_rider')->where('id', '[0-9]+');
        Route::post('change-rider-status', 'RiderController@change_rider_status')->name('change-rider-status');
        Route::get('/rider-favorite-places', 'RiderController@rider_favorite_places');
        Route::get('/credit-cards', 'RiderController@credit_cards');
    });

    Route::prefix('rider-trip')->group(function () {
        Route::get('rider-all-trips', 'RiderTripController@rider_all_trips');
        //Route::post('trip-management-list-data', 'RiderTripController@rider_trip_management_list_data');
        Route::redirect('/', URL::to('/rider-trip/rider-all-trips'));
        Route::get('active-rider-trips', 'RiderTripController@active_rider_trips');
        Route::get('completed-rider-trips', 'RiderTripController@completed_rider_trips');
        Route::get('cancelled-rider-trips', 'RiderTripController@cancelled_rider_trips');
        Route::get('booked-rider-trips', 'RiderTripController@booked_rider_trips');
        Route::get('/searching-trips', 'RiderTripController@searching_trips');

        Route::get('/trip-route/{trip_id}', 'RiderTripController@rider_trip_route');
        Route::delete('delete-rider-trip/{trip_id}', 'RiderTripController@delete_rider_trip')->where('id', '[0-9]+');
    });


    Route::prefix('driver')->group(function () {
        Route::get('all-drivers', 'DriverController@driver_management');
        //Route::post('driver-management-list-data', 'DriverController@driver_management_list_data');
        Route::redirect('/', URL::to('/driver/all-drivers'));
        Route::get('/this-week-drivers', 'DriverController@this_week_drivers');
        //Route::post('new-driver-save', 'DriverController@new_driver_save')->name('new-driver-save');
        //Route::get('edit-driver/{driver_id}', 'DriverController@edit_driver')->where('id', '[0-9]+');
        //Route::post('update-driver-save', 'DriverController@update_driver')->name('update-driver-save');

        Route::get('unapproved-drivers', 'DriverController@unapproved_drivers');
        Route::get('view-driver/{driver_id}', 'DriverController@view_driver');
        Route::delete('delete-driver/{driver_id}', 'DriverController@delete_driver')->where('id', '[0-9]+');

        Route::post('change-driver-status', 'DriverController@change_driver_status')->name('change-driver-status');
        Route::post('change-approval-status', 'DriverController@change_approval_status')->name('change-approval-status');
        //Route::get('print-driver/{driver_id}', 'DriverController@print_driver');
        Route::get('/view-driver-in-map/{driver_id}', 'DriverController@view_driver_in_map');
    });


    Route::prefix('driver/trip')->group(function () {
        Route::get('driver-trips', 'DriverTripController@driver_trips');
        //Route::post('trip-management-list-data', 'DriverTripController@driver_trip_management_list_data');
        Route::redirect('/', URL::to('/driver/trip/driver-trips'));
        Route::get('driver-cancelled-trip', 'DriverTripController@driver_cancelled_trips');
        Route::get('driver-trip-history-route/{trip_id}', 'DriverTripController@driver_trip_route');
        Route::delete('delete-driver-trip-history/{trip_id}', 'DriverTripController@delete_driver_trip')->where('id', '[0-9]+');


        /*******Upcoming Trips*******/
        Route::get('driver-upcoming-trip', 'DriverUpcomingTripController@driver_upcoming_trip');
        Route::redirect('/', URL::to('/driver/trip/all-driver-upcoming-trips'));
        Route::get('driver-upcoming-trip-route/{trip_id}', 'DriverUpcomingTripController@driver_upcoming_trip_route');
        Route::delete('delete-driver-upcoming-trip/{trip_id}', 'DriverUpcomingTripController@delete_driver_upcoming_trip')->where('id', '[0-9]+');
    });

    Route::prefix('driver/payment')->group(function () {
        Route::get('all-payments', 'DriverPaymentController@driver_payments');
        Route::redirect('/', URL::to('/driver-payment/all-payments'));
        Route::get('driver-payment-route/{trip_id}', 'DriverPaymentController@driver_payment_route');
        Route::delete('delete-driver-payment/{trip_id}', 'DriverPaymentController@delete_driver_payment')->where('id', '[0-9]+');
    });


    Route::prefix('driver/tax')->group(function () {
        Route::get('tax-management', 'DriverTaxController@tax_management');
        Route::redirect('/', URL::to('/tax/tax-management'));
        //Route::post('new-tax-save', 'DriverTaxController@new_tax_save')->name('new-tax-save');
        //Route::get('edit-tax/{tax_id}', 'DriverTaxController@edit_tax')->where('id', '[0-9]+');
        //Route::post('edit-tax-save', 'DriverTaxController@edit_tax_save')->name('edit-tax-save');
        Route::post('change-tax-status', 'DriverTaxController@change_tax_status')->name('change-tax-status');

        //Route::get('view-tax/{tax_id}', 'DriverTaxController@view_tax');
        //Route::delete('delete-tax/{tax_id}', 'DriverTaxController@delete_tax')->where('id', '[0-9]+');
    });

    Route::prefix('driver/insurance')->group(function () {
        Route::get('insurance-management', 'DriverInsuranceController@insurance_management');
        Route::redirect('/', URL::to('/driver/insurance/insurance-management'));
        //Route::post('new-insurance-save', 'DriverInsuranceController@new_insurance_save')->name('new-insurance-save');
        //Route::get('edit-insurance/{insurance_id}', 'DriverInsuranceController@edit_insurance')->where('id', '[0-9]+');
        //Route::post('edit-insurance-save', 'DriverInsuranceController@edit_insurance_save')->name('edit-insurance-save');
        Route::post('change-insurance-status', 'DriverInsuranceController@change_insurance_status')->name('change-insurance-status');

        //Route::get('view-insurance/{insurance_id}', 'DriverInsuranceController@view_insurance');
        //Route::delete('delete-insurance/{insurance_id}', 'DriverInsuranceController@delete_insurance')->where('id', '[0-9]+');
    });

    Route::prefix('driver/earning')->group(function () {
        Route::get('driver-earnings', 'DriverEarningsController@earning_management');
        Route::redirect('/', URL::to('/driver/earning/driver-earnings'));
        //Route::post('new-earning-save', 'DriverEarningsController@new_earning_save')->name('new-earning-save');
        //Route::get('edit-earning/{earning_id}', 'DriverEarningsController@edit_earning')->where('id', '[0-9]+');
        //Route::post('edit-earning-save', 'DriverEarningsController@edit_earning_save')->name('edit-earning-save');
        Route::post('change-payment-status', 'DriverEarningsController@change_payment_status')->name('change-payment-status');

        Route::get('specific-driver-earnings/{driver_id}', 'DriverEarningsController@specific_driver_earnings');
        //Route::get('view-earning/{earning_id}', 'DriverEarningsController@view_earning');
        //Route::delete('delete-earning/{earning_id}', 'DriverEarningsController@delete_earning')->where('id', '[0-9]+');
    });


    Route::prefix('vehicle')->group(function () {
        Route::get('vehicle-management', 'VehicleController@vehicle_management');
        //Route::post('vehicle-management-list-data', 'VehicleController@vehicle_management_list_data');
        Route::redirect('/', URL::to('/vehicle/vehicle-management'));
        //Route::post('new-vehicle-save', 'VehicleController@new_vehicle_save')->name('new-vehicle-save');
        //Route::get('edit-vehicle/{vehicle_id}', 'VehicleController@edit_vehicle')->where('id', '[0-9]+');
        //Route::post('update-vehicle-save', 'VehicleController@update_vehicle')->name('update-vehicle-save');

        Route::get('view-vehicle/{vehicle_id}', 'VehicleController@view_vehicle');

        //Route::delete('delete-vehicle/{vehicle_id}', 'VehicleController@delete_vehicle')->where('id', '[0-9]+');
        //Route::post('change-vehicle-status', 'VehicleController@change_vehicle_status')->name('change-vehicle-status');
        //Route::get('print-vehicle/{vehicle_id}', 'VehicleController@print_vehicle');
    });

    Route::prefix('vehicle-type')->group(function () {
        Route::get('vehicle-type-management', 'VehicleTypeController@vehicle_type_management');
        Route::redirect('/', URL::to('/vehicle-type/vehicle-type-management'));
        Route::post('new-vehicle-type-save', 'VehicleTypeController@new_vehicle_type_save')->name('new-vehicle-type-save');
        Route::get('edit-vehicle-type/{id}', 'VehicleTypeController@edit_vehicle_type');
        Route::post('update-vehicle-type-save', 'VehicleTypeController@update_vehicle_type')->name('update-vehicle-type-save');
        //Route::get('cancel-update-vehicle-type', 'VehicleTypeController@cancel_update_vehicle_type');
        Route::get('vehicle-type/view-driver/{employee_id}', 'VehicleTypeController@view_vehicle_type_wise_driver');
        Route::delete('delete-vehicle-type/{id}', 'VehicleTypeController@delete_vehicle_type')->where('id', '[0-9]+');
    });

    Route::prefix('agent')->group(function () {
        Route::get('agent-management', 'AgentController@agent_management');
        //Route::post('agent-management-list-data', 'AgentController@agent_management_list_data');
        Route::redirect('/', URL::to('/agent/agent-management'));
        Route::post('new-agent-save', 'AgentController@new_agent_save')->name('new-agent-save');
        Route::get('edit-agent/{agent_id}', 'AgentController@edit_agent')->where('id', '[0-9]+');
        Route::post('edit-agent-save', 'AgentController@edit_agent_save')->name('edit-agent-save');

        Route::get('view-agent/{agent_id}', 'AgentController@view_agent');
        Route::delete('delete-agent/{agent_id}', 'AgentController@delete_agent')->where('id', '[0-9]+');

        Route::post('change-agent-status', 'AgentController@change_agent_status')->name('change-agent-status');
        //Route::get('print-agent/{agent_id}', 'AgentController@print_agent');
    });

    Route::prefix('fare')->group(function () {
        Route::get('fare-management', 'FareController@fare_management');
        Route::redirect('/', URL::to('/fare/fare-management'));
        Route::post('new-fare-save', 'FareController@new_fare_save')->name('new-fare-save');
        Route::get('edit-fare/{fare_id}', 'FareController@edit_fare')->where('id', '[0-9]+');
        Route::post('edit-fare-save', 'FareController@edit_fare_save')->name('edit-fare-save');

        Route::get('view-fare/{fare_id}', 'FareController@view_fare');
        Route::delete('delete-fare/{fare_id}', 'FareController@delete_fare')->where('id', '[0-9]+');
    });

    Route::prefix('promo-code')->group(function () {
        Route::get('promo-code-management', 'PromoCodeController@promo_code_management');
        Route::redirect('/', URL::to('/promo-code/promo-code-management'));
        Route::post('new-promo-code-save', 'PromoCodeController@new_promo_code_save')->name('new-promo-code-save');
        Route::get('edit-promo-code/{promo_code_id}', 'PromoCodeController@edit_promo_code')->where('id', '[0-9]+');
        Route::post('edit-promo-code-save', 'PromoCodeController@edit_promo_code_save')->name('edit-promo-code-save');

        Route::get('view-promo-code/{promo_code_id}', 'PromoCodeController@view_promo_code');
        Route::post('change-promo-code-status', 'PromoCodeController@change_promo_code_status')->name('change-promo-code-status');
        Route::delete('delete-promo-code/{promo_code_id}', 'PromoCodeController@delete_promo_code')->where('id', '[0-9]+');
    });

    Route::prefix('referral')->group(function () {
        Route::get('referral-management', 'ReferralController@referral_management');
        Route::redirect('/', URL::to('/referral/referral-management'));
        Route::post('new-referral-save', 'ReferralController@new_referral_save')->name('new-referral-save');
        Route::get('edit-referral/{referral_id}', 'ReferralController@edit_referral')->where('id', '[0-9]+');
        Route::post('edit-referral-save', 'ReferralController@edit_referral_save')->name('edit-referral-save');

        Route::get('view-referral/{referral_id}', 'ReferralController@view_referral');
        Route::post('change-referral-status', 'ReferralController@change_referral_status')->name('change-referral-status');
        Route::delete('delete-referral/{referral_id}', 'ReferralController@delete_referral')->where('id', '[0-9]+');
    });
}); //End of Middleware





Route::prefix('web/rider')->group(function () {
    Route::get('registration-form', 'ApiWebRiderController@registration_form');
    Route::post('rider-registration-form-save', 'ApiWebRiderController@rider_registration_form_save')->name('rider-registration-form-save');
    Route::get('registration-success', 'ApiWebRiderController@registration_success');

    Route::get('login-form', 'ApiWebRiderController@login_form');
    Route::post('rider-login-check', 'ApiWebRiderController@rider_login_check')->name('rider-login-check');
    Route::get('password-reset/request-form', 'Auth\ForgotPasswordController@password_reset_request_form')->name('rider.password.request');
    Route::post('password-reset/send-reset-link-email', 'Auth\ForgotPasswordController@password_reset_send_reset_link_email');
    Route::get('password-reset/reset-form/{token}', 'Auth\ResetPasswordController@password_reset_form')->name('rider.password.reset');
    Route::post('password/reset-submit', 'Auth\ResetPasswordController@password_reset_submit');

    Route::get('profile', 'ApiWebRiderController@profile');
    Route::get('my-wallet', 'ApiWebRiderController@my_wallet');
    Route::get('trip-history', 'ApiWebRiderController@trip_history');
    Route::get('scheduled-trips', 'ApiWebRiderController@scheduled_trips');

    Route::get('edit-profile', 'ApiWebRiderController@edit_profile');
    Route::post('edit-profile-save', 'ApiWebRiderController@edit_profile_save')->name('edit-profile-save');
    Route::get('change-password', 'ApiWebRiderController@change_password');
    Route::post('change-password-save', 'ApiWebRiderController@change_password_save')->name('change-password-save');
    Route::get('logout', 'ApiWebRiderController@logout')->name('rider-logout');
});



Route::prefix('web/driver')->group(function () {
    Route::get('registration-form', 'ApiWebDriverController@registration_form');
    Route::post('driver-registration-form-save', 'ApiWebDriverController@driver_registration_form_save')->name('driver-registration-form-save');
    Route::get('registration-success', 'ApiWebDriverController@registration_success');
    Route::get('get-district-branch/{id}', 'GeneralInformationController@get_district_branch');

    Route::get('login-form', 'ApiWebDriverController@login_form');
    Route::post('driver-login-check', 'ApiWebDriverController@driver_login_check')->name('driver-login-check');
    Route::get('password-reset/request-form', 'Auth\ForgotPasswordController@password_reset_request_form')->name('driver.password.request');
    Route::post('password-reset/send-reset-link-email', 'Auth\ForgotPasswordController@password_reset_send_reset_link_email');
    Route::get('password-reset/reset-form/{token}', 'Auth\ResetPasswordController@password_reset_form')->name('driver.password.reset');
    Route::post('password/reset-submit', 'Auth\ResetPasswordController@password_reset_submit');

    Route::get('profile', 'ApiWebDriverController@profile');
    Route::get('my-earnings', 'ApiWebDriverController@my_earnings');
    Route::get('trip-history', 'ApiWebDriverController@trip_history');
    Route::get('upcoming-trips', 'ApiWebDriverController@upcoming_trips');
    Route::get('tax-and-insurance', 'ApiWebDriverController@tax_and_insurance');

    Route::get('edit-profile', 'ApiWebDriverController@edit_profile');
    Route::post('edit-profile-save', 'ApiWebDriverController@edit_profile_save')->name('edit-profile-save');
    Route::get('change-password', 'ApiWebDriverController@change_password');
    Route::post('change-password-save', 'ApiWebDriverController@change_password_save')->name('change-password-save');
    Route::get('logout', 'ApiWebDriverController@logout')->name('driver-logout');
});
