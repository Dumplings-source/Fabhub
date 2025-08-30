<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'material_name',
        'price',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
} 