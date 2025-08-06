<?php

namespace App\Http\Controllers\pages;

use App\Helpers\activityLogHelper;
use App\Helpers\GeolocationHelper;
use App\Helpers\InsertHelper;
use App\Helpers\UpdateHelper;
use App\Http\Controllers\Controller;
use App\Imports\importFunction;
use App\Imports\memberImport;
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
use App\Models\loanpurpose;
use App\Models\loanrepayment;
use App\Models\loanrequest;
use App\Models\loanschedule;
use App\Models\otherincome;
use App\Models\profession;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Nette\Utils\Random;

class member_controller extends Controller
{

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
        $getDataActive = DB::table('loans')->where('createStatus', 1)->where('memberId', $id)->where('loanStatus', 'Active')->get();
        $getLoanScheduleData = loanschedule::all();
        $getRepaymentData = loanrepayment::all();
        $getGurDetails = DB::table('loans')->where('gurrantos', $id)->get();
           $getSavings = DB::table('savings')->where('memberId', $member->uniqueId)->first();
        $pdf = Pdf::loadView('pages.pdfgenerate.member_summary_details', compact(
            'member',
            'getDataActive',
            'getLoanPurpose',
            'getAllMemberData',
            'getLoanScheduleData',
            'getRepaymentData',
            'getGurDetails',
            'getSavings'
        ));

