<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\userRole;
use App\Models\member;
use App\Models\division;
use App\Models\loan;
use App\Models\loanproduct;
use App\Models\Meeting;
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

        function manage_meetings()
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
        $meetingData = Meeting::all();
        return view('pages.permission.meetings.manage_meetings_per', [ 'meetingData' => $meetingData, 'getUserRole' => $getUserRole, 'getMember' => $getMember, 'getDivision' => $getDivision,  'villages' => $villages,  'smallGroups' => $smallGroups, 'getProfession' => $getProfession, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

public function createMeeting(Request $request)
{
    try {
        // CSRF check (optional: Laravel middleware handles this)
        if ($request->_token !== Session::token()) {
            return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
        }
        // Save meeting
        $meeting = new Meeting();
        $meeting->meeting_title = $request->meetingTitle;
        $meeting->meeting_date = $request->meetingDate;
        $meeting->meeting_time = $request->meetingTime;
        $meeting->resource_person = $request->resourcePerson;
        $meeting->resource_position = $request->resourcePosition;
        $meeting->resource_contact_no = $request->resourceContactNo;
        $meeting->meeting_type = $request->meetingType;
        $meeting->division_id = $request->divisionId;
        $meeting->village_id = $request->villageId;
        $meeting->small_group_id = $request->smallGroupId;
        $meeting->memberData = $request->memberData;
        $meeting->save();



        return response()->json(['message' => 'Meeting created successfully', 'code' => 200]);

    } catch (\Illuminate\Database\QueryException $e) {
        DB::rollBack();
        return response()->json([
            'error' => 'Database error: ' . $e->getMessage(),
            'code' => 500,
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'error' => 'An unexpected error occurred: ' . $e->getMessage(),
            'code' => 500,
        ]);
    }
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
                $villageOption .= '<option value="' . $villageData->id . '">' . $villageData->villageName . '</option>';
            }

            if ($request->input('txtMeetingType') == 'Division Meeting') {
                $getMemberData = DB::table('members')->where('divisionId', $txtDivision)->get();
            } else {
                $getMemberData = [];
            }

            return response()->json(['villageOption' => $villageOption, 'getMemberData' => $getMemberData, 'code' => 200]);
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
            $getVillageData = DB::table('smallgroups')->where('divisionId', $txtDivision)->where('villageId', $txtVillage)->get();
            $villageOption = '<option value="">Select Village</option>';
            foreach ($getVillageData as $villageData) {
                $villageOption .= '<option value="' . $villageData->id . '">' . $villageData->smallGroupName . '</option>';
            }

            if ($request->input('txtMeetingType') == 'Village Meeting') {
                $getMemberData = DB::table('members')->where('villageId', $txtVillage)->get();
            } else {
                $getMemberData = [];
            }

            return response()->json(['villageOption' => $villageOption, 'getMemberData' => $getMemberData, 'code' => 200]);
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

    function getMeetingSmallgroupDataTable(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txtSmallGroup = $request->input('txtSmallGroup');

            if ($request->input('txtMeetingType') == 'Group Meeting') {
                $getMemberData = DB::table('members')->where('smallGroupId', $txtSmallGroup)->get();
            } else {
                $getMemberData = [];
            }

            return response()->json(['getMemberData' => $getMemberData, 'code' => 200]);
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
