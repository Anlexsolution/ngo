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
use App\Models\loanapprovalsetting;
use App\Models\loandocument;
use App\Models\loanproduct;
use App\Models\loanpurpose;
use App\Models\loanpurposesub;
use App\Models\loanrequest;
use App\Models\member;
use App\Models\profession;
use App\Models\subprofession;
use App\Models\userRole;
use DateTime;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class loan_controller extends Controller
{

    function createLoanRequest($id)
    {
        $getEncId = Crypt::decrypt($id);
        $getLoanRequestData = loanrequest::find($getEncId);
        $getMemId = $getLoanRequestData->memberId;
        $getMainCatId = $getLoanRequestData->mainCategoryId;
        $getSubCatId = $getLoanRequestData->subCategoryId;
        $getLoanAmount = $getLoanRequestData->loanAmount;
        $getLoanDocs = $getLoanRequestData->documents;
        $getUserRole = userRole::all();
        $getMember = DB::table('members')->where('id', $getMemId)->get();
        $getLoanProduct = DB::table('loanproducts')->where('mainCategory', $getMainCatId)->where('subCategory', $getSubCatId)->get();
        $getLoanPurpose = loanpurpose::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $getLoanApproveSetData = loanapprovalsetting::all();

        $getLoanDocData = json_decode($getLoanDocs, true);
        $getDocumentsData = loandocument::all();

        return view('pages.permission.loan.create_loan_request_per', [ 'getEncId' => $getEncId, 'getDocumentsData' => $getDocumentsData, 'getLoanDocData' => $getLoanDocData, 'getAmount' => $getLoanAmount, 'getMainCatId' => $getMainCatId, 'getSubCatId' => $getSubCatId, 'getLoanApproveSetData' => $getLoanApproveSetData, 'getUserRole' => $getUserRole, 'getMember' => $getMember, 'getLoanProduct' => $getLoanProduct, 'getLoanPurpose' => $getLoanPurpose, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    function getLoanRepaymentData(Request $request)
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
            $txtPaymentDate = $request->input('txtPaymentDate');
            $txtLoan = $request->input('txtLoan');
            $getLoans = DB::table('loans')->where('id', $txtLoan)->first();
            $getLoanId = $getLoans->loanId;

            $getLoanRepaymentCount = DB::table('loanrepayments')->where('loanId', $txtLoan)->count();

            function calculateOneTimePayment($loanAmount, $annualInterestRate, $startDate, $endDate, $prinAmount, $loanfinalAm, $status, $getLoanId)
            {
                // Convert annual interest rate to daily interest rate
                $dailyInterestRate = ($annualInterestRate / 100) / 365;

                // Calculate number of days between start and end date
                $start = new DateTime($startDate);
                $end = new DateTime($endDate);
                $daysBetween = $start->diff($end)->days; // Get difference in days

                // Calculate interest for the given period
                if ($status == 'interest wise') {
                    $interest = 0;
                } else {
                    $interest = $loanAmount * $dailyInterestRate * $daysBetween;
                }

                $balancePay = $loanAmount - $prinAmount;
                // Total repayment is just the interest (assuming no principal payment)
                $totalRepayment = $interest;

                $getInteresArreassData = DB::table('interest_arrears')->where('loanId', $getLoanId)->where('status', 'Pending')->get();

                foreach($getInteresArreassData as $arreas){
                    $getAm = $arreas->arrearInterest;
                    $interest += $getAm;
                }


                return [
                    'loan_amount' => $loanAmount,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'days_between' => $daysBetween,
                    'balancePay' => $balancePay,
                    'interest' => round($interest, 2),
                    'total_repayment' => round($totalRepayment, 2),
                    'loanFinalAm' => $loanfinalAm
                ];
            }

            if ($getLoanRepaymentCount > 0) {
                $principal = $getLoans->principal;
                $lastMinBalanceRow = DB::table('loanrepayments')
                    ->where('loanId', $txtLoan)
                    ->orderBy('lastLoanBalance', 'asc')
                    ->first();
                $endDate = $txtPaymentDate;
                $getPrincipalData = DB::table('loanschedules')
                    ->where('loanId', $txtLoan)
                    ->offset(2)
                    ->limit(1)
                    ->first();
                $getloanSchedule = DB::table('loanschedules')->where('loanId', $txtLoan)->get();
                $countWriteOff = 0;
                $countInterestwise  = 0;
                foreach ($getloanSchedule as $sch) {
                    $status = $sch->status;
                    if ($status == "interest wise") {
                        $countInterestwise++;
                    } else if ($status == "write off") {
                        $countWriteOff++;
                    }
                }
                if ($countInterestwise > 0) {
                    $statusView = "interest wise";
                } else if ($countWriteOff > 0) {
                    $statusView = "write off";
                } else {
                    $statusView = "";
                }
                $principalPayment = $getPrincipalData->principalPayment;
                $interestRate = $getLoans->interestRate;
                $oneTimePayment = calculateOneTimePayment($lastMinBalanceRow->lastLoanBalance, $interestRate, $lastMinBalanceRow->repaymentDate, $endDate, $principalPayment, $principal, $statusView, $getLoanId);
                $days = $oneTimePayment['days_between'];
                $payDate = $oneTimePayment['end_date'];
                $interest = $oneTimePayment['interest'];
                $balancePay = $oneTimePayment['balancePay'];
                $loanAmount =  $oneTimePayment['loanFinalAm'];
                $totalPay = $interest + $principalPayment;
                $totalPay = $totalPay;
                if ($statusView == 'write off') {
                    return response()->json(['success' => 'Not repayment the data beacuse this loan is write off', 'code' => 202]);
                } else {
                    return response()->json(['success' => 'Create Profession successfully', 'loanId' => $getLoanId, 'balancePay' => $balancePay, 'totalPay' => $totalPay, 'loanAmount' => $loanAmount,  'payDate' => $payDate, 'interest' => $interest,   'principalPayment' => $principalPayment, 'days' => $days, 'code' => 200]);
                }
            } else {
                $principal = $getLoans->principal;
                $repaymentFrequency = $getLoans->repaymentFrequency;
                $interestRate = $getLoans->interestRate;
                $per = $getLoans->per;

                $getApprovalData = DB::table('loanapprovals')->where('loanId', $txtLoan)->where('approvalType', ' Final Approval')->first();
                if ($getLoans->loanType == 'Old') {
                    $firstRepaymentDate = $getLoans->created_at;
                } else {
                    $firstRepaymentDate = $getApprovalData->created_at;
                }
                $firstLoanApprovalDate = date("Y-m-d", strtotime($firstRepaymentDate));
                $endDate = $txtPaymentDate;

                $getPrincipalData = DB::table('loanschedules')
                    ->where('loanId', $txtLoan)
                    ->offset(2)
                    ->limit(1)
                    ->first();
                $getloanSchedule = DB::table('loanschedules')->where('loanId', $txtLoan)->get();
                $countWriteOff = 0;
                $countInterestwise  = 0;
                foreach ($getloanSchedule as $sch) {
                    $status = $sch->status;
                    if ($status == "interest wise") {
                        $countInterestwise++;
                    } else if ($status == "write off") {
                        $countWriteOff++;
                    }
                }
                if ($countInterestwise > 0) {
                    $statusView = "interest wise";
                } else if ($countWriteOff > 0) {
                    $statusView = "write off";
                } else {
                    $statusView = "";
                }
                $principalPayment = $getPrincipalData->principalPayment;
                $oneTimePayment = calculateOneTimePayment($principal, $interestRate, $firstLoanApprovalDate, $endDate, $principalPayment, $principal, $statusView, $getLoanId);
                $days = $oneTimePayment['days_between'];
                $payDate = $oneTimePayment['end_date'];
                $interest = $oneTimePayment['interest'];
                $balancePay = $oneTimePayment['balancePay'];
                $loanAmount =  $oneTimePayment['loanFinalAm'];
                $totalPay = $interest + $principalPayment;
                $totalPay = $totalPay;
                if ($statusView == 'write off') {
                    return response()->json(['message' => 'Not repayment the data beacuse this loan is write off', 'code' => 202]);
                } else {
                    return response()->json(['success' => 'Create Profession successfully', 'loanId' => $getLoanId, 'balancePay' => $balancePay, 'totalPay' => $totalPay, 'loanAmount' => $loanAmount,  'payDate' => $payDate, 'interest' => $interest,   'principalPayment' => $principalPayment, 'days' => $days, 'code' => 200]);
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

    function getMemberLoanData(Request $request)
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
            $getLoans = DB::table('loans')->where('memberId', $txtMember)->where('loanStatus' , 'Active')->get();

            $getAllLoanOption = '<option value="">---select----</option>';
            foreach ($getLoans as $get) {
                $getAllLoanOption .= '<option value="' . $get->id . '">' . $get->loanId . '</option>';
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


    function calculateLoanAmount(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txtPricipal = $request->input('txtPricipal');
            $txtInterestRate = $request->input('txtInterestRate');
            $txtLoanTerm = $request->input('txtLoanTerm');
            $txtRepaymentFrequency = $request->input('txtRepaymentFrequency');
            $txtRepaymentPreriod = $request->input('txtRepaymentPreriod');
            $txtExpectedFirstRepaymentDate = $request->input('txtExpectedFirstRepaymentDate');
            $txtPer = $request->input('txtPer');

            if ($txtPer == 'Year') {
                function calculateLoanScheduleWithZeroBalance($loanAmount, $annualInterestRate, $repaymentIntervalDays, $loanTermMonths, $startDate)
                {
                    $dailyInterestRate = ($annualInterestRate / 100) / 365; // Convert annual rate to daily rate
                    $loanTermDays = $loanTermMonths * 30; // Approximate loan term in days
                    $numRepayments = floor($loanTermDays / $repaymentIntervalDays); // Number of repayments

                    $remainingBalance = $loanAmount;
                    $schedule = [];
                    $paymentDate = new DateTime($startDate); // Convert start date to DateTime object

                    // Installment 1: Only the loan balance, no payment yet
                    $schedule[] = [
                        'installment' => 1,
                        'payment_date' => $paymentDate->format('Y-m-d'),
                        'remaining_balance' => round($remainingBalance, 2),
                        'principal_payment' => 0.00,
                        'interest' => 0.00,
                        'total_repayment' => 0.00,
                    ];

                    $paymentDate->modify("+$repaymentIntervalDays days"); // Move to next repayment date

                    // Calculate equal principal payments
                    $principalPayment = $loanAmount / $numRepayments;

                    // Start actual repayments from Installment 2 onwards
                    for ($i = 2; $i <= $numRepayments + 1; $i++) {
                        $interest = $remainingBalance * ($dailyInterestRate * $repaymentIntervalDays); // Interest for this period

                        // Adjust last installment to clear remaining balance
                        if ($i == $numRepayments + 1) {
                            $principalPayment = $remainingBalance; // Take whatever balance is left
                            $totalRepayment = $principalPayment + $interest; // Ensure final payment clears loan
                            $remainingBalance = 0; // Ensure last balance is exactly 0
                        } else {
                            $totalRepayment = $principalPayment + $interest;
                            $remainingBalance -= $principalPayment; // Reduce remaining balance after payment
                        }

                        $schedule[] = [
                            'installment' => $i,
                            'payment_date' => $paymentDate->format('Y-m-d'),
                            'remaining_balance' => round($remainingBalance, 2),
                            'principal_payment' => round($principalPayment, 2),
                            'interest' => round($interest, 2),
                            'total_repayment' => round($totalRepayment, 2),
                        ];

                        $paymentDate->modify("+$repaymentIntervalDays days"); // Move to next repayment date
                    }

                    return $schedule;
                }

                function calculateLoanScheduleWithZeroBalanceMonth($loanAmount, $annualInterestRate, $loanTermMonths, $startDate)
                {
                    $monthlyInterestRate = ($annualInterestRate / 12) / 100; // Convert annual rate to monthly
                    $numRepayments = $loanTermMonths;

                    $remainingBalance = $loanAmount;
                    $schedule = [];

                    $paymentDate = new DateTime($startDate);

                    // Installment 1: Initial balance, no payment yet
                    $schedule[] = [
                        'installment' => 1,
                        'payment_date' => $paymentDate->format('Y-m-d'),
                        'remaining_balance' => round($remainingBalance, 2),
                        'principal_payment' => 0.00,
                        'interest' => 0.00,
                        'total_repayment' => 0.00,
                    ];

                    // Calculate equal principal payments
                    $principalPayment = $loanAmount / $numRepayments;

                    // Start repayments monthly
                    for ($i = 2; $i <= $numRepayments + 1; $i++) {
                        $paymentDate->modify('+1 month');

                        // Monthly interest on remaining balance
                        $interest = $remainingBalance * $monthlyInterestRate;

                        // If it's the last payment, clear remaining balance
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


                $loanAmount = $txtPricipal; // Loan Amount
                $annualInterestRate = $txtInterestRate; // 10% yearly interest

                $loanTermMonths = $txtLoanTerm; // 12 months loan term
                $startDate = date('Y-m-d'); // Loan start date


                if ($txtRepaymentPreriod == 'Days') {
                    $repaymentIntervalDays = $txtRepaymentFrequency; // Every 10 days
                    // Get Loan Repayment Schedule
                    $loanSchedule = calculateLoanScheduleWithZeroBalance($loanAmount, $annualInterestRate, $repaymentIntervalDays, $loanTermMonths, $startDate);
                } else if ($txtRepaymentPreriod == 'Weeks') {
                    $repaymentIntervalDays = $txtRepaymentFrequency * 7; // Every 7 days
                    // Get Loan Repayment Schedule
                    $loanSchedule = calculateLoanScheduleWithZeroBalance($loanAmount, $annualInterestRate, $repaymentIntervalDays, $loanTermMonths, $startDate);
                } else {
                    $repaymentIntervalDays = $txtRepaymentFrequency * 30; // Every 30 days
                    // Get Loan Repayment Schedule
                    $loanSchedule = calculateLoanScheduleWithZeroBalanceMonth($loanAmount, $annualInterestRate, $loanTermMonths, $startDate);
                }
                // Example Usage:



                // Generate Table View
                $viewTable = '<table class="table table-striped table-bordered" id="loanTable">';
                $viewTable .= '<thead><tr><th>Installment</th><th>Payment Date</th><th>Principal Payment</th><th>Interest</th><th>Total Repayment</th><th>Remaining Balance</th></tr></thead>';
                foreach ($loanSchedule as $payment) {
                    $viewTable .= '<tr>';
                    $viewTable .= '<td>' . $payment['installment'] . '</td>';
                    $viewTable .= '<td>' . $payment['payment_date'] . '</td>';
                    $viewTable .= '<td>' . number_format($payment['principal_payment'], 2) . '</td>';
                    $viewTable .= '<td>' . number_format($payment['interest'], 2) . '</td>';
                    $viewTable .= '<td>' . number_format($payment['total_repayment'], 2) . '</td>';
                    $viewTable .= '<td>' . number_format($payment['remaining_balance'], 2) . '</td>';
                    $viewTable .= '</tr>';
                }
                $viewTable .= '</table>';
            } else if ($txtPer == 'Month') {
                function calculateLoanScheduleWithMonthlyInterest($loanAmount, $annualInterestRate, $repaymentIntervalDays, $loanTermMonths, $startDate)
                {
                    $monthlyInterestRate = ($annualInterestRate / 100);  // Convert annual rate to monthly rate
                    $loanTermDays = $loanTermMonths * 30; // Approximate loan term in days
                    $numRepayments = floor($loanTermDays / $repaymentIntervalDays); // Number of repayments

                    $remainingBalance = $loanAmount;
                    $schedule = [];
                    $paymentDate = new DateTime($startDate); // Convert start date to DateTime object

                    // Installment 1: Only the loan balance, no payment yet
                    $schedule[] = [
                        'installment' => 1,
                        'payment_date' => $paymentDate->format('Y-m-d'),
                        'remaining_balance' => round($remainingBalance, 2),
                        'principal_payment' => 0.00,
                        'interest' => 0.00,
                        'total_repayment' => 0.00,
                    ];

                    $paymentDate->modify("+$repaymentIntervalDays days"); // Move to next repayment date

                    // Calculate equal principal payments
                    $principalPayment = $loanAmount / $numRepayments;

                    // Start actual repayments from Installment 2 onwards
                    for ($i = 2; $i <= $numRepayments + 1; $i++) {
                        // Interest based on remaining balance and monthly interest rate
                        $interest = $remainingBalance * $monthlyInterestRate;
                        $interest = $interest / 30;
                        $interest = $interest * $repaymentIntervalDays;
                        // Adjust last installment to clear remaining balance
                        if ($i == $numRepayments + 1) {
                            $principalPayment = $remainingBalance; // Take whatever balance is left
                            $totalRepayment = $principalPayment + $interest; // Ensure final payment clears loan
                            $remainingBalance = 0; // Ensure last balance is exactly 0
                        } else {
                            $totalRepayment = $principalPayment + $interest;
                            $remainingBalance -= $principalPayment; // Reduce remaining balance after payment
                        }

                        $schedule[] = [
                            'installment' => $i,
                            'payment_date' => $paymentDate->format('Y-m-d'),
                            'remaining_balance' => round($remainingBalance, 2),
                            'principal_payment' => round($principalPayment, 2),
                            'interest' => round($interest, 2),
                            'total_repayment' => round($totalRepayment, 2),
                        ];

                        $paymentDate->modify("+$repaymentIntervalDays days"); // Move to next repayment date
                    }

                    return $schedule;
                }

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


                $loanAmount = $txtPricipal; // Loan Amount
                $annualInterestRate = $txtInterestRate; // 10% yearly interest

                $loanTermMonths = $txtLoanTerm; // 12 months loan term
                $startDate = date('Y-m-d'); // Loan start date

                // Example Usage:
                if ($txtRepaymentPreriod == 'Days') {
                    $repaymentIntervalDays = $txtRepaymentFrequency; // Every 10 days
                    $loanSchedule = calculateLoanScheduleWithMonthlyInterest($loanAmount, $annualInterestRate, $repaymentIntervalDays, $loanTermMonths, $startDate);
                } else if ($txtRepaymentPreriod == 'Weeks') {
                    $repaymentIntervalDays = $txtRepaymentFrequency * 7; // Every 7 days
                    $loanSchedule = calculateLoanScheduleWithMonthlyInterest($loanAmount, $annualInterestRate, $repaymentIntervalDays, $loanTermMonths, $startDate);
                } else {
                    $repaymentIntervalDays = $txtRepaymentFrequency * 30; // Every 30 days
                    $loanSchedule = calculateLoanScheduleWithMonthlyInterestMonth($loanAmount, $annualInterestRate, $loanTermMonths, $startDate);
                }
                // Example Usage:



                // Output Loan Schedule
                $viewTable = '';
                $viewTable .= '<table class="table table-striped table-bordered" id="loanTable">';
                $viewTable .= '<thead><tr><th>Installment</th><th>Payment Date</th><th>Principal Payment</th><th>Interest</th><th>Total Repayment</th><th>Remaining Balance</th></tr></thead>';
                // Output Loan Schedule
                foreach ($loanSchedule as $payment) {
                    $viewTable .= '<tr>';
                    $viewTable .= '<td>' . $payment['installment'] . '</td>';
                    $viewTable .= '<td>' . $payment['payment_date'] . '</td>';
                    $viewTable .= '<td>' . $payment['principal_payment'] . '</td>';
                    $viewTable .= '<td>' . $payment['interest'] . '</td>';
                    $viewTable .= '<td>' . $payment['total_repayment'] . '</td>';
                    $viewTable .= '<td>' . $payment['remaining_balance'] . '</td>';
                    $viewTable .= '</tr>';
                }
                $viewTable .= '</table>';
            }

            return response()->json([
                'loanSchedule' => $viewTable,
                'code' => 200,
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

    function viewLoanDetails($id)
    {
        $decId = Crypt::decrypt($id);
        $loanDetails = loan::find($decId);
        $memberIdGet = $loanDetails->memberId;
        $loanOfficer = $loanDetails->loanOfficer;
        $getScheduleData = DB::table('loanschedules')->where('loanId', $decId)->get();
        $getRepaymentDetails = DB::table('loanrepayments')
            ->where('loanId', $decId)
            ->orderBy('created_at', 'desc')
            ->get();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $getMember = member::find($memberIdGet);
        $getUserRole = userRole::all();
        $getAllUser = User::all();
        $getLoanOfficer = User::find($loanOfficer);
        $getLoanApproval = DB::table('loanapprovals')->where('loanId', $decId)->get();
        $getPro = profession::all();
        $getSubPro = subprofession::all();
        $getGnDivision = gndivision::all();
        $gndivisionSmallgroup = gndivisionsmallgroup::all();
        $getLoanReqId = $loanDetails->loanReqId;
        $getLoanReqData = loanrequest::find($getLoanReqId);

        return view('pages.permission.loan.view_loan_details_per', ['getLoanReqData' => $getLoanReqData, 'gndivisionSmallgroup' => $gndivisionSmallgroup, 'getGnDivision' => $getGnDivision, 'getPro' => $getPro, 'getSubPro' => $getSubPro, 'getRepaymentDetails' => $getRepaymentDetails, 'getAllUser' => $getAllUser, 'getLoanApproval' => $getLoanApproval, 'getLoanOfficer' => $getLoanOfficer, 'member' => $getMember, 'loanDetails' => $loanDetails, 'getUserRole' => $getUserRole, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData, 'getScheduleData' => $getScheduleData]);
    }


    function viewLoanApproval($loanId, $memberId)
    {
        $loanIdDec = Crypt::decrypt($loanId);
        $memberIdDec = Crypt::decrypt($memberId);
        $loanDetails = loan::find($loanIdDec);
        $memberDetails = member::find($memberIdDec);
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $getUserRole = userRole::all();
        $loanOfficerId = $loanDetails->loanOfficer;
        $getLoanOfficer = User::find($loanOfficerId);

        $getLoanData = loan::find($loanIdDec);

        $getApprovalArray = $getLoanData->approval;
        $getApprovalArray = json_decode($getApprovalArray, true);
        $idArray = array_column($getApprovalArray, 'id');
        $maxId = max($idArray);
        $getApprovalStatus = $getLoanData->approvalStatus + 1;

        $getLoanAm = $loanDetails->principal;
        $getAccountData = DB::table('accounts')->where('balance', '>', $getLoanAm)->get();

        return view('pages.permission.loan.view_loan_approval_per', ['getAccountData' => $getAccountData, 'maxId' => $maxId, 'getApprovalStatus' => $getApprovalStatus,  'loanDetails' => $loanDetails, 'memberDetails' => $memberDetails, 'getUserRole' => $getUserRole, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData, 'getLoanOfficer' => $getLoanOfficer]);
    }

    function createLoanFinal(Request $request)
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

            $txtLoanId = $request->input('txtLoanId');
            $txtName = $request->input('txtName');
            $txtAddress = $request->input('txtAddress');
            $txtNic = $request->input('txtNic');
            $txtNicIssueDate = $request->input('txtNicIssueDate');
            $txtPhoneNumber = $request->input('txtPhoneNumber');
            $txtProfession = $request->input('txtProfession');

            $ipAddress = $request->ip();
            $activityMessage = 'Created new Loan: ' . $txtLoanId;
            $type = 'Insert';
            $className = 'bg-primary';

            $table = 'loans';
            $data = [
                'followerName' => $txtName,
                'followerAddress' => $txtAddress,
                'followerNic' => $txtNic,
                'followerNicIssueDate' => $txtNicIssueDate,
                'followerPhone' => $txtPhoneNumber,
                'followerProfession' => $txtProfession,
                'createStatus' => 1
            ];
            $result = UpdateHelper::updateRecord($table, $txtLoanId, $data);
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
    function loanFollower($id)
    {
        $decId = Crypt::decrypt($id);
        $getUserRole = userRole::all();
        $getPro = profession::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.permission.loan.loan_follower_per', ['getUserRole' => $getUserRole, 'loanId' => $decId, 'getPro' => $getPro, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }
    function manageLoanPurpose()
    {
        $getPurpose = loanpurpose::all();
        $getUserRole = userRole::all();
        $getLoansData = loan::all();
        $getLoanPurposeSubCat = loanpurposesub::all();
        $getAllMemberData = member::all();
        return view('pages.permission.settings.manage_loan_purpose_per', ['getAllMemberData' => $getAllMemberData, 'getLoanPurposeSubCat' => $getLoanPurposeSubCat, 'getUserRole' => $getUserRole, 'getPurpose' => $getPurpose, 'getLoansData' => $getLoansData]);
    }
    function listOfLoan()
    {
        $getData = DB::table('loans')->where('createStatus', 1)->latest('created_at')->get();
        $getMember = member::all();
        $getproduct = loanproduct::all();
        $getUserRole = userRole::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.permission.loan.list_of_loan_per', ['getUserRole' => $getUserRole, 'getData' => $getData, 'getMember' => $getMember, 'getproduct' => $getproduct, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    function createLoan()
    {
        $getUserRole = userRole::all();
        $getMember = member::all();
        $getLoanProduct = loanproduct::all();
        $getLoanPurpose = loanpurpose::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $getLoanRequestData = loanrequest::all();
        $getLoanApproveSetData = loanapprovalsetting::all();
        return view('pages.permission.loan.create_loan_per', ['getLoanApproveSetData' => $getLoanApproveSetData, 'getLoanRequestData' => $getLoanRequestData, 'getUserRole' => $getUserRole, 'getMember' => $getMember, 'getLoanProduct' => $getLoanProduct, 'getLoanPurpose' => $getLoanPurpose, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    function getLoanProduct(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }
            $txtSelectMember = $request->input('txtSelectMember');
            $txtSelectLoanProduct = $request->input('txtSelectLoanProduct');
            $txtSelectLoanAmount = $request->input('txtSelectLoanAmount');
            $txtSelectLoanApprovalSet = $request->input('txtSelectLoanApprovalSet');

            $getLoanProduct = loanproduct::where('id', $txtSelectLoanProduct)->first();
            $getMember = member::where('id', $txtSelectMember)->first();
            $getMemDivisionId = $getMember->divisionId;
            $getUser = User::all();

            $getLoanAm = DB::table('loanrequests')->where('id', $txtSelectLoanAmount)->first();
            $getloanAmount = $getLoanAm->loanAmount;

            $getLoanApp = DB::table('loanapprovalsettings')->where('id', $txtSelectLoanApprovalSet)->first();
            $getLoanAppCount = $getLoanApp->howManyApproval;

            $appprovalCount = $getLoanAppCount;

            $getApprovalDetails = "<div class='row mt-3'>";
            for ($i = 1; $i <= $appprovalCount; $i++) {
                $labels = [
                    1 => "First",
                    2 => "Second",
                    3 => "Third",
                    4 => "Fourth",
                    5 => "Fifth",
                    6 => "Sixth",
                    7 => "Seventh",
                    8 => "Eighth",
                    9 => "Ninth",
                    10 => "Tenth"
                ];
                $getApprovalDetails .= "<div class='col-4'>";
                $getApprovalDetails .= "<div class='form-group'>";
                $getApprovalDetails .= '<label>' . $labels[$i] . ' Approval</label>';
                $getApprovalDetails .= '<select id="' . $i . '" class="selectizeApproval getApprovalData">';
                foreach ($getUser as $user) {
                    if ($user->userType != 'member') {
                        $getApprovalDetails .= '<option value="' . $user->id . '">' . $user->name . ' - ' . $user->userType . '</option>';
                    }
                }
                $getApprovalDetails .= "</select>";
                $getApprovalDetails .= "</div>";
                $getApprovalDetails .= "</div>";
            }
            $getApprovalDetails .= "</div>";

            $getLoanOfficer = '<select  id="txtLoanOfficer">';
            foreach ($getUser as $user) {
                $userDivId = $user->division;
                if ($user->userType == 'Field Officer') {
                    $getLoanOfficer .= '<option value="' . $user->id . '">' . $user->name . '</option>';
                    // if ($userDivId != '' || $userDivId != null) {
                    //     $userDivId = json_decode($userDivId, true);
                    //     if (in_array($getMemDivisionId, $userDivId)) {
                    //         $getLoanOfficer .= '<option value="' . $user->id . '">' . $user->name . '</option>';
                    //     }
                    // }
                }
            }
            $getLoanOfficer .= '</select>';

            return response()->json(['success' => 'Create Product successfully', 'code' => 200, 'getloanAmount' => $getloanAmount, 'getLoanProduct' => $getLoanProduct, 'getMember' => $getMember, 'getLoanOfficer' => $getLoanOfficer, 'getApprovalDetails' => $getApprovalDetails]);
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

    function loanApprovalData(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $loanId = $request->input('loanId');
            $getLoanData = loan::find($loanId);

            //get location information
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $approvalStatus = $request->input('approvalStatus');
            $txtApprovalReason = $request->input('txtApprovalReason');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information

            $ipAddress = $request->ip();
            $activityMessage = 'Created Loan Approval: ' . $getLoanData->id;
            $type = 'Update';
            $className = 'bg-success';

            $getApprovalArray = $getLoanData->approval;
            $getApprovalArray = json_decode($getApprovalArray, true);
            $idArray = array_column($getApprovalArray, 'id');
            $maxId = max($idArray);
            $getApprovalStatus = $getLoanData->approvalStatus + 1;

            if ($approvalStatus == 'approved') {
                if ($getApprovalStatus == $maxId) {
                    $txtPer = $getLoanData->per;
                    if ($txtPer == 'Year') {
                        function calculateLoanScheduleWithZeroBalance($loanAmount, $annualInterestRate, $repaymentIntervalDays, $loanTermMonths, $startDate)
                        {
                            $dailyInterestRate = ($annualInterestRate / 100) / 365; // Convert annual rate to daily rate
                            $loanTermDays = $loanTermMonths * 30; // Approximate loan term in days
                            $numRepayments = floor($loanTermDays / $repaymentIntervalDays); // Number of repayments

                            $remainingBalance = $loanAmount;
                            $schedule = [];
                            $paymentDate = new DateTime($startDate); // Convert start date to DateTime object

                            // Installment 1: Only the loan balance, no payment yet
                            $schedule[] = [
                                'installment' => 1,
                                'payment_date' => $paymentDate->format('Y-m-d'),
                                'remaining_balance' => round($remainingBalance, 2),
                                'principal_payment' => 0.00,
                                'interest' => 0.00,
                                'total_repayment' => 0.00,
                            ];

                            $paymentDate->modify("+$repaymentIntervalDays days"); // Move to next repayment date

                            // Calculate equal principal payments
                            $principalPayment = $loanAmount / $numRepayments;

                            // Start actual repayments from Installment 2 onwards
                            for ($i = 2; $i <= $numRepayments + 1; $i++) {
                                $interest = $remainingBalance * ($dailyInterestRate * $repaymentIntervalDays); // Interest for this period

                                // Adjust last installment to clear remaining balance
                                if ($i == $numRepayments + 1) {
                                    $principalPayment = $remainingBalance; // Take whatever balance is left
                                    $totalRepayment = $principalPayment + $interest; // Ensure final payment clears loan
                                    $remainingBalance = 0; // Ensure last balance is exactly 0
                                } else {
                                    $totalRepayment = $principalPayment + $interest;
                                    $remainingBalance -= $principalPayment; // Reduce remaining balance after payment
                                }

                                $schedule[] = [
                                    'installment' => $i,
                                    'payment_date' => $paymentDate->format('Y-m-d'),
                                    'remaining_balance' => round($remainingBalance, 2),
                                    'principal_payment' => round($principalPayment, 2),
                                    'interest' => round($interest, 2),
                                    'total_repayment' => round($totalRepayment, 2),
                                ];

                                $paymentDate->modify("+$repaymentIntervalDays days"); // Move to next repayment date
                            }

                            return $schedule;
                        }

                        function calculateLoanScheduleWithZeroBalanceMonth($loanAmount, $annualInterestRate, $loanTermMonths, $startDate)
                        {
                            $monthlyInterestRate = ($annualInterestRate / 12) / 100; // Convert annual rate to monthly
                            $numRepayments = $loanTermMonths;

                            $remainingBalance = $loanAmount;
                            $schedule = [];

                            $paymentDate = new DateTime($startDate);

                            // Installment 1: Initial balance, no payment yet
                            $schedule[] = [
                                'installment' => 1,
                                'payment_date' => $paymentDate->format('Y-m-d'),
                                'remaining_balance' => round($remainingBalance, 2),
                                'principal_payment' => 0.00,
                                'interest' => 0.00,
                                'total_repayment' => 0.00,
                            ];

                            // Calculate equal principal payments
                            $principalPayment = $loanAmount / $numRepayments;

                            // Start repayments monthly
                            for ($i = 2; $i <= $numRepayments + 1; $i++) {
                                $paymentDate->modify('+1 month');

                                // Monthly interest on remaining balance
                                $interest = $remainingBalance * $monthlyInterestRate;

                                // If it's the last payment, clear remaining balance
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

                        $txtRepaymentPreriod = $getLoanData->repaymentPeriod;
                        $txtRepaymentFrequency = $getLoanData->repaymentFrequency;
                        $txtPricipal = $getLoanData->principal;
                        $txtInterestRate = $getLoanData->interestRate;
                        $txtLoanTerm = $getLoanData->loanterm;
                        $txtExpectedFirstRepaymentDate = $getLoanData->firstRepaymentDate;

                        $loanAmount = $txtPricipal; // Loan Amount
                        $annualInterestRate = $txtInterestRate; // 10% yearly interest

                        $loanTermMonths = $txtLoanTerm; // 12 months loan term
                        $startDate = $txtExpectedFirstRepaymentDate; // Loan start date

                        if ($txtRepaymentPreriod == 'Days') {
                            $repaymentIntervalDays = $txtRepaymentFrequency; // Every 10 days
                            $loanSchedule = calculateLoanScheduleWithZeroBalance($loanAmount, $annualInterestRate, $repaymentIntervalDays, $loanTermMonths, $startDate);
                        } else if ($txtRepaymentPreriod == 'Weeks') {
                            $repaymentIntervalDays = $txtRepaymentFrequency * 7; // Every 7 days
                            $loanSchedule = calculateLoanScheduleWithZeroBalance($loanAmount, $annualInterestRate, $repaymentIntervalDays, $loanTermMonths, $startDate);
                        } else {
                            $repaymentIntervalDays = $txtRepaymentFrequency * 30; // Every 30 days
                            $loanSchedule = calculateLoanScheduleWithZeroBalanceMonth($loanAmount, $annualInterestRate, $loanTermMonths, $startDate);
                        }
                        // Example Usage:





                        // Output Loan Schedule
                        foreach ($loanSchedule as $payment) {
                            $tablePayment = 'loanschedules';
                            $dataPayment = [
                                'loanId' => $loanId,
                                'paymentDate' => $payment['payment_date'],
                                'monthlyPayment' => $payment['total_repayment'],
                                'principalPayment' => $payment['principal_payment'],
                                'interestPayment' =>  $payment['interest'],
                                'balance' => $payment['remaining_balance'],
                                'status' => 'unPaid'
                            ];
                            $resultInsertSchedule = InsertHelper::insertRecord($tablePayment, $dataPayment);
                        }

                        $tableApproval = 'loanapprovals';
                        $userId = Auth::user()->id;
                        $dataApproval = [
                            'loanId' => $loanId,
                            'userId' => $userId,
                            'approvalType' => " Final Approval",
                            'approvalStatus' => $approvalStatus,
                            'reason' => $txtApprovalReason
                        ];
                        $resultInsert = InsertHelper::insertRecord($tableApproval, $dataApproval);

                        $txtCheckNoFinal = $request->input('txtCheckNoFinal');
                        $txtAccount = $request->input('txtAccount');

                        $getAccountData = DB::table('accounts')->where('id', $txtAccount)->first();
                        $getAccountBlanace = $getAccountData->balance;

                        $getLoanDatas = DB::table('loans')->where('id', $loanId)->first();
                        $getprincipal = $getLoanDatas->principal;
                        $getmemberId = $getLoanDatas->memberId;

                        $finalBalance = $getAccountBlanace - $getprincipal;

                        $tableUpdateAcc = 'accounts';
                        $dataACC = [
                            'balance' => $finalBalance
                        ];

                        $tableAccTrans = 'accounttransferhistories';
                        $dataTrans = [
                            'userId' => $userId,
                            'transferAmount' => $getprincipal,
                            'remarks' => "Provide a loan to the member",
                            'toAccountId' => 0,
                            'fromAccountId' => $txtAccount,
                            'fromAccountBalance' => $finalBalance,
                            'toAccountBalance' => 0,
                            'date' => date('Y-m-d'),
                        ];

                        $tableUpdate = 'loans';
                        $data = [
                            'approvalStatus' => $getApprovalStatus,
                            'loanStatus' => "Active",
                            'checkNo' => $txtCheckNoFinal,
                            'account' => $txtAccount
                        ];
                        $result = UpdateHelper::updateRecord($tableUpdate, $loanId, $data);
                        $resultACC = UpdateHelper::updateRecord($tableUpdateAcc, $txtAccount, $dataACC);
                        $resultTrans = InsertHelper::insertRecord($tableAccTrans, $dataTrans);
                        if ($result === true && $resultInsert === true  && $resultACC === true && $resultTrans === true) {
                            return response()->json(['success' => 'Loan Activated successfully', 'redirectUrl' => '/dashboard', 'code' => 202]);
                            $activityLogResult = activityLogHelper::activityLog($ipAddress, $location, $country, $activityMessage, $type, $className);
                        } else {
                            return response()->json(['error' => $result['error'], 'code' => 500]);
                        }
                    } else if ($txtPer == 'Month') {
                        function calculateLoanScheduleWithMonthlyInterest($loanAmount, $annualInterestRate, $repaymentIntervalDays, $loanTermMonths, $startDate)
                        {
                            $monthlyInterestRate = ($annualInterestRate / 100);  // Convert annual rate to monthly rate
                            $loanTermDays = $loanTermMonths * 30; // Approximate loan term in days
                            $numRepayments = floor($loanTermDays / $repaymentIntervalDays); // Number of repayments

                            $remainingBalance = $loanAmount;
                            $schedule = [];
                            $paymentDate = new DateTime($startDate); // Convert start date to DateTime object

                            // Installment 1: Only the loan balance, no payment yet
                            $schedule[] = [
                                'installment' => 1,
                                'payment_date' => $paymentDate->format('Y-m-d'),
                                'remaining_balance' => round($remainingBalance, 2),
                                'principal_payment' => 0.00,
                                'interest' => 0.00,
                                'total_repayment' => 0.00,
                            ];

                            $paymentDate->modify("+$repaymentIntervalDays days"); // Move to next repayment date

                            // Calculate equal principal payments
                            $principalPayment = $loanAmount / $numRepayments;

                            // Start actual repayments from Installment 2 onwards
                            for ($i = 2; $i <= $numRepayments + 1; $i++) {
                                // Interest based on remaining balance and monthly interest rate
                                $interest = $remainingBalance * $monthlyInterestRate;
                                $interest = $interest / 30;
                                $interest = $interest * $repaymentIntervalDays;
                                // Adjust last installment to clear remaining balance
                                if ($i == $numRepayments + 1) {
                                    $principalPayment = $remainingBalance; // Take whatever balance is left
                                    $totalRepayment = $principalPayment + $interest; // Ensure final payment clears loan
                                    $remainingBalance = 0; // Ensure last balance is exactly 0
                                } else {
                                    $totalRepayment = $principalPayment + $interest;
                                    $remainingBalance -= $principalPayment; // Reduce remaining balance after payment
                                }

                                $schedule[] = [
                                    'installment' => $i,
                                    'payment_date' => $paymentDate->format('Y-m-d'),
                                    'remaining_balance' => round($remainingBalance, 2),
                                    'principal_payment' => round($principalPayment, 2),
                                    'interest' => round($interest, 2),
                                    'total_repayment' => round($totalRepayment, 2),
                                ];

                                $paymentDate->modify("+$repaymentIntervalDays days"); // Move to next repayment date
                            }

                            return $schedule;
                        }

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


                        $txtRepaymentPreriod = $getLoanData->repaymentPeriod;
                        $txtRepaymentFrequency = $getLoanData->repaymentFrequency;
                        $txtPricipal = $getLoanData->principal;
                        $txtInterestRate = $getLoanData->interestRate;
                        $txtLoanTerm = $getLoanData->loanterm;
                        $txtExpectedFirstRepaymentDate = $getLoanData->firstRepaymentDate;

                        $loanAmount = $txtPricipal; // Loan Amount
                        $annualInterestRate = $txtInterestRate; // 10% yearly interest

                        $loanTermMonths = $txtLoanTerm; // 12 months loan term
                        $startDate = date('Y-m-d'); // Loan start date


                        // Example Usage:
                        if ($txtRepaymentPreriod == 'Days') {
                            $repaymentIntervalDays = $txtRepaymentFrequency; // Every 10 days
                            $loanSchedule = calculateLoanScheduleWithMonthlyInterest($loanAmount, $annualInterestRate, $repaymentIntervalDays, $loanTermMonths, $startDate);
                        } else if ($txtRepaymentPreriod == 'Weeks') {
                            $repaymentIntervalDays = $txtRepaymentFrequency * 7; // Every 7 days
                            $loanSchedule = calculateLoanScheduleWithMonthlyInterest($loanAmount, $annualInterestRate, $repaymentIntervalDays, $loanTermMonths, $startDate);
                        } else {
                            $repaymentIntervalDays = $txtRepaymentFrequency * 30; // Every 30 days
                            $loanSchedule = calculateLoanScheduleWithMonthlyInterestMonth($loanAmount, $annualInterestRate, $loanTermMonths, $startDate);
                        }
                        // Example Usage:



                        // Output Loan Schedule
                        // Output Loan Schedule
                        foreach ($loanSchedule as $payment) {
                            $tablePayment = 'loanschedules';
                            $dataPayment = [
                                'loanId' => $loanId,
                                'paymentDate' => $payment['payment_date'],
                                'monthlyPayment' => $payment['total_repayment'],
                                'principalPayment' => $payment['principal_payment'],
                                'interestPayment' =>  $payment['interest'],
                                'balance' => $payment['remaining_balance'],
                                'status' => 'unPaid'
                            ];
                            $resultInsertSchedule = InsertHelper::insertRecord($tablePayment, $dataPayment);
                        }

                        $tableApproval = 'loanapprovals';
                        $userId = Auth::user()->id;
                        $dataApproval = [
                            'loanId' => $loanId,
                            'userId' => $userId,
                            'approvalType' => " Final Approval",
                            'approvalStatus' => $approvalStatus,
                            'reason' => $txtApprovalReason
                        ];
                        $resultInsert = InsertHelper::insertRecord($tableApproval, $dataApproval);

                        $tableUpdate = 'loans';
                        $data = [
                            'approvalStatus' => $getApprovalStatus,
                            'loanStatus' => "Active"
                        ];
                        $result = UpdateHelper::updateRecord($tableUpdate, $loanId, $data);
                        if ($result === true && $resultInsert === true) {
                            return response()->json(['success' => 'Loan Activated successfully', 'redirectUrl' => '/dashboard', 'code' => 202]);
                            $activityLogResult = activityLogHelper::activityLog($ipAddress, $location, $country, $activityMessage, $type, $className);
                        } else {
                            return response()->json(['error' => $result['error'], 'code' => 500]);
                        }
                    }
                } else {
                    $labels = [
                        1 => "First",
                        2 => "Second",
                        3 => "Third",
                        4 => "Fourth",
                        5 => "Fifth",
                        6 => "Sixth",
                        7 => "Seventh",
                        8 => "Eighth",
                        9 => "Ninth",
                        10 => "Tenth"
                    ];
                    $tableApproval = 'loanapprovals';
                    $userId = Auth::user()->id;
                    $dataApproval = [
                        'loanId' => $loanId,
                        'userId' => $userId,
                        'approvalType' => $labels[$getApprovalStatus] . " Approval",
                        'approvalStatus' => $approvalStatus,
                        'reason' => $txtApprovalReason
                    ];
                    $resultInsert = InsertHelper::insertRecord($tableApproval, $dataApproval);

                    $tableUpdate = 'loans';
                    $data = [
                        'approvalStatus' => $getApprovalStatus,
                        'loanStatus' => $labels[$getApprovalStatus] . " Approval"
                    ];
                    $result = UpdateHelper::updateRecord($tableUpdate, $loanId, $data);
                    if ($result === true && $resultInsert === true) {
                        return response()->json(['success' => 'Loan Approval successfully', 'redirectUrl' => '/dashboard', 'code' => 202]);
                        $activityLogResult = activityLogHelper::activityLog($ipAddress, $location, $country, $activityMessage, $type, $className);
                    } else {
                        return response()->json(['error' => $result['error'], 'code' => 500]);
                    }
                }
            } else {
                $labels = [
                    1 => "First",
                    2 => "Second",
                    3 => "Third",
                    4 => "Fourth",
                    5 => "Fifth",
                    6 => "Sixth",
                    7 => "Seventh",
                    8 => "Eighth",
                    9 => "Ninth",
                    10 => "Tenth"
                ];
                $tableApproval = 'loanapprovals';
                $userId = Auth::user()->id;
                $dataApproval = [
                    'loanId' => $loanId,
                    'userId' => $userId,
                    'approvalType' => $labels[$getApprovalStatus] . " Approval",
                    'approvalStatus' => $approvalStatus,
                    'reason' => $txtApprovalReason
                ];
                $resultInsert = InsertHelper::insertRecord($tableApproval, $dataApproval);

                $tableUpdate = 'loans';
                $data = [
                    'approvalStatus' => 11,
                    'loanStatus' => "Rejected"
                ];
                $result = UpdateHelper::updateRecord($tableUpdate, $loanId, $data);
                if ($result === true && $resultInsert === true) {
                    return response()->json(['success' => 'Loan Approval successfully', 'redirectUrl' => '/dashboard', 'code' => 202]);
                    $activityLogResult = activityLogHelper::activityLog($ipAddress, $location, $country, $activityMessage, $type, $className);
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
