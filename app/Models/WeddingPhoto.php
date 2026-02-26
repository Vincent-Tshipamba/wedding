<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeddingPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'wedding_id',
        'photo_url',
    ];

    public function wedding()
    {
        return $this->belongsTo(Wedding::class);
    }
}
