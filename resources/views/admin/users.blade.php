@extends('admin.dashboard')

@section('content')
    <div class="flex flex-col lg:flex-row min-h-screen">
        <!-- Sidebar -->
        <aside class="w-full lg:w-64 bg-gray-800 text-white p-6 lg:min-h-screen">
            <h2 class="text-xl font-semibold mb-6">Admin Menu</h2>
            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Dashboard</a>
                <a href="{{ route('services') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Service Management</a>
                <a href="{{ route('admin.orders') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Orders</a>
                <a href="{{ route('admin.users') }}" class="block px-4 py-2 rounded bg-gray-700">User Management</a>
                <a href="{{ route('admin.reservations') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Reservations</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            @if(!auth('admin')->check())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 m-6" role="alert">
                    <p class="font-bold">Access Denied</p>
                    <p>You do not have permission to view this page.</p>
                </div>
            @else
                <div class="bg-white shadow rounded-lg p-6 m-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">User Management</h2>
                        <button onclick="document.getElementById('add-user-modal').classList.toggle('hidden')" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            <i class="fas fa-plus mr-2"></i>Add New User
                        </button>
                    </div>

                    <!-- Success/Error Messages -->
                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Filter Section -->
                    <div class="mb-6">
                        <div class="flex flex-wrap items-center gap-2 md:gap-4">
                            <span class="text-sm font-medium text-gray-700 mb-2 md:mb-0 w-full md:w-auto">Filter by Role:</span>
                            <div class="flex flex-wrap gap-2 w-full md:w-auto">
                                <a href="{{ route('admin.users', ['role' => '']) }}" 
                                   class="px-3 py-2 text-xs md:text-sm rounded-md {{ !request('role') ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                    All
                                </a>
                                <a href="{{ route('admin.users', ['role' => 'admin']) }}" 
                                   class="px-3 py-2 text-xs md:text-sm rounded-md {{ request('role') == 'admin' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                    Admins
                                </a>
                                <a href="{{ route('admin.users', ['role' => 'staff']) }}" 
                                   class="px-3 py-2 text-xs md:text-sm rounded-md {{ request('role') == 'staff' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                    Staff
                                </a>
                                <a href="{{ route('admin.users', ['role' => 'customer']) }}" 
                                   class="px-3 py-2 text-xs md:text-sm rounded-md {{ request('role') == 'customer' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                    Customers
                                </a>
                            </div>
                        </div>
                        
                        <!-- Filter summary -->
                        <div class="mt-3 text-sm text-gray-600">
                            @if(request('role'))
                                Showing {{ ucfirst(request('role')) }} users
                                <span class="text-xs ml-2 text-gray-500">({{ $users->count() }} {{ Str::plural('user', $users->count()) }})</span>
                            @else
                                Showing all users
                                <span class="text-xs ml-2 text-gray-500">({{ $users->count() }} {{ Str::plural('user', $users->count()) }})</span>
                            @endif
                        </div>
                    </div>

                    <!-- Users Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead>
                                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">ID</th>
                                    <th class="py-3 px-6 text-left">Name</th>
                                    <th class="py-3 px-6 text-left">Email</th>
                                    <th class="py-3 px-6 text-left">Role</th>
                                    <th class="py-3 px-6 text-left">Date Joined</th>
                                    <th class="py-3 px-6 text-left">Status</th>
                                    <th class="py-3 px-6 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @foreach($users as $user)
                                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                                        <td class="py-3 px-6">{{ $user->id }}</td>
                                        <td class="py-3 px-6">{{ $user->name }}</td>
                                        <td class="py-3 px-6">{{ $user->email }}</td>
                                        <td class="py-3 px-6">
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : '' }}
                                                {{ $user->role === 'staff' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ $user->role === 'customer' ? 'bg-green-100 text-green-800' : '' }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-6">{{ $user->created_at->format('M d, Y') }}</td>
                                        <td class="py-3 px-6">
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span>
                                        </td>
                                        <td class="py-3 px-6 flex space-x-2">
                                            <button onclick="openEditModal({{ $user->id }})" class="text-blue-500 hover:underline">Edit</button>
                                            <form method="POST" action="{{ route('admin.users.delete', $user->id) }}" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                            </form>
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
        </main>
    </div>

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
@endsection