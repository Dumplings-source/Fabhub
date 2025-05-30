@extends('admin.dashboard')

@section('page-title', 'Service Management')

@section('content')
    <style>
        .service-card {
            background: linear-gradient(135deg, var(--secondary-palette) 0%, #ffffff 100%);
            border: 2px solid black;
            box-shadow: 0 10px 25px rgba(0, 23, 64, 0.1);
            border-radius: 16px;
            transition: all 0.3s ease;
        }
        
        .service-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(0, 23, 64, 0.15);
        }
        
        .management-card {
            background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
            border: 1px solid #e2e8f0;
            box-shadow: 0 8px 20px rgba(0, 23, 64, 0.08);
            border-radius: 12px;
            transition: all 0.3s ease;
        }
        
        .management-card:hover {
            box-shadow: 0 12px 28px rgba(0, 23, 64, 0.12);
        }
        
        .btn-primary-gradient {
            background: linear-gradient(135deg, var(--primary-base) 0%, var(--secondary-accent) 100%);
            color: var(--primary-accent);
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
        }
        
        .btn-primary-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(244, 212, 98, 0.4);
            color: var(--primary-accent);
        }
        
        .table-enhanced {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }
        
        .table-header-enhanced {
            background: linear-gradient(135deg, var(--primary-accent) 0%, var(--complementary-accent) 100%);
            color: white;
        }
        
        .table-row-enhanced:hover {
            background: linear-gradient(135deg, var(--secondary-palette) 0%, #f8fafc 100%);
            transform: scale(1.005);
            transition: all 0.2s ease;
        }
        
        .availability-toggle-available {
            background: linear-gradient(45deg, #22c55e, #16a34a);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
        }
        
        .availability-toggle-unavailable {
            background: linear-gradient(45deg, #ef4444, #dc2626);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
        }
        
        .time-slot-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 12px;
            margin-top: 16px;
            border: 50px;
        }
        
        .time-slot-item {
            position: relative;
            background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
            border: 2px solid black;
            border-radius: 12px;
            padding: 12px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .time-slot-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 23, 64, 0.1);
        }
        
        .time-slot-item.selected {
            border-color: var(--primary-base);
            background: linear-gradient(135deg, var(--primary-base) 0%, var(--secondary-accent) 100%);
            color: var(--primary-accent);
            font-weight: 600;
        }
        
        .time-slot-item input[type="checkbox"] {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }
        
        .time-slot-label {
            font-size: 14px;
            font-weight: 500;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }
        
        .time-period {
            font-size: 12px;
            opacity: 0.8;
        }
        
        .morning-slots {
            border-left: 4px solid #fbbf24;
        }
        
        .afternoon-slots {
            border-left: 4px solid #3b82f6;
        }
        
        .service-stats {
            background: linear-gradient(135deg, var(--complementary-accent) 0%, var(--primary-accent) 100%);
            color: white;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 800;
            line-height: 1;
        }
        
        .stat-label {
            font-size: 0.875rem;
            opacity: 0.9;
            margin-top: 4px;
        }
        
        .alert-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: 1px solid #10b981;
        }
        
        .alert-error {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            border: 1px solid #ef4444;
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
        <!-- Service Statistics Header -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="service-stats">
                <div class="stat-number">{{ $services->count() }}</div>
                <div class="stat-label">Total Services</div>
            </div>
            <div class="service-stats">
                <div class="stat-number">{{ $services->where('availability', true)->count() }}</div>
                <div class="stat-label">Available</div>
            </div>
            <div class="service-stats">
                <div class="stat-number">{{ $services->where('availability', false)->count() }}</div>
                <div class="stat-label">Unavailable</div>
            </div>
            <div class="service-stats">
                <div class="stat-number">${{ number_format($services->avg('price'), 0) }}</div>
                <div class="stat-label">Avg. Price</div>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Main Content - Service Management -->
            <div class="lg:col-span-2">
                <div class="service-card p-8">
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h3 class="text-3xl font-bold text-primary-accent mb-2">Services</h3>
                            <p class="text-complementary">Manage your fabrication lab services</p>
                        </div>
                        <button onclick="document.getElementById('add-service-modal').classList.toggle('hidden')" 
                                class="btn-primary-gradient px-6 py-3 rounded-lg flex items-center space-x-2 hover:shadow-lg transition-all">
                            <i class="fas fa-plus"></i>
                            <span>Add New Service</span>
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

                    <!-- Enhanced Services Table -->
                    <div class="table-enhanced">
                        <table class="w-full">
                            <thead>
                                <tr class="table-header-enhanced">
                                    <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                                        <i class="fas fa-cog mr-2"></i>Service
                                    </th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                                        <i class="fas fa-file-alt mr-2"></i>Description
                                    </th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                                        <i class="fas fa-dollar-sign mr-2"></i>Price
                                    </th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider">
                                        <i class="fas fa-toggle-on mr-2"></i>Status
                                    </th>
                                    <th class="px-6 py-4 text-center text-sm font-semibold uppercase tracking-wider">
                                        <i class="fas fa-tools mr-2"></i>Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($services as $service)
                                    <tr class="table-row-enhanced transition-all duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="profile-avatar w-10 h-10 rounded-full flex items-center justify-center font-bold text-primary-accent text-sm mr-4">
                                                    {{ substr($service->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="text-sm font-semibold text-primary-accent">{{ $service->name }}</div>
                                                    <div class="text-xs text-gray-500">ID: {{ $service->id }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">{{ Str::limit($service->description, 40) }}</div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                <i class="fas fa-layer-group mr-1"></i>
                                                Materials: {{ Str::limit($service->materials, 30) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-lg font-bold text-complementary">${{ number_format($service->price, 2) }}</div>
                                            <div class="text-xs text-gray-500">per hour</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <button onclick="toggleServiceAvailability({{ $service->id }}, {{ $service->availability ? 'true' : 'false' }})" 
                                                    class="{{ $service->availability ? 'availability-toggle-available' : 'availability-toggle-unavailable' }} hover:scale-105 transform"
                                                    id="availability-btn-{{ $service->id }}">
                                                <span id="availability-text-{{ $service->id }}">{{ $service->availability ? 'Available' : 'Unavailable' }}</span>
                                                <i id="availability-icon-{{ $service->id }}" class="fas fa-circle ml-2 {{ $service->availability ? 'text-green-200' : 'text-red-200' }}"></i>
                                            </button>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="flex items-center justify-center space-x-3">
                                                <a href="{{ route('services.edit', $service->id) }}" 
                                                   class="text-complementary hover:text-primary-accent transition-colors duration-200 hover:scale-110 transform">
                                                    <i class="fas fa-edit text-lg"></i>
                                                </a>
                                                <form method="POST" action="{{ route('services.destroy', $service->id) }}" 
                                                      onsubmit="return confirm('⚠️ Are you sure you want to delete {{ $service->name }}? This action cannot be undone.');" 
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
                                @if($services->isEmpty())
                                    <tr>
                                        <td colspan="5" class="py-8 px-6 text-center text-gray-500">
                                            <i class="fas fa-inbox text-4xl mb-4 text-gray-300"></i>
                                            <p class="text-lg">No services available</p>
                                            <p class="text-sm">Add your first service to get started</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Enhanced Sidebar - Management Tools -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Material Management Section -->
                <div class="management-card p-6">
                    <div class="flex items-center mb-6">
                        <div class="p-3 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg mr-4">
                            <i class="fas fa-cubes text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-primary-accent">Manage Materials</h3>
                            <p class="text-sm text-gray-600">Update service materials</p>
                        </div>
                    </div>
                    
                    <form method="POST" action="{{ route('services.updateMaterials') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label for="service_id" class="block text-sm font-semibold text-gray-700 mb-2">Select Service</label>
                            <select name="service_id" id="service_id" class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 text-gray-900 focus:border-primary-base focus:ring-2 focus:ring-primary-base focus:ring-opacity-20 transition-all" required>
                                <option value="">Choose a service...</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="materials" class="block text-sm font-semibold text-gray-700 mb-2">Materials</label>
                            <input type="text" name="materials" id="materials" 
                                   class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 text-gray-900 focus:border-primary-base focus:ring-2 focus:ring-primary-base focus:ring-opacity-20 transition-all" 
                                   placeholder="e.g., PLA, ABS, PETG">
                            <p class="text-xs text-gray-500 mt-1">Separate multiple materials with commas</p>
                        </div>
                        <button type="submit" class="btn-primary-gradient w-full py-3 rounded-lg font-semibold">
                            <i class="fas fa-save mr-2"></i>Update Materials
                        </button>
                    </form>
                </div>
                
                <!-- Enhanced Time Slot Management Section -->
                <div class="management-card p-6">
                    <div class="flex items-center mb-6">
                        <div class="p-3 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg mr-4">
                            <i class="fas fa-clock text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-primary-accent">Manage Time Slots</h3>
                            <p class="text-sm text-gray-600">Set available booking times</p>
                        </div>
                    </div>
                    
                    <form method="POST" action="{{ route('services.updateTimeSlots') }}" class="space-y-6">
                        @csrf
                        <div>
                            <label for="timeslot_service_id" class="block text-sm font-semibold text-gray-700 mb-2">Select Service</label>
                            <select name="service_id" id="timeslot_service_id" class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 text-gray-900 focus:border-primary-base focus:ring-2 focus:ring-primary-base focus:ring-opacity-20 transition-all" required>
                                <option value="">Choose a service...</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Morning Time Slots -->
                        <div class="morning-slots pl-4 pr-2 py-4 bg-gradient-to-r from-yellow-50 to-orange-50 rounded-lg">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-sun text-yellow-500 mr-2"></i>
                                <h4 class="font-semibold text-gray-800">Morning Sessions</h4>
                                <span class="ml-auto text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full">9:00 AM - 12:00 PM</span>
                            </div>
                            
                            <div class="time-slot-grid">
                                <div class="time-slot-item" onclick="toggleTimeSlot('slot_9_10')">
                                    <input type="checkbox" name="time_slots[]" id="slot_9_10" value="9:00 AM - 10:00 AM">
                                    <div class="time-slot-label">
                                        <i class="fas fa-clock text-lg"></i>
                                        <span class="font-medium">9:00 - 10:00</span>
                                        <span class="time-period">AM</span>
                                    </div>
                                </div>
                                
                                <div class="time-slot-item" onclick="toggleTimeSlot('slot_10_11')">
                                    <input type="checkbox" name="time_slots[]" id="slot_10_11" value="10:00 AM - 11:00 AM">
                                    <div class="time-slot-label">
                                        <i class="fas fa-clock text-lg"></i>
                                        <span class="font-medium">10:00 - 11:00</span>
                                        <span class="time-period">AM</span>
                                    </div>
                                </div>
                                
                                <div class="time-slot-item" onclick="toggleTimeSlot('slot_11_12')">
                                    <input type="checkbox" name="time_slots[]" id="slot_11_12" value="11:00 AM - 12:00 PM">
                                    <div class="time-slot-label">
                                        <i class="fas fa-clock text-lg"></i>
                                        <span class="font-medium">11:00 - 12:00</span>
                                        <span class="time-period">AM/PM</span>
                                    </div>
                                </div>
                            </div>
                            </div>
                            
                        <!-- Afternoon Time Slots -->
                        <div class="afternoon-slots pl-4 pr-2 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-cloud-sun text-blue-500 mr-2"></i>
                                <h4 class="font-semibold text-gray-800">Afternoon Sessions</h4>
                                <span class="ml-auto text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">1:00 PM - 4:00 PM</span>
                            </div>
                            
                            <div class="time-slot-grid">
                                <div class="time-slot-item" onclick="toggleTimeSlot('slot_1_2')">
                                    <input type="checkbox" name="time_slots[]" id="slot_1_2" value="1:00 PM - 2:00 PM">
                                    <div class="time-slot-label">
                                        <i class="fas fa-clock text-lg"></i>
                                        <span class="font-medium">1:00 - 2:00</span>
                                        <span class="time-period">PM</span>
                                    </div>
                            </div>
                            
                                <div class="time-slot-item" onclick="toggleTimeSlot('slot_2_3')">
                                    <input type="checkbox" name="time_slots[]" id="slot_2_3" value="2:00 PM - 3:00 PM">
                                    <div class="time-slot-label">
                                        <i class="fas fa-clock text-lg"></i>
                                        <span class="font-medium">2:00 - 3:00</span>
                                        <span class="time-period">PM</span>
                                    </div>
                            </div>
                            
                                <div class="time-slot-item" onclick="toggleTimeSlot('slot_3_4')">
                                    <input type="checkbox" name="time_slots[]" id="slot_3_4" value="3:00 PM - 4:00 PM">
                                    <div class="time-slot-label">
                                        <i class="fas fa-clock text-lg"></i>
                                        <span class="font-medium">3:00 - 4:00</span>
                                        <span class="time-period">PM</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn-primary-gradient w-full py-3 rounded-lg font-semibold">
                            <i class="fas fa-calendar-check mr-2"></i>Update Time Slots
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Enhanced Add Service Modal -->
        <div id="add-service-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 backdrop-filter backdrop-blur-md overflow-y-auto h-full w-full flex items-center justify-center z-50">
            <div class="service-card p-8 border w-full max-w-2xl shadow-2xl mx-4">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-2xl font-bold text-primary-accent">Add New Service</h3>
                        <p class="text-complementary text-sm">Create a new fabrication service</p>
                    </div>
                    <button onclick="document.getElementById('add-service-modal').classList.add('hidden')" 
                            class="text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>
                
                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="alert-error p-4 mb-6 rounded-lg">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-exclamation-circle mr-3 text-lg"></i>
                            <span class="font-medium">Please fix the following errors:</span>
                        </div>
                        <ul class="list-disc pl-8">
                            @foreach ($errors->all() as $error)
                                <li class="text-sm">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('services.store') }}" class="space-y-6">
                            @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Service Name</label>
                            <input type="text" name="name" required 
                                   class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 text-gray-900 focus:border-primary-base focus:ring-2 focus:ring-primary-base focus:ring-opacity-20 transition-all" 
                                   placeholder="e.g., 3D Printing">
                                </div>
                                <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Hourly Rate ($)</label>
                            <input type="number" name="rate" step="0.01" required 
                                   class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 text-gray-900 focus:border-primary-base focus:ring-2 focus:ring-primary-base focus:ring-opacity-20 transition-all" 
                                   placeholder="0.00">
                                </div>
                                </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Base Price ($)</label>
                            <input type="number" name="price" step="0.01" required 
                                   class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 text-gray-900 focus:border-primary-base focus:ring-2 focus:ring-primary-base focus:ring-opacity-20 transition-all" 
                                   placeholder="0.00">
                                </div>
                                <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Estimated Time</label>
                            <input type="text" name="estimated_time" required
                                   class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 text-gray-900 focus:border-primary-base focus:ring-2 focus:ring-primary-base focus:ring-opacity-20 transition-all" 
                                   placeholder="e.g., 2-4 hours">
                                </div>
                            </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                        <textarea name="description" rows="3" 
                                  class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 text-gray-900 focus:border-primary-base focus:ring-2 focus:ring-primary-base focus:ring-opacity-20 transition-all" 
                                  placeholder="Describe the service and what it offers..."></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Supported File Formats</label>
                            <input type="text" name="file_formats" required
                                   class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 text-gray-900 focus:border-primary-base focus:ring-2 focus:ring-primary-base focus:ring-opacity-20 transition-all" 
                                   placeholder="e.g., STL, OBJ, 3MF">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Materials</label>
                            <input type="text" name="materials" required
                                   class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 text-gray-900 focus:border-primary-base focus:ring-2 focus:ring-primary-base focus:ring-opacity-20 transition-all" 
                                   placeholder="e.g., PLA, ABS, PETG (comma-separated)">
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <input type="hidden" name="availability" value="0">
                        <input type="checkbox" name="availability" value="1" id="availability" checked 
                               class="w-5 h-5 text-primary-base border-2 border-gray-300 rounded focus:ring-primary-base focus:ring-2">
                        <label for="availability" class="text-sm font-medium text-gray-700">Service Available</label>
                        </div>
                    
                    <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                        <button type="button" onclick="document.getElementById('add-service-modal').classList.add('hidden')" 
                                class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-all">
                            Cancel
                        </button>
                        <button type="submit" class="btn-primary-gradient px-6 py-3 rounded-lg font-semibold">
                            <i class="fas fa-plus mr-2"></i>Create Service
                                                </button>
                    </div>
                </form>
                    </div>
                </div>
            @endif
@endsection

@push('scripts')
<script>
    // Enhanced time slot toggle functionality
    function toggleTimeSlot(slotId) {
        const checkbox = document.getElementById(slotId);
        const container = checkbox.closest('.time-slot-item');
        
        // Toggle checkbox
        checkbox.checked = !checkbox.checked;
        
        // Update visual state
        if (checkbox.checked) {
            container.classList.add('selected');
        } else {
            container.classList.remove('selected');
        }
        
        // Add animation feedback
        container.style.transform = 'scale(0.95)';
        setTimeout(() => {
            container.style.transform = '';
        }, 150);
    }

    // Enhanced service availability toggle
    function toggleServiceAvailability(serviceId, currentStatus) {
        const button = document.getElementById(`availability-btn-${serviceId}`);
        const text = document.getElementById(`availability-text-${serviceId}`);
        const icon = document.getElementById(`availability-icon-${serviceId}`);
        
        // Show loading state
        button.disabled = true;
        text.textContent = 'Updating...';
        icon.className = 'fas fa-spinner fa-spin ml-2';
        
        // Make AJAX request
        fetch(`/admin/services/${serviceId}/toggle-availability`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                availability: !currentStatus
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update button appearance
                const newStatus = data.service.availability;
                
                button.className = newStatus 
                    ? 'availability-toggle-available hover:scale-105 transform' 
                    : 'availability-toggle-unavailable hover:scale-105 transform';
                
                text.textContent = newStatus ? 'Available' : 'Unavailable';
                icon.className = `fas fa-circle ml-2 ${newStatus ? 'text-green-200' : 'text-red-200'}`;
                
                // Update onclick handler
                button.setAttribute('onclick', `toggleServiceAvailability(${serviceId}, ${newStatus})`);
                
                // Show success notification
                showNotification(data.message, 'success');
                
                // Add visual feedback
                button.style.transform = 'scale(1.1)';
                setTimeout(() => {
                    button.style.transform = '';
                }, 200);
            } else {
                throw new Error(data.message || 'Failed to update availability');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            
            // Restore original state
            button.className = currentStatus 
                ? 'availability-toggle-available hover:scale-105 transform' 
                : 'availability-toggle-unavailable hover:scale-105 transform';
            
            text.textContent = currentStatus ? 'Available' : 'Unavailable';
            icon.className = `fas fa-circle ml-2 ${currentStatus ? 'text-green-200' : 'text-red-200'}`;
            
            showNotification('Failed to update service availability', 'error');
        })
        .finally(() => {
            button.disabled = false;
        });
    }

    // Enhanced notification system
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 max-w-sm px-6 py-4 rounded-lg shadow-lg transform transition-all duration-500 translate-x-full`;
        
        // Set colors based on type
        switch (type) {
            case 'success':
                notification.classList.add('bg-green-500', 'text-white');
                break;
            case 'error':
                notification.classList.add('bg-red-500', 'text-white');
                break;
            case 'warning':
                notification.classList.add('bg-yellow-500', 'text-white');
                break;
            default:
                notification.classList.add('bg-blue-500', 'text-white');
        }
        
        notification.innerHTML = `
            <div class="flex items-center space-x-3">
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} text-lg"></i>
                <span class="font-medium">${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-auto">
                    <i class="fas fa-times hover:text-gray-200"></i>
                </button>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 500);
        }, 5000);
    }

    // Initialize page functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize time slot visual states based on checkbox states
        document.querySelectorAll('.time-slot-item input[type="checkbox"]').forEach(checkbox => {
            const container = checkbox.closest('.time-slot-item');
            if (checkbox.checked) {
                container.classList.add('selected');
            }
        });
        
        // Add hover effects to management cards
        document.querySelectorAll('.management-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
        
        // Enhanced form validation
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const requiredFields = this.querySelectorAll('[required]');
                let isValid = true;
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('border-red-500');
                        isValid = false;
                    } else {
                        field.classList.remove('border-red-500');
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                    showNotification('Please fill in all required fields', 'error');
                }
            });
        });
        
        // Close modal when clicking outside
        document.getElementById('add-service-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });
        
        // ESC key to close modal
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.getElementById('add-service-modal').classList.add('hidden');
            }
        });
    });
</script>
@endpush