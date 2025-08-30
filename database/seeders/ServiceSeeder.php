<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 3D Printing Service
        Service::create([
            'name' => '3D Printing',
            'rate' => 15.00, // hourly rate
            'price' => 5.00, // base price
            'estimated_time' => '1-3 days',
            'availability' => true,
            'description' => 'Professional 3D printing service with various materials and finishes available.',
            'file_formats' => 'STL, OBJ, 3MF',
            'materials' => 'PLA, ABS, PETG, TPU, Resin',
        ]);

        // Woodwork Service
        Service::create([
            'name' => 'Woodwork',
            'rate' => 25.00,
            'price' => 10.00,
            'estimated_time' => '3-7 days',
            'availability' => true,
            'description' => 'Custom woodworking services including cutting, carving, and assembly.',
            'file_formats' => 'DXF, SVG, PDF',
            'materials' => 'Pine, Oak, Maple, Walnut, Plywood',
        ]);

        // Laser Cutting Service
        Service::create([
            'name' => 'Laser Cutting',
            'rate' => 20.00,
            'price' => 8.00,
            'estimated_time' => '1-2 days',
            'availability' => true,
            'description' => 'Precision laser cutting for various materials with high accuracy.',
            'file_formats' => 'SVG, DXF, AI, PDF',
            'materials' => 'Acrylic, Wood, Cardboard, Leather, Fabric',
        ]);

        // Embroidery Service
        Service::create([
            'name' => 'Embroidery',
            'rate' => 18.00,
            'price' => 7.00,
            'estimated_time' => '2-4 days',
            'availability' => true,
            'description' => 'Custom embroidery services for clothing, accessories, and more.',
            'file_formats' => 'PES, DST, EXP, JEF, XXX',
            'materials' => 'Cotton, Polyester, Denim, Canvas, Felt',
        ]);
    }
} 