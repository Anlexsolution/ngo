<?php

namespace App\Http\Controllers\pages;

use App\Helpers\GeolocationHelper;
use App\Http\Controllers\Controller;
use App\Imports\otherIncomeImport;
use App\Models\division;
use App\Models\loan;
use App\Models\member;
use App\Models\otherincome;
use App\Models\profession;
use App\Models\userRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class manage_other_income_controller extends Controller
{

        function otherIncomeImportData(Request $request)
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
            $activityMessage = 'Import Death Details: ' . $filename;
            $type = 'Import';
            $className = 'bg-success';

            Excel::import(new otherIncomeImport, storage_path('app/imports/' . $filename));
            return response()->json(['success' => 'import Death History successfully', 'code' => 200]);

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

    function manageOtherIncomes(){
        $getUserRole = userRole::all();
        $getOtherIncome = otherincome::all();
        $getOtherIncome = otherincome::with('member')->get();
        $getDivision = division::all();
        $getProfession = profession::all();
        $villages = [];
        $smallGroups = [];
        $getMember = member::with('division', 'village', 'smallgroup')->get();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.permission.otherincome.manage_other_incomes_per', ['getUserRole' => $getUserRole, 'getOtherIncome' => $getOtherIncome,  'getMember' => $getMember, 'getDivision' => $getDivision,  'villages' => $villages,  'smallGroups' => $smallGroups, 'getProfession' => $getProfession, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }
}
