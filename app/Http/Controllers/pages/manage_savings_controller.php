<?php

namespace App\Http\Controllers\pages;

use App\Helpers\GeolocationHelper;
use App\Http\Controllers\Controller;
use App\Imports\savingHistoryImport;
use App\Models\division;
use App\Models\loan;
use App\Models\member;
use App\Models\profession;
use Illuminate\Http\Request;
use App\Models\saving;
use App\Models\savinginterest;
use App\Models\savingtransectionhistory;
use App\Models\userRole;
use App\Models\withdrawalhistory;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

use function Laravel\Prompts\table;

class manage_savings_controller extends Controller
{

        function importSavingsData(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $filename = $request->file('file')->getClientOriginalName();

            $path = $request->file('file')->storeAs('imports', $filename);

            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information

            $ipAddress = $request->ip();
            $activityMessage = 'Import member Details: ' . $filename;
            $type = 'Import';
            $className = 'bg-success';

            Excel::import(new savingHistoryImport, storage_path('app/imports/' . $filename));
            return response()->json(['success' => 'import Saving History successfully', 'code' => 200]);

            // $table = 'membernotes';
            // $data = [
            //     'memberId' => $txtMemberId,
            //     'title' => $txtTitle,
            //     'description' => $txtDescription
            // ];
            // $result = InsertHelper::insertRecord($table, $data);
            // if ($result === true) {
            //     return response()->json(['success' => 'created member note successfully', 'code' => 200]);
            //     $activityLogResult = activityLogHelper::activityLog($ipAddress, $location, $country, $activityMessage, $type, $className);
            // } else {
            //     return response()->json(['error' => $result['error'], 'code' => 500]);
            // }
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


    public function viewSavingsHistories($id)
    {
        $decId = Crypt::decrypt($id);
        // dd($decId);
        $getUserRole = userRole::all();
        $getSavings = saving::all();
        $getSavings = saving::with('member')->get();
        $getDivision = division::all();
        $getProfession = profession::all();
        $villages = [];
        $smallGroups = [];
        $getMember = member::with('division', 'village', 'smallgroup')->get();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $getSavingTransec = DB::table('savingtransectionhistories')->where('savingId', $decId)->get();
        return view('pages.view_member_sav_his_per', ['getSavingTransec' => $getSavingTransec, 'getUserRole' => $getUserRole, 'getSavings' => $getSavings, 'getMember' => $getMember, 'getDivision' => $getDivision,  'villages' => $villages,  'smallGroups' => $smallGroups, 'getProfession' => $getProfession, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }
    public function manageSavings()
    {
        $getUserRole = userRole::all();
        $getSavings = saving::all();
        $getSavings = saving::with('member')->get();
        $getDivision = division::all();
        $getProfession = profession::all();
        $villages = [];
        $smallGroups = [];
        $getMember = member::with('division', 'village', 'smallgroup')->get();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.manage_savings_per', ['getUserRole' => $getUserRole, 'getSavings' => $getSavings, 'getMember' => $getMember, 'getDivision' => $getDivision,  'villages' => $villages,  'smallGroups' => $smallGroups, 'getProfession' => $getProfession, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    public function viewSavingsHistory($id)
    {
        $decId = decrypt($id);
        $getUserRole = userRole::all();
        $getSavingHistory = savingtransectionhistory::where('savingId', $decId)->get();
        $getmemuniId = DB::table('savings')->where('savingsId', $decId)->first();
        $getmemberUniqueId = $getmemuniId->memberId;
        $getmem = DB::table('members')->where('uniqueId', $getmemberUniqueId)->first();
        $getMemberId = $getmem->id;
        $getUser = User::all();
        $getMember = member::with('division', 'village', 'smallgroup')->get();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $geInterData = savinginterest::where('savingId', $decId)->get();
        $getSIdData = saving::where('savingsId', $decId)->first();
        $getSavId = $getSIdData->id;
        $getWithHisData = withdrawalhistory::where('savingId', $getSavId)->get();
$withdrawalhistories = DB::table('withdrawalhistories')->where('memberId', $getmemberUniqueId)->where('status', 'Withdrawal successfully')->get();
        return view('pages.view_saving_history_per', [ 'withdrawalhistories' => $withdrawalhistories, 'getWithHisData' => $getWithHisData,  'geInterData' => $geInterData, 'memberUniqueId' => $getmem->uniqueId,  'memberId' => $getMemberId, 'getUser' => $getUser, 'getUserRole' => $getUserRole, 'getSavingHistory' => $getSavingHistory, 'getMember' => $getMember, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }
}
