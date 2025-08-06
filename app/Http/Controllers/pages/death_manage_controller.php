<?php

namespace App\Http\Controllers\pages;

use App\Helpers\activityLogHelper;
use App\Helpers\GeolocationHelper;
use App\Helpers\InsertHelper;
use App\Helpers\UpdateHelper;
use App\Http\Controllers\Controller;
use App\Imports\deathHistoryImport;
use App\Models\account;
use App\Models\deathdonation;
use Illuminate\Http\Request;
use App\Models\userRole;
use App\Models\deathsubscription;
use App\Models\deathtransectionhistory;
use App\Models\division;
use App\Models\gndivision;
use App\Models\gndivisionsmallgroup;
use App\Models\loan;
use App\Models\member;
use App\Models\profession;
use App\Models\relative;
use App\Models\subprofession;
use Crypt;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class death_manage_controller extends Controller
{

    function donationRejectedData(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txtRejectedReason = $request->input('txtRejectedReason');
            $txtDonationId = $request->input('txtDonationRejectedId');

            $getDonationData = DB::table('deathdonations')->where('id', $txtDonationId)->first();
            $donationUniqueId = $getDonationData->donationId;


            $table = 'deathdonations';
            $data = [
                'status' => 5,
            ];

            $tabHis = 'deathdonationhistories';
            $dataHis = [
                'donationId' => $donationUniqueId,
                'userBy' => Auth::user()->id,
                'remarks' => $txtRejectedReason,
                'status' => "Rejected for donation",
            ];

            $result = UpdateHelper::updateRecord($table, $txtDonationId, $data);
            $resultHis = InsertHelper::insertRecord($tabHis, $dataHis);
            if ($result === true && $resultHis === true) {
                Session::put('deathDonation', deathdonation::all());
                return response()->json(['success' => 'Rejected Death Donation successfully', 'code' => 202, 'redirectUrl' => '/dashboard']);
            } else {
                return response()->json(['error' => $result['error'], 'code' => 500]);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'error' => 'Database error: ' . $e->getMessage(),
                'code' => 500,
            ]);
        } catch (\Exception $e) {
            // Handle general errors
            return response()->json([
                'error' => 'An unexpected error occurred: ' . $e->getMessage(),
                'code' => 500,
            ]);
        }
    }


    function deathApproveData(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txtApprovalReason = $request->input('txtApprovalReason');
            $txtUserType = $request->input('txtUserType');
            $txtDonationId = $request->input('txtDonationId');

            $getDonationData = DB::table('deathdonations')->where('id', $txtDonationId)->first();
            $donationUniqueId = $getDonationData->donationId;


            $table = 'deathdonations';
            $data = [
                'userType' => $txtUserType,
                'status' => 3,
            ];

            $tabHis = 'deathdonationhistories';
            $dataHis = [
                'donationId' => $donationUniqueId,
                'userBy' => Auth::user()->id,
                'remarks' => $txtApprovalReason,
                'status' => "Approved for donation",
            ];

            $result = UpdateHelper::updateRecord($table, $txtDonationId, $data);
            $resultHis = InsertHelper::insertRecord($tabHis, $dataHis);
            if ($result === true && $resultHis === true) {
                Session::put('deathDonation', deathdonation::all());
                return response()->json(['success' => 'Approved Death Donation successfully', 'code' => 202, 'redirectUrl' => '/dashboard']);
            } else {
                return response()->json(['error' => $result['error'], 'code' => 500]);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'error' => 'Database error: ' . $e->getMessage(),
                'code' => 500,
            ]);
        } catch (\Exception $e) {
            // Handle general errors
            return response()->json([
                'error' => 'An unexpected error occurred: ' . $e->getMessage(),
                'code' => 500,
            ]);
        }
    }

    function deathDistributeData(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txtApprovalReason = $request->input('txtApprovalReason');
            $txtAccount = $request->input('txtAccount');
            $txtCheqNo = $request->input('txtCheqNo');
            $txtDonationId = $request->input('txtDonationId');

            $getDonationData = DB::table('deathdonations')->where('id', $txtDonationId)->first();
            $donationUniqueId = $getDonationData->donationId;


            $table = 'deathdonations';
            $data = [
                'status' => 4,
                'account' => $txtAccount,
                'cheqNo' => $txtCheqNo
            ];

            $tabHis = 'deathdonationhistories';
            $dataHis = [
                'donationId' => $donationUniqueId,
                'userBy' => Auth::user()->id,
                'remarks' => $txtApprovalReason,
                'status' => "Distributed for donation",
            ];

            $getAccData = DB::table('accounts')->where('id', $txtAccount)->first();
            $accountBalance = $getAccData->balance;

            $finalBalance = $accountBalance - 10000;

            $dataAcc = [
                'balance' => $finalBalance
            ];

            $tabHisAcc = 'accounttransferhistories';
            $dataHisAcc = [
                'fromAccountId' => $txtAccount,
                'toAccountId' => 0,
                'userId' => Auth::user()->id,
                'transferAmount' => 10000,
                'remarks' => "Death Donation",
                'fromAccountBalance' => $finalBalance,
                'toAccountBalance' => 0,
                'date' => date('Y-m-d'),
            ];


            $result = UpdateHelper::updateRecord($table, $txtDonationId, $data);
            $resultHis = InsertHelper::insertRecord($tabHis, $dataHis);
            $resultAcc = UpdateHelper::updateRecord('accounts', $txtAccount, $dataAcc);
            $resultHisAcc = InsertHelper::insertRecord($tabHisAcc, $dataHisAcc);
            if ($result === true && $resultHis === true && $resultAcc === true && $resultHisAcc === true) {
                Session::put('deathDonation', deathdonation::all());
                return response()->json(['success' => 'Distributed Death Donation successfully', 'code' => 202, 'redirectUrl' => '/dashboard']);
            } else {
                return response()->json(['error' => $result['error'], 'code' => 500]);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'error' => 'Database error: ' . $e->getMessage(),
                'code' => 500,
            ]);
        } catch (\Exception $e) {
            // Handle general errors
            return response()->json([
                'error' => 'An unexpected error occurred: ' . $e->getMessage(),
                'code' => 500,
            ]);
        }
    }

    function deathRecommandData(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txtApprovalReason = $request->input('txtApprovalReason');
            $txtUserType = $request->input('txtUserType');
            $txtDonationId = $request->input('txtDonationId');

            $getDonationData = DB::table('deathdonations')->where('id', $txtDonationId)->first();
            $donationUniqueId = $getDonationData->donationId;


            $table = 'deathdonations';
            $data = [
                'userType' => $txtUserType,
                'status' => 2,
            ];

            $tabHis = 'deathdonationhistories';
            $dataHis = [
                'donationId' => $donationUniqueId,
                'userBy' => Auth::user()->id,
                'remarks' => $txtApprovalReason,
                'status' => "Recommand for donation",
            ];

            $result = UpdateHelper::updateRecord($table, $txtDonationId, $data);
            $resultHis = InsertHelper::insertRecord($tabHis, $dataHis);
            if ($result === true && $resultHis === true) {
                Session::put('deathDonation', deathdonation::all());
                return response()->json(['success' => 'Recommanded Death Donation successfully', 'code' => 202, 'redirectUrl' => '/dashboard']);
            } else {
                return response()->json(['error' => $result['error'], 'code' => 500]);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'error' => 'Database error: ' . $e->getMessage(),
                'code' => 500,
            ]);
        } catch (\Exception $e) {
            // Handle general errors
            return response()->json([
                'error' => 'An unexpected error occurred: ' . $e->getMessage(),
                'code' => 500,
            ]);
        }
    }

    function deathDonationData(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txtMember = $request->input('txtMember');
            $txtRelative = $request->input('txtRelative');
            $txtName = $request->input('txtName');
            $txtRemarks = $request->input('txtRemarks');
            $txtUserType = $request->input('txtUserType');

            //get location information
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information

            $ipAddress = $request->ip();
            $activityMessage = 'Created new Death Donation: ' . $txtName;
            $type = 'Insert';
            $className = 'bg-primary';

            $donationId = rand(1000000000, 9999999999);

            $table = 'deathdonations';
            $data = [
                'donationId' => $donationId,
                'memberId' => $txtMember,
                'relativeId' => $txtRelative,
                'name' => $txtName,
                'remarks' => $txtRemarks,
                'userType' => $txtUserType,
                'status' => 1,
            ];

            $tabHis = 'deathdonationhistories';
            $dataHis = [
                'donationId' => $donationId,
                'userBy' => Auth::user()->id,
                'remarks' => $txtRemarks,
                'status' => "Request for donation",
            ];
            $result = InsertHelper::insertRecord($table, $data);
            $resultHis = InsertHelper::insertRecord($tabHis, $dataHis);
            if ($result === true && $resultHis === true) {
                Session::put('deathDonation', deathdonation::all());
                return response()->json(['success' => 'Create Death Donation successfully', 'code' => 200]);
                $activityLogResult = activityLogHelper::activityLog($ipAddress, $location, $country, $activityMessage, $type, $className);
            } else {
                return response()->json(['error' => $result['error'], 'code' => 500]);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'error' => 'Database error: ' . $e->getMessage(),
                'code' => 500,
            ]);
        } catch (\Exception $e) {
            // Handle general errors
            return response()->json([
                'error' => 'An unexpected error occurred: ' . $e->getMessage(),
                'code' => 500,
            ]);
        }
    }

    function deathHistoryData(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $filename = $request->file('file')->getClientOriginalName();

            $path = $request->file('file')->storeAs('imports', $filename);

            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information

            $ipAddress = $request->ip();
            $activityMessage = 'Import Death Details: ' . $filename;
            $type = 'Import';
            $className = 'bg-success';

            Excel::import(new deathHistoryImport, storage_path('app/imports/' . $filename));
            return response()->json(['success' => 'import Death History successfully', 'code' => 200]);

            // $table = 'membernotes';
            // $data = [
            //     'memberId' => $txtMemberId,
            //     'title' => $txtTitle,
            //     'description' => $txtDescription
            // ];
            // $result = InsertHelper::insertRecord($table, $data);
            // if ($result === true) {
            //     return response()->json(['success' => 'created member note successfully', 'code' => 200]);
            //     $activityLogResult = activityLogHelper::activityLog($ipAddress, $location, $country, $activityMessage, $type, $className);
            // } else {
            //     return response()->json(['error' => $result['error'], 'code' => 500]);
            // }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'error' => 'Database error: ' . $e->getMessage(),
                'code' => 500,
            ]);
        } catch (\Exception $e) {
            // Handle general errors
            return response()->json([
                'error' => 'An unexpected error occurred: ' . $e->getMessage(),
                'code' => 500,
            ]);
        }
    }


    public function manageDeathDonation()
    {
        $getUserRole = userRole::all();
        $getSavings = deathsubscription::all();
        $getSavings = deathsubscription::with('member')->get();
        $getDivision = division::all();
        $getProfession = profession::all();
        $villages = [];
        $smallGroups = [];
        $getMember = member::with('division', 'village', 'smallgroup')->get();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $getrelative = relative::all();
        $getDonationData = deathdonation::all();
        $getAllAccount = account::all();
        return view('pages.permission.death.manage_death_donation_per', ['getAllAccount' => $getAllAccount, 'getDonationData' => $getDonationData, 'getrelative' => $getrelative, 'getUserRole' => $getUserRole, 'getSavings' => $getSavings,  'getMember' => $getMember, 'getDivision' => $getDivision,  'villages' => $villages,  'smallGroups' => $smallGroups, 'getProfession' => $getProfession, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    public function viewDeathDonationRecommand($id)
    {
        $decId = Crypt::decrypt($id);
        $getDonation = DB::table('deathdonations')->where('id', $decId)->first();
        $getMembId = $getDonation->memberId;
        $getRelativeId = $getDonation->relativeId;
        $getRelative = relative::find($getRelativeId);
        $getUserRole = userRole::all();
        $getSavings = deathsubscription::all();
        $getSavings = deathsubscription::with('member')->get();
        $getDivision = division::all();
        $getProfession = profession::all();
        $villages = [];
        $smallGroups = [];
        $getMember = member::with('division', 'village', 'smallgroup')->find($getMembId);
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $getrelative = relative::all();
        $getDonationData = deathdonation::all();
        $getAllAccount = account::all();
        $getDonationHis = DB::table('deathdonationhistories')->where('donationId', $getDonation->donationId)
            ->join('users', 'deathdonationhistories.userBy', '=', 'users.id')
            ->select('deathdonationhistories.*', 'users.name as userName')->get();
        return view('pages.permission.death.view_death_donation_recommand_per', ['getDonationHis' => $getDonationHis, 'getRelative' => $getRelative, 'getAllAccount' => $getAllAccount, 'getDonation' => $getDonation, 'getrelative' => $getrelative, 'getUserRole' => $getUserRole, 'getSavings' => $getSavings,  'getMember' => $getMember, 'getDivision' => $getDivision,  'villages' => $villages,  'smallGroups' => $smallGroups, 'getProfession' => $getProfession, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    public function viewDeathDonationHistory($id)
    {
        $decId = Crypt::decrypt($id);
        $getDonation = DB::table('deathdonations')->where('id', $decId)->first();
        $getMembId = $getDonation->memberId;
        $getRelativeId = $getDonation->relativeId;
        $getRelative = relative::find($getRelativeId);
        $getUserRole = userRole::all();
        $getSavings = deathsubscription::all();
        $getSavings = deathsubscription::with('member')->get();
        $getDivision = division::all();
        $getProfession = profession::all();
        $villages = [];
        $smallGroups = [];
        $getMember = member::with('division', 'village', 'smallgroup')->find($getMembId);
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $getrelative = relative::all();
        $getDonationData = deathdonation::all();
        $getAllAccount = account::all();
        $getDonationHis = DB::table('deathdonationhistories')->where('donationId', $getDonation->donationId)
            ->join('users', 'deathdonationhistories.userBy', '=', 'users.id')
            ->select('deathdonationhistories.*', 'users.name as userName')->get();
        $member = \App\Models\Member::with(['division', 'village', 'smallgroup'])->find($getMembId);
        $getPro = profession::all();
        $getSubPro = subprofession::all();
        $getGnDivision = gndivision::all();
        $gndivisionSmallgroup = gndivisionsmallgroup::all();
        return view('pages.permission.death.view_death_donation_history_per', [ 'gndivisionSmallgroup' => $gndivisionSmallgroup, 'getGnDivision' => $getGnDivision, 'getPro' => $getPro, 'getSubPro' => $getSubPro, 'member' => $member, 'getDonationHis' => $getDonationHis, 'getRelative' => $getRelative, 'getAllAccount' => $getAllAccount, 'getDonation' => $getDonation, 'getrelative' => $getrelative, 'getUserRole' => $getUserRole, 'getSavings' => $getSavings,  'getMember' => $getMember, 'getDivision' => $getDivision,  'villages' => $villages,  'smallGroups' => $smallGroups, 'getProfession' => $getProfession, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    public function viewDeathDonationDistribute($id)
    {
        $decId = Crypt::decrypt($id);
        $getDonation = DB::table('deathdonations')->where('id', $decId)->first();
        $getMembId = $getDonation->memberId;
        $getRelativeId = $getDonation->relativeId;
        $getRelative = relative::find($getRelativeId);
        $getUserRole = userRole::all();
        $getSavings = deathsubscription::all();
        $getSavings = deathsubscription::with('member')->get();
        $getDivision = division::all();
        $getProfession = profession::all();
        $villages = [];
        $smallGroups = [];
        $getMember = member::with('division', 'village', 'smallgroup')->find($getMembId);
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $getrelative = relative::all();
        $getAllAccount = DB::table('accounts')->where('balance', '>', 10000)->get();
        $getDonationHis = DB::table('deathdonationhistories')->where('donationId', $getDonation->donationId)
            ->join('users', 'deathdonationhistories.userBy', '=', 'users.id')
            ->select('deathdonationhistories.*', 'users.name as userName')->get();
        return view('pages.permission.death.view_death_donation_distribute_per', ['getDonationHis' => $getDonationHis, 'getRelative' => $getRelative, 'getAllAccount' => $getAllAccount, 'getDonation' => $getDonation, 'getrelative' => $getrelative, 'getUserRole' => $getUserRole, 'getSavings' => $getSavings,  'getMember' => $getMember, 'getDivision' => $getDivision,  'villages' => $villages,  'smallGroups' => $smallGroups, 'getProfession' => $getProfession, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    public function viewDeathDonationApprove($id)
    {
        $decId = Crypt::decrypt($id);
        $getDonation = DB::table('deathdonations')->where('id', $decId)->first();
        $getMembId = $getDonation->memberId;
        $getRelativeId = $getDonation->relativeId;
        $getRelative = relative::find($getRelativeId);
        $getUserRole = userRole::all();
        $getSavings = deathsubscription::all();
        $getSavings = deathsubscription::with('member')->get();
        $getDivision = division::all();
        $getProfession = profession::all();
        $villages = [];
        $smallGroups = [];
        $getMember = member::with('division', 'village', 'smallgroup')->find($getMembId);
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $getrelative = relative::all();
        $getDonationData = deathdonation::all();
        $getAllAccount = account::all();
        $getDonationHis = DB::table('deathdonationhistories')->where('donationId', $getDonation->donationId)
            ->join('users', 'deathdonationhistories.userBy', '=', 'users.id')
            ->select('deathdonationhistories.*', 'users.name as userName')->get();
        return view('pages.permission.death.view_death_donation_approve_per', ['getDonationHis' => $getDonationHis, 'getRelative' => $getRelative, 'getAllAccount' => $getAllAccount, 'getDonation' => $getDonation, 'getrelative' => $getrelative, 'getUserRole' => $getUserRole, 'getSavings' => $getSavings,  'getMember' => $getMember, 'getDivision' => $getDivision,  'villages' => $villages,  'smallGroups' => $smallGroups, 'getProfession' => $getProfession, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    public function manageDeath()
    {
        $getUserRole = userRole::all();
        $getSavings = deathsubscription::all();
        $getSavings = deathsubscription::with('member')->get();
        $getDivision = division::all();
        $getProfession = profession::all();
        $villages = [];
        $smallGroups = [];
        $getMember = member::with('division', 'village', 'smallgroup')->get();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.death_manage_per', ['getUserRole' => $getUserRole, 'getSavings' => $getSavings,  'getMember' => $getMember, 'getDivision' => $getDivision,  'villages' => $villages,  'smallGroups' => $smallGroups, 'getProfession' => $getProfession, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    public function viewDeathHistory($id)
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
        return view('pages.view_death_history_per', ['memberId' => $memberId, 'getUser' => $getUser, 'getUserRole' => $getUserRole, 'getDeathHistory' => $getDeathHistory, 'getMember' => $getMember, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }
}
