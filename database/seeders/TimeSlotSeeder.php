<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\TimeSlot;

class TimeSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timeSlots = [
            '08:00 AM - 10:00 AM',
            '10:00 AM - 12:00 PM',
            '01:00 PM - 03:00 PM',
            '03:00 PM - 05:00 PM'
        ];

        $services = Service::all();

        foreach ($services as $service) {
            foreach ($timeSlots as $slot) {
                TimeSlot::updateOrCreate([
                    'service_id' => $service->id,
                    'name' => $slot
                ], [
                    'is_available' => true
                ]);
            }
        }
    }
}
