<?php

namespace App\Http\Controllers\pages;

use App\Helpers\activityLogHelper;
use App\Helpers\GeolocationHelper;
use App\Helpers\InsertHelper;
use App\Helpers\UpdateHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\userRole;
use App\Models\division;
use App\Models\divisiondetail;
use App\Models\gndivision;
use App\Models\gndivisionsmallgroup;
use App\Models\loan;
use App\Models\member;
use App\Models\village;
use App\Models\smallgroup;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class manage_division_controller extends Controller
{

        function getSmallGroupData(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $divisionName = $request->input('divisionName');
            $villageId = $request->input('villageId');
            $getZoneData = DB::table('villages')->where('villageName', $villageId)->first();
            $villageIdGet = $getZoneData->id;
            $getDivisionData = DB::table('divisions')->where('divisionName', $divisionName)->first();
            $getDivisionId = $getDivisionData->id;
            $getSmallData = DB::table('smallgroups')->where('divisionId', $getDivisionId)->where('villageId', $villageIdGet)->get();
            $smallOption = '<option value="">Select Small Group</option>';
            foreach ($getSmallData as $small) {
                $smallOption .= '<option value="' . $small->smallGroupName . '">' . $small->smallGroupName . '</option>';
            }

            return response()->json(['smallOption' => $smallOption, 'code' => 200]);
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

    function getVillageData(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $divisionName = $request->input('divisionName');
            $getDivisionData = DB::table('divisions')->where('divisionName', $divisionName)->first();
            $getDivisionId = $getDivisionData->id;
            $getVillageData = DB::table('villages')->where('divisionId', $getDivisionId)->get();
            $villageOption = '<option value="">Select Village</option>';
            foreach ($getVillageData as $villageData) {
                $villageOption .= '<option value="' . $villageData->villageName . '">' . $villageData->villageName . '</option>';
            }

            return response()->json(['villageOption' => $villageOption, 'code' => 200]);
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

    function updateSmallGroupDetails(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $smallGroupId = $request->input('smallGroupId');
            $getsmallgroupsData = DB::table('smallgroups')->where('id', $smallGroupId)->first();
            $smallGroupName = $getsmallgroupsData->smallGroupName;
            $txtGroupLeader = $request->input('txtGroupLeader');
            $txtSecretary = $request->input('txtSecretary');
            //get location information
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information

            $ipAddress = $request->ip();
            $activityMessage = 'Update smallgroup Details: ' . $smallGroupName;
            $type = 'Update';
            $className = 'bg-success';

            $getCheckData = DB::table('smallgroupdetails')->where('smallgroupId', $smallGroupId)->count();
            if ($getCheckData > 0) {
                $getCheckDataAll = DB::table('smallgroupdetails')->where('smallgroupId', $smallGroupId)->first();
                $getId = $getCheckDataAll->id;
                $table = 'smallgroupdetails';
                $data = [
                    'groupLeader' => $txtGroupLeader,
                    'secretary' => $txtSecretary
                ];
                $result = UpdateHelper::updateRecord($table, $getId, $data);
                if ($result === true) {
                    return response()->json(['success' => 'Update smallgroup Details successfully', 'code' => 200]);
                    $activityLogResult = activityLogHelper::activityLog($ipAddress, $location, $country, $activityMessage, $type, $className);
                } else {
                    return response()->json(['error' => $result['error'], 'code' => 500]);
                }
            } else {
                $table = 'smallgroupdetails';
                $data = [
                    'smallgroupId' => $smallGroupId,
                    'groupLeader' => $txtGroupLeader,
                    'secretary' => $txtSecretary
                ];
                $result = InsertHelper::insertRecord($table, $data);
                if ($result === true) {
                    return response()->json(['success' => 'Update smallgroup details successfully', 'code' => 200]);
                    $activityLogResult = activityLogHelper::activityLog($ipAddress, $location, $country, $activityMessage, $type, $className);
                } else {
                    return response()->json(['error' => $result['error'], 'code' => 500]);
                }
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
    function updateVillageDetails(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $villageId = $request->input('villageId');
            $getDivisionData = DB::table('villages')->where('id', $villageId)->first();
            $villageName = $getDivisionData->villageName;
            $txtVillageLeader = $request->input('txtVillageLeader');
            $txtSecretary = $request->input('txtSecretary');
            $txtStaff = $request->input('txtStaff');
            $txtPhoneNumber = $request->input('txtPhoneNumber');
            $txtFoName = $request->input('txtFoName');

            //get location information
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information

            $ipAddress = $request->ip();
            $activityMessage = 'Update Village Details: ' . $villageName;
            $type = 'Update';
            $className = 'bg-success';

            $getCheckData = DB::table('villagedetails')->where('villageId', $villageId)->count();
            if ($getCheckData > 0) {
                $getCheckDataAll = DB::table('villagedetails')->where('villageId', $villageId)->first();
                $getId = $getCheckDataAll->id;
                $table = 'villagedetails';
                $data = [
                    'villageLeader' => $txtVillageLeader,
                    'secretary' => $txtSecretary,
                    'staff' => $txtStaff,
                    'phone' => $txtPhoneNumber,
                    'foName' => $txtFoName
                ];
                $result = UpdateHelper::updateRecord($table, $getId, $data);
                if ($result === true) {
                    return response()->json(['success' => 'Update Village Details successfully', 'code' => 200]);
                    $activityLogResult = activityLogHelper::activityLog($ipAddress, $location, $country, $activityMessage, $type, $className);
                } else {
                    return response()->json(['error' => $result['error'], 'code' => 500]);
                }
            } else {
                $table = 'villagedetails';
                $data = [
                    'villageId' => $villageId,
                    'villageLeader' => $txtVillageLeader,
                    'secretary' => $txtSecretary,
                    'staff' => $txtStaff,
                    'phone' => $txtPhoneNumber,
                    'foName' => $txtFoName
                ];
                $result = InsertHelper::insertRecord($table, $data);
                if ($result === true) {
                    return response()->json(['success' => 'Update Village details successfully', 'code' => 200]);
                    $activityLogResult = activityLogHelper::activityLog($ipAddress, $location, $country, $activityMessage, $type, $className);
                } else {
                    return response()->json(['error' => $result['error'], 'code' => 500]);
                }
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


    function updateDivisionDetails(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $divisionId = $request->input('divisionId');
            $getDivisionData = DB::table('divisions')->where('id', $divisionId)->first();
            $divisionName = $getDivisionData->divisionName;
            $txtDivisionHead = $request->input('txtDivisionHead');
            $txtDMName = $request->input('txtDMName');
            $txtRCName = $request->input('txtRCName');
            $txtPhoneNumber = $request->input('txtPhoneNumber');
            $txtAddress = $request->input('txtAddress');
            $txtFoName = $request->input('txtFoName');

            //get location information
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information

            $ipAddress = $request->ip();
            $activityMessage = 'Update Division Details: ' . $divisionName;
            $type = 'Update';
            $className = 'bg-success';

            $getCheckData = DB::table('divisiondetails')->where('divisionId', $divisionId)->count();
            if ($getCheckData > 0) {
                $getCheckDataAll = DB::table('divisiondetails')->where('divisionId', $divisionId)->first();
                $getId = $getCheckDataAll->id;
                $table = 'divisiondetails';
                $data = [
                    'divisionHead' => $txtDivisionHead,
                    'dmName' => $txtDMName,
                    'rcName' => $txtRCName,
                    'phone' => $txtPhoneNumber,
                    'address' => $txtAddress,
                    'foName' => $txtFoName
                ];
                $result = UpdateHelper::updateRecord($table, $getId, $data);
                if ($result === true) {
                    return response()->json(['success' => 'Update Division Details successfully', 'code' => 200]);
                    $activityLogResult = activityLogHelper::activityLog($ipAddress, $location, $country, $activityMessage, $type, $className);
                } else {
                    return response()->json(['error' => $result['error'], 'code' => 500]);
                }
            } else {
                $table = 'divisiondetails';
                $data = [
                    'divisionId' => $divisionId,
                    'divisionHead' => $txtDivisionHead,
                    'dmName' => $txtDMName,
                    'rcName' => $txtRCName,
                    'phone' => $txtPhoneNumber,
                    'address' => $txtAddress,
                    'foName' => $txtFoName
                ];
                $result = InsertHelper::insertRecord($table, $data);
                if ($result === true) {
                    return response()->json(['success' => 'Update Division details successfully', 'code' => 200]);
                    $activityLogResult = activityLogHelper::activityLog($ipAddress, $location, $country, $activityMessage, $type, $className);
                } else {
                    return response()->json(['error' => $result['error'], 'code' => 500]);
                }
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

    function smallgroupDetailsView($id)
    {
        $decId = Crypt::decrypt($id);
        $getUsers = User::all();
        $getSmallgroupFinalData = DB::table('smallgroupdetails')->where('smallgroupId', $decId)->first();

        $getSmallgroupDatas = DB::table('smallgroups')->where('id', $decId)->first();
        $divisionIdGet = $getSmallgroupDatas->divisionId;
        $villageIdGet = $getSmallgroupDatas->villageId;

        $getDivisionData = DB::table('divisions')->where('id', $divisionIdGet)->first();
        $getVillageData = DB::table('villages')->where('id', $villageIdGet)->first();
        $getDivisionName = $getDivisionData->divisionName;
        $getVillageName = $getVillageData->villageName;
        $memberData = DB::table('members')->where('smallGroupId', $decId)->get();
        $getUserRole = userRole::all();
        $getGnDivision = gndivision::all();
        $getDivision = division::all();
        $getGnSmallGroup = gndivisionsmallgroup::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.permission.divisionbyvillage.smallgroup_details_per', ['getVillageName' => $getVillageName, 'getDivisionName' => $getDivisionName, 'getUsers' => $getUsers,  'getSmallgroupFinalData' => $getSmallgroupFinalData, 'getUserRole' => $getUserRole, 'getGnDivision' => $getGnDivision, 'getDivision' => $getDivision, 'getGnSmallGroup' => $getGnSmallGroup, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData, 'smallGroupId' => $decId, 'memberData' => $memberData]);
    }

    function villageDetailsView($id)
    {
        $decId = Crypt::decrypt($id);
        $getVillageData = DB::table('villages')->where('id', $decId)->first();
        $getUsers = User::all();
        $getDivisionFinalData = DB::table('villagedetails')->where('villageId', $decId)->first();
        $userDetails = [];
        foreach ($getUsers as $user) {
            if ($user->village != '' || $user->village != null) {
                $villageIds = json_decode($user->village, true);
                if (in_array($decId, $villageIds)) {
                    $userDetails[] = $user;
                }
            }
        }

        $memberData = DB::table('members')->where('villageId', $decId)->get();
        $getUserRole = userRole::all();
        $getGnDivision = gndivision::all();
        $getDivision = division::all();
        $getGnSmallGroup = gndivisionsmallgroup::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.permission.divisionbyvillage.village_details_per', [ 'getVillageData' => $getVillageData, 'getUsers' => $getUsers,  'getVillageFinalData' => $getDivisionFinalData, 'userDetails' => $userDetails, 'getUserRole' => $getUserRole, 'getGnDivision' => $getGnDivision, 'getDivision' => $getDivision, 'getGnSmallGroup' => $getGnSmallGroup, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData, 'villageId' => $decId, 'memberData' => $memberData]);
    }

    function divisionDetailsView($id)
    {
        $decId = Crypt::decrypt($id);
        $getUsers = User::all();
        $getDivisionFinalData = DB::table('divisiondetails')->where('divisionId', $decId)->first();
        $userDetails = [];
        foreach ($getUsers as $user) {
            if ($user->division != '' || $user->division != null) {
                $divisionIds = json_decode($user->division, true);
                if (in_array($decId, $divisionIds)) {
                    $userDetails[] = $user;
                }
            }
        }

        $getDeviData = DB::table('divisions')->where('id', $decId)->first();

        $memberData = DB::table('members')->where('divisionId', $decId)->get();
        $getUserRole = userRole::all();
        $getGnDivision = gndivision::all();
        $getDivision = division::all();
        $getGnSmallGroup = gndivisionsmallgroup::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.permission.divisionbyvillage.division_details_per', ['getDeviData' => $getDeviData,'getUsers' => $getUsers,  'getDivisionFinalData' => $getDivisionFinalData, 'userDetails' => $userDetails, 'getUserRole' => $getUserRole, 'getGnDivision' => $getGnDivision, 'getDivision' => $getDivision, 'getGnSmallGroup' => $getGnSmallGroup, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData, 'divisionId' => $decId, 'memberData' => $memberData]);
    }
    //
    public function manageDivision()
    {
        $getUserRole = userRole::all();
        $getGnDivision = gndivision::all();
        $getDivision = division::all();
        $getGnSmallGroup = gndivisionsmallgroup::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.manage_division_per', ['getUserRole' => $getUserRole, 'getGnDivision' => $getGnDivision, 'getDivision' => $getDivision, 'getGnSmallGroup' => $getGnSmallGroup, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    public function createDivision()
    {
        $getUserRole = userRole::all();
        $getDivision = division::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.create_gn_division_per', ['getUserRole' => $getUserRole, 'getDivision' => $getDivision, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    public function createSmallgroupBygn()
    {
        $getUserRole = userRole::all();
        $getDivision = division::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.permission.gndivision.create_smallgroup_by_gn_per', ['getDivision' => $getDivision, 'getUserRole' => $getUserRole, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    function getGnDivision(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txtSelectDivision = $request->input('txtSelectDivision');
            $getGnDiv = DB::table('gndivisions')->where('divisionId', $txtSelectDivision)->get();

            $getAllGnOption = '';
            foreach ($getGnDiv as $gn) {
                $id = $gn->id;
                $gnDivisionName = $gn->gnDivisionName;
                $getAllGnOption .= "<option value='$id'>$gnDivisionName</option>";
            }

            return response()->json(['success' => true, 'code' => 200, 'getGnDiv' => $getAllGnOption]);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'error' => 'Database error: ' . $e->getMessage(),
                'code' => 500,
            ]);
        }
    }

    function createGnSmallGroup(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txtSelectDivision = $request->input('txtSelectDivision');
            $txtSelectGnDivision = $request->input('txtSelectGnDivision');
            $txtGnSmallGroup = $request->input('txtGnSmallGroup');

            $smallgroup = new gndivisionsmallgroup();
            $smallgroup->divisionId = $txtSelectDivision;
            $smallgroup->gnDivisionId = $txtSelectGnDivision;
            $smallgroup->smallGroupName = $txtGnSmallGroup;
            $smallgroup->save();

            return response()->json(['success' => true, 'code' => 200]);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'error' => 'Database error: ' . $e->getMessage(),
                'code' => 500,
            ]);
        }
    }

    public function creategnDivisiondata(Request $request)
    {
        $request->validate([
            'divisionId' => 'required',
            'gnDivisionName' => 'required',
        ]);
        $gnDivision = new gndivision();
        $gnDivision->divisionId = $request->input('divisionId');
        $gnDivision->gnDivisionName = $request->input('gnDivisionName');
        $gnDivision->save();
        return redirect()->back()->with('success', 'Gn division Added Successfully');
    }

    public function updateassignsmallgroup(Request $request)
    {
        $validated = $request->validate([
            'gnDivId' => 'required|integer',
            'permissionsDiv' => 'required|array',
        ]);


        $gnDiv = gndivision::find($request->gnDivId);

        if ($gnDiv) {
            $gnDiv->assignSmallGroup = json_encode($request->permissionsDiv);

            if (json_encode($request->permissionsDiv) == '' || json_encode($request->permissionsDiv) == [] || json_encode($request->permissionsDiv) == '[]' || json_encode($request->permissionsDiv) == 'null') {
                return redirect()->back()->with('error', 'Please select at least one small group!');
            } else if ($gnDiv->save()) {
                return redirect()->back()->with('success', 'assign updated successfully!');
            } else {
                return redirect()->back()->with('error', 'Failed to update assign data.');
            }
        } else {
            return redirect()->back()->with('error', 'assign not found.');
        }
    }
}
