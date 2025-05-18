@extends('layouts.navigation')

@section('content')
    <div class="container py-5">
        {{-- Page Header --}}
        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold text-gradient-primary mb-3">
                <i class="fas fa-calendar-check me-2"></i> Detail Tempahan
            </h1>
            <div class="divider mx-auto" style="width: 80px; height: 3px; background: linear-gradient(90deg, #4e73df, #1cc88a);"></div>
            <p class="text-muted mt-3">Maklumat lengkap mengenai tempahan anda</p>
        </div>

        {{-- Display success or error messages --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show glass-effect" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-2"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger alert-dismissible fade show glass-effect" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        {{-- Booking Details --}}
        <div class="card border-0 shadow-lg overflow-hidden glass-effect mb-4">
            <div class="card-header bg-gradient-primary py-3">
                <h5 class="mb-0 text-white"><i class="fas fa-info-circle me-2"></i> Maklumat Tempahan</h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    {{-- Customer Info --}}
                    <div class="col-md-6">
                        <div class="detail-section">
                            <h6 class="section-title bg-light-primary">
                                <i class="fas fa-user-circle me-2"></i> Maklumat Waris
                            </h6>
                            <div class="detail-item">
                                <span class="detail-label">Nama:</span>
                                <span class="detail-value">{{ $booking->customerName }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Email:</span>
                                <span class="detail-value">{{ $booking->customerEmail }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">No Telefon:</span>
                                <span class="detail-value">{{ $booking->contactNumber }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Alamat Waris:</span>
                                <span class="detail-value">{{ $booking->waris_address }}</span>
                            </div>
                        </div>
                    </div>
                    

                    {{-- Deceased Info --}}
                    <div class="col-md-6">
                        <div class="detail-section">
                            <h6 class="section-title bg-light-primary">
                                <i class="fas fa-angel me-2"></i> Maklumat Si Mati
                            </h6>
                            <div class="detail-item">
                                <span class="detail-label">Nama:</span>
                                <span class="detail-value">{{ $booking->nama_simati }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">No Kad Pengenalan:</span>
                                <span class="detail-value">{{ $booking->no_mykad_simati }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Jantina:</span>
                                <span class="detail-value">
                                    @if($booking->jantina_simati == 'Lelaki')
                                        <i class="fas fa-mars text-primary me-1"></i> Lelaki
                                    @else
                                        <i class="fas fa-venus text-danger me-1"></i> Perempuan
                                    @endif
                                </span>
                            </div>
                            
                            <div class="detail-item">
                                <span class="detail-label">Tarikh Meninggal:</span>
                                <span class="detail-value">{{ $booking->eventDate }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Masa Meninggal:</span>
                                <span class="detail-value">{{ $booking->eventTime }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                  @if($booking->death_certificate_image)
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-file-certificate me-2"></i> Sijil Kematian</h5>
                        </div>
                        <div class="card-body p-0">
                            <img class="card-img-top" 
                                src="{{ asset('death_certificates/' . $booking->death_certificate_image)}}" 
                                alt="Sijil Kematian"
                                style="width: 100%; height: auto; max-height: 500px; object-fit: contain;">
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Tiada sijil kematian dimuat naik
                    </div>
                @endif
                

                <div class="divider my-4" style="height: 1px; background: rgba(0,0,0,0.1);"></div>

                <div class="row g-4">
                    {{-- Booking Details --}}
                    <div class="col-md-6">
                        <div class="detail-section">
                            <h6 class="section-title bg-light-primary">
                                <i class="fas fa-calendar-alt me-2"></i> Butiran Tempahan
                            </h6>
                            <div class="detail-item">
                                <span class="detail-label">No Pusara:</span>
                                <span class="detail-value">{{ $booking->package ? $booking->package->pusaraNo : 'N/A' }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Lokasi Kematian:</span>
                                <span class="detail-value">{{ $booking->eventLocation }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Status:</span>
                                <span class="detail-value">
                                    @if ($booking->status === 'confirmed')
                                        <span class="badge rounded-pill bg-success bg-opacity-10 text-success py-2 px-3">
                                            <i class="fas fa-check-circle me-1"></i> Reserved
                                        </span>
                                    @elseif ($booking->status === 'pending')
                                        <span class="badge rounded-pill bg-warning bg-opacity-10 text-warning py-2 px-3">
                                            <i class="fas fa-clock me-1"></i> Pending
                                        </span>
                                    @else
                                        <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger py-2 px-3">
                                            <i class="fas fa-times-circle me-1"></i> Cancelled
                                        </span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Location and Notes --}}
                    <div class="col-md-6">
                        <div class="detail-section">
                            <h6 class="section-title bg-light-primary">
                                <i class="fas fa-map-marker-alt me-2"></i> Koordinat Lokasi
                            </h6>
                            <div class="detail-item">
                                <span class="detail-label">Latitude:</span>
                                <span class="detail-value">{{ $booking->package->latitude ?? 'N/A' }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Longitude:</span>
                                <span class="detail-value">{{ $booking->package->longitude ?? 'N/A' }}</span>
                            </div>
                            @if($booking->package && $booking->package->latitude && $booking->package->longitude)
                            <div class="detail-item">
                                <span class="detail-label">Peta:</span>
                                <span class="detail-value">
                                    <a href="https://www.google.com/maps?q={{ $booking->package->latitude }},{{ $booking->package->longitude }}" 
                                       target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-external-link-alt me-1"></i> Buka di Google Maps
                                    </a>
                                </span>
                            </div>
                            @endif
                        </div>

                        <div class="detail-section mt-4">
                            <h6 class="section-title bg-light-primary">
                                <i class="fas fa-sticky-note me-2"></i> Catatan Tambahan
                            </h6>
                            <div class="notes-box">
                                {{ $booking->notes ?: 'Tiada catatan tambahan.' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="d-flex justify-content-between align-items-center mt-4">
            {{-- Back Button --}}
            <a href="{{ route('admin.bookings.index') }}" 
               class="btn btn-outline-primary btn-lg px-4 py-2 rounded-pill">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
            </a>
            
            {{-- Delete Button --}}
            <button type="button" 
                    class="btn btn-danger btn-lg px-4 py-2 rounded-pill shadow-sm" 
                    data-bs-toggle="modal" 
                    data-bs-target="#deleteBookingModal">
                <i class="fas fa-trash-alt me-2"></i> Padam Tempahan
            </button>  
        </div>

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteBookingModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-exclamation-triangle me-2"></i> Sahkan Penghapusan
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ route('admin.bookings.destroy', $booking->id) }}">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body">
                            <div class="alert alert-danger bg-danger bg-opacity-10 border-danger">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <strong>Amaran!</strong> Tindakan ini tidak boleh diundur.
                            </div>
                            <p>Adakah anda pasti ingin memadam tempahan ini secara kekal?</p>
                            <ul class="list-group list-group-flush mb-3">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="fw-bold">No. Tempahan:</span>
                                    <span>#{{ $booking->id }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="fw-bold">Nama Waris:</span>
                                    <span>{{ $booking->customerName }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="fw-bold">Nama Si Mati:</span>
                                    <span>{{ $booking->nama_simati }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="fw-bold">Lokasi Pusara:</span>
                                    <span>{{ $booking->package ? $booking->package->pusaraNo : 'N/A' }}</span>
                                </li>
                            </ul>
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" id="confirmDelete" required>
                                <label class="form-check-label" for="confirmDelete">
                                    Saya memahami bahawa data akan dihapuskan secara kekal
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i> Batal
                            </button>
                            <button type="submit" class="btn btn-danger rounded-pill px-4">
                                <i class="fas fa-trash-alt me-1"></i> Sahkan Penghapusan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --primary-color: #4e73df;
            --primary-gradient: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            --primary-light: rgba(78, 115, 223, 0.1);
            --success-color: #1cc88a;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
        }
        
        .text-gradient-primary {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .bg-gradient-primary {
            background: var(--primary-gradient);
        }
        
        .bg-light-primary {
            background-color: var(--primary-light);
        }
        
        .card {
            border-radius: 16px;
            overflow: hidden;
            border: none;
        }
        
        .card-header {
            border-bottom: none;
        }
        
        .detail-section {
            background: white;
            border-radius: 12px;
            padding: 0;
            height: 100%;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        
        .section-title {
            color: var(--primary-color);
            font-weight: 600;
            padding: 1rem 1.5rem;
            margin: 0;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        
        .detail-item {
            display: flex;
            justify-content: space-between;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        
        .detail-item:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: 600;
            color: #4b5563;
        }
        
        .detail-value {
            color: #2d3748;
            text-align: right;
        }
        
        .notes-box {
            padding: 1.5rem;
            color: #4b5563;
            min-height: 150px;
        }
        
        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: white;
        }
        
        .badge {
            font-weight: 500;
        }
        
        .modal-content {
            border-radius: 16px;
            overflow: hidden;
        }
        
        .list-group-item {
            padding: 0.75rem 1.25rem;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize any necessary JavaScript here
        });
    </script>
@endsection