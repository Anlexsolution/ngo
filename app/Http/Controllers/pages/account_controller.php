<?php

namespace App\Http\Controllers\pages;

use App\Helpers\activityLogHelper;
use App\Helpers\GeolocationHelper;
use App\Helpers\InsertHelper;
use App\Helpers\UpdateHelper;
use App\Http\Controllers\Controller;
use App\Models\account;
use App\Models\accounttransferhistory;
use App\Models\division;
use App\Models\loan;
use App\Models\member;
use App\Models\smallgroup;
use App\Models\userRole;
use App\Models\village;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class account_controller extends Controller
{

    function transferAccountToAccount(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txtMemberUniqueId = $request->input('txtMemberUniqueId');
            $txtSelectAcccount = $request->input('txtSelectAcccount');
            $txtAmount = $request->input('txtAmount');
            $txtRemarks = $request->input('txtRemarks');

            $getSavData = DB::table('savings')->where('memberId', $txtMemberUniqueId)->first();
            $getSavBalance = $getSavData->totalAmount;
            $getSavId = $getSavData->id;
            $getsavingsId = $getSavData->savingsId;

            if ($getSavBalance < $txtAmount) {
                return response()->json(['error' => 'Insufficient balance', 'code' => 400]);
            }

            $getSavBalance = $getSavBalance - $txtAmount;
            $savData = [
                'totalAmount' => $getSavBalance,
            ];

            if ($txtRemarks == "") {
                $txtRemarks = "Transfer Savings to anohter account";
            } else {
                $txtRemarks = $txtRemarks;
            }

            $resultUpdate = UpdateHelper::updateRecord('savings', $getSavId, $savData);

            $randomId = str_pad(mt_rand(0, 999999999999), 12, '0', STR_PAD_LEFT);
            $savTransHis = [
                'savingId' => $getsavingsId,
                'balance' => $getSavBalance,
                'userId' => Auth::user()->id,
                'memberId' => $txtMemberUniqueId,
                'type' => 'Debit',
                'amount' => $txtAmount,
                'description' => $txtRemarks,
                'randomId' => $randomId,
            ];
            $resultInsert = InsertHelper::insertRecord('savingtransectionhistories', $savTransHis);

            if ($txtRemarks == '') {
                $deathDes = "Savings transfer to death subscription";
            } else {
                $deathDes = $txtRemarks;
            }

            if ($txtSelectAcccount == 'Death') {
                $randomIdDeath = str_pad(mt_rand(0, 999999999999), 12, '0', STR_PAD_LEFT);
                $getDeathData = DB::table('deathsubscriptions')->where('memberId', $txtMemberUniqueId)->first();
                $getDeathCount = DB::table('deathsubscriptions')->where('memberId', $txtMemberUniqueId)->count();
                if ($getDeathCount > 0) {
                    $getDeathId = $getDeathData->id;
                    $deathData = [
                        'amount' => $txtAmount,
                        'totalAmount' => $getDeathData->totalAmount + $txtAmount,
                    ];
                    $resultUpdate = UpdateHelper::updateRecord('deathsubscriptions', $getDeathId, $deathData);
                    $deathHisData = [
                        'deathId' => $getDeathData->deathId,
                        'memberId' => $txtMemberUniqueId,
                        'type' => 'Credit',
                        'balance' => $getDeathData->totalAmount + $txtAmount,
                        'randomId' => $randomIdDeath,
                        'userId' => Auth::user()->id,
                        'amount' => $txtAmount,
                        'description' => $deathDes,
                    ];
                    $resultInsert = InsertHelper::insertRecord('deathtransectionhistories', $deathHisData);
                }
            } else if ($txtSelectAcccount == "Other Income") {
                if ($txtRemarks == '') {
                    $otherDes = "Savings transfer to other income";
                } else {
                    $otherDes = $txtRemarks;
                }
                $randomIdOtherIncome = str_pad(mt_rand(0, 999999999999), 12, '0', STR_PAD_LEFT);
                $getOtherIncomeData = DB::table('otherincomes')->where('memberId', $txtMemberUniqueId)->first();
                $getOtherIncomeCount = DB::table('otherincomes')->where('memberId', $txtMemberUniqueId)->count();
                if ($getOtherIncomeCount > 0) {
                    $getOtherIncomeId = $getOtherIncomeData->id;
                    $otherIncomeData = [
                        'amount' => $txtAmount,
                        'totalAmount' => $getOtherIncomeData->totalAmount + $txtAmount,
                    ];
                    $resultUpdate = UpdateHelper::updateRecord('otherincomes', $getOtherIncomeId, $otherIncomeData);
                    $otherIncomeHisData = [
                        'otherIncomeId' => $getOtherIncomeData->otherIncomeId,
                        'memberId' => $txtMemberUniqueId,
                        'type' => 'Credit',
                        'balance' => $getOtherIncomeData->totalAmount + $txtAmount,
                        'randomId' => $randomIdOtherIncome,
                        'userId' => Auth::user()->id,
                        'amount' => $txtAmount,
                        'description' => $otherDes,
                    ];
                    $resultInsert = InsertHelper::insertRecord('otherincomehistories', $otherIncomeHisData);
                }
            }

            if ($resultUpdate === true && $resultInsert === true && $resultInsert === true && $resultInsert === true && $resultInsert === true) {
                return response()->json(['success' => 'Transfer successfully', 'code' => 200]);
                $activityLogResult = activityLogHelper::activityLog($ipAddress, $location, $country, $activityMessage, $type, $className);
            } else {
                return response()->json(['error' => 'Failed to insert account transfer history', 'code' => 500]);
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


    function transferAccount(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txtFromAccount = $request->input('txtFromAccount');
            $txtToAccount = $request->input('txtToAccount');
            $txtTransferAmount = $request->input('txtTransferAmount');
            $txtRemarks = $request->input('txtRemarks');

            $getFromAccount = account::where('id', $txtFromAccount)->first();
            $getToAccount = account::where('id', $txtToAccount)->first();
            if ($getFromAccount->balance < $txtTransferAmount) {
                return response()->json(['error' => 'Insufficient balance', 'code' => 400]);
            }

            $getFrombalance = $getFromAccount->balance - $txtTransferAmount;
            $getTobalance = $getToAccount->balance + $txtTransferAmount;

            //get location information
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information

            $ipAddress = $request->ip();
            $activityMessage = 'Transferred ' . $txtTransferAmount . ' from ' . $getFromAccount->name . ' to ' . $getToAccount->name;
            $type = 'Transfer';
            $className = 'bg-success';

            $table = 'accounts';
            $dataFrom = [
                'balance' => $getFrombalance
            ];
            $datato = [
                'balance' => $getTobalance
            ];
            $result = UpdateHelper::updateRecord($table, $txtFromAccount, $dataFrom);
            $resultTo = UpdateHelper::updateRecord($table, $txtToAccount, $datato);
            if ($result === true && $resultTo === true) {
                $tableAccHis = 'accounttransferhistories';
                $dataAccHis = [
                    'userId' => Auth::user()->id,
                    'fromAccountId' => $txtFromAccount,
                    'toAccountId' => $txtToAccount,
                    'transferAmount' => $txtTransferAmount,
                    'remarks' => $txtRemarks,
                    'fromAccountBalance' => $getFrombalance,
                    'toAccountBalance' => $getTobalance
                ];
                $resultAccHis = InsertHelper::insertRecord($tableAccHis, $dataAccHis);
                if ($resultAccHis === true) {
                    return response()->json(['success' => 'Transfer successfully', 'code' => 200]);
                    $activityLogResult = activityLogHelper::activityLog($ipAddress, $location, $country, $activityMessage, $type, $className);
                } else {
                    return response()->json(['error' => 'Failed to insert account transfer history', 'code' => 500]);
                }
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

    function viewAccountDetails($id)
    {
        $decId = Crypt::decrypt($id);
        $getUserRole = userRole::all();
        $getSmallGroup = smallgroup::all();
        $getVillage = village::all();
        $getDivision = division::all();
        $getMember = member::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $getUser = User::all();
        $getAccData = DB::table('accounts')->where('id', $decId)->first();
        $getAccType = $getAccData->accountType;
        $getAcctransferHis = DB::table('accounttransferhistories')->where('fromAccountId', $decId)->orWhere('toAccountId', $decId)->get();
        $getAccountDetails = DB::table('accounttransectionhistories')->where('accountId', $decId)->get();
        $getAccount = account::all();
        return view('pages.permission.account.view_account_details_per', [ 'getAccount' => $getAccount, 'decId' => $decId, 'getAcctransferHis' => $getAcctransferHis, 'getAccType' => $getAccType, 'getUser' => $getUser, 'getAccountDetails' => $getAccountDetails, 'getUserRole' => $getUserRole, 'getSmallGroup' => $getSmallGroup, 'getVillage' => $getVillage, 'getDivision' => $getDivision, 'getMember' => $getMember, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    public function manageAccount()
    {
        $getUserRole = userRole::all();
        $getSmallGroup = smallgroup::all();
        $getVillage = village::all();
        $getDivision = division::all();
        $getMember = member::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $getAccountData = account::all();
        return view('pages.permission.account.manage_account_per', ['getAccountData' => $getAccountData, 'getUserRole' => $getUserRole, 'getSmallGroup' => $getSmallGroup, 'getVillage' => $getVillage, 'getDivision' => $getDivision, 'getMember' => $getMember, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    public function createAccount()
    {
        $getUserRole = userRole::all();
        $getSmallGroup = smallgroup::all();
        $getVillage = village::all();
        $getDivision = division::all();
        $getMember = member::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.permission.account.create_account_per', ['getUserRole' => $getUserRole, 'getSmallGroup' => $getSmallGroup, 'getVillage' => $getVillage, 'getDivision' => $getDivision, 'getMember' => $getMember, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    function addAccount(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txtAccountName = $request->input('txtAccountName');
            $txtBranchName = $request->input('txtBranchName');
            $txtAccountNumber = $request->input('txtAccountNumber');
            $txtRegisterDate = $request->input('txtRegisterDate');
            $txtStatus = $request->input('txtStatus');
            $txtNote = $request->input('txtNote');
            $txtOpeningBalance = $request->input('txtOpeningBalance');
            $txtAccountType = $request->input('txtAccountType');

            //get location information
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information

            $ipAddress = $request->ip();
            $activityMessage = 'Created new account: ' . $txtAccountName;
            $type = 'Insert';
            $className = 'bg-primary';

            $table = 'accounts';
            $data = [
                'name' => $txtAccountName,
                'branch' => $txtBranchName,
                'accountNumber' => $txtAccountNumber,
                'registerDate' => $txtRegisterDate,
                'status' => $txtStatus,
                'note' => $txtNote,
                'balance' => $txtOpeningBalance,
                'accountType' => $txtAccountType
            ];


            $result = InsertHelper::insertRecord($table, $data);
            if ($result === true) {
                $getaccData = DB::table('accounts')->where('accountNumber', $txtAccountNumber)->first();
                $getaccId = $getaccData->id;
                $tableHis = 'accounttransferhistories';
                $dataHIs = [
                    'userId' => Auth::user()->id,
                    'fromAccountId' => 0,
                    'toAccountId' => $getaccId,
                    'transferAmount' => $txtOpeningBalance,
                    'remarks' => 'Opening Balance',
                    'fromAccountBalance' => 0,
                    'toAccountBalance' => $txtOpeningBalance
                ];
                $resultHis = InsertHelper::insertRecord($tableHis, $dataHIs);
                if ($resultHis === true) {
                    return response()->json(['success' => 'Create Account successfully', 'code' => 200]);
                    $activityLogResult = activityLogHelper::activityLog($ipAddress, $location, $country, $activityMessage, $type, $className);
                } else {
                    return response()->json(['error' => $resultHis['error'], 'code' => 500]);
                }
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


    function addExpensiveIncome(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txtSelectAccount = $request->input('txtSelectAccount');
            $txtType = $request->input('txtType');
            $txtDate = $request->input('txtDate');
            $txtAmount = $request->input('txtAmount');
            $txtExpensiveRemarks = $request->input('txtExpensiveRemarks');

            $getAccData = DB::table('accounts')->where('id', $txtSelectAccount)->first();
            $getAccName = $getAccData->name;

            //get location information
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information

            $ipAddress = $request->ip();
            $activityMessage = 'Created Expensive / Income: ' . $getAccName;
            $type = 'Insert';
            $className = 'bg-primary';

            if ($txtType == 'Expensive') {
                $AccountBalance = $getAccData->balance - $txtAmount;
                $tableTran = 'accounttransferhistories';
                $dataTrans = [

                    'userId' => Auth::user()->id,
                    'fromAccountId' => $txtSelectAccount,
                    'toAccountId' => 0,
                    'transferAmount' => $txtAmount,
                    'remarks' => $txtExpensiveRemarks . $txtType,
                    'fromAccountBalance' => $AccountBalance,
                    'toAccountBalance' => 0,
                    'date' => $txtDate
                ];
            } else {
                $AccountBalance = $getAccData->balance + $txtAmount;
                $tableTran = 'accounttransferhistories';
                $dataTrans = [
                    'userId' => Auth::user()->id,
                    'fromAccountId' => 0,
                    'toAccountId' => $txtSelectAccount,
                    'transferAmount' => $txtAmount,
                    'remarks' => $txtExpensiveRemarks . $txtType,
                    'fromAccountBalance' => 0,
                    'toAccountBalance' => $AccountBalance,
                    'date' => $txtDate
                ];
            }

            $table = 'accounts';
            $data = [
                'balance' => $AccountBalance
            ];



            $result = UpdateHelper::updateRecord($table, $txtSelectAccount, $data);
            $resultAcc = InsertHelper::insertRecord($tableTran, $dataTrans);
            if ($result === true && $resultAcc === true) {
                return response()->json(['success' => 'Created expensive / income successfully', 'code' => 200]);
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
