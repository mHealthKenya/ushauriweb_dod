<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partner;
use App\Models\Unit;
use Session;

class UnitController extends Controller
{
    public function index()
    {
        $all_unit = Unit::join('tbl_partner', 'tbl_unit.service_id', '=', 'tbl_partner.id')
            ->select('tbl_unit.unit_name as unit_name', 'tbl_partner.name as partner_name', 'tbl_unit.id', 'tbl_unit.created_at', 'tbl_unit.updated_at')
            ->get();

        $services = Partner::all();

        return view('units.units', compact('services', 'all_unit'));
    }

    public function addUnit(Request $request)
    {

        try {
            $unit = new Unit;

            $unit->unit_name = $request->unit_name;
            $unit->service_id = $request->service;
            if ($unit->save()) {
                Session::flash('statuscode', 'success');

                return redirect('admin/units')->with('status', 'Unit has been saved successfully!');
            } else {

                Session::flash('statuscode', 'error');
                return back()->with('error', 'An error has occurred please try again later.');
            }
        } catch (Exception $e) {
            Session::flash('statuscode', 'error');
            return back()->with('error', 'An error has occurred please try again later.');
        }
    }
    public function editUnit(Request $request)
    {
        try {
            $unit = Unit::where('id', $request->id)
                ->update([
                    'unit_name' => $request->name,
                    'service_id' => $request->service,
                ]);
            if ($unit) {
                Session::flash('statuscode', 'success');
                return redirect('admin/units')->with('status', 'Unit was successfully Updated in the system!');
            } else {
                Session::flash('statuscode', 'error');
                return back()->with('error', 'Could not update donor please try again later.');
            }
        } catch (Exception $e) {
            return back();
        }
    }
    public function deleteUnit(Request $request)
    {
        try {
            $unit = Unit::find($request->id);
            // $donor->update_at = date('Y-m-d H:i:s');
            if ($unit->save()) {
                Session::flash('statuscode', 'success');
                return redirect('admin/units')->with('status', 'Unit has been deleted successfully');
            } else {
                Session::flash('statuscode', 'error');
                return back()->with('error', 'An error has occurred please try again later.');
            }
        } catch (Exception $e) {
        }
    }
}
