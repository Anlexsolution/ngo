<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class otherincomehistory extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'incomId',
        'balance',
        'randomId',
        'userId',
        'memberId',
        'type',
        'amount',
        'description',
        'created_at',
        'updated_at',
    ];
}
