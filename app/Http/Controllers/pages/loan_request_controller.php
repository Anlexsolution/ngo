<?php

namespace App\Http\Controllers\pages;

use App\Helpers\activityLogHelper;
use App\Helpers\GeolocationHelper;
use App\Helpers\InsertHelper;
use App\Helpers\UpdateHelper;
use App\Http\Controllers\Controller;
use App\Models\gndivision;
use App\Models\gndivisionsmallgroup;
use App\Models\loan;
use App\Models\loandocument;
use App\Models\loanproduct;
use App\Models\loanrequest;
use App\Models\loanRequestmemberApproval;
use App\Models\loanschedule;
use App\Models\member;
use App\Models\profession;
use App\Models\subprofession;
use App\Models\userRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class loan_request_controller extends Controller
{
    //

    function loanWriteOffData(Request $request)
    {
        $loanId = $request->input('loanId');
        $loan = loanschedule::where('loanId', $loanId)->get();
        foreach ($loan as $loanData) {
            $getInterst = $loanData->interestPayment;
            $getTotalPay = $loanData->monthlyPayment;
            $getFinalTotal = $getTotalPay - $getInterst;
            $table = 'loanschedules';
            $data = [
                "status" => "write off",
            ];
            UpdateHelper::updateRecord($table, $loanData->id, $data);
        }
        return response()->json(['success' => 'Updated loan request  successfully', 'code' => 200]);
    }

    function loanInterestWiseData(Request $request)
    {
        $loanId = $request->input('loanId');
        $loan = loanschedule::where('loanId', $loanId)->get();
        foreach ($loan as $loanData) {
            $getInterst = $loanData->interestPayment;
            $getTotalPay = $loanData->monthlyPayment;
            $getFinalTotal = $getTotalPay - $getInterst;
            $getBalance = $loanData->balance;
            $table = 'loanschedules';
            $data = [
                "interestPayment" => 0,
                "monthlyPayment" => $getFinalTotal,
                "status" => "interest wise"
            ];
            UpdateHelper::updateRecord($table, $loanData->id, $data);
        }
        return response()->json(['success' => 'Updated loan request  successfully', 'code' => 200]);
    }

    function getLoanAmountNew(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }
            //get location information
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information

            $txtSelectMember = $request->input('txtSelectMember');
            $txtloanAmount = $request->input('txtloanAmount');
            $getLoansPur = DB::table('loanrequests')->where('memberId', $txtSelectMember)->where('status', 2)->where('loancreated', 0)->get();

            $getAllLoanOption = '';
            foreach ($getLoansPur as $get) {
                $floatValue = str_replace(',', '', $get->loanAmount);
                if ($floatValue == $txtloanAmount) {
                    $getAllLoanOption .= '<option value="' . $get->id . '" selected>' . number_format($get->loanAmount, 2) . '</option>';
                }
            }

            return response()->json(['success' => 'Create Profession successfully', 'getAllLoanOption' => $getAllLoanOption, 'code' => 200]);
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

    function getLoanAmount(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }
            //get location information
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information

            $txtSelectMember = $request->input('txtSelectMember');
            $getLoansPur = DB::table('loanrequests')->where('memberId', $txtSelectMember)->where('status', 2)->where('loancreated', 0)->get();

            $getAllLoanOption = '';
            foreach ($getLoansPur as $get) {
                $getAllLoanOption .= '<option value="' . $get->id . '">' . number_format($get->loanAmount, 2) . '</option>';
            }

            return response()->json(['success' => 'Create Profession successfully', 'getAllLoanOption' => $getAllLoanOption, 'code' => 200]);
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

    function viewLoanRequest($id)
    {
        $decId = Crypt::decrypt($id);
        $loanRequest = DB::table('loanrequests')->where('id', $decId)->first();
        $getMember = DB::table('members')->where('id', $loanRequest->memberId)->first();
        $getDocumentData = DB::table('loandocuments')->where('mainCategory', $loanRequest->mainCategoryId)->where('subCategory', $loanRequest->subCategoryId)->get();
        $getUserRole = userRole::all();
        $getProductData = loanproduct::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $getLoanreqAppData = loanRequestmemberApproval::all();
        $getAllDoc = loandocument::all();
        return view('pages.permission.loan.view_loan_request_per', ['getAllDoc' => $getAllDoc, 'getDocumentData' => $getDocumentData, 'getLoanreqAppData' => $getLoanreqAppData, 'getMember' => $getMember, 'loanRequest' => $loanRequest, 'getUserRole' => $getUserRole, 'getProductData' => $getProductData, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    function viewRequest($id)
    {
        $decId = Crypt::decrypt($id);
        $getLoanReqData = DB::table('loanrequests')->where('id', $decId)->first();
        $getMemId = $getLoanReqData->memberId;
        $member = \App\Models\Member::with(['division', 'village', 'smallgroup'])->find($getMemId);
        $getUniqueId = $getLoanReqData->uniqueId;
        $loanRequestHisData = DB::table('loanrequesthistories')->where('loanRequestId', $getUniqueId)
            ->join('users', 'users.id', '=', 'loanrequesthistories.approvedBy')
            ->select('loanrequesthistories.*', 'users.name as userName')->get();
        $getUserRole = userRole::all();
        $getProductData = loanproduct::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $getLoanreqAppData = loanRequestmemberApproval::all();
        $getPro = profession::all();
        $getSubPro = subprofession::all();
        $getGnDivision = gndivision::all();
        $gndivisionSmallgroup = gndivisionsmallgroup::all();
        $getReqApproveMemb = DB::table('loan_requestmember_approvals')->where('requestId', $decId)->get();
        return view('pages.permission.loan.view_request_per', ['getLoanReqData' => $getLoanReqData, 'getReqApproveMemb' => $getReqApproveMemb, 'getGnDivision' => $getGnDivision, 'gndivisionSmallgroup' => $gndivisionSmallgroup,  'getSubPro' => $getSubPro, 'getPro' => $getPro, 'member' => $member, 'loanRequestHisData' => $loanRequestHisData, 'getLoanreqAppData' => $getLoanreqAppData, 'getUserRole' => $getUserRole, 'getProductData' => $getProductData, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    function addLoanRequestRejected(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }


            //get location information
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information
            $txtRequestId = $request->input('txtRequestId');
            $getReqData = DB::table('loanrequests')->where('id', $txtRequestId)->first();
            $txtMember = $getReqData->memberId;
            $getMemData = DB::table('members')->where('id', $txtMember)->first();
            $getMemFName = $getMemData->firstName;
            $getMemlastName = $getMemData->lastName;


            $ipAddress = $request->ip();
            $activityMessage = 'Update loan Request Status: ' . $getMemFName . ' ' . $getMemlastName;
            $type = 'Insert';
            $className = 'bg-primary';

            $table = 'loanrequests';
            $data = [
                'status' => 3
            ];
            $result = UpdateHelper::updateRecord($table, $txtRequestId, $data);
            if ($result === true) {
                Session::put('loanRequest', loanrequest::all());
                return response()->json(['success' => 'Updated loan request  successfully', 'code' => 202, 'redirectUrl' => '/dashboard']);
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

    function addLoanRequestApprove(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }


            //get location information
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information
            $txtRequestId = $request->input('txtRequestId');
            $getReqData = DB::table('loanrequests')->where('id', $txtRequestId)->first();
            $txtMember = $getReqData->memberId;
            $getMemData = DB::table('members')->where('id', $txtMember)->first();
            $getMemFName = $getMemData->firstName;
            $getMemlastName = $getMemData->lastName;


            $ipAddress = $request->ip();
            $activityMessage = 'Update loan Request Status: ' . $getMemFName . ' ' . $getMemlastName;
            $type = 'Insert';
            $className = 'bg-primary';

            $selected = $request->input('selected');

            $table = 'loanrequests';
            $data = [
                'status' => 2
            ];

            $tableHis = 'loanrequesthistories';
            $dataHis = [
                'loanRequestId' => $getReqData->uniqueId,
                'approvedBy' => Auth::user()->id,
                'approvedStatus' => 'Approved',
                'documents' => $selected
            ];
            $result = UpdateHelper::updateRecord($table, $txtRequestId, $data);
            $resultHis = InsertHelper::insertRecord($tableHis, $dataHis);
            if ($result === true && $resultHis === true) {
                Session::put('loanRequest', loanrequest::all());
                return response()->json(['success' => 'Updated loan request  successfully', 'code' => 202, 'redirectUrl' => '/dashboard']);
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

    function addLoanRequestApproveMember(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }


            //get location information
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information

            $txtMember = $request->input('txtMember');
            $getMemData = DB::table('members')->where('id', $txtMember)->first();
            $getMemFName = $getMemData->firstName;
            $getMemlastName = $getMemData->lastName;
            $selectedOption = $request->input('selectedOption');
            $txtRemarks = $request->input('txtRemarks');
            $txtRequestId = $request->input('txtRequestId');

            $ipAddress = $request->ip();
            $activityMessage = 'Created new loan Request Approval: ' . $getMemFName . ' ' . $getMemlastName;
            $type = 'Insert';
            $className = 'bg-primary';

            $table = 'loan_requestmember_approvals';
            $data = [
                'memberId' => $txtMember,
                'selectedOption' => $selectedOption,
                'remarks' => $txtRemarks,
                'requestId' => $txtRequestId
            ];

            $result = InsertHelper::insertRecord($table, $data);

            if ($result === true) {
                return response()->json(['success' => 'Create loan request Approval  successfully', 'code' => 200]);
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

    function addLoanRequest(Request $request)
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

            $txtMember = $request->input('txtMember');
            $txtLoanAmount = $request->input('txtLoanAmount');
            $txtMainCategory = $request->input('txtMainCategory');
            $txtSubCategory = $request->input('txtSubCategory');
            $txUserType = $request->input('txUserType');
            $documents = $request->input('selected');

            $uniqueId = str_pad(random_int(0, 999999999999), 12, '0', STR_PAD_LEFT);


            $ipAddress = $request->ip();
            $activityMessage = 'Created new loan Request: ' . $txtMember;
            $type = 'Insert';
            $className = 'bg-primary';

            $table = 'loanrequests';
            $data = [
                'memberId' => $txtMember,
                'loanAmount' => $txtLoanAmount,
                'mainCategoryId' => $txtMainCategory,
                'subCategoryId' => $txtSubCategory,
                'userTypeId' => $txUserType,
                'status' => 1,
                'uniqueId' => $uniqueId,
                'documents' => $documents
            ];

            $tableHis = 'loanrequesthistories';
            $dataHis = [
                'loanRequestId' => $uniqueId,
                'approvedBy' => Auth::user()->id,
                'approvedStatus' => 'Requested',
                'documents' => $documents
            ];
            $result = InsertHelper::insertRecord($table, $data);
            $resultHis = InsertHelper::insertRecord($tableHis, $dataHis);
            if ($result === true && $resultHis === true) {
                return response()->json(['success' => 'Create loan request successfully', 'code' => 200]);
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

    function getPurposeSubCat(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }
            //get location information
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information

            $txtMainCategory = $request->input('txtMainCategory');
            $getLoansPur = DB::table('loanpurposesubs')->where('mainCatId', $txtMainCategory)->get();

            $getAllLoanOption = '<option value="">---select----</option>';
            foreach ($getLoansPur as $get) {
                $getAllLoanOption .= '<option value="' . $get->id . '">' . $get->name . '</option>';
            }

            return response()->json(['success' => 'Create Profession successfully', 'getAllLoanOption' => $getAllLoanOption, 'code' => 200]);
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
