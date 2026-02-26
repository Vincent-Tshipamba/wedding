<?php

namespace App\Models;

use App\Models\WeddingEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeddingColor extends Model
{
    use HasFactory;

    protected $fillable = [
        'color',
        'wedding_event_id',
    ];

    public function wedding_event()
    {
        return $this->belongsTo(WeddingEvent::class);
    }
}
