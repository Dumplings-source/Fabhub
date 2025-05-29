<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ActivityController extends Controller
{
    /**
     * Display a listing of the user's activities.
     */
    public function index()
    {
        try {
            $userId = Auth::check() ? Auth::id() : null;
            
            // If not authenticated, provide a welcome activity
            if (!$userId) {
                $welcomeActivity = [
                    'id' => 0,
                    'user_id' => 0,
                    'type' => 'system',
                    'message' => 'Welcome to FabHub!',
                    'data' => ['details' => 'Explore our fabrication services and place your first order.'],
                    'created_at' => now()->toISOString(),
                    'updated_at' => now()->toISOString()
                ];
                
                return response()->json([$welcomeActivity]);
            }
            
            // Find activities for the user
            $activities = Activity::where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
            
            // If no activities found, provide a welcome message
            if ($activities->isEmpty()) {
                // Create a welcome activity in the database
                $welcome = new Activity();
                $welcome->user_id = $userId;
                $welcome->type = 'welcome';
                $welcome->message = 'Welcome to FabHub!';
                $welcome->data = ['details' => 'Explore our fabrication services and place your first order.'];
                $welcome->save();
                
                // Fetch again to include the welcome message
                $activities = Activity::where('user_id', $userId)
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();
            }

            // Log the count of activities for debugging
            Log::info('Activities fetched: ' . $activities->count() . ' for user ID: ' . $userId);
            
            return response()->json($activities);
        } catch (\Exception $e) {
            Log::error('Error fetching activities: ' . $e->getMessage());
            
            // Return a fallback welcome message even if there's an error
            $fallbackActivity = [
                'id' => 0,
                'user_id' => 0,
                'type' => 'system',
                'message' => 'Welcome to FabHub!',
                'data' => ['details' => 'Explore our fabrication services and place your first order.'],
                'created_at' => now()->toISOString(),
                'updated_at' => now()->toISOString()
            ];
            
            return response()->json([$fallbackActivity]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created activity in storage.
     */
    public function store(Request $request)
    {
        try {
            $userId = Auth::check() ? Auth::id() : null;
            
            // If not authenticated, log the attempt but return success
            if (!$userId) {
                Log::warning('Unauthenticated user tried to store activity');
                return response()->json([
                    'message' => 'Activity logged',
                    'activity' => null
                ], 200);
            }

            $validated = $request->validate([
                'type' => 'required|string',
                'message' => 'required|string',
                'data' => 'nullable|array',
            ]);

            // Create activity with sanitized data
            $activity = new Activity();
            $activity->user_id = $userId;
            $activity->type = $validated['type'];
            $activity->message = $validated['message'];
            
            // Handle data as JSON correctly
            if (isset($validated['data'])) {
                $activity->data = $validated['data'];
            }
            
            $activity->save();

            Log::info('Activity created: ' . $activity->id);
            
            return response()->json([
                'message' => 'Activity logged successfully',
                'activity' => $activity
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating activity: ' . $e->getMessage());
            return response()->json([
                'message' => 'Activity noted',
                'error' => $e->getMessage()
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Activity $activity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activity $activity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Activity $activity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        //
    }

    /**
     * Log a user activity (static helper method).
     */
    public static function logActivity($userId, $type, $message, $data = null)
    {
        try {
            // If no user ID provided, just return without logging
            if (!$userId) {
                return null;
            }
            
            $activity = new Activity();
            $activity->user_id = $userId;
            $activity->type = $type;
            $activity->message = $message;
            $activity->data = $data;
            $activity->save();
            
            Log::info('Activity logged via helper: ' . $activity->id);
            
            return $activity;
        } catch (\Exception $e) {
            Log::error('Error logging activity via helper: ' . $e->getMessage());
            return null;
        }
    }
}
