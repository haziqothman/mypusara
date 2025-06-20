@extends('layouts.navigation')

@section('content')
<div class="container-fluid px-4">
    <!-- Welcome Header with Profile Image -->
    <div class="d-flex justify-content-between align-items-center mt-4 mb-5">
        <div>
            <h2 class="fw-bold text-gradient-primary mb-1">Selamat Datang, {{ Auth::user()->name }}!</h2>
            <p class="text-muted mb-0">Gambaran keseluruhan tempahan pusara anda</p>
        </div>
        <div class="position-relative">
            @if(Auth::user()->profile_image)
                <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" class="avatar avatar-lg rounded-circle border border-3 border-primary shadow" alt="Profile Image">
            @else
                <div class="avatar avatar-lg bg-primary text-white rounded-circle border border-3 border-primary shadow">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            @endif
            <span class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-2 border-white" style="width: 15px; height: 15px;"></span>
        </div>
    </div>

    <!-- Stats Cards with Icons and Images -->
    <div class="row mb-4 g-4">
        <!-- Total Bookings -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3 h-100 hover-lift" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);">
                <div class="card-body text-white position-relative" style="z-index: 1;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-white-50 mb-2">
                                <i class="fas fa-calendar-check me-2"></i> Jumlah Tempahan
                            </h6>
                            <h2 class="mb-0">{{ $bookings->count() }}</h2>
                        </div>
                        <div class="bg-white-10 p-3 rounded-circle">
                            <i class="fas fa-calendar-alt fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('ManageBooking.Customer.dashboardBooking') }}" class="btn btn-sm btn-light rounded-pill">
                            Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pending Bookings -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3 h-100 hover-lift" style="background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%);">
                <div class="card-body text-white position-relative" style="z-index: 1;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-white-50 mb-2">
                                <i class="fas fa-clock me-2"></i> Dalam Proses
                            </h6>
                            <h2 class="mb-0">{{ $bookings->where('status', 'pending')->count() }}</h2>
                        </div>
                        <div class="bg-white-10 p-3 rounded-circle">
                            <i class="fas fa-hourglass-half fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-white-10 text-white">
                            <i class="fas fa-info-circle me-1"></i> Menunggu kelulusan
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cancelled Bookings -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3 h-100 hover-lift" style="background: linear-gradient(135deg, #e74a3b 0%, #be2617 100%);">
                <div class="card-body text-white position-relative" style="z-index: 1;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-white-50 mb-2">
                                <i class="fas fa-times-circle me-2"></i> Dibatalkan
                            </h6>
                            <h2 class="mb-0">{{ $bookings->where('status', 'cancelled')->count() }}</h2>
                        </div>
                        <div class="bg-white-10 p-3 rounded-circle">
                            <i class="fas fa-ban fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('customer.display.package') }}" class="btn btn-sm btn-light rounded-pill">
                            Buat Baru <i class="fas fa-plus ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Completed Bookings -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3 h-100 hover-lift" style="background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);">
                <div class="card-body text-white position-relative" style="z-index: 1;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-white-50 mb-2">
                                <i class="fas fa-check-circle me-2"></i> Selesai
                            </h6>
                            <h2 class="mb-0">{{ $bookings->where('status', 'confirmed')->count() }}</h2>
                        </div>
                        <div class="bg-white-10 p-3 rounded-circle">
                            <i class="fas fa-check-double fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-white-10 text-white">
                            <i class="fas fa-check me-1"></i> Berjaya
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Bookings with Image -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-history text-primary me-2"></i> 
                            Tempahan Terkini Anda
                        </h5>
                        <a href="{{ route('ManageBooking.Customer.dashboardBooking') }}" class="btn btn-sm btn-outline-primary rounded-pill">
                            Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($bookings->take(3) as $booking)
                        <div class="list-group-item border-0 py-3 hover-lift-light">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 ms-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-1">{{ $booking->nama_simati }}</h6>
                                        <span class="badge bg-{{ $booking->status_color }}-soft">
                                            @if($booking->status == 'confirmed')
                                                <i class="fas fa-check-circle me-1"></i> Disahkan
                                            @elseif($booking->status == 'pending')
                                                <i class="fas fa-clock me-1"></i> Dalam Proses
                                            @else
                                                <i class="fas fa-times-circle me-1"></i> Dibatalkan
                                            @endif
                                        </span>
                                    </div>
                                    <p class="text-muted mb-0">
                                        <i class="fas fa-tombstone me-1"></i> No. Pusara: {{ $booking->package->pusaraNo ?? 'N/A' }} • 
                                        <i class="fas fa-calendar-day me-1"></i> {{ \Carbon\Carbon::parse($booking->eventDate)->format('d M Y') }} • 
                                        <i class="fas fa-map-marker-alt me-1"></i> {{ $booking->eventLocation }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="list-group-item border-0 py-4 text-center">
                            <img src="{{ asset('images/no-booking.png') }}" class="img-fluid mb-3" style="max-height: 150px;" alt="No Bookings">
                            <h5 class="text-muted">Tiada rekod tempahan ditemui</h5>
                            <a href="{{ route('customer.display.package') }}" class="btn btn-primary rounded-pill mt-2">
                                <i class="fas fa-plus me-2"></i> Buat Tempahan Baru
                            </a>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        
      <!-- Quick Actions with Image -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt text-primary me-2"></i> 
                        Tindakan Pantas
                    </h5>
                </div>
                <div class="card-body d-flex flex-column">                    
                    <div class="d-grid gap-3">
                        <a href="{{ route('customer.display.package') }}" class="btn btn-primary btn-lg text-start">
                            <i class="fas fa-plus-circle me-2"></i> Buat Tempahan Baru
                        </a>
                        
                        <button class="btn btn-success btn-lg text-start" data-bs-toggle="modal" data-bs-target="#careGuideModal">
                            <i class="fas fa-book-open me-2"></i> Panduan Penjagaan
                        </button>
                        
                        <a href="https://wa.me/601137490379" target="_blank" class="btn btn-lg text-start text-white" style="background-color: #25D366;">
                            <i class="fab fa-whatsapp me-2"></i> WhatsApp Kami
                        </a>
                        
                     <a href="https://mail.google.com/mail/?view=cm&fs=1&to=haziq.othman99@gmail.com&su=Pertanyaan%20Tempahan%20Pusara&body=Sila%20nyatakan%20pertanyaan%20anda..." 
                        target="_blank"
                        class="btn btn-gmail btn-lg text-start" 
                        style="background-color: #D44638; color: white;">
                        <i class="fas fa-envelope me-2"></i> Email Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>

    <!-- Help Section with Image -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
        <div class="row g-0">
            <div class="col-md-5">
                <img src="{{ asset("avatars/kubur2.jpeg") }}" class="img-fluid h-100 object-cover" alt="Customer Support">
            </div>
            <div class="col-md-7">
                <div class="card-body p-4">
                    <h3 class="text-primary mb-3">Perlukan Bantuan?</h3>
                    <p class="text-muted mb-4">Pasukan sokongan kami sedia membantu anda dengan sebarang pertanyaan mengenai tempahan pusara atau penjagaan pusara keluarga.</p>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                                    <i class="fas fa-phone-alt text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Hubungi Kami</h6>
                                    <small class="text-muted">+6011 3749 0379</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                                    <i class="fas fa-envelope text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Emel Kami</h6>
                                    <small class="text-muted">support@mypusara.com</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                                    <i class="fab fa-whatsapp text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">WhatsApp</h6>
                                    <small class="text-muted">+6011 3749 0379</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                                    <i class="fas fa-map-marker-alt text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Lokasi Kami</h6>
                                    <small class="text-muted">Kuantan, Pahang</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Care Guide Modal -->
    <div class="modal fade" id="careGuideModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-book-medical me-2"></i> 
                        Panduan Penjagaan Pusara
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <img src="{{ asset('images/grave-care.jpg') }}" class="img-fluid rounded mb-3" alt="Grave Care">
                            <h5 class="text-primary">Penjagaan Fizikal</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Bersihkan kawasan pusara secara berkala</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Gunakan air dan sabun lembut</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Elakkan bahan kimia kuat</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Kawal pertumbuhan rumput liar</li>
                            </ul>
                        </div>
                        <div class="col-md-6 mb-4">
                            <img src="{{ asset('images/prayer-guide.jpg') }}" class="img-fluid rounded mb-3" alt="Prayer Guide">
                            <h5 class="text-primary">Amalan Kerohanian</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Baca Surah Yasin ketika ziarah</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Hadiahkan bacaan Al-Fatihah</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Baca doa ziarah kubur</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Bersedekah untuk si mati</li>
                            </ul>
                        </div>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> Penjagaan yang baik mencerminkan penghormatan kepada yang telah tiada.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary">Cetak Panduan</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .text-gradient-primary {
        background: linear-gradient(90deg, #4e73df 0%, #224abe 100%);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }
    
    .avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .avatar-lg {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }
    
    .hover-lift {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 2.5rem rgba(0, 0, 0, 0.1) !important;
    }
    
    .hover-lift-light:hover {
        transform: translateY(-2px);
        background-color: rgba(78, 115, 223, 0.03) !important;
    }
    
    .bg-primary-soft {
        background-color: rgba(78, 115, 223, 0.1) !important;
    }
    
    .bg-success-soft {
        background-color: rgba(28, 200, 138, 0.1) !important;
    }
    
    .bg-warning-soft {
        background-color: rgba(246, 194, 62, 0.1) !important;
    }
    
    .bg-danger-soft {
        background-color: rgba(231, 74, 59, 0.1) !important;
    }
    
    .bg-white-10 {
        background-color: rgba(255, 255, 255, 0.1);
    }
    
    .object-cover {
        object-fit: cover;
    }
    
    .rounded-3 {
        border-radius: 0.75rem !important;
    }
    
    .list-group-item {
        transition: all 0.2s ease;
    }
</style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize tooltips
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
                
                // Initialize modals
                var documentModal = new bootstrap.Modal(document.getElementById('documentModal'));
                var doaModal = new bootstrap.Modal(document.getElementById('doaModal'));
            });
        </script>
@endsection