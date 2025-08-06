<?php

namespace App\Http\Controllers\pages;

use App\Helpers\activityLogHelper;
use App\Helpers\GeolocationHelper;
use App\Helpers\InsertHelper;
use App\Helpers\UpdateHelper;
use App\Http\Controllers\Controller;
use App\Imports\repaymentImport;
use App\Models\loan;
use App\Models\loanapprovalsetting;
use App\Models\loanproduct;
use App\Models\loanpurpose;
use App\Models\loanrequest;
use App\Models\member;
use Illuminate\Support\Str;
use App\Models\userRole;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class loan_product_controller extends Controller
{

    function loanDocumentData(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txtMainCategory = $request->input('txtMainCategory');
            $txtSubCategory = $request->input('txtSubCategory');

            $getLoanDocData = DB::table('loandocuments')->where('mainCategory', $txtMainCategory)->where('subCategory', $txtSubCategory)->get();

            return response()->json(['success' => 'Create Loan Document successfully', 'code' => 200, 'getLoanDocData' => $getLoanDocData]);
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

    function importRepaymentData(Request $request)
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

            Excel::import(new repaymentImport, storage_path('app/imports/' . $filename));
            return response()->json(['success' => 'import Repayment successfully', 'code' => 200]);

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



   public function payRepaymentData(Request $request)
{
    try {
        if ($request->_token !== csrf_token()) {
            return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
        }

        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);
        $location = $geoData['location'];
        $country = $geoData['country'];

        $loanData = json_decode($request->input('loanData'), true);
        $txtMember = $request->input('txtMember');
        $txtSavingAmount = round((float)($request->input('txtSavingAmount') ?? 0), 2);
        $txtPaymentDate = $request->input('txtPaymentDate');
        $userId = Auth::id();

        $getMemData = DB::table('members')->where('id', $txtMember)->first();
        $getUniqueId = $getMemData->uniqueId;

        $getSavData = DB::table('savings')->where('memberId', $getUniqueId)->first();
        $getSavBalance = $getSavData->totalAmount;
        $getSavId = $getSavData->id;
        $getSavIdUnique = $getSavData->savingsId;

        $accountSetting = DB::table('accountsettings')->first();
        if (!$accountSetting) {
            return response()->json(['error' => 'Please select the default collection account in settings', 'code' => 500]);
        }
        $accountId = $accountSetting->accountId;
        $account = DB::table('accounts')->where('id', $accountId)->first();

        // Saving Only
        if (empty($loanData)) {
            if ($txtSavingAmount > 0) {
                $totalSavingAmount = $txtSavingAmount + $getSavBalance;

                UpdateHelper::updateRecord('savings', $getSavId, ['totalAmount' => $totalSavingAmount]);

                InsertHelper::insertRecord('savingtransectionhistories', [
                    'memberId' => $getUniqueId,
                    'savingId' => $getSavIdUnique,
                    'userId' => $userId,
                    'balance' => $totalSavingAmount,
                    'randomId' => str_pad(rand(1, 999999999), 12, '0', STR_PAD_LEFT),
                    'type' => 'Credit',
                    'amount' => $txtSavingAmount,
                    'description' => 'Saving Only Collection'
                ]);

                InsertHelper::insertRecord('accounttransectionhistories', [
                    'collectionBy' => $userId,
                    'memberId' => $txtMember,
                    'amount' => $txtSavingAmount,
                    'accountId' => $accountId,
                    'description' => 'Saving Only Collection',
                    'status' => 'Credit',
                    'repaymentDate' => $txtPaymentDate,
                ]);

                // Update accounts balance
                UpdateHelper::updateRecord('accounts', $accountId, [
                    'balance' => $account->balance + $txtSavingAmount
                ]);
            }

            return response()->json(['success' => 'Saving Amount collected successfully', 'code' => 200]);
        }

        // Loan Repayment
        foreach ($loanData as $loan) {
            $loanId = $loan['loanId'];
            $currentInterest = round((float)$loan['interest'], 2);
            $principal = round((float)$loan['principal'], 2);
            $balance = round((float)$loan['balance'], 2);
            $payAmount = round((float)$loan['payAmount'], 2);
            $txtLoan = $request->input('txtLoan');
            $txtDays = $loan['days'];

            // Fetch previous interest arrears
            $prevArrears = DB::table('interest_arrears')
                ->where('memberId', $txtMember)
                ->where('loanId', $loanId)
                ->first();

            $prevArrearInterest = $prevArrears ? (float)$prevArrears->arrearInterest : 0;
            $interest = $currentInterest + $prevArrearInterest;

            $totalDue = $interest + $principal + $balance;
            $actualRepay = min($payAmount, $totalDue);
            $extraPaymentToSaving = max(0, $payAmount - $totalDue);

            // Calculate actual interest and principal paid
            $interestPaid = min($interest, $actualRepay);
            $principalDue = $principal + $balance;
            $actualPrincipalPaid = max(0, min($actualRepay - $interestPaid, $principalDue));
            $getFinalBalance = $principalDue - $actualPrincipalPaid;

            // Saving from extra payment + user-input
            $extraTotalSaving = $txtSavingAmount + $extraPaymentToSaving;
            $totalSavingAmount = $getSavBalance + $extraTotalSaving;

            if ($extraTotalSaving > 0) {
                UpdateHelper::updateRecord('savings', $getSavId, ['totalAmount' => $totalSavingAmount]);

                InsertHelper::insertRecord('savingtransectionhistories', [
                    'memberId' => $getUniqueId,
                    'savingId' => $getSavIdUnique,
                    'userId' => $userId,
                    'balance' => $totalSavingAmount,
                    'randomId' => str_pad(rand(1, 999999999), 12, '0', STR_PAD_LEFT),
                    'type' => 'Credit',
                    'amount' => $extraTotalSaving,
                    'description' => 'Saving from Loan Overpayment'
                ]);

                InsertHelper::insertRecord('accounttransectionhistories', [
                    'collectionBy' => $userId,
                    'memberId' => $txtMember,
                    'amount' => $extraTotalSaving,
                    'accountId' => $accountId,
                    'description' => 'Saving from Loan Overpayment',
                    'status' => 'Credit',
                    'repaymentDate' => $txtPaymentDate,
                ]);

                // Do NOT update account balance for extra saving
            }

            // Update interest arrears table
            $remainingInterest = max(0, $interest - $interestPaid);
            if ($remainingInterest > 0) {
                if ($prevArrears) {
                    DB::table('interest_arrears')
                        ->where('id', $prevArrears->id)
                        ->update([
                            'arrearInterest' => $remainingInterest,
                            'status' => 'Pending',
                            'updated_at' => now()
                        ]);
                } else {
                    DB::table('interest_arrears')->insert([
                        'memberId' => $txtMember,
                        'loanId' => $loanId,
                        'arrearInterest' => $remainingInterest,
                        'status' => 'Pending',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            } elseif ($prevArrears) {
                // Fully paid, mark as Cleared
                DB::table('interest_arrears')
                    ->where('id', $prevArrears->id)
                    ->update([
                        'arrearInterest' => 0,
                        'status' => 'Cleared',
                        'updated_at' => now()
                    ]);
            }

            // Record repayment
            $transectionId = str_pad(rand(100000000000, 999999999999), 12, '0', STR_PAD_LEFT);
            $repaymentData = [
                'loanId' => $txtLoan,
                'repaymentDate' => $txtPaymentDate,
                'repaymentAmount' => $payAmount,
                'lastLoanBalance' => $getFinalBalance,
                'interest' => $interestPaid,
                'principalAmount' => $actualPrincipalPaid,
                'memberId' => $txtMember,
                'transectionId' => $transectionId,
                'userId' => $userId,
                'days' => $txtDays,
                'savingAmount' => $extraTotalSaving,
            ];

            $insertResult = InsertHelper::insertRecord('loanrepayments', $repaymentData);

            if ($insertResult === true) {
                InsertHelper::insertRecord('accounttransectionhistories', [
                    'collectionBy' => $userId,
                    'memberId' => $txtMember,
                    'amount' => $payAmount,
                    'accountId' => $accountId,
                    'description' => 'Loan Repayment',
                    'status' => 'Credit',
                    'interest' => $interestPaid,
                    'principalAmount' => $actualPrincipalPaid,
                    'repaymentDate' => $txtPaymentDate
                ]);

                // Update account balance for loan repayment only
                UpdateHelper::updateRecord('accounts', $accountId, [
                    'balance' => $account->balance + $payAmount
                ]);

                // Update loan schedules
                $loanSchedules = DB::table('loanschedules')->where('loanId', $txtLoan)->get();
                foreach ($loanSchedules as $sch) {
                    if ($sch->balance > $getFinalBalance) {
                        UpdateHelper::updateRecord('loanschedules', $sch->id, ['status' => 'paid']);
                    }
                }

                if ((float)$getFinalBalance == 0) {
                    DB::table('loans')->where('id', $txtLoan)->update(['loanStatus' => 'Completed']);
                    foreach ($loanSchedules as $sch) {
                        UpdateHelper::updateRecord('loanschedules', $sch->id, ['status' => 'paid']);
                    }
                }

                return response()->json(['success' => 'Repayment successfully', 'code' => 204, 'transId' => $transectionId]);
            } else {
                return response()->json(['error' => $insertResult['error'], 'code' => 500]);
            }
        }

    } catch (\Illuminate\Database\QueryException $e) {
        return response()->json(['error' => 'Database error: ' . $e->getMessage(), 'code' => 500]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An unexpected error occurred: ' . $e->getMessage(), 'code' => 500]);
    }
}




    function createLoanGuarantors(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $selectCurrentes = $request->input('selectCurrentes');
            $txtLoanId = $request->input('txtLoanId');
            $txtLoanIdEnc = Crypt::encrypt($txtLoanId);
            $table = 'loans';
            $data = [
                'gurrantos' => $selectCurrentes
            ];

            $save = UpdateHelper::updateRecord($table, $txtLoanId, $data);
            if ($save === true) {
                return response()->json(['success' => 'Update Purpose successfully', 'code' => 200, 'txtLoanIdEnc' => $txtLoanIdEnc]);
            } else {
                return response()->json(['error' => $save['error'], 'code' => 500]);
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


    function getLoanProductData(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $productId = $request->input('txtSelectLoanProduct');

            $getProductData = loanproduct::find($productId);
            return response()->json(['success' => 'Create Purpose successfully', 'code' => 200, 'data' => $getProductData]);
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


    function createLoanFirst(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $modalPurposeName = $request->input('modalPurposeName');

            //get location information
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information

            $ipAddress = $request->ip();
            $activityMessage = 'Created new purpose: ' . $modalPurposeName;
            $type = 'Insert';
            $className = 'bg-primary';

            $txtLoanId = $request->input('txtLoanId');
            $txtSelectMember = $request->input('txtSelectMember');
            $txtSelectLoanProduct = $request->input('txtSelectLoanProduct');
            $txtPricipal = $request->input('txtPricipal');
            $txtLoanTerm = $request->input('txtLoanTerm');
            $txtInterestRate = $request->input('txtInterestRate');
            $txtRepaymentFrequency = $request->input('txtRepaymentFrequency');
            $txtRepaymentPreriod = $request->input('txtRepaymentPreriod');
            $txtPer = $request->input('txtPer');
            $txtInterestType = $request->input('txtInterestType');
            $txtLoanOfficer = $request->input('txtLoanOfficer');
            $txtLoanPurpose = $request->input('txtLoanPurpose');
            $txtLoanPurposeSub = $request->input('txtLoanPurposeSub');
            $txtExpectedFirstRepaymentDate = $request->input('txtExpectedFirstRepaymentDate');
            $approval = $request->input('approval');
            $getLoanDoc = $request->input('loanDocArray');
            $loanReqId = $request->input('loanReqId');

            $table = 'loans';
            $data = [
                'loanId' => $txtLoanId,
                'memberId' => $txtSelectMember,
                'loanProductId' => $txtSelectLoanProduct,
                'principal' => $txtPricipal,
                'loanterm' => $txtLoanTerm,
                'repaymentFrequency' => $txtRepaymentFrequency,
                'interestRate' => $txtInterestRate,
                'repaymentPeriod' => $txtRepaymentPreriod,
                'per' => $txtPer,
                'interestType' => $txtInterestType,
                'loanOfficer' => $txtLoanOfficer,
                'loanPurpose' => $txtLoanPurpose,
                'firstRepaymentDate' => $txtExpectedFirstRepaymentDate,
                'createStatus' => 0,
                'approval' => $approval,
                'loanStatus' => 'Processing',
                'approvalStatus' => 0,
                'loanPurposeSub' => $txtLoanPurposeSub,
                'documents' => $getLoanDoc,
                'loanReqId' => $loanReqId
            ];



            $getMemberData = DB::table('members')->where('id', $txtSelectMember)->first();
            $getSmallGroupId = $getMemberData->smallGroupId;

            $getGur = DB::table('members')->where('smallGroupId', $getSmallGroupId)->get();

            $selectGurantos = "<select class='' id='selectCurrentes'>";
            foreach ($getGur as $gur) {
                if ($gur->id != $txtSelectMember) {
                    $selectGurantos .= '<option value="' . $gur->id . '">' . $gur->firstName . '</option>';
                }
            }
            $selectGurantos .= '</select>';

            $getLoanReqData = DB::table('loanrequests')->where('memberId', $txtSelectMember)->where('mainCategoryId', $txtLoanPurpose)->where('subCategoryId', $txtLoanPurposeSub)->where('loanAmount', $txtPricipal)->first();
            $getReqId = $getLoanReqData->id;

            $dataReq = [
                'loancreated' => 1,
                'status' => 4
            ];

            $result = InsertHelper::insertRecord($table, $data);
            $resultReq = UpdateHelper::updateRecord('loanrequests', $loanReqId, $dataReq);
            if ($result === true && $resultReq === true) {
                $lastRecord = DB::table('loans')->latest('id')->first();
                $loanApp = [
                    'loanId' => $lastRecord->id,
                    'userId' => Auth::user()->id,
                    'approvalType' => 'Loan Created',
                    'approvalStatus' => 'Created',
                    'reason' => '',
                ];
                InsertHelper::insertRecord('loanapprovals', $loanApp);
                $maxOrderNo = loan::max('id');
                return response()->json(['success' => 'Create Purpose successfully', 'code' => 200, 'selectGurantos' => $selectGurantos, 'loanId' => $maxOrderNo]);
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

    function addPurpose(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $modalPurposeName = $request->input('modalPurposeName');

            //get location information
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information

            $ipAddress = $request->ip();
            $activityMessage = 'Created new purpose: ' . $modalPurposeName;
            $type = 'Insert';
            $className = 'bg-primary';

            $table = 'loanpurposes';
            $data = [
                'name' => $modalPurposeName
            ];
            $result = InsertHelper::insertRecord($table, $data);
            if ($result === true) {
                return response()->json(['success' => 'Create main category successfully', 'code' => 200]);
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


    function manageLoanRequest()
    {
        $getUserRole = userRole::all();
        $getProductData = loanproduct::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::with('division', 'village', 'smallgroup')->get();
        $getAllMainPurpose = loanpurpose::all();
        $getLoanRequetData = DB::table('loanrequests')->latest('created_at')->get();
        return view('pages.permission.loan.manage_loan_request_per', ['getLoanRequetData' => $getLoanRequetData, 'getAllMainPurpose' => $getAllMainPurpose, 'getUserRole' => $getUserRole, 'getProductData' => $getProductData, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    function manageLoanRepayment()
    {
        $getUserRole = userRole::all();
        $getProductData = loanproduct::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.permission.loanrepayment.loan_repayment_per', ['getUserRole' => $getUserRole, 'getProductData' => $getProductData, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    function manageApprovalSettings()
    {
        $getUserRole = userRole::all();
        $getProductData = loanproduct::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $getAllLoanApprovalSetting = loanapprovalsetting::all();
        return view('pages.permission.settings.manage_approval_settings_per', ['getAllLoanApprovalSetting' => $getAllLoanApprovalSetting, 'getUserRole' => $getUserRole, 'getProductData' => $getProductData, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    function manageLoanProduct()
    {
        $getUserRole = userRole::all();
        $getProductData = loanproduct::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.permission.loan.manage_loan_product_per', ['getUserRole' => $getUserRole, 'getProductData' => $getProductData, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }
    function createLoanProduct()
    {
        $getUserRole = userRole::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $getloanMainCatData = loanpurpose::all();
        return view('pages.permission.loan.create_loan_product_per', ['getloanMainCatData' => $getloanMainCatData, 'getUserRole' => $getUserRole, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    function createProduct(Request $request)
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

            $ipAddress = $request->ip();
            $activityMessage = 'Created new product: ' . $request->input('txtProductName');
            $type = 'Insert';
            $className = 'bg-primary';

            $tableName = 'loanproducts';
            $data = [
                'productName' => $request->input('txtProductName'),
                'description' => $request->input('txtDescription'),
                'defaultPrincipal' => $request->input('txtDefaultPrincipel'),
                'minimumPrincipal' => $request->input('txtMinimumPrincipel'),
                'maximumPrincipal' => $request->input('txtMaximumPrincipel'),
                'defaultLoanTerm' => $request->input('txtDefaultLoanTerm'),
                'minimumLoanTerm' => $request->input('txtMinimumLoanTerm'),
                'maximumLoanTerm' => $request->input('txtMaximumLoanTerm'),
                'repaymentFrequency' => $request->input('txtRepaymentFrequency'),
                'repaymentPeriod' => $request->input('txtRepaymentPreriod'),
                'defaultInterest' => $request->input('txtDefaultInterest'),
                'minimumInterest' => $request->input('txtMinimumInterest'),
                'maximumInterest' => $request->input('txtMaximumInterest'),
                'per' => $request->input('txtPer'),
                'active' => $request->input('txtActive'),
                'interestType' => $request->input('txtInterestType'),
                'appprovalCount' => $request->input('txtApprovalCount'),
                'mainCategory' => $request->input('txtMainCategory'),
                'subCategory' => $request->input('txtSubCategory'),
            ];

            $result = InsertHelper::insertRecord($tableName, $data);
            if ($result === true) {
                return response()->json(['success' => 'Create Product successfully', 'code' => 200]);
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

    function createApprovalSettings(Request $request)
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

            $ipAddress = $request->ip();
            $activityMessage = 'Created new approval: ' . $request->input('txtProductName');
            $type = 'Insert';
            $className = 'bg-primary';

            $tableName = 'loanapprovalsettings';
            $data = [
                'name' => $request->input('txtApprovalName'),
                'minimum' => $request->input('txtMinAmount'),
                'maximum' => $request->input('txtMaxAmount'),
                'howManyApproval' => $request->input('txtHowManyApproval')
            ];

            $result = InsertHelper::insertRecord($tableName, $data);
            if ($result === true) {
                return response()->json(['success' => 'Create loan approval settings successfully', 'code' => 200]);
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


    function createSubCatData(Request $request)
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

            $ipAddress = $request->ip();
            $activityMessage = 'Created new sub category: ' . $request->input('txtSubCatName');
            $type = 'Insert';
            $className = 'bg-primary';

            $tableName = 'loanpurposesubs';
            $data = [
                'mainCatId' => $request->input('txtMainCatId'),
                'name' => $request->input('txtSubCatName')
            ];

            $result = InsertHelper::insertRecord($tableName, $data);
            if ($result === true) {
                return response()->json(['success' => 'Create loan purpose sub category successfully', 'code' => 200]);
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
