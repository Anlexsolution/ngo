<?php

namespace App\Http\Controllers;

use App\Helpers\activityLogHelper;
use App\Helpers\GeolocationHelper;
use App\Helpers\InsertHelper;
use App\Models\loan;
use App\Models\member;
use App\Models\systemactivitylog;
use Illuminate\Http\Request;
use App\Models\userRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class user_role_controller extends Controller
{
    //
    public function userrole()
    {
        $getUserRole = userRole::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.user_role', ['getUserRole'=> $getUserRole, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    public function manageuserrole()
    {
        $getUserRole = userRole::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.manage_user_role_per', ['getUserRole'=> $getUserRole, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }

    public function createuserrole(Request $request)
    {
        $request->validate([
            'roleName' => 'required|string|max:255|unique:user_roles',
            'permissions' => 'nullable|array'
        ]);

        if (json_encode($request->permissions) == '' || json_encode($request->permissions) == [] || json_encode($request->permissions) == '[]' || json_encode($request->permissions) == 'null') {
            return redirect()->back()->with('error', 'Please select at least one permission!');
        } else {
            $userRol = new userRole;
            $userRol->roleName = $request->roleName;
            $userRol->permission = json_encode($request->permissions);
            $userRol->save();


            $ipAddress = $request->ip();
            $userId = Auth::user()->id;
            $activityLog = new systemactivitylog();
            $activityLog->userId = $userId;
            $activityLog->activity = 'Created new user role: '. $request->roleName;
            $activityLog->type = 'Insert';
            $activityLog->ipAddress = $ipAddress;
            $activityLog->className = 'bg-primary';
            $activityLog->save();

            return redirect()->back()->with('success', 'User Role created successfully!');
        }
    }

    public function updateuserrole(Request $request)
    {
        $request->validate([
            'permissions' => 'nullable|array'
        ]);

        if (json_encode($request->permissions) == '' || json_encode($request->permissions) == [] || json_encode($request->permissions) == '[]' || json_encode($request->permissions) == 'null') {
            return redirect()->back()->with('error', 'Please select at least one permission!');
        } else {
            $userRol = userRole::find($request->userRoleId);
            $userRol->permission = json_encode($request->permissions);
            $userRol->save();

            return redirect()->back()->with('success', 'User Role updated successfully!');
        }
    }

    public function createUserRoleData(Request $request){
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

            $ipAddress = $request->ip();
            $activityMessage = 'Create User Role : ' . $request->input('roleName');
            $type = 'Insert';
            $className = 'bg-primary';

            $tableName = 'user_roles'; 
            $data = [
                'roleName' => $request->input('roleName'),
                'permission' => $request->input('selectedPermissions'),
            ];

            // Use the UpdateHelper
            $result = InsertHelper::insertRecord($tableName, $data);
        
            // Check the result
            if ($result === true) {
                $activityLogResult = activityLogHelper::activityLog($ipAddress, $location, $country, $activityMessage, $type, $className);
                return response()->json(['success' => 'User Role created successfully', 'code' => 200]);
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
