@extends('admin.dashboard')

@section('content')
    @if(!auth('admin')->check())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 m-6 rounded-lg shadow-md" role="alert">
            <p class="font-bold">Access Denied</p>
            <p>You do not have permission to view this page.</p>
        </div>
    @else
        <!-- Enhanced Card with Admin Dashboard Design -->
        <div class="content-area p-6">
            <div class="header-card p-6 rounded-lg mb-6">
                <h2 class="text-3xl font-bold text-primary-accent mb-2">Edit Service</h2>
                <p class="text-complementary">Modify service details and pricing information</p>
            </div>

            <!-- Success/Error Messages with Enhanced Styling -->
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-400 text-green-800 p-4 mb-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-3 text-green-500"></i>
                        {{ session('success') }}
                    </div>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-400 text-red-800 p-4 mb-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-3 text-red-500"></i>
                        {{ session('error') }}
                    </div>
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-400 text-red-800 p-4 mb-6 rounded-lg shadow-sm">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-exclamation-triangle mr-3 text-red-500"></i>
                        <span class="font-semibold">Please correct the following errors:</span>
                    </div>
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Enhanced Form Card -->
            <div class="header-card p-8 rounded-lg shadow-lg">
                <form method="POST" action="{{ route('services.update', $service->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-semibold text-primary-accent mb-2">Service Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $service->name) }}" 
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-4 focus:ring-primary-base focus:border-complementary transition-all duration-300 bg-secondary-palette" required>
                        </div>
                        
                        <div class="mb-6">
                            <label for="rate" class="block text-sm font-semibold text-primary-accent mb-2">Hourly Rate ($)</label>
                            <input type="number" name="rate" id="rate" step="0.01" value="{{ old('rate', $service->rate) }}" 
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-4 focus:ring-primary-base focus:border-complementary transition-all duration-300 bg-secondary-palette" required>
                        </div>
                        
                        <div class="mb-6">
                            <label for="price" class="block text-sm font-semibold text-primary-accent mb-2">Base Price ($)</label>
                            <input type="number" name="price" id="price" step="0.01" value="{{ old('price', $service->price) }}" 
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-4 focus:ring-primary-base focus:border-complementary transition-all duration-300 bg-secondary-palette" required>
                        </div>
                        
                        <div class="mb-6">
                            <label for="estimated_time" class="block text-sm font-semibold text-primary-accent mb-2">Estimated Time</label>
                            <input type="text" name="estimated_time" id="estimated_time" value="{{ old('estimated_time', $service->estimated_time) }}" 
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-4 focus:ring-primary-base focus:border-complementary transition-all duration-300 bg-secondary-palette" required>
                        </div>
                        
                        <div class="mb-6">
                            <label for="availability" class="block text-sm font-semibold text-primary-accent mb-2">Availability</label>
                            <select name="availability" id="availability" 
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-4 focus:ring-primary-base focus:border-complementary transition-all duration-300 bg-secondary-palette" required>
                                <option value="1" {{ $service->availability ? 'selected' : '' }}>Available</option>
                                <option value="0" {{ !$service->availability ? 'selected' : '' }}>Unavailable</option>
                            </select>
                        </div>
                        
                        <div class="mb-6">
                            <label for="file_formats" class="block text-sm font-semibold text-primary-accent mb-2">File Formats</label>
                            <input type="text" name="file_formats" id="file_formats" value="{{ old('file_formats', $service->file_formats) }}" 
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-4 focus:ring-primary-base focus:border-complementary transition-all duration-300 bg-secondary-palette" required>
                        </div>
                        
                        <div class="mb-6 md:col-span-2">
                            <label for="materials" class="block text-sm font-semibold text-primary-accent mb-2">Materials (comma-separated)</label>
                            <input type="text" name="materials" id="materials" value="{{ old('materials', $service->materials) }}" 
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-4 focus:ring-primary-base focus:border-complementary transition-all duration-300 bg-secondary-palette" required>
                            <p class="mt-2 text-sm text-complementary flex items-center">
                                <i class="fas fa-info-circle mr-2"></i>
                                Enter materials separated by commas (e.g., PLA, ABS, PETG)
                            </p>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-semibold text-primary-accent mb-2">Description</label>
                        <textarea name="description" id="description" rows="4" 
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-4 focus:ring-primary-base focus:border-complementary transition-all duration-300 bg-secondary-palette">{{ old('description', $service->description) }}</textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-4">
                        <button type="submit" class="gradient-primary text-white px-6 py-3 rounded-lg font-semibold hover:shadow-lg transition-all duration-300 flex items-center">
                            <i class="fas fa-save mr-2"></i>
                            Update Service
                        </button>
                        <a href="{{ route('services') }}" class="bg-gray-200 text-primary-accent px-6 py-3 rounded-lg font-semibold hover:bg-gray-300 transition-all duration-300 flex items-center">
                            <i class="fas fa-times mr-2"></i>
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
            
            <!-- Material Prices Section with Enhanced Design -->
            <div class="header-card p-8 rounded-lg shadow-lg mt-6">
                <div class="flex items-center mb-6">
                    <div class="bg-secondary-accent p-3 rounded-lg mr-4">
                        <i class="fas fa-dollar-sign text-primary-accent text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-primary-accent">Material Prices</h3>
                        <p class="text-complementary">Set specific prices for each material. If not set, the base price will be used.</p>
                    </div>
                </div>
                
                <div class="bg-secondary-palette p-6 rounded-lg border-2 border-primary-base border-opacity-20">
                    <form method="POST" action="{{ route('services.updateMaterialPrices', $service->id) }}" id="material-prices-form">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="material-prices-container">
                            @foreach($service->getMaterialsArray() as $index => $material)
                                <div class="material-price-item">
                                    <label class="block text-sm font-semibold text-primary-accent mb-2">{{ $material }}</label>
                                    <div class="flex rounded-lg shadow-sm">
                                        <span class="inline-flex items-center px-4 rounded-l-lg border-2 border-r-0 border-gray-200 bg-primary-base text-primary-accent font-bold">
                                            $
                                        </span>
                                        <input type="number" name="material_prices[{{ $material }}]" 
                                            value="{{ $service->materialPrices->where('material_name', $material)->first() ? $service->materialPrices->where('material_name', $material)->first()->price : $service->price }}" 
                                            step="0.01" min="0"
                                            class="flex-1 px-4 py-3 border-2 border-gray-200 rounded-r-lg focus:ring-4 focus:ring-primary-base focus:border-complementary transition-all duration-300 bg-white">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="gradient-secondary text-primary-accent px-6 py-3 rounded-lg font-semibold hover:shadow-lg transition-all duration-300 flex items-center">
                                <i class="fas fa-sync-alt mr-2"></i>
                                Update Material Prices
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    
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
                    <label class="block text-sm font-semibold text-primary-accent mb-2">${material}</label>
                    <div class="flex rounded-lg shadow-sm">
                        <span class="inline-flex items-center px-4 rounded-l-lg border-2 border-r-0 border-gray-200 bg-primary-base text-primary-accent font-bold">
                            $
                        </span>
                        <input type="number" name="material_prices[${material}]" 
                            value="{{ $service->price }}" 
                            step="0.01" min="0"
                            class="flex-1 px-4 py-3 border-2 border-gray-200 rounded-r-lg focus:ring-4 focus:ring-primary-base focus:border-complementary transition-all duration-300 bg-white">
                    </div>
                `;
                container.appendChild(div);
            });
        });
    </script>
@endsection 