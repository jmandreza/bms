<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Resident extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'user_id',
        'fname',
        'mname',
        'lname',
        'birthdate',
        'gender',
        'phone',
        'household_no',
        'zone',
        'civil_status',
        'occupation',
        'nationality',
        'fourps_member',
        'fully_vaxxed',
        'voter',
    ];
    
    protected $hidden = [];
    protected $casts = [];
}
