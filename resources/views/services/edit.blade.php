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

            <form method="POST" action="{{ route('services.update', $service->id) }}">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Service Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $service->name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <div>
                        <label for="rate" class="block text-sm font-medium text-gray-700">Rate ($)</label>
                        <input type="number" name="rate" id="rate" step="0.01" value="{{ old('rate', $service->rate) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700">Price ($)</label>
                        <input type="number" name="price" id="price" step="0.01" value="{{ old('price', $service->price) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <div>
                        <label for="estimated_time" class="block text-sm font-medium text-gray-700">Estimated Time</label>
                        <input type="text" name="estimated_time" id="estimated_time" value="{{ old('estimated_time', $service->estimated_time) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <div>
                        <label for="availability" class="block text-sm font-medium text-gray-700">Availability</label>
                        <select name="availability" id="availability" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="1" {{ old('availability', $service->availability) == 1 ? 'selected' : '' }}>Available</option>
                            <option value="0" {{ old('availability', $service->availability) == 0 ? 'selected' : '' }}>Unavailable</option>
                        </select>
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description', $service->description) }}</textarea>
                    </div>
                    <div>
                        <label for="file_formats" class="block text-sm font-medium text-gray-700">File Formats</label>
                        <input type="text" name="file_formats" id="file_formats" value="{{ old('file_formats', $service->file_formats) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <div>
                        <label for="materials" class="block text-sm font-medium text-gray-700">Materials</label>
                        <input type="text" name="materials" id="materials" value="{{ old('materials', $service->materials) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                </div>
                <div class="mt-4 flex justify-end space-x-2">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update</button>
                    <a href="{{ route('services') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">Cancel</a>
                </div>
            </form>

            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mt-4">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    @endif
@endsection