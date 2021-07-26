<?php

namespace App\Http\Controllers;

ini_set('max_execution_time', 0);
ini_set('memory_limit', '1024M');

use Illuminate\Http\Request;
use\App\Models\Pmtct;
use\App\Models\Client;
use\App\Models\Appointments;
use Carbon\Carbon;
use Auth;

class FilterController extends Controller
{
    public function filter_pmtct_dashboard(Request $request)
    {

        if (Auth::user()->access_level == 'Facility') {
        $ranges = [

            'ToNine' => 0,
            'ToFourteen' => 10,
            'ToNineteen' => 15,
            'ToTwentyFour' => 20,
            'ToTwentyNine' => 25,
            'ToThirtyFour' => 30,
            'ToThirtyNine' => 35,
            'ToFortyFour' => 40,
            'ToFortyNine' => 45,
            'FiftyPlus' => 50
        ];

        $startdate = Appointments::select('appntmnt_date')->orderBy('appntmnt_date', 'asc')->first();
        $startdate = Carbon::parse($startdate->appntmnt_date)->format('Y-m-d');
        $enddate  = Appointments::select('appntmnt_date')->orderBy('appntmnt_date', 'desc')->first();
        $enddate = Carbon::parse($enddate->appntmnt_date)->format('Y-m-d');

            $tonine_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 9)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            //->where('tbl_appointment.visit_type', '=', 'Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
           // ->whereDate('tbl_appointment.appntmnt_date', '>=', $startdate)->whereDate('tbl_appointment.appntmnt_date', '<=', $enddate)
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tofourteen_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 10) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 14)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tonineteen_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 15) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 19)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $totwentyfour_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 20) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 24)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $totwentynine_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 25) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 29)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tothirtyfour_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 30) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 34)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tothirtynine_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 35) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 39)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tofortyfour_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 40) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 44)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tofortynine_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 45) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 49)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tofiftyplus_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 50)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tototal_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) >=10)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            // Un-Scheduled
            $tonine_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 9)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tofourteen_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 10) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 14)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tonineteen_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 15) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 19)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $totwentyfour_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 20) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 24)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $totwentynine_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 25) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 29)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tothirtyfour_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 30) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 34)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tothirtynine_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 35) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 39)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tofortyfour_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 40) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 44)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tofortynine_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 45) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 49)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tofifty_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 50) and ((year(curdate()) - year(`tbl_client`.`dob`)) >= 50)) then `tbl_pmtct`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tototal_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->whereNull('tbl_client.hei_no')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) >=10)) then `tbl_client`.`id` end)) AS count"))
            ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            //Booked
            $tonine_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 9)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Booked')
            ->where('tbl_appointment.appntmnt_date', '>', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tofourteen_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 10) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 14)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Booked')
            ->where('tbl_appointment.appntmnt_date', '>', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tonineteen_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 15) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 19)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Booked')
            ->where('tbl_appointment.appntmnt_date', '>', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $totwentyfour_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 20) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 24)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Booked')
            ->where('tbl_appointment.appntmnt_date', '>', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $totwentynine_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 25) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 29)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Booked')
            ->where('tbl_appointment.appntmnt_date', '>', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tothirtyfour_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 30) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 34)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Booked')
            ->where('tbl_appointment.appntmnt_date', '>', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tothirtynine_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 35) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 39)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Booked')
            ->where('tbl_appointment.appntmnt_date', '>', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tofortyfour_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 40) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 44)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Booked')
            ->where('tbl_appointment.appntmnt_date', '>', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tofortynine_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 45) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 49)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Booked')
            ->where('tbl_appointment.appntmnt_date', '>', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tofifty_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 50) and ((year(curdate()) - year(`tbl_client`.`dob`)) >= 50)) then `tbl_pmtct`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Booked')
            ->where('tbl_appointment.appntmnt_date', '>', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tototal_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->whereNull('tbl_client.hei_no')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) >=10)) then `tbl_client`.`id` end)) AS count"))
            ->where('tbl_appointment.app_status', '=', 'Booked')
            ->where('tbl_appointment.appntmnt_date', '>', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            // Defaulter

            $tonine_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 9)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Defaulted')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tofourteen_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 10) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 14)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Defaulted')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tonineteen_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 15) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 19)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Defaulted')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $totwentyfour_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 20) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 24)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Defaulted')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $totwentynine_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 25) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 29)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Defaulted')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tothirtyfour_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 30) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 34)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Defaulted')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tothirtynine_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 35) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 39)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Defaulted')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tofortyfour_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 40) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 44)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Defaulted')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tofortynine_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 45) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 49)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Defaulted')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tofifty_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 50) and ((year(curdate()) - year(`tbl_client`.`dob`)) >= 50)) then `tbl_pmtct`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Defaulted')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tototal_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->whereNull('tbl_client.hei_no')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) >=10)) then `tbl_client`.`id` end)) AS count"))
            ->where('tbl_appointment.app_status', '=', 'Defaulted')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            // Missed
            $tonine_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 9)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Missed')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tofourteen_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 10) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 14)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Missed')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tonineteen_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 15) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 19)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Missed')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $totwentyfour_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 20) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 24)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Missed')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $totwentynine_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 25) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 29)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Missed')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tothirtyfour_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 30) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 34)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Missed')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tothirtynine_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 35) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 39)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Missed')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tofortyfour_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 40) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 44)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Missed')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tofortynine_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 45) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 49)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Missed')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tofifty_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 50) and ((year(curdate()) - year(`tbl_client`.`dob`)) >= 50)) then `tbl_pmtct`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Missed')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tototal_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->whereNull('tbl_client.hei_no')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) >=10)) then `tbl_client`.`id` end)) AS count"))
            ->where('tbl_appointment.app_status', '=', 'Missed')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            // LTFU
            $tonine_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 9)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'LTFU')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tofourteen_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 10) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 14)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'LTFU')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tonineteen_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 15) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 19)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'LTFU')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $totwentyfour_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 20) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 24)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'LTFU')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $totwentynine_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 25) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 29)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'LTFU')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tothirtyfour_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 30) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 34)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'LTFU')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tothirtynine_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 35) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 39)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'LTFU')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tofortyfour_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 40) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 44)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'LTFU')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tofortynine_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 45) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 49)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'LTFU')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tofifty_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 50) and ((year(curdate()) - year(`tbl_client`.`dob`)) >= 50)) then `tbl_pmtct`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'LTFU')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tototal_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->whereNull('tbl_client.hei_no')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) >=10)) then `tbl_client`.`id` end)) AS count"))
            ->where('tbl_appointment.app_status', '=', 'LTFU')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            // honoured appointments
            $tonine_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 9)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appointment_kept', '=', 'Yes')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tofourteen_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 10) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 14)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appointment_kept', '=', 'Yes')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tonineteen_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 15) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 19)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appointment_kept', '=', 'Yes')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $totwentyfour_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 20) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 24)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appointment_kept', '=', 'Yes')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $totwentynine_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 25) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 29)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appointment_kept', '=', 'Yes')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tothirtyfour_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 30) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 34)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appointment_kept', '=', 'Yes')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tothirtynine_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 35) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 39)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appointment_kept', '=', 'Yes')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tofortyfour_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 40) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 44)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appointment_kept', '=', 'Yes')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tofortynine_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 45) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 49)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appointment_kept', '=', 'Yes')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tofifty_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 50) and ((year(curdate()) - year(`tbl_client`.`dob`)) >= 50)) then `tbl_pmtct`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appointment_kept', '=', 'Yes')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');

            $tototal_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->whereNull('tbl_client.hei_no')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) >=10)) then `tbl_client`.`id` end)) AS count"))
            ->where('tbl_appointment.appointment_kept', '=', 'Yes')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->where('tbl_client.mfl_code', Auth::user()->facility_id)
            ->pluck('count');
        }

        // partner level

        if (Auth::user()->access_level == 'Partner') {


                $tonine_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                 ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 9)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
               // ->where('tbl_appointment.visit_type', '=', 'Scheduled')
                ->where('tbl_appointment.appntmnt_date', '<', Now())
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tofourteen_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                 ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 10) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 14)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.appntmnt_date', '<', Now())
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tonineteen_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                 ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 15) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 19)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.appntmnt_date', '<', Now())
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $totwentyfour_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                 ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 20) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 24)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.appntmnt_date', '<', Now())
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $totwentynine_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 25) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 29)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.appntmnt_date', '<', Now())
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tothirtyfour_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 30) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 34)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.appntmnt_date', '<', Now())
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tothirtynine_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 35) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 39)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.appntmnt_date', '<', Now())
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tofortyfour_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 40) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 44)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.appntmnt_date', '<', Now())
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tofortynine_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 45) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 49)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.appntmnt_date', '<', Now())
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tofiftyplus_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 50)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.appntmnt_date', '<', Now())
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tototal_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) >=10)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.appntmnt_date', '<', Now())
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                // Un-Scheduled
                $tonine_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                 ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 9)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
                ->where('tbl_appointment.appntmnt_date', '<', Now())
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tofourteen_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                 ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 10) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 14)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
                ->where('tbl_appointment.appntmnt_date', '<', Now())
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tonineteen_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                 ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 15) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 19)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
                ->where('tbl_appointment.appntmnt_date', '<', Now())
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $totwentyfour_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                 ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 20) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 24)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
                ->where('tbl_appointment.appntmnt_date', '<', Now())
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $totwentynine_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 25) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 29)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
                ->where('tbl_appointment.appntmnt_date', '<', Now())
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tothirtyfour_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 30) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 34)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
                ->where('tbl_appointment.appntmnt_date', '<', Now())
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tothirtynine_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 35) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 39)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
                ->where('tbl_appointment.appntmnt_date', '<', Now())
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tofortyfour_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 40) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 44)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
                ->where('tbl_appointment.appntmnt_date', '<', Now())
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tofortynine_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 45) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 49)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
                ->where('tbl_appointment.appntmnt_date', '<', Now())
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tofifty_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 50) and ((year(curdate()) - year(`tbl_client`.`dob`)) >= 50)) then `tbl_pmtct`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
                ->where('tbl_appointment.appntmnt_date', '<', Now())
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tototal_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->whereNull('tbl_client.hei_no')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) >=10)) then `tbl_client`.`id` end)) AS count"))
                ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
                ->where('tbl_appointment.appntmnt_date', '<', Now())
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                //Booked
                $tonine_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                 ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 9)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'Booked')
                ->where('tbl_appointment.appntmnt_date', '>', Now())
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tofourteen_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 10) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 14)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'Booked')
                ->where('tbl_appointment.appntmnt_date', '>', Now())
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tonineteen_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                 ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 15) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 19)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'Booked')
                ->where('tbl_appointment.appntmnt_date', '>', Now())
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $totwentyfour_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                 ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 20) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 24)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'Booked')
                ->where('tbl_appointment.appntmnt_date', '>', Now())
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $totwentynine_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 25) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 29)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'Booked')
                ->where('tbl_appointment.appntmnt_date', '>', Now())
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tothirtyfour_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 30) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 34)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'Booked')
                ->where('tbl_appointment.appntmnt_date', '>', Now())
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tothirtynine_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 35) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 39)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'Booked')
                ->where('tbl_appointment.appntmnt_date', '>', Now())
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tofortyfour_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 40) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 44)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'Booked')
                ->where('tbl_appointment.appntmnt_date', '>', Now())
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tofortynine_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 45) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 49)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'Booked')
                ->where('tbl_appointment.appntmnt_date', '>', Now())
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tofifty_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 50) and ((year(curdate()) - year(`tbl_client`.`dob`)) >= 50)) then `tbl_pmtct`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'Booked')
                ->where('tbl_appointment.appntmnt_date', '>', Now())
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tototal_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->whereNull('tbl_client.hei_no')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) >=10)) then `tbl_client`.`id` end)) AS count"))
                ->where('tbl_appointment.app_status', '=', 'Booked')
                ->where('tbl_appointment.appntmnt_date', '>', Now())
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                // Defaulter

                $tonine_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                 ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 9)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'Defaulted')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tofourteen_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 10) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 14)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'Defaulted')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tonineteen_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                 ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 15) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 19)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'Defaulted')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $totwentyfour_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                 ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 20) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 24)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'Defaulted')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $totwentynine_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 25) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 29)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'Defaulted')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tothirtyfour_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 30) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 34)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'Defaulted')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tothirtynine_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 35) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 39)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'Defaulted')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tofortyfour_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 40) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 44)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'Defaulted')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tofortynine_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 45) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 49)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'Defaulted')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tofifty_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 50) and ((year(curdate()) - year(`tbl_client`.`dob`)) >= 50)) then `tbl_pmtct`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'Defaulted')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tototal_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->whereNull('tbl_client.hei_no')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) >=10)) then `tbl_client`.`id` end)) AS count"))
                ->where('tbl_appointment.app_status', '=', 'Defaulted')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                // Missed
                $tonine_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                 ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 9)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'Missed')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tofourteen_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 10) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 14)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'Missed')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tonineteen_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                 ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 15) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 19)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'Missed')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $totwentyfour_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                 ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 20) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 24)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'Missed')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $totwentynine_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 25) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 29)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'Missed')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tothirtyfour_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 30) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 34)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'Missed')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tothirtynine_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 35) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 39)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'Missed')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tofortyfour_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 40) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 44)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'Missed')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tofortynine_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 45) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 49)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'Missed')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tofifty_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 50) and ((year(curdate()) - year(`tbl_client`.`dob`)) >= 50)) then `tbl_pmtct`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'Missed')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tototal_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->whereNull('tbl_client.hei_no')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) >=10)) then `tbl_client`.`id` end)) AS count"))
                ->where('tbl_appointment.app_status', '=', 'Missed')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                // LTFU
                $tonine_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                 ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 9)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'LTFU')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tofourteen_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 10) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 14)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'LTFU')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tonineteen_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                 ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 15) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 19)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'LTFU')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $totwentyfour_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                 ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 20) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 24)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'LTFU')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $totwentynine_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 25) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 29)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'LTFU')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tothirtyfour_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 30) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 34)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'LTFU')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tothirtynine_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 35) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 39)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'LTFU')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tofortyfour_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 40) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 44)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'LTFU')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tofortynine_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 45) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 49)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'LTFU')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tofifty_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 50) and ((year(curdate()) - year(`tbl_client`.`dob`)) >= 50)) then `tbl_pmtct`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.app_status', '=', 'LTFU')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tototal_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->whereNull('tbl_client.hei_no')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) >=10)) then `tbl_client`.`id` end)) AS count"))
                ->where('tbl_appointment.app_status', '=', 'LTFU')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                // honoured appointments
                $tonine_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                 ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 9)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.appointment_kept', '=', 'Yes')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tofourteen_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 10) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 14)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.appointment_kept', '=', 'Yes')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tonineteen_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                 ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 15) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 19)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.appointment_kept', '=', 'Yes')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $totwentyfour_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                 ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 20) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 24)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.appointment_kept', '=', 'Yes')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $totwentynine_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 25) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 29)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.appointment_kept', '=', 'Yes')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tothirtyfour_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 30) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 34)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.appointment_kept', '=', 'Yes')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tothirtynine_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 35) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 39)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.appointment_kept', '=', 'Yes')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tofortyfour_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 40) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 44)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.appointment_kept', '=', 'Yes')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tofortynine_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 45) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 49)) then `tbl_client`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.appointment_kept', '=', 'Yes')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tofifty_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 50) and ((year(curdate()) - year(`tbl_client`.`dob`)) >= 50)) then `tbl_pmtct`.`id` end)) AS count"))
                ->whereNull('tbl_client.hei_no')
                ->where('tbl_appointment.appointment_kept', '=', 'Yes')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');

                $tototal_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
                ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
                ->whereNull('tbl_client.hei_no')
                ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) >=10)) then `tbl_client`.`id` end)) AS count"))
                ->where('tbl_appointment.appointment_kept', '=', 'Yes')
                ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
                ->where('tbl_client.partner_id', Auth::user()->partner_id)
                ->pluck('count');
            }

            // Administrator

        if (Auth::user()->access_level == 'Admin') {


            $tonine_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 9)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
           // ->where('tbl_appointment.visit_type', '=', 'Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tofourteen_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 10) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 14)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
           // ->where('tbl_appointment.visit_type', '=', 'Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tonineteen_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 15) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 19)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            //->where('tbl_appointment.visit_type', '=', 'Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $totwentyfour_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 20) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 24)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            //->where('tbl_appointment.visit_type', '=', 'Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $totwentynine_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 25) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 29)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
          //  ->where('tbl_appointment.visit_type', '=', 'Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tothirtyfour_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 30) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 34)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
           // ->where('tbl_appointment.visit_type', '=', 'Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tothirtynine_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 35) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 39)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            //->where('tbl_appointment.visit_type', '=', 'Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tofortyfour_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 40) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 44)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
           // ->where('tbl_appointment.visit_type', '=', 'Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tofortynine_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 45) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 49)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
           // ->where('tbl_appointment.visit_type', '=', 'Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tofiftyplus_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 50)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            //->where('tbl_appointment.visit_type', '=', 'Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tototal_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) >=10)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
           // ->where('tbl_appointment.visit_type', '=', 'Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            // Un-Scheduled
            $tonine_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 9)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tofourteen_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 10) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 14)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tonineteen_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 15) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 19)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $totwentyfour_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 20) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 24)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $totwentynine_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 25) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 29)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tothirtyfour_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 30) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 34)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tothirtynine_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 35) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 39)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tofortyfour_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 40) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 44)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tofortynine_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 45) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 49)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tofifty_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 50) and ((year(curdate()) - year(`tbl_client`.`dob`)) >= 50)) then `tbl_pmtct`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tototal_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->whereNull('tbl_client.hei_no')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) >=10)) then `tbl_client`.`id` end)) AS count"))
            ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            //Booked
            $tonine_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 9)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Booked')
            ->where('tbl_appointment.appntmnt_date', '>', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tofourteen_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 10) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 14)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Booked')
            ->where('tbl_appointment.appntmnt_date', '>', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tonineteen_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 15) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 19)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Booked')
            ->where('tbl_appointment.appntmnt_date', '>', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $totwentyfour_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 20) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 24)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Booked')
            ->where('tbl_appointment.appntmnt_date', '>', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $totwentynine_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 25) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 29)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Booked')
            ->where('tbl_appointment.appntmnt_date', '>', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tothirtyfour_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 30) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 34)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Booked')
            ->where('tbl_appointment.appntmnt_date', '>', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tothirtynine_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 35) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 39)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Booked')
            ->where('tbl_appointment.appntmnt_date', '>', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tofortyfour_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 40) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 44)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Booked')
            ->where('tbl_appointment.appntmnt_date', '>', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tofortynine_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 45) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 49)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Booked')
            ->where('tbl_appointment.appntmnt_date', '>', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tofifty_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 50) and ((year(curdate()) - year(`tbl_client`.`dob`)) >= 50)) then `tbl_pmtct`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Booked')
            ->where('tbl_appointment.appntmnt_date', '>', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tototal_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->whereNull('tbl_client.hei_no')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) >=10)) then `tbl_client`.`id` end)) AS count"))
            ->where('tbl_appointment.app_status', '=', 'Booked')
            ->where('tbl_appointment.appntmnt_date', '>', Now())
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            // Defaulter

            $tonine_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 9)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Defaulted')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tofourteen_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 10) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 14)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Defaulted')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tonineteen_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 15) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 19)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Defaulted')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $totwentyfour_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 20) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 24)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Defaulted')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $totwentynine_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 25) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 29)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Defaulted')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tothirtyfour_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 30) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 34)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Defaulted')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tothirtynine_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 35) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 39)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Defaulted')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tofortyfour_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 40) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 44)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Defaulted')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tofortynine_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 45) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 49)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Defaulted')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tofifty_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 50) and ((year(curdate()) - year(`tbl_client`.`dob`)) >= 50)) then `tbl_pmtct`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Defaulted')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tototal_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->whereNull('tbl_client.hei_no')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) >=10)) then `tbl_client`.`id` end)) AS count"))
            ->where('tbl_appointment.app_status', '=', 'Defaulted')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            // Missed
            $tonine_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 9)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Missed')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tofourteen_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 10) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 14)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Missed')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tonineteen_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 15) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 19)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Missed')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $totwentyfour_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 20) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 24)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Missed')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $totwentynine_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 25) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 29)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Missed')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tothirtyfour_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 30) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 34)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Missed')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tothirtynine_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 35) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 39)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Missed')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tofortyfour_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 40) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 44)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Missed')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tofortynine_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 45) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 49)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Missed')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tofifty_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 50) and ((year(curdate()) - year(`tbl_client`.`dob`)) >= 50)) then `tbl_pmtct`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Missed')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tototal_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->whereNull('tbl_client.hei_no')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) >=10)) then `tbl_client`.`id` end)) AS count"))
            ->where('tbl_appointment.app_status', '=', 'Missed')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            // LTFU
            $tonine_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 9)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'LTFU')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tofourteen_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 10) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 14)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'LTFU')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tonineteen_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 15) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 19)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'LTFU')
            ->pluck('count');

            $totwentyfour_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 20) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 24)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'LTFU')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $totwentynine_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 25) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 29)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'LTFU')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tothirtyfour_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 30) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 34)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'LTFU')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tothirtynine_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 35) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 39)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'LTFU')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tofortyfour_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 40) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 44)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'LTFU')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tofortynine_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 45) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 49)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'LTFU')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tofifty_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 50) and ((year(curdate()) - year(`tbl_client`.`dob`)) >= 50)) then `tbl_pmtct`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'LTFU')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tototal_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->whereNull('tbl_client.hei_no')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) >=10)) then `tbl_client`.`id` end)) AS count"))
            ->where('tbl_appointment.app_status', '=', 'LTFU')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            // honoured appointments
            $tonine_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 9)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appointment_kept', '=', 'Yes')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tofourteen_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 10) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 14)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appointment_kept', '=', 'Yes')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tonineteen_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 15) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 19)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appointment_kept', '=', 'Yes')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $totwentyfour_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
             ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 20) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 24)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appointment_kept', '=', 'Yes')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $totwentynine_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 25) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 29)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appointment_kept', '=', 'Yes')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tothirtyfour_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 30) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 34)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appointment_kept', '=', 'Yes')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tothirtynine_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 35) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 39)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appointment_kept', '=', 'Yes')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tofortyfour_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 40) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 44)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appointment_kept', '=', 'Yes')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tofortynine_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 45) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 49)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appointment_kept', '=', 'Yes')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tofifty_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 50) and ((year(curdate()) - year(`tbl_client`.`dob`)) >= 50)) then `tbl_pmtct`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appointment_kept', '=', 'Yes')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');

            $tototal_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->whereNull('tbl_client.hei_no')
            ->select(\DB::raw("count((case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) >=10)) then `tbl_client`.`id` end)) AS count"))
            ->where('tbl_appointment.appointment_kept', '=', 'Yes')
            ->whereDate('tbl_appointment.appntmnt_date', '>=', date($request->from))->whereDate('tbl_appointment.appntmnt_date', '<=', date($request->to))
            ->pluck('count');
        }

        return view('pmtct/pmtct_dashboard', compact('tonine_scheduled', 'tofourteen_scheduled', 'tonineteen_scheduled', 'totwentyfour_scheduled',
    'totwentynine_scheduled', 'tothirtyfour_scheduled', 'tothirtynine_scheduled', 'tofortyfour_scheduled', 'tofortynine_scheduled', 'tofiftyplus_scheduled', 'tototal_scheduled',
    'tonine_unscheduled', 'tofourteen_unscheduled', 'tonineteen_unscheduled', 'totwentyfour_unscheduled', 'totwentynine_unscheduled', 'tothirtyfour_unscheduled', 'tothirtynine_unscheduled',
    'tofortyfour_unscheduled', 'tofortynine_unscheduled', 'tofifty_unscheduled', 'tototal_unscheduled', 'tonine_booked', 'tofourteen_booked', 'tonineteen_booked', 'totwentyfour_booked',
    'totwentynine_booked', 'tothirtyfour_booked', 'tothirtynine_booked', 'tofortyfour_booked', 'tofortynine_booked', 'tofifty_booked', 'tototal_booked',
    'tonine_defaulted', 'tofourteen_defaulted', 'tonineteen_defaulted', 'totwentyfour_defaulted',
    'totwentynine_defaulted', 'tothirtyfour_defaulted', 'tothirtynine_defaulted', 'tofortyfour_defaulted', 'tofortynine_defaulted', 'tofifty_defaulted', 'tototal_defaulted',
    'tonine_missed', 'tofourteen_missed', 'tonineteen_missed', 'totwentyfour_missed',
    'totwentynine_missed', 'tothirtyfour_missed', 'tothirtynine_missed', 'tofortyfour_missed', 'tofortynine_missed', 'tofifty_missed', 'tototal_missed',
    'tonine_ltfu', 'tofourteen_ltfu', 'tonineteen_ltfu', 'totwentyfour_ltfu',
    'totwentynine_ltfu', 'tothirtyfour_ltfu', 'tothirtynine_ltfu', 'tofortyfour_ltfu', 'tofortynine_ltfu', 'tofifty_ltfu', 'tototal_ltfu',
    'tonine_honoured', 'tofourteen_honoured', 'tonineteen_honoured', 'totwentyfour_honoured',
    'totwentynine_honoured', 'tothirtyfour_honoured', 'tothirtynine_honoured', 'tofortyfour_honoured', 'tofortynine_honoured', 'tofifty_honoured', 'tototal_honoured'));
    }

    public function filter_select_pmtct_dashboard(Request $request){
        $data                = [];

        $selected_counties = $request->partners;
        $selected_counties = $request->counties;
        $selected_subcounties = $request->subcounties;
        $selected_facilites = $request->facilities;

            $tonine_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
             ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 9)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appntmnt_date', '<', Now());

            $tofourteen_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
             ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 10) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 14)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appntmnt_date', '<', Now());

            $tonineteen_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
             ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 15) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 19)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appntmnt_date', '<', Now());

            $totwentyfour_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
             ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 20) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 24)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appntmnt_date', '<', Now());

            $totwentynine_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 25) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 29)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appntmnt_date', '<', Now());

            $tothirtyfour_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 30) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 34)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appntmnt_date', '<', Now());

            $tothirtynine_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 35) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 39)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appntmnt_date', '<', Now());

            $tofortyfour_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 40) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 44)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appntmnt_date', '<', Now());

            $tofortynine_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 45) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 49)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appntmnt_date', '<', Now());

            $tofiftyplus_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 50)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appntmnt_date', '<', Now());

            $tototal_scheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) >=10)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appntmnt_date', '<', Now());

            // Un-Scheduled
            $tonine_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
             ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 9)) then `tbl_client`.`id` end)) AS count"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now());

            $tofourteen_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 10) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 14)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now());

            $tonineteen_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 15) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 19)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now());

            $totwentyfour_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 20) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 24)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now());

            $totwentynine_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 25) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 29)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now());

            $tothirtyfour_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 30) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 34)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now());

            $tothirtynine_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 35) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 39)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now());

            $tofortyfour_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 40) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 44)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now());

            $tofortynine_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 45) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 49)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now());

            $tofifty_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 50) and ((year(curdate()) - year(`tbl_client`.`dob`)) >= 50)) then `tbl_pmtct`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now());

            $tototal_unscheduled = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->whereNull('tbl_client.hei_no')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) >=10)) then `tbl_client`.`id` end"))
            ->where('tbl_appointment.visit_type', '=', 'Un-Scheduled')
            ->where('tbl_appointment.appntmnt_date', '<', Now());

            //Booked
            $tonine_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 9)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Booked')
            ->where('tbl_appointment.appntmnt_date', '>', Now());

            $tofourteen_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 10) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 14)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Booked')
            ->where('tbl_appointment.appntmnt_date', '>', Now());

            $tonineteen_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 15) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 19)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Booked')
            ->where('tbl_appointment.appntmnt_date', '>', Now());

            $totwentyfour_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 20) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 24)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Booked')
            ->where('tbl_appointment.appntmnt_date', '>', Now());

            $totwentynine_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 25) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 29)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Booked')
            ->where('tbl_appointment.appntmnt_date', '>', Now());

            $tothirtyfour_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 30) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 34)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Booked')
            ->where('tbl_appointment.appntmnt_date', '>', Now());

            $tothirtynine_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 35) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 39)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Booked')
            ->where('tbl_appointment.appntmnt_date', '>', Now());

            $tofortyfour_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 40) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 44)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Booked')
            ->where('tbl_appointment.appntmnt_date', '>', Now());

            $tofortynine_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 45) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 49)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Booked')
            ->where('tbl_appointment.appntmnt_date', '>', Now());

            $tofifty_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 50) and ((year(curdate()) - year(`tbl_client`.`dob`)) >= 50)) then `tbl_pmtct`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Booked')
            ->where('tbl_appointment.appntmnt_date', '>', Now());

            $tototal_booked = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->whereNull('tbl_client.hei_no')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) >=10)) then `tbl_client`.`id` end"))
            ->where('tbl_appointment.app_status', '=', 'Booked')
            ->where('tbl_appointment.appntmnt_date', '>', Now());

            // Defaulter

            $tonine_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 9)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Defaulted');

            $tofourteen_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 10) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 14)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Defaulted');

            $tonineteen_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 15) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 19)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Defaulted');

            $totwentyfour_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 20) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 24)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Defaulted');

            $totwentynine_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 25) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 29)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Defaulted');

            $tothirtyfour_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 30) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 34)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Defaulted');

            $tothirtynine_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 35) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 39)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Defaulted');

            $tofortyfour_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 40) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 44)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Defaulted');

            $tofortynine_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 45) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 49)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Defaulted');

            $tofifty_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 50) and ((year(curdate()) - year(`tbl_client`.`dob`)) >= 50)) then `tbl_pmtct`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Defaulted');

            $tototal_defaulted = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->whereNull('tbl_client.hei_no')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) >=10)) then `tbl_client`.`id` end"))
            ->where('tbl_appointment.app_status', '=', 'Defaulted');

            // Missed
            $tonine_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
             ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 9)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Missed');

            $tofourteen_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 10) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 14)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Missed');

            $tonineteen_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 15) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 19)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Missed');

            $totwentyfour_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 20) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 24)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Missed');

            $totwentynine_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 25) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 29)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Missed');

            $tothirtyfour_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 30) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 34)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Missed');

            $tothirtynine_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 35) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 39)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Missed');

            $tofortyfour_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 40) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 44)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Missed');

            $tofortynine_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 45) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 49)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Missed');

            $tofifty_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 50) and ((year(curdate()) - year(`tbl_client`.`dob`)) >= 50)) then `tbl_pmtct`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'Missed');

            $tototal_missed = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->whereNull('tbl_client.hei_no')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) >=10)) then `tbl_client`.`id` end"))
            ->where('tbl_appointment.app_status', '=', 'Missed');

            // LTFU
            $tonine_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 9)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'LTFU');

            $tofourteen_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 10) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 14)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'LTFU');

            $tonineteen_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 15) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 19)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no');

            $totwentyfour_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 20) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 24)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'LTFU');

            $totwentynine_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 25) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 29)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'LTFU');

            $tothirtyfour_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 30) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 34)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'LTFU');

            $tothirtynine_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 35) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 39)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'LTFU');

            $tofortyfour_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 40) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 44)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'LTFU');

            $tofortynine_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 45) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 49)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'LTFU');

            $tofifty_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 50) and ((year(curdate()) - year(`tbl_client`.`dob`)) >= 50)) then `tbl_pmtct`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.app_status', '=', 'LTFU');

            $tototal_ltfu = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->whereNull('tbl_client.hei_no')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) >=10)) then `tbl_client`.`id` end"))
            ->where('tbl_appointment.app_status', '=', 'LTFU');

            // honoured appointments
            $tonine_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 9)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appointment_kept', '=', 'Yes');

            $tofourteen_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 10) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 14)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appointment_kept', '=', 'Yes');

            $tonineteen_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 15) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 19)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appointment_kept', '=', 'Yes');

            $totwentyfour_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 20) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 24)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appointment_kept', '=', 'Yes');

            $totwentynine_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 25) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 29)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appointment_kept', '=', 'Yes');

            $tothirtyfour_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 30) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 34)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appointment_kept', '=', 'Yes');

            $tothirtynine_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 35) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 39)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appointment_kept', '=', 'Yes');

            $tofortyfour_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 40) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 44)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appointment_kept', '=', 'Yes');

            $tofortynine_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 45) and ((year(curdate()) - year(`tbl_client`.`dob`)) <= 49)) then `tbl_client`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appointment_kept', '=', 'Yes');

            $tofifty_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) >= 50) and ((year(curdate()) - year(`tbl_client`.`dob`)) >= 50)) then `tbl_pmtct`.`id` end"))
            ->whereNull('tbl_client.hei_no')
            ->where('tbl_appointment.appointment_kept', '=', 'Yes');

            $tototal_honoured = Pmtct::join('tbl_client', 'tbl_client.id', '=', 'tbl_pmtct.client_id')
            ->join('tbl_appointment', 'tbl_client.id', '=', 'tbl_appointment.client_id')
            ->join('tbl_partner_facility', 'tbl_client.mfl_code', '=', 'tbl_partner_facility.mfl_code')
            ->whereNull('tbl_client.hei_no')
            ->select(\DB::raw("case when (((year(curdate()) - year(`tbl_client`.`dob`)) > 0) and ((year(curdate()) - year(`tbl_client`.`dob`)) >=10)) then `tbl_client`.`id` end"))
            ->where('tbl_appointment.appointment_kept', '=', 'Yes');

            if (!empty($selected_partners)) {
                $tonine_scheduled = $tonine_scheduled->where('tbl_partner_facility.partner_id', $selected_partners);
                $tofourteen_scheduled = $tofourteen_scheduled->where('tbl_partner_facility.partner_id', $selected_partners);
                $tonineteen_scheduled = $tonineteen_scheduled->where('tbl_partner_facility.partner_id', $selected_partners);
                $totwentyfour_scheduled = $totwentyfour_scheduled->where('tbl_partner_facility.partner_id', $selected_partners);
                $totwentynine_scheduled = $totwentynine_scheduled->where('tbl_partner_facility.partner_id', $selected_partners);
                $tothirtyfour_scheduled = $tothirtyfour_scheduled->where('tbl_partner_facility.partner_id', $selected_partners);
                $tothirtynine_scheduled = $tothirtynine_scheduled->where('tbl_partner_facility.partner_id', $selected_partners);
                $tothirtynine_scheduled = $tothirtynine_scheduled->where('tbl_partner_facility.partner_id', $selected_partners);
                $tofortyfour_scheduled = $tofortyfour_scheduled->where('tbl_partner_facility.partner_id', $selected_partners);
                $tofortynine_scheduled = $tofortynine_scheduled->where('tbl_partner_facility.partner_id', $selected_partners);
                $tofiftyplus_scheduled = $tofiftyplus_scheduled->where('tbl_partner_facility.partner_id', $selected_partners);
                $tototal_scheduled = $tototal_scheduled->where('tbl_partner_facility.partner_id', $selected_partners);
                $tonine_unscheduled = $tonine_unscheduled->where('tbl_partner_facility.partner_id', $selected_partners);
                $tofourteen_unscheduled = $tofourteen_unscheduled->where('tbl_partner_facility.partner_id', $selected_partners);
                $tonineteen_unscheduled = $tonineteen_unscheduled->where('tbl_partner_facility.partner_id', $selected_partners);
                $totwentyfour_unscheduled = $totwentyfour_unscheduled->where('tbl_partner_facility.partner_id', $selected_partners);
                $totwentynine_unscheduled = $totwentynine_unscheduled->where('tbl_partner_facility.partner_id', $selected_partners);
                $tothirtyfour_unscheduled = $tothirtyfour_unscheduled->where('tbl_partner_facility.partner_id', $selected_partners);
                $tothirtynine_unscheduled = $tothirtynine_unscheduled->where('tbl_partner_facility.partner_id', $selected_partners);
                $tofortyfour_unscheduled = $tofortyfour_unscheduled->where('tbl_partner_facility.partner_id', $selected_partners);
                $tofortynine_unscheduled = $tofortynine_unscheduled->where('tbl_partner_facility.partner_id', $selected_partners);
                $tofifty_unscheduled = $tofifty_unscheduled->where('tbl_partner_facility.partner_id', $selected_partners);
                $tototal_unscheduled = $tototal_unscheduled->where('tbl_partner_facility.partner_id', $selected_partners);
                $tonine_booked = $tonine_booked->where('tbl_partner_facility.partner_id', $selected_partners);
                $tofourteen_booked = $tofourteen_booked->where('tbl_partner_facility.partner_id', $selected_partners);
                $tonineteen_booked = $tonineteen_booked->where('tbl_partner_facility.partner_id', $selected_partners);
                $totwentyfour_booked = $totwentyfour_booked->where('tbl_partner_facility.partner_id', $selected_partners);
                $totwentynine_booked = $totwentynine_booked->where('tbl_partner_facility.partner_id', $selected_partners);
                $tothirtyfour_booked = $tothirtyfour_booked->where('tbl_partner_facility.partner_id', $selected_partners);
                $tothirtynine_booked = $tothirtynine_booked->where('tbl_partner_facility.partner_id', $selected_partners);
                $tofortyfour_booked = $tofortyfour_booked->where('tbl_partner_facility.partner_id', $selected_partners);
                $tofortynine_booked = $tofortynine_booked->where('tbl_partner_facility.partner_id', $selected_partners);
                $tofifty_booked = $tofifty_booked->where('tbl_partner_facility.partner_id', $selected_partners);
                $tototal_booked = $tototal_booked->where('tbl_partner_facility.partner_id', $selected_partners);
                $tonine_defaulted = $tonine_defaulted->where('tbl_partner_facility.partner_id', $selected_partners);
                $tofourteen_defaulted = $tofourteen_defaulted->where('tbl_partner_facility.partner_id', $selected_partners);
                $tonineteen_defaulted = $tonineteen_defaulted->where('tbl_partner_facility.partner_id', $selected_partners);
                $totwentyfour_defaulted = $totwentyfour_defaulted->where('tbl_partner_facility.partner_id', $selected_partners);
                $totwentynine_defaulted = $totwentynine_defaulted->where('tbl_partner_facility.partner_id', $selected_partners);
                $tothirtyfour_defaulted = $tothirtyfour_defaulted->where('tbl_partner_facility.partner_id', $selected_partners);
                $tothirtynine_defaulted = $tothirtynine_defaulted->where('tbl_partner_facility.partner_id', $selected_partners);
                $tofortynine_defaulted = $tofortynine_defaulted->where('tbl_partner_facility.partner_id', $selected_partners);
                $tofifty_defaulted = $tofifty_defaulted->where('tbl_partner_facility.partner_id', $selected_partners);
                $tototal_defaulted = $tototal_defaulted->where('tbl_partner_facility.partner_id', $selected_partners);
                $tonine_missed = $tonine_missed->where('tbl_partner_facility.partner_id', $selected_partners);
                $tofourteen_missed = $tofourteen_missed->where('tbl_partner_facility.partner_id', $selected_partners);
                $tonineteen_missed = $tonineteen_missed->where('tbl_partner_facility.partner_id', $selected_partners);
                $totwentyfour_missed = $totwentyfour_missed->where('tbl_partner_facility.partner_id', $selected_partners);
                $totwentynine_missed = $totwentynine_missed->where('tbl_partner_facility.partner_id', $selected_partners);
                $tothirtyfour_missed = $tothirtyfour_missed->where('tbl_partner_facility.partner_id', $selected_partners);
                $tothirtynine_missed = $tothirtynine_missed->where('tbl_partner_facility.partner_id', $selected_partners);
                $tofortyfour_missed = $tofortyfour_missed->where('tbl_partner_facility.partner_id', $selected_partners);
                $tofortynine_missed = $tofortynine_missed->where('tbl_partner_facility.partner_id', $selected_partners);
                $tofifty_missed = $tofifty_missed->where('tbl_partner_facility.partner_id', $selected_partners);
                $tototal_missed = $tototal_missed->where('tbl_partner_facility.partner_id', $selected_partners);
                $tonine_ltfu = $tonine_ltfu->where('tbl_partner_facility.partner_id', $selected_partners);
                $tofourteen_ltfu = $tofourteen_ltfu->where('tbl_partner_facility.partner_id', $selected_partners);
                $tonineteen_ltfu = $tonineteen_ltfu->where('tbl_partner_facility.partner_id', $selected_partners);
                $totwentyfour_ltfu = $totwentyfour_ltfu->where('tbl_partner_facility.partner_id', $selected_partners);
                $totwentynine_ltfu = $totwentynine_ltfu->where('tbl_partner_facility.partner_id', $selected_partners);
                $tothirtyfour_ltfu = $tothirtyfour_ltfu->where('tbl_partner_facility.partner_id', $selected_partners);
                $tothirtynine_ltfu = $tothirtynine_ltfu->where('tbl_partner_facility.partner_id', $selected_partners);
                $tofortyfour_ltfu = $tofortyfour_ltfu->where('tbl_partner_facility.partner_id', $selected_partners);
                $tofortynine_ltfu = $tofortynine_ltfu->where('tbl_partner_facility.partner_id', $selected_partners);
                $tofifty_ltfu = $tofifty_ltfu->where('tbl_partner_facility.partner_id', $selected_partners);
                $tototal_ltfu = $tototal_ltfu->where('tbl_partner_facility.partner_id', $selected_partners);
                $tonine_honoured = $tonine_honoured->where('tbl_partner_facility.partner_id', $selected_partners);
                $tofourteen_honoured = $tofourteen_honoured->where('tbl_partner_facility.partner_id', $selected_partners);
                $tonineteen_honoured = $tonineteen_honoured->where('tbl_partner_facility.partner_id', $selected_partners);
                $totwentyfour_honoured = $totwentyfour_honoured->where('tbl_partner_facility.partner_id', $selected_partners);
                $totwentynine_honoured = $totwentynine_honoured->where('tbl_partner_facility.partner_id', $selected_partners);
                $tothirtyfour_honoured = $tothirtyfour_honoured->where('tbl_partner_facility.partner_id', $selected_partners);
                $tothirtynine_honoured = $tothirtynine_honoured->where('tbl_partner_facility.partner_id', $selected_partners);
                $tofortyfour_honoured = $tofortyfour_honoured->where('tbl_partner_facility.partner_id', $selected_partners);
                $tofortynine_honoured = $tofortynine_honoured->where('tbl_partner_facility.partner_id', $selected_partners);
                $tofifty_honoured = $tofifty_honoured->where('tbl_partner_facility.partner_id', $selected_partners);
                $tototal_honoured = $tototal_honoured->where('tbl_partner_facility.partner_id', $selected_partners);
            }

            if (!empty($selected_counties)) {
                $tonine_scheduled = $tonine_scheduled->where('tbl_partner_facility.county_id', $selected_counties);
                $tofourteen_scheduled = $tofourteen_scheduled->where('tbl_partner_facility.county_id', $selected_counties);
                $tonineteen_scheduled = $tonineteen_scheduled->where('tbl_partner_facility.county_id', $selected_counties);
                $totwentyfour_scheduled = $totwentyfour_scheduled->where('tbl_partner_facility.county_id', $selected_counties);
                $totwentynine_scheduled = $totwentynine_scheduled->where('tbl_partner_facility.county_id', $selected_counties);
                $tothirtyfour_scheduled = $tothirtyfour_scheduled->where('tbl_partner_facility.county_id', $selected_counties);
                $tothirtynine_scheduled = $tothirtynine_scheduled->where('tbl_partner_facility.county_id', $selected_counties);
                $tothirtynine_scheduled = $tothirtynine_scheduled->where('tbl_partner_facility.county_id', $selected_counties);
                $tofortyfour_scheduled = $tofortyfour_scheduled->where('tbl_partner_facility.county_id', $selected_counties);
                $tofortynine_scheduled = $tofortynine_scheduled->where('tbl_partner_facility.county_id', $selected_counties);
                $tofiftyplus_scheduled = $tofiftyplus_scheduled->where('tbl_partner_facility.county_id', $selected_counties);
                $tototal_scheduled = $tototal_scheduled->where('tbl_partner_facility.county_id', $selected_counties);
                $tonine_unscheduled = $tonine_unscheduled->where('tbl_partner_facility.county_id', $selected_counties);
                $tofourteen_unscheduled = $tofourteen_unscheduled->where('tbl_partner_facility.county_id', $selected_counties);
                $tonineteen_unscheduled = $tonineteen_unscheduled->where('tbl_partner_facility.county_id', $selected_counties);
                $totwentyfour_unscheduled = $totwentyfour_unscheduled->where('tbl_partner_facility.county_id', $selected_counties);
                $totwentynine_unscheduled = $totwentynine_unscheduled->where('tbl_partner_facility.county_id', $selected_counties);
                $tothirtyfour_unscheduled = $tothirtyfour_unscheduled->where('tbl_partner_facility.county_id', $selected_counties);
                $tothirtynine_unscheduled = $tothirtynine_unscheduled->where('tbl_partner_facility.county_id', $selected_counties);
                $tofortyfour_unscheduled = $tofortyfour_unscheduled->where('tbl_partner_facility.county_id', $selected_counties);
                $tofortynine_unscheduled = $tofortynine_unscheduled->where('tbl_partner_facility.county_id', $selected_counties);
                $tofifty_unscheduled = $tofifty_unscheduled->where('tbl_partner_facility.county_id', $selected_counties);
                $tototal_unscheduled = $tototal_unscheduled->where('tbl_partner_facility.county_id', $selected_counties);
                $tonine_booked = $tonine_booked->where('tbl_partner_facility.county_id', $selected_counties);
                $tofourteen_booked = $tofourteen_booked->where('tbl_partner_facility.county_id', $selected_counties);
                $tonineteen_booked = $tonineteen_booked->where('tbl_partner_facility.county_id', $selected_counties);
                $totwentyfour_booked = $totwentyfour_booked->where('tbl_partner_facility.county_id', $selected_counties);
                $totwentynine_booked = $totwentynine_booked->where('tbl_partner_facility.county_id', $selected_counties);
                $tothirtyfour_booked = $tothirtyfour_booked->where('tbl_partner_facility.county_id', $selected_counties);
                $tothirtynine_booked = $tothirtynine_booked->where('tbl_partner_facility.county_id', $selected_counties);
                $tofortyfour_booked = $tofortyfour_booked->where('tbl_partner_facility.county_id', $selected_counties);
                $tofortynine_booked = $tofortynine_booked->where('tbl_partner_facility.county_id', $selected_counties);
                $tofifty_booked = $tofifty_booked->where('tbl_partner_facility.county_id', $selected_counties);
                $tototal_booked = $tototal_booked->where('tbl_partner_facility.county_id', $selected_counties);
                $tonine_defaulted = $tonine_defaulted->where('tbl_partner_facility.county_id', $selected_counties);
                $tofourteen_defaulted = $tofourteen_defaulted->where('tbl_partner_facility.county_id', $selected_counties);
                $tonineteen_defaulted = $tonineteen_defaulted->where('tbl_partner_facility.county_id', $selected_counties);
                $totwentyfour_defaulted = $totwentyfour_defaulted->where('tbl_partner_facility.county_id', $selected_counties);
                $totwentynine_defaulted = $totwentynine_defaulted->where('tbl_partner_facility.county_id', $selected_counties);
                $tothirtyfour_defaulted = $tothirtyfour_defaulted->where('tbl_partner_facility.county_id', $selected_counties);
                $tothirtynine_defaulted = $tothirtynine_defaulted->where('tbl_partner_facility.county_id', $selected_counties);
                $tofortynine_defaulted = $tofortynine_defaulted->where('tbl_partner_facility.county_id', $selected_counties);
                $tofifty_defaulted = $tofifty_defaulted->where('tbl_partner_facility.county_id', $selected_counties);
                $tototal_defaulted = $tototal_defaulted->where('tbl_partner_facility.county_id', $selected_counties);
                $tonine_missed = $tonine_missed->where('tbl_partner_facility.county_id', $selected_counties);
                $tofourteen_missed = $tofourteen_missed->where('tbl_partner_facility.county_id', $selected_counties);
                $tonineteen_missed = $tonineteen_missed->where('tbl_partner_facility.county_id', $selected_counties);
                $totwentyfour_missed = $totwentyfour_missed->where('tbl_partner_facility.county_id', $selected_counties);
                $totwentynine_missed = $totwentynine_missed->where('tbl_partner_facility.county_id', $selected_counties);
                $tothirtyfour_missed = $tothirtyfour_missed->where('tbl_partner_facility.county_id', $selected_counties);
                $tothirtynine_missed = $tothirtynine_missed->where('tbl_partner_facility.county_id', $selected_counties);
                $tofortyfour_missed = $tofortyfour_missed->where('tbl_partner_facility.county_id', $selected_counties);
                $tofortynine_missed = $tofortynine_missed->where('tbl_partner_facility.county_id', $selected_counties);
                $tofifty_missed = $tofifty_missed->where('tbl_partner_facility.county_id', $selected_counties);
                $tototal_missed = $tototal_missed->where('tbl_partner_facility.county_id', $selected_counties);
                $tonine_ltfu = $tonine_ltfu->where('tbl_partner_facility.county_id', $selected_counties);
                $tofourteen_ltfu = $tofourteen_ltfu->where('tbl_partner_facility.county_id', $selected_counties);
                $tonineteen_ltfu = $tonineteen_ltfu->where('tbl_partner_facility.county_id', $selected_counties);
                $totwentyfour_ltfu = $totwentyfour_ltfu->where('tbl_partner_facility.county_id', $selected_counties);
                $totwentynine_ltfu = $totwentynine_ltfu->where('tbl_partner_facility.county_id', $selected_counties);
                $tothirtyfour_ltfu = $tothirtyfour_ltfu->where('tbl_partner_facility.county_id', $selected_counties);
                $tothirtynine_ltfu = $tothirtynine_ltfu->where('tbl_partner_facility.county_id', $selected_counties);
                $tofortyfour_ltfu = $tofortyfour_ltfu->where('tbl_partner_facility.county_id', $selected_counties);
                $tofortynine_ltfu = $tofortynine_ltfu->where('tbl_partner_facility.county_id', $selected_counties);
                $tofifty_ltfu = $tofifty_ltfu->where('tbl_partner_facility.county_id', $selected_counties);
                $tototal_ltfu = $tototal_ltfu->where('tbl_partner_facility.county_id', $selected_counties);
                $tonine_honoured = $tonine_honoured->where('tbl_partner_facility.county_id', $selected_counties);
                $tofourteen_honoured = $tofourteen_honoured->where('tbl_partner_facility.county_id', $selected_counties);
                $tonineteen_honoured = $tonineteen_honoured->where('tbl_partner_facility.county_id', $selected_counties);
                $totwentyfour_honoured = $totwentyfour_honoured->where('tbl_partner_facility.county_id', $selected_counties);
                $totwentynine_honoured = $totwentynine_honoured->where('tbl_partner_facility.county_id', $selected_counties);
                $tothirtyfour_honoured = $tothirtyfour_honoured->where('tbl_partner_facility.county_id', $selected_counties);
                $tothirtynine_honoured = $tothirtynine_honoured->where('tbl_partner_facility.county_id', $selected_counties);
                $tofortyfour_honoured = $tofortyfour_honoured->where('tbl_partner_facility.county_id', $selected_counties);
                $tofortynine_honoured = $tofortynine_honoured->where('tbl_partner_facility.county_id', $selected_counties);
                $tofifty_honoured = $tofifty_honoured->where('tbl_partner_facility.county_id', $selected_counties);
                $tototal_honoured = $tototal_honoured->where('tbl_partner_facility.county_id', $selected_counties);
            }

            if (!empty($selected_subcounties)) {
                $tonine_scheduled = $tonine_scheduled->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tofourteen_scheduled = $tofourteen_scheduled->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tonineteen_scheduled = $tonineteen_scheduled->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $totwentyfour_scheduled = $totwentyfour_scheduled->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $totwentynine_scheduled = $totwentynine_scheduled->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tothirtyfour_scheduled = $tothirtyfour_scheduled->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tothirtynine_scheduled = $tothirtynine_scheduled->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tothirtynine_scheduled = $tothirtynine_scheduled->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tofortyfour_scheduled = $tofortyfour_scheduled->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tofortynine_scheduled = $tofortynine_scheduled->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tofiftyplus_scheduled = $tofiftyplus_scheduled->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tototal_scheduled = $tototal_scheduled->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tonine_unscheduled = $tonine_unscheduled->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tofourteen_unscheduled = $tofourteen_unscheduled->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tonineteen_unscheduled = $tonineteen_unscheduled->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $totwentyfour_unscheduled = $totwentyfour_unscheduled->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $totwentynine_unscheduled = $totwentynine_unscheduled->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tothirtyfour_unscheduled = $tothirtyfour_unscheduled->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tothirtynine_unscheduled = $tothirtynine_unscheduled->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tofortyfour_unscheduled = $tofortyfour_unscheduled->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tofortynine_unscheduled = $tofortynine_unscheduled->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tofifty_unscheduled = $tofifty_unscheduled->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tototal_unscheduled = $tototal_unscheduled->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tonine_booked = $tonine_booked->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tofourteen_booked = $tofourteen_booked->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tonineteen_booked = $tonineteen_booked->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $totwentyfour_booked = $totwentyfour_booked->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $totwentynine_booked = $totwentynine_booked->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tothirtyfour_booked = $tothirtyfour_booked->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tothirtynine_booked = $tothirtynine_booked->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tofortyfour_booked = $tofortyfour_booked->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tofortynine_booked = $tofortynine_booked->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tofifty_booked = $tofifty_booked->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tototal_booked = $tototal_booked->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tonine_defaulted = $tonine_defaulted->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tofourteen_defaulted = $tofourteen_defaulted->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tonineteen_defaulted = $tonineteen_defaulted->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $totwentyfour_defaulted = $totwentyfour_defaulted->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $totwentynine_defaulted = $totwentynine_defaulted->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tothirtyfour_defaulted = $tothirtyfour_defaulted->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tothirtynine_defaulted = $tothirtynine_defaulted->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tofortynine_defaulted = $tofortynine_defaulted->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tofifty_defaulted = $tofifty_defaulted->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tototal_defaulted = $tototal_defaulted->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tonine_missed = $tonine_missed->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tofourteen_missed = $tofourteen_missed->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tonineteen_missed = $tonineteen_missed->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $totwentyfour_missed = $totwentyfour_missed->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $totwentynine_missed = $totwentynine_missed->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tothirtyfour_missed = $tothirtyfour_missed->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tothirtynine_missed = $tothirtynine_missed->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tofortyfour_missed = $tofortyfour_missed->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tofortynine_missed = $tofortynine_missed->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tofifty_missed = $tofifty_missed->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tototal_missed = $tototal_missed->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tonine_ltfu = $tonine_ltfu->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tofourteen_ltfu = $tofourteen_ltfu->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tonineteen_ltfu = $tonineteen_ltfu->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $totwentyfour_ltfu = $totwentyfour_ltfu->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $totwentynine_ltfu = $totwentynine_ltfu->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tothirtyfour_ltfu = $tothirtyfour_ltfu->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tothirtynine_ltfu = $tothirtynine_ltfu->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tofortyfour_ltfu = $tofortyfour_ltfu->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tofortynine_ltfu = $tofortynine_ltfu->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tofifty_ltfu = $tofifty_ltfu->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tototal_ltfu = $tototal_ltfu->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tonine_honoured = $tonine_honoured->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tofourteen_honoured = $tofourteen_honoured->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tonineteen_honoured = $tonineteen_honoured->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $totwentyfour_honoured = $totwentyfour_honoured->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $totwentynine_honoured = $totwentynine_honoured->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tothirtyfour_honoured = $tothirtyfour_honoured->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tothirtynine_honoured = $tothirtynine_honoured->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tofortyfour_honoured = $tofortyfour_honoured->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tofortynine_honoured = $tofortynine_honoured->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tofifty_honoured = $tofifty_honoured->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
                $tototal_honoured = $tototal_honoured->where('tbl_partner_facility.sub_county_id', $selected_subcounties);
            }

            if (!empty($selected_facilites)) {
                $tonine_scheduled = $tonine_scheduled->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tofourteen_scheduled = $tofourteen_scheduled->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tonineteen_scheduled = $tonineteen_scheduled->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $totwentyfour_scheduled = $totwentyfour_scheduled->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $totwentynine_scheduled = $totwentynine_scheduled->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tothirtyfour_scheduled = $tothirtyfour_scheduled->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tothirtynine_scheduled = $tothirtynine_scheduled->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tothirtynine_scheduled = $tothirtynine_scheduled->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tofortyfour_scheduled = $tofortyfour_scheduled->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tofortynine_scheduled = $tofortynine_scheduled->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tofiftyplus_scheduled = $tofiftyplus_scheduled->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tototal_scheduled = $tototal_scheduled->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tonine_unscheduled = $tonine_unscheduled->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tofourteen_unscheduled = $tofourteen_unscheduled->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tonineteen_unscheduled = $tonineteen_unscheduled->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $totwentyfour_unscheduled = $totwentyfour_unscheduled->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $totwentynine_unscheduled = $totwentynine_unscheduled->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tothirtyfour_unscheduled = $tothirtyfour_unscheduled->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tothirtynine_unscheduled = $tothirtynine_unscheduled->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tofortyfour_unscheduled = $tofortyfour_unscheduled->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tofortynine_unscheduled = $tofortynine_unscheduled->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tofifty_unscheduled = $tofifty_unscheduled->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tototal_unscheduled = $tototal_unscheduled->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tonine_booked = $tonine_booked->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tofourteen_booked = $tofourteen_booked->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tonineteen_booked = $tonineteen_booked->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $totwentyfour_booked = $totwentyfour_booked->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $totwentynine_booked = $totwentynine_booked->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tothirtyfour_booked = $tothirtyfour_booked->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tothirtynine_booked = $tothirtynine_booked->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tofortyfour_booked = $tofortyfour_booked->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tofortynine_booked = $tofortynine_booked->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tofifty_booked = $tofifty_booked->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tototal_booked = $tototal_booked->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tonine_defaulted = $tonine_defaulted->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tofourteen_defaulted = $tofourteen_defaulted->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tonineteen_defaulted = $tonineteen_defaulted->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $totwentyfour_defaulted = $totwentyfour_defaulted->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $totwentynine_defaulted = $totwentynine_defaulted->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tothirtyfour_defaulted = $tothirtyfour_defaulted->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tothirtynine_defaulted = $tothirtynine_defaulted->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tofortynine_defaulted = $tofortynine_defaulted->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tofifty_defaulted = $tofifty_defaulted->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tototal_defaulted = $tototal_defaulted->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tonine_missed = $tonine_missed->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tofourteen_missed = $tofourteen_missed->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tonineteen_missed = $tonineteen_missed->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $totwentyfour_missed = $totwentyfour_missed->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $totwentynine_missed = $totwentynine_missed->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tothirtyfour_missed = $tothirtyfour_missed->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tothirtynine_missed = $tothirtynine_missed->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tofortyfour_missed = $tofortyfour_missed->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tofortynine_missed = $tofortynine_missed->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tofifty_missed = $tofifty_missed->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tototal_missed = $tototal_missed->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tonine_ltfu = $tonine_ltfu->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tofourteen_ltfu = $tofourteen_ltfu->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tonineteen_ltfu = $tonineteen_ltfu->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $totwentyfour_ltfu = $totwentyfour_ltfu->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $totwentynine_ltfu = $totwentynine_ltfu->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tothirtyfour_ltfu = $tothirtyfour_ltfu->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tothirtynine_ltfu = $tothirtynine_ltfu->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tofortyfour_ltfu = $tofortyfour_ltfu->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tofortynine_ltfu = $tofortynine_ltfu->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tofifty_ltfu = $tofifty_ltfu->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tototal_ltfu = $tototal_ltfu->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tonine_honoured = $tonine_honoured->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tofourteen_honoured = $tofourteen_honoured->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tonineteen_honoured = $tonineteen_honoured->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $totwentyfour_honoured = $totwentyfour_honoured->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $totwentynine_honoured = $totwentynine_honoured->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tothirtyfour_honoured = $tothirtyfour_honoured->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tothirtynine_honoured = $tothirtynine_honoured->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tofortyfour_honoured = $tofortyfour_honoured->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tofortynine_honoured = $tofortynine_honoured->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tofifty_honoured = $tofifty_honoured->where('tbl_partner_facility.mfl_code', $selected_facilites);
                $tototal_honoured = $tototal_honoured->where('tbl_partner_facility.mfl_code', $selected_facilites);
            }

            return $data;

    }
}
