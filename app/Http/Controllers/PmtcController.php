<?php

namespace App\Http\Controllers;

ini_set('max_execution_time', 0);
ini_set('memory_limit', '1024M');

use Illuminate\Http\Request;
use\App\Models\Pmtct;
use\App\Models\Client;
use\App\Models\Appointments;
use Carbon\Carbon;

class PmtcController extends Controller
{
    public function get_pmtct_clients_data()
    {
        $data = [];
         
        
         // mother pmtct
        $all_pmtct_clients = Pmtct::select('client_id')->whereNotNull('client_id');
 
        //mother appointment
        $honored_appointment_clients = Appointments::select('client_id')->where('appointment_kept', '=', 'Yes')->whereIn('client_id', $all_pmtct_clients);
        $unschedule_appointment_clients = Appointments::select('client_id')->where('visit_type', '=', 'Un-Scheduled')->whereIn('client_id', $all_pmtct_clients);
        $scheduled_appointment_clients = Appointments::select('client_id')->where('visit_type', '=', 'Scheduled')->whereIn('client_id', $all_pmtct_clients);
        $missed_appointment_clients = Appointments::select('client_id')->where('app_status', '=', 'Missed')->whereIn('client_id', $all_pmtct_clients);
        $defaulted_appointment_clients = Appointments::select('client_id')->where('app_status', '=', 'Defaulted')->whereIn('client_id', $all_pmtct_clients);
        $ltfu_appointment_clients = Appointments::select('client_id')->where('app_status', '=', 'LTFU')->whereIn('client_id', $all_pmtct_clients);
       // $deceased_appointment_clients = Appointments::select('client_id')->where('app_status', '=', 'Deceased')->whereIn('client_id', $all_pmtct_clients);
        $booked_appointment_clients = Appointments::select('client_id')->where('app_status', '=', 'Booked')->whereIn('client_id', $all_pmtct_clients);

        // mother as client
        $all_honored_appointment_clients = Client::selectRaw('id, clinic_number, CONCAT(f_name, " ", m_name, "", l_name) AS client_name')->whereIn('id', $honored_appointment_clients);
        $all_unschedule_appointment_clients = Client::selectRaw('id, clinic_number, CONCAT(f_name, " ", m_name, "", l_name) AS client_name')->whereIn('id', $unschedule_appointment_clients);
        $all_schedule_appointment_clients = Client::selectRaw('id, clinic_number, CONCAT(f_name, " ", m_name, "", l_name) AS client_name')->whereIn('id', $scheduled_appointment_clients);
        $all_missed_appointment_clients = Client::selectRaw('id, clinic_number, CONCAT(f_name, " ", m_name, "", l_name) AS client_name')->whereIn('id', $missed_appointment_clients);
        $all_defaulted_appointment_clients = Client::selectRaw('id, clinic_number, CONCAT(f_name, " ", m_name, "", l_name) AS client_name')->whereIn('id', $defaulted_appointment_clients);
        $all_deceased_pmtct_clients = Client::selectRaw('id, clinic_number, CONCAT(f_name, " ", m_name, "", l_name) AS client_name')->where('status', '=', 'Deceased')->whereIn('id', $all_pmtct_clients);
        $all_ltfu_pmtct_clients = Client::selectRaw('id, clinic_number, CONCAT(f_name, " ", m_name, "", l_name) AS client_name')->whereIn('id', $ltfu_appointment_clients);
        $all_booked_pmtct_clients = Client::select('id', 'clinic_number', 'f_name', 'm_name', 'l_name')->whereIn('id', $booked_appointment_clients);
        
        
        // mother data
        $data['all_honored_appointment_clients'] = $all_honored_appointment_clients->count();
        $data['all_unschedule_appointment_clients'] = $all_unschedule_appointment_clients->count();
        $data['all_schedule_appointment_clients'] = $all_schedule_appointment_clients->count();
        $data['all_missed_appointment_clients'] = $all_missed_appointment_clients->count();
        $data['all_defaulted_appointment_clients'] = $all_defaulted_appointment_clients->count();
        $data['all_deceased_pmtct_clients'] = $all_deceased_pmtct_clients->count();
        $data['all_ltfu_pmtct_clients'] = $all_ltfu_pmtct_clients->count();
        $data['all_booked_pmtct_clients'] = $all_booked_pmtct_clients->get();

        // hei pmtct
    
        return $data;

    }

