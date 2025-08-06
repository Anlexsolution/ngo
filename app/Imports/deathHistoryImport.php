<?php

namespace App\Imports;

use App\Models\deathtransectionhistory;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class deathHistoryImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        //
        $userId = Auth::user()->id;
        foreach ($rows->skip(1) as $row) {
            $currentTimestamp = Carbon::now();
            $transSavingIdRandom = str_pad(rand(1, 999999999), 12, '0', STR_PAD_LEFT);


            $maxBalance = (float) DB::table('deathtransectionhistories')
                ->where('deathId', $row[0])
                ->where('memberId', $row[2])
                ->orderByDesc('id')
                ->value('balance');

            if ($row[3] < 0) {
                $finalBalance = $maxBalance - $row[3];
                $payAm = abs($row[3]);
                $type = 'Debit';
            } else {
                $finalBalance = $maxBalance + $row[3];
                $type = 'Credit';
                $payAm = $row[3];
            }
            $date = $this->parseExcelDate($row[1]);
            deathtransectionhistory::create([
                'deathId' => $row[0],
                'balance' => $finalBalance,
                'randomId' => $transSavingIdRandom,
                'userId' => $userId,
                'memberId' => $row[2],
                'type' => $type,
                'amount' => $payAm,
                'description' => $row[4],
                'created_at' => $date,
                'updated_at' => $currentTimestamp
            ]);

            $updatedBalance = DB::table('deathsubscriptions')
                ->where('deathId', $row[0])
                ->where('memberId', $row[2])
                ->update(['totalAmount' => $finalBalance]);
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
                return now(); // fallback to current time
            }
        }
    }
}
