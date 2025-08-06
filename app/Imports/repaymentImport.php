<?php

namespace App\Imports;

use App\Helpers\InsertHelper;
use App\Helpers\UpdateHelper;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Illuminate\Support\Str;

class repaymentImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        $userId = Auth::user()->id;
        foreach ($rows->skip(1) as $row) {
            $currentTimestamp = Carbon::now();
            $transSavingIdRandom = str_pad(rand(1, 999999999), 12, '0', STR_PAD_LEFT);

            $loanId = $row[0];
            $repaymentDate = $this->parseExcelDate($row[1]);
            $repaymentAmount = $row[2];
            $memberId = $row[3];
            $savingAmount = $row[4];

            $getLoanData = DB::table('loans')->where('loanId', $loanId)->first();
            if (!$getLoanData) {
                continue; // or log error and continue with next row
            }
            $getLoanId = $getLoanData->id;



            $getMemberData = DB::table('members')->where('uniqueId', $memberId)->first();
            $getMemberId = $getMemberData->id;

            $getREpaymentData = $this->getRepaymentData($getLoanId);
            $lastLoanBalance = $getREpaymentData['lastLoanBalance'];
            $interest = $getREpaymentData['interest'];
            $principalAmount = $getREpaymentData['principalPayment'];
            $days = $getREpaymentData['days'];
            $totalPay = $getREpaymentData['totalPay'];
            $balancePay = $getREpaymentData['balancePay'];
            if (!$getLoanData || !$getMemberData || !$getREpaymentData) {
                continue; // skip this row
            }
            $insertData = $this->insertRepaymentData($interest, $principalAmount, $totalPay, $balancePay, $days, $lastLoanBalance, $getMemberId, $getLoanId, $repaymentAmount, $savingAmount, $repaymentDate);
        }
    }



    private function getRepaymentData($loanId)
    {
        $txtLoan = $loanId;
        $getLoans = DB::table('loans')->where('id', $txtLoan)->first();

        $getLoanRepaymentCount = DB::table('loanrepayments')->where('loanId', $txtLoan)->count();

        function calculateOneTimePayment($loanAmount, $annualInterestRate, $startDate, $endDate, $prinAmount, $loanfinalAm)
        {
            // Convert annual interest rate to daily interest rate
            $dailyInterestRate = ($annualInterestRate / 100) / 365;

            // Calculate number of days between start and end date
            $start = new DateTime($startDate);
            $end = new DateTime($endDate);
            $daysBetween = $start->diff($end)->days; // Get difference in days

            // Calculate interest for the given period
            $interest = $loanAmount * $dailyInterestRate * $daysBetween;
            $balancePay = $loanAmount - $prinAmount;
            // Total repayment is just the interest (assuming no principal payment)
            $totalRepayment = $interest;

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
            $endDate = date('Y-m-d');
            $getPrincipalData = DB::table('loanschedules')
                ->where('loanId', $txtLoan)
                ->offset(2)
                ->limit(1)
                ->first();
            $principalPayment = $getPrincipalData->principalPayment;
            $interestRate = $getLoans->interestRate;
            $oneTimePayment = calculateOneTimePayment($lastMinBalanceRow->lastLoanBalance, $interestRate, $lastMinBalanceRow->repaymentDate, $endDate, $principalPayment, $principal);
            $days = $oneTimePayment['days_between'];
            $payDate = $oneTimePayment['end_date'];
            $interest = $oneTimePayment['interest'];
            $balancePay = $oneTimePayment['balancePay'];
            $loanAmount =  $oneTimePayment['loanFinalAm'];
            $totalPay = $interest + $principalPayment;
            $totalPay = $totalPay;

            $repaymentData = [
                'loanId' => $txtLoan,
                'repaymentDate' => $payDate,
                'lastLoanBalance' => $loanAmount,
                'days' => $days,
                'interest' => $interest,
                'balancePay' => $balancePay,
                'totalPay' => $totalPay,
                'principalPayment' => $principalPayment,
            ];
            return $repaymentData;
        }else{
            $principal = $getLoans->principal;
            $lastMinBalanceRow = DB::table('loanrepayments')
                ->where('loanId', $txtLoan)
                ->orderBy('lastLoanBalance', 'asc')
                ->first();
            $endDate = date('Y-m-d');
            $getPrincipalData = DB::table('loanschedules')
                ->where('loanId', $txtLoan)
                ->offset(2)
                ->limit(1)
                ->first();
            $principalPayment = $getPrincipalData->principalPayment;
            $interestRate = $getLoans->interestRate;
            $oneTimePayment = calculateOneTimePayment($lastMinBalanceRow->lastLoanBalance, $interestRate, $lastMinBalanceRow->repaymentDate, $endDate, $principalPayment, $principal);
            $days = $oneTimePayment['days_between'];
            $payDate = $oneTimePayment['end_date'];
            $interest = $oneTimePayment['interest'];
            $balancePay = $oneTimePayment['balancePay'];
            $loanAmount =  $oneTimePayment['loanFinalAm'];
            $totalPay = $interest + $principalPayment;
            $totalPay = $totalPay;
            $repaymentData = [
                'loanId' => $txtLoan,
                'repaymentDate' => $payDate,
                'lastLoanBalance' => $loanAmount,
                'days' => $days,
                'interest' => $interest,
                'balancePay' => $balancePay,
                'totalPay' => $totalPay,
                'principalPayment' => $principalPayment,
            ];
            return $repaymentData;
        }
    }

    function insertRepaymentData($interest, $principalAmount, $totalPay, $balancePay, $days, $loanAmount, $member, $loan, $paymentAmount, $savingAmount, $repaymentDate)
    {
        $txtInterestPay = round((float)$interest, 2);
        $txtprincipalPayment = round((float)$principalAmount, 2);
        $txttotalPay = round((float)$totalPay, 2);
        $txtbalancePay = round((float)$balancePay, 2);
        $txtdays = $days;
        $txtloanAmount = round((float)$loanAmount, 2);
        $txtMember = $member;
        $txtLoan = $loan;

        $txtPaymentAmount = round((float)$paymentAmount, 2);
        $getFinalPay = $txtPaymentAmount - $txtInterestPay;
        $totalAm = $txtprincipalPayment + $txtbalancePay;
        $getfinalBalance = $totalAm - $getFinalPay;

        if ($savingAmount == '') {
            $txtSavingAmount = 0;
        } else {
            $txtSavingAmount = round((float)$savingAmount, 2);
        }

        $getMemData = DB::table('members')->where('id', $txtMember)->first();
        $getUniqueId = $getMemData->uniqueId;

        $getSavData = DB::table('savings')->where('memberId', $getUniqueId)->first();
        $getSavBalance = $getSavData->totalAmount;
        $getSavId = $getSavData->id;
        $getSavIdUnique = $getSavData->savingsId;
        $totalSavingAmount = $txtSavingAmount + $getSavBalance;

        $upTable = 'savings';
        $dataUp = [
            'totalAmount' => $totalSavingAmount,
        ];

        $savHis = 'savingtransectionhistories';
        $userId = Auth::user()->id;
        $transDeathIdRandom = str_pad(rand(1, 999999999), 12, '0', STR_PAD_LEFT);
        $dataHistory = [
            'memberId' => $getUniqueId,
            'savingId' => $getSavIdUnique,
            'userId' => $userId,
            'balance' => $totalSavingAmount,
            'randomId' => $transDeathIdRandom,
            'type' => 'Credit',
            'amount' => $txtSavingAmount,
            'description' => 'Repayment Saving Amount'
        ];


        $getLoanData = DB::table('loans')->where('id', $txtLoan)->first();
        $getLoanId = $getLoanData->loanId;

        $randomNumber = Str::random(12);
        $randomNumber = substr(str_shuffle('0123456789'), 0, 12);

        $userId = Auth::user()->id;

        $table = 'loanrepayments';
        $data = [
            'loanId' => $txtLoan,
            'repaymentDate' => $repaymentDate,
            'repaymentAmount' => $txtPaymentAmount,
            'lastLoanBalance' => $getfinalBalance,
            'interest' => $txtInterestPay,
            'principalAmount' => $getFinalPay,
            'memberId' => $txtMember,
            'transectionId' => $randomNumber,
            'userId' => $userId,
            'days' => $txtdays,
            'savingAmount' => $txtSavingAmount
        ];

        $getAccountCount = DB::table('accountsettings')->count();

        if ($getAccountCount == 0) {
            return response()->json(['error' => 'Please select the default collection account in settings', 'code' => 500]);
        } else {
            $insertData = InsertHelper::insertRecord($savHis, $dataHistory);
            $updateSav = UpdateHelper::updateRecord($upTable, $getSavId, $dataUp);
            $result = InsertHelper::insertRecord($table, $data);
            if ($result === true) {

                $getAccount = DB::table('accountsettings')->first();
                $accountId = $getAccount->accountId;
                $getAccData = DB::table('accounts')->where('id', $accountId)->first();
                $getBal = $getAccData->balance;
                if ($getBal == '') {
                    $getBal = 0;
                } else {
                    $getBal = $getBal;
                }
                $totalBal = $getBal + $txtPaymentAmount + $txtSavingAmount;
                $upBal = [
                    'balance' => $totalBal
                ];
                UpdateHelper::updateRecord('accounts', $accountId, $upBal);

                //Add history
                $historyTable = 'accounttransectionhistories';
                $hisData  = [
                    'collectionBy' => $userId,
                    'memberId' => $txtMember,
                    'amount' => $txtPaymentAmount,
                    'accountId' => $accountId,
                    'description' => 'Loan Repayment',
                    'status' => 'Credit'
                ];
                InsertHelper::insertRecord($historyTable, $hisData);

                if ($txtSavingAmount != '' || $txtSavingAmount != 0) {
                    $hisDataNew  = [
                        'collectionBy' => $userId,
                        'memberId' => $txtMember,
                        'amount' => $txtSavingAmount,
                        'accountId' => $accountId,
                        'description' => 'Saving Amount',
                        'status' => 'Credit'
                    ];
                    InsertHelper::insertRecord($historyTable, $hisDataNew);
                }
                //Add history


                $getLoanSch = DB::table('loanschedules')->where('loanId', $txtLoan)->get();
                foreach ($getLoanSch as $sch) {
                    if ($sch->balance > $getfinalBalance) {
                        $tables = 'loanschedules';
                        $datas = [
                            'status' => 'paid'
                        ];
                        $schId = $sch->id;
                        $updateSch = UpdateHelper::updateRecord($tables, $schId, $datas);
                    }
                }
            }
        }
        return response()->json(['success' => 'Loan Repayment Successfully', 'code' => 200]);
    }


    private function parseExcelDate($value)
    {
        if (is_numeric($value)) {
            return Carbon::instance(ExcelDate::excelToDateTimeObject($value));
        }

        try {
            return Carbon::createFromFormat('m/d/Y H:i:s', $value);
        } catch (\Exception $e1) {
            try {
                return Carbon::createFromFormat('m/d/Y', $value)->startOfDay();
            } catch (\Exception $e2) {
                return now(); // fallback to current time
            }
        }
    }
}
