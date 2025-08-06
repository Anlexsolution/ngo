<?php

namespace App\Http\Controllers\pages;

use App\Helpers\activityLogHelper;
use App\Helpers\GeolocationHelper;
use App\Helpers\InsertHelper;
use App\Helpers\UpdateHelper;
use App\Http\Controllers\Controller;
use App\Models\account;
use App\Models\accountsetting;
use App\Models\loan;
use App\Models\loandocument;
use App\Models\loanpurpose;
use App\Models\loanpurposesub;
use App\Models\loginactivitylog;
use App\Models\meetingcategory;
use App\Models\meetingtype;
use App\Models\member;
use App\Models\profession;
use App\Models\relative;
use App\Models\subprofession;
use App\Models\systemactivitylog;
use App\Models\userRole;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class manage_settings_controller extends Controller
{


    function loanDocumentSettings()
    {
        $getUserRole = userRole::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $getloanMainCatData = loanpurpose::all();
        $getLoanSubCatData = loanpurposesub::all();
        $getLoanDocData = DB::table('loandocuments')
            ->join('loanpurposes', 'loanpurposes.id', '=', 'loandocuments.mainCategory')
            ->join('loanpurposesubs', 'loanpurposesubs.id', '=', 'loandocuments.subCategory')
            ->select('loandocuments.*', 'loanpurposes.name as mainCategoryName', 'loanpurposesubs.name as subCategoryName')->get();
        return view('pages.permission.settings.loan_document_settings_per', ['getLoanDocData' => $getLoanDocData, 'getUserRole' => $getUserRole, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData, 'getloanMainCatData' => $getloanMainCatData, 'getLoanSubCatData' => $getLoanSubCatData]);
    }

    function loanDocData(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $docList = $request->input('docList');
            $txtMainCategory = $request->input('txtMainCategory');
            $txtSubCategory = $request->input('txtSubCategory');

            //get location information
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information

            $docList = json_decode($docList, true);

            foreach ($docList as $documentName) {
                $ipAddress = $request->ip();
                $activityMessage = 'Created new Loan Document: ' . $documentName;
                $type = 'Insert';
                $className = 'bg-primary';

                $table = 'loandocuments';
                $data = [
                    'name' => $documentName,
                    'mainCategory' => $txtMainCategory,
                    'subCategory' => $txtSubCategory
                ];
                $result = InsertHelper::insertRecord($table, $data);
                $activityLogResult = activityLogHelper::activityLog($ipAddress, $location, $country, $activityMessage, $type, $className);
            }
            if ($result === true) {
                return response()->json(['success' => 'Create Loan Document successfully', 'code' => 200]);
            } else {
                return response()->json(['error' => $result['error'], 'code' => 500]);
            }
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

    function manageInterstSettings()
    {
        $getUserRole = userRole::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $countData = DB::table('interestsettings')->count();
        if ($countData > 0) {
            $getData = DB::table('interestsettings')->first();
            $getInterest = $getData->interest;
        } else {
            $getInterest = '';
        }
        return view('pages.permission.settings.manage_interest_settings_per', ['getInterest' => $getInterest, 'getUserRole' => $getUserRole, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    function manageSettings()
    {
        $getUserRole = userRole::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.manage_settings_per', ['getUserRole' => $getUserRole, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }



    function manageAccountSettings()
    {
        $getUserRole = userRole::all();
        $managePro = profession::all();
        $getLoansData = loan::all();
        $getAccountData = account::all();
        $getcountaccount = DB::table('accountsettings')->first();
        $getAllMemberData = member::all();
        return view('pages.permission.settings.manage_account_settings_per', ['getcountaccount' => $getcountaccount, 'getAccountData' => $getAccountData, 'managePro' => $managePro, 'getUserRole' => $getUserRole, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    function manageProfession()
    {
        $getUserRole = userRole::all();
        $managePro = profession::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $getAllSubProfession = subprofession::all();
        return view('pages.permission.settings.manage_profession_per', [ 'getAllSubProfession' => $getAllSubProfession, 'managePro' => $managePro, 'getUserRole' => $getUserRole, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    function meetingCategory()
    {
        $getUserRole = userRole::all();
        $manageMeetingType = meetingcategory::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.permission.settings.meeting_category_per', ['manageMeetingType' => $manageMeetingType, 'getUserRole' => $getUserRole, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    function manageActivitylog()
    {
        $getUserRole = userRole::all();
        $manageLoginActivity = loginactivitylog::all();
        $systemActivityLog = systemactivitylog::all();
        $userData = Users::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.permission.settings.manage_activitylog_per', ['getUserRole' => $getUserRole, 'manageLoginActivity' => $manageLoginActivity, 'systemActivityLog' => $systemActivityLog, 'userData' => $userData, 'getAllMemberData' => $getAllMemberData, 'getLoansData' => $getLoansData]);
    }

    function relativeSettings()
    {
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $getRelativeData = relative::all();
        return view('pages.permission.settings.manage_relative_settings_per', ['getRelativeData' => $getRelativeData, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    function addRelative(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $addRelativeName = $request->input('addRelativeName');

            //get location information
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information

            $ipAddress = $request->ip();
            $activityMessage = 'Created new relative: ' . $addRelativeName;
            $type = 'Insert';
            $className = 'bg-primary';

            $table = 'relatives';
            $data = [
                'name' => $addRelativeName,
                'addedBy' => Auth::user()->id,
            ];
            $result = InsertHelper::insertRecord($table, $data);
            if ($result === true) {
                return response()->json(['success' => 'Create Relative successfully', 'code' => 200]);
                $activityLogResult = activityLogHelper::activityLog($ipAddress, $location, $country, $activityMessage, $type, $className);
            } else {
                return response()->json(['error' => $result['error'], 'code' => 500]);
            }
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


    function createProfession()
    {
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.permission.settings.create_profession_per', ['getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    function addProfession(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $modalProfessionName = $request->input('modalProfessionName');

            //get location information
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information

            $ipAddress = $request->ip();
            $activityMessage = 'Created new profession: ' . $modalProfessionName;
            $type = 'Insert';
            $className = 'bg-primary';

            $table = 'professions';
            $data = [
                'name' => $modalProfessionName
            ];
            $result = InsertHelper::insertRecord($table, $data);
            if ($result === true) {
                return response()->json(['success' => 'Create Profession successfully', 'code' => 200]);
                $activityLogResult = activityLogHelper::activityLog($ipAddress, $location, $country, $activityMessage, $type, $className);
            } else {
                return response()->json(['error' => $result['error'], 'code' => 500]);
            }
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

        function addSubProfession(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txtSubProName = $request->input('txtSubProName');
            $txtSubProfessionId = $request->input('txtSubProfessionId');

            //get location information
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information

            $ipAddress = $request->ip();
            $activityMessage = 'Created new Sub profession: ' . $txtSubProName;
            $type = 'Insert';
            $className = 'bg-primary';

            $table = 'subprofessions';
            $data = [
                'name' => $txtSubProName,
                'professionId' => $txtSubProfessionId
            ];
            $result = InsertHelper::insertRecord($table, $data);
            if ($result === true) {
                return response()->json(['success' => 'Create Sub Profession successfully', 'code' => 200]);
                $activityLogResult = activityLogHelper::activityLog($ipAddress, $location, $country, $activityMessage, $type, $className);
            } else {
                return response()->json(['error' => $result['error'], 'code' => 500]);
            }
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

    function addMeetingCategory(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txtMeetingTypeName = $request->input('txtMeetingTypeName');

            //get location information
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information

            $ipAddress = $request->ip();
            $activityMessage = 'Created new Meeting category: ' . $txtMeetingTypeName;
            $type = 'Insert';
            $className = 'bg-primary';

            $table = 'meetingcategories';
            $data = [
                'name' => $txtMeetingTypeName
            ];
            $result = InsertHelper::insertRecord($table, $data);
            if ($result === true) {
                return response()->json(['success' => 'Create Meeting Category successfully', 'code' => 200]);
                $activityLogResult = activityLogHelper::activityLog($ipAddress, $location, $country, $activityMessage, $type, $className);
            } else {
                return response()->json(['error' => $result['error'], 'code' => 500]);
            }
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


    function updateAccountDetails(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txtSelectCollectionAccount = $request->input('txtSelectCollectionAccount');

            //get location information
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information

            $ipAddress = $request->ip();
            $activityMessage = 'update account details: ' . $txtSelectCollectionAccount;
            $type = 'Update';
            $className = 'bg-success';

            $table = 'accountsettings';
            $data = [
                'accountId' => $txtSelectCollectionAccount
            ];

            $getAccountDetails = DB::table('accountsettings')->count();

            if ($getAccountDetails == 0) {
                $result = InsertHelper::insertRecord($table, $data);
            } else {
                $getdetails = DB::table('accountsettings')->first();
                $getId = $getdetails->id;
                $result = UpdateHelper::updateRecord($table, $getId, $data);
            }
            if ($result === true) {
                return response()->json(['success' => 'Updated Account details successfully', 'code' => 200]);
                $activityLogResult = activityLogHelper::activityLog($ipAddress, $location, $country, $activityMessage, $type, $className);
            } else {
                return response()->json(['error' => $result['error'], 'code' => 500]);
            }
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



    function updateProfession(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $modalProfessionName = $request->input('txtproName');
            $modalProfessionId = $request->input('txtProfessionId');

            //get location information
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information

            $ipAddress = $request->ip();
            $activityMessage = 'Update new profession: ' . $modalProfessionName;
            $type = 'Update';
            $className = 'bg-success';

            $table = 'professions';
            $data = [
                'name' => $modalProfessionName
            ];
            $result = UpdateHelper::updateRecord($table, $modalProfessionId, $data);
            if ($result === true) {
                return response()->json(['success' => 'Updated Profession successfully', 'code' => 200]);
                $activityLogResult = activityLogHelper::activityLog($ipAddress, $location, $country, $activityMessage, $type, $className);
            } else {
                return response()->json(['error' => $result['error'], 'code' => 500]);
            }
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


    function updateMeetingCategory(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txtMeetingTypeId = $request->input('txtMeetingTypeId');
            $txtMeetingTypeNameUpdate = $request->input('txtMeetingTypeNameUpdate');

            //get location information
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information

            $ipAddress = $request->ip();
            $activityMessage = 'Update new Meeting Category: ' . $txtMeetingTypeNameUpdate;
            $type = 'Update';
            $className = 'bg-success';

            $table = 'meetingcategories';
            $data = [
                'name' => $txtMeetingTypeNameUpdate
            ];
            $result = UpdateHelper::updateRecord($table, $txtMeetingTypeId, $data);
            if ($result === true) {
                return response()->json(['success' => 'Updated Meeting Category successfully', 'code' => 200]);
                $activityLogResult = activityLogHelper::activityLog($ipAddress, $location, $country, $activityMessage, $type, $className);
            } else {
                return response()->json(['error' => $result['error'], 'code' => 500]);
            }
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

    function deleteProfession(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txtProId = $request->input('txtProId');

            $getprofession =  profession::find($txtProId)->first();
            $name = $getprofession->name;
            //get location information
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information

            $ipAddress = $request->ip();
            $activityMessage = 'Deleted new profession: ' . $name;
            $type = 'Delete';
            $className = 'bg-danger';

            $table = 'professions';
            $data = [
                'deleted' => 1
            ];
            $result = UpdateHelper::updateRecord($table, $txtProId, $data);
            if ($result === true) {
                return response()->json(['success' => 'Deleted Profession successfully', 'code' => 200]);
                $activityLogResult = activityLogHelper::activityLog($ipAddress, $location, $country, $activityMessage, $type, $className);
            } else {
                return response()->json(['error' => $result['error'], 'code' => 500]);
            }
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

    function interestSettingData(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txtInterestRate = $request->input('txtInterestRate');

            //get location information
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information


            $table = 'interestsettings';
            $data = [
                'interest' => $txtInterestRate
            ];

            DB::table($table)->truncate();

            $result = InsertHelper::insertRecord($table, $data);
            if ($result === true) {
                return response()->json(['success' => 'Updated Interest rate successfully', 'code' => 200]);
            } else {
                return response()->json(['error' => $result['error'], 'code' => 500]);
            }
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
