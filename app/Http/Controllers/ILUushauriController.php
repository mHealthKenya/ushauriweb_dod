<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointments;
use App\Models\Message;
use App\Models\Client;
use App\Models\Facility;
use App\Models\County;
use App\Models\Partner;

class ILUushauriController extends Controller
{
  public function il_dashboard()
  {

    $il_appointments = Appointments::select(\DB::raw("client_id as count"))
      ->where('db_source', '=', 'KENYAEMR')
      ->orwhere('db_source', '=', 'ADT')
      ->count();

    $il_future_apps = Appointments::select(\DB::raw("client_id as count"))
      ->where('appntmnt_date', '>', Now())
      ->where('db_source', '=', 'KENYAEMR')
      ->orwhere('db_source', '=', 'ADT')
      ->count();

    $messages_count = Appointments::join('tbl_client', 'tbl_client.id', '=', 'tbl_appointment.client_id')
      ->join('tbl_clnt_outgoing', 'tbl_clnt_outgoing.clnt_usr_id', '=', 'tbl_client.id')
      ->select(\DB::raw("tbl_clnt_outgoing.id as count"))
      ->where('tbl_clnt_outgoing.recepient_type', '=', 'Client')
      ->where('tbl_appointment.client_id', '=', 'tbl_client.id')
      ->where('tbl_appointment.db_source', '=', 'KENYAEMR')
      ->orwhere('tbl_appointment.db_source', '=', 'ADT')
      ->count();
    $il_facilities = Client::join('tbl_appointment', 'tbl_appointment.client_id', '=', 'tbl_client.id')
      ->join('tbl_master_facility', 'tbl_master_facility.code', '=', 'tbl_client.mfl_code')
      ->select(\DB::raw("COUNT(tbl_master_facility.name) as count"))
      // ->select('tbl_master_facility.name as facility', 'tbl_master_facility.code', 'tbl_partner.name as partner')
      ->groupBy('tbl_client.mfl_code')
      ->where('tbl_appointment.client_id', '=', 'tbl_client.id')
      ->where('tbl_appointment.db_source', '=', 'KENYAEMR')
      ->orwhere('tbl_appointment.db_source', '=', 'ADT')
      ->pluck('count');

    $il_partners = Client::join('tbl_appointment', 'tbl_appointment.client_id', '=', 'tbl_client.id')
      ->join('tbl_partner', 'tbl_partner.id', '=', 'tbl_client.partner_id')
      ->select(\DB::raw("tbl_partner.name as count"))
      // ->select('tbl_partner.name as partner')
      ->groupBy('tbl_partner.name')
      ->where('tbl_appointment.client_id', '=', 'tbl_client.id')
      ->where('tbl_appointment.db_source', '=', 'KENYAEMR')
      ->orwhere('tbl_appointment.db_source', '=', 'ADT')
      ->count();

    $il_kenyaemr = Appointments::select(\DB::raw("COUNT(client_id) as count"))
      ->where('db_source', '=', 'KENYAEMR')
      ->pluck('count');

    $il_adt = Appointments::select(\DB::raw("COUNT(client_id) as count"))
      ->where('db_source', '=', 'ADT')
      ->pluck('count');

    $il_registration = Client::select(\DB::raw("COUNT(id) as count"))
      ->where('entry_point', '=', 'IL')
      ->pluck('count');

    $all_partners = Partner::where('status', '=', 'Active')->pluck('name', 'id');
    $all_counties = County::select('id', 'name')->get();


    //dd($il_kenyaemr);

    return view('dashboard.il_dashboard', compact('all_partners', 'all_counties', 'il_appointments', 'il_registration', 'il_future_apps', 'messages_count', 'il_facilities', 'il_partners', 'il_kenyaemr', 'il_adt'));
  }

  public function facilities_il()
  {
    $il_facilities_list = Client::join('tbl_appointment', 'tbl_appointment.client_id', '=', 'tbl_client.id')
      ->join('tbl_master_facility', 'tbl_master_facility.code', '=', 'tbl_client.mfl_code')
      ->join('tbl_partner', 'tbl_partner.id', '=', 'tbl_client.partner_id')
      ->join('tbl_county', 'tbl_master_facility.county_id', '=', 'tbl_county.id')
      ->join('tbl_sub_county', 'tbl_master_facility.Sub_County_ID', '=', 'tbl_sub_county.id')
      ->select('tbl_master_facility.name as facility', 'tbl_county.name as county', 'tbl_sub_county.name as subcounty', 'tbl_master_facility.code', 'tbl_partner.name as partner')
      ->groupBy('tbl_client.mfl_code')
      ->where('tbl_appointment.client_id', '=', 'tbl_client.id')
      ->where('tbl_appointment.db_source', '=', 'KENYAEMR')
      ->orwhere('tbl_appointment.db_source', '=', 'ADT')
      ->get();

    return view('facilities.facilities_il', compact('il_facilities_list'));
  }

