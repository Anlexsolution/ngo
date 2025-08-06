<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\deathdonation;
use App\Models\deathsubscription;
use App\Models\division;
use App\Models\divisiondetail;
use App\Models\loan;
use App\Models\loanpurpose;
use App\Models\loanrepayment;
use App\Models\loanschedule;
use App\Models\member;
use App\Models\otherincome;
use App\Models\profession;
use App\Models\subprofession;
use App\Models\saving;
use App\Models\savingtransectionhistory;
use App\Models\smallgroup;
use App\Models\smallgroupdetail;
use App\Models\userRole;
use App\Models\village;
use App\Models\villagedetail;
use Crypt;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class manage_reports_controller extends Controller

{

    function viewMemberSavingReport($id){
        $getUserRole = userRole::all();
        $getSmallGroup = smallgroup::all();
        $getVillage = village::all();
        $getDivision = division::all();
        $getMember = member::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $getSavingData = saving::all();
        $getLoanRepaymentData = loanschedule::all();
        $getDeathSubscription = deathsubscription::all();
        $getDeathDonation = deathdonation::all();
        $getOtherIncome = otherincome::all();
        $getDivisionDetails = divisiondetail::all();
        $getUsers = User::all();
        $getVillageDetails = villagedetail::all();
        $getProfession = profession::all();
        $getSubProfession = subprofession::all();
        $getSmallGroupDetails = smallgroupdetail::all();
        $getLoanRepaymentData = loanschedule::all();
        $getLoanRepaymentData = loanschedule::all();
        $getData = DB::table('accounttransectionhistories')->where('memberId', Crypt::decrypt($id))->get();
        return view( 'pages.permission.reports.view_member_saving_report_per' , compact( 'getData' , 'getUserRole', 'getSmallGroup', 'getVillage', 'getDivision', 'getMember', 'getLoansData', 'getAllMemberData', 'getSavingData', 'getLoanRepaymentData', 'getDeathSubscription', 'getDeathDonation', 'getOtherIncome', 'getDivisionDetails', 'getUsers', 'getVillageDetails', 'getProfession', 'getSubProfession', 'getSmallGroupDetails', 'getLoanRepaymentData', 'getLoanRepaymentData'));
    }

    function groupLeaderReport()
    {
        $getUserRole = userRole::all();
        $getSmallGroup = smallgroup::all();
        $getVillage = village::all();
        $getDivision = division::all();
        $getMember = member::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $getSavingData = saving::all();
        $getLoanRepaymentData = loanschedule::all();
        $getDeathSubscription = deathsubscription::all();
        $getDeathDonation = deathdonation::all();
        $getOtherIncome = otherincome::all();
        $getDivisionDetails = divisiondetail::all();
        $getUsers = User::all();
        $getVillageDetails = villagedetail::all();
        $getSmallGroupDetails = smallgroupdetail::all();
        return view('pages.permission.reports.group_leader_report_per', ['getSmallGroupDetails' => $getSmallGroupDetails, 'getVillageDetails' => $getVillageDetails, 'getUsers' => $getUsers, 'getDivisionDetails' => $getDivisionDetails, 'getOtherIncome' => $getOtherIncome, 'getDeathDonation' => $getDeathDonation, 'getDeathSubscription' => $getDeathSubscription, 'getLoanRepaymentData' => $getLoanRepaymentData, 'getSavingData' => $getSavingData, 'getUserRole' => $getUserRole, 'getSmallGroup' => $getSmallGroup, 'getVillage' => $getVillage, 'getDivision' => $getDivision, 'getMember' => $getMember, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }



    function groupReport()
    {
        $getUserRole = userRole::all();
        $getSmallGroup = smallgroup::all();
        $getVillage = village::all();
        $getDivision = division::all();
        $getMember = member::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $getSavingData = saving::all();
        $getLoanRepaymentData = loanschedule::all();
        $getDeathSubscription = deathsubscription::all();
        $getDeathDonation = deathdonation::all();
        $getOtherIncome = otherincome::all();
        return view('pages.permission.reports.group_report_per', ['getOtherIncome' => $getOtherIncome, 'getDeathDonation' => $getDeathDonation, 'getDeathSubscription' => $getDeathSubscription, 'getLoanRepaymentData' => $getLoanRepaymentData, 'getSavingData' => $getSavingData, 'getUserRole' => $getUserRole, 'getSmallGroup' => $getSmallGroup, 'getVillage' => $getVillage, 'getDivision' => $getDivision, 'getMember' => $getMember, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    function loanArreasReport()
    {
        $getUserRole = userRole::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $getDivision = division::all();
        $getLoanData = DB::table('loans')->where('loanStatus', '=', 'Active')->get();
        $getAllRepaymentData = loanrepayment::all();
        return view('pages.permission.reports.loan_arreas_report_per', ['getAllRepaymentData' => $getAllRepaymentData, 'getLoanData' => $getLoanData, 'getDivision' => $getDivision, 'getUserRole' => $getUserRole, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    function loanReport()
    {
        $getUserRole = userRole::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $getDivision = division::all();
        $getLoanData = DB::table('loans')->where('loanStatus', '=', 'Active')->get();
        $getAllRepaymentData = loanrepayment::all();
        $getLoanPurposeData = loanpurpose::all();
        return view('pages.permission.reports.loan_report_per', [ 'getLoanPurposeData' => $getLoanPurposeData, 'getAllRepaymentData' => $getAllRepaymentData, 'getLoanData' => $getLoanData, 'getDivision' => $getDivision, 'getUserRole' => $getUserRole, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

  public function collectionReport()
{
    $getUserRole = userRole::all();
    $getLoansData = loan::all();
    $getAllMemberData = member::all();
    $getDivision = division::all();
    $getUser = DB::table('users')->where('userType', '=', 'Field Officer')->get();

    // Raw transaction data with joins
    $rawData = DB::table('accounttransectionhistories')
        ->join('users', 'accounttransectionhistories.collectionBy', '=', 'users.id')
        ->join('members', 'accounttransectionhistories.memberId', '=', 'members.id')
        ->join('divisions', 'members.divisionId', '=', 'divisions.id')
        ->join('villages', 'members.villageId', '=', 'villages.id')
        ->join('smallgroups', 'members.smallGroupId', '=', 'smallgroups.id')
        ->select(
            'accounttransectionhistories.*',
            'users.name as collectedBy',
            'members.id as memberId',
            'members.firstName as memberFirstName',
            'members.lastName as memberLastName',
            'members.nicNumber',
            'members.oldAccountNumber',
            'members.divisionId as divisionId',
            'members.villageId as villageId',
            'members.smallGroupId as smallGroupId',
            'divisions.divisionName',
            'villages.villageName',
            'smallgroups.smallGroupName'
        )
        ->orderBy('accounttransectionhistories.repaymentDate', 'desc')
        ->get();

    // Group by member and date
    $groupedData = $rawData->groupBy(function ($item) {
        return $item->memberId . '|' . \Carbon\Carbon::parse($item->repaymentDate)->format('Y-m-d');
    });

    // Map grouped results
    $finalData = $groupedData->map(function ($group) {
        $first = $group->first();

        $totalSaving = $group->filter(fn ($t) => str_contains($t->description, 'Saving'))->sum('amount');
        $totalPrincipal = $group->filter(fn ($t) => str_contains($t->description, 'Loan'))->sum('principalAmount');
        $totalInterest = $group->filter(fn ($t) => str_contains($t->description, 'Loan'))->sum('interest');

        return [
            'collectionDate' => \Carbon\Carbon::parse($first->repaymentDate)->format('Y-m-d'),
            'memberId' => $first->memberId,
            'divisionId' => $first->divisionId,
            'villageId' => $first->villageId,
            'smallGroupId' => $first->smallGroupId,
            'memberFirstName' => $first->memberFirstName,
            'memberLastName' => $first->memberLastName,
            'nicNumber' => $first->nicNumber,
            'oldAccountNumber' => $first->oldAccountNumber,
            'divisionName' => $first->divisionName,
            'villageName' => $first->villageName,
            'smallGroupName' => $first->smallGroupName,
            'collectedBy' => $first->collectedBy,
            'totalSaving' => $totalSaving,
            'totalPrincipal' => $totalPrincipal,
            'totalInterest' => $totalInterest,
            'totalAmount' => $totalSaving + $totalPrincipal + $totalInterest,
            'descriptions' => $group->pluck('description')->unique()->implode(', ')
        ];
    })->values();

    return view('pages.permission.reports.collection_reports_per', [
        'getUser' => $getUser,
        'getDivision' => $getDivision,
        'getUserRole' => $getUserRole,
        'getLoansData' => $getLoansData,
        'getAllMemberData' => $getAllMemberData,
        'getCollectionData' => $finalData,
    ]);
}




    function manageReports()
    {
        $getUserRole = userRole::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.permission.reports.manage_reports_per', ['getUserRole' => $getUserRole, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    function memberReport()
{
    $getUserRole        = userRole::all();
    $getMember          = member::with('division', 'village', 'smallgroup')->get();
    $getDivision        = division::all();
    $getProfession      = profession::all();
    $getSavingData      = saving::all();
    $getLoansData       = loan::all();
    $getAllMemberData   = member::all(); // Optional, if different from $getMember
    $getOtherIncomeData = DB::table('otherincomes')->get();
    $getDeathSubData    = DB::table('deathsubscriptions')->get();
    $savingtransectionhistories = savingtransectionhistory::all();

    return view('pages.permission.reports.member_report_per', [
        'getUserRole'       => $getUserRole,
        'getMember'         => $getMember,
        'getDivision'       => $getDivision,
        'getProfession'     => $getProfession,
        'getSavingData'     => $getSavingData,
        'getLoansData'      => $getLoansData,
        'getAllMemberData'  => $getAllMemberData,
        'getOtherIncomeData'=> $getOtherIncomeData,
        'getDeathSubData'   => $getDeathSubData,
        'savingtransectionhistories' => $savingtransectionhistories,
        // If needed:
        'villages'          => village::all(),
        'smallGroups'       => smallgroup::all(),
    ]);
}



public function memberSavingReport(Request $request)
{
    $year = $request->input('year', now()->year); // Default to current year if not selected

    $getUserRole        = userRole::all();
    $getMember          = member::with('division', 'village', 'smallgroup')->get();
    $getDivision        = division::all();
    $getProfession      = profession::all();
    $getSavingData      = saving::all();
    $getLoansData       = loan::all();
    $getAllMemberData   = member::all(); // Optional
    $getOtherIncomeData = DB::table('otherincomes')->get();
    $getDeathSubData    = DB::table('deathsubscriptions')->get();

    // ✅ Filter by selected year
    $getData = DB::table('savingtransectionhistories')
                ->whereYear('created_at', $year)
                ->get();

    return view('pages.permission.reports.member_savings_report_per', [
        'getUserRole'        => $getUserRole,
        'getMember'          => $getMember,
        'getDivision'        => $getDivision,
        'getProfession'      => $getProfession,
        'getSavingData'      => $getSavingData,
        'getLoansData'       => $getLoansData,
        'getAllMemberData'   => $getAllMemberData,
        'getOtherIncomeData' => $getOtherIncomeData,
        'getDeathSubData'    => $getDeathSubData,
        'getData'            => $getData,
        'villages'           => village::all(),
        'smallGroups'        => smallgroup::all(),
        'selectedYear'       => $year, // Optional: to show in view
    ]);
}



    function openingBalanceReport()
    {
        $getUserRole = userRole::all();
        $getMember = member::all();
        $getDivision = division::all();
        $getProfession = profession::all();
        $getsavings = saving::all();
        $villages = [];
        $smallGroups = [];
        $getMember = member::with('division', 'village', 'smallgroup')->get();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.permission.reports.opening_balance_report_per', ['getUserRole' => $getUserRole, 'getMember' => $getMember, 'getDivision' => $getDivision,  'villages' => $villages,  'smallGroups' => $smallGroups, 'getProfession' => $getProfession, 'getsavings' => $getsavings, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }
}
