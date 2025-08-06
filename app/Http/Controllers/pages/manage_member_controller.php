<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\deathtransectionhistory;
use Illuminate\Http\Request;
use App\Models\userRole;
use App\Models\member;
use App\Models\division;
use App\Models\gndivision;
use App\Models\gndivisionsmallgroup;
use App\Models\loan;
use App\Models\loanproduct;
use App\Models\loanpurpose;
use App\Models\loanrepayment;
use App\Models\loanschedule;
use App\Models\memberdocument;
use App\Models\profession;
use App\Models\saving;
use App\Models\savinginterest;
use App\Models\savingtransectionhistory;
use App\Models\smallgroup;
use App\Models\subprofession;
use App\Models\village;
use App\Models\withdrawalhistory;
use Crypt;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\DB;

class manage_member_controller extends Controller
{

        public function viewDeathHisMem($id)
    {
        $decId = decrypt($id);
        $getUser = User::all();
        $getUserRole = userRole::all();
        $getDeathHistory = deathtransectionhistory::where('deathId', $decId)->get();
        $getMember = member::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $getDeathData = DB::table('deathsubscriptions')->where('deathId', $decId)->first();
        $getMemId = $getDeathData->memberId;
        $getMemberData = DB::table('members')->where('uniqueId', $getMemId)->first();
        $memberId =  $getMemberData->id;
        return view('pages.permission.memberlogin.view_death_history_mem_per', ['memberId' => $memberId, 'getUser' => $getUser, 'getUserRole' => $getUserRole, 'getDeathHistory' => $getDeathHistory, 'getMember' => $getMember, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

        function viewLoanDetailsMem($id)
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
        return view('pages.permission.memberlogin.view_loan_details_mem_per', ['getRepaymentDetails' => $getRepaymentDetails, 'getAllUser' => $getAllUser, 'getLoanApproval' => $getLoanApproval, 'getLoanOfficer' => $getLoanOfficer, 'getMember' => $getMember, 'loanDetails' => $loanDetails, 'getUserRole' => $getUserRole, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData, 'getScheduleData' => $getScheduleData]);
    }

        public function viewSavHisMem($id)
    {
        $decId = decrypt($id);
        $getUserRole = userRole::all();
        $getSavingHistory = savingtransectionhistory::where('savingId', $decId)->get();
        $getmemuniId = DB::table('savings')->where('savingsId', $decId)->first();
        $getmemberUniqueId = $getmemuniId->memberId;
        $getmem = DB::table('members')->where('uniqueId', $getmemberUniqueId)->first();
        $getMemberId = $getmem->id;
        $getUser = User::all();
        $getMember = member::with('division', 'village', 'smallgroup')->get();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $geInterData = savinginterest::where('savingId', $decId)->get();
        $getSIdData = saving::where('savingsId', $decId)->first();
        $getSavId = $getSIdData->id;
        $getWithHisData = withdrawalhistory::where('savingId', $getSavId)->get();
        return view('pages.permission.memberlogin.view_saving_history_mem_per', ['getWithHisData' => $getWithHisData,  'geInterData' => $geInterData, 'memberUniqueId' => $getmem->uniqueId,  'memberId' => $getMemberId, 'getUser' => $getUser, 'getUserRole' => $getUserRole, 'getSavingHistory' => $getSavingHistory, 'getMember' => $getMember, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    function manageMember()
    {
        $getUserRole = userRole::all();
        $getMember = member::all();
        $getDivision = division::all();
        $getProfession = profession::all();
        $villages = [];
        $smallGroups = [];
        $getMember = member::with('division', 'village', 'smallgroup')->get();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.manage_member_per', ['getUserRole' => $getUserRole, 'getMember' => $getMember, 'getDivision' => $getDivision,  'villages' => $villages,  'smallGroups' => $smallGroups, 'getProfession' => $getProfession, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    function viewMember($id)
    {
        $memberId = decrypt($id);
        $getUserRole = userRole::all();
        $getMember = member::all();
        $getData = DB::table('loans')->where('createStatus', 1)->where('memberId', $memberId)->get();
        $getDataActive = DB::table('loans')->where('createStatus', 1)->where('memberId', $memberId)->where('loanStatus', 'Active')->get();
        $getMemberId = member::find($memberId);
        $getMemberDocument = DB::table('memberdocuments')->where('memberId', $memberId)->get();
        $getMemberNotes = DB::table('membernotes')->where('memberId', $memberId)->get();

        $getLoanPurpose = loanpurpose::all();

        $getLoansData = DB::table('loans')->where('memberId', $memberId)->get();

        $getSavings = DB::table('savings')->where('memberId', $getMemberId->uniqueId)->first();
        $getDeath = DB::table('deathsubscriptions')->where('memberId', $getMemberId->uniqueId)->first();
        $member = member::with('division', 'village', 'smallgroup')->find($memberId);
        $getAllMemberData = member::all();
        $getproduct = loanproduct::all();
        $getMemberData = DB::table('members')->where('id', $memberId)->first();
        $getMemberId = $getMemberData->uniqueId;

        $savingData = DB::table('savings')->where('memberId', $getMemberId)->first();
        if($savingData) {
            $totalSavAM = $savingData->totalAmount;
            $totalSavAM = number_format($totalSavAM, 2);
        } else {
            $totalSavAM = 0;
        }

        $deathData = DB::table('deathsubscriptions')->where('memberId', $getMemberId)->first();
        if($deathData) {
            $totalDeathAM = $deathData->totalAmount;
            $totalDeathAM = number_format($totalDeathAM, 2);
        } else {
            $totalDeathAM = 0;
        }

        $otherData = DB::table('otherincomes')->where('memberId', $getMemberId)->first();
        if($otherData) {
            $totalOtherAM = $otherData->totalAmount;
            $totalOtherAM = number_format($totalOtherAM, 2);
        } else {
            $totalOtherAM = 0;
        }

        $getLoanDataall = DB::table('loans')->where('memberId', $memberId)->where('loanStatus', 'Active')->get();
        $totalLoanAM = 0;
        $loanArreas =  0;
        foreach ($getLoanDataall as $loanData) {
            $loanAm = $loanData->principal;
            $getLoanId = $loanData->id;
            $totalLoanAM += $loanAm;

            $balances = DB::table('loanschedules')
                ->where('loanId', $getLoanId)
                ->where('status', 'unPaid')
                ->pluck('balance') // Only get the 'balance' column
                ->map(function ($balance) {
                    return floatval(str_replace(',', '', $balance));
                });

            $maxBalance = $balances->max();
            $loanArreas += $maxBalance;
        }
        $finalTotalLoanAM = number_format($totalLoanAM, 2);
        $finalArreas = number_format($loanArreas, 2);

        $getGurDetails = DB::table('loans')->where('gurrantos', $memberId)->get();

        $getFinalGur = DB::table('loans')->where('memberId', $memberId)->get();
        $getLoanScheduleData = loanschedule::all();

        $getRepaymentData = loanrepayment::all();

        $getGnDivision = gndivision::all();
        $gndivisionSmallgroup = gndivisionsmallgroup::all();

        $getPro = profession::all();
        $getSubPro = subprofession::all();
        $getAllUser = User::all();

        return view('pages.view_member_per', [ 'getFinalGur' => $getFinalGur, 'getAllUser' => $getAllUser, 'getSubPro' => $getSubPro, 'getPro' => $getPro, 'gndivisionSmallgroup' => $gndivisionSmallgroup, 'getGnDivision' => $getGnDivision, 'getRepaymentData' => $getRepaymentData, 'getDataActive' => $getDataActive, 'getLoanScheduleData' => $getLoanScheduleData, 'getLoanPurpose' => $getLoanPurpose, 'getGurDetails' => $getGurDetails, 'totalOtherAM' => $totalOtherAM, 'totalDeathAM' => $totalDeathAM, 'totalSavAM' => $totalSavAM, 'finalArreas' => $finalArreas, 'finalTotalLoanAM' => $finalTotalLoanAM, 'getMemberData' => $getMemberData, 'memberId' => $memberId, 'getproduct' => $getproduct, 'getData' => $getData, 'getMemberNotes' => $getMemberNotes, 'getMemberDocument' => $getMemberDocument, 'getUserRole' => $getUserRole, 'getMember' => $getMember, 'member' => $member, 'getSavings' => $getSavings, 'getDeath' => $getDeath, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    function showMember($id)
    {
        $memberId = decrypt($id);
        $getUserRole = userRole::all();
        $getMember = member::all();
        $getData = DB::table('loans')->where('createStatus', 1)->where('memberId', $memberId)->get();
        $getDataActive = DB::table('loans')->where('createStatus', 1)->where('memberId', $memberId)->where('loanStatus', 'Active')->get();
        $getMemberId = member::find($memberId);
        $getMemberDocument = DB::table('memberdocuments')->where('memberId', $memberId)->get();
        $getMemberNotes = DB::table('membernotes')->where('memberId', $memberId)->get();

        $getLoanPurpose = loanpurpose::all();

        $getLoansData = DB::table('loans')->where('memberId', $memberId)->get();

        $getSavings = DB::table('savings')->where('memberId', $getMemberId->uniqueId)->first();
        $getDeath = DB::table('deathsubscriptions')->where('memberId', $getMemberId->uniqueId)->first();
        $member = member::with('division', 'village', 'smallgroup')->find($memberId);
        $getAllMemberData = member::all();
        $getproduct = loanproduct::all();
        $getMemberData = DB::table('members')->where('id', $memberId)->first();
        $getMemberId = $getMemberData->uniqueId;

        $savingData = DB::table('savings')->where('memberId', $getMemberId)->first();
        if($savingData) {
            $totalSavAM = $savingData->totalAmount;
            $totalSavAM = number_format($totalSavAM, 2);
        } else {
            $totalSavAM = 0;
        }

        $deathData = DB::table('deathsubscriptions')->where('memberId', $getMemberId)->first();
        if($deathData) {
            $totalDeathAM = $deathData->totalAmount;
            $totalDeathAM = number_format($totalDeathAM, 2);
        } else {
            $totalDeathAM = 0;
        }

        $otherData = DB::table('otherincomes')->where('memberId', $getMemberId)->first();
        if($otherData) {
            $totalOtherAM = $otherData->totalAmount;
            $totalOtherAM = number_format($totalOtherAM, 2);
        } else {
            $totalOtherAM = 0;
        }

        $getLoanDataall = DB::table('loans')->where('memberId', $memberId)->where('loanStatus', 'Active')->get();
        $totalLoanAM = 0;
        $loanArreas =  0;
        foreach ($getLoanDataall as $loanData) {
            $loanAm = $loanData->principal;
            $getLoanId = $loanData->id;
            $totalLoanAM += $loanAm;

            $balances = DB::table('loanschedules')
                ->where('loanId', $getLoanId)
                ->where('status', 'unPaid')
                ->pluck('balance') // Only get the 'balance' column
                ->map(function ($balance) {
                    return floatval(str_replace(',', '', $balance));
                });

            $maxBalance = $balances->max();
            $loanArreas += $maxBalance;
        }
        $finalTotalLoanAM = number_format($totalLoanAM, 2);
        $finalArreas = number_format($loanArreas, 2);

        $getGurDetails = DB::table('loans')->where('gurrantos', $memberId)->get();

        $getFinalGur = DB::table('loans')->where('memberId', $memberId)->get();
        $getLoanScheduleData = loanschedule::all();

        $getRepaymentData = loanrepayment::all();

        $getGnDivision = gndivision::all();
        $gndivisionSmallgroup = gndivisionsmallgroup::all();

        $getPro = profession::all();
        $getSubPro = subprofession::all();
        $getAllUser = User::all();

        return view('pages.permission.memberlogin.show_member_per', [ 'getFinalGur' => $getFinalGur, 'getAllUser' => $getAllUser, 'getSubPro' => $getSubPro, 'getPro' => $getPro, 'gndivisionSmallgroup' => $gndivisionSmallgroup, 'getGnDivision' => $getGnDivision, 'getRepaymentData' => $getRepaymentData, 'getDataActive' => $getDataActive, 'getLoanScheduleData' => $getLoanScheduleData, 'getLoanPurpose' => $getLoanPurpose, 'getGurDetails' => $getGurDetails, 'totalOtherAM' => $totalOtherAM, 'totalDeathAM' => $totalDeathAM, 'totalSavAM' => $totalSavAM, 'finalArreas' => $finalArreas, 'finalTotalLoanAM' => $finalTotalLoanAM, 'getMemberData' => $getMemberData, 'memberId' => $memberId, 'getproduct' => $getproduct, 'getData' => $getData, 'getMemberNotes' => $getMemberNotes, 'getMemberDocument' => $getMemberDocument, 'getUserRole' => $getUserRole, 'getMember' => $getMember, 'member' => $member, 'getSavings' => $getSavings, 'getDeath' => $getDeath, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    function updateMember($id)
    {
        $memberId = decrypt($id);
        $getUserRole = userRole::all();
        $member = member::find($memberId);
        $getDivision = division::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.update_member_per', ['getUserRole' => $getUserRole, 'member' => $member, 'getDivision' => $getDivision, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    function deletemember($id)
    {
        $member = member::findOrFail($id);
        $member->delete();
        return redirect()->back()->with('success', 'Member Deleted Successfully');
    }

    public function filterMembersByDivision(Request $request)
    {
        $divisionId = $request->get('divisionId');

        if ($divisionId) {
            $members = member::where('divisionId', $divisionId)->get();
        } else {
            $members = member::all();
        }

        $getDivision = division::all();
        $getUserRole = userRole::all();
        $villages = village::where('divisionId', $divisionId)->get();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.manage_member_per', ['getUserRole' => $getUserRole, 'getMember' => $members, 'getDivision' => $getDivision, 'villages' => $villages, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    public function filterMembersByVillage(Request $request)
    {
        $divisionId = $request->get('divisionId');
        $villageId = $request->get('villageId');
        $smallGroupId = $request->get('smallGroupId');
        $professionName = $request->get('professionName');

        // Apply filters based on division, village, and small group
        $query = member::query();

        if ($divisionId) {
            $query->where('divisionId', $divisionId);
        }

        if ($villageId) {
            $query->where('villageId', $villageId);
        }

        if ($smallGroupId) {
            $query->where('smallGroupId', $smallGroupId);
        }
        if ($professionName) {
            $query->where('profession', $professionName);
        }

        // Get the filtered members
        $members = $query->get();

        // Fetch all divisions and villages (depending on selected division)
        $getDivision = division::all();
        $getUserRole = userRole::all();
        $getProfession = profession::all();

        // Fetch villages and small groups based on the selected division and village
        $villages = $divisionId ? village::where('divisionId', $divisionId)->get() : collect();
        $smallGroups = $villageId ? smallgroup::where('villageId', $villageId)->get() : collect();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.manage_member_per', [
            'getUserRole' => $getUserRole,
            'getMember' => $members,
            'getDivision' => $getDivision,
            'villages' => $villages,
            'smallGroups' => $smallGroups,
            'getProfession' => $getProfession,
            'getLoansData' => $getLoansData,
            'getAllMemberData' => $getAllMemberData
        ]);
    }
}
