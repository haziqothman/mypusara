@extends('layouts.navigation')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        {{-- Booking Update Form --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg overflow-hidden">
                {{-- Form Header with Gradient --}}
                <div class="card-header bg-gradient-primary py-4">
                    <div class="text-center text-white">
                        <h1 class="h3 mb-1 fw-light">Kemaskini Tempahan</h1>
                        <p class="mb-0 opacity-75">Sila kemaskini butiran tempahan anda</p>
                    </div>
                </div>

                {{-- Form Body --}}
                <div class="card-body p-5">
                    <form method="POST" action="{{ route('customer.update.booking', $booking->id) }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        {{-- Form Sections --}}
                        <div class="row g-4">
                            {{-- Customer Information --}}
                            <div class="col-md-6">
                                <div class="bg-light p-4 rounded-3 h-100">
                                    <h5 class="mb-4 text-primary">
                                        <i class="fas fa-user-circle me-2"></i> Maklumat Waris
                                    </h5>
                                    
                                    <div class="mb-3">
                                        <label for="customerName" class="form-label">Nama Penuh</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="fas fa-user"></i></span>
                                            <input type="text" id="customerName" name="customerName" 
                                                   value="{{ old('customerName', $booking->customerName) }}" 
                                                   class="form-control bg-light" placeholder="Ahmad bin Ali" readonly>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="no_mykad" class="form-label">No. MyKad</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="fas fa-id-card"></i></span>
                                            <input type="text" id="no_mykad" name="no_mykad" 
                                                   value="{{ old('no_mykad', $booking->no_mykad) }}" 
                                                   class="form-control bg-light" placeholder="901025145679" readonly>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="customerEmail" class="form-label">Emel</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="fas fa-envelope"></i></span>
                                            <input type="email" id="customerEmail" name="customerEmail" 
                                                   value="{{ old('customerEmail', $booking->customerEmail) }}" 
                                                   class="form-control bg-light" placeholder="example@gmail.com" readonly>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="contactNumber" class="form-label">No. Telefon</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="fas fa-phone"></i></span>
                                            <input type="tel" id="contactNumber" name="contactNumber" 
                                                   value="{{ old('contactNumber', $booking->contactNumber) }}" 
                                                   class="form-control" placeholder="0123456789" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="waris_address" class="form-label">Alamat Waris</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="fas fa-map-marker-alt"></i></span>
                                            <input type="text" id="waris_address" name="waris_address" 
                                                value="{{ old('waris_address', $booking->waris_address ?? '') }}" 
                                                class="form-control" placeholder="Contoh: No. 10, Jalan Mawar, 12345 Shah Alam" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Deceased Information --}}
                            <div class="col-md-6">
                                <div class="bg-light p-4 rounded-3 h-100">
                                    <h5 class="mb-4 text-primary">
                                        <i class="fas fa-angel me-2"></i> Maklumat Si Mati
                                    </h5>
                                    
                                    <div class="mb-3">
                                        <label for="nama_simati" class="form-label">Nama Si Mati</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="fas fa-user"></i></span>
                                            <input type="text" id="nama_simati" name="nama_simati" 
                                                   value="{{ old('nama_simati', $booking->nama_simati) }}" 
                                                   class="form-control" placeholder="Siti binti Ahmad" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="no_mykad_simati" class="form-label">No. MyKad</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="fas fa-id-card"></i></span>
                                            <input type="text" id="no_mykad_simati" name="no_mykad_simati" 
                                                   value="{{ old('no_mykad_simati', $booking->no_mykad_simati) }}" 
                                                   class="form-control" placeholder="0000000000" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="jantina_simati" class="form-label">Jantina Si Mati</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="fas fa-venus-mars"></i></span>
                                            <select id="jantina_simati" name="jantina_simati" class="form-select" required>
                                                <option value="Lelaki" {{ old('jantina_simati', $booking->jantina_simati) == 'Lelaki' ? 'selected' : '' }}>Lelaki</option>
                                                <option value="Perempuan" {{ old('jantina_simati', $booking->jantina_simati) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="no_sijil_kematian" class="form-label">No. Sijil Kematian</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="as fa-award"></i></span>
                                            <input type="text" id="no_sijil_kematian" name="no_sijil_kematian" 
                                                   value="{{ old('no_sijil_kematian', $booking->no_sijil_kematian) }}" 
                                                   class="form-control" placeholder="A1234567" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="area" class="form-label">Kawasan</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="fas fa-map-marker-alt"></i></span>
                                            <input type="text" id="area" name="area" 
                                                   value="{{ old('area', $booking->area) }}" 
                                                   class="form-control bg-light" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Event Details --}}
                            <div class="col-12">
                                <div class="bg-light p-4 rounded-3">
                                    <h5 class="mb-4 text-primary">
                                        <i class="fas fa-calendar-alt me-2"></i> Butiran Acara
                                    </h5>
                                    
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="eventDate" class="form-label">Tarikh Meninggal</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-white"><i class="fas fa-calendar-day"></i></span>
                                                <input type="text" id="eventDate" name="eventDate" 
                                                       value="{{ old('eventDate', $booking->eventDate) }}" 
                                                       class="form-control" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label for="eventTime" class="form-label">Masa Meninggal</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-white"><i class="fas fa-clock"></i></span>
                                                <input type="time" id="eventTime" name="eventTime" 
                                                       value="{{ old('eventTime', $booking->eventTime) }}" 
                                                       class="form-control" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <label for="eventLocation" class="form-label">Lokasi Kematian</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-white"><i class="fas fa-map-marked-alt"></i></span>
                                                <input type="text" id="eventLocation" name="eventLocation" 
                                                       value="{{ old('eventLocation', $booking->eventLocation) }}" 
                                                       class="form-control" placeholder="Masjid Sultan Salahuddin Abdul Aziz Shah" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <label for="notes" class="form-label">Catatan Tambahan</label>
                                            <textarea id="notes" name="notes" rows="3" class="form-control" 
                                                      placeholder="Arahan khas atau maklumat tambahan">{{ old('notes', $booking->notes) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Form Actions --}}
                        <div class="d-flex justify-content-between mt-5">
                            <a href="{{ route('ManageBooking.Customer.dashboardBooking') }}" 
                               class="btn btn-outline-danger px-4 py-2"
                               onclick="return confirm('Adakah anda pasti ingin membatalkan kemaskini tempahan ini?')">
                                <i class="fas fa-times me-2"></i> Batalkan
                            </a>
                            <button type="submit" class="btn btn-primary px-4 py-2">
                                <i class="fas fa-save me-2"></i> Kemaskini
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <!-- Flatpickr CSS -->
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- Malay localization -->
    <script src="https://npmcdn.com/flatpickr/dist/l10n/ms.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize date picker
            flatpickr("#eventDate", {
                dateFormat: "Y-m-d",
                minDate: "today",
                locale: "ms",
                disable: [
                    // Example unavailable dates - replace with your actual data
                    "2024-12-25",
                    "2024-12-31",
                    "2025-01-01"
                ],
                onChange: function(selectedDates, dateStr, instance) {
                    // You can add additional validation here
                }
            });

            // Form validation
            (function () {
                'use strict'
                var forms = document.querySelectorAll('.needs-validation')
                Array.prototype.slice.call(forms)
                    .forEach(function (form) {
                        form.addEventListener('submit', function (event) {
                            if (!form.checkValidity()) {
                                event.preventDefault()
                                event.stopPropagation()
                            }
                            form.classList.add('was-validated')
                        }, false)
                    })
            })();
        });
    </script>

    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        }
        
        .card {
            border-radius: 0.75rem;
            overflow: hidden;
        }
        
        .card-header {
            border-bottom: none;
        }
        
        .form-control, .form-select {
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
        }
        
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
            border-color: #4e73df;
        }
        
        .input-group-text {
            border-radius: 0.5rem 0 0 0.5rem;
        }
        
        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
            border-radius: 0.5rem;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2653d4;
            transform: translateY(-2px);
        }
        
        .btn-outline-danger {
            border-radius: 0.5rem;
            transition: all 0.3s;
        }
        
        .btn-outline-danger:hover {
            transform: translateY(-2px);
        }
        
        .bg-light {
            background-color: #f8f9fa !important;
        }
        
        .invalid-feedback {
            font-size: 0.85rem;
        }
        
        .was-validated .form-control:invalid, 
        .was-validated .form-control:invalid:focus {
            border-color: #e74a3b;
            box-shadow: 0 0 0 0.25rem rgba(231, 74, 59, 0.25);
        }
        
        .was-validated .form-control:valid, 
        .was-validated .form-control:valid:focus {
            border-color: #1cc88a;
            box-shadow: 0 0 0 0.25rem rgba(28, 200, 138, 0.25);
        }
        
        .flatpickr-day.disabled {
            color: #dc3545;
            background-color: #f8d7da;
            cursor: not-allowed;
        }
    </style>
@endsection