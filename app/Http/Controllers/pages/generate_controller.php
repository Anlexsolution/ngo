<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\accounttransectionhistory;
use App\Models\collectiondeposit;
use Illuminate\Http\Request;
use App\Models\userRole;
use App\Models\division;
use App\Models\smallgroup;
use App\Models\member;
use Illuminate\Support\str;
use App\Models\saving;
use App\Models\deathsubscription;
use App\Models\deathtransectionhistory;
use App\Models\gndivision;
use App\Models\gndivisionsmallgroup;
use App\Models\importfun;
use App\Models\loan;
use App\Models\loanproduct;
use App\Models\loanpurpose;
use App\Models\loanpurposesub;
use App\Models\loanrepayment;
use App\Models\loanrequest;
use App\Models\loanschedule;
use App\Models\otherincome;
use App\Models\profession;
use App\Models\withdrawal;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\DB;

class generate_controller extends Controller
{

public function exportMemberPdf(Request $request)
{
    $rows = json_decode($request->input('rows'), true);
    $title = $request->input('title', 'Member Report');
    $headers = json_decode($request->input('headers'), true);  // decode headers

    $pdf = Pdf::loadView('pages.pdfgenerate.member_report', [
        'rows' => $rows,
        'title' => $title,
        'headers' => $headers,
    ])->setPaper('a4', 'landscape');

    return $pdf->download('member-report.pdf');
}

    public function viewPdfLoanArreas()
    {
        $getUserRole = userRole::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $getDivision = division::all();
        $getLoanData = DB::table('loans')->where('loanStatus', '=', 'Active')->get();
        $getAllRepaymentData = loanrepayment::all();
        $pdf = Pdf::loadView('pages.pdfgenerate.loan_details_arreas_report', compact(
            'getUserRole',
            'getLoanData',
            'getDivision',
            'getAllMemberData',
            'getAllRepaymentData',
            'getLoansData'
        ))->setPaper('A4', 'landscape'); // <- Set orientation to landscape

        return $pdf->stream('withdrawal-report.pdf');
    }

    public function viewPdfLoanReport()
    {
        $getUserRole = userRole::all();
        $getAllMemberData = member::all();
        $getDivision = division::all();
        $getLoanData = DB::table('loans')->where('loanStatus', '=', 'Active')->get();
        $getAllRepaymentData = loanrepayment::all();
        $pdf = Pdf::loadView('pages.pdfgenerate.loan_details_report', compact(
            'getUserRole',
            'getLoanData',
            'getDivision',
            'getAllMemberData',
            'getAllRepaymentData'
        ))->setPaper('A4', 'landscape'); // <- Set orientation to landscape

        return $pdf->stream('withdrawal-report.pdf');
    }

    public function viewPdfCollectionvsdeposit()
    {
        $getUserRole = userRole::all();
        $getPurpose = loanpurpose::all();
        $getLoansData = loan::all();
        $getLoanPurposeSubCat = loanpurposesub::all();
        $getAllMemberData = member::all();
        $accountTransectionHis = accounttransectionhistory::all();
        $collectionData = collectiondeposit::all();
        $getUser = User::all();
        $pdf = Pdf::loadView('pages.pdfgenerate.collection_vs_deposit_details_report', compact(
            'getUserRole',
            'getPurpose',
            'getLoansData',
            'getLoanPurposeSubCat',
            'getAllMemberData',
            'accountTransectionHis',
            'collectionData',
            'getUser'
        ))->setPaper('A4', 'landscape'); // <- Set orientation to landscape

        return $pdf->stream('withdrawal-report.pdf');
    }

    public function viewPdfCollection()
    {
        $getUserRole = userRole::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $getDivision = division::all();
        $getUser = DB::table('users')->where('userType', '=', 'Field Officer')->get();
        $getCollectionData = DB::table('accounttransectionhistories')
            ->join('users', 'accounttransectionhistories.collectionBy', '=', 'users.id')
            ->join('members', 'accounttransectionhistories.memberId', '=', 'members.id')
            ->join('divisions', 'members.divisionId', '=', 'divisions.id')
            ->join('villages', 'members.villageId', '=', 'villages.id')
            ->join('smallgroups', 'members.smallGroupId', '=', 'smallgroups.id')
            ->select('accounttransectionhistories.*', 'users.name as collectionBy', 'members.firstName as memberFirstName', 'members.nicNumber as nicNumber', 'members.oldAccountNumber as oldAccountNumber', 'members.lastName as memberLastName', 'members.id as memberId', 'divisions.divisionName as divisionName', 'villages.villageName as villageName', 'smallgroups.smallGroupName as smallGroupName')->get();


        $pdf = Pdf::loadView('pages.pdfgenerate.collection_details_report', compact(
            'getUserRole',
            'getLoansData',
            'getAllMemberData',
            'getDivision',
            'getUser',
            'getCollectionData'
        ))->setPaper('A4', 'landscape'); // <- Set orientation to landscape

        return $pdf->stream('withdrawal-report.pdf');
    }

