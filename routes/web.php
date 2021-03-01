<?php

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

Route::get('/Login', function () {
    return view('sessions/signIn');
});

Auth::routes();


Route::group(['middleware' => 'auth'], function () {

    Route::get('/Reports/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/logout', ['uses'=>'App\Http\Controllers\Auth\LoginController@logout', 'as' => 'logout']);

    // Dashboard routes
    Route::get('/get_client_data', ['uses' => 'App\Http\Controllers\DashboardController@get_client_data', 'as' => 'get_client_data']);

    // DCM routes
   // Route::get('/get_client_data', ['uses' => 'App\Http\Controllers\DashboardController@get_client_data', 'as' => 'get_client_data']);
    Route::get('/get_dfc_clients', ['uses' => 'App\Http\Controller\DcmReportController@get_dfc_clients', 'as' => 'get_dfc_clients']);
    Route::get('/get_dcm_less_well', ['uses' => 'App\Http\Controllers\DcmReportController@get_dcm_less_well', 'as' => 'get_dcm_less_well']);
    Route::get('/get_dcm_less_advanced', ['uses' => 'App\Http\Controllers\DcmReportController@get_dcm_less_advanced', 'as' => 'get_dcm_less_advanced']);
    Route::get('/get_dcm_more_stable', ['uses' => 'App\Http\Controllers\DcmReportController@get_dcm_more_stable', 'as' => 'get_dcm_more_stable']);
    Route::get('/get_dcm_more_unstable', ['uses' => 'App\Http\Controllers\DcmReportController@get_dcm_more_unstable', 'as' => 'get_dcm_more_unstable']);

    // Appointments routes
    Route::get('get_future_appointments', ['uses'=>'App\Http\Controllers\AppointmentController@get_future_appointments', 'as' => 'get_future_appointments']);
    Route::get('report/appointments/missed', ['uses'=>'App\Http\Controllers\AppointmentController@get_missed_appointments', 'as' => 'report-appointments-missed']);
    Route::get('report/appointments/defaulted', ['uses'=>'App\Http\Controllers\AppointmentController@get_defaulted_appointments', 'as' => 'report-appointments-defaulted']);
    Route::get('report/appointments/ltfu_clients', ['uses'=>'App\Http\Controllers\AppointmentController@get_ltfu_appointments', 'as' => 'report-appointments-ltfu_clients']);
    Route::get('report/appointments', ['uses'=>'App\Http\Controllers\AppointmentController@get_appointment_list', 'as' => 'report-appointments']);
    //Route::get('report/edit-appointments', ['uses'=>'App\Http\Controllers\AppointmentController@get_appointment_list', 'as' => 'report-appointments']);

    // wellness routes
    Route::get('report/ok_clients', ['uses'=>'App\Http\Controllers\WellnessController@get_ok_clients', 'as' => 'report-ok_clients']);
    Route::get('report/not_ok_clients', ['uses'=>'App\Http\Controllers\WellnessController@get_not_ok_clients', 'as' => 'report-not_ok_clients']);
    Route::get('report/unrecognised_response', ['uses'=>'App\Http\Controllers\WellnessController@get_unrecoginised_clients', 'as' => 'report-unrecognised_response']);

    // grouping routes
    Route::get('report/adolescent_clients', ['uses'=>'App\Http\Controllers\GroupController@get_adolescents_clients', 'as' => 'report-adolescent_clients']);
    Route::get('report/pmtct_clients', ['uses'=>'App\Http\Controllers\GroupController@get_pmtct_clients', 'as' => 'report-pmtct_clients']);
    Route::get('report/adults_clients', ['uses'=>'App\Http\Controllers\GroupController@get_psc_clients', 'as' => 'report-adults_clients']);
    Route::get('report/paeds_clients', ['uses'=>'App\Http\Controllers\GroupController@get_paeds_clients', 'as' => 'report-paeds_clients']);

    //routes for bulk clients upload
    Route::get('/upload/clients/form', ['uses'=>'App\Http\Controllers\BulkUploadController@uploadClientForm', 'as' => 'upload-clients-form']);
    Route::post('/import/client/file', ['uses'=>'App\Http\Controllers\BulkUploadController@importClients', 'as' => 'client-file-import']);
    Route::get('/download/client/template', ['uses'=>'App\Http\Controllers\BulkUploadController@downloadClientTemplate', 'as' => 'client-template-download']);


    // PMTCT routes
    Route::get('/get_pmtct_clients_data', ['uses' => 'App\Http\Controllers\PmtcController@get_pmtct_clients_data', 'as' => 'get_pmtct_clients_data']);

    Route::get('/get_pmtct_booked_clients', ['uses' => 'App\Http\Controllers\PmtcController@get_pmtct_booked_clients', 'as' => 'get_pmtct_booked_clients']);
    Route::get('/get_pmtct_honored_appointment', ['uses' => 'App\Http\Controllers\PmtcController@get_pmtct_honored_appointment', 'as' => 'get_pmtct_honored_appointment']);
    Route::get('/get_pmtct_scheduled_appointments', ['uses' => 'App\Http\Controllers\PmtcController@get_pmtct_scheduled_appointments', 'as' => 'get_pmtct_scheduled_appointments']);
    Route::get('/get_pmtct_unscheduled_appointments', ['uses' => 'App\Http\Controllers\PmtcController@get_pmtct_unscheduled_appointments', 'as' => 'get_pmtct_unscheduled_appointments']);
    Route::get('/get_pmtct_missed_clients', ['uses' => 'App\Http\Controllers\PmtcController@get_pmtct_missed_clients', 'as' => 'get_pmtct_missed_clients']);
    Route::get('/get_pmtct_defaulted_clients', ['uses' => 'App\Http\Controllers\PmtcController@get_pmtct_defaulted_clients', 'as' => 'get_pmtct_defaulted_clients']);
    Route::get('/get_pmtct_ltfu_clients', ['uses' => 'App\Http\Controllers\PmtcController@get_pmtct_ltfu_clients', 'as' => 'get_pmtct_ltfu_clients']);
    Route::get('/get_deceased_clients', ['uses' => 'App\Http\Controllers\PmtcController@get_deceased_clients', 'as' => 'get_deceased_clients']);

    Route::get('/report/all_heis', ['uses' => 'App\Http\Controllers\PmtcController@get_all_hei', 'as' => 'report-all_heis']);
    Route::get('/report/booked_heis', ['uses' => 'App\Http\Controllers\PmtcController@get_booked_hei', 'as' => 'report-booked_heis']);
    Route::get('/report/scheduled_heis', ['uses' => 'App\Http\Controllers\PmtcController@get_scheduled_hei', 'as' => 'report-scheduled_heis']);
    Route::get('/report/unscheduled_heis', ['uses' => 'App\Http\Controllers\PmtcController@get_unscheduled_hei', 'as' => 'report-unscheduled_heis']);
    Route::get('/report/missed_heis', ['uses' => 'App\Http\Controllers\PmtcController@get_missed_hei', 'as' => 'report-missed_heis']);
    Route::get('/report/defaulted_heis', ['uses' => 'App\Http\Controllers\PmtcController@get_defaulted_hei', 'as' => 'report-defaulted_heis']);
    Route::get('/report/ltfu_heis', ['uses' => 'App\Http\Controllers\PmtcController@get_ltfu_hei', 'as' => 'report-ltfu_heis']);
    Route::get('/report/deceased_heis', ['uses' => 'App\Http\Controllers\PmtcController@get_deceased_hei', 'as' => 'report-deceased_heis']);
});