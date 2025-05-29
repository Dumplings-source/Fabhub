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
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Service Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $service->name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="rate" class="block text-sm font-medium text-gray-700">Base Rate ($)</label>
                        <input type="number" name="rate" id="rate" step="0.01" value="{{ old('rate', $service->rate) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="price" class="block text-sm font-medium text-gray-700">Base Price ($)</label>
                        <input type="number" name="price" id="price" step="0.01" value="{{ old('price', $service->price) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
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
                    
                    <div class="mb-4">
                        <label for="file_formats" class="block text-sm font-medium text-gray-700">File Formats</label>
                        <input type="text" name="file_formats" id="file_formats" value="{{ old('file_formats', $service->file_formats) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="materials" class="block text-sm font-medium text-gray-700">Materials (comma-separated)</label>
                        <input type="text" name="materials" id="materials" value="{{ old('materials', $service->materials) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <p class="mt-1 text-sm text-gray-500">Enter materials separated by commas (e.g., PLA, ABS, PETG)</p>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description', $service->description) }}</textarea>
                </div>
                
                <div class="flex justify-end space-x-2">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update Service</button>
                    <a href="{{ route('services') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">Cancel</a>
                </div>
            </form>
            
            <!-- Material Prices Section -->
            <div class="mt-8 border-t pt-6">
                <h3 class="text-xl font-semibold mb-4">Material Prices</h3>
                <p class="mb-4 text-gray-600">Set specific prices for each material. If not set, the base price will be used.</p>
                
                <div class="bg-gray-50 p-4 rounded-md mb-6">
                    <form method="POST" action="{{ route('services.updateMaterialPrices', $service->id) }}" id="material-prices-form">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4" id="material-prices-container">
                            @foreach($service->getMaterialsArray() as $index => $material)
                                <div class="material-price-item">
                                    <label class="block text-sm font-medium text-gray-700">{{ $material }}</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                            $
                                        </span>
                                        <input type="number" name="material_prices[{{ $material }}]" 
                                            value="{{ $service->materialPrices->where('material_name', $material)->first() ? $service->materialPrices->where('material_name', $material)->first()->price : $service->price }}" 
                                            step="0.01" min="0"
                                            class="focus:ring-blue-500 focus:border-blue-500 flex-1 block w-full rounded-none rounded-r-md border-gray-300">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-4 flex justify-end">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update Material Prices</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <script>
            // Update material prices form when materials input changes
            document.getElementById('materials').addEventListener('change', function() {
                const materialsInput = this.value;
                const materials = materialsInput.split(',').map(material => material.trim()).filter(material => material);
                
                const container = document.getElementById('material-prices-container');
                container.innerHTML = '';
                
                materials.forEach(material => {
                    const div = document.createElement('div');
                    div.className = 'material-price-item';
                    div.innerHTML = `
                        <label class="block text-sm font-medium text-gray-700">${material}</label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                $
                            </span>
                            <input type="number" name="material_prices[${material}]" 
                                value="{{ $service->price }}" 
                                step="0.01" min="0"
                                class="focus:ring-blue-500 focus:border-blue-500 flex-1 block w-full rounded-none rounded-r-md border-gray-300">
                        </div>
                    `;
                    container.appendChild(div);
                });
            });
        </script>
    @endif
@endsection 