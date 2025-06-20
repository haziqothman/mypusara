@extends('layouts.navigation')

@section('content')
<div class="container-fluid px-4">
    <!-- Welcome Header -->
    <div class="d-flex justify-content-between align-items-center mt-4 mb-5">
        <div>
            <h2 class="fw-bold text-gradient mb-1">Selamat Datang, {{ Auth::user()->name }}!</h2>
            <p class="text-muted mb-0">Dashboard Pentadbir - Sistem Pengurusan Pusara</p>
        </div>
        <div class="position-relative">
            <div class="avatar avatar-lg bg-primary text-white rounded-circle border border-3 border-primary shadow">
                <i class="fas fa-user-shield"></i>
            </div>
            <span class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-2 border-white" style="width: 15px; height: 15px;"></span>
        </div>
    </div>

    <!-- Stats Cards with Images -->
    <div class="row mb-4 g-4">
        <!-- Total Bookings -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-3 h-100 hover-lift" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);">
                <div class="card-body text-white position-relative" style="z-index: 1;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-white-50 mb-2">
                                <i class="fas fa-calendar-check me-2"></i> Jumlah Tempahan
                            </h6>
                            <h2 class="mb-0">{{ $stats['total_bookings'] }}</h2>
                        </div>
                        <div class="bg-white-10 p-3 rounded-circle">
                            <i class="fas fa-calendar-alt fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-white-10 text-white">
                            <i class="fas fa-clock me-1"></i> {{ $stats['new_bookings_today'] }} hari ini
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Approvals -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-3 h-100 hover-lift" style="background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%);">
                <div class="card-body text-white position-relative" style="z-index: 1;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-white-50 mb-2">
                                <i class="fas fa-clock me-2"></i> Menunggu Kelulusan
                            </h6>
                            <h2 class="mb-0">{{ $stats['pending_approvals'] }}</h2>
                        </div>
                        <div class="bg-white-10 p-3 rounded-circle">
                            <i class="fas fa-hourglass-half fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-light rounded-pill">
                            <i class="fas fa-eye me-1"></i> Lihat
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cancelled Bookings -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-3 h-100 hover-lift" style="background: linear-gradient(135deg, #e74a3b 0%, #be2617 100%);">
                <div class="card-body text-white position-relative" style="z-index: 1;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-white-50 mb-2">
                                <i class="fas fa-times-circle me-2"></i> Dibatalkan
                            </h6>
                            <h2 class="mb-0">{{ $stats['cancelled'] }}</h2>
                        </div>
                        <div class="bg-white-10 p-3 rounded-circle">
                            <i class="fas fa-ban fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-white-10 text-white">
                            <i class="fas fa-calendar me-1"></i> Sehingga hari ini
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completed Burials -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-3 h-100 hover-lift" style="background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);">
                <div class="card-body text-white position-relative" style="z-index: 1;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-white-50 mb-2">
                                <i class="fas fa-check-circle me-2"></i> Selesai
                            </h6>
                            <h2 class="mb-0">{{ $stats['completed_burials'] }}</h2>
                        </div>
                        <div class="bg-white-10 p-3 rounded-circle">
                            <i class="fas fa-check-double fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-white-10 text-white">
                            <i class="fas fa-calendar me-1"></i> Sehingga hari ini
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grave Availability and Charts -->
    <div class="row mb-4 g-4">
        <!-- Grave Availability -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-3 h-100 hover-lift" style="background: linear-gradient(135deg, #36b9cc 0%, #258391 100%);">
                <div class="card-body text-white position-relative" style="z-index: 1;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-white-50 mb-2">
                                <i class="fas fa-tombstone me-2"></i> Bilangan Pusara
                            </h6>
                            <h2 class="mb-0">{{ $stats['available_graves'] }}</h2>
                        </div>
                        <div class="bg-white-10 p-3 rounded-circle">
                            <i class="fas fa-warehouse fs-4"></i>
                        </div>
                    </div>
                    <div class="progress mt-3 bg-white-20" style="height: 6px;">
                        <div class="progress-bar bg-white" role="progressbar" 
                            style="width: {{ $stats['grave_utilization'] }}%" 
                            aria-valuenow="{{ $stats['grave_utilization'] }}" 
                            aria-valuemin="0" 
                            aria-valuemax="100"></div>
                    </div>
                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ route('admin.create.package') }}" class="btn btn-sm btn-light flex-grow-1">
                            <i class="fas fa-plus me-1"></i> Tambah
                        </a>
                     
                    </div>
                </div>
            </div>
        </div>

    <!-- Charts and Recent Activity Row -->
    <div class="row mb-4 g-4">
        <!-- Bookings Chart -->
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line text-primary me-2"></i> 
                        Trend Tempahan 6 Bulan Terkini
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="bookingsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Distribution -->
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-pie text-primary me-2"></i> 
                        Status Tempahan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-pie">
                        <canvas id="statusPieChart"></canvas>
                    </div>
                    <div class="text-center small mt-3">
                        <span class="me-3">
                            <i class="fas fa-circle text-success me-1"></i> Disahkan
                        </span>
                        <span class="me-3">
                            <i class="fas fa-circle text-warning me-1"></i> Dalam Proses
                        </span>
                        <span>
                            <i class="fas fa-circle text-danger me-1"></i> Dibatalkan
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Bookings and Quick Actions -->
    <div class="row g-4">
        <!-- Recent Bookings -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-history text-primary me-2"></i> 
                            Tempahan Terkini
                        </h5>
                        <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-outline-primary">
                            Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No. Pusara</th>
                                    <th>Nama Si Mati</th>
                                    <th>Tarikh</th>
                                    <th>Status</th>
                                    <th>Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentBookings as $booking)
                                <tr>
                                    <td>
                                        <span class="badge bg-primary bg-opacity-10 text-primary">
                                            {{ $booking->package->pusaraNo ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>{{ $booking->nama_simati }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->eventDate)->format('d/m/Y') }}</td>
                                    <td>
                                        @if($booking->status == 'confirmed')
                                            <span class="badge bg-success bg-opacity-10 text-success">
                                                <i class="fas fa-check-circle me-1"></i> Disahkan
                                            </span>
                                        @elseif($booking->status == 'pending')
                                            <span class="badge bg-warning bg-opacity-10 text-warning">
                                                <i class="fas fa-clock me-1"></i> Dalam Proses
                                            </span>
                                        @else
                                            <span class="badge bg-danger bg-opacity-10 text-danger">
                                                <i class="fas fa-times-circle me-1"></i> Dibatalkan
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.bookings.view', $booking->id) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <i class="fas fa-calendar-times fa-2x text-muted mb-3"></i>
                                        <p class="text-muted">Tiada rekod tempahan terkini</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt text-primary me-2"></i> 
                        Tindakan Pantas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('admin.bookings.index') }}" 
                           class="btn btn-primary btn-lg text-start">
                            <i class="fas fa-calendar-plus me-2"></i> Urus Tempahan
                        </a>
                        
                        <a href="{{ route('admin.create.package') }}" 
                           class="btn btn-success btn-lg text-start">
                            <i class="fas fa-tombstone me-2"></i> Tambah Pusara
                        </a>
                        
                        <a href="{{ route('adminProfile.users.index') }}" 
                           class="btn btn-warning btn-lg text-start">
                            <i class="fas fa-users me-2"></i> Pengurusan Pengguna
                        </a>
                        
                        <button type="button" class="btn btn-info btn-lg text-start" data-bs-toggle="modal" data-bs-target="#reportModal">
                            <i class="fas fa-file-alt me-2"></i> Jana Laporan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Report Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="reportModalLabel">Jana Laporan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.generate.report') }}" method="POST" target="_blank">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="report_type" class="form-label">Jenis Laporan</label>
                        <select class="form-select" id="report_type" name="report_type" required>
                            <option value="">Pilih Jenis Laporan</option>
                            <option value="bookings">Laporan Tempahan</option>
                            <option value="graves">Laporan Pusara</option>
                            <option value="users">Laporan Pengguna</option>
                            <option value="financial">Laporan Kewangan</option>
                        </select>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="start_date" class="form-label">Tarikh Mula</label>
                            <input type="date" class="form-control" id="start_date" name="start_date">
                        </div>
                        <div class="col-md-6">
                            <label for="end_date" class="form-label">Tarikh Akhir</label>
                            <input type="date" class="form-control" id="end_date" name="end_date">
                        </div>
                    </div>
                    
                    <div class="mb-3" id="statusField" style="display:none;">
                        <label for="status" class="form-label">Status Tempahan</label>
                        <select class="form-select" id="status" name="status">
                            <option value="all">Semua Status</option>
                            <option value="confirmed">Disahkan Sahaja</option>
                            <option value="pending">Dalam Proses Sahaja</option>
                            <option value="cancelled">Dibatalkan Sahaja</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Format Laporan</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="format" id="formatPdf" value="pdf" checked>
                            <label class="form-check-label" for="formatPdf">
                                PDF <i class="far fa-file-pdf text-danger"></i>
                            </label>
                        </div>
                    
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-download me-1"></i> Muat Turun
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
    .text-gradient {
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
        width: 50px;
        height: 50px;
        font-size: 1.25rem;
    }
    
    .chart-area {
        position: relative;
        height: 250px;
        width: 100%;
    }
    
    .chart-pie {
        position: relative;
        height: 250px;
        width: 100%;
    }
    
    .bg-opacity-10 {
        background-color: rgba(var(--bs-primary-rgb), 0.1) !important;
    }
    
    .btn-opacity-10 {
        opacity: 0.9;
        transition: opacity 0.2s;
    }
    
    .btn-opacity-10:hover {
        opacity: 1;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(78, 115, 223, 0.05);
    }
    
    .rounded-3 {
        border-radius: 0.75rem !important;
    }

    .alert-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
    margin-bottom: 0.5rem;
    }
