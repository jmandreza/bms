<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\DocumentRequest;

class Document extends Model
{
    use HasFactory;

    public function request()
    {
        return $this->belongsTo(DocumentRequest::class);
    }

    protected $fillable = [
        'code',
        'description',
    ];

    protected $hidden = [];
    protected $casts = [];
}
