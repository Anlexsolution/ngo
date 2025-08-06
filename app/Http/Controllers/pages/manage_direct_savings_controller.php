<?php

namespace App\Http\Controllers\pages;

use App\Helpers\activityLogHelper;
use App\Helpers\GeolocationHelper;
use App\Helpers\InsertHelper;
use App\Helpers\UpdateHelper;
use App\Http\Controllers\Controller;
use App\Models\loan;
use App\Models\member;
use App\Models\saving;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class manage_direct_savings_controller extends Controller
{

    function directSavings()
    {
        $getMember = member::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.permission.directsavings.direct_savings_per', ['getMember' => $getMember, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    function memberDetails(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }
            $txtSelectMember = $request->input('txtSelectMember');
            if ($txtSelectMember == '') {
                return response()->json([
                    'member' => [],
                    'saving' => '',
                    'code' => 200,
                ]);
            } else {
                $getMember = member::where('id', $txtSelectMember)->first();
                $memberUniqueId = $getMember->uniqueId;
                $getSaving = saving::where('memberId', $memberUniqueId)->first();
                $getSavingAmount = $getSaving->totalAmount;
                return response()->json([
                    'member' => $getMember,
                    'saving' => $getSavingAmount,
                    'code' => 200,
                ]);
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

    function insertDirectSavings(Request $request)
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
            $txtAmount = $request->input('txtAmount');

            $getMember = member::where('id', $txtSelectMember)->first();
            $memberUniqueId = $getMember->uniqueId;
            $getSaving = saving::where('memberId', $memberUniqueId)->first();
            $getSavingAmount = $getSaving->totalAmount;
            $getSavId = $getSaving->id;
            $newTotalAmount = $getSavingAmount + $txtAmount;

            $ipAddress = $request->ip();
            $activityMessage = 'Update Saving Total Amount For member : ' . $getMember->firstName;
            $type = 'Update';
            $className = 'bg-success';

            $tableName = 'savings';
            $id = $getSavId;
            $data = [
                'totalAmount' => $newTotalAmount
            ];



            $getTotal = saving::find($getSavId)->first();
            $totalAmount = $getTotal->totalAmount;

            $tableNameHistory = 'savingtransectionhistories';
            $userId = Auth::user()->id;
            $transDeathIdRandom = str_pad(rand(1, 999999999), 12, '0', STR_PAD_LEFT);
            $dataHistory = [
                'memberId' => $memberUniqueId,
                'savingId' => $getSaving->savingsId,
                'userId' => $userId,
                'balance' => $newTotalAmount,
                'randomId' => $transDeathIdRandom,
                'type' => 'Credit',
                'amount' => $txtAmount,
                'description' => 'Direct Saving Amount',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $getAccountCount = DB::table('accountsettings')->count();

            if ($getAccountCount == 0) {
                return response()->json(['error' => 'Please select the default collection account in settings', 'code' => 500]);
            } else {
                // Use the UpdateHelper
                $result = UpdateHelper::updateRecord($tableName, $id, $data);

                $insertData = InsertHelper::insertRecord($tableNameHistory, $dataHistory);

                // Check the result
                if ($result === true && $insertData === true) {
                    $getAccount = DB::table('accountsettings')->first();
                    $accountId = $getAccount->accountId;
                    $getAccData = DB::table('accounts')->where('id', $accountId)->first();
                    $getBal = $getAccData->balance;
                    if($getBal == ''){
                        $getBal = 0;
                    }else{
                        $getBal = $getBal;
                    }
                    $totalBal = $getBal + $txtAmount;
                    $upBal = [
                        'balance' => $totalBal
                    ];
                    UpdateHelper::updateRecord('accounts', $accountId, $upBal);

                    //Add history
                    $historyTable = 'accounttransectionhistories';
                    $hisData  = [
                        'collectionBy' => $userId,
                        'memberId' => $txtSelectMember,
                        'amount' => $txtAmount,
                        'description' => 'Direct Savings',
                        'accountId' => $accountId,
                        'status' => 'Credit'
                    ];
                    InsertHelper::insertRecord($historyTable, $hisData);
                    //Add history

                    $activityLogResult = activityLogHelper::activityLog($ipAddress, $location, $country, $activityMessage, $type, $className);
                    return response()->json(['success' => 'Member Savings Amount Insert successfully', 'transectionId' => $transDeathIdRandom, 'code' => 201]);
                } else {
                    return response()->json(['error' => $result['error'], 'code' => 500]);
                }
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