    public function get_pmtct_booked_clients()
    {
        $all_booked_pmtct_clients = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
        ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')

        ->selectRaw('tbl_client.clinic_number, tbl_client.f_name, tbl_client.m_name, tbl_client.l_name, tbl_appointment.appntmnt_date')
       ->where('tbl_appointment.app_status', '=', 'Booked')
       ->where('tbl_appointment.appntmnt_date', '>=', Now());

        return view('pmtct.booked_clients')->with('all_booked_pmtct_clients', $all_booked_pmtct_clients->get());
    }

    public function get_pmtct_honored_appointment()
    {
        $all_honored_appointment_clients = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
        ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
       //->innerJoin('tbl_appointment_types')->ON('tbl_appointment_types.id', '=', 'tbl_appointment.app_type_1')
        ->selectRaw('tbl_client.clinic_number, tbl_client.f_name, tbl_client.m_name, tbl_client.l_name, tbl_appointment.appntmnt_date')
        ->where('appointment_kept', '=', 'Yes');

        return view('pmtct/kept_appointments')->with('all_honored_appointment_clients', $all_honored_appointment_clients->get());
    }

    public function get_pmtct_scheduled_appointments()
    {
        $all_schedule_appointment_clients = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
        ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
       //->innerJoin('tbl_appointment_types')->ON('tbl_appointment_types.id', '=', 'tbl_appointment.app_type_1')
        ->selectRaw('tbl_client.clinic_number, tbl_client.f_name, tbl_client.m_name, tbl_client.l_name, tbl_appointment.appntmnt_date')
        ->where('visit_type', '=', 'Scheduled');

        return view('pmtct/scheduled_appointments')->with('all_schedule_appointment_clients', $all_schedule_appointment_clients->get());
    }

    public function get_pmtct_unscheduled_appointments()
    {
        $all_pmtct_clients = Pmtct::select('client_id')->whereNotNull('client_id');
        $unschedule_appointment_clients = Appointments::select('client_id')->where('visit_type', '=', 'Un-Scheduled')->whereIn('client_id', $all_pmtct_clients);
        $all_unschedule_appointment_clients = Client::select('id', 'clinic_number', 'f_name', 'm_name', 'l_name')->whereIn('id', $unschedule_appointment_clients);

        return view('pmtct/unscheduled_appointments')->with('all_unschedule_appointment_clients', $all_unschedule_appointment_clients->get());
    }

    public function get_pmtct_missed_clients()
    {
        $all_missed_appointment_clients = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
        ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
       //->innerJoin('tbl_appointment_types')->ON('tbl_appointment_types.id', '=', 'tbl_appointment.app_type_1')
        ->selectRaw('tbl_client.clinic_number, tbl_client.f_name, tbl_client.m_name, tbl_client.l_name, tbl_appointment.appntmnt_date')
        ->where('app_status', '=', 'Missed');

        return view('pmtct/missed_appointments')->with('all_missed_appointment_clients', $all_missed_appointment_clients->get());
    }

    public function get_pmtct_defaulted_clients()
    {
        $all_defaulted_appointment_clients = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
        ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
       //->innerJoin('tbl_appointment_types')->ON('tbl_appointment_types.id', '=', 'tbl_appointment.app_type_1')
        ->selectRaw('tbl_client.clinic_number, tbl_client.f_name, tbl_client.m_name, tbl_client.l_name, tbl_appointment.appntmnt_date')
        ->where('app_status', '=', 'Defaulted');

        return view('pmtct/defaulted_appointments')->with('all_defaulted_appointment_clients', $all_defaulted_appointment_clients->get());
    }

    public function get_pmtct_ltfu_clients()
    {
        $all_ltfu_pmtct_clients = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
        ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
       //->innerJoin('tbl_appointment_types')->ON('tbl_appointment_types.id', '=', 'tbl_appointment.app_type_1')
        ->selectRaw('tbl_client.clinic_number, tbl_client.f_name, tbl_client.m_name, tbl_client.l_name, tbl_appointment.appntmnt_date')
        ->where('app_status', '=', 'LTFU');
        
        return view('pmtct/ltfu_appointments')->with('all_ltfu_pmtct_clients', $all_ltfu_pmtct_clients->get());
    }

    public function get_deceased_clients()
    {
        $all_pmtct_clients = Pmtct::select('client_id')->whereNotNull('client_id');
        $all_deceased_pmtct_clients = Client::select('id', 'clinic_number', 'f_name', 'm_name', 'l_name')->where('status', '=', 'Deceased')->whereIn('id', $all_pmtct_clients);

        return view('pmtct/deceased_clients')->with('all_deceased_pmtct_clients', $all_deceased_pmtct_clients->get());
    }

}