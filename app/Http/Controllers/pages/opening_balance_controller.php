<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\deathsubscription;
use App\Models\deathtransectionhistory;
use App\Models\loan;
use App\Models\member;
use App\Models\saving;
use App\Models\savingtransectionhistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class opening_balance_controller extends Controller
{
    function openingBalance()
    {
        $memberGet = member::all();
        $getSavings = saving::with('member')->get();
        $savingsData = DB::table('savings')
            ->where('amount', 0)
            ->get();
        $deathData = DB::table('deathsubscriptions')
            ->where('amount', 0)
            ->get();
            $getLoansData = loan::all();
            $getAllMemberData = member::all();
        return view('pages.permission.openingbalance.opening_balance_per', ['savingsData' => $savingsData, 'memberGet' => $memberGet, 'getSavings' => $getSavings, 'deathData' => $deathData, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    public function saveOpeningBalance(Request $request)
    {
        try {

            $savingData = json_decode($request->input('allField'), true);

            $allFieldDeath = json_decode($request->input('allFieldDeath'), true);

            foreach ($savingData as $data) {
                if (!isset($data['id']) || !isset($data['value'])) {
                    return response()->json([
                        'error' => 'Invalid data format',
                        'code' => 422,
                    ]);
                }

                $id = $data['id'];
                $value = $data['value'];

                $saving = Saving::find($id);

                if (!$saving) {
                    return response()->json([
                        'error' => "Record with ID $id not found",
                        'code' => 404,
                    ]);
                }

                // Update the totalAmount
                $saving->totalAmount = $value;
                $saving->amount = $value;
                $saving->save();

                $getSaving = Saving::find($id)->first();
                $balance = $getSaving->totalAmount;

                if ($value > 0) {
                    $userId = Auth::user()->id;
                    $transIdRandom = str_pad(rand(1, 999999999), 12, '0', STR_PAD_LEFT);
                    $savingtransectionhistory = new savingtransectionhistory();
                    $savingtransectionhistory->savingId = $saving->savingsId;
                    $savingtransectionhistory->randomId = $transIdRandom;
                    $savingtransectionhistory->userId = $userId;
                    $savingtransectionhistory->balance = $value;
                    $savingtransectionhistory->memberId = $saving->memberId;
                    $savingtransectionhistory->amount = $value;
                    $savingtransectionhistory->type = 'Credit';
                    $savingtransectionhistory->description = 'opening amount';
                    $savingtransectionhistory->save();
                }
            }

            foreach ($allFieldDeath as $data) {
                if (!isset($data['id']) || !isset($data['value'])) {
                    return response()->json([
                        'error' => 'Invalid data format',
                        'code' => 422,
                    ]);
                }

                $id = $data['id'];
                $value = $data['value'];

                $death = deathsubscription::find($id);

                if (!$death) {
                    return response()->json([
                        'error' => "Record with ID $id not found",
                        'code' => 404,
                    ]);
                }

                $death->totalAmount = $value;
                $death->amount = $value;
                $death->save();

                $getDeath = deathsubscription::find($id)->first();
                $balanceDeath = $getDeath->totalAmount;
                if ($value > 0) {
                    $userId = Auth::user()->id;
                    $transDeathIdRandom = str_pad(rand(1, 999999999), 12, '0', STR_PAD_LEFT);
                    $deathtransectionhistory = new deathtransectionhistory();
                    $deathtransectionhistory->deathId = $death->deathId;
                    $deathtransectionhistory->memberId = $death->memberId;
                    $deathtransectionhistory->randomId = $transDeathIdRandom;
                    $deathtransectionhistory->userId = $userId;
                    $deathtransectionhistory->balance = $value;
                    $deathtransectionhistory->amount = $value;
                    $deathtransectionhistory->type = 'Credit';
                    $deathtransectionhistory->description = 'opening amount';
                    $deathtransectionhistory->save();
                }
            }

            return response()->json(['success' => true, 'code' => 200]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Validation error: ' . $e->getMessage(),
                'code' => 422,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'error' => 'Database error: ' . $e->getMessage(),
                'code' => 500,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred: ' . $e->getMessage(),
                'code' => 500,
            ]);
        }
    }
}
