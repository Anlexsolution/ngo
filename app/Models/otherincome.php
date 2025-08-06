<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class otherincome extends Model
{
    //
     use HasFactory;

    public function member()
    {
        return $this->belongsTo(member::class, 'memberId', 'uniqueId');
    }
}
