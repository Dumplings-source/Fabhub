<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'rate',
        'price', // Added price
        'estimated_time',
        'availability',
        'description',
        'file_formats', // Added file_formats
        'materials',
    ];

    protected $casts = [
        'availability' => 'boolean',
    ];
    
    public function timeSlots()
    {
        return $this->hasMany(TimeSlot::class);
    }
}