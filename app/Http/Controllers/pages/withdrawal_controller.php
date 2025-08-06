<?php

namespace App\Http\Controllers\pages;

use App\Helpers\activityLogHelper;
use App\Helpers\GeolocationHelper;
use App\Helpers\InsertHelper;
use App\Helpers\UpdateHelper;
use App\Http\Controllers\Controller;
use App\Models\account;
use App\Models\loan;
use App\Models\loanproduct;
use App\Models\loanRequestmemberApproval;
use App\Models\member;
use App\Models\saving;
use App\Models\userRole;
use App\Models\withdrawal;
use App\Models\withdrawalhistory;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\str;

class withdrawal_controller extends Controller
{

    function viewWithHistory($id)
    {
        $decId = Crypt::decrypt($id);
        $getMember = member::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $getAllUser = User::all();
        $getWithdrawalData = DB::table('withdrawalhistories')->where('withdrawalId', $decId)->get();
        $getAllWithdrawal = withdrawal::all();
        return view('pages.permission.reports.view_withdrawal_history_per', ['getAllWithdrawal' => $getAllWithdrawal, 'getWithdrawalData' => $getWithdrawalData, 'getAllUser' => $getAllUser, 'getMember' => $getMember, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    function withApproveStatus()
    {
        $getMember = member::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $getAllUser = User::all();
        $getWithdrawalData = DB::table('withdrawalhistories')->get();
        $getAllWithdrawal = withdrawal::all();
        $getDivision = DB::table('divisions')->get();
        $getProfession = DB::table('professions')->get();
        $getUserRole = userRole::all();
        return view('pages.permission.reports.withrawal_approve_reports_per', [ 'getUserRole' => $getUserRole, 'getProfession' => $getProfession, 'getDivision' => $getDivision,  'getAllWithdrawal' => $getAllWithdrawal, 'getWithdrawalData' => $getWithdrawalData, 'getAllUser' => $getAllUser, 'getMember' => $getMember, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    function approveWithdrawal($id)
    {
        $decId = Crypt::decrypt($id);
        $getWithdrawalData = DB::table('withdrawals')->where('id', $decId)->first();
        $getWithId = $getWithdrawalData->withdrawalId;
        $getWithHisData = DB::table('withdrawalhistories')->where('withdrawalId', $getWithId)->get();
        $getUserRole = userRole::all();
        $getProductData = loanproduct::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $getAllUser = User::all();
        $getSavingData = saving::all();
        $getAccountData = account::all();
        $getLoanreqAppData = loanRequestmemberApproval::all();
        return view('pages.permission.withdrawal.view_withdrawal_request_per', ['getAccountData' => $getAccountData, 'withId' => $getWithId, 'getSavingData' => $getSavingData, 'getAllUser' => $getAllUser, 'getWithHisData' => $getWithHisData, 'getWithdrawalData' => $getWithdrawalData, 'getLoanreqAppData' => $getLoanreqAppData, 'getUserRole' => $getUserRole, 'getProductData' => $getProductData, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }


    function firstApproval(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txtReasonFirst = $request->input('txtReasonFirst');
            $txtSecondApproveUserType = $request->input('txtSecondApproveUserType');
            $txtApproveStatusFirst = $request->input('txtApproveStatusFirst');
            $txtWithId = $request->input('txtWithId');
            $getWithData = DB::table('withdrawals')->where('withdrawalId', $txtWithId)->first();
            $getWithId = $getWithData->id ?? 0;
            $getAm = $getWithData->amount;
            $getmemberId = $getWithData->memberId;
            $getsavingId = $getWithData->savingId;


            //get location information
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information

            $ipAddress = $request->ip();
            $activityMessage = 'First Approved for withdrawal: ' . $txtWithId;
            $type = '1st Approve';
            $className = 'bg-success';

            if ($txtApproveStatusFirst == 1) {
                $approveStats = '1st Approve completed';
            } else {
                $approveStats = 'Rejected';
            }

            $table = 'withdrawals';
            $data = [
                'request' => $txtApproveStatusFirst,
                'status' => $approveStats,
                'approveUserType' => $txtSecondApproveUserType
            ];
            $result = UpdateHelper::updateRecord($table, $getWithId, $data);

            $tableHis = 'withdrawalhistories';
            $datahis = [
                'userId' => Auth::user()->id,
                'amount' => $getAm,
                'request' => $txtApproveStatusFirst,
                'status' => $approveStats,
                'memberId' => $getmemberId,
                'savingId' => $getsavingId,
                'withdrawalId' => $txtWithId,
                'reason' => $txtReasonFirst,
                'approveUserType' => $txtSecondApproveUserType
            ];
            $resultHis = InsertHelper::insertRecord($tableHis, $datahis);

            if ($result === true && $resultHis === true) {
                Session::put('withdrawal', withdrawal::all());
                Session::put('withdrawalHistory', withdrawalhistory::all());
                return response()->json(['success' => 'Withrawal 1st Approved successfully', 'code' => 202, 'redirectUrl' => '/dashboard']);
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

    function secondApproval(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txtReasonSecond = $request->input('txtReasonSecond');
            $txtThirdApproveUserType = $request->input('txtThirdApproveUserType');
            $txtApproveStatusSecond = $request->input('txtApproveStatusSecond');
            $txtWithId = $request->input('txtWithId');
            $getWithData = DB::table('withdrawals')->where('withdrawalId', $txtWithId)->first();
            $getWithId = $getWithData->id;
            $getAm = $getWithData->amount;
            $getmemberId = $getWithData->memberId;
            $getsavingId = $getWithData->savingId;


            //get location information
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information

            $ipAddress = $request->ip();
            $activityMessage = 'Second Approved for withdrawal: ' . $txtWithId;
            $type = '2nd Approve';
            $className = 'bg-success';

            if ($txtApproveStatusSecond == 2) {
                $approveStats = '2nd Approve completed';
            } else {
                $approveStats = 'Rejected';
            }

            $table = 'withdrawals';
            $data = [
                'request' => $txtApproveStatusSecond,
                'status' => $approveStats,
                'approveUserType' => $txtThirdApproveUserType
            ];
            $result = UpdateHelper::updateRecord($table, $getWithId, $data);

            $tableHis = 'withdrawalhistories';
            $datahis = [
                'userId' => Auth::user()->id,
                'amount' => $getAm,
                'request' => $txtApproveStatusSecond,
                'status' => $approveStats,
                'memberId' => $getmemberId,
                'savingId' => $getsavingId,
                'withdrawalId' => $txtWithId,
                'reason' => $txtReasonSecond,
                'approveUserType' => $txtThirdApproveUserType
            ];
            $resultHis = InsertHelper::insertRecord($tableHis, $datahis);

            if ($result === true && $resultHis === true) {
                Session::put('withdrawal', withdrawal::all());
                Session::put('withdrawalHistory', withdrawalhistory::all());
                return response()->json(['success' => 'Withrawal 2nd Approved successfully', 'code' => 202, 'redirectUrl' => '/dashboard']);
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

    function thirdApproval(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txtReasonThird = $request->input('txtReasonThird');
            $txtForthApproveUserType = $request->input('txtForthApproveUserType');
            $txtApproveStatusThird = $request->input('txtApproveStatusThird');
            $txtWithId = $request->input('txtWithId');
            $getWithData = DB::table('withdrawals')->where('withdrawalId', $txtWithId)->first();
            $getWithId = $getWithData->id;
            $getAm = $getWithData->amount;
            $getmemberId = $getWithData->memberId;
            $getsavingId = $getWithData->savingId;


            //get location information
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information

            $ipAddress = $request->ip();
            $activityMessage = 'Third Approved for withdrawal: ' . $txtWithId;
            $type = '3rd Approve';
            $className = 'bg-success';

            if ($txtApproveStatusThird == 3) {
                $approveStats = '3rd Approve completed';
            } else {
                $approveStats = 'Rejected';
            }

            $table = 'withdrawals';
            $data = [
                'request' => $txtApproveStatusThird,
                'status' => $approveStats,
                'approveUserType' => $txtForthApproveUserType
            ];
            $result = UpdateHelper::updateRecord($table, $getWithId, $data);

            $tableHis = 'withdrawalhistories';
            $datahis = [
                'userId' => Auth::user()->id,
                'amount' => $getAm,
                'request' => $txtApproveStatusThird,
                'status' => $approveStats,
                'memberId' => $getmemberId,
                'savingId' => $getsavingId,
                'withdrawalId' => $txtWithId,
                'reason' => $txtReasonThird,
                'approveUserType' => $txtForthApproveUserType
            ];
            $resultHis = InsertHelper::insertRecord($tableHis, $datahis);

            if ($result === true && $resultHis === true) {
                Session::put('withdrawal', withdrawal::all());
                Session::put('withdrawalHistory', withdrawalhistory::all());
                return response()->json(['success' => 'Withrawal 3rd Approved successfully', 'code' => 202, 'redirectUrl' => '/dashboard']);
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

    function forthApproval(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txtReasonForth = $request->input('txtReasonForth');
            $txtWithAccount = $request->input('txtWithAccount');
            $txtApproveStatusForth = $request->input('txtApproveStatusForth');
            $txtWithId = $request->input('txtWithId');
            $getWithData = DB::table('withdrawals')->where('withdrawalId', $txtWithId)->first();
            $getWithId = $getWithData->id;
            $getAm = $getWithData->amount;
            $getmemberId = $getWithData->memberId;
            $getsavingId = $getWithData->savingId;

            $getMemData = DB::table('members')->where('uniqueId', $getmemberId)->first();
            $getMemId = $getMemData->id;


            //get location information
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information

            $ipAddress = $request->ip();

            if ($txtApproveStatusForth == 4) {
                $approveStats = 'Withdrawal successfully';
                $withAc = $txtWithAccount;
                $getWithAccData = DB::table('accounts')->where('id', $txtWithAccount)->first();
                $balance = $getWithAccData->balance;
                if ($balance >= $getAm) {
                    $newBalance = $balance - $getAm;
                    $updateBalance = DB::table('accounts')->where('id', $txtWithAccount)->update(['balance' => $newBalance]);
                    $accHisTable = 'accounttransectionhistories';
                    $accHisData = [
                        'collectionBy' => Auth::user()->id,
                        'accountId' => $txtWithAccount,
                        'amount' => $getAm,
                        'description' => 'Withdrawal',
                        'status' => 'Debit',
                        'memberId' => $getMemId
                    ];
                    $accHisResult = InsertHelper::insertRecord($accHisTable, $accHisData);
                    if ($updateBalance) {
                        $activityMessage = 'Withdrawal successfully: ' . $txtWithId;
                        $type = 'Withdrawal';
                        $className = 'bg-success';
                    } else {
                        $activityMessage = 'Withdrawal failed: ' . $txtWithId;
                        $type = 'Withdrawal';
                        $className = 'bg-danger';
                    }

                    $getSavData = DB::table('savings')->where('id', $getsavingId)->first();
                    $gettotalSavAM = $getSavData->totalAmount;
                    $getWithAM = $getWithData->amount;
                    $finalSavAm = $gettotalSavAM - $getWithAM;
                    UpdateHelper::updateRecord('savings', $getsavingId, ['totalAmount' => $finalSavAm]);
                    InsertHelper::insertRecord('savingtransectionhistories',
                    [
                        'savingId' => $getSavData->savingsId,
                        'balance' => $finalSavAm,
                        'randomId' => $getWithData->withdrawalId,
                        'userId' => Auth::user()->id,
                        'memberId' => $getWithData->memberId,
                        'type' => 'Debit',
                        'amount' => $getWithAM,
                        'description' => "Withdrawal successfully"
                    ]
                    );


                } else {
                    return response()->json(['error' => 'Insufficient balance', 'code' => 400]);
                }
            } else {
                $approveStats = 'Rejected';
                $withAc = 'Rejected';
                $activityMessage = 'Withdrawal rejected: ' . $txtWithId;
                $type = 'Withdrawal';
                $className = 'bg-danger';
            }

            $table = 'withdrawals';
            $data = [
                'request' => $txtApproveStatusForth,
                'status' => $approveStats,
                'bankAccount' => $withAc
            ];
            $result = UpdateHelper::updateRecord($table, $getWithId, $data);

            $tableHis = 'withdrawalhistories';
            $datahis = [
                'userId' => Auth::user()->id,
                'amount' => $getAm,
                'request' => $txtApproveStatusForth,
                'status' => $approveStats,
                'memberId' => $getmemberId,
                'savingId' => $getsavingId,
                'withdrawalId' => $txtWithId,
                'reason' => $txtReasonForth,
                'approveUserType' => 0
            ];
            $resultHis = InsertHelper::insertRecord($tableHis, $datahis);

            if ($result === true && $resultHis === true) {
                Session::put('withdrawal', withdrawal::all());
                Session::put('withdrawalHistory', withdrawalhistory::all());
                return response()->json(['success' => 'Withrawal successfully', 'code' => 202, 'redirectUrl' => '/dashboard']);
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


    function createWithdrawal(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txtMember = $request->input('txtMember');
            $txtSavingAccount = $request->input('txtSavingAccount');
            $txtAmount = $request->input('txtAmount');
            $txtApproveUser = $request->input('txtApproveUser');
            $txtReason = $request->input('txtReason');



            $getSaveData = DB::table('savings')->where('id', $txtSavingAccount)->first();
            $gettotalAmountt = $getSaveData->totalAmount;

            if ($gettotalAmountt < $txtAmount) {
                return response()->json(['error' => 'Insufficient balance', 'code' => 403]);
            }

            //get location information
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information

            $ipAddress = $request->ip();
            $activityMessage = 'Created new withdrawal: ' . $txtMember;
            $type = 'Insert';
            $className = 'bg-primary';

            $uniqueId = mt_rand(100000000000, 999999999999);

            $table = 'withdrawals';
            $data = [
                'userId' => Auth::user()->id,
                'amount' => $txtAmount,
                'request' => 0,
                'status' => 'Requested',
                'memberId' => $txtMember,
                'savingId' => $txtSavingAccount,
                'withdrawalId' => $uniqueId,
                'bankAccount' => '0',
                'approveUserType' => $txtApproveUser
            ];
            $result = InsertHelper::insertRecord($table, $data);

            $tableHis = 'withdrawalhistories';
            $datahis = [
                'userId' => Auth::user()->id,
                'amount' => $txtAmount,
                'request' => 0,
                'status' => 'Requested',
                'memberId' => $txtMember,
                'savingId' => $txtSavingAccount,
                'withdrawalId' => $uniqueId,
                'reason' => $txtReason,
                'approveUserType' => $txtApproveUser
            ];
            $resultHis = InsertHelper::insertRecord($tableHis, $datahis);

            if ($result === true && $resultHis === true) {
                Session::put('withdrawal', withdrawal::all());
                Session::put('withdrawalHistory', withdrawalhistory::all());
                return response()->json(['success' => 'Withrawal requested successfully', 'code' => 200]);
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
}
