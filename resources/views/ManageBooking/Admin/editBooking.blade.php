@extends('layouts.navigation')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Form Card -->
                <div class="card border-0 shadow-lg">
                    <!-- Card Header -->
                    <div class="card-header bg-primary text-white py-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <h2 class="h5 mb-0">
                                <i class="fas fa-calendar-edit me-2"></i> Kemaskini Tempahan @session('error') {{ $value }} @endsession
                                @endsession
                            </h2>
                            <!-- <a href="{{ route('ManageBooking.Admin.dashboardBooking') }}" class="btn btn-sm btn-light">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a> -->
                        </div>
                    </div>
                    
                    <!-- Card Body -->
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('admin.bookings.update', $booking->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <!-- Form Sections -->
                            <div class="mb-4">
                                <h5 class="text-primary mb-3 border-bottom pb-2">
                                    <i class="fas fa-user-circle me-2"></i> Maklumat Waris
                                </h5>
                                
                                <div class="row g-3">
                                    <!-- Customer Name -->
                                    <div class="col-md-6">
                                        <label for="customerName" class="form-label">Nama Penuh</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                                            <input type="text" id="customerName" name="customerName" 
                                                value="{{ old('customerName', $booking->customerName) }}" 
                                                class="form-control bg-light" readonly>
                                        </div>
                                    </div>
                                    
                                    <!-- MyKad Number -->
                                    <div class="col-md-6">
                                        <label for="no_mykad" class="form-label">No. MyKad</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="fas fa-id-card"></i></span>
                                            <input type="text" id="no_mykad" name="no_mykad" 
                                                   value="{{ old('no_mykad', $booking->no_mykad) }}" 
                                                   class="form-control bg-light" readonly>
                                        </div>
                                    </div>
                                    
                                    <!-- Email -->
                                    <div class="col-md-6">
                                        <label for="customerEmail" class="form-label">Emel</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="fas fa-envelope"></i></span>
                                            <input type="email" id="customerEmail" name="customerEmail" 
                                                   value="{{ old('customerEmail', $booking->customerEmail) }}" 
                                                   class="form-control bg-light" readonly>
                                        </div>
                                    </div>
                                    
                                    <!-- Phone Number -->
                                    <div class="col-md-6">
                                        <label for="contactNumber" class="form-label">No. Telefon</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            <input type="tel" id="contactNumber" name="contactNumber" 
                                                   value="{{ old('contactNumber', $booking->contactNumber) }}" 
                                                   class="form-control" placeholder="cth: 0123456789" required>
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
                                    
                                    <!-- Area -->
                                    <div class="col-12">
                                        <label for="area" class="form-label">Kawasan</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="fas fa-map-marker-alt"></i></span>
                                            <input type="text" id="area" name="area" 
                                                   value="{{ old('area', $booking->area) }}" 
                                                   class="form-control bg-light" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Deceased Information Section -->
                            <div class="mb-4">
                                <h5 class="text-primary mb-3 border-bottom pb-2">
                                    <i class="fas fa-angel me-2"></i> Maklumat Si Mati
                                </h5>
                                
                                <div class="row g-3">
                                    <!-- Deceased Name -->
                                    <div class="col-md-6">
                                        <label for="nama_simati" class="form-label">Nama Si Mati</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                            <input type="text" id="nama_simati" name="nama_simati" 
                                                   value="{{ old('nama_simati', $booking->nama_simati) }}" 
                                                   class="form-control" placeholder="cth: Siti binti Ahmad" required>
                                        </div>
                                    </div>
                                    
                                    <!-- Deceased MyKad -->
                                    <div class="col-md-6">
                                        <label for="no_mykad_simati" class="form-label">No Kad Pengenalan Si Mati</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                            <input type="text" id="no_mykad_simati" name="no_mykad_simati" 
                                                   class="form-control" value="{{ old('no_mykad_simati', $booking->no_mykad_simati) }}"  
                                                   placeholder="cth: 0000000000" required>
                                        </div>
                                    </div>
                                    
                                    <!-- Death Certificate -->
                                    <div class="col-md-6">
                                        <label for="no_sijil_kematian" class="form-label">No Sijil Kematian</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-award"></i></span>
                                            <input type="text" id="no_sijil_kematian" name="no_sijil_kematian" 
                                                   class="form-control" value="{{ old('no_sijil_kematian', $booking->no_sijil_kematian) }}" 
                                                   placeholder="cth: A1234567" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Event Information Section -->
                            <div class="mb-4">
                                <h5 class="text-primary mb-3 border-bottom pb-2">
                                    <i class="fas fa-calendar-day me-2"></i> Maklumat Acara
                                </h5>
                                
                                <div class="row g-3">
                                    <!-- Event Date -->
                                    <div class="col-md-6">
                                        <label for="eventDate" class="form-label">Tarikh Acara</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                            <input type="text" id="eventDate" name="eventDate" 
                                                   value="{{ old('eventDate', $booking->eventDate) }}" 
                                                   class="form-control datepicker" required>
                                        </div>
                                    </div>
                                    
                                    <!-- Event Time -->
                                    <div class="col-md-6">
                                        <label for="eventTime" class="form-label">Masa Acara</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                            <input type="time" id="eventTime" name="eventTime" 
                                                   value="{{ old('eventTime', $booking->eventTime) }}" 
                                                   class="form-control" required>
                                        </div>
                                    </div>
                                    
                                    <!-- Event Location -->
                                    <div class="col-12">
                                        <label for="eventLocation" class="form-label">Lokasi Acara</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                                            <input type="text" id="eventLocation" name="eventLocation" 
                                                   value="{{ old('eventLocation', $booking->eventLocation) }}" 
                                                   class="form-control" placeholder="cth: Masjid Sultan Salahuddin Abdul Aziz Shah" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Additional Notes -->
                            <div class="mb-4">
                                <label for="notes" class="form-label">Catatan Tambahan</label>
                                <textarea id="notes" name="notes" rows="3" class="form-control" 
                                          placeholder="Arahan khas atau maklumat tambahan">{{ old('notes', $booking->notes) }}</textarea>
                            </div>
                            
                            <!-- Form Actions -->
                            <div class="d-flex justify-content-between mt-4">
                                 <a href="{{ route('admin.bookings.index') }}" 
                                    class="btn btn-outline-danger px-4"
                                    onclick="return confirm('Adakah anda pasti ingin membatalkan kemaskini tempahan ini?')">
                                        <i class="fas fa-times me-2"></i> Batalkan
                                </a>
                                
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-2"></i> Simpan Perubahan
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
    <!-- Flatpickr -->
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/ms.js"></script>

    <script>
        // Initialize date picker
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr(".datepicker", {
                dateFormat: "Y-m-d",
                locale: "ms",
                minDate: "today",
                disable: [
                    function(date) {
                        // Disable weekends
                        return (date.getDay() === 0 || date.getDay() === 6);
                    }
                ]
            });
        });
    </script>
@endsection

@section('styles')
    <style>
        .card {
            border-radius: 0.75rem;
            overflow: hidden;
        }
        
        .card-header {
            border-radius: 0 !important;
        }
        
        .form-label {
            font-weight: 600;
            color: #495057;
        }
        
        .input-group-text {
            min-width: 45px;
            justify-content: center;
        }
        
        .bg-light {
            background-color: #f8f9fa !important;
        }
        
        .datepicker, .timepicker {
            background-color: white;
        }
        
        .btn {
            font-weight: 500;
            padding: 0.5rem 1.5rem;
        }
        
        textarea {
            min-height: 100px;
        }
        
        .flatpickr-day.disabled {
            color: #dc3545;
            background-color: rgba(220, 53, 69, 0.1);
        }
        
        .flatpickr-day.selected {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
    </style>
@endsection