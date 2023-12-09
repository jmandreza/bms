<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Document;
use App\Models\User;

class DocumentRequest extends Model
{
    use HasFactory;

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'user_id',
        'document_id',
        'purpose',
        'status',
        'cert_id',
    ];

    protected $hidden = [];
    protected $casts = [];
}