</style>
@endsection

@section('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Bookings Chart
    var ctx = document.getElementById('bookingsChart').getContext('2d');
    var bookingsChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($bookingStats['months']) !!},
            datasets: [{
                label: "Tempahan",
                lineTension: 0.3,
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 4,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "#fff",
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "#fff",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: {!! json_encode($bookingStats['counts']) !!},
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: "#fff",
                    bodyColor: "#858796",
                    titleMarginBottom: 10,
                    titleColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    ticks: {
                        beginAtZero: true
                    },
                    grid: {
                        color: "rgba(0, 0, 0, 0.05)",
                    }
                }
            }
        }
    });
    
    // Status Pie Chart
    var pieCtx = document.getElementById('statusPieChart').getContext('2d');
    var statusPieChart = new Chart(pieCtx, {
        type: 'doughnut',
        data: {
            labels: ["Disahkan", "Dalam Proses", "Dibatalkan"],
            datasets: [{
                data: [
                    {{ $statusStats['confirmed'] }},
                    {{ $statusStats['pending'] }},
                    {{ $statusStats['cancelled'] }}
                ],
                backgroundColor: ['#1cc88a', '#f6c23e', '#e74a3b'],
                hoverBackgroundColor: ['#17a673', '#dda20a', '#be2617'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            cutout: '70%',
        }
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle report type changes
    const reportType = document.getElementById('report_type');
    const statusField = document.getElementById('statusField');
    
    reportType.addEventListener('change', function() {
        if (this.value === 'bookings') {
            statusField.style.display = 'block';
        } else {
            statusField.style.display = 'none';
        }
    });
    
    // Set default dates
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');
    
    if (startDate && endDate) {
        const today = new Date().toISOString().split('T')[0];
        const firstDayOfMonth = new Date();
        firstDayOfMonth.setDate(1);
        const firstDayStr = firstDayOfMonth.toISOString().split('T')[0];
        
        startDate.value = firstDayStr;
        endDate.value = today;
    }
});
</script>
@endsection