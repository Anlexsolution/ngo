<?php

namespace App\Http\Controllers\pages;

use App\Helpers\activityLogHelper;
use App\Helpers\GeolocationHelper;
use App\Helpers\InsertHelper;
use App\Helpers\UpdateHelper;
use App\Http\Controllers\Controller;
use App\Models\account;
use App\Models\accounttransectionhistory;
use App\Models\accounttransferhistory;
use App\Models\collectiondeposit;
use App\Models\collectiondepositapprove;
use App\Models\loan;
use App\Models\loanpurpose;
use App\Models\loanpurposesub;
use App\Models\member;
use App\Models\userRole;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class collection_controller extends Controller
{

        function createCollectionTransferData(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txtBank = $request->input('txtBank');
            $txtCollectionTransferId = $request->input('txtCollectionTransferId');
            $getCollectionApproveData = collectiondepositapprove::where('id', $txtCollectionTransferId)->first();
            $depositBy = $getCollectionApproveData->depositBy;
            $amount = $getCollectionApproveData->amount;
            $slipNo = $getCollectionApproveData->slipNo;
            $balance = $getCollectionApproveData->balance;

            //get location information
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information

            $ipAddress = $request->ip();
            $activityMessage = 'deposit transfer: ' . Auth::user()->name;
            $type = 'Insert';
            $className = 'bg-primary';

            $table = 'collectiondeposits';
            $data = [
                'depositBy' => $depositBy,
                'amount' => $amount,
                'slipNo' => $slipNo,
                'balance' => $balance
            ];

            $updateTable = 'collectiondepositapproves';
            $updateData = [
                'status' => 'Approved',
                'approveBy' => Auth::user()->id,
                'approveDate' => Carbon::now(),
                'bank' => $txtBank
            ];

            $result = InsertHelper::insertRecord($table, $data);
            $resultUpdate = UpdateHelper::updateRecord($updateTable, $txtCollectionTransferId, $updateData);

            $getBankData = account::where('id', $txtBank)->first();
            $getbalance = $getBankData->balance;

            $totalAm = $getbalance + $amount;
            $updateBankData = [
                'balance' => $totalAm
            ];
            $updateBankResult = UpdateHelper::updateRecord('accounts', $txtBank, $updateBankData);

            $transHisTable = 'accounttransferhistories';
            $transHisData = [
                'userId' => Auth::user()->id,
                'fromAccountId' => 0,
                'toAccountId' => $txtBank,
                'transferAmount' => $amount,
                'remarks' => 'Collection Transfer',
                'fromAccountBalance' => 0,
                'toAccountBalance' => $totalAm,
                'date' => Carbon::now(),
            ];

            $transHisResult = InsertHelper::insertRecord($transHisTable, $transHisData);
            if ($result === true && $resultUpdate === true && $updateBankResult === true && $transHisResult === true) {
                return response()->json(['success' => 'Create Deposit Approved successfully', 'code' => 200]);
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

    function depositCollection(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txttotalDepositPending = $request->input('txttotalDepositPending');
            $txtDepositAmount = $request->input('txtDepositAmount');
            $txtSlipNo = $request->input('txtSlipNo');

            $balance = $txttotalDepositPending - $txtDepositAmount;

            //get location information
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information

            $ipAddress = $request->ip();
            $activityMessage = 'Created new deposit: ' . Auth::user()->name;
            $type = 'Insert';
            $className = 'bg-primary';

            $table = 'collectiondepositapproves';
            $data = [
                'depositBy' => Auth::user()->id,
                'amount' => $txtDepositAmount,
                'slipNo' => $txtSlipNo,
                'balance' => $balance,
                'status' => 'Pending'
            ];
            $result = InsertHelper::insertRecord($table, $data);
            if ($result === true) {
                return response()->json(['success' => 'Create Deposit successfully waiting for approve', 'code' => 200]);
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

    function collectionDeposit()
{
    $getPurpose = loanpurpose::all();
    $getUserRole = userRole::all();
    $getLoansData = loan::all();
    $getLoanPurposeSubCat = loanpurposesub::all();
    $getAllMemberData = member::all();

    // Exclude 'Saving from Loan Overpayment' from total collection
    $totalCollection = DB::table('accounttransectionhistories')
        ->where('collectionBy', Auth::user()->id)
        ->where('description', '!=', 'Saving from Loan Overpayment')
        ->sum('amount');

    $totalDeposit = DB::table('collectiondeposits')
        ->where('depositBy', Auth::user()->id)
        ->sum('amount');

    $balanceDeposit = $totalCollection - $totalDeposit;

    $totalTodayCollection = DB::table('accounttransectionhistories')
        ->where('collectionBy', Auth::user()->id)
        ->whereDate('created_at', Carbon::today())
        ->where('description', '!=', 'Saving from Loan Overpayment')
        ->sum('amount');

    $getAllCollectionData = DB::table('collectiondeposits')
        ->where('collectiondeposits.depositBy', Auth::user()->id)
        ->join('users', 'collectiondeposits.depositBy', '=', 'users.id')
        ->select(
            'collectiondeposits.id',
            'collectiondeposits.amount',
            'collectiondeposits.slipNo',
            'collectiondeposits.balance',
            DB::raw('DATE(collectiondeposits.created_at) as created_date'),
            'users.name as depositBy'
        )
        ->get();

    return view('pages.permission.collection.collection_deposit_per', [
        'getAllCollectionData' => $getAllCollectionData,
        'totalTodayCollection' => $totalTodayCollection,
        'balanceDeposit' => $balanceDeposit,
        'getAllMemberData' => $getAllMemberData,
        'getLoanPurposeSubCat' => $getLoanPurposeSubCat,
        'getUserRole' => $getUserRole,
        'getPurpose' => $getPurpose,
        'getLoansData' => $getLoansData
    ]);
}

    function collectionvsdeposit()
    {
        $getPurpose = loanpurpose::all();
        $getUserRole = userRole::all();
        $getLoansData = loan::all();
        $getLoanPurposeSubCat = loanpurposesub::all();
        $getAllMemberData = member::all();
        $accountTransectionHis = accounttransectionhistory::all();
        $collectionData = collectiondeposit::all();
        $getUser = User::all();
        return view('pages.permission.collection.collection_vs_deposit_reports_per', ['getUser' => $getUser, 'collectionData' => $collectionData, 'accountTransectionHis' => $accountTransectionHis, 'getAllMemberData' => $getAllMemberData, 'getLoanPurposeSubCat' => $getLoanPurposeSubCat, 'getUserRole' => $getUserRole, 'getPurpose' => $getPurpose, 'getLoansData' => $getLoansData]);
    }

    function collectionTransfer()
    {
        $getPurpose = loanpurpose::all();
        $getUserRole = userRole::all();
        $getLoansData = loan::all();
        $getLoanPurposeSubCat = loanpurposesub::all();
        $getAllMemberData = member::all();
        $accountTransectionHis = accounttransectionhistory::all();
        $collectionData = collectiondeposit::all();
        $getUser = User::all();
        $getCollectionTransferData = DB::table('collectiondepositapproves')
            ->get();
        $getAccountData = account::all();
        return view('pages.permission.account.collection_transfer_per', [ 'getAccountData' => $getAccountData, 'getCollectionTransferData' => $getCollectionTransferData,  'getUser' => $getUser, 'collectionData' => $collectionData, 'accountTransectionHis' => $accountTransectionHis, 'getAllMemberData' => $getAllMemberData, 'getLoanPurposeSubCat' => $getLoanPurposeSubCat, 'getUserRole' => $getUserRole, 'getPurpose' => $getPurpose, 'getLoansData' => $getLoansData]);
    }
}
