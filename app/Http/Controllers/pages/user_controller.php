<?php

namespace App\Http\Controllers\pages;

use App\Helpers\activityLogHelper;
use App\Helpers\GeolocationHelper;
use App\Helpers\UpdateHelper;
use App\Http\Controllers\Controller;
use App\Models\division;
use App\Models\loan;
use App\Models\member;
use App\Models\profession;
use App\Models\systemactivitylog;
use Illuminate\Http\Request;
use App\Models\userRole;
use App\Models\users;
use App\Models\village;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class user_controller extends Controller
{
    //
    public function addUsers()
    {
        $getUserRole = userRole::all();
        $getProfessional = profession::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.add_users', ['getUserRole' => $getUserRole, 'getProfessional' => $getProfessional, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    public function manageUsers()
    {
        $getUserRole = userRole::all();
        $getUsers = users::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.manage_users_per', ['getUserRole' => $getUserRole, 'getUsers' => $getUsers, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    function assignDivision($id)
    {
        $getUserRole = userRole::all();
        $users = users::find($id);
        $division = division::all();
        $village = village::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.assign_division_per', ['getUserRole' => $getUserRole,  'users' => $users, 'getDivision' => $division, 'getVillage' => $village, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    public function updateuserdivisiondata(Request $request)
    {
        $validated = $request->validate([
            'userId' => 'required|integer',
            'permissionsDivision' => 'required|array',
            'permissionsVillage' => 'nullable|array',
        ]);


        $user = users::find($request->userId);

        if ($user) {
            $user->division = json_encode($request->permissionsDivision);
            $user->village = json_encode($request->permissionsVillage);
            $user->memberPermision = json_encode($request->permissionsMember);

            if (json_encode($request->permissionsDivision) == '' || json_encode($request->permissionsDivision) == [] || json_encode($request->permissionsDivision) == '[]' || json_encode($request->permissionsDivision) == 'null') {
                return redirect()->back()->with('error', 'Please select at least one division!');
            } else if ($user->save()) {
                return redirect()->back()->with('success', 'Division and Village and member permisson updated successfully!');
            } else {
                return redirect()->back()->with('error', 'Failed to update user data.');
            }
        } else {
            return redirect()->back()->with('error', 'User not found.');
        }
    }

    public function enableuser($id)
    {

        $user = users::find($id);

        if ($user) {
            $user->active = '1';

            if ($user->save()) {
                return redirect()->back()->with('success', 'Activated the user successfully!');
            } else {
                return redirect()->back()->with('error', 'Failed to activate user.');
            }
        } else {
            return redirect()->back()->with('error', 'Somthing wrong try again');
        }
    }

    public function disableuser($id)
    {

        $user = users::find($id);

        if ($user) {
            $user->active = '0';

            if ($user->save()) {
                return redirect()->back()->with('success', 'Disabled the user successfully!');
            } else {
                return redirect()->back()->with('error', 'Failed to disable user.');
            }
        } else {
            return redirect()->back()->with('error', 'Somthing wrong try again');
        }
    }

    function deleteuser($id)
    {
        $user = users::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'User Deleted Successfully');
    }

    function updateUsers($id)
    {
        $userId = Crypt::decrypt($id);
        $userData = DB::table('users')
            ->where('id', $userId)
            ->first();

        $getProfessional = profession::all();
        $getUserRole = userRole::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.update_user_per', ['userData' => $userData, 'getProfessional' => $getProfessional, 'getUserRole' => $getUserRole, 'userId' => $userId, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    function profileView($id)
    {
        $userId = Crypt::decrypt($id);
        $getUserRole = userRole::all();
        $userData = DB::table('users')
            ->where('id', $userId)
            ->first();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.profile_view_per', ['userData' => $userData, 'getUserRole' => $getUserRole, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    function updateUserRole($id)
    {
        $userRoleId = Crypt::decrypt($id);
        $userData = DB::table('user_roles')
            ->where('id', $userRoleId)
            ->first();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        $getUserRole = userRole::all();
        return view('pages.update_userrole_per', [ 'getUserRole' => $getUserRole, 'userData' => $userData, 'userRoleId' => $userRoleId, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    public function assignPermissionUpdate($id)
    {
        $decId = decrypt($id);
        $getData = users::find($decId);
        $getUserRole = userRole::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.permission.users.assign_permssion_update_per', ['userData' => $getData, 'getUserRole' => $getUserRole, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    public function updateUserPermission(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            //get location information
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information

            $userName = users::find($request->input('txtUserId'));
            $ipAddress = $request->ip();
            $activityMessage = 'Update User Permission : ' . $userName->name;
            $type = 'Update';
            $className = 'bg-success';

            $tableName = 'users';
            $id = $request->input('txtUserId');
            $data = [
                'permissions' => $request->input('selectedPermissions')
            ];

            // Use the UpdateHelper
            $result = UpdateHelper::updateRecord($tableName, $id, $data);

            // Check the result
            if ($result === true) {
                $activityLogResult = activityLogHelper::activityLog($ipAddress, $location, $country, $activityMessage, $type, $className);
                return response()->json(['success' => 'User Permission Updated successfully', 'code' => 200]);
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
}
