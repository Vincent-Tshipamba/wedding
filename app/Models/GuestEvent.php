<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'wedding_event_id',
        'guest_id',
        'is_confirmed',
        'role_type',
        'service_id',
        'scanned_at',
        'scanned_by',
    ];

    protected function casts(): array
    {
        return [
            'is_confirmed' => 'boolean',
            'scanned_at' => 'datetime',
        ];
    }

    public function weddingEvent()
    {
        return $this->belongsTo(WeddingEvent::class);
    }

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function service()
    {
        return $this->belongsTo(WeddingService::class);
    }

    public function scanner()
    {
        return $this->belongsTo(User::class, 'scanned_by');
    }
}
