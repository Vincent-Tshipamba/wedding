<?php

namespace App\Models;

use App\Models\MessageTemplate;
use App\Models\User;
use App\Models\WeddingEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wedding extends Model
{
    use HasFactory;

    protected $fillable = [
        'groom_name',
        'bride_name',
        'theme_color',
        'slug',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function photos()
    {
        return $this->hasMany(WeddingPhoto::class);
    }

    public function messageTemplates()
    {
        return $this->hasMany(MessageTemplate::class);
    }

    public function weddingEvents()
    {
        return $this->hasMany(WeddingEvent::class)->orderBy('event_date');
    }
}
