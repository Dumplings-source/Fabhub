<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Service Catalog') }}
            </h2>
            <div class="flex items-center">
                <div class="text-sm text-gray-600">
                    <a href="/" class="hover:text-primary transition-colors">Home</a> / 
                    <a href="{{ route('dashboard') }}" class="hover:text-primary transition-colors">Dashboard</a> / 
                    <span class="font-medium">Service Catalog</span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Navigation Bar -->
            <div class="bg-white shadow-sm rounded-lg mb-6">
                <nav class="d-flex p-3 border-bottom" aria-label="Tabs">
                    <a href="{{ route('dashboard') }}" class="btn fw-semibold me-3 text-secondary border-0">
                        Dashboard
                    </a>
                    <a href="{{ route('service-catalog') }}" class="btn fw-semibold me-3 text-primary border-0">
                        Service Catalog
                    </a>
                    <a href="{{ route('recent-orders') }}" class="btn fw-semibold me-3 text-secondary border-0">
                        Recent Orders
                    </a>
                    <a href="{{ route('dashboard') }}?tab=reservations" class="btn fw-semibold me-3 text-secondary border-0">
                        Reservations
                    </a>
                    <a href="{{ route('dashboard') }}?tab=notifications" class="btn fw-semibold me-3 text-secondary border-0">
                        Notifications
                    </a>
                </nav>
            </div>
            
            <!-- Service Catalog -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Service Catalog</h3>
                    @if ($services->isEmpty())
                        <div class="col-span-full text-center text-gray-500">
                            No services available at the moment.
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($services as $service)
                                <div class="border rounded-lg p-4 relative overflow-hidden">
                                    <h4 class="font-semibold text-lg mb-2">{{ $service->name }}</h4>
                                    
                                    @if (!$service->availability)
                                        <div class="mb-4 inline-block bg-red-100 text-black px-4 py-2 rounded-full text-base font-bold border-2 border-red-500">
                                            Unavailable
                                        </div>
                                    @else
                                        <div class="mb-4 inline-block bg-green-100 text-black px-4 py-2 rounded-full text-base font-bold border-2 border-green-500">
                                            Available
                                        </div>
                                    @endif
                                    
                                    <p class="text-gray-600 mb-4">{{ $service->description ?? 'No description available' }}</p>
                                    <div class="space-y-2 mb-4">
                                        <p class="text-sm"><span class="font-medium">Price:</span> Starting at ₱{{ number_format($service->price, 2) }}/hour</p>
                                        <p class="text-sm"><span class="font-medium">File Format:</span> {{ $service->file_formats }}</p>
                                        <p class="text-sm"><span class="font-medium">Materials:</span> {{ $service->materials }}</p>
                                        <p class="text-sm"><span class="font-medium">Time:</span> {{ $service->estimated_time }}</p>
                                        
                                        @php
                                            // Time slots data needed for the form
                                            $timeSlots = [];
                                            
                                            if ($service->availableTimeSlots && $service->availableTimeSlots->count() > 0) {
                                                foreach ($service->availableTimeSlots as $slot) {
                                                    $timeSlots[$slot->name] = $slot->is_available;
                                                }
                                            } else {
                                                // Fallback to simulated time slots
                                                $timeSlots = [
                                                    '9:00 AM - 10:00 AM' => $service->availability && rand(0, 1),
                                                    '10:00 AM - 11:00 AM' => $service->availability && rand(0, 1),
                                                    '11:00 AM - 12:00 PM' => $service->availability && rand(0, 1),
                                                    '1:00 PM - 2:00 PM' => $service->availability && rand(0, 1),
                                                    '2:00 PM - 3:00 PM' => $service->availability && rand(0, 1),
                                                    '3:00 PM - 4:00 PM' => $service->availability && rand(0, 1),
                                                ];
                                            }
                                        @endphp
                                    </div>
                                    
                                    <!-- Button to show order form modal -->
                                    <button 
                                        onclick="document.getElementById('order-form-{{ $service->id }}').classList.toggle('hidden')" 
                                        class="w-full {{ $service->availability ? 'bg-primary hover:bg-primary/90 text-black font-bold border-2 border-black' : 'bg-gray-400 cursor-not-allowed text-black font-bold border-2 border-red-300' }} py-3 !rounded-button transition text-lg mt-2"
                                        {{ !$service->availability ? 'disabled' : '' }}
                                    >
                                        {{ $service->availability ? 'Request Service' : 'Currently Unavailable' }}
                                    </button>
                                    
                                    <!-- Order Form Modal -->
                                    <div id="order-form-{{ $service->id }}" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center z-50">
                                        <div class="bg-white p-5 border w-96 shadow-lg rounded-md">
                                            <h3 class="text-lg font-medium text-gray-900 mb-4">Request Service: {{ $service->name }}</h3>
                                            <form id="service-form-{{ $service->id }}" method="POST" action="{{ route('service-catalog.order', $service->id) }}" enctype="multipart/form-data" onsubmit="trackFormSubmission(event, {{ $service->id }})">
                                                @csrf
                                                <input type="hidden" name="service_id" value="{{ $service->id }}">
                                                <div class="mb-4">
                                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="file-{{ $service->id }}">Design File</label>
                                                    <input type="file" name="file" id="file-{{ $service->id }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                    <p class="text-xs text-gray-500 mt-1">Any file format accepted (max 10MB)</p>
                                                    @error('file')
                                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="mb-4">
                                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="material-{{ $service->id }}">Material</label>
                                                    <select name="material" id="material-{{ $service->id }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                        <option value="" disabled selected>Select a material</option>
                                                        @foreach (explode(',', $service->materials) as $material)
                                                            <option value="{{ trim($material) }}">{{ trim($material) }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('material')
                                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="mb-4">
                                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="quantity-{{ $service->id }}">Quantity</label>
                                                    <input type="number" name="quantity" id="quantity-{{ $service->id }}" required min="1" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                    @error('quantity')
                                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="mb-4">
                                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="preferred_date-{{ $service->id }}">Preferred Date</label>
                                                    <input type="date" name="preferred_date" id="preferred_date-{{ $service->id }}" required min="{{ now()->toDateString() }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                    @error('preferred_date')
                                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="mb-4">
                                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="time_slot-{{ $service->id }}">Preferred Time Slot</label>
                                                    <select name="time_slot" id="time_slot-{{ $service->id }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                        <option value="" disabled selected>Select a time slot</option>
                                                        @foreach ($timeSlots as $slot => $available)
                                                            @if ($available)
                                                                <option value="{{ $slot }}">{{ $slot }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    <p class="text-xs text-gray-500 mt-1">Only available time slots are shown</p>
                                                    @error('time_slot')
                                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="mb-4">
                                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="notes-{{ $service->id }}">Additional Notes (Optional)</label>
                                                    <textarea name="notes" id="notes-{{ $service->id }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" rows="3"></textarea>
                                                </div>
                                                <div class="flex justify-end space-x-2">
                                                    <button type="button" onclick="document.getElementById('order-form-{{ $service->id }}').classList.add('hidden')" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
                                                    <button type="submit" id="submit-btn-{{ $service->id }}" class="bg-primary text-black font-bold px-4 py-2 rounded hover:bg-primary/90 border-2 border-black">Submit Request</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- Pagination Links -->
                        <div class="mt-6">
                            {{ $services->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function trackFormSubmission(event, serviceId) {
            // Don't interrupt the form submission
            const form = document.getElementById(`service-form-${serviceId}`);
            const submitBtn = document.getElementById(`submit-btn-${serviceId}`);
            
            // Update the button to show loading state
            submitBtn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-black inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Submitting...
            `;
            submitBtn.disabled = true;
            
            // Store the flag that an order was just created
            localStorage.setItem('order_just_created', 'true');
            
            // Continue with the form submission
            return true;
        }
        
        // Check if we need to trigger the order created event when navigating between pages
        document.addEventListener('DOMContentLoaded', function() {
            if (localStorage.getItem('order_just_created') === 'true') {
                // Clear the flag
                localStorage.removeItem('order_just_created');
                
                // Dispatch a custom event that the dashboard will listen for
                document.dispatchEvent(new CustomEvent('orderCreated'));
                
                // Show a toast notification if we're not being redirected to the dashboard with a success message
                if (!window.location.href.includes('/dashboard')) {
                    const notification = document.createElement('div');
                    notification.className = 'fixed top-4 right-4 bg-green-500 text-white p-4 rounded-lg shadow-lg z-50';
                    notification.innerHTML = `
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Order request submitted successfully!</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="absolute top-1 right-1 text-white hover:text-gray-200">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    `;
                    document.body.appendChild(notification);
                    
                    // Remove the notification after 5 seconds
                    setTimeout(() => notification.remove(), 5000);
                }
            }
        });
    </script>
</x-app-layout>
```