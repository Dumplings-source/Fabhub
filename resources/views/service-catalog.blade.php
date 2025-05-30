<x-app-layout>
    <div class="container py-4">
        <!-- Custom CSS to fix input text visibility in service request forms -->
        <style>
            /* Add backdrop filter to modals */
            .modal {
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
            }
            
            .modal-backdrop {
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
            }
            
            /* Fix text color in input fields */
            .modal input[type="text"],
            .modal input[type="email"],
            .modal input[type="number"],
            .modal input[type="date"],
            .modal select,
            .modal textarea {
                color: #212529 !important; /* Dark text color */
                background-color: #fff !important;
                border: 1px solid #ced4da !important;
            }
            
            /* Ensure text is visible in readonly fields */
            .modal input[readonly] {
                color: #212529 !important;
                background-color: #f8f9fa !important;
            }
            
            /* Fix placeholder color */
            .modal ::placeholder {
                color: #6c757d !important;
                opacity: 1 !important;
            }
            
            /* Improve visibility of form labels */
            .modal label,
            .modal .form-check-label {
                color: #212529 !important;
                font-weight: 500 !important;
            }

            /* Style the dropzone container better */
            .dropzone-container {
                background-color: #f8f9fa !important;
                border: 1px dashed #dee2e6 !important;
                color: #212529 !important;
            }
            
            /* Make dropdown text visible */
            .modal select option {
                color: #212529 !important;
                background-color: #fff !important;
            }
            
            /* Ensure radio buttons and checkboxes are visible */
            .modal .form-check-input {
                border-color: #6c757d !important;
            }
            
            /* Fix text in all modal content */
            .modal-content {
                color: #212529 !important;
            }
            
            /* Fix text in file dropzone */
            #dropzone-content-* span,
            .dropzone-container span,
            .dropzone-container .small {
                color: #212529 !important;
            }
            
            /* Fix file preview text */
            #file-preview-* span,
            #file-name-*,
            #file-size-* {
                color: #212529 !important;
            }
            
            /* Fix text in text fields and areas */
            textarea, input, select {
                color: #000 !important;
            }
            
            /* Fix text in modals for woodwork service */
            #orderModal* input::placeholder {
                color: #6c757d !important;
            }
            
            /* Force text visibility everywhere in modals */
            .modal * {
                color: inherit;
            }
            
            /* Specific fixes for Woodwork service form */
            [id^="orderModal"] input[type="text"], 
            [id^="orderModal"] input[type="email"],
            [id^="orderModal"] input[type="number"],
            [id^="orderModal"] input[type="date"],
            [id^="orderModal"] select,
            [id^="orderModal"] textarea,
            [id^="orderModal"] .form-control {
                color: black !important;
                background-color: white !important;
            }
            
            /* Service information section text */
            .modal .col-lg-3.bg-light p,
            .modal .col-lg-3.bg-light span {
                color: #212529 !important;
            }
            
            /* Fix placeholder text in specific inputs */
            #phone-* {
                color: black !important;
            }
            
            /* Force all text inputs to be visible regardless of their state */
            .form-control, .form-select {
                color: black !important;
                background-color: white !important;
            }
            
            /* Fix text in phone field specifically */
            input[id^="phone-"],
            input[placeholder="Enter phone number"] {
                color: black !important;
            }
            
            /* Make price display text clearly visible */
            [id^="price-display-"] {
                color: #000 !important;
                font-weight: bold !important;
                font-size: 16px !important;
            }
            
            /* Price display container */
            .bg-primary.bg-opacity-10 {
                background-color: #f8f9fa !important;
                border: 1px solid #007bff !important;
            }
            
            /* Price label text */
            .bg-primary.bg-opacity-10 h6.text-primary {
                color: #000 !important;
                font-weight: bold !important;
            }
            
            /* Enhance all price related elements */
            .modal span.fw-bold.text-primary,
            .modal h6.fw-bold.text-primary {
                color: #000 !important;
                font-weight: bold !important;
            }
        </style>

        <!-- Service Catalog -->
        <div class="row">
            <div class="col-12">
                <div class="card bg-secondary border-0 shadow position-relative mb-4">
                    <div class="tech-pattern"></div>
                    <div class="card-body p-4 position-relative">
                        <h2 class="text-warning mb-4 section-title">Service Catalog</h2>
                        
                        @if ($services->isEmpty())
                            <div class="text-center py-5 text-light">
                                <i class="bi bi-emoji-frown fs-1 mb-3 d-block"></i>
                                <p class="fs-5">No services available at the moment.</p>
                            </div>
                        @else
                            <div class="row g-4">
                                @foreach ($services as $service)
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card h-100 bg-light shadow service-card" data-service-id="{{ $service->id }}">
                                            <div class="card-body p-4">
                                                <h3 class="card-title h5 text-primary fw-bold mb-3">{{ $service->name }}</h3>
                                                
                                                @if (!$service->availability)
                                                    <div class="mb-3">
                                                        <span class="badge bg-danger px-3 py-2 rounded-pill">Unavailable</span>
                                                    </div>
                                                @else
                                                    <div class="mb-3">
                                                        <span class="badge bg-success px-3 py-2 rounded-pill">Available</span>
                                                    </div>
                                                @endif
                                                
                                                <p class="card-text text-secondary mb-3">{{ $service->description ?? 'No description available' }}</p>
                                                
                                                <div class="mb-4">
                                                    <div class="row g-2 text-secondary small">
                                                        <div class="col-12">
                                                            <div class="d-flex align-items-center">
                                                                <i class="bi bi-currency-dollar me-2 text-primary"></i>
                                                                <span class="fw-medium">Price:</span>
                                                                <span class="ms-1">Starting at ₱{{ number_format($service->price, 2) }}/hour</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="d-flex align-items-center">
                                                                <i class="bi bi-file-earmark me-2 text-primary"></i>
                                                                <span class="fw-medium">File Format:</span>
                                                                <span class="ms-1">{{ $service->file_formats }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="d-flex align-items-center">
                                                                <i class="bi bi-box me-2 text-primary"></i>
                                                                <span class="fw-medium">Materials:</span>
                                                                <span class="ms-1">{{ $service->materials }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="d-flex align-items-center">
                                                                <i class="bi bi-clock me-2 text-primary"></i>
                                                                <span class="fw-medium">Time:</span>
                                                                <span class="ms-1">{{ $service->estimated_time }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
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
                                                
                                                <!-- Button to show order form modal -->
                                                <button 
                                                    type="button"
                                                    class="btn {{ $service->availability ? 'btn-primary' : 'btn-secondary' }} w-100 tech-btn"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#orderModal{{ $service->id }}"
                                                    {{ !$service->availability ? 'disabled' : '' }}
                                                >
                                                    {{ $service->availability ? 'Request Service' : 'Currently Unavailable' }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <!-- Pagination Links -->
                            <div class="mt-4 d-flex justify-content-center">
                                {{ $services->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Form Modals -->
    @foreach ($services as $service)
    <div class="modal fade" id="orderModal{{ $service->id }}" tabindex="-1" aria-labelledby="orderModalLabel{{ $service->id }}" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header bg-primary text-light border-0">
                    <h5 class="modal-title" id="orderModalLabel{{ $service->id }}">
                        <i class="bi bi-tools me-2"></i>Request {{ $service->name }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="row g-0">
                        <!-- Service Information (Left Side) -->
                        <div class="col-lg-3 bg-light p-3 border-end">
                            <div class="d-flex align-items-center mb-2">
                                <div class="rounded-circle bg-primary p-1 me-2 text-light">
                                    <i class="bi bi-info-circle small"></i>
                                </div>
                                <h6 class="fw-bold text-primary mb-0 small">Service Information</h6>
                            </div>
                            
                            <p class="small text-secondary mb-2" style="font-size: 0.8rem;">
                                {{ $service->description ?? 'Our professional technicians will support various materials suitable for prototypes, educational models, or functional parts.' }}
                            </p>
                            
                            <div class="row g-2 mb-0">
                                <div class="col-lg-12 col-sm-4">
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="bi bi-file-earmark me-1 text-primary small"></i>
                                        <span class="fw-bold text-primary small">Files:</span>
                                        <span class="small text-secondary ms-1">{{ $service->file_formats }}</span>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-sm-4">
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="bi bi-clock-history me-1 text-primary small"></i>
                                        <span class="fw-bold text-primary small">Time:</span>
                                        <span class="small text-secondary ms-1">{{ $service->estimated_time }}</span>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-sm-4">
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="bi bi-currency-dollar me-1 text-primary small"></i>
                                        <span class="fw-bold text-primary small">Base:</span>
                                        <span class="small text-secondary ms-1">₱{{ number_format($service->price, 2) }}/hr</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Request Form (Right Side) -->
                        <div class="col-lg-9 p-3">
                            <form id="service-form-{{ $service->id }}" method="POST" action="{{ route('service-catalog.order', $service->id) }}" enctype="multipart/form-data" onsubmit="trackFormSubmission(event, {{ $service->id }})">
                                @csrf
                                <input type="hidden" name="service_id" value="{{ $service->id }}">
                                
                                <div class="row g-2">
                                    <!-- Basic Info -->
                                    <div class="col-md-3">
                                        <div class="mb-2">
                                            <label for="full_name-{{ $service->id }}" class="form-label small fw-bold">
                                                <i class="bi bi-person me-1 text-primary"></i>Name
                                            </label>
                                            <input type="text" name="full_name" id="full_name-{{ $service->id }}" value="{{ Auth::user()->name }}" readonly class="form-control form-control-sm bg-light">
                                        </div>
                                        
                                        <div class="mb-2">
                                            <label for="email-{{ $service->id }}" class="form-label small fw-bold">
                                                <i class="bi bi-envelope me-1 text-primary"></i>Email
                                            </label>
                                            <input type="email" name="email" id="email-{{ $service->id }}" value="{{ Auth::user()->email }}" readonly class="form-control form-control-sm bg-light">
                                        </div>
                                    </div>
                                    
                                    <!-- Contact & Quantity -->
                                    <div class="col-md-3">
                                        <div class="mb-2">
                                            <label for="phone-{{ $service->id }}" class="form-label small fw-bold">
                                                <i class="bi bi-telephone me-1 text-primary"></i>Phone
                                            </label>
                                            <input type="text" name="phone" id="phone-{{ $service->id }}" placeholder="Enter phone number" class="form-control form-control-sm">
                                        </div>
                                        
                                        <div class="mb-2">
                                            <label for="quantity-{{ $service->id }}" class="form-label small fw-bold">
                                                <i class="bi bi-hash me-1 text-primary"></i>Quantity
                                            </label>
                                            <input type="number" name="quantity" id="quantity-{{ $service->id }}" required min="1" value="1" class="form-control form-control-sm" onchange="updatePrice{{ $service->id }}()" oninput="updatePrice{{ $service->id }}()">
                                        </div>
                                    </div>
                                    
                                    <!-- Material & Date -->
                                    <div class="col-md-3">
                                        <div class="mb-2">
                                            <label for="material-{{ $service->id }}" class="form-label small fw-bold">
                                                <i class="bi bi-box me-1 text-primary"></i>Material
                                            </label>
                                            <select name="material" id="material-{{ $service->id }}" required class="form-select form-select-sm" onchange="updatePrice{{ $service->id }}()">
                                                <option value="" disabled selected>Select material</option>
                                                @foreach (explode(',', $service->materials) as $material)
                                                    @php
                                                        $materialPrice = $service->materialPrices->where('material_name', trim($material))->first();
                                                        $price = $materialPrice ? $materialPrice->price : $service->price;
                                                    @endphp
                                                    <option value="{{ trim($material) }}" data-price="{{ $price }}">{{ trim($material) }} - ₱{{ number_format($price, 2) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div class="mb-2">
                                            <label for="preferred_date-{{ $service->id }}" class="form-label small fw-bold">
                                                <i class="bi bi-calendar me-1 text-primary"></i>Date
                                            </label>
                                            <input type="date" name="preferred_date" id="preferred_date-{{ $service->id }}" required min="{{ now()->toDateString() }}" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    
                                    <!-- Time & Type -->
                                    <div class="col-md-3">
                                        <div class="mb-2">
                                            <label for="time_slot-{{ $service->id }}" class="form-label small fw-bold">
                                                <i class="bi bi-clock me-1 text-primary"></i>Time Slot
                                            </label>
                                            <select name="time_slot" id="time_slot-{{ $service->id }}" required class="form-select form-select-sm">
                                                <option value="" disabled selected>Select time</option>
                                                @foreach ($timeSlots as $slot => $available)
                                                    @if ($available)
                                                        <option value="{{ $slot }}">{{ $slot }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <!-- Price Display -->
                                        <div class="mb-2 p-2 bg-primary bg-opacity-10 rounded border border-primary border-opacity-25">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <h6 class="mb-0 fw-bold text-primary small">Total Price:</h6>
                                                <span class="fw-bold text-primary" id="price-display-{{ $service->id }}">₱{{ number_format($service->price, 2) }}</span>
                                            </div>
                                            <!-- Price breakdown -->
                                            <div class="small text-muted" id="price-breakdown-{{ $service->id }}" style="display: none;">
                                                <div class="d-flex justify-content-between">
                                                    <span>Material:</span>
                                                    <span id="material-price-{{ $service->id }}">₱{{ number_format($service->price, 2) }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span>Quantity:</span>
                                                    <span id="quantity-display-{{ $service->id }}">1</span>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span>Request Type:</span>
                                                    <span id="multiplier-display-{{ $service->id }}">Standard (1x)</span>
                                                </div>
                                            </div>
                                                <input type="hidden" name="calculated_price" id="calculated-price-{{ $service->id }}" value="{{ $service->price }}">
                                            <div class="small text-muted mt-1">
                                                <i class="bi bi-info-circle me-1"></i>
                                                Price = Material × Quantity × Request Type
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Request Type -->
                                    <div class="col-12">
                                        <div class="mb-2">
                                            <label class="form-label small fw-bold d-block mb-1">
                                                <i class="bi bi-tag me-1 text-primary"></i>Request Type
                                            </label>
                                            <div class="d-flex gap-2">
                                                <div class="form-check flex-grow-1">
                                                    <input class="form-check-input" type="radio" name="request_type" id="standard-{{ $service->id }}" value="Standard" data-multiplier="1" checked onchange="updatePrice{{ $service->id }}()">
                                                    <label class="form-check-label small" for="standard-{{ $service->id }}">
                                                        Standard (1x)
                                                    </label>
                                                </div>
                                                <div class="form-check flex-grow-1">
                                                    <input class="form-check-input" type="radio" name="request_type" id="rush-{{ $service->id }}" value="Rush" data-multiplier="1.5" onchange="updatePrice{{ $service->id }}()">
                                                    <label class="form-check-label small" for="rush-{{ $service->id }}">
                                                        Rush (+50%)
                                                    </label>
                                                </div>
                                                <div class="form-check flex-grow-1">
                                                    <input class="form-check-input" type="radio" name="request_type" id="custom-{{ $service->id }}" value="Custom" data-multiplier="1.75" onchange="updatePrice{{ $service->id }}()">
                                                    <label class="form-check-label small" for="custom-{{ $service->id }}">
                                                        Custom (+75%)
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Notes & File -->
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <label for="notes-{{ $service->id }}" class="form-label small fw-bold">
                                                <i class="bi bi-pencil me-1 text-primary"></i>Notes (Optional)
                                            </label>
                                            <textarea name="notes" id="notes-{{ $service->id }}" class="form-control form-control-sm" rows="2" placeholder="Add requirements or details"></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <label class="form-label small fw-bold mb-1">
                                                <i class="bi bi-cloud-upload me-1 text-primary"></i>Upload Files
                                            </label>
                                            <div class="dropzone-container border border-dashed rounded p-2 text-center bg-light position-relative" 
                                                 id="dropzone-{{ $service->id }}"
                                                 ondragover="event.preventDefault(); this.classList.add('bg-primary', 'bg-opacity-10');"
                                                 ondragleave="this.classList.remove('bg-primary', 'bg-opacity-10');"
                                                 ondrop="handleFileDrop(event, {{ $service->id }})">
                                                
                                                <input type="file" name="file" id="file-{{ $service->id }}" required class="position-absolute inset-0 w-100 h-100 opacity-0 cursor-pointer" 
                                                       onchange="updateFileName{{ $service->id }}(this)">
                                                
                                                <div class="text-center" id="dropzone-content-{{ $service->id }}">
                                                    <i class="bi bi-cloud-arrow-up text-primary me-1"></i>
                                                    <span class="small">Drag files here or click to browse</span>
                                                </div>
                                                
                                                <div class="d-none align-items-center bg-primary bg-opacity-10 rounded py-1 px-2" id="file-preview-{{ $service->id }}">
                                                    <i class="bi bi-file-earmark me-1 text-primary small"></i>
                                                    <span class="text-truncate small" id="file-name-{{ $service->id }}"></span>
                                                    <span class="small ms-auto me-1" id="file-size-{{ $service->id }}"></span>
                                                    <button type="button" class="btn btn-sm text-danger p-0" onclick="clearFileInput{{ $service->id }}()">
                                                        <i class="bi bi-x-circle small"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="small form-text">Accepted: {{ $service->file_formats }}</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between mt-3">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">
                                        Cancel
                                    </button>
                                    <button type="submit" id="submit-btn-{{ $service->id }}" class="btn btn-sm btn-primary">
                                        Submit Request
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    
    <script>
        // Create updatePrice functions for each service
        @foreach ($services as $service)
        function updatePrice{{ $service->id }}() {
            // Get the base price (material price takes precedence if selected)
            const basePrice = {{ $service->price }};
            
            // Get the quantity
            const quantity = parseInt(document.getElementById('quantity-{{ $service->id }}').value) || 1;
            
            // Get the material price
            const materialSelect = document.getElementById('material-{{ $service->id }}');
            let materialPrice = basePrice; // Default to base price
            let materialName = 'Default';
            if (materialSelect.selectedIndex > 0) {
                materialPrice = parseFloat(materialSelect.options[materialSelect.selectedIndex].getAttribute('data-price')) || basePrice;
                materialName = materialSelect.options[materialSelect.selectedIndex].text.split(' - ')[0];
            }
            
            // Get the request type multiplier
            let multiplier = 1;
            let requestTypeName = 'Standard (1x)';
            const modalElement = document.getElementById('orderModal{{ $service->id }}');
            const checkedRadio = modalElement.querySelector('input[name="request_type"]:checked');
            if (checkedRadio) {
                multiplier = parseFloat(checkedRadio.getAttribute('data-multiplier')) || 1;
                const radioLabel = modalElement.querySelector(`label[for="${checkedRadio.id}"]`);
                if (radioLabel) {
                    requestTypeName = radioLabel.textContent.trim();
                }
            }
            
            // Calculate the total price: (material price per unit) × quantity × request type multiplier
            const totalPrice = materialPrice * quantity * multiplier;
            
            // Update the price display
            const priceDisplay = document.getElementById('price-display-{{ $service->id }}');
            priceDisplay.textContent = '₱' + totalPrice.toFixed(2);
            document.getElementById('calculated-price-{{ $service->id }}').value = totalPrice.toFixed(2);
            
            // Update breakdown displays
            const materialPriceDisplay = document.getElementById('material-price-{{ $service->id }}');
            const quantityDisplay = document.getElementById('quantity-display-{{ $service->id }}');
            const multiplierDisplay = document.getElementById('multiplier-display-{{ $service->id }}');
            const breakdownDiv = document.getElementById('price-breakdown-{{ $service->id }}');
            
            if (materialPriceDisplay) materialPriceDisplay.textContent = '₱' + materialPrice.toFixed(2);
            if (quantityDisplay) quantityDisplay.textContent = quantity;
            if (multiplierDisplay) multiplierDisplay.textContent = requestTypeName;
            
            // Show breakdown if material is selected
            if (breakdownDiv) {
                if (materialSelect.selectedIndex > 0) {
                    breakdownDiv.style.display = 'block';
                } else {
                    breakdownDiv.style.display = 'none';
                }
            }
            
            // Style the price display for visibility
            priceDisplay.style.color = '#000000';
            priceDisplay.style.fontWeight = 'bold';
            priceDisplay.style.fontSize = '16px';
            priceDisplay.style.transition = 'all 0.3s ease';
            
            // Visual feedback based on price
            if (totalPrice === 0 || !materialPrice || materialSelect.selectedIndex === 0) {
                priceDisplay.style.color = '#dc3545';
                priceDisplay.style.backgroundColor = '#f8d7da';
                priceDisplay.style.padding = '4px 8px';
                priceDisplay.style.borderRadius = '4px';
                priceDisplay.style.border = '1px solid #dc3545';
                priceDisplay.textContent = 'Please select material';
                
                // Hide breakdown when no material selected
                if (breakdownDiv) {
                    breakdownDiv.style.display = 'none';
                }
            } else {
                priceDisplay.style.color = '#000000';
                priceDisplay.style.backgroundColor = '#f8f9fa';
                priceDisplay.style.padding = '4px 8px';
                priceDisplay.style.borderRadius = '4px';
                priceDisplay.style.border = '1px solid #007bff';
                
                // Add subtle animation to highlight price change
                priceDisplay.style.transform = 'scale(1.05)';
                setTimeout(() => {
                    priceDisplay.style.transform = 'scale(1)';
                }, 200);
            }
            
            // Show breakdown in console for debugging
            console.log(`Service {{ $service->id }}: Material=₱${materialPrice}, Qty=${quantity}, Multiplier=${multiplier}, Total=₱${totalPrice.toFixed(2)}`);
        }
        
        function updateFileName{{ $service->id }}(input) {
            const fileName = input.files[0]?.name;
            const fileSize = input.files[0]?.size;
            
            if (fileName) {
                document.getElementById('file-name-{{ $service->id }}').textContent = fileName;
                document.getElementById('file-preview-{{ $service->id }}').classList.remove('d-none');
                document.getElementById('file-preview-{{ $service->id }}').classList.add('d-flex');
                document.getElementById('dropzone-content-{{ $service->id }}').classList.add('d-none');
                
                // Display file size
                if (fileSize) {
                    const fileSizeKB = fileSize / 1024;
                    const fileSizeMB = fileSizeKB / 1024;
                    
                    if (fileSizeMB >= 1) {
                        document.getElementById('file-size-{{ $service->id }}').textContent = `${fileSizeMB.toFixed(2)} MB`;
                    } else {
                        document.getElementById('file-size-{{ $service->id }}').textContent = `${fileSizeKB.toFixed(2)} KB`;
                    }
                }
            } else {
                clearFileInput{{ $service->id }}();
            }
        }
        
        function clearFileInput{{ $service->id }}() {
            const fileInput = document.getElementById('file-{{ $service->id }}');
            fileInput.value = '';
            document.getElementById('file-name-{{ $service->id }}').textContent = '';
            document.getElementById('file-size-{{ $service->id }}').textContent = '';
            document.getElementById('file-preview-{{ $service->id }}').classList.add('d-none');
            document.getElementById('file-preview-{{ $service->id }}').classList.remove('d-flex');
            document.getElementById('dropzone-content-{{ $service->id }}').classList.remove('d-none');
        }
        @endforeach
        
        // Global helper functions
        function handleFileDrop(event, serviceId) {
            event.preventDefault();
            event.stopPropagation();
            
            const dropzone = document.getElementById(`dropzone-${serviceId}`);
            dropzone.classList.remove('bg-primary', 'bg-opacity-10');
            
            const fileInput = document.getElementById(`file-${serviceId}`);
            const dt = event.dataTransfer;
            
            if (dt.files.length) {
                fileInput.files = dt.files;
                // Call the appropriate updateFileName function
                window[`updateFileName${serviceId}`](fileInput);
            }
        }
        
        function trackFormSubmission(event, serviceId) {
            // Don't interrupt the form submission
            const form = document.getElementById(`service-form-${serviceId}`);
            const submitBtn = document.getElementById(`submit-btn-${serviceId}`);
            
            // Update the button to show loading state
            submitBtn.innerHTML = `
                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                Processing...
            `;
            submitBtn.disabled = true;
            
            // Store the flag that an order was just created
            localStorage.setItem('order_just_created', 'true');
            
            // Continue with the form submission
            return true;
        }
        
        // Real-time service availability updates
        try {
            if (window.Echo) {
                window.Echo.channel('services')
                    .listen('.service.availability.updated', (event) => {
                        console.log('Service availability updated:', event);
                        updateServiceAvailability(event.service);
                        showServiceUpdateNotification(event.message);
                    });
            } else {
                console.warn('Echo not available - real-time updates disabled');
            }
        } catch (error) {
            console.error('Error setting up real-time service updates:', error);
        }

        function updateServiceAvailability(service) {
            // Find the service card
            const serviceCard = document.querySelector(`[data-service-id="${service.id}"]`);
            if (!serviceCard) {
                // If card doesn't exist, reload the page to show updated content
                console.log('Service card not found, reloading page for updates');
                setTimeout(() => window.location.reload(), 1000);
                return;
            }

            // Update the availability badge
            const badge = serviceCard.querySelector('.badge');
            if (badge) {
                badge.className = service.availability 
                    ? 'badge bg-success px-3 py-2 rounded-pill' 
                    : 'badge bg-danger px-3 py-2 rounded-pill';
                badge.textContent = service.availability ? 'Available' : 'Unavailable';
            }

            // Update the request button
            const requestButton = serviceCard.querySelector('.tech-btn');
            if (requestButton) {
                requestButton.className = service.availability 
                    ? 'btn btn-primary w-100 tech-btn' 
                    : 'btn btn-secondary w-100 tech-btn';
                requestButton.textContent = service.availability 
                    ? 'Request Service' 
                    : 'Currently Unavailable';
                requestButton.disabled = !service.availability;
                
                // Update modal target
                if (service.availability) {
                    requestButton.setAttribute('data-bs-toggle', 'modal');
                    requestButton.setAttribute('data-bs-target', `#orderModal${service.id}`);
                } else {
                    requestButton.removeAttribute('data-bs-toggle');
                    requestButton.removeAttribute('data-bs-target');
                }
            }

            // Add visual feedback
            serviceCard.style.transition = 'all 0.3s ease';
            serviceCard.style.transform = 'scale(1.02)';
            setTimeout(() => {
                serviceCard.style.transform = 'scale(1)';
            }, 300);
        }

        function showServiceUpdateNotification(message) {
            // Create toast notification
            const toastContainer = document.createElement('div');
            toastContainer.className = 'position-fixed top-0 end-0 p-3';
            toastContainer.style.zIndex = '1055';
            
            toastContainer.innerHTML = `
                <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header bg-info text-white">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong class="me-auto">Service Update</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                                </div>
                                <div class="toast-body">
                        ${message}
                            </div>
                        </div>
                    `;
                    
            document.body.appendChild(toastContainer);
                    
            // Auto remove after 5 seconds
                    setTimeout(() => {
                if (toastContainer.parentElement) {
                    toastContainer.remove();
                        }
                    }, 5000);
                }

        // Initialize all modals and event handlers
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize price calculation for each service when modals are opened
            @foreach ($services as $service)
            const modal{{ $service->id }} = document.getElementById('orderModal{{ $service->id }}');
            if (modal{{ $service->id }}) {
                modal{{ $service->id }}.addEventListener('shown.bs.modal', function() {
                    // Initialize price calculation
                    updatePrice{{ $service->id }}();
                    
                    // Set up event listeners for all price-affecting inputs
                    const quantityInput = document.getElementById('quantity-{{ $service->id }}');
                    const materialSelect = document.getElementById('material-{{ $service->id }}');
                    const requestTypeRadios = document.querySelectorAll('#orderModal{{ $service->id }} input[name="request_type"]');
                    
                    // Quantity input event
                    if (quantityInput) {
                        quantityInput.addEventListener('input', function() {
                            updatePrice{{ $service->id }}();
                        });
                        quantityInput.addEventListener('change', function() {
                            updatePrice{{ $service->id }}();
                        });
                    }
                    
                    // Material select event
                    if (materialSelect) {
                        materialSelect.addEventListener('change', function() {
                            updatePrice{{ $service->id }}();
                        });
                    }
                    
                    // Request type radio events (already have onchange in HTML)
                    requestTypeRadios.forEach(radio => {
                        radio.addEventListener('change', function() {
                            updatePrice{{ $service->id }}();
                        });
                    });
                });
            }
    @endforeach
    
            // Fix all modals when they are shown
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                modal.addEventListener('shown.bs.modal', function() {
                    // Get the service ID from the modal ID
                    const serviceId = modal.id.replace('orderModal', '');

                    // Fix input colors and ensure text is visible
                    const inputs = modal.querySelectorAll('input, select, textarea');
                    inputs.forEach(input => {
                        input.style.color = '#212529';
                        input.style.backgroundColor = '#ffffff';
                    });
                    
                    // Make sure price is calculated on modal open
                    if (window[`updatePrice${serviceId}`]) {
                        window[`updatePrice${serviceId}`]();
                    }
                        });
                    });
            
            // Track form submissions for analytics
            window.trackFormSubmission = function(event, serviceId) {
                console.log(`Form for service ${serviceId} submitted`);
                document.getElementById(`submit-btn-${serviceId}`).disabled = true;
                document.getElementById(`submit-btn-${serviceId}`).innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Submitting...';
            };

            // Check if we need to trigger the order created event when navigating between pages
            if (localStorage.getItem('order_just_created') === 'true') {
                // Clear the flag
                localStorage.removeItem('order_just_created');
                
                // Dispatch a custom event that the dashboard will listen for
                document.dispatchEvent(new CustomEvent('orderCreated'));
                
                // Show a toast notification if we're not being redirected to the dashboard with a success message
                if (!window.location.href.includes('/dashboard')) {
                    const toastHTML = `
                        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050">
                            <div class="toast show bg-success text-white" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="toast-header bg-success text-white">
                                    <i class="bi bi-check-circle-fill me-2"></i>
                                    <strong class="me-auto">Success</strong>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                                <div class="toast-body">
                                    Order request submitted successfully!
                                </div>
                            </div>
                        </div>
                    `;
                    
                    document.body.insertAdjacentHTML('beforeend', toastHTML);
                    
                    // Remove the toast after 5 seconds
                    setTimeout(() => {
                        const toast = document.querySelector('.toast');
                        if (toast) {
                            toast.remove();
                        }
                    }, 5000);
                }
            }
        });
    </script>
</x-app-layout>
