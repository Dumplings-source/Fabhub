@extends('admin.dashboard')

@section('content')
    @if(!auth('admin')->check())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 m-6" role="alert">
            <p class="font-bold">Access Denied</p>
            <p>You do not have permission to view this page.</p>
        </div>
    @else
        <div class="bg-white shadow rounded-lg p-6 m-6">
            <h2 class="text-2xl font-semibold mb-6">Notifications</h2>

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

            <!-- Notifications List -->
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Message</th>
                            <th class="py-3 px-6 text-left">Type</th>
                            <th class="py-3 px-6 text-left">Date</th>
                            <th class="py-3 px-6 text-left">Status</th>
                            <th class="py-3 px-6 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach($notifications as $notification)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6">{{ $notification->data['message'] ?? 'No message' }}</td>
                                <td class="py-3 px-6">{{ $notification->type }}</td>
                                <td class="py-3 px-6">{{ $notification->created_at->format('Y-m-d H:i') }}</td>
                                <td class="py-3 px-6">
                                    <span class="{{ $notification->read_at ? 'text-green-500' : 'text-yellow-500' }}">
                                        {{ $notification->read_at ? 'Read' : 'Unread' }}
                                    </span>
                                </td>
                                <td class="py-3 px-6 flex space-x-2">
                                    @if(!$notification->read_at)
                                        <form method="POST" action="{{ route('notifications.markAsRead', $notification->id) }}">
                                            @csrf
                                            <button type="submit" class="text-blue-500 hover:underline">Mark as Read</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        @if(empty($notifications) || $notifications->isEmpty())
                            <tr>
                                <td colspan="5" class="py-3 px-6 text-center">No notifications available</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection