<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\loan;
use App\Models\member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class receipt_controller extends Controller
{
    function directSavingReceipt($id){
        $getData = DB::table('savingtransectionhistories')->where('randomId', $id)->first();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('receipts.direct_saving_receipts', ['getData' => $getData, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    function repaymentReceipt($id){
        $getData = DB::table('loanrepayments')->where('transectionId', $id)->first();
        $getloanDetails = DB::table('loans')->where('id', $getData->loanId)->first();
        $getmemDetails = DB::table('members')->where('id', $getData->memberId)->first();
        $getmemApproverDetails = DB::table('users')->where('id', $getData->userId)->first();
        $getmemSavDetails = DB::table('savings')->where('memberId', $getmemDetails->uniqueId)->first();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('receipts.repayment_recipet', [ 'getmemSavDetails' => $getmemSavDetails, 'getmemApproverDetails' => $getmemApproverDetails, 'getmemDetails' => $getmemDetails, 'getloanDetails' => $getloanDetails, 'getData' => $getData, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }
}
