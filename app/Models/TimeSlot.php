<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'name',
        'is_available',
    ];

    protected $casts = [
        'is_available' => 'boolean',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
} 