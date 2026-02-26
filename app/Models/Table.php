<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'max_guests',
        'status'
    ];

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }
}
