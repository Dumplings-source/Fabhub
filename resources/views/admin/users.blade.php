@extends('admin.dashboard')

@section('page-title', 'User Management')

@section('content')
    <style>
        .card-modern {
            background: linear-gradient(135deg, var(--secondary-palette) 0%, #ffffff 100%);
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 25px rgba(0, 23, 64, 0.1);
            border-radius: 16px;
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-base) 0%, var(--secondary-accent) 100%);
            color: var(--primary-accent);
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(244, 212, 98, 0.4);
            color: var(--primary-accent);
        }
        
        .alert-success {
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
            border-left: 4px solid #22c55e;
            color: #15803d;
        }
        
        .alert-error {
            background: linear-gradient(135deg, #fef2f2 0%, #fecaca 100%);
            border-left: 4px solid #ef4444;
            color: #dc2626;
        }
        
        .table-header {
            background: linear-gradient(135deg, var(--primary-accent) 0%, var(--complementary-accent) 100%);
            color: white;
        }
        
        .table-row:hover {
            background: linear-gradient(135deg, var(--secondary-palette) 0%, #f8fafc 100%);
            transform: scale(1.01);
            transition: all 0.2s ease;
        }
        
        .badge-active {
            background: linear-gradient(45deg, #22c55e, #16a34a);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .badge-inactive {
            background: linear-gradient(45deg, #ef4444, #dc2626);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
    </style>

    @if(!auth('admin')->check())
        <div class="alert-error p-4 mb-6 rounded-lg" role="alert">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle mr-3 text-lg"></i>
                <div>
                    <p class="font-bold">Access Denied</p>
                    <p>You do not have permission to view this page.</p>
                </div>
            </div>
        </div>
    @else
        <div class="card-modern p-8">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h3 class="text-3xl font-bold text-primary-accent mb-2">User Management</h3>
                    <p class="text-complementary">Manage system users and their permissions</p>
                </div>
                <button onclick="document.getElementById('add-user-modal').classList.toggle('hidden')" class="btn-primary-custom px-6 py-3 rounded-lg flex items-center space-x-2 hover:shadow-lg transition-all">
                    <i class="fas fa-plus"></i>
                    <span>Add New User</span>
                </button>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert-success p-4 mb-6 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-3 text-lg"></i>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif
            @if(session('error'))
                <div class="alert-error p-4 mb-6 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-3 text-lg"></i>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert-error p-4 mb-6 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle mr-3 text-lg"></i>
                        <div>
                            <p class="font-medium mb-2">Please fix the following errors:</p>
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li class="text-sm">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Enhanced Filter Section -->
            <div class="mb-8 p-6 bg-gradient-to-r from-gray-50 to-white rounded-xl border border-gray-200">
                <div class="flex flex-wrap items-center gap-4">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-filter text-complementary"></i>
                        <span class="text-sm font-semibold text-primary-accent">Filter by Role:</span>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('admin.users', ['role' => '']) }}" 
                           class="px-4 py-2 text-sm rounded-lg transition-all {{ !request('role') ? 'bg-primary-accent text-white shadow-lg' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-300' }}">
                            <i class="fas fa-users mr-2"></i>All Users
                        </a>
                        <a href="{{ route('admin.users', ['role' => 'admin']) }}" 
                           class="px-4 py-2 text-sm rounded-lg transition-all {{ request('role') == 'admin' ? 'bg-primary-accent text-white shadow-lg' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-300' }}">
                            <i class="fas fa-crown mr-2"></i>Admins
                        </a>
                        <a href="{{ route('admin.users', ['role' => 'staff']) }}" 
                           class="px-4 py-2 text-sm rounded-lg transition-all {{ request('role') == 'staff' ? 'bg-primary-accent text-white shadow-lg' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-300' }}">
                            <i class="fas fa-user-tie mr-2"></i>Staff
                        </a>
                        <a href="{{ route('admin.users', ['role' => 'customer']) }}" 
                           class="px-4 py-2 text-sm rounded-lg transition-all {{ request('role') == 'customer' ? 'bg-primary-accent text-white shadow-lg' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-300' }}">
                            <i class="fas fa-user mr-2"></i>Customers
                        </a>
                    </div>
                </div>
                
                <!-- Enhanced Filter Summary -->
                <div class="mt-4 flex items-center space-x-2 text-sm text-complementary">
                    <i class="fas fa-info-circle"></i>
                    <span>
                        @if(request('role'))
                            Showing <span class="font-semibold text-primary-accent">{{ ucfirst(request('role')) }}</span> users
                        @else
                            Showing <span class="font-semibold text-primary-accent">all</span> users
                        @endif
                        <span class="ml-2 px-2 py-1 bg-primary-base text-primary-accent rounded-full text-xs font-bold">
                            {{ $users->count() }} {{ Str::plural('user', $users->count()) }}
                        </span>
                    </span>
                </div>
            </div>

            <!-- Enhanced Users Table -->
            <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-lg">
                <table class="w-full">
                    <thead>
                        <tr class="table-header">
                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                                <i class="fas fa-user mr-2"></i>User
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                                <i class="fas fa-envelope mr-2"></i>Email
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                                <i class="fas fa-tag mr-2"></i>Role
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                                <i class="fas fa-calendar mr-2"></i>Created
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                                <i class="fas fa-toggle-on mr-2"></i>Status
                            </th>
                            <th class="px-6 py-4 text-center text-sm font-semibold uppercase tracking-wider">
                                <i class="fas fa-cogs mr-2"></i>Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($users as $user)
                            <tr class="table-row transition-all duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="profile-avatar w-10 h-10 rounded-full flex items-center justify-center font-bold text-primary-accent text-sm mr-4">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-primary-accent">{{ $user->name }}</div>
                                            <div class="text-xs text-gray-500">ID: {{ $user->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                    <div class="text-xs text-gray-500">
                                        <i class="fas fa-clock mr-1"></i>
                                        Verified {{ $user->email_verified_at ? 'Yes' : 'No' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->role === 'admin')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-purple-100 to-purple-200 text-purple-800">
                                            <i class="fas fa-crown mr-1"></i>
                                            Admin
                                        </span>
                                    @elseif($user->role === 'staff')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800">
                                            <i class="fas fa-user-tie mr-1"></i>
                                            Staff
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-green-100 to-green-200 text-green-800">
                                            <i class="fas fa-user mr-1"></i>
                                            Customer
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-plus mr-2 text-complementary"></i>
                                        {{ $user->created_at->format('M d, Y') }}
                                    </div>
                                    <div class="text-xs text-gray-400">
                                        {{ $user->created_at->diffForHumans() }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="badge-active">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Active
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex items-center justify-center space-x-3">
                                        <button onclick="openEditModal({{ $user->id }})" 
                                                class="text-complementary hover:text-primary-accent transition-colors duration-200 hover:scale-110 transform">
                                            <i class="fas fa-edit text-lg"></i>
                                        </button>
                                        <form method="POST" action="{{ route('admin.users.delete', $user->id) }}" 
                                              onsubmit="return confirm('⚠️ Are you sure you want to delete {{ $user->name }}? This action cannot be undone.');" 
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-500 hover:text-red-700 transition-colors duration-200 hover:scale-110 transform">
                                                <i class="fas fa-trash text-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @if($users->isEmpty())
                            <tr>
                                <td colspan="7" class="py-3 px-6 text-center">
                                    @if(request('role'))
                                        No {{ request('role') }} users found
                                    @else
                                        No users available
                                    @endif
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <!-- Pagination Links (if applicable) -->
            <div class="mt-6">
                @if(method_exists($users, 'links'))
                    {{ $users->links() }}
                @endif
            </div>
        </div>

        <!-- Add User Modal -->
        <div id="add-user-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center z-50">
            <div class="bg-white p-5 border w-96 shadow-lg rounded-md">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Add New User</h3>
                    <button onclick="document.getElementById('add-user-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Name</label>
                        <input type="text" name="name" id="name" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                        <input type="email" name="email" id="email" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
                        <input type="password" name="password" id="password" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="role">Role</label>
                        <select name="role" id="role" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="" disabled selected>Select a role</option>
                            <option value="admin">Admin</option>
                            <option value="staff">Staff</option>
                            <option value="customer">Customer</option>
                        </select>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="document.getElementById('add-user-modal').classList.add('hidden')" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add User</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit User Modal Template (Will be populated with JavaScript) -->
        <div id="edit-user-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center z-50">
            <div class="bg-white p-5 border w-96 shadow-lg rounded-md">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Edit User</h3>
                    <button onclick="document.getElementById('edit-user-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form id="edit-user-form" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="edit-name">Name</label>
                        <input type="text" name="name" id="edit-name" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="edit-email">Email</label>
                        <input type="email" name="email" id="edit-email" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="edit-password">Password (leave blank to keep current)</label>
                        <input type="password" name="password" id="edit-password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="edit-role">Role</label>
                        <select name="role" id="edit-role" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="admin">Admin</option>
                            <option value="staff">Staff</option>
                            <option value="customer">Customer</option>
                        </select>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="document.getElementById('edit-user-modal').classList.add('hidden')" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
<script>
    function openEditModal(userId) {
        // Fetch user data from server
        fetch(`/admin/users/${userId}/edit`)
            .then(response => response.json())
            .then(data => {
                if (data.user) {
                    const user = data.user;
                    document.getElementById('edit-name').value = user.name;
                    document.getElementById('edit-email').value = user.email;
                    document.getElementById('edit-role').value = user.role;
                    document.getElementById('edit-user-form').action = `/admin/users/${userId}`;
                    document.getElementById('edit-user-modal').classList.remove('hidden');
                } else {
                    alert('Failed to load user data');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while fetching user data');
            });
    }
</script>
@endpush