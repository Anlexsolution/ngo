<?php

namespace App\Imports;

use App\Models\deathsubscription;
use App\Models\member;
use App\Models\otherincome;
use App\Models\saving;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class memberImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows->skip(1) as $row) {
            $randomNumber = rand(1, 999999999);
            $formattedNumber = str_pad($randomNumber, 9, '0', STR_PAD_LEFT);
            $uniqueId = Str::random(16);
            $currentTimestamp = Carbon::now();

            // Safely parse Excel dates
            $nicIssueDate = $this->parseExcelDate($row[5]);
            $followerIssueDate = $this->parseExcelDate($row[20]);
            $DOB = $this->parseExcelDate($row[21]);

            member::create([
                'title' => $row[0],
                'firstName' => $row[1],
                'lastName' => $row[2],
                'address' => $row[3],
                'nicNumber' => $row[4],
                'nicIssueDate' => $nicIssueDate,
                'newAccountNumber' => $formattedNumber,
                'oldAccountNumber' => $row[6],
                'profession' => $row[7],
                'gender' => $row[8],
                'maritalStatus' => $row[9],
                'phoneNumber' => $row[10],
                'divisionId' => $row[11],
                'villageId' => $row[12],
                'smallGroupStatus' => $row[13],
                'gnDivStatus' => $row[14],
                'gnDivisionId' => $row[15],
                'smallGroupId' => $row[16],
                'followerName' => $row[17],
                'followerAddress' => $row[18],
                'followerNicNumber' => $row[19],
                'followerIssueDate' => $followerIssueDate,
                'dateOfBirth' => $DOB,
                'uniqueId' => $uniqueId,
                'deleted' => 0,
                'smallGroupGNStatus' => $row[14],
                'gnDivisionSmallGroup' => $row[22],
                'subprofession' => $row[23],
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp
            ]);

            $savingsIdRandom = rand(1, 999999999);
            $saving = new saving();
            $saving->memberId = $uniqueId;
            $saving->savingsId = $savingsIdRandom;
            $saving->totalAmount = 0;
            $saving->amount = 0;
            $saving->save();

            $deathIdRandom = rand(1, 999999999);
            $deathsubscription = new deathsubscription();
            $deathsubscription->memberId = $uniqueId;
            $deathsubscription->deathId = $deathIdRandom;
            $deathsubscription->totalAmount = 0;
            $deathsubscription->amount = 0;
            $deathsubscription->save();

            $otherIncomeIdRandom = rand(1, 999999999);
            $otherincome = new otherincome();
            $otherincome->memberId = $uniqueId;
            $otherincome->incomId = $otherIncomeIdRandom;
            $otherincome->totalAmount = 0;
            $otherincome->amount = 0;
            $otherincome->save();
        }
    }

    private function parseExcelDate($value)
    {
        if (is_numeric($value)) {
            return Carbon::instance(Date::excelToDateTimeObject($value))->format('Y-m-d');
        }

        try {
            return Carbon::createFromFormat('m/d/Y', $value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null; // or log error if needed
        }
    }
}
