<?php

namespace App\Http\Controllers\pages;

use App\Helpers\activityLogHelper;
use App\Helpers\GeolocationHelper;
use App\Helpers\InsertHelper;
use App\Http\Controllers\Controller;
use App\Models\division;
use App\Models\loan;
use App\Models\loanpurpose;
use App\Models\loanpurposesub;
use App\Models\member;
use App\Models\Qualification;
use App\Models\Resourceperson;
use App\Models\userRole;
use App\Models\village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class resource_person_controller extends Controller
{


    public function getResourcePersonData(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $getResorceId = $request->input('txtResourcePerson');
            $getResData = DB::table('resourcepeople')->where('id', $getResorceId)->first();
            $contact_no = $getResData->contact_no;
            $designation = $getResData->designation;
            return response()->json([
                'success' => 'Resource Person created successfully',
                'code'    => 200,
                'contact_no' => $contact_no,
                "designation" => $designation
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'error' => 'Database error: ' . $e->getMessage(),
                'code'  => 500,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred: ' . $e->getMessage(),
                'code'  => 500,
            ]);
        }
    }

    public function addResourcePerson(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            // Get form values
            $txtFullName          = $request->input('txtFullName');
            $txtDivision          = $request->input('txtDivision');
            $txtVillage           = $request->input('txtVillage');
            $txType               = $request->input('txType');
            $txtDesignation       = $request->input('txtDesignation');
            $txtMainQualification = $request->input('txtMainQualification');
            $txtSubQualification  = $request->input('txtSubQualification');
            $txtDateOfBirth       = $request->input('txtDateOfBirth');
            $txtNic               = $request->input('txtNic');
            $txtContactNo         = $request->input('txtContactNo');
            $txtWhatsappNo        = $request->input('txtWhatsappNo');
            $txtaddress           = $request->input('txtaddress');

            // Get location information
            $latitude  = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData  = GeolocationHelper::getGeolocationData($latitude, $longitude);
            $location = $geoData['location'];
            $country  = $geoData['country'];

            // Prepare activity log data
            $ipAddress       = $request->ip();
            $activityMessage = 'Created new Resource Person: ' . $txtFullName;
            $type            = 'Insert';
            $className       = 'bg-primary';

            // Prepare data for insert
            $table = 'resourcepeople';
            $data = [
                'full_name'          => $txtFullName,
                'division_id'        => $txtDivision,
                'village_id'         => $txtVillage,
                'type'               => $txType,
                'designation'        => $txtDesignation,
                'main_qualification' => $txtMainQualification,
                'sub_qualification'  => $txtSubQualification,
                'date_of_birth'      => $txtDateOfBirth,
                'nic'                => $txtNic,
                'contact_no'         => $txtContactNo,
                'whatsapp_no'        => $txtWhatsappNo,
                'created_at'         => now(),
                'updated_at'         => now(),
                'address'            => $txtaddress,
            ];

            // Insert into database
            $result = InsertHelper::insertRecord($table, $data);

            if ($result === true) {
                // Log activity AFTER success
                activityLogHelper::activityLog($ipAddress, $location, $country, $activityMessage, $type, $className);

                return response()->json([
                    'success' => 'Resource Person created successfully',
                    'code'    => 200
                ]);
            } else {
                return response()->json(['error' => $result['error'], 'code' => 500]);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'error' => 'Database error: ' . $e->getMessage(),
                'code'  => 500,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred: ' . $e->getMessage(),
                'code'  => 500,
            ]);
        }
    }


    function manageResourcePerson()
    {
        $getUserRole = userRole::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $getloanMainCatData = loanpurpose::all();
        $getLoanSubCatData = loanpurposesub::all();
        $getResourcePerson = Resourceperson::all();
        $getDivisionData = division::all();
        $getVillageData = village::all();
        $getQualification = Qualification::all();
        return view('pages.permission.resourceperson.manage_resource_person_per', ['getQualification' => $getQualification, 'getVillageData' => $getVillageData, 'getDivisionData' => $getDivisionData, 'getResourcePerson' => $getResourcePerson, 'getUserRole' => $getUserRole, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData, 'getloanMainCatData' => $getloanMainCatData, 'getLoanSubCatData' => $getLoanSubCatData]);
    }

    function create_resource()
    {
        $getUserRole = userRole::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $getloanMainCatData = loanpurpose::all();
        $getLoanSubCatData = loanpurposesub::all();
        $getDivision = division::all();
        $getQualification = Qualification::all();
        return view('pages.permission.resourceperson.create_resource_per', ['getQualification' => $getQualification, 'getDivision' => $getDivision, 'getUserRole' => $getUserRole, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData, 'getloanMainCatData' => $getloanMainCatData, 'getLoanSubCatData' => $getLoanSubCatData]);
    }

    function getSubQualificaton(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $quaIsd = $request->input('quaIsd');
            $getVillageData = DB::table('s_ubqualifications')->where('qualificationId', $quaIsd)->get();
            $subquaOption = '<option value="">Select Sub Qualification</option>';
            foreach ($getVillageData as $villageData) {
                $subquaOption .= '<option value="' . $villageData->id . '">' . $villageData->subQualificationName . '</option>';
            }

            return response()->json(['subquaOption' => $subquaOption, 'code' => 200]);
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
