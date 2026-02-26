<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'wedding_id',
        'type',
        'content',
    ];

    public function wedding()
    {
        return $this->belongsTo(Wedding::class);
    }

    public function logs()
    {
        return $this->hasMany(MessageLog::class, 'template_id');
    }
}
