<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class profile_controller extends Controller
{
    public function uploadProfile(Request $request)
{
    try {
        // CSRF token check
        if ($request->_token !== Session::token()) {
            return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
        }

        if (!$request->has('txtUserId')) {
            return response()->json(['error' => 'User ID missing', 'code' => 400]);
        }

        $txtUserId = $request->input('txtUserId');
        $user = DB::table('users')->where('id', $txtUserId)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found', 'code' => 404]);
        }

        if (!$request->hasFile('txtUploadProfile')) {
            return response()->json(['error' => 'No file uploaded', 'code' => 422]);
        }

        $file = $request->file('txtUploadProfile');

        if (!$file->isValid()) {
            return response()->json(['error' => 'Invalid file', 'code' => 422]);
        }

        $uploadPath = public_path('uploads');
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0777, true, true);
        }

        $fileName = $user->profileImage ?: (Str::random(12) . '.' . $file->getClientOriginalExtension());

        $file->move($uploadPath, $fileName);

        $updated = DB::table('users')
            ->where('id', $txtUserId)
            ->update(['profileImage' => $fileName]);

        if ($updated || $user->profileImage === $fileName) {
            return response()->json([
                'success' => 'Profile image uploaded successfully',
                'code' => 200,
                'image' => asset('uploads/' . $fileName)
            ]);
        } else {
            return response()->json(['error' => 'Failed to update profile image', 'code' => 500]);
        }

    } catch (\Illuminate\Database\QueryException $e) {
        Log::error('DB Error: ' . $e->getMessage());
        return response()->json([
            'error' => 'Database error: ' . $e->getMessage(),
            'code' => 500,
        ]);
    } catch (\Exception $e) {
        Log::error('General Error: ' . $e->getMessage());
        return response()->json([
            'error' => 'Unexpected error: ' . $e->getMessage(),
            'code' => 500,
        ]);
    }
}

    public function showProfile($id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        return view('profile_view', ['users' => $user]);
    }


    public function updateProfileData(Request $request)
{
    try {
        $id = $request->input('txtUpdateUserId');

        $data = [
            'fullName'     => $request->input('txtFullname'),
            'DOB'          => $request->input('dateOfBirth'),
            'gender'       => $request->input('gender'),
            'phoneNumber'  => $request->input('txtPhoneNumber'),
        ];

        DB::table('users')->where('id', $id)->update($data);

        return response()->json(['success' => 'Profile updated successfully', 'code' => 200]);

    } catch (\Exception $e) {
        return response()->json(['error' => 'Update failed: ' . $e->getMessage(), 'code' => 500]);
    }
}

public function changePassword(Request $request)
{
    $user = DB::table('users')->where('id', $request->userId)->first();

    if (!$user || !Hash::check($request->currentPassword, $user->password)) {
        return response()->json(['error' => 'Current password is incorrect.', 'code' => 403]);
    }

    $newHashedPassword = Hash::make($request->newPassword);

    DB::table('users')->where('id', $request->userId)->update([
        'password' => $newHashedPassword
    ]);

    return response()->json(['success' => 'Password updated successfully.', 'code' => 200]);
}

}
