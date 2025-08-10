<?php

namespace App\Console\Commands;

use App\Helpers\InsertHelper;
use App\Models\savingtransectionhistory;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class interest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:interest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate and log monthly interest for savings';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('Interest calculation started at ' . now());

        // Fetch active members
        $getMemberData = DB::table('members')->where('status', 1)->get();

        // Get interest setting, default to 0 if none set
        $countData = DB::table('interestsettings')->count();
        $getInterest = 0;
        if ($countData > 0) {
            $getData = DB::table('interestsettings')->first();
            $getInterest = $getData->interest;
        }

        foreach ($getMemberData as $memData) {
            $memUniqueId = $memData->uniqueId;

            // Get savings for the member
            $getSavingData = DB::table('savings')->where('memberId', $memUniqueId)->first();

            if (!$getSavingData) {
                Log::warning("No savings found for member {$memUniqueId}, skipping.");
                continue;
            }

            $getSavingId = $getSavingData->id;

            $transSavIdRandom = str_pad(rand(1, 999999999), 12, '0', STR_PAD_LEFT);

            // Get previous month start and end date
            $startOfPreviousMonth = Carbon::now()->subMonth()->startOfMonth();
            $endOfPreviousMonth = Carbon::now()->subMonth()->endOfMonth();

            // Get last balance record for the saving in previous month
            $lastRecord = savingtransectionhistory::where('savingId', $getSavingId)
                ->whereBetween('created_at', [$startOfPreviousMonth, $endOfPreviousMonth])
                ->orderBy('created_at', 'desc')
                ->first();

            $lastBalance = $lastRecord ? $lastRecord->balance : 0;

            // Calculate monthly interest
            $interestAmount = ($lastBalance * $getInterest) / (100 * 12);
            $newBalance = $lastBalance + $interestAmount;

            $previousMonthYear = Carbon::now()->subMonth()->format('F Y');

            // Check if interest already added for that month
            $checkData = DB::table('savinginterests')
                ->where('savingId', $getSavingId)
                ->where('memberId', $memUniqueId)
                ->where('monthandyear', $previousMonthYear)
                ->count();

            if ($checkData == 0) {
                $table = 'savinginterests';
                $data = [
                    'savingId' => $getSavingId,
                    'balance' => $newBalance,
                    'randomId' => $transSavIdRandom,
                    'userId' => Auth::user()->id ?? 0,
                    'memberId' => $memUniqueId,
                    'type' => 'Credit',
                    'amount' => $interestAmount,
                    'description' => 'Interest for ' . $previousMonthYear,
                    'monthandyear' => $previousMonthYear,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
                $insert = InsertHelper::insertRecord($table, $data);

                if ($insert) {
                    Log::info("Interest of {$interestAmount} added for member {$memUniqueId} for {$previousMonthYear}");
                } else {
                    Log::error("Failed to insert interest for member {$memUniqueId} for {$previousMonthYear}");
                }
            } else {
                Log::info("Interest already exists for member {$memUniqueId} for {$previousMonthYear}, skipping insert.");
            }
        }

        Log::info('Interest calculation finished at ' . now());
    }
}
