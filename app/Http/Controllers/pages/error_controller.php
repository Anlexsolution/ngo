<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class error_controller extends Controller
{
    public function error401(){
        return view('pages.401page');
    }
}
