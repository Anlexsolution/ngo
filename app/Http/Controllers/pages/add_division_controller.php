<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\userRole;
use App\Models\division;
use App\Models\gndivision;
use App\Models\loan;
use App\Models\loanrepayment;
use App\Models\loanschedule;
use App\Models\member;
use App\Models\saving;
use App\Models\village;
use App\Models\smallgroup;
use Illuminate\Support\Facades\Session;

class add_division_controller extends Controller
{
    //
    public function addDivision()
    {
        $getUserRole = userRole::all();
        $getSmallGroup = smallgroup::all();
        $getVillage = village::all();
        $getDivision = division::all();
        $getMember = member::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $getSavingData = saving::all();
        $getLoanRepaymentData = loanschedule::all();
        $getRepaymentData = loanrepayment::all();
        return view('pages.add_division_per', [ 'getRepaymentData' => $getRepaymentData, 'getLoanRepaymentData' => $getLoanRepaymentData, 'getSavingData' => $getSavingData, 'getUserRole' => $getUserRole, 'getSmallGroup' => $getSmallGroup, 'getVillage' => $getVillage, 'getDivision' => $getDivision, 'getMember' => $getMember, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    public function createDivision()
    {
        $getUserRole = userRole::all();
        $getDivision = division::where('deleted', '==', 0)->get();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.create_division', ['getUserRole' => $getUserRole, 'getDivision' => $getDivision, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    public function createdivisiondata(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $division = new Division();
            $division->divisionName = $request->input('divisionName');
            $division->save();

            return response()->json(['success' => true, 'code' => 200]);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'error' => 'Database error: ' . $e->getMessage(),
                'code' => 500,
            ]);
        } catch (\Exception $e) {
            // Handle general errors
            return response()->json([
                'error' => 'An unexpected error occurred: ' . $e->getMessage(),
                'code' => 500,
            ]);
        }
    }


    public function addVillage()
    {
        $getUserRole = userRole::all();
        $getDivision = division::where('deleted', '==', 0)->get();
        $getVillage = village::where('deleted', '==', 0)->get();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.add_vilage_per', ['getUserRole' => $getUserRole, 'getDivision' => $getDivision, 'getVillage' => $getVillage, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    public function createvillagedata(Request $request)
    {

        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $village = new village();
            $village->divisionId = $request->input('divisionId');
            $village->villageName = $request->input('villageName');
            $village->save();

            return response()->json(['success' => true, 'code' => 200]);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'error' => 'Database error: ' . $e->getMessage(),
                'code' => 500,
            ]);
        } catch (\Exception $e) {
            // Handle general errors
            return response()->json([
                'error' => 'An unexpected error occurred: ' . $e->getMessage(),
                'code' => 500,
            ]);
        }
    }

    public function addSmallGroup()
    {
        $getUserRole = userRole::all();
        $getDivision = division::all();
        $getVillage = village::all();
        $getSmallGroup = smallgroup::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.add_smallgroup_per', ['getUserRole' => $getUserRole, 'getDivision' => $getDivision, 'getVillage' => $getVillage, 'getSmallGroup' => $getSmallGroup, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    public function getVillages($divisionId)
    {
        $villages = village::where('divisionId', $divisionId)->get();
        return response()->json($villages);
    }

    public function getGnDivision($divisionId)
    {
        $gnDivision = gndivision::where('divisionId', $divisionId)->get();
        return response()->json($gnDivision);
    }

    public function createsmallgroupdata(Request $request)
    {
        $request->validate([
            'divisionId' => 'required',
            'villageId' => 'required',
            'smallGroupName' => 'required',
        ]);
        $smallgroup = new smallgroup();
        $smallgroup->divisionId = $request->input('divisionId');
        $smallgroup->villageId = $request->input('villageId');
        $smallgroup->smallGroupName = $request->input('smallGroupName');
        $smallgroup->save();
        return redirect()->back()->with('success', 'Small Group Added Successfully');
    }

    public function updateDivisionData(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $divisionId = $request->input('txtDivisionId');
            $division = division::find($divisionId);

            if (!$division) {
                return response()->json([
                    'error' => 'Division not found',
                    'code' => 404,
                ]);
            }

            $division->divisionName = $request->input('txtDivisionName');
            $division->save();

            return response()->json(['success' => true, 'code' => 200]);
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle database-related errors
            return response()->json([
                'error' => 'Database error: ' . $e->getMessage(),
                'code' => 500,
            ]);
        } catch (\Exception $e) {
            // Handle general errors
            return response()->json([
                'error' => 'An unexpected error occurred: ' . $e->getMessage(),
                'code' => 500,
            ]);
        }
    }

    public function deleteDivision(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $divisionId = $request->input('txtDivisionId');
            // $division = division::findOrFail($divisionId);
            // $division->delete();

            $division = division::find($divisionId);
            $division->deleted = 1;
            $division->save();

            return response()->json(['success' => true, 'code' => 200]);
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle database-related errors
            return response()->json([
                'error' => 'Database error: ' . $e->getMessage(),
                'code' => 500,
            ]);
        } catch (\Exception $e) {
            // Handle general errors
            return response()->json([
                'error' => 'An unexpected error occurred: ' . $e->getMessage(),
                'code' => 500,
            ]);
        }
    }

    public function deleteVillage(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $divisionId = $request->input('txtVillageId');
            $division = village::find($divisionId);
            $division->deleted = 1;
            $division->save();

            return response()->json(['success' => true, 'code' => 200]);
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle database-related errors
            return response()->json([
                'error' => 'Database error: ' . $e->getMessage(),
                'code' => 500,
            ]);
        } catch (\Exception $e) {
            // Handle general errors
            return response()->json([
                'error' => 'An unexpected error occurred: ' . $e->getMessage(),
                'code' => 500,
            ]);
        }
    }
}
