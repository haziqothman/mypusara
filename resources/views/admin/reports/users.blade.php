@extends('layouts.public')

@section('content')
<div class="container-fluid py-4">
    <!-- Report Header -->
    <div class="report-header mb-4">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1"><i class="fas fa-users me-2"></i> Laporan Pengguna Sistem</h2>
                    <p class="mb-0 opacity-75">Analisis Pengguna dan Aktiviti</p>
                </div>
                <div class="text-end">
                    <div class="text-white-50 small">Dijana pada: {{ now()->format('d/m/Y H:i') }}</div>
                    <button onclick="window.print()" class="btn btn-sm btn-light mt-2 no-print">
                        <i class="fas fa-print me-1"></i> Cetak Laporan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- User Statistics -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="stat-card bg-white p-3 text-center h-100">
                <div class="text-muted small mb-2"><i class="fas fa-users me-1"></i> Jumlah Pengguna</div>
                <div class="h3 font-weight-bold text-dark">{{ $data['totalUsers'] }}</div>
                <div class="progress mt-2" style="height: 6px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 100%"></div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="stat-card bg-white p-3 text-center h-100">
                <div class="text-muted small mb-2"><i class="fas fa-user-check me-1"></i> Pengguna Aktif</div>
                <div class="h3 font-weight-bold text-success">{{ $data['activeUsers'] }}</div>
                <div class="progress mt-2" style="height: 6px;">
                    <div class="progress-bar bg-success" role="progressbar" 
                         style="width: {{ $data['totalUsers'] > 0 ? round(($data['activeUsers']/$data['totalUsers'])*100) : 0 }}%"></div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="stat-card bg-white p-3 text-center h-100">
                <div class="text-muted small mb-2"><i class="fas fa-user-plus me-1"></i> Pengguna Baru (30 hari)</div>
                <div class="h3 font-weight-bold text-info">{{ $data['newUsers'] }}</div>
                <div class="progress mt-2" style="height: 6px;">
                    <div class="progress-bar bg-info" role="progressbar" 
                         style="width: {{ $data['totalUsers'] > 0 ? round(($data['newUsers']/$data['totalUsers'])*100) : 0 }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- User List -->
    <div class="section-card card mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="m-0"><i class="fas fa-list me-2"></i> Senarai Pengguna</h5>
            <span class="badge bg-primary bg-opacity-10 text-primary">
                {{ count($data['users']) }} Rekod
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th width="20%">Nama</th>
                            <th width="20%">Email</th>
                            <th width="15%">No. Telefon</th>
                            <th width="15%" class="text-center">Tempahan</th>
                            <th width="15%" class="text-center">Tarikh Daftar</th>
                            <th width="15%" class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data['users'] as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone ?? 'N/A' }}</td>
                            <td class="text-center">{{ $user->total_bookings }}</td>
                            <td class="text-center">{{ $user->created_at->format('d/m/Y') }}</td>
                            <td class="text-center">
                                @if($user->email_verified_at)
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success">
                                        <i class="fas fa-check-circle me-1"></i> Aktif
                                    </span>
                                @else
                                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning">
                                        <i class="fas fa-clock me-1"></i> Belum Sah
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="fas fa-user-slash fa-2x mb-3"></i><br>
                                Tiada rekod pengguna ditemui
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer text-muted small d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-info-circle me-1"></i> Sistem Pengurusan Pusara
            </div>
            <div>
                <span class="badge bg-light text-dark">
                    Halaman <span class="font-weight-bold">1</span> daripada <span class="font-weight-bold">1</span>
                </span>
            </div>
        </div>
    </div>

    <!-- User Activity -->
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="section-card card h-100">
                <div class="card-header bg-white">
                    <h5 class="m-0"><i class="fas fa-chart-pie me-2"></i> Taburan Pengguna</h5>
                </div>
                <div class="card-body">
                    <canvas id="userChart" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="section-card card h-100">
                <div class="card-header bg-white">
                    <h5 class="m-0"><i class="fas fa-user-clock me-2"></i> Aktiviti Terkini</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        @foreach($data['users']->sortByDesc('created_at')->take(5) as $user)
                        <div class="timeline-item mb-3">
                            <div class="timeline-badge bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">{{ $user->name }}</h6>
                                <p class="text-muted small mb-0">
                                    <i class="far fa-envelope me-1"></i> {{ $user->email }}
                                </p>
                                <p class="text-muted small mb-0">
                                    <i class="far fa-clock me-1"></i> Daftar {{ $user->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Watermark -->
    <div class="watermark text-muted">
        <i class="fas fa-users"></i>
    </div>
</div>

<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // User Chart
        const ctx = document.getElementById('userChart').getContext('2d');
        const userChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Aktif', 'Belum Sah'],
                datasets: [{
                    data: [{{ $data['activeUsers'] }}, {{ $data['totalUsers'] - $data['activeUsers'] }}],
                    backgroundColor: [
                        'rgba(28, 200, 138, 0.8)',
                        'rgba(108, 117, 125, 0.8)'
                    ],
                    borderColor: [
                        'rgba(28, 200, 138, 1)',
                        'rgba(108, 117, 125, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                },
                cutout: '70%'
            }
        });
    });
</script>
@endsection

<style>
    .report-header {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
        padding: 1.5rem 0;
        margin-bottom: 2rem;
        border-radius: 0.5rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }
    
    .stat-card {
        border-radius: 0.5rem;
        border: none;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
        transition: transform 0.3s ease;
    }
    
    .section-card {
        border-radius: 0.5rem;
        border: none;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }
    
    .table-responsive {
        border-radius: 0.5rem;
        overflow: hidden;
    }
    
    .table thead th {
        background-color: #f8f9fc;
        border-bottom-width: 2px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #858796;
    }
    
    .badge {
        font-weight: 600;
        padding: 0.5em 0.75em;
        border-radius: 0.25rem;
    }
    
    .watermark {
        position: fixed;
        bottom: 20px;
        right: 20px;
        opacity: 0.05;
        font-size: 120px;
        z-index: -1;
        transform: rotate(-15deg);
    }
    
    .timeline {
        position: relative;
        padding-left: 1.5rem;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 6px;
        top: 0;
        bottom: 0;
        width: 2px;
        background-color: #e9ecef;
    }
    
    .timeline-item {
        position: relative;
        padding-bottom: 1rem;
    }
    
    .timeline-badge {
        position: absolute;
        left: -1.5rem;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: #4e73df;
        z-index: 1;
    }
    
    .timeline-content {
        padding-left: 1rem;
    }
    
    @media print {
        body {
            background-color: white !important;
            font-size: 12px;
        }
        
        .report-header, .section-card {
            box-shadow: none !important;
            border: 1px solid #dee2e6 !important;
        }
        
        .no-print {
            display: none !important;
        }
        
        .table {
            font-size: 11px;
        }
    }
</style>