        return $pdf->stream('member-summary.pdf');
    }

    function getMemberAccData(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }
            $txtMember = $request->input('txtMember');
            $getAccountData = DB::table('savings')->where('memberId', $txtMember)->get();
            $getaccData = '<optionn value="">Select Account</option>';
            if ($getAccountData->isEmpty()) {
            } else {
                foreach ($getAccountData as $data) {
                    $getaccData .= '<option value="' . $data->id . '">' . $data->savingsId . ' - ' . number_format($data->totalAmount, 2) . '</option>';
                }
            }
            return response()->json(['accountData' => $getaccData, 'success' => 'created member note successfully', 'code' => 200]);
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


    function importMember(Request $request)
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
            $activityMessage = 'Import member Details: ' . $filename;
            $type = 'Import';
            $className = 'bg-success';

            Excel::import(new memberImport, storage_path('app/imports/' . $filename));
            return response()->json(['success' => 'import member successfully', 'code' => 200]);

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


    function createMemberUser(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txtMemberId = $request->input('txtMemberId');
            $password = $request->input('password');

            $getMemberDatas = DB::table('members')->where('id', $txtMemberId)->first();
            $firstName = $getMemberDatas->firstName;
            $lastName = $getMemberDatas->lastName;
            $nicNumber = $getMemberDatas->nicNumber;
            $gender = $getMemberDatas->gender;
            $phoneNumber = $getMemberDatas->phoneNumber;
            $dateOfBirth = $getMemberDatas->dateOfBirth;
            $profiePhoto = $getMemberDatas->profiePhoto;

            $email = 'member' . rand(1000, 9999) . '@gmail.com';

            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information

            $ipAddress = $request->ip();
            $activityMessage = 'Create member user: ' . $firstName;
            $type = 'Create';
            $className = 'bg-primary';

            $table = 'users';
            $data = [
                'name' => $firstName,
                'email' => $email,
                'password' => Hash::make($password),
                'userType' => 'member',
                'fullName' => $firstName . ' ' . $lastName,
                'nic' => $nicNumber,
                'phoneNumber' => $phoneNumber,
                'DOB' => $dateOfBirth,
                'gender' => $gender,
                'active' => 1,
                'profileImage' => 'memberimages/' . $profiePhoto
            ];

            $checklect = DB::table('users')->where('nic', $nicNumber)->where('usertype', 'member')->count();
            if ($checklect > 0) {
                return response()->json(['error' => 'Member already exists', 'code' => 500]);
            } else {
                $result = InsertHelper::insertRecord($table, $data);
                if ($result === true) {
                    $tabMam = 'members';
                    $memData = [
                        'login' => 1,
                        'password' => $password
                    ];
                    $resultMem = UpdateHelper::updateRecord($tabMam, $txtMemberId, $memData);
                    if ($resultMem === true) {
                        return response()->json(['success' => 'created member users successfully', 'code' => 200]);
                        $activityLogResult = activityLogHelper::activityLog($ipAddress, $location, $country, $activityMessage, $type, $className);
                    } else {
                        return response()->json(['error' => $resultMem['error'], 'code' => 500]);
                    }
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

    function createmembersNote(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txtMemberId = $request->input('txtMemberId');
            $txtTitle = $request->input('txtTitle');
            $txtDescription = $request->input('txtDescription');

            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information

            $ipAddress = $request->ip();
            $activityMessage = 'Create member note Details: ' . $txtTitle;
            $type = 'Update';
            $className = 'bg-primary';

            $table = 'membernotes';
            $data = [
                'memberId' => $txtMemberId,
                "createdBy" => Auth::user()->id,
                "randomId" => rand(100000, 999999),
                'title' => $txtTitle,
                'description' => $txtDescription
            ];
            $result = InsertHelper::insertRecord($table, $data);
            if ($result === true) {
                return response()->json(['success' => 'created member note successfully', 'code' => 200]);
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

    function createMemberLocation(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txtMapLattitude = $request->input('txtMapLattitude');
            $txtMapLongitude = $request->input('txtMapLongitude');
            $txtMemberId = $request->input('txtMemberId');

            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information

            $ipAddress = $request->ip();
            $activityMessage = 'Update member location Details: latitude ' . $txtMapLattitude . ' longitude ' . $txtMapLongitude;
            $type = 'Update';
            $className = 'bg-success';

            $table = 'members';
            $data = [
                'latitude' => $txtMapLattitude,
                'longitude' => $txtMapLongitude
            ];
            $result = UpdateHelper::updateRecord($table, $txtMemberId, $data);
            if ($result === true) {
                return response()->json(['success' => 'Update member location successfully', 'code' => 200]);
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

    function updateMemberStatus(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txtMemberId = $request->input('txtMemberId');
            $txtStatusType = $request->input('txtStatusType');
            $txtStatus = $request->input('txtStatus');

            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

            $location = $geoData['location'];
            $country = $geoData['country'];
            //get location information

            $ipAddress = $request->ip();
            $activityMessage = 'Update member Status Details: ' . $txtStatus;
            $type = 'Update';
            $className = 'bg-success';

            $table = 'members';
            $data = [
                'status' => $txtStatus,
                'statusType' => $txtStatusType
            ];
            $result = UpdateHelper::updateRecord($table, $txtMemberId, $data);
            if ($result === true) {
                return response()->json(['success' => 'Updated member Status successfully', 'code' => 200]);
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


    function updateSignatureImage(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txtMemberId = $request->input('txtMemberId');
            $getMemData = DB::table('members')->where('id', $txtMemberId)->first();
            $txtfirstName = $getMemData->firstName;
            $txtLastName = $getMemData->lastName;
            $fullName = $txtfirstName . ' ' . $txtLastName;
            $signature = $getMemData->signature;

            if ($request->hasFile('txtDocument')) {
                if ($signature != null) {
                    $txtDocument = $request->file('txtDocument');
                    $fileName = $signature;
                    $uploadPath = public_path('memberimages');

                    if (!File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath, 0777, true, true);
                    }

                    $txtDocument->move($uploadPath, $fileName);

                    $latitude = $request->input('latitude');
                    $longitude = $request->input('longitude');

                    $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

                    $location = $geoData['location'];
                    $country = $geoData['country'];
                    //get location information

                    $ipAddress = $request->ip();
                    $activityMessage = 'Update Profile Image: ' . $fullName;
                    $type = 'Update';
                    $className = 'bg-success';

                    return response()->json(['success' => 'Updated member signatures successfully', 'code' => 200]);
                    $activityLogResult = activityLogHelper::activityLog($ipAddress, $location, $country, $activityMessage, $type, $className);
                } else {
                    $txtDocument = $request->file('txtDocument');
                    $extension = $txtDocument->getClientOriginalExtension();

                    $fileName = str::random(12) . '.' . $extension;
                    $uploadPath = public_path('memberimages');

                    if (!File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath, 0777, true, true);
                    }

                    $txtDocument->move($uploadPath, $fileName);

                    $latitude = $request->input('latitude');
                    $longitude = $request->input('longitude');

                    $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

                    $location = $geoData['location'];
                    $country = $geoData['country'];
                    //get location information

                    $ipAddress = $request->ip();
                    $activityMessage = 'Update Member profile: ' . $fullName;
                    $type = 'Update';
                    $className = 'bg-success';

                    $table = 'members';
                    $data = [
                        'signature' => $fileName
                    ];
                    $result = UpdateHelper::updateRecord($table, $txtMemberId, $data);
                    if ($result === true) {
                        return response()->json(['success' => 'Updated member signatures successfully', 'code' => 200]);
                        $activityLogResult = activityLogHelper::activityLog($ipAddress, $location, $country, $activityMessage, $type, $className);
                    } else {
                        return response()->json(['error' => $result['error'], 'code' => 500]);
                    }
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

    function updateProfileImage(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txtMemberId = $request->input('txtMemberId');
            $getMemData = DB::table('members')->where('id', $txtMemberId)->first();
            $txtfirstName = $getMemData->firstName;
            $txtLastName = $getMemData->lastName;
            $fullName = $txtfirstName . ' ' . $txtLastName;
            $profiePhoto = $getMemData->profiePhoto;

            if ($request->hasFile('txtDocument')) {
                if ($profiePhoto != null) {
                    $txtDocument = $request->file('txtDocument');
                    $fileName = $profiePhoto;
                    $uploadPath = public_path('memberimages');

                    if (!File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath, 0777, true, true);
                    }

                    $txtDocument->move($uploadPath, $fileName);

                    $latitude = $request->input('latitude');
                    $longitude = $request->input('longitude');

                    $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

                    $location = $geoData['location'];
                    $country = $geoData['country'];
                    //get location information

                    $ipAddress = $request->ip();
                    $activityMessage = 'Update Profile Image: ' . $fullName;
                    $type = 'Update';
                    $className = 'bg-success';

                    return response()->json(['success' => 'Updated member profile successfully', 'code' => 200]);
                    $activityLogResult = activityLogHelper::activityLog($ipAddress, $location, $country, $activityMessage, $type, $className);
                } else {
                    $txtDocument = $request->file('txtDocument');
                    $extension = $txtDocument->getClientOriginalExtension();

                    $fileName = str::random(12) . '.' . $extension;
                    $uploadPath = public_path('memberimages');

                    if (!File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath, 0777, true, true);
                    }

                    $txtDocument->move($uploadPath, $fileName);

                    $latitude = $request->input('latitude');
                    $longitude = $request->input('longitude');

                    $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

                    $location = $geoData['location'];
                    $country = $geoData['country'];
                    //get location information

                    $ipAddress = $request->ip();
                    $activityMessage = 'Update Member profile: ' . $fullName;
                    $type = 'Update';
                    $className = 'bg-success';

                    $table = 'members';
                    $data = [
                        'profiePhoto' => $fileName
                    ];
                    $result = UpdateHelper::updateRecord($table, $txtMemberId, $data);
                    if ($result === true) {
                        return response()->json(['success' => 'Updated member profile successfully', 'code' => 200]);
                        $activityLogResult = activityLogHelper::activityLog($ipAddress, $location, $country, $activityMessage, $type, $className);
                    } else {
                        return response()->json(['error' => $result['error'], 'code' => 500]);
                    }
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

    function uploadMemberDocument(Request $request)
    {
        try {
            // Check CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            $txtMemberId = $request->input('txtMemberId');
            $txtTitle = $request->input('txtTitle');

            if ($request->hasFile('txtDocument')) {
                $txtDocument = $request->file('txtDocument');


                $title = preg_replace('/[^A-Za-z0-9_\-]/', '_', $request->input('txtTitle'));
                $extension = $txtDocument->getClientOriginalExtension();

                $fileName = $title . '_' . time() . '.' . $extension;
                $uploadPath = public_path('uploads');

                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0777, true, true);
                }

                $txtDocument->move($uploadPath, $fileName);

                $relativePath = 'uploads/' . $fileName;

                $latitude = $request->input('latitude');
                $longitude = $request->input('longitude');

                $geoData = GeolocationHelper::getGeolocationData($latitude, $longitude);

                $location = $geoData['location'];
                $country = $geoData['country'];
                //get location information

                $ipAddress = $request->ip();
                $activityMessage = 'Update smallgroup Details: ' . $txtTitle;
                $type = 'Update';
                $className = 'bg-success';

                $table = 'memberdocuments';
                $data = [
                    'memberId' => $txtMemberId,
                    'createdBy' => Auth::user()->id,
                    "randomId" => rand(100000, 999999),
                    'documentName' => $txtTitle,
                    'documentPath' => $relativePath
                ];
                $result = InsertHelper::insertRecord($table, $data);
                if ($result === true) {
                    return response()->json(['success' => 'Uploaded member document successfully', 'code' => 200]);
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

    //
    public function createMember()
    {
        $getUserRole = userRole::all();
        $getDivision = division::all();
        $managePro = profession::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.add_member_per', ['getUserRole' => $getUserRole, 'getDivision' => $getDivision, 'managePro' => $managePro, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }




    public function getSmallGroup($villageId, $divisionIdValue)
    {
        $smallGroup = smallgroup::where('divisionId', $divisionIdValue)
            ->where('villageId', $villageId)
            ->get();
        return response()->json($smallGroup);
    }

    public function getSmallGroupGN($villageId, $divisionIdValue)
    {
        $smallGroup = gndivisionsmallgroup::where('divisionId', $divisionIdValue)
            ->where('gnDivisionId', $villageId)
            ->get();
        return response()->json($smallGroup);
    }

    public function getSubProfession($professionId)
    {
        $getSubProData = DB::table('subprofessions')->where('professionId', $professionId)->get();
        return response()->json($getSubProData);
    }

    public function getSmallGroupByGn($divisionIdValue)
    {
        // Fetch all records from gndivision where divisionId matches the given value
        $gnDivisions = gndivision::where('divisionId', $divisionIdValue)->get();

        // Initialize an empty array to collect small group data
        $allSmallGroups = [];

        // Loop through each gndivision record
        foreach ($gnDivisions as $gnDivision) {
            // Check if assignSmallGroup column exists and is not empty
            if (!empty($gnDivision->assignSmallGroup)) {
                // Convert the JSON string or array to a PHP array
                $smallGroupIds = json_decode($gnDivision->assignSmallGroup, true);

                // Loop through each small group ID one by one
                foreach ($smallGroupIds as $smallGroupId) {
                    // Fetch the small group record by its ID
                    $smallGroup = smallgroup::find($smallGroupId);

                    // If the small group exists, add it to the result array
                    if ($smallGroup) {
                        $allSmallGroups[] = $smallGroup;
                    }
                }
            }
        }

        // Return the collected small group data as a JSON response
        return response()->json($allSmallGroups);
    }



    public function createmembers(Request $request)
    {
        $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'nicNumber' => 'required',
            'dateOfBirth' => 'required',
            'address' => 'required',
            'oldAccountNumber' => 'required',
            'newAccountNumber' => 'required',
            'phoneNumber' => 'required',
            'profession' => 'required',
            'followerName' => 'required',
            'followerAddress' => 'required',
            'followerNicNumber' => 'required',
            'divisionId' => 'required',
            'profiePhoto' => 'required|mimes:jpeg,jpg,png|max:10000',
            'signature' => 'required|mimes:jpeg,jpg,png|max:10000',
            'subprofession' => 'required',
        ]);

        $profileImage = str::random(12) . "." . $request->profiePhoto->extension();
        $request->profiePhoto->move(public_path('memberimages'), $profileImage);

        $signatureImage = str::random(12) . "." . $request->signature->extension();
        $request->signature->move(public_path('memberimages'), $signatureImage);

        $uniqueId = Str::random(16);

        $member = new member();
        $member->title = $request->input('title');
        $member->firstName = $request->input('firstName');
        $member->lastName = $request->input('lastName');
        $member->address = $request->input('address');
        $member->nicNumber = $request->input('nicNumber');
        $member->nicIssueDate = $request->input('nicIssueDate');
        $member->newAccountNumber = $request->input('newAccountNumber');
        $member->oldAccountNumber = $request->input('oldAccountNumber');
        $member->profession = $request->input('profession');
        $member->gender = $request->input('gender');
        $member->maritalStatus = $request->input('maritalStatus');
        $member->phoneNumber = $request->input('phoneNumber');
        $member->divisionId = $request->input('divisionId');
        $member->villageId = $request->input('villageId');
        $member->smallGroupStatus = $request->input('smallGroup');
        $member->gnDivisionId = $request->input('gnDivisionId');
        $member->smallGroupId = $request->input('smallGroupId');
        $member->followerName = $request->input('followerName');
        $member->followerAddress = $request->input('followerAddress');
        $member->followerNicNumber = $request->input('followerNicNumber');
        $member->followerIssueDate = $request->input('followerIssueDate');
        $member->dateOfBirth = $request->input('dateOfBirth');
        $member->profiePhoto = $profileImage;
        $member->signature = $signatureImage;
        $member->uniqueId = $uniqueId;
        $member->subprofession = $request->input('subprofession');
        $member->gnDivisionSmallGroup = $request->input('smallGroupIdGN');
        $member->smallGroupGNStatus = $request->input('smallGroupGN');
        $member->save();

        $savingsIdRandom = rand(1, 999999999);
        $saving = new saving();
        $saving->memberId = $uniqueId;
        $saving->savingsId = $savingsIdRandom;
        $saving->totalAmount = 0;
        $saving->amount = 0;
        $saving->save();

        $deathIdRandom = rand(1, 999999999);
        $deathsubscription = new deathsubscription();
        $deathsubscription->memberId = $uniqueId;
        $deathsubscription->deathId = $deathIdRandom;
        $deathsubscription->totalAmount = 0;
        $deathsubscription->amount = 0;
        $deathsubscription->save();

        $otherIncomeIdRandom = rand(1, 999999999);
        $otherincome = new otherincome();
        $otherincome->memberId = $uniqueId;
        $otherincome->incomId = $otherIncomeIdRandom;
        $otherincome->totalAmount = 0;
        $otherincome->amount = 0;
        $otherincome->save();

        return redirect()->back()->with('success', 'Member created Successfully');
    }

    public function updatemembersdata(Request $request)
    {
        $request->validate([
            'firstName' => 'required',
            'nicNumber' => 'required',
            'nicIssueDate' => 'required',
            'newAccountNumber' => 'required',
            'phoneNumber' => 'required'
        ]);

        $member = member::find($request->memberId);

        if ($member) {
            $member->title = $request->input('title');
            $member->firstName = $request->input('firstName');
            $member->lastName = $request->input('lastName');
            $member->address = $request->input('address');
            $member->nicNumber = $request->input('nicNumber');
            $member->nicIssueDate = $request->input('nicIssueDate');
            $member->newAccountNumber = $request->input('newAccountNumber');
            $member->oldAccountNumber = $request->input('oldAccountNumber');
            $member->profession = $request->input('profession');
            $member->gender = $request->input('gender');
            $member->maritalStatus = $request->input('maritalStatus');
            $member->phoneNumber = $request->input('phoneNumber');
            $member->divisionId = $request->input('divisionId');
            $member->villageId = $request->input('villageId');
            $member->smallGroupStatus = $request->input('smallGroup');
            $member->smallGroupId = $request->input('smallGroupId');
            $member->followerName = $request->input('followerName');
            $member->followerAddress = $request->input('followerAddress');
            $member->followerNicNumber = $request->input('followerNicNumber');
            $member->followerIssueDate = $request->input('followerIssueDate');
            $member->dateOfBirth = $request->input('dateOfBirth');


            if (
                $request->input('title') == '' || $request->input('firstName') == '' || $request->input('lastName') == ''
            ) {
                return redirect()->back()->with('error', 'Please file the deails');
            } else if ($member->save()) {
                return redirect()->back()->with('success', 'member updated successfully!');
            } else {
                return redirect()->back()->with('error', 'Failed to update user data.');
            }
        } else {
            return redirect()->back()->with('error', 'User not found.');
        }
    }
}
