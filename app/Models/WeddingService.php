<?php

namespace App\Models;

use App\Models\GuestEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeddingService extends Model
{
    use HasFactory;

    protected $fillable = [
        'wedding_event_id',
        'name',
        'description',
    ];

    public function weddingEvent()
    {
        return $this->belongsTo(WeddingEvent::class);
    }

    public function guestEvents()
    {
        return $this->hasMany(GuestEvent::class);
    }
}
