<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;
use App\Models\userRole;
use Illuminate\Support\Facades\Session;

class registercontroller extends Controller
{
    public function registerform(){
        return view('auth.register');
    }

    public function store(Request $request){
        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'confirm-password' => 'required|same:password'
        ]);

        $user = new Users;
        $user->name = $request->input('username');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->userType = 'superAdmin';
        $user->permissions = '[]';
        $user->save();

        return redirect('/login');
    }

    public function createusers(Request $request)
    {

        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $userType = $request->input('userType');
            $role = UserRole::where('roleName', $userType)->first();
            $user = new Users;
            $user->name = $request->input('userName');
            $user->email = $request->input('email');
            $user->fullName = $request->input('txtFullName');
            $user->nic = $request->input('txtNic');
            $user->phoneNumber = $request->input('txtPhoneNumber');
            $user->DOB = $request->input('txtDOB');
            $user->professional = $request->input('txtProfessional');
            $user->epfNo = $request->input('txtEpfNo');
            $user->gender = $request->input('txtGender');
            $user->password = Hash::make($request->input('password'));
            $user->userType = $request->input('userType');
            $user->permissions = $role->permission;
            $user->active = '1';
            $user->save();

            return response()->json(['success' => true, 'code' => 200]);
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

    public function updateusers(Request $request)
    {

        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }


            $duplicateEmail = Users::where('email', $request->input('email'))
            ->where('id', '<>', $request->input('txtUserId')) 
            ->exists();

        if ($duplicateEmail) {
            return response()->json(['error' => 'The email is already in use by another user.', 'code' => 409]);
        }

            $userType = $request->input('userType');
            $role = UserRole::where('roleName', $userType)->first();
            $user = Users::find($request->input('txtUserId'));
            $user->name = $request->input('userName');
            $user->email = $request->input('email');
            $user->fullName = $request->input('txtFullName');
            $user->nic = $request->input('txtNic');
            $user->phoneNumber = $request->input('txtPhoneNumber');
            $user->DOB = $request->input('txtDOB');
            $user->professional = $request->input('txtProfessional');
            $user->epfNo = $request->input('txtEpfNo');
            $user->gender = $request->input('txtGender');
            $user->password = Hash::make($request->input('password'));
            $user->userType = $request->input('userType');
            $user->permissions = $role->permission;
            $user->active = '1';
            $user->save();

            return response()->json(['success' => true, 'code' => 200]);
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
