<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\userRole;

class Users extends Authenticatable
{
    use HasFactory;

    public function role()
    {
        return $this->belongsTo(userRole::class, 'roleName', 'id');
    }
}
