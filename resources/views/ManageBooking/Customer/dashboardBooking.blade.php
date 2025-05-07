@extends('layouts.navigation')

@section('content')
    <div class="container my-5">
        <!-- Header Section with Gradient Background -->
        <div class="card bg-gradient-primary shadow-lg mb-5">
            <div class="card-body py-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="text-white mb-0">Tempahan Anda</h1>
                        <p class="text-white-50 mb-0">Senarai semua tempahan anda</p>
                    </div>
                    <a href="{{ route('customer.display.package') }}" class="btn btn-light btn-lg rounded-pill shadow-sm">
                        <i class="fas fa-plus me-2"></i> Tempah Baru
                    </a>
                </div>
            </div>
        </div>

        <!-- Messages Section -->
        <div class="mb-4">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-lg shadow-sm">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @elseif (session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-lg shadow-sm">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(isset($message))
                <div class="alert alert-info alert-dismissible fade show text-center rounded-lg shadow-sm">
                    <i class="fas fa-info-circle me-2"></i>
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        <!-- Bookings Table Section -->
        @if($bookings->isNotEmpty())
            <div class="card shadow-lg border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light-primary text-dark">
                                <tr>
                                    <th class="ps-4">Kawasan</th>
                                    <th>Nama Simati</th>
                                    <th>No Pusara</th>
                                    <th>Tarikh</th>
                                    <th>Masa</th>
                                    <th>Lokasi</th>
                                    <th>Ulasan</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookings as $booking)
                                    <tr class="align-middle">
                                        <td class="ps-4 fw-bold">{{ $booking->area }}</td>
                                        <td>{{ $booking->nama_simati }}</td>
                                        <td>{{ $booking->package ? $booking->package->pusaraNo : 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($booking->eventDate)->format('d M Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($booking->eventTime)->format('h:i A') }}</td>
                                        <td>
                                            <div class="text-truncate" style="max-width: 150px;" title="{{ $booking->eventLocation }}">
                                                {{ $booking->eventLocation }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-truncate" style="max-width: 200px;" title="{{ $booking->notes ?? '-' }}">
                                                {{ $booking->notes ?? '-' }}
                                            </div>
                                        </td>
                                        <td>
                                            @if($booking->status == 'confirmed')
                                                <span class="badge rounded-pill bg-success bg-opacity-10 text-success py-2 px-3">
                                                    <i class="fas fa-check-circle me-1"></i> Disahkan
                                                </span>
                                            @elseif($booking->status == 'pending')
                                                <span class="badge rounded-pill bg-warning bg-opacity-10 text-warning py-2 px-3">
                                                    <i class="fas fa-clock me-1"></i> Dalam Proses
                                                </span>
                                            @else
                                                <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger py-2 px-3">
                                                    <i class="fas fa-times-circle me-1"></i> Dibatalkan
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="d-flex justify-content-end gap-2">
                                                <!-- View Button -->
                                                <a href="{{ route('ManageBooking.Customer.viewBooking', $booking->id) }}" 
                                                class="btn btn-sm btn-outline-primary rounded-circle p-2" 
                                                title="View"
                                                data-bs-toggle="tooltip">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                
                                                <!-- Edit Button -->
                                                <a href="{{ route('ManageBooking.Customer.editBooking', $booking->id) }}" 
                                                class="btn btn-sm btn-outline-warning rounded-circle p-2 @if($booking->status == 'confirmed' || $booking->status == 'cancelled') disabled @endif" 
                                                title="Edit"
                                                data-bs-toggle="tooltip"
                                                @if($booking->status == 'confirmed' || $booking->status == 'cancelled') onclick="return false;" @endif>
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <!-- Cancel Button -->
                                                <a href="{{ route('customer.cancel.booking', $booking->id) }}" 
                                                class="btn btn-sm btn-outline-danger rounded-circle p-2 @if($booking->status == 'confirmed' || $booking->status == 'cancelled') disabled @endif" 
                                                title="Cancel"
                                                data-bs-toggle="tooltip"
                                                onclick="return confirm('Adakah anda pasti ingin membatalkan tempahan ini?')"
                                                @if($booking->status == 'confirmed' || $booking->status == 'cancelled') onclick="return false;" @endif>
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

           
        @endif
    </div>

    <!-- Custom CSS -->
    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        
        .bg-light-primary {
            background-color: rgba(102, 126, 234, 0.1);
        }
        
        .table-hover tbody tr:hover {
            background-color: rgba(102, 126, 234, 0.05);
        }
        
        .card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table th {
            border-top: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }
        
        .badge {
            font-weight: 500;
        }
        
        .btn-outline-primary, .btn-outline-warning, .btn-outline-danger {
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary:hover {
            background-color: #667eea;
            color: white;
        }
        
        .btn-outline-warning:hover {
            background-color: #ffc107;
            color: black;
        }
        
        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: white;
        }
        
        .disabled {
            opacity: 0.5;
            pointer-events: none;
        }
        
        .rounded-circle {
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>

    <!-- JavaScript -->
    <script>
        // Enable tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });
    </script>
@endsection