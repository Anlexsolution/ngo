<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\userRole;
use App\Models\member;
use App\Models\division;
use App\Models\loan;
use App\Models\loanproduct;
use App\Models\profession;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class manage_meeting_controller extends Controller
{
        function addMeetings()
    {
        $getUserRole = userRole::all();
        $getMember = member::all();
        $getDivision = division::all();
        $getProfession = profession::all();
        $villages = [];
        $smallGroups = [];
        $getMember = member::with('division', 'village', 'smallgroup')->get();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.permission.meetings.add_meeting_per', ['getUserRole' => $getUserRole, 'getMember' => $getMember, 'getDivision' => $getDivision,  'villages' => $villages,  'smallGroups' => $smallGroups, 'getProfession' => $getProfession, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

        function getMeetingVillageData(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txtDivision = $request->input('txtDivision');
            $getVillageData = DB::table('villages')->where('divisionId', $txtDivision)->get();
            $villageOption = '<option value="">Select Village</option>';
            foreach ($getVillageData as $villageData) {
                $villageOption .= '<option value="' . $villageData->villageName . '">' . $villageData->villageName . '</option>';
            }

            return response()->json(['villageOption' => $villageOption, 'code' => 200]);
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

            function getMeetingSmallgroupData(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txtDivision = $request->input('txtDivision');
              $txtVillage = $request->input('txtVillage');
            $getVillageData = DB::table('villages')->where('divisionId', $txtDivision)->get();
            $villageOption = '<option value="">Select Village</option>';
            foreach ($getVillageData as $villageData) {
                $villageOption .= '<option value="' . $villageData->villageName . '">' . $villageData->villageName . '</option>';
            }

            return response()->json(['villageOption' => $villageOption, 'code' => 200]);
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
}
