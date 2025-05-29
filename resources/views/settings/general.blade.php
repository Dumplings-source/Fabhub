@extends('admin.dashboard')

@section('content')
    @if(!auth('admin')->check())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 m-6" role="alert">
            <p class="font-bold">Access Denied</p>
            <p>You do not have permission to view this page.</p>
        </div>
    @else
        <div class="bg-white shadow rounded-lg p-6 m-6">
            <h2 class="text-2xl font-semibold mb-6">General Settings</h2>
            <form method="POST" action="{{ route('settings.general') }}">
                @csrf
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="site_name" class="block text-sm font-medium text-gray-700">Site Name</label>
                        <input type="text" name="site_name" id="site_name" value="{{ old('site_name', 'CTUFABLAB') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                <div class="mt-4 flex justify-end">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Save</button>
                </div>
            </form>
        </div>
    @endif
@endsection