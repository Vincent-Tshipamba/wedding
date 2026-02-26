<?php

namespace App\Models;

use App\Models\Guest;
use App\Models\Wedding;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeddingEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'wedding_id',
        'name',
        'description',
        'event_date',
        'start_time',
        'end_time',
        'location',
        'is_public',
        'max_guests',
    ];

    public function wedding()
    {
        return $this->belongsTo(Wedding::class);
    }

    public function services()
    {
        return $this->hasMany(WeddingService::class);
    }

    public function guests()
    {
        return $this->belongsToMany(Guest::class, 'guest_events', 'wedding_event_id', 'guest_id');
    }
}
