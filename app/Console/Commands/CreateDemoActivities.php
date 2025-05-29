<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CreateDemoActivities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:activities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create demo activities for testing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get all users or create a demo user if none exists
        $users = User::all();
        
        if ($users->isEmpty()) {
            $this->info('No users found. Creating a demo user...');
            
            $userId = DB::table('users')->insertGetId([
                'name' => 'Demo User',
                'email' => 'demo@example.com',
                'password' => bcrypt('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            $this->info("Created demo user with ID: {$userId}");
        } else {
            $userId = $users->first()->id;
            $this->info("Using existing user with ID: {$userId}");
        }
        
        // Create sample activities
        $activities = [
            [
                'user_id' => $userId,
                'type' => 'welcome',
                'message' => 'Welcome to FabHub!',
                'data' => ['details' => 'Explore our fabrication services and place your first order.'],
            ],
            [
                'user_id' => $userId,
                'type' => 'order',
                'message' => 'You placed an order for 3D Printing service',
                'data' => ['order_id' => 1, 'service' => '3D Printing'],
            ],
            [
                'user_id' => $userId,
                'type' => 'status-change',
                'message' => 'Your order #1 has been processed',
                'data' => ['order_id' => 1, 'old_status' => 'pending', 'new_status' => 'processing'],
            ],
            [
                'user_id' => $userId,
                'type' => 'notification',
                'message' => 'Your file is ready for pickup',
                'data' => ['order_id' => 1],
            ],
            [
                'user_id' => $userId,
                'type' => 'login',
                'message' => 'You logged in to your account',
                'data' => ['ip' => '127.0.0.1'],
            ],
        ];
        
        foreach ($activities as $activityData) {
            Activity::create($activityData);
            $this->info("Created activity: {$activityData['type']} - {$activityData['message']}");
        }
        
        $this->info('Demo activities created successfully!');
    }
} 