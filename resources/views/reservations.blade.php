<x-app-layout>
    <!-- Import Tailwind directly -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        /* CTU FABLAB Font Styling - Matching Dashboard */
        body {
            font-family: 'Inter', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', sans-serif !important;
        }
        
        .font-sans {
            font-family: 'Inter', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', sans-serif !important;
        }
        
        /* Enhanced Dashboard Styling with CTU FABLAB Typography */
        :root {
            --primary-blue: #1e3a8a;
            --secondary-blue: #3b82f6;
            --accent-yellow: #fbbf24;
            --success-green: #10b981;
            --warning-orange: #f59e0b;
            --danger-red: #ef4444;
            --light-bg: #f8fafc;
            --card-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            --card-shadow-hover: 0 20px 40px rgba(0, 0, 0, 0.15);
            --gradient-primary: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            --gradient-secondary: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            --gradient-warning: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
            --gradient-success: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        }

        /* Enhanced Card Styling */
        .enhanced-card {
            background: white;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .enhanced-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .enhanced-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--card-shadow-hover);
        }

        .enhanced-card:hover::before {
            opacity: 1;
        }

        /* Enhanced Buttons */
        .btn-enhanced {
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            position: relative;
            overflow: hidden;
        }

        .btn-enhanced::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-enhanced:hover::before {
            left: 100%;
        }

        .btn-enhanced:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .btn-primary-enhanced {
            background: var(--gradient-primary);
            color: white;
        }

        .btn-warning-enhanced {
            background: var(--gradient-warning);
            color: #1f2937;
        }

        .btn-success-enhanced {
            background: var(--gradient-success);
            color: white;
        }

        /* Enhanced Section Headers */
        .section-header {
            background: var(--gradient-primary);
            color: white;
            padding: 1.5rem;
            border-radius: 16px 16px 0 0;
            position: relative;
            overflow: hidden;
        }

        .section-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.5), transparent);
        }

        /* Form Styling */
        .form-control {
            border-radius: 8px;
            border: 2px solid #e5e7eb;
            padding: 0.75rem;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
            outline: none;
        }

        .form-select {
            border-radius: 8px;
            border: 2px solid #e5e7eb;
            padding: 0.75rem;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-select:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
            outline: none;
        }

        /* Table Styling */
        .table-enhanced {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .table-enhanced thead th {
            background: var(--gradient-primary);
            color: white;
            font-weight: 600;
            padding: 1rem;
            border: none;
        }

        .table-enhanced tbody tr {
            transition: all 0.3s ease;
        }

        .table-enhanced tbody tr:hover {
            background-color: rgba(30, 58, 138, 0.05);
        }

        .table-enhanced tbody td {
            padding: 1rem;
            vertical-align: middle;
        }

        /* Status Badges */
        .badge-enhanced {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .badge-pending {
            background: var(--gradient-warning);
            color: #1f2937;
        }

        .badge-confirmed {
            background: var(--gradient-success);
            color: white;
        }

        .badge-cancelled {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        /* Navigation Breadcrumb */
        .breadcrumb-nav {
            background: rgba(30, 58, 138, 0.05);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 2rem;
        }

        /* Loading Animation */
        .loading-shimmer {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        /* Toast Notifications */
        .toast-container {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 9999;
        }

        /* Loading spinner animation */
        .spin {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Service loading indicator */
        .service-loading {
            color: var(--primary-blue);
            font-size: 0.875rem;
        }

        /* Highlight animation for new/updated reservations */
        .reservation-highlight {
            animation: highlightFade 3s ease-in-out;
            background-color: rgba(16, 185, 129, 0.1) !important;
        }

        @keyframes highlightFade {
            0% { 
                background-color: rgba(16, 185, 129, 0.3);
                box-shadow: 0 0 10px rgba(16, 185, 129, 0.5);
            }
            100% { 
                background-color: rgba(16, 185, 129, 0.1);
                box-shadow: none;
            }
        }

        /* Status update notification */
        .status-update-glow {
            animation: statusGlow 2s ease-in-out;
        }

        @keyframes statusGlow {
            0%, 100% { box-shadow: none; }
            50% { box-shadow: 0 0 15px rgba(59, 130, 246, 0.4); }
        }
    </style>
    
    <div class="container py-4 font-sans">
        <!-- Breadcrumb Navigation -->
        <div class="breadcrumb-nav">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}" class="text-decoration-none" style="color: var(--primary-blue);">
                            <i class="bi bi-house-door me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Reservations</li>
                </ol>
            </nav>
        </div>

        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="enhanced-card">
                    <div class="section-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="mb-0 fs-3 font-sans" style="font-weight: 700; letter-spacing: 0.5px;">
                                    <i class="bi bi-calendar-check me-3"></i>Reservations
                                </h2>
                                <p class="mb-0 mt-2 opacity-75">Schedule your fabrication lab sessions</p>
                            </div>
                            <div class="text-end">
                                <small class="opacity-75">Welcome, {{ Auth::user()->name }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Make Reservation Form -->
            <div class="col-lg-6">
                <div class="enhanced-card h-100">
                    <div class="section-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 font-sans" style="font-weight: 600; color: white;">
                                <i class="bi bi-calendar-plus me-2"></i>Make a New Reservation
                            </h5>
                            <button class="btn btn-sm btn-enhanced btn-warning-enhanced" onclick="refreshServices()" title="Refresh Services">
                                <i class="bi bi-arrow-clockwise me-1"></i>Refresh Services
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <form id="reservationForm">
                            @csrf
                            <div class="mb-3">
                                <label for="service_id" class="form-label fw-semibold text-primary">
                                    <i class="bi bi-gear me-1"></i>Service <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" id="service_id" name="service_id" required>
                                    <option value="">Select a service...</option>
                                    <!-- Services will be loaded via JavaScript -->
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="reservation_date" class="form-label fw-semibold text-primary">
                                        <i class="bi bi-calendar me-1"></i>Preferred Date <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" class="form-control" id="reservation_date" name="reservation_date" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="time_slot" class="form-label fw-semibold text-primary">
                                        <i class="bi bi-clock me-1"></i>Time Slot <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select" id="time_slot" name="time_slot" required>
                                        <option value="">Select a time slot...</option>
                                        <!-- Time slots will be loaded based on service selection -->
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="contact_info" class="form-label fw-semibold text-primary">
                                    <i class="bi bi-telephone me-1"></i>Contact Information <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="contact_info" name="contact_info" 
                                    placeholder="Phone number or email" required>
                            </div>

                            <div class="mb-4">
                                <label for="notes" class="form-label fw-semibold text-primary">
                                    <i class="bi bi-chat-text me-1"></i>Notes <span class="text-muted">(Optional)</span>
                                </label>
                                <textarea class="form-control" id="notes" name="notes" rows="3" 
                                    placeholder="Any special requirements or additional information..."></textarea>
                            </div>

                            <div class="d-grid">
                                <button type="button" class="btn btn-enhanced btn-primary-enhanced" onclick="submitReservation()">
                                    <i class="bi bi-calendar-check me-2"></i>Submit Reservation
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Quick Info & Guidelines -->
            <div class="col-lg-6">
                <div class="enhanced-card h-100">
                    <div class="section-header">
                        <h5 class="mb-0 font-sans" style="font-weight: 600;">
                            <i class="bi bi-info-circle me-2"></i>Reservation Guidelines
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <h6 class="fw-semibold text-primary mb-2">
                                <i class="bi bi-clock-history me-1"></i>Operating Hours
                            </h6>
                            <p class="mb-0 text-muted">Monday - Friday: 8:00 AM - 5:00 PM</p>
                            <p class="mb-0 text-muted">Saturday: 8:00 AM - 12:00 PM</p>
                            <p class="mb-3 text-muted">Sunday: Closed</p>
                        </div>

                        <div class="mb-4">
                            <h6 class="fw-semibold text-primary mb-2">
                                <i class="bi bi-exclamation-triangle me-1"></i>Important Notes
                            </h6>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="bi bi-check-circle text-success me-2"></i>
                                    <span class="text-primary">Reservations must be made at least 24 hours in advance</span>
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check-circle text-success me-2"></i>
                                    <span class="text-primary">Maximum session duration: 4 hours</span>
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check-circle text-success me-2"></i>
                                    <span class="text-primary">Please arrive 10 minutes before your session</span>
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check-circle text-success me-2"></i>
                                    <span class="text-primary">Bring your own materials or purchase on-site</span>
                                </li>
                            </ul>
                        </div>

                        <div class="alert alert-info border-0" style="background: rgba(59, 130, 246, 0.1);">
                            <i class="bi bi-lightbulb me-2 text-primary"></i>
                            <strong class="text-primary">Tip:</strong> <span class="text-primary">For large projects, consider booking multiple consecutive time slots.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- My Reservations Section -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="enhanced-card">
                    <div class="section-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 font-sans" style="font-weight: 600;">
                            <i class="bi bi-calendar-event me-2"></i>My Reservations
                        </h5>
                        <button class="btn btn-sm btn-enhanced btn-warning-enhanced" onclick="refreshReservations()">
                            <i class="bi bi-arrow-clockwise me-1"></i>Refresh
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <!-- Loading State -->
                        <div id="reservationsLoading" class="text-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-3 mb-0 text-primary">Loading your reservations...</p>
                        </div>

                        <!-- Reservations Table -->
                        <div id="reservationsContent" class="d-none">
                            <div class="table-responsive">
                                <table class="table table-enhanced mb-0">
                                    <thead>
                                        <tr>
                                            <th>Reservation ID</th>
                                            <th>Service</th>
                                            <th>Date & Time</th>
                                            <th>Contact</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="reservationsTableBody">
                                        <!-- Reservations will be loaded here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- No Reservations State -->
                        <div id="noReservationsMessage" class="text-center py-5 d-none">
                            <i class="bi bi-calendar-x text-primary" style="font-size: 4rem;"></i>
                            <h5 class="mt-3 text-primary">No Reservations Found</h5>
                            <p class="text-primary mb-3">You haven't made any reservations yet.</p>
                            <button class="btn btn-enhanced btn-primary-enhanced" onclick="document.getElementById('service_id').focus()">
                                <i class="bi bi-calendar-plus me-1"></i>Make Your First Reservation
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container"></div>

    <!-- JavaScript -->
    <script>
        // Global variable to track previous reservations for change detection
        let previousReservations = [];

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize the page
            loadServices();
            setMinDate();
            loadMyReservations();

            // Handle service selection change
            document.getElementById('service_id').addEventListener('change', function() {
                const serviceId = this.value;
                const date = document.getElementById('reservation_date').value;
                if (serviceId && date) {
                    loadTimeSlots(serviceId, date);
                } else {
                    const timeSlotSelect = document.getElementById('time_slot');
                    timeSlotSelect.innerHTML = '<option value="">Select a time slot...</option>';
                }
            });

            // Handle date change
            document.getElementById('reservation_date').addEventListener('change', function() {
                const serviceId = document.getElementById('service_id').value;
                const date = this.value;
                if (serviceId && date) {
                    loadTimeSlots(serviceId, date);
                }
            });

            // Add refresh services function to window for external access
            window.refreshServices = function() {
                console.log('Refreshing services...');
                loadServices();
            };

            // Listen for service updates (if broadcast events are implemented)
            if (typeof window.Echo !== 'undefined') {
                window.Echo.channel('services')
                    .listen('ServiceUpdated', (e) => {
                        console.log('Service updated, refreshing list...');
                        loadServices();
                    });
            }

            // Auto-refresh services every 5 minutes to keep in sync
            setInterval(function() {
                console.log('Auto-refreshing services...');
                loadServices();
            }, 5 * 60 * 1000); // 5 minutes

            // Auto-refresh reservations every 30 seconds to check for status updates
            setInterval(function() {
                console.log('Auto-refreshing reservations...');
                loadMyReservations(true); // Silent refresh for auto-updates
            }, 30 * 1000); // 30 seconds

            // Listen for reservation status updates (if broadcast events are implemented)
            if (typeof window.Echo !== 'undefined') {
                window.Echo.channel('reservations')
                    .listen('ReservationStatusUpdated', (e) => {
                        console.log('Reservation status updated, refreshing list...', e);
                        loadMyReservations();
                        
                        // Show notification if it's for current user
                        if (e.reservation && e.reservation.user_id === {{ Auth::id() }}) {
                            showSuccessToast(`Your reservation #${e.reservation.id} status has been updated to: ${e.reservation.status}`);
                        }
                    });

                // Listen for user-specific reservation updates
                window.Echo.private('user.{{ Auth::id() }}')
                    .listen('ReservationUpdated', (e) => {
                        console.log('Personal reservation updated:', e);
                        loadMyReservations();
                        showSuccessToast(`Your reservation #${e.reservation.id} has been ${e.reservation.status}`);
                    });
            }

            // Add global refresh function for external access
            window.refreshReservations = function() {
                console.log('Manually refreshing reservations...');
                loadMyReservations(false); // Show loading indicators for manual refresh
            };
        });

        function loadServices() {
            const serviceSelect = document.getElementById('service_id');
            const refreshButton = document.querySelector('button[onclick="refreshServices()"]');
            
            // Show loading state
            serviceSelect.innerHTML = '<option value="">🔄 Loading services...</option>';
            serviceSelect.disabled = true;
            
            // Animate refresh button if it exists
            if (refreshButton) {
                const icon = refreshButton.querySelector('i.bi-arrow-clockwise');
                if (icon) {
                    icon.classList.add('spin');
                }
                refreshButton.disabled = true;
            }
            
            fetch('/api/services', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                credentials: 'same-origin'
            })
                .then(response => {
                    console.log('Services API response status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(services => {
                    console.log('Services loaded:', services);
                    serviceSelect.innerHTML = '<option value="">Select a service...</option>';
                    
                    if (services && services.length > 0) {
                        services.forEach(service => {
                            const option = document.createElement('option');
                            option.value = service.id;
                            
                            // Create service text with rate
                            let serviceText = service.name;
                            if (service.rate) {
                                serviceText += ` - ₱${service.rate}/hour`;
                            }
                            
                            // Add availability indicator if service is not available
                            if (service.availability === false) {
                                serviceText += ' (Currently Unavailable)';
                                option.style.color = '#6b7280'; // Gray color for unavailable
                                option.style.fontStyle = 'italic';
                            }
                            
                            option.textContent = serviceText;
                            serviceSelect.appendChild(option);
                        });
                        
                        // Show success message if services were loaded
                        console.log(`✅ Successfully loaded ${services.length} services`);
                        
                        // Show brief success indicator
                        serviceSelect.style.borderColor = 'var(--success-green)';
                        setTimeout(() => {
                            serviceSelect.style.borderColor = '';
                        }, 2000);
                    } else {
                        serviceSelect.innerHTML = '<option value="">No services available</option>';
                        showErrorToast('No services are currently available for reservation.');
                    }
                    
                    serviceSelect.disabled = false;
                })
                .catch(error => {
                    console.error('❌ Error loading services:', error);
                    
                    // Fallback to hardcoded services if API fails
                    console.log('Loading fallback services...');
                    serviceSelect.innerHTML = `
                        <option value="">Select a service...</option>
                        <option value="1">3D Printing - ₱150/hour</option>
                        <option value="2">Woodwork - ₱250/hour</option>
                        <option value="3">Laser Cutting - ₱200/hour</option>
                        <option value="4">Embroidery - ₱180/hour</option>
                        <option value="5">Tarpulin - ₱15/hour</option>
                    `;
                    
                    serviceSelect.disabled = false;
                    serviceSelect.style.borderColor = 'var(--warning-orange)';
                    
                    // Show warning message about fallback
                    showErrorToast('Unable to load services from server. Using cached services. Please refresh the page if you expect to see new services.');
                })
                .finally(() => {
                    // Stop spinning animation and re-enable refresh button
                    if (refreshButton) {
                        const icon = refreshButton.querySelector('i.bi-arrow-clockwise');
                        if (icon) {
                            icon.classList.remove('spin');
                        }
                        refreshButton.disabled = false;
                    }
                });
        }

        function setMinDate() {
            const today = new Date();
            const tomorrow = new Date(today);
            tomorrow.setDate(tomorrow.getDate() + 1);
            const dateString = tomorrow.toISOString().split('T')[0];
            document.getElementById('reservation_date').min = dateString;
        }

        function loadTimeSlots(serviceId, date) {
            const timeSlotSelect = document.getElementById('time_slot');
            timeSlotSelect.innerHTML = '<option value="">Loading time slots...</option>';
            timeSlotSelect.disabled = true;
            
            fetch(`/reservations/time-slots?service_id=${serviceId}&date=${date}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                credentials: 'same-origin'
            })
                .then(response => {
                    console.log('Time slots API response status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Time slots loaded:', data);
                    timeSlotSelect.innerHTML = '<option value="">Select a time slot...</option>';
                    
                    if (data.time_slots && data.time_slots.length > 0) {
                        data.time_slots.forEach(slot => {
                            const option = document.createElement('option');
                            option.value = slot.name;
                            option.textContent = slot.name;
                            timeSlotSelect.appendChild(option);
                        });
                        console.log(`Successfully loaded ${data.time_slots.length} time slots`);
                    } else {
                        // Fallback time slots
                        console.log('No time slots from API, using fallback...');
                        const fallbackSlots = [
                            '08:00 AM - 10:00 AM',
                            '10:00 AM - 12:00 PM',
                            '01:00 PM - 03:00 PM',
                            '03:00 PM - 05:00 PM'
                        ];
                        fallbackSlots.forEach(slot => {
                            const option = document.createElement('option');
                            option.value = slot;
                            option.textContent = slot;
                            timeSlotSelect.appendChild(option);
                        });
                        
                        showErrorToast('Using default time slots. Custom time slots for this service may not be available.');
                    }
                    
                    timeSlotSelect.disabled = false;
                })
                .catch(error => {
                    console.error('Error loading time slots:', error);
                    
                    // Fallback time slots
                    console.log('Error occurred, loading fallback time slots...');
                    timeSlotSelect.innerHTML = `
                        <option value="">Select a time slot...</option>
                        <option value="08:00 AM - 10:00 AM">08:00 AM - 10:00 AM</option>
                        <option value="10:00 AM - 12:00 PM">10:00 AM - 12:00 PM</option>
                        <option value="01:00 PM - 03:00 PM">01:00 PM - 03:00 PM</option>
                        <option value="03:00 PM - 05:00 PM">03:00 PM - 05:00 PM</option>
                    `;
                    
                    timeSlotSelect.disabled = false;
                    
                    showErrorToast('Unable to load custom time slots. Using default time slots.');
                });
        }

        function submitReservation() {
            const form = document.getElementById('reservationForm');
            
            // Validate required fields
            const serviceId = document.getElementById('service_id').value;
            const reservationDate = document.getElementById('reservation_date').value;
            const timeSlot = document.getElementById('time_slot').value;
            const contactInfo = document.getElementById('contact_info').value;
            
            if (!serviceId) {
                showErrorToast('Please select a service.');
                document.getElementById('service_id').focus();
                return;
            }
            
            if (!reservationDate) {
                showErrorToast('Please select a reservation date.');
                document.getElementById('reservation_date').focus();
                return;
            }
            
            if (!timeSlot) {
                showErrorToast('Please select a time slot.');
                document.getElementById('time_slot').focus();
                return;
            }
            
            if (!contactInfo.trim()) {
                showErrorToast('Please provide your contact information.');
                document.getElementById('contact_info').focus();
                return;
            }
            
            // Disable form during submission
            const submitButton = form.querySelector('button[onclick="submitReservation()"]');
            const originalText = submitButton.innerHTML;
            submitButton.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Submitting...';
            submitButton.disabled = true;
            
            const formData = new FormData(form);
            
            // Convert FormData to JSON
            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });
            
            // Add CSRF token
            data._token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            fetch('/reservations', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': data._token
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(result => {
                if (result.message) {
                    // Success
                    showSuccessToast(result.message);
                    form.reset();
                    setMinDate(); // Reset the min date
                    loadMyReservations(); // Refresh the reservations list
                    
                    // Reset time slot dropdown
                    document.getElementById('time_slot').innerHTML = '<option value="">Select a time slot...</option>';
                } else if (result.error) {
                    showErrorToast(result.error);
                } else {
                    showErrorToast('Unexpected response from server.');
                }
            })
            .catch(error => {
                console.error('Error submitting reservation:', error);
                showErrorToast('Failed to submit reservation. Please try again.');
            })
            .finally(() => {
                // Re-enable form
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
            });
        }

        function loadMyReservations(silent = false) {
            // Only show loading state if it's not a silent refresh
            if (!silent) {
                document.getElementById('reservationsLoading').classList.remove('d-none');
                document.getElementById('reservationsContent').classList.add('d-none');
                document.getElementById('noReservationsMessage').classList.add('d-none');
            }
            
            fetch('/reservations', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                credentials: 'same-origin'
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('reservationsLoading').classList.add('d-none');
                    
                    if (data.reservations && data.reservations.length > 0) {
                        displayReservations(data.reservations);
                        
                        // Log successful update for debugging
                        console.log(`✅ Successfully loaded ${data.reservations.length} reservations`);
                        
                        // Show subtle notification for manual refresh
                        if (!silent) {
                            console.log('Reservations refreshed manually');
                        }
                    } else {
                        document.getElementById('noReservationsMessage').classList.remove('d-none');
                        console.log('No reservations found for user');
                    }
                })
                .catch(error => {
                    console.error('❌ Error loading reservations:', error);
                    document.getElementById('reservationsLoading').classList.add('d-none');
                    document.getElementById('noReservationsMessage').classList.remove('d-none');
                    
                    // Only show error toast for manual refresh, not auto-refresh
                    if (!silent) {
                        showErrorToast('Failed to load reservations. Please try again.');
                    }
                });
        }

        function displayReservations(reservations) {
            const tbody = document.getElementById('reservationsTableBody');
            tbody.innerHTML = '';
            
            // Track which reservations are new or updated
            const newOrUpdated = [];
            
            reservations.forEach(reservation => {
                const statusClass = getStatusClass(reservation.status);
                const canCancel = reservation.status === 'pending';
                
                // Check if this is a new reservation or status changed
                const previousReservation = previousReservations.find(prev => prev.id === reservation.id);
                const isNew = !previousReservation;
                const isUpdated = previousReservation && previousReservation.status !== reservation.status;
                
                if (isNew || isUpdated) {
                    newOrUpdated.push(reservation.id);
                }
                
                const row = document.createElement('tr');
                row.setAttribute('data-reservation-id', reservation.id);
                
                // Add highlight class for new or updated reservations
                if (isNew || isUpdated) {
                    row.classList.add('reservation-highlight');
                }
                
                row.innerHTML = `
                    <td class="fw-semibold">#${reservation.id}</td>
                    <td>${reservation.service ? reservation.service.name : 'N/A'}</td>
                    <td>
                        <div class="fw-semibold">${formatDate(reservation.reservation_date)}</div>
                        <small class="text-muted">${reservation.time_slot || 'N/A'}</small>
                    </td>
                    <td>${reservation.contact_info || 'N/A'}</td>
                    <td><span class="badge badge-enhanced ${statusClass} ${isUpdated ? 'status-update-glow' : ''}">${reservation.status.charAt(0).toUpperCase() + reservation.status.slice(1)}</span></td>
                    <td>
                        <div class="d-flex gap-2">
                            ${canCancel ? `<button class="btn btn-sm btn-outline-danger" onclick="cancelReservation(${reservation.id})">
                                <i class="bi bi-x-circle me-1"></i>Cancel
                            </button>` : ''}
                            ${reservation.notes ? `<button class="btn btn-sm btn-outline-info" onclick="showReservationNotes('${escapeHtml(reservation.notes)}')">
                                <i class="bi bi-chat-text me-1"></i>Notes
                            </button>` : ''}
                        </div>
                    </td>
                `;
                
                tbody.appendChild(row);
            });
            
            // Update previous reservations for next comparison
            previousReservations = [...reservations];
            
            // Log new or updated reservations
            if (newOrUpdated.length > 0) {
                console.log(`🔄 Detected ${newOrUpdated.length} new/updated reservations:`, newOrUpdated);
            }
            
            document.getElementById('reservationsContent').classList.remove('d-none');
        }

        function getStatusClass(status) {
            switch(status) {
                case 'pending': return 'badge-pending';
                case 'confirmed': return 'badge-confirmed';
                case 'cancelled': return 'badge-cancelled';
                default: return 'bg-secondary';
            }
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'short', 
                day: 'numeric' 
            });
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function cancelReservation(id) {
            if (confirm('Are you sure you want to cancel this reservation?')) {
                fetch(`/reservations/${id}/cancel`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(result => {
                    if (result.message) {
                        showSuccessToast(result.message);
                        loadMyReservations(); // Reload the reservations
                    } else if (result.error) {
                        showErrorToast(result.error);
                    }
                })
                .catch(error => {
                    console.error('Error canceling reservation:', error);
                    showErrorToast('Failed to cancel reservation. Please try again.');
                });
            }
        }

        function showReservationNotes(notes) {
            alert('Reservation Notes:\n\n' + notes);
        }

        function showSuccessToast(message) {
            const toast = document.createElement('div');
            toast.className = 'alert alert-success alert-dismissible fade show';
            toast.style.cssText = 'position: fixed; top: 1rem; right: 1rem; z-index: 9999; min-width: 300px;';
            toast.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle me-2"></i>
                    <span>${message}</span>
                    <button type="button" class="btn-close ms-auto" onclick="this.closest('.alert').remove()"></button>
                </div>
            `;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 5000);
        }

        function showErrorToast(message) {
            const toast = document.createElement('div');
            toast.className = 'alert alert-danger alert-dismissible fade show';
            toast.style.cssText = 'position: fixed; top: 1rem; right: 1rem; z-index: 9999; min-width: 300px;';
            toast.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    <span>${message}</span>
                    <button type="button" class="btn-close ms-auto" onclick="this.closest('.alert').remove()"></button>
                </div>
            `;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 5000);
        }
    </script>
</x-app-layout> 