  public function partners_il()
  {
    $il_partners = Client::join('tbl_appointment', 'tbl_appointment.client_id', '=', 'tbl_client.id')

      ->join('tbl_partner', 'tbl_partner.id', '=', 'tbl_client.partner_id')
      ->select('tbl_partner.name as partner')
      ->groupBy('tbl_partner.name')
      ->where('tbl_appointment.client_id', '=', 'tbl_client.id')
      ->where('tbl_appointment.db_source', '=', 'KENYAEMR')
      ->orwhere('tbl_appointment.db_source', '=', 'ADT')
      ->get();

    return view('partners.partner_il', compact('il_partners'));
  }
  public function filter_ildashboard(Request $request)
  {
    $data = [];

    $selected_partners = $request->partners;
    $selected_counties = $request->counties;
    $selected_subcounties = $request->subcounties;
    $selected_facilites = $request->facilities;

    $il_appointments = Appointments::select('client_id')
      ->where('db_source', '=', 'KENYAEMR')
      ->orwhere('db_source', '=', 'ADT');

    $il_future_apps = Appointments::select('client_id')
      ->where('appntmnt_date', '>', Now())
      ->where('db_source', '=', 'KENYAEMR')
      ->orwhere('db_source', '=', 'ADT');

    $messages_count = Appointments::join('tbl_client', 'tbl_client.id', '=', 'tbl_appointment.client_id')
      ->join('tbl_clnt_outgoing', 'tbl_clnt_outgoing.clnt_usr_id', '=', 'tbl_client.id')
      ->select('tbl_clnt_outgoing.id')
      ->where('tbl_clnt_outgoing.recepient_type', '=', 'Client')
      ->where('tbl_appointment.client_id', '=', 'tbl_client.id')
      ->where('tbl_appointment.db_source', '=', 'KENYAEMR')
      ->orwhere('tbl_appointment.db_source', '=', 'ADT');

    $il_facilities = Client::join('tbl_appointment', 'tbl_appointment.client_id', '=', 'tbl_client.id')
      ->join('tbl_master_facility', 'tbl_master_facility.code', '=', 'tbl_client.mfl_code')
      ->select('tbl_master_facility.name')
      ->groupBy('tbl_client.mfl_code')
      ->where('tbl_appointment.client_id', '=', 'tbl_client.id')
      ->where('tbl_appointment.db_source', '=', 'KENYAEMR')
      ->orwhere('tbl_appointment.db_source', '=', 'ADT');

    $il_partners = Client::join('tbl_appointment', 'tbl_appointment.client_id', '=', 'tbl_client.id')
      ->join('tbl_partner', 'tbl_partner.id', '=', 'tbl_client.partner_id')
      ->select('tbl_partner.name')
      ->groupBy('tbl_partner.name')
      ->where('tbl_appointment.client_id', '=', 'tbl_client.id')
      ->where('tbl_appointment.db_source', '=', 'KENYAEMR')
      ->orwhere('tbl_appointment.db_source', '=', 'ADT');

    $il_kenyaemr = Appointments::select('client_id')->where('db_source', '=', 'KENYAEMR');

    $il_adt = Appointments::select('client_id')->where('db_source', '=', 'ADT');

    $il_registration = Client::select('id')->where('entry_point', '=', 'IL');

    if (!empty($selected_partners)) {
      $il_appointments = $il_appointments->join('tbl_client', 'tbl_appointment.client_id', '=', 'tbl_client.id')->where('tbl_client.partner_id', $selected_partners);
      $il_future_apps = $il_future_apps->join('tbl_client', 'tbl_appointment.client_id', '=', 'tbl_client.id')->where('tbl_client.partner_id', $selected_partners);
      $messages_count = $messages_count->where('tbl_client.partner_id', $selected_partners);
      $il_facilities = $il_facilities->where('tbl_client.partner_id', $selected_partners);
      $il_partners = $il_partners->where('tbl_client.partner_id', $selected_partners);
      $il_kenyaemr = $il_kenyaemr->join('tbl_client', 'tbl_appointment.client_id', '=', 'tbl_client.id')->where('tbl_client.partner_id', $selected_partners);
      $il_adt = $il_adt->join('tbl_client', 'tbl_appointment.client_id', '=', 'tbl_client.id')->where('tbl_client.partner_id', $selected_partners);
      $il_registration = $il_registration->where('partner_id', $selected_partners);
    }

    if (!empty($selected_facilites)) {
      $il_appointments = $il_appointments->join('tbl_client', 'tbl_appointment.client_id', '=', 'tbl_client.id')->where('tbl_client.mfl_code', $selected_facilites);
      $il_future_apps = $il_future_apps->join('tbl_client', 'tbl_appointment.client_id', '=', 'tbl_client.id')->where('tbl_client.mfl_code', $selected_facilites);
      $messages_count = $messages_count->where('tbl_client.mfl_code', $selected_facilites);
      $il_facilities = $il_facilities->where('tbl_client.mfl_code', $selected_facilites);
      $il_partners = $il_partners->where('tbl_client.mfl_code', $selected_facilites);
      $il_kenyaemr = $il_kenyaemr->join('tbl_client', 'tbl_appointment.client_id', '=', 'tbl_client.id')->where('tbl_client.mfl_code', $selected_facilites);
      $il_adt = $il_adt->join('tbl_client', 'tbl_appointment.client_id', '=', 'tbl_client.id')->where('tbl_client.mfl_code', $selected_facilites);
      $il_registration = $il_registration->where('mfl_code', $selected_facilites);
    }

    if (!empty($selected_subcounties)) {
      $il_appointments = $il_appointments->join('tbl_client', 'tbl_appointment.client_id', '=', 'tbl_client.id')->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
      $il_future_apps = $il_future_apps->join('tbl_client', 'tbl_appointment.client_id', '=', 'tbl_client.id')->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
      $messages_count = $messages_count->join('tbl_client', 'tbl_appointment.client_id', '=', 'tbl_client.id')->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
      $il_facilities = $il_facilities->join('tbl_client', 'tbl_appointment.client_id', '=', 'tbl_client.id')->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
      $il_partners = $il_partners->join('tbl_client', 'tbl_appointment.client_id', '=', 'tbl_client.id')->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
      $il_kenyaemr = $il_kenyaemr->join('tbl_client', 'tbl_appointment.client_id', '=', 'tbl_client.id')->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
      $il_adt = $il_adt->join('tbl_client', 'tbl_appointment.client_id', '=', 'tbl_client.id')->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
      $il_registration = $il_registration->join('tbl_client', 'tbl_appointment.client_id', '=', 'tbl_client.id')->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
    }

    if (!empty($selected_counties)) {
      $il_appointments = $il_appointments->join('tbl_client', 'tbl_appointment.client_id', '=', 'tbl_client.id')->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')->where('tbl_partner_facility.county_id', $selected_counties);
      $il_future_apps = $il_future_apps->join('tbl_client', 'tbl_appointment.client_id', '=', 'tbl_client.id')->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')->where('tbl_partner_facility.county_id', $selected_counties);
      $messages_count = $messages_count->join('tbl_client', 'tbl_appointment.client_id', '=', 'tbl_client.id')->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')->where('tbl_partner_facility.county_id', $selected_counties);
      $il_facilities = $il_facilities->join('tbl_client', 'tbl_appointment.client_id', '=', 'tbl_client.id')->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')->where('tbl_partner_facility.county_id', $selected_counties);
      $il_partners = $il_partners->join('tbl_client', 'tbl_appointment.client_id', '=', 'tbl_client.id')->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')->where('tbl_partner_facility.county_id', $selected_counties);
      $il_kenyaemr = $il_kenyaemr->join('tbl_client', 'tbl_appointment.client_id', '=', 'tbl_client.id')->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')->where('tbl_partner_facility.county_id', $selected_counties);
      $il_adt = $il_adt->join('tbl_client', 'tbl_appointment.client_id', '=', 'tbl_client.id')->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')->where('tbl_partner_facility.county_id', $selected_counties);
      $il_registration = $il_registration->join('tbl_client', 'tbl_appointment.client_id', '=', 'tbl_client.id')->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')->where('tbl_partner_facility.county_id', $selected_counties);
    }

    $data["il_appointments"]        = $il_appointments->count();
    $data["il_future_apps"]        = $il_future_apps->count();
    $data["messages_count"]        = $messages_count->count();
    $data["il_facilities"]        = $il_facilities->count();
    $data["il_partners"]        = $il_partners->count();
    $data["il_kenyaemr"]        = $il_kenyaemr->count();
    $data["il_adt"]        = $il_adt->count();
    $data["il_registration"]        = $il_registration->count();

    return $data;
  }
}
