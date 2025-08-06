<?php

namespace App\Http\Controllers\pages;

use App\Helpers\activityLogHelper;
use App\Helpers\GeolocationHelper;
use App\Helpers\InsertHelper;
use App\Helpers\UpdateHelper;
use App\Http\Controllers\Controller;
use App\Models\division;
use App\Models\loan;
use App\Models\member;
use App\Models\profession;
use App\Models\userRole;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class manage_old_loan_controller extends Controller
{

     public function updatePurposeMaincatData(Request $request)
    {

        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txtMainCatId = $request->input('txtMainCatId');
            $txtUpdateMainCat = $request->input('txtUpdateMainCat');

            $table = 'loanpurposes';
            $data = [
                'name' => $txtUpdateMainCat,
            ];

            $update = UpdateHelper::updateRecord($table, $txtMainCatId ,$data);

            if($update) {
                return response()->json(['success' => 'Updated purpose main category successfully', 'code' => 200 ]);
            } else {
                return response()->json(['error' => 'Failed to update record', 'code' => 500]);
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

    function createOldLoan()
    {
        $getUserRole = userRole::all();
        $getMember = member::all();
        $getDivision = division::all();
        $getProfession = profession::all();
        $villages = [];
        $smallGroups = [];
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $getLoanOfficer = DB::table('users')->where('userType', 'Field Officer')->get();
        $getLoanPurpose = DB::table('loanpurposes')->get();
        $getPro = DB::table('professions')->get();
        return view('pages.permission.loan.create_old_loan_per', ['getPro' => $getPro, 'getLoanPurpose' => $getLoanPurpose, 'getUserRole' => $getUserRole, 'getLoanOfficer' => $getLoanOfficer, 'getMember' => $getMember, 'getDivision' => $getDivision,  'villages' => $villages,  'smallGroups' => $smallGroups, 'getProfession' => $getProfession, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    function getGurrandas(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txtSelectMember = $request->input('txtSelectMember');
            $getMemberData = DB::table('members')->where('id', $txtSelectMember)->first();
            $getSmallGroupId = $getMemberData->smallGroupId;

            $getGur = DB::table('members')->where('smallGroupId', $getSmallGroupId)->get();
            $selectGurantos = '<option value="">Select Gurantor</option>';
            foreach ($getGur as $gur) {
                if ($gur->id != $txtSelectMember) {
                    $selectGurantos .= '<option value="' . $gur->id . '">' . $gur->firstName . '</option>';
                }
            }
            return response()->json(['success' => 'Create Purpose successfully', 'code' => 200, 'selectGurantos' => $selectGurantos]);
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


    function createOldLoanData(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txtSelectMember = $request->input('txtSelectMember');
            $txtLoanId = $request->input('txtLoanId');
            $txtLoanAmount = $request->input('txtLoanAmount');
            $txtLoanTerm = $request->input('txtLoanTerm');
            $txtRepaymentFrequency = $request->input('txtRepaymentFrequency');
            $txtInterestRate = $request->input('txtInterestRate');
            $txtRepaymentPreriod = $request->input('txtRepaymentPreriod');
            $txtPer = $request->input('txtPer');
            $txtLoanOfficer = $request->input('txtLoanOfficer');
            $txtLoanPurpose = $request->input('txtLoanPurpose');
            $txtLoanGuarantors = $request->input('txtLoanGuarantors');
            $txtFollowerName = $request->input('txtFollowerName');
            $txtFollowerAddress = $request->input('txtFollowerAddress');
            $txtFollowerNic = $request->input('txtFollowerNic');
            $txtFollowerNicIssueDate = $request->input('txtFollowerNicIssueDate');
            $txtFollowerPhoneNumber = $request->input('txtFollowerPhoneNumber');
            $txtFollowerProfession = $request->input('txtFollowerProfession');
            $txtLoanDate = $request->input('txtLoanDate');


            //get location information
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information

            $ipAddress = $request->ip();
            $activityMessage = 'Created Old Loan: ' . $txtLoanId;
            $type = 'Insert';
            $className = 'bg-primary';

            $table = 'loans';
            $data = [
                'memberId' => $txtSelectMember,
                'loanProductId' => 0,
                'principal' => $txtLoanAmount,
                'loanterm' => $txtLoanTerm,
                'repaymentFrequency' => $txtRepaymentFrequency,
                'interestRate' => $txtInterestRate,
                'repaymentPeriod' => $txtRepaymentPreriod,
                'per' => $txtPer,
                'interestType' => 'normal',
                'loanOfficer' => $txtLoanOfficer,
                'loanPurpose' => $txtLoanPurpose,
                'gurrantos' => $txtLoanGuarantors,
                'followerName' => $txtFollowerName,
                'followerAddress' => $txtFollowerAddress,
                'followerNic' => $txtFollowerNic,
                'followerNicIssueDate' => $txtFollowerNicIssueDate,
                'followerPhone' => $txtFollowerPhoneNumber,
                'followerProfession' => $txtFollowerProfession,
                'createStatus' => 1,
                'loanStatus' => 'Active',
                'approvalStatus' => 2,
                'loanId' => $txtLoanId,
                'loanType' => 'Old',
                'created_at' => Carbon::parse($txtLoanDate)->setTime(7, 52, 24)->toDateTimeString(),
            ];
            $result = DB::table($table)->insert($data);
            if ($result === true) {
                $getMaxLoanId = DB::table('loans')->max('id');
                //set on loan schedule
                function calculateLoanScheduleWithMonthlyInterestMonth($loanAmount, $annualInterestRate, $loanTermMonths, $startDate)
                {
                    $monthlyInterestRate = ($annualInterestRate / 12) / 100; // Convert annual interest to monthly rate
                    $numRepayments = $loanTermMonths;

                    $remainingBalance = $loanAmount;
                    $schedule = [];

                    $paymentDate = new DateTime($startDate); // Start date as DateTime

                    // Installment 1: Initial balance, no payment yet
                    $schedule[] = [
                        'installment' => 1,
                        'payment_date' => $paymentDate->format('Y-m-d'),
                        'remaining_balance' => round($remainingBalance, 2),
                        'principal_payment' => 0.00,
                        'interest' => 0.00,
                        'total_repayment' => 0.00,
                    ];

                    // Calculate fixed principal per month
                    $principalPayment = $loanAmount / $numRepayments;

                    // Generate the monthly repayment schedule
                    for ($i = 2; $i <= $numRepayments + 1; $i++) {
                        // Move to next month's payment date
                        $paymentDate->modify('+1 month');

                        // Monthly interest on remaining balance
                        $interest = $remainingBalance * $monthlyInterestRate;

                        // If it's the last payment, pay off all remaining balance
                        if ($i == $numRepayments + 1) {
                            $principalPayment = $remainingBalance;
                            $totalRepayment = $principalPayment + $interest;
                            $remainingBalance = 0;
                        } else {
                            $totalRepayment = $principalPayment + $interest;
                            $remainingBalance -= $principalPayment;
                        }

                        $schedule[] = [
                            'installment' => $i,
                            'payment_date' => $paymentDate->format('Y-m-d'),
                            'remaining_balance' => round($remainingBalance, 2),
                            'principal_payment' => round($principalPayment, 2),
                            'interest' => round($interest, 2),
                            'total_repayment' => round($totalRepayment, 2),
                        ];
                    }

                    return $schedule;
                }
                //set on loan schedule

                $loanSchedule = calculateLoanScheduleWithMonthlyInterestMonth($txtLoanAmount, $txtInterestRate, $txtLoanTerm, $txtLoanDate);
                foreach ($loanSchedule as $payment) {
                    $tablePayment = 'loanschedules';
                    $dataPayment = [
                        'loanId' => $getMaxLoanId,
                        'paymentDate' => $payment['payment_date'],
                        'monthlyPayment' => $payment['total_repayment'],
                        'principalPayment' => $payment['principal_payment'],
                        'interestPayment' =>  $payment['interest'],
                        'balance' => $payment['remaining_balance'],
                        'status' => 'unPaid'
                    ];
                    $resultInsertSchedule = InsertHelper::insertRecord($tablePayment, $dataPayment);
                }
                return response()->json(['success' => 'Create old loan successfully', 'code' => 202, 'redirectUrl' => 'list_of_loan']);
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
