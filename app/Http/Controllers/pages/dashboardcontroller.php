<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\loan;
use App\Models\member;
use Illuminate\Http\Request;
use App\Models\userRole;
class dashboardcontroller extends Controller
{
    public function dashboard(){
        $getUserRole = userRole::all();
        $getLoansData = loan::all();
        $getAllMemberData = member::all();
        return view('pages.dashboard', ['getUserRole'=> $getUserRole, 'getLoansData' => $getLoansData, 'getAllMemberData' => $getAllMemberData]);
    }
}
