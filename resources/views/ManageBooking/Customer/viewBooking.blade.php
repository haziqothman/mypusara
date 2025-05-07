@extends('layouts.navigation')

@section('content')
    <div class="container py-5">
        {{-- Page Header --}}
        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold text-gradient-primary mb-3">Detail Tempahan</h1>
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
        <div class="card border-0 shadow-lg overflow-hidden glass-effect">
            <div class="card-header bg-gradient-primary py-3">
                <h5 class="mb-0 text-white"><i class="fas fa-calendar-check me-2"></i> Maklumat Tempahan</h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    {{-- Customer Info --}}
                    <div class="col-md-6">
                        <div class="detail-section">
                            <h6 class="section-title"><i class="fas fa-user-circle me-2"></i> Maklumat Waris</h6>
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
                            <h6 class="section-title"><i class="fas fa-angel me-2"></i> Maklumat Si Mati</h6>
                            <div class="detail-item">
                                <span class="detail-label">Nama:</span>
                                <span class="detail-value">{{ $booking->nama_simati }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">No Kad Pengenalan:</span>
                                <span class="detail-value">{{ $booking->no_mykad_simati }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="divider my-4" style="height: 1px; background: rgba(0,0,0,0.1);"></div>

                <div class="row g-4">
                    {{-- Booking Details --}}
                    <div class="col-md-6">
                        <div class="detail-section">
                            <h6 class="section-title"><i class="fas fa-info-circle me-2"></i> Butiran Tempahan</h6>
                            <div class="detail-item">
                                <span class="detail-label">No Pusara:</span>
                                <span class="detail-value">{{ $booking->package ? $booking->package->pusaraNo : 'N/A' }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Lokasi:</span>
                                <span class="detail-value">{{ $booking->eventLocation }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Tarikh:</span>
                                <span class="detail-value">{{ $booking->eventDate }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Masa:</span>
                                <span class="detail-value">{{ $booking->eventTime }}</span>
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

                    {{-- Notes --}}
                    <div class="col-md-6">
                        <div class="detail-section">
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
        }
        
        .text-gradient-primary {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.1);
        }
        
        .bg-gradient-primary {
            background: var(--primary-gradient);
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
        }
        
        .section-title {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid rgba(78, 115, 223, 0.2);
        }
        
        .detail-item {
            display: flex;
            margin-bottom: 1rem;
        }
        
        .detail-label {
            font-weight: 600;
            color: #4b5563;
            min-width: 150px;
        }
        
        .detail-value {
            color: #2d3748;
        }
        
        .notes-box {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
            min-height: 150px;
            color: #4b5563;
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
    </style>
@endsection