    public function viewPdfWithdrawal()
    {
        $getMember = member::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $getAllUser = User::all();
        $getWithdrawalData = DB::table('withdrawalhistories')->get();
        $getAllWithdrawal = withdrawal::all();
        $getDivision = DB::table('divisions')->get();
        $getProfession = DB::table('professions')->get();
        $getUserRole = userRole::all();

        $pdf = Pdf::loadView('pages.pdfgenerate.withdrawal_details_report', compact(
            'getMember',
            'getLoansData',
            'getAllMemberData',
            'getWithdrawalData',
            'getAllWithdrawal',
            'getDivision',
            'getProfession',
            'getUserRole'
        ))->setPaper('A4', 'landscape'); // <- Set orientation to landscape

        return $pdf->stream('withdrawal-report.pdf');
    }

    public function viewPdfMember()
    {
        $getUserRole = userRole::all();
        $getMember = member::with('division', 'village', 'smallgroup')->get();
        $getDivision = division::all();
        $getProfession = profession::all();
        $getsavings = saving::all();
        $villages = [];
        $smallGroups = [];
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $getSavingData = saving::all();
        $getOtherIncomeData = DB::table('otherincomes')->get();
        $getDeathSubData = DB::table('deathsubscriptions')->get();

        $pdf = Pdf::loadView('pages.pdfgenerate.member_details_report', compact(
            'getMember',
            'villages',
            'smallGroups',
            'getDivision',
            'getProfession',
            'getsavings',
            'getLoansData',
            'getAllMemberData',
            'getSavingData',
            'getOtherIncomeData',
            'getDeathSubData',
            'getUserRole'
        ))->setPaper('A4', 'landscape'); // <- Set orientation to landscape

        return $pdf->stream('member-report.pdf');
    }

    public function viewPdfLoan()
    {
        $getData = DB::table('loans')->where('createStatus', 1)->get();
        $getMember = member::all();
        $getproduct = loanproduct::all();
        $pdf = Pdf::loadView('pages.pdfgenerate.loan_details', compact(
            'getData',
            'getMember',
            'getproduct'
        ));

        return $pdf->stream('member-personal.pdf');
    }


    public function viewPdfPersonal($id)
    {
        $member = member::with(['division', 'village', 'smallgroup'])->findOrFail($id);
        $getLoanPurpose = loanpurpose::all();
        $getAllMemberData = member::all();
        $getDataActive = DB::table('loans')->where('createStatus', 1)->where('memberId', $id)->where('loanStatus', 'Active')->get();
        $getLoanScheduleData = loanschedule::all();
        $getRepaymentData = loanrepayment::all();
        $getGurDetails = DB::table('loans')->where('gurrantos', $id)->get();
        $getSavings = DB::table('savings')->where('memberId', $member->uniqueId)->first();
        $pdf = Pdf::loadView('pages.pdfgenerate.member_personal_details', compact(
            'member',
            'getDataActive',
            'getLoanPurpose',
            'getAllMemberData',
            'getLoanScheduleData',
            'getRepaymentData',
            'getGurDetails',
            'getSavings'
        ));

        return $pdf->stream('member-personal.pdf');
    }

    public function viewPdf($id)
    {
        $member = member::with(['division', 'village', 'smallgroup'])->findOrFail($id);
        $getLoanPurpose = loanpurpose::all();
        $getAllMemberData = member::all();
        $getDataActive = DB::table('loans')
            ->where('createStatus', 1)
            ->where('memberId', $id)
            ->where('loanStatus', 'Active')
            ->get();
        $getLoanScheduleData = loanschedule::all();
        $getRepaymentData = loanrepayment::all();
        $getGurDetails = DB::table('loans')
            ->where('gurrantos', $id)
            ->get();
        $getSavings = DB::table('savings')
            ->where('memberId', $member->uniqueId)
            ->first();

        // ✅ Added missing variables
        $getPro = profession::all();
        $getSubPro = DB::table('subprofessions')->get();
        $getGnDivision = gndivision::all();
        $gndivisionSmallgroup = gndivisionsmallgroup::all();
        $getMemberNotes = DB::table('membernotes')->where('memberId', $member->id)->get();
        $getAllUser = User::all(); // <-- Add this

        $pdf = Pdf::loadView('pages.pdfgenerate.member_summary_details', compact(
            'member',
            'getDataActive',
            'getLoanPurpose',
            'getAllMemberData',
            'getLoanScheduleData',
            'getRepaymentData',
            'getGurDetails',
            'getSavings',
            'getPro',
            'getSubPro',
            'getGnDivision',
            'gndivisionSmallgroup',
            'getMemberNotes',
            'getAllUser'
        ));

        return $pdf->stream('member-summary.pdf');
    }
}
