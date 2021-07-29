<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facility;
use App\Models\County;
use App\Models\Partner;
use App\Models\SubCounty;
use App\Models\PartnerFacility;
use Session;
use Auth;

class FacilityController extends Controller
{
    public function admin_facilities()
    {
        $admin_facilities = Facility::join('tbl_unit', 'tbl_master_facility.unit_id', '=', 'tbl_unit.id')
            ->join('tbl_consituency', 'tbl_master_facility.consituency_id', '=', 'tbl_consituency.id')
            ->select(
                'tbl_master_facility.name as facility_name',
                'tbl_master_facility.code',
                'tbl_master_facility.owner',
                'tbl_unit.unit_name as unit_name',
                'tbl_master_facility.facility_type',
                'tbl_master_facility.keph_level as level',
                'tbl_master_facility.unit_id'
            )
            ->where('tbl_master_facility.assigned', '=', '0')
            ->get();

        $all_partners = Partner::all()->where('status', '=', 'Active');

        return view('facilities.admin_facilities', compact('admin_facilities', 'all_partners'));
    }
    public function add_facility(Request $request)
    {
        try {
            $facility = new PartnerFacility;

            $facility->mfl_code = $request->mfl_code;
            $facility->status = 'Active';
            $facility->partner_id = $request->partner;
            $facility->_id = $request->county;
            $facility->sub_county_id = $request->sub_county;
            $facility->is_approved = 'No';
            $facility->avg_clients = $request->average_clients;

            $master_update = Facility::where('code', $request->mfl_code)
                ->update([
                    'assigned' => "1",
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

            if ($facility->save() && $master_update) {
                Session::flash('statuscode', 'success');

                return redirect('admin/facilities')->with('status', 'CCC Clinic added successfully!');
            } else {

                Session::flash('statuscode', 'error');
                return back()->with('error', 'An error has occurred please try again later.');
            }
        } catch (Exception $e) {
            return back();
        }
    }
    public function my_facility()
    {
        if (Auth::user()->access_level == 'Admin') {
            $facilities = Facility::join('tbl_county', 'tbl_master_facility.unit_id', '=', 'tbl_unit.id')
                // ->join('tbl_partner', 'tbl_partner_facility.partner_id', '=', 'tbl_partner.id')
                ->join('tbl_partner_facility', 'tbl_master_facility.code', '=', 'tbl_partner_facility.mfl_code')
                ->select(
                    'tbl_master_facility.name as facility_name',
                    'tbl_partner_facility.avg_clients as average_clients',
                    'tbl_master_facility.code',
                    'tbl_master_facility.owner',
                    'tbl_unit.unit_name as unit_name',
                    'tbl_master_facility.facility_type',
                    'tbl_master_facility.keph_level as level',
                    'tbl_partner_facility.is_approved',
                    'tbl_partner_facility.id'
                    //'tbl_partner.name as partner_name'
                )
                ->get();
        }
        if (Auth::user()->access_level == 'Donor') {
            $facilities = Facility::join('tbl_county', 'tbl_master_facility.unit_id', '=', 'tbl_unit.id')
                // ->join('tbl_partner', 'tbl_partner_facility.partner_id', '=', 'tbl_partner.id')
                ->join('tbl_partner_facility', 'tbl_master_facility.code', '=', 'tbl_partner_facility.mfl_code')
                ->select(
                    'tbl_master_facility.name as facility_name',
                    'tbl_partner_facility.avg_clients as average_clients',
                    'tbl_master_facility.code',
                    'tbl_master_facility.owner',
                    'tbl_unit.unit_name as unit_name',
                    'tbl_master_facility.facility_type',
                    'tbl_master_facility.keph_level as level',
                    'tbl_partner_facility.is_approved',
                    'tbl_partner_facility.id'
                    //'tbl_partner.name as partner_name'
                )
                ->get();
        }
        if (Auth::user()->access_level == 'Facility') {
            $facilities = Facility::join('tbl_county', 'tbl_master_facility.unit_id', '=', 'tbl_unit.id')
                // ->join('tbl_partner', 'tbl_partner_facility.partner_id', '=', 'tbl_partner.id')
                ->join('tbl_partner_facility', 'tbl_master_facility.code', '=', 'tbl_partner_facility.mfl_code')
                ->select(
                    'tbl_master_facility.name as facility_name',
                    'tbl_partner_facility.avg_clients as average_clients',
                    'tbl_master_facility.code',
                    'tbl_master_facility.owner',
                    'tbl_unit.unit_name as unit_name',
                    'tbl_master_facility.facility_type',
                    'tbl_master_facility.keph_level as level',
                    'tbl_partner_facility.is_approved',
                    'tbl_partner_facility.id'
                    //'tbl_partner.name as partner_name'
                )
                ->where('tbl_partner_facility.mfl_code', Auth::user()->facility_id)
                ->get();
        }
        if (Auth::user()->access_level == 'Partner') {
            $facilities = Facility::join('tbl_county', 'tbl_master_facility.unit_id', '=', 'tbl_unit.id')
                // ->join('tbl_partner', 'tbl_partner_facility.partner_id', '=', 'tbl_partner.id')
                ->join('tbl_partner_facility', 'tbl_master_facility.code', '=', 'tbl_partner_facility.mfl_code')
                ->select(
                    'tbl_master_facility.name as facility_name',
                    'tbl_partner_facility.avg_clients as average_clients',
                    'tbl_master_facility.code',
                    'tbl_master_facility.owner',
                    'tbl_unit.unit_name as unit_name',
                    'tbl_master_facility.facility_type',
                    'tbl_master_facility.keph_level as level',
                    'tbl_partner_facility.is_approved',
                    'tbl_partner_facility.id'
                    //'tbl_partner.name as partner_name'
                )
                ->where('tbl_partner_facility.partner_id', Auth::user()->partner_id)
                ->get();
        }
        $all_partners = Partner::all()->where('status', '=', 'Active');
        return view('facilities.my_facilities', compact('facilities', 'all_partners'));
    }
    public function approve_facility(Request $request)
    {
        try {

            $approve = PartnerFacility::where('mfl_code', $request->mflcode)
                ->update([
                    'is_approved' => "Yes",
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => Auth::user()->id,
                ]);
            if ($approve) {
                Session::flash('statuscode', 'success');

                return redirect('admin/my_facilities')->with('status', 'Facility has been approved successfully!');
            } else {

                Session::flash('statuscode', 'error');
                return back()->with('error', 'An error has occurred please try again later.');
            }
        } catch (Exception $e) {
            return back();
        }
    }
    public function edit_facility(Request $request)
    {
        try {
            $facility = PartnerFacility::where('mfl_code', $request->mfl_code)
                ->update([
                    'avg_clients' => $request->avg_clients,
                    'partner_id' => $request->partner,
                ]);
            if ($facility) {
                Session::flash('statuscode', 'success');

                return redirect('admin/my_facilities')->with('status', 'Facility updated successfully!');
            } else {

                Session::flash('statuscode', 'error');
                return back()->with('error', 'An error has occurred please try again later.');
            }
        } catch (Exception $e) {
            return back();
        }
    }
}
