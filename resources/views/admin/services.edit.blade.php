@extends('admin.dashboard')

@section('content')
    @if(!auth('admin')->check())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 m-6" role="alert">
            <p class="font-bold">Access Denied</p>
            <p>You do not have permission to view this page.</p>
        </div>
    @else
        <div class="bg-white shadow rounded-lg p-6 m-6">
            <h2 class="text-2xl font-semibold mb-6">Edit Service</h2>

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

            <!-- Edit Form -->
            <form method="POST" action="{{ route('services.update', $service->id) }}">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Service Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $service->name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div class="mb-4">
                    <label for="rate" class="block text-sm font-medium text-gray-700">Rate ($)</label>
                    <input type="number" name="rate" id="rate" step="0.01" value="{{ old('rate', $service->rate) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div class="mb-4">
                    <label for="estimated_time" class="block text-sm font-medium text-gray-700">Estimated Time</label>
                    <input type="text" name="estimated_time" id="estimated_time" value="{{ old('estimated_time', $service->estimated_time) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div class="mb-4">
                    <label for="availability" class="block text-sm font-medium text-gray-700">Availability</label>
                    <select name="availability" id="availability" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="1" {{ $service->availability ? 'selected' : '' }}>Available</option>
                        <option value="0" {{ !$service->availability ? 'selected' : '' }}>Unavailable</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update</button>
                    <a href="{{ route('services') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">Cancel</a>
                </div>
            </form>
        </div>
    @endif
@endsection