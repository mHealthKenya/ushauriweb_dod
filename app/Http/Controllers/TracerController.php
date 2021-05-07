<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tracer;
use App\Models\User;
use App\Models\Outcome;
use App\Models\Appointments;
use Session;
use Auth;
use DB;

class TracerController extends Controller
{
    public function tracer_client()
    {

      if (Auth::user()->access_level == 'Admin') {
        $tracer_client_list = Tracer::join('tbl_users', 'tbl_tracer_client.tracer_id', '=', 'tbl_users.id')
        ->join('tbl_client', 'tbl_tracer_client.client_id', '=', 'tbl_client.id')
        ->join('tbl_clinic', 'tbl_client.clinic_id', '=', 'tbl_clinic.id')
        ->select('tbl_client.clinic_number', 'tbl_client.phone_no as client_contact', 'tbl_clinic.name as clinic', DB::raw("CONCAT(`tbl_users`.`f_name`, ' ', `tbl_users`.`m_name`, ' ', `tbl_users`.`l_name`) as tracer_name"), 'tbl_users.phone_no as tracer_contact')
        ->get();
      }

      if (Auth::user()->access_level == 'Facility' && Auth::user()->role_id == 12) {
        $tracer_client_list = Tracer::join('tbl_users', 'tbl_tracer_client.tracer_id', '=', 'tbl_users.id')
        ->join('tbl_client', 'tbl_tracer_client.client_id', '=', 'tbl_client.id')
        ->join('tbl_clinic', 'tbl_client.clinic_id', '=', 'tbl_clinic.id')
        ->select('tbl_client.clinic_number', 'tbl_client.phone_no as client_contact', 'tbl_clinic.name as clinic', DB::raw("CONCAT(`tbl_users`.`f_name`, ' ', `tbl_users`.`m_name`, ' ', `tbl_users`.`l_name`) as tracer_name"), 'tbl_users.phone_no as tracer_contact')
        ->where('tbl_client.mfl_code', Auth::user()->facility_id)
        //->where('tbl_tracer_client.tracer_id', Auth::user()->id)
        ->get();
      }

      if (Auth::user()->access_level == 'Partner') {
        $tracer_client_list = Tracer::join('tbl_users', 'tbl_tracer_client.tracer_id', '=', 'tbl_users.id')
        ->join('tbl_client', 'tbl_tracer_client.client_id', '=', 'tbl_client.id')
        ->join('tbl_clinic', 'tbl_client.clinic_id', '=', 'tbl_clinic.id')
        ->select('tbl_client.clinic_number', 'tbl_client.phone_no as client_contact', 'tbl_clinic.name as clinic', DB::raw("CONCAT(`tbl_users`.`f_name`, ' ', `tbl_users`.`m_name`, ' ', `tbl_users`.`l_name`) as tracer_name"), 'tbl_users.phone_no as tracer_contact')
        ->where('tbl_client.partner_id', Auth::user()->partner_id)
        ->get();
      }

        return view('users.tracerclient')->with('tracer_client_list', $tracer_client_list );

    }
    public function tracing_cost()
  {
    if (Auth::user()->access_level == 'Admin') {
    $tracing_cost = Outcome::join('tbl_users', 'tbl_clnt_outcome.created_by', '=', 'tbl_users.id')
    ->join('tbl_client', 'tbl_clnt_outcome.client_id', '=', 'tbl_client.id')
    ->select('tbl_clnt_outcome.app_status', DB::raw("CONCAT(`tbl_users`.`f_name`, ' ', `tbl_users`.`m_name`, ' ', `tbl_users`.`l_name`) as tracer_name"), 'tbl_client.clinic_number', 'tbl_clnt_outcome.tracing_cost')
    ->whereNotNull('tbl_clnt_outcome.tracing_cost')
    ->get();
    }

    if (Auth::user()->access_level == 'Partner') {
      $tracing_cost = Outcome::join('tbl_users', 'tbl_clnt_outcome.created_by', '=', 'tbl_users.id')
    ->join('tbl_client', 'tbl_clnt_outcome.client_id', '=', 'tbl_client.id')
    ->select('tbl_clnt_outcome.app_status', DB::raw("sum(`tbl_clnt_outcome`.`tracing_cost`) as total_cost"), DB::raw("CONCAT(`tbl_users`.`f_name`, ' ', `tbl_users`.`m_name`, ' ', `tbl_users`.`l_name`) as tracer_name"), 'tbl_client.clinic_number', 'tbl_clnt_outcome.tracing_cost')
    ->where('tbl_client.partner_id', Auth::user()->partner_id)
    ->whereNotNull('tbl_clnt_outcome.tracing_cost')
    ->get();
    }
    if (Auth::user()->access_level == 'Facility') {
      $tracing_cost = Outcome::join('tbl_users', 'tbl_clnt_outcome.created_by', '=', 'tbl_users.id')
    ->join('tbl_client', 'tbl_clnt_outcome.client_id', '=', 'tbl_client.id')
    ->select('tbl_clnt_outcome.app_status', DB::raw("CONCAT(`tbl_users`.`f_name`, ' ', `tbl_users`.`m_name`, ' ', `tbl_users`.`l_name`) as tracer_name"), 'tbl_client.clinic_number', 'tbl_clnt_outcome.tracing_cost')
    ->where('tbl_client.mfl_code', Auth::user()->facility_id)
    ->whereNotNull('tbl_clnt_outcome.tracing_cost')
    ->get();

    $total_costing = Outcome::join('tbl_users', 'tbl_clnt_outcome.created_by', '=', 'tbl_users.id')
    ->join('tbl_client', 'tbl_clnt_outcome.client_id', '=', 'tbl_client.id')
    ->select(DB::raw("sum(`tbl_clnt_outcome`.`tracing_cost`) as total_cost"))
    ->where('tbl_client.mfl_code', Auth::user()->facility_id)
    ->get();
    }

    return view('tracing.tracing_cost')->with('tracing_cost', $tracing_cost);
  }

  public function booked_clients_tracing()
  {
    if (Auth::user()->access_level == 'Facility') {
    $all_booked = Appointments::join('tbl_client', 'tbl_appointment.client_id', '=', 'tbl_client.id')
    ->join('tbl_appointment_types', 'tbl_appointment.app_type_1', '=', 'tbl_appointment_types.id')
    ->leftjoin('tbl_tracer_client', 'tbl_client.id', '=', 'tbl_tracer_client.client_id')
    ->select('tbl_appointment.id as app_id', 'tbl_client.id as client_id', 'tbl_tracer_client.is_assigned', 'tbl_client.clinic_number as clinic_number', DB::raw("CONCAT(`tbl_client`.`f_name`, ' ', `tbl_client`.`m_name`, ' ', `tbl_client`.`l_name`) as client_name"), 'tbl_appointment.appntmnt_date', 'tbl_appointment_types.name as app_type')
    ->where('tbl_appointment.appntmnt_date', '>', Now())
    ->where('tbl_client.mfl_code', Auth::user()->facility_id)
    ->get();

    $get_tracers = User::select('id', DB::raw("CONCAT(`f_name`, ' ', `m_name`, ' ', `l_name`) as tracer_name"))
    ->where('role_id', '=', 12)
    ->where('facility_id', Auth::user()->facility_id)
    ->get();
  }

    return view('tracing.booked_clients', compact('all_booked', 'get_tracers'));
  }

  public function assign_client(Request $request)
  {
    try {
      $tracer = new Tracer;
      $tracer->client_id = $request->client_id;
      $tracer->tracer_id = $request->tracer_id;
      $tracer->is_assigned = "Yes";
      $tracer->updated_at = date('Y-m-d H:i:s');
      $tracer->created_at = date('Y-m-d H:i:s');

      $tracer->updated_by = Auth::user()->id;
      $tracer->created_by = Auth::user()->id;

               if ($tracer->save()) {
                   Session::flash('statuscode', 'success');
                  return redirect('clients/booked')->with('status', 'Client was successfully Assigned to a Tracer!');
              } else {
                  Session::flash('statuscode', 'error');
                  return back()->with('error', 'Could not assign client please try again later.');
              }
          } catch (Exception $e) {
              return back();
          }
  }
}
