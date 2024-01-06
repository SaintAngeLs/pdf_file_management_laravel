<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Documents extends Model
{

    protected $fillable = [
        'user_id',
        'title',
        'status',
        'pdf',
        'upload_date',
        'hash',
    ];

    public function getPdfExistsAttribute()
    {
        return Storage::exists('pdf/' . $this->pdf);
    }

}
