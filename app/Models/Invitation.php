<?php

namespace App\Models;

use App\Models\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    public const STATUS_CONFIRMED = 'CONFIRMED';
    public const STATUS_PARTIALLY_CONFIRMED = 'PARTIALLY_CONFIRMED';
    public const STATUS_PENDING = 'PENDING';
    public const STATUS_PARTIALLY_SCANNED = 'PARTIALLY_SCANNED';
    public const STATUS_COMPLETED = 'COMPLETED';

    protected $fillable = [
        'token',
        'max_guests',
        'table_id',
        'status',
    ];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function guests()
    {
        return $this->hasMany(Guest::class);
    }

    public function refreshStatusFromGuestEvents(): void
    {
        $guestIds = $this->guests()->pluck('id');

        $scannedCount = GuestEvent::query()
            ->whereIn('guest_id', $guestIds)
            ->whereNotNull('scanned_at')
            ->distinct('guest_id')
            ->count('guest_id');

        $status = match (true) {
            $scannedCount === 0 => self::STATUS_PENDING,
            $scannedCount >= $this->max_guests => self::STATUS_COMPLETED,
            default => self::STATUS_PARTIALLY_SCANNED,
        };

        if ($this->status !== $status) {
            $this->status = $status;
            $this->save();
        }
    }
}
