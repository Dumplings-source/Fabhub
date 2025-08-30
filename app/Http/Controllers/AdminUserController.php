<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Events\NewUserAdded;

class AdminUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $users = User::latest()->get();
        return response()->json(['users' => $users]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'role' => 'required|string|in:admin,staff,customer',
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
                'email_verified_at' => now(), // Auto-verify admin created users
            ]);

            // Uncomment if you want to trigger events
            // event(new NewUserAdded($user));

            return redirect()->route('admin.users')->with('success', 'User created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create user: ' . $e->getMessage())->withInput();
        }
    }

    public function showUserManagement(Request $request)
    {
        try {
            // Get the role filter from the request
            $role = $request->query('role');
            
            // Start with a base query
            $query = User::query();
            
            // Apply role filter if provided
            if ($role && in_array($role, ['admin', 'staff', 'customer'])) {
                $query->where('role', $role);
            }
            
            // Get all users with optional filtering, ordered by latest
            $users = $query->latest()->get();
            
            return view('admin.users', compact('users'));
        } catch (\Exception $e) {
            return redirect()->route('admin.dashboard')->with('error', 'Failed to load user management: ' . $e->getMessage());
        }
    }
    
    public function edit(User $user)
    {
        try {
            return response()->json([
                'success' => true,
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load user data'
            ], 500);
        }
    }
    
    public function update(Request $request, User $user)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'role' => 'required|string|in:admin,staff,customer',
                'password' => 'nullable|string|min:6',
            ]);
            
            // Update user data
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->role = $validated['role'];
            
            // Update password only if provided
            if (!empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }
            
            $user->save();
            
            return redirect()->route('admin.users')->with('success', 'User updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update user: ' . $e->getMessage())->withInput();
        }
    }
    
    public function destroy(User $user)
    {
        try {
            // Prevent deleting your own account if you're logged in as admin
            if (Auth::guard('admin')->check() && Auth::guard('admin')->id() === $user->id) {
                return redirect()->back()->with('error', 'You cannot delete your own account');
            }
            
            // Store user info for success message
            $userName = $user->name;
            
            // Delete the user
            $user->delete();
            
            return redirect()->route('admin.users')->with('success', "User '{$userName}' deleted successfully!");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }

    /**
     * Toggle user status (activate/deactivate)
     */
    public function toggleStatus(User $user)
    {
        try {
            $user->is_active = !$user->is_active;
            $user->save();
            
            $status = $user->is_active ? 'activated' : 'deactivated';
            return redirect()->route('admin.users')->with('success', "User {$status} successfully!");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update user status: ' . $e->getMessage());
        }
    }

    /**
     * Bulk actions for users
     */
    public function bulkAction(Request $request)
    {
        try {
            $validated = $request->validate([
                'action' => 'required|string|in:delete,activate,deactivate',
                'user_ids' => 'required|array',
                'user_ids.*' => 'exists:users,id'
            ]);

            $users = User::whereIn('id', $validated['user_ids'])->get();
            $count = $users->count();

            switch ($validated['action']) {
                case 'delete':
                    // Prevent deleting own account
                    $adminId = Auth::guard('admin')->id();
                    $users = $users->filter(function($user) use ($adminId) {
                        return $user->id !== $adminId;
                    });
                    $users->each->delete();
                    break;
                case 'activate':
                    $users->each(function($user) {
                        $user->update(['is_active' => true]);
                    });
                    break;
                case 'deactivate':
                    $users->each(function($user) {
                        $user->update(['is_active' => false]);
                    });
                    break;
            }

            return redirect()->route('admin.users')->with('success', "Bulk action completed on {$count} users!");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to perform bulk action: ' . $e->getMessage());
        }
    }
}