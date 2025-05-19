@extends('layouts.navigation')

@section('content')
    <div class="container py-5">
        {{-- Page Header --}}
        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold text-gradient-primary mb-3">Detail Tempahan</h1>
            <div class="divider mx-auto" style="width: 80px; height: 3px; background: linear-gradient(90deg, #4e73df, #1cc88a);"></div>
            <p class="text-muted mt-3">Maklumat lengkap mengenai tempahan anda</p>
        </div>

        {{-- Display messages --}}
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

        {{-- Main Booking Card --}}
        <div class="card border-0 shadow-lg overflow-hidden glass-effect">
            <div class="card-header bg-gradient-primary py-3">
                <h5 class="mb-0 text-white"><i class="fas fa-calendar-check me-2"></i> Maklumat Tempahan</h5>
            </div>
            <div class="card-body p-4">
                {{-- Top Row - Customer and Deceased Info --}}
                <div class="row g-4 mb-4">
                    {{-- Customer Info --}}
                    <div class="col-md-6">
                        <div class="detail-section h-100">
                            <h6 class="section-title"><i class="fas fa-user-circle me-2"></i> Maklumat Waris</h6>
                            <div class="detail-grid">
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
                    </div>

                    {{-- Deceased Info --}}
                    <div class="col-md-6">
                        <div class="detail-section h-100">
                            <h6 class="section-title"><i class="fas fa-angel me-2"></i> Maklumat Si Mati</h6>
                            <div class="detail-grid">
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
                          <a href="{{ asset('death_certificates/' . $booking->death_certificate_image) }}" 
                                target="_blank" 
                                class="btn btn-sm btn-outline-primary w-100">
                                <i class="fas fa-expand me-1"></i> Lihat Penuh
                          </a>
                    </div>
                @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Tiada sijil kematian dimuat naik
                    </div>
                @endif
                           
                
                {{-- Location Section --}}
                @if($booking->package && $booking->package->latitude && $booking->package->longitude)
                <div class="detail-section mb-4">
                    <h6 class="section-title bg-light-primary">
                        <i class="fas fa-map-marker-alt me-2"></i> Lokasi Pusara
                    </h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label">No Pusara:</span>
                                <span class="detail-value">{{ $booking->package->pusaraNo ?? 'N/A' }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Lokasi Kematian:</span>
                                <span class="detail-value">{{ $booking->eventLocation }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label">Koordinat:</span>
                                <span class="detail-value">
                                    {{ $booking->package->latitude ?? 'N/A' }}, {{ $booking->package->longitude ?? 'N/A' }}
                                </span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Peta:</span>
                                <span class="detail-value">
                                    <a href="https://www.google.com/maps?q={{ $booking->package->latitude }},{{ $booking->package->longitude }}" 
                                       target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-external-link-alt me-1"></i> Buka di Google Maps
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Bottom Row - Status and Notes --}}
                <div class="row g-4">
                    {{-- Status --}}
                    <div class="col-md-6">
                        <div class="detail-section h-100">
                            <h6 class="section-title"><i class="fas fa-info-circle me-2"></i> Status Tempahan</h6>
                            <div class="d-flex align-items-center justify-content-center h-75">
                                <div class="text-center">
                                    @if ($booking->status === 'confirmed')
                                        <span class="badge rounded-pill bg-success bg-opacity-10 text-success py-3 px-4 fs-6">
                                            <i class="fas fa-check-circle me-1"></i> Reserved
                                        </span>
                                        <p class="mt-3 text-muted">Tempahan anda telah disahkan</p>
                                    @elseif ($booking->status === 'pending')
                                        <span class="badge rounded-pill bg-warning bg-opacity-10 text-warning py-3 px-4 fs-6">
                                            <i class="fas fa-clock me-1"></i> Pending
                                        </span>
                                        <p class="mt-3 text-muted">Menunggu pengesahan</p>
                                    @else
                                        <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger py-3 px-4 fs-6">
                                            <i class="fas fa-times-circle me-1"></i> Cancelled
                                        </span>
                                        <p class="mt-3 text-muted">Tempahan ini telah dibatalkan</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Notes --}}
                    <div class="col-md-6">
                        <div class="detail-section h-100">
                            <h6 class="section-title"><i class="fas fa-sticky-note me-2"></i> Catatan Tambahan</h6>
                            <div class="notes-box">
                                {{ $booking->notes ?: 'Tiada catatan tambahan.' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Back Button --}}
        <div class="text-center mt-5">
            <a href="{{ route('ManageBooking.Customer.dashboardBooking') }}" class="btn btn-outline-primary btn-lg rounded-pill px-4">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>

    <style>
        :root {
            --primary-color: #4e73df;
            --primary-gradient: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            --success-color: #1cc88a;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --light-primary: rgba(78, 115, 223, 0.1);
        }
        
        .text-gradient-primary {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .bg-gradient-primary {
            background: var(--primary-gradient);
        }
        
        .bg-light-primary {
            background-color: var(--light-primary);
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
            padding: 1.5rem;
            height: 100%;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            border: 1px solid rgba(0,0,0,0.05);
        }
        
        .section-title {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid rgba(78, 115, 223, 0.2);
        }
        
        .detail-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .detail-item {
            display: flex;
            margin-bottom: 0.5rem;
        }
        
        .detail-label {
            font-weight: 600;
            color: #4b5563;
            min-width: 150px;
        }
        
        .detail-value {
            color: #2d3748;
            word-break: break-word;
        }
        
        .notes-box {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
            min-height: 150px;
            color: #4b5563;
            height: calc(100% - 40px);
            overflow-y: auto;
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
            letter-spacing: 0.5px;
        }

        .gender-icon {
            margin-right: 5px;
        }

        .divider {
            background: linear-gradient(90deg, rgba(78, 115, 223, 0.1), rgba(78, 115, 223, 0.5), rgba(78, 115, 223, 0.1));
        }
    </style>
@endsection