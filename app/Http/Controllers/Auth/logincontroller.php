<?php

namespace App\Http\Controllers\auth;

use App\Helpers\InsertHelper;
use App\Helpers\MailHelper;
use App\Helpers\UpdateHelper;
use App\Http\Controllers\Controller;
use App\Models\deathdonation;
use App\Models\deathsubscription;
use App\Models\gndivision;
use App\Models\gndivisionsmallgroup;
use App\Models\loanrequest;
use App\Models\loginactivitylog;
use App\Models\profession;
use App\Models\savingtransectionhistory;
use App\Models\subprofession;
use App\Models\userRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Users;
use App\Models\withdrawal;
use App\Models\withdrawalhistory;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;


class logincontroller extends Controller
{


    function otpVerifyData(Request $request)
    {
        try {
            $email = $request->input('email');
            $password = $request->input('password');
            $txtOtp = $request->input('otpCode');
            $getData = Users::where('email', $email)->first();
            $getOtp = $getData->otpCode;
            $userId = $getData->id;
            $user = Users::where('email', $email)->first();

            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');
            $location = 'Unknown City';
            $country = 'Unknown Country';

            if ($latitude && $longitude) {
                $apiKey = env('GOOGLE_MAPS_API_KEY');
                $response = Http::get("https://maps.googleapis.com/maps/api/geocode/json", [
                    'latlng' => "$latitude,$longitude",
                    'key' => $apiKey
                ]);

                if ($response->successful()) {
                    $geoData = $response->json();
                    $location = $geoData['results'][0]['formatted_address'] ?? 'Unknown City';

                    foreach ($geoData['results'][0]['address_components'] ?? [] as $component) {
                        if (in_array('country', $component['types'])) {
                            $country = $component['long_name'];
                            break;
                        }
                    }
                }
            }

            if ($txtOtp == $getOtp) {
                $upData = [
                    'otpVerified' => 1
                ];
                $update = UpdateHelper::updateRecord('users', $userId, $upData);
                if ($update == true) {
                    if (Auth::attempt(['email' => $email, 'password' => $password])) {
                        Auth::login($user);
                        Session::put('userId', $user->id);
                        Session::put('userEmail', $user->email);
                        Session::put('userName', $user->name);
                        Session::put('loanRequest', loanrequest::all());
                        Session::put('withdrawal', withdrawal::all());
                        Session::put('withdrawalHistory', withdrawalhistory::all());
                        Session::put('userRole', userRole::all());
                        Session::put('deathDonation', deathdonation::all());
                        // Log login activity
                        $ipAddress = $request->ip();

                        $loginActivity = new loginactivitylog();
                        $loginActivity->name = $user->name;
                        $loginActivity->email = $user->email;
                        $loginActivity->location = $location;
                        $loginActivity->country = $country;
                        $loginActivity->ipAddress = $ipAddress;
                        $loginActivity->loginTime = now();
                        $loginActivity->date = now()->toDateString();
                        $loginActivity->save();

                        //Saving Interest Set
                        $getMemberData = DB::table('members')->where('status', 1)->get();
                        $countData = DB::table('interestsettings')->count();
                        if ($countData > 0) {
                            $getData = DB::table('interestsettings')->first();
                            $getInterest = $getData->interest;
                        } else {
                            $getInterest = 0;
                        }
                        foreach ($getMemberData as $memData) {
                            $memUniqueId = $memData->uniqueId;
                            $getSavingData = DB::table('savings')->where('memberId', $memUniqueId)->first();
                            $getSavingId = $getSavingData->id;
                            $transSavIdRandom = str_pad(rand(1, 999999999), 12, '0', STR_PAD_LEFT);
                            $startOfPreviousMonth = Carbon::now()->subMonth()->startOfMonth();
                            $endOfPreviousMonth = Carbon::now()->subMonth()->endOfMonth();
                            $lastRecord = savingtransectionhistory::where('savingId', $getSavingId)
                                ->whereBetween('created_at', [$startOfPreviousMonth, $endOfPreviousMonth])
                                ->orderBy('created_at', 'desc')
                                ->first();
                            $lastBalance = $lastRecord ? $lastRecord->balance : 0;
                            $interestAmount = ($lastBalance * $getInterest) / (100 * 12);
                            $newBalance = $lastBalance + $interestAmount;
                            $previousMonthYear = Carbon::now()->subMonth()->format('F Y');

                            $checkData = DB::table('savinginterests')->where('savingId', $getSavingId)->where('memberId', $memUniqueId)->where('monthandyear', $previousMonthYear)->count();
                            if ($checkData < 0) {

                                $table = 'savinginterests';
                                $data = [
                                    'savingId' => $getSavingId,
                                    'balance' => $newBalance,
                                    'randomId' => $transSavIdRandom,
                                    'userId' => Auth::user()->id,
                                    'memberId' => $memUniqueId,
                                    'type' => 'Credit',
                                    'amount' => $interestAmount,
                                    'description' => 'Interest for ' . $previousMonthYear,
                                    'monthandyear' => $previousMonthYear
                                ];
                                $insert = InsertHelper::insertRecord($table, $data);
                            }
                        }
                        //Saving Interest Set

                        return response()->json(['success' => true, 'code' => 200]);
                    } else {
                        return response()->json(['error' => 'Invalid credentials', 'code' => 401]);
                    }
                } else {
                    return response()->json(['error' => 'Invalid record updated', 'code' => 401]);
                }
            } else {
                return response()->json(['error' => 'Invalid OTP', 'code' => 401]);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'error' => 'Database error: ' . $e->getMessage(),
                'code' => 500,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred: ' . $e->getMessage(),
                'code' => 500,
            ]);
        }
    }
    function otpVerify($email, $password)
    {
        $decEmail = Crypt::decrypt($email);
        $decPassword = Crypt::decrypt($password);
        return view('auth.otp_verify', ['email' => $decEmail, 'password' => $decPassword]);
    }

    public function loginpage()
    {
        return view('auth.login');
    }

    public function loginpageMember()
    {
        return view('auth.login_member');
    }

    public function authendicate(Request $request)
    {
        try {
            // Validate the CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            // // Verify reCAPTCHA response
            // $recaptchaResponse = $request->input('captcha');
            // $secretKey = env('RECAPTCHA_SECRET_KEY');
            // $recaptchaValidation = Http::post('https://www.google.com/recaptcha/api/siteverify', [
            //     'secret' => $secretKey,
            //     'response' => $recaptchaResponse,
            // ]);

            // $recaptchaResult = $recaptchaValidation->json();
            // if (!$recaptchaResult['success']) {
            //     return response()->json(['error' => 'Invalid reCAPTCHA verification', 'code' => 422]);
            // }

            // Get location information
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');
            $location = 'Unknown City';
            $country = 'Unknown Country';

            if ($latitude && $longitude) {
                $apiKey = env('GOOGLE_MAPS_API_KEY');
                $response = Http::get("https://maps.googleapis.com/maps/api/geocode/json", [
                    'latlng' => "$latitude,$longitude",
                    'key' => $apiKey
                ]);

                if ($response->successful()) {
                    $geoData = $response->json();
                    $location = $geoData['results'][0]['formatted_address'] ?? 'Unknown City';

                    foreach ($geoData['results'][0]['address_components'] ?? [] as $component) {
                        if (in_array('country', $component['types'])) {
                            $country = $component['long_name'];
                            break;
                        }
                    }
                }
            }

            // Authenticate user
            $email = $request->input('email');
            $password = $request->input('password');
            $user = Users::where('email', $email)->first();

            if ($user) {
                if (!$user->active) {
                    return response()->json(['error' => 'Your account is inactive. Please contact support.', 'code' => 305]);
                }

                if ($user->userType != 'member') {

                    if ($user->userType == 'superAdmin') {
                        $code = random_int(100000, 999999);
                        $updateCode = [
                            'otpCode' => $code
                        ];
                        if (Auth::attempt(['email' => $email, 'password' => $password])) {
                            $upRec = UpdateHelper::updateRecord('users', $user->id, $updateCode);
                            if ($upRec == true) {
                                $mail = MailHelper::sendOtpEmail($user->email, $user->fullName, $code);
                                if ($mail == true) {
                                    return response()->json(['successMsg' => 'OTP sent to your email. Please verify your OTP.', 'code' => 201, 'email' => Crypt::encrypt($email), 'password' => Crypt::encrypt($password)]);
                                } else {
                                    return response()->json(['error' => 'Something went wrong. Please try again later.', 'code' => 500]);
                                }
                            } else {
                                return response()->json(['error' => 'Something went wrong. Please try again later.', 'code' => 500]);
                            }
                        } else {
                            return response()->json(['error' => 'Invalid credentials', 'code' => 401]);
                        }
                    } else {
                        if (Auth::attempt(['email' => $email, 'password' => $password])) {
                            Auth::login($user);
                            Session::put('userId', $user->id);
                            Session::put('userEmail', $user->email);
                            Session::put('userName', $user->name);
                            Session::put('loanRequest', loanrequest::all());
                            Session::put('withdrawal', withdrawal::all());
                            Session::put('withdrawalHistory', withdrawalhistory::all());
                            Session::put('userRole', userRole::all());
                            Session::put('deathDonation', deathdonation::all());
                            // Log login activity
                            $ipAddress = $request->ip();

                            $loginActivity = new loginactivitylog();
                            $loginActivity->name = $user->name;
                            $loginActivity->email = $user->email;
                            $loginActivity->location = $location;
                            $loginActivity->country = $country;
                            $loginActivity->ipAddress = $ipAddress;
                            $loginActivity->loginTime = now();
                            $loginActivity->date = now()->toDateString();
                            $loginActivity->save();

                            return response()->json(['success' => true, 'code' => 200]);
                        } else {
                            return response()->json(['error' => 'Invalid credentials', 'code' => 401]);
                        }
                    }
                } else {
                    return response()->json(['error' => 'Invalid credentials', 'code' => 401]);
                }
            } else {
                return response()->json(['error' => 'No account found with this email address', 'code' => 402]);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'error' => 'Database error: ' . $e->getMessage(),
                'code' => 500,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred: ' . $e->getMessage(),
                'code' => 500,
            ]);
        }
    }


    public function authendicate_member(Request $request)
    {
        try {
            // Validate the CSRF token
            if ($request->_token !== Session::token()) {
                return response()->json(['error' => 'CSRF token mismatch', 'code' => 403]);
            }

            // // Verify reCAPTCHA response
            // $recaptchaResponse = $request->input('captcha');
            // $secretKey = env('RECAPTCHA_SECRET_KEY');
            // $recaptchaValidation = Http::post('https://www.google.com/recaptcha/api/siteverify', [
            //     'secret' => $secretKey,
            //     'response' => $recaptchaResponse,
            // ]);

            // $recaptchaResult = $recaptchaValidation->json();
            // if (!$recaptchaResult['success']) {
            //     return response()->json(['error' => 'Invalid reCAPTCHA verification', 'code' => 422]);
            // }

            // Get location information
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');
            $location = 'Unknown City';
            $country = 'Unknown Country';

            // if ($latitude && $longitude) {
            //     $apiKey = env('GOOGLE_MAPS_API_KEY');
            //     $response = Http::get("https://maps.googleapis.com/maps/api/geocode/json", [
            //         'latlng' => "$latitude,$longitude",
            //         'key' => $apiKey
            //     ]);

            //     if ($response->successful()) {
            //         $geoData = $response->json();
            //         $location = $geoData['results'][0]['formatted_address'] ?? 'Unknown City';

            //         foreach ($geoData['results'][0]['address_components'] ?? [] as $component) {
            //             if (in_array('country', $component['types'])) {
            //                 $country = $component['long_name'];
            //                 break;
            //             }
            //         }
            //     }
            // }

            // Authenticate user
            $nicNumber = $request->input('nicNumber');
            $password = $request->input('password');
            $user = Users::where('nic', $nicNumber)->first();
            $getUserEmail = $user->email;

            if ($user) {
                if ($user->active == 0) {
                    return response()->json(['error' => 'Your account is inactive. Please contact support.', 'code' => 305]);
                }

                if ($user->userType == 'member') {
                    if (Auth::attempt(['email' => $getUserEmail, 'password' => $password])) {
                        Auth::login($user);
                        $getMemData = DB::table('members')->where('nicNumber', $nicNumber)->first();
                        $getMemId = $getMemData->id;
                        $encMemId = Crypt::encrypt($getMemId);
                        Session::put('encMemId', $encMemId);
                        Session::put('userId', $user->id);
                        Session::put('userEmail', $user->email);
                        Session::put('userName', $user->name);
                        Session::put('loanRequest', loanrequest::all());
                        Session::put('withdrawal', withdrawal::all());
                        Session::put('withdrawalHistory', withdrawalhistory::all());
                        Session::put('userRole', userRole::all());
                        Session::put('deathDonation', deathdonation::all());
                        Session::put('getuserRole', userRole::all());

                        $encMemId = Crypt::encrypt($getMemData->id);
                        $uniqueId = $getMemData->uniqueId;
                        $memberId = $getMemData->id;

                        // Fetch all required data
                        $loanRequests = loanrequest::all();
                        $withdrawals = withdrawal::all();
                        $withdrawalHistory = withdrawalhistory::all();
                        $userRoles = userRole::all();
                        $deathDonations = deathdonation::all();
                        $professions = profession::all();
                        $subProfessions = subprofession::all();
                        $gnDivisions = gndivision::all();
                        $gnSmallGroups = gndivisionsmallgroup::all();

                        $savings = DB::table('savings')->where('memberId', $uniqueId)->first();
                        $deathSub = DB::table('deathsubscriptions')->where('memberId', $uniqueId)->first();
                        $otherIncome = DB::table('otherincomes')->where('memberId', $uniqueId)->first();

                        $totalSavings = $savings->totalAmount ?? 0;
                        $totalDeath = $deathSub->totalAmount ?? 0;
                        $totalOther = $otherIncome->totalAmount ?? 0;

                        $activeLoans = DB::table('loans')->where('memberId', $memberId)->where('loanStatus', 'Active')->get();
                        $totalLoanAmount = 0;
                        $totalArrears = 0;

                        foreach ($activeLoans as $loan) {
                            $totalLoanAmount += $loan->principal;

                            $balances = DB::table('loanschedules')
                                ->where('loanId', $loan->id)
                                ->where('status', 'unPaid')
                                ->pluck('balance')
                                ->map(fn($b) => floatval(str_replace(',', '', $b)));

                            $totalArrears += $balances->max() ?? 0;
                        }

                        // Put all in session
                        Session::put('encMemId', $encMemId);
                        Session::put('userId', $user->id);
                        Session::put('userEmail', $user->email);
                        Session::put('userName', $user->name);
                        Session::put('userRole', $user->userType);
                        Session::put('memberUniqueId', $uniqueId);

                        // Main Data
                        Session::put('loanRequest', $loanRequests);
                        Session::put('withdrawal', $withdrawals);
                        Session::put('withdrawalHistory', $withdrawalHistory);
                        Session::put('userRoles', $userRoles);
                        Session::put('deathDonation', $deathDonations);
                        Session::put('getPro', $professions);
                        Session::put('getSubPro', $subProfessions);
                        Session::put('getGnDivision', $gnDivisions);
                        Session::put('gndivisionSmallgroup', $gnSmallGroups);
                        Session::put('getData',  DB::table('loans')->where('createStatus', 1)->where('memberId', $memberId)->get());
                        Session::put('getDataActive', DB::table('loans')->where('createStatus', 1)->where('memberId', $memberId)->where('loanStatus', 'Active')->get());
                        Session::put('getuserRole', userRole::all());
                        // Member Financial Info
                        Session::put('getSavings', $savings);
                        Session::put('totalSavings', number_format($totalSavings, 2));
                        Session::put('totalDeath', number_format($totalDeath, 2));
                        Session::put('totalOtherIncome', number_format($totalOther, 2));
                        Session::put('totalLoanAmount', number_format($totalLoanAmount, 2));
                        Session::put('totalLoanArrears', number_format($totalArrears, 2));


                        // Log login activity
                        $ipAddress = $request->ip();

                        $loginActivity = new loginactivitylog();
                        $loginActivity->name = $user->name;
                        $loginActivity->email = $user->email;
                        $loginActivity->location = $location;
                        $loginActivity->country = $country;
                        $loginActivity->ipAddress = $ipAddress;
                        $loginActivity->loginTime = now();
                        $loginActivity->date = now()->toDateString();
                        $loginActivity->save();

                        return response()->json(['success' => true, 'code' => 200, 'encMemId' => $encMemId]);
                    } else {
                        return response()->json(['error' => 'Invalid credentials', 'code' => 401]);
                    }
                } else {
                    return response()->json(['error' => 'Invalid credentials', 'code' => 401]);
                }
            } else {
                return response()->json(['error' => 'No account found with this email address', 'code' => 402]);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'error' => 'Database error: ' . $e->getMessage(),
                'code' => 500,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred: ' . $e->getMessage(),
                'code' => 500,
            ]);
        }
    }


    public function logout(Request $request)
    {
        $email = Session::get('userEmail');

        if (!$email) {
            return;
        }

        $currentDate = now()->toDateString();

        $logEntry = loginactivitylog::where('email', $email)
            ->where('date', $currentDate)
            ->whereNull('logoutTime')
            ->first();

        if ($logEntry) {
            $logEntry->update([
                'logoutTime' => now(),
            ]);
        }
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->withHeaders([
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

        public function logout_member(Request $request)
    {
        $email = Session::get('userEmail');

        if (!$email) {
            return;
        }

        $currentDate = now()->toDateString();

        $logEntry = loginactivitylog::where('email', $email)
            ->where('date', $currentDate)
            ->whereNull('logoutTime')
            ->first();

        if ($logEntry) {
            $logEntry->update([
                'logoutTime' => now(),
            ]);
        }
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/e-login')->withHeaders([
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }
}
