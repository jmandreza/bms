<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'subject',
        'message',
        'replied_at'
    ];

    protected $hidden = [];

    protected $casts = [];
}
