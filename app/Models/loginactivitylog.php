<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class loginactivitylog extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'date',
        'loginTime',
        'logoutTime', // Add this to allow mass assignment
    ];
}
