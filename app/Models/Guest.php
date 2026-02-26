<?php

namespace App\Models;

use App\Models\Invitation;
use App\Models\MessageLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'invitation_id',
        'full_name',
        'phone_number',
        'photo_path',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }

    public function weddingEvent()
    {
        return $this->belongsToMany(WeddingEvent::class, 'guest_events', 'guest_id', 'wedding_event_id');
    }

    public function messageLogs()
    {
        return $this->hasMany(MessageLog::class);
    }
}
