<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Events\NewUserAdded;

class AdminUserController extends Controller
{
    public function index()
    {
        return response()->json(['users' => User::all()]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'role' => 'required|string',
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'role' => $validated['role'],
            ]);
            // event(new NewUserAdded($user)); // Commented out to avoid potential broadcasting issues

            return redirect()->route('admin.users')->with('success', 'User added!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add user: ' . $e->getMessage());
        }
    }

    public function showDashboard(Request $request)
    {
        $activeTab = $request->query('tab', 'dashboard');
        return view('dashboard', compact('activeTab'));
    }

    public function showUserManagement(Request $request)
    {
        // Get the role filter from the request
        $role = $request->query('role');
        
        // Start with a base query
        $query = User::query();
        
        // Apply role filter if provided
        if ($role) {
            $query->where('role', $role);
        }
        
        // Get all users with optional filtering
        $users = $query->latest()->get();
        
        return view('admin.users', compact('users'));
    }
    
    public function edit(User $user)
    {
        return response()->json(['user' => $user]);
    }
    
    public function update(Request $request, User $user)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'role' => 'required|string',
                'password' => 'nullable|string|min:6',
            ]);
            
            // Update user data
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->role = $validated['role'];
            
            // Update password only if provided
            if (!empty($validated['password'])) {
                $user->password = bcrypt($validated['password']);
            }
            
            $user->save();
            
            return redirect()->route('admin.users')->with('success', 'User updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update user: ' . $e->getMessage());
        }
    }
    
    public function destroy(User $user)
    {
        try {
            // Prevent deleting your own account
            if (Auth::id() === $user->id) {
                return redirect()->back()->with('error', 'You cannot delete your own account');
            }
            
            $user->delete();
            return redirect()->route('admin.users')->with('success', 'User deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }
}