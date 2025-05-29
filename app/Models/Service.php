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
    
    public function materialPrices()
    {
        return $this->hasMany(MaterialPrice::class);
    }
    
    public function getMaterialsArray()
    {
        return array_map('trim', explode(',', $this->materials));
    }
    
    public function getMaterialPrice($materialName)
    {
        $materialPrice = $this->materialPrices()->where('material_name', $materialName)->first();
        return $materialPrice ? $materialPrice->price : $this->price; // Default to service price if no specific price
    }
}