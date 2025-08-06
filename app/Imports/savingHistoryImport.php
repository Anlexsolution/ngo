<?php

namespace App\Imports;

use App\Models\savingtransectionhistory;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class savingHistoryImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $userId = Auth::user()->id;

        // Step 1: Parse and group data by member+savingId+month
        $monthlyGroups = [];

        foreach ($rows->skip(1) as $row) {
            $date = $this->parseExcelDate($row[1]);
            $monthKey = $date->format('Y-m');
            $savingId = $row[0];
            $memberId = $row[2];

            $groupKey = "$savingId-$memberId-$monthKey";

            $monthlyGroups[$groupKey][] = [
                'row' => $row,
                'date' => $date
            ];
        }

        // Step 2: Loop through each group and process
        foreach ($monthlyGroups as $groupKey => $transactions) {
            usort($transactions, fn($a, $b) => $a['date']->timestamp <=> $b['date']->timestamp); // sort by date

            $savingId = $transactions[0]['row'][0];
            $memberId = $transactions[0]['row'][2];
            $lastBalance = (float) DB::table('savingtransectionhistories')
                ->where('savingId', $savingId)
                ->where('memberId', $memberId)
                ->orderByDesc('id')
                ->value('balance');

            foreach ($transactions as $index => $entry) {
                $row = $entry['row'];
                $date = $entry['date'];

                $transSavingIdRandom = str_pad(rand(1, 999999999), 12, '0', STR_PAD_LEFT);

                $amount = $row[3];
                if ($amount < 0) {
                    $finalBalance = $lastBalance + $amount; // add negative value (effectively subtract)
                    $type = 'Debit';
                    $payAm = abs($amount); // positive value stored in DB
                } else {
                    $finalBalance = $lastBalance + $amount;
                    $type = 'Credit';
                    $payAm = $amount;
                }

                // Insert actual transaction
                savingtransectionhistory::create([
                    'savingId' => $savingId,
                    'memberId' => $memberId,
                    'balance' => $finalBalance,
                    'randomId' => $transSavingIdRandom,
                    'userId' => $userId,
                    'type' => $type,
                    'amount' => $payAm,
                    'description' => $row[4],
                    'created_at' => $date,
                    'updated_at' => now(),
                ]);

                $lastBalance = $finalBalance; // update for next round

                // Update current savings table
                DB::table('savings')
                    ->where('savingsId', $savingId)
                    ->where('memberId', $memberId)
                    ->update(['totalAmount' => $finalBalance]);

                // After last transaction in the month → insert interest
                $getInterest = DB::table('interestsettings')->first();
                $getInterestData = $getInterest->interest;
                $finalInterest = $getInterestData / 100;
                if ($index === count($transactions) - 1) {
                    $interestAmount = round($lastBalance * $finalInterest, 2);
                    $lastDate = $date->copy()->endOfMonth();

                    $interestRandomId = str_pad(rand(1, 999999999), 12, '0', STR_PAD_LEFT);

                    savingtransectionhistory::create([
                        'savingId' => $savingId,
                        'memberId' => $memberId,
                        'balance' => $lastBalance + $interestAmount,
                        'randomId' => $interestRandomId,
                        'userId' => $userId,
                        'type' => 'Credit',
                        'amount' => $interestAmount,
                        'description' => 'Interest for ' . $date->format('F Y'),
                        'created_at' => $lastDate,
                        'updated_at' => now(),
                    ]);

                    // Update balance after interest
                    DB::table('savings')
                        ->where('savingsId', $savingId)
                        ->where('memberId', $memberId)
                        ->update(['totalAmount' => $lastBalance + $interestAmount]);

                    // Update lastBalance for next group
                    $lastBalance += $interestAmount;
                }
            }
        }
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
                return now(); // fallback
            }
        }
    }
}
