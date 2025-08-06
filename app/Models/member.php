<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\division;
use App\Models\village;
use App\Models\smallgroup;

class member extends Model
{
    use HasFactory;
    public function division()
    {
        return $this->belongsTo(division::class, 'divisionId');
    }
    public function village()
    {
        return $this->belongsTo(village::class, 'villageId');
    }
    public function smallgroup()
    {
        return $this->belongsTo(smallgroup::class, 'smallGroupId');
    }

    protected $fillable = [
        'title',
        'firstName',
        'lastName',
        'address',
        'nicNumber',
        'nicIssueDate',
        'newAccountNumber',
        'oldAccountNumber',
        'profession',
        'gender',
        'maritalStatus',
        'phoneNumber',
        'divisionId',
        'villageId',
        'smallGroupStatus',
        'gnDivStatus',
        'gnDivisionId',
        'smallGroupId',
        'followerName',
        'followerAddress',
        'followerNicNumber',
        'followerIssueDate',
        'dateOfBirth',
        'uniqueId',
        'deleted'
    ];    
}
