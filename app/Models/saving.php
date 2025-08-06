<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\member;

class saving extends Model
{
    use HasFactory;
    public function member()
    {
        return $this->belongsTo(Member::class, 'memberId', 'uniqueId');
    }
}
