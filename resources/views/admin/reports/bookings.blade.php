<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Tempahan Pusara</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #f8f9fc;
            --accent-color: #2e59d9;
            --success-color: #1cc88a;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
        }
        
        body {
            background-color: #f8f9fc;
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, sans-serif;
        }
        
        .report-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 15px 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        
        .stat-card {
            border-radius: 10px;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1.5rem 0 rgba(58, 59, 69, 0.2);
        }
        
        .report-card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            margin-bottom: 2rem;
        }
        
        .report-card .card-header {
            border-radius: 15px 15px 0 0 !important;
            background-color: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .badge {
            padding: 0.5em 0.75em;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }
        
        .table thead th {
            background-color: var(--secondary-color);
            border-bottom-width: 1px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }
        
        .table tbody tr {
            transition: all 0.2s ease;
        }
        
        .table tbody tr:hover {
            background-color: rgba(78, 115, 223, 0.05);
        }
        
        .watermark {
            position: fixed;
            bottom: 20px;
            right: 20px;
            opacity: 0.1;
            font-size: 100px;
            z-index: -1;
            transform: rotate(-15deg);
        }
        
        @media print {
            .no-print {
                display: none !important;
            }
            
            body {
                background-color: white !important;
            }
            
            .report-header, .report-card {
                box-shadow: none !important;
            }
            
            .table {
                width: 100% !important;
            }
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <div class="report-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-1"><i class="fas fa-file-alt me-2"></i> Laporan Tempahan Pusara</h1>
                    <p class="mb-0 opacity-75">Sistem Pengurusan Pusara - {{ config('app.name') }}</p>
                </div>
                <div class="col-md-4 text-md-end">
                    @if($startDate)
                        <div class="bg-white text-dark d-inline-block px-3 py-2 rounded-pill">
                            <i class="fas fa-calendar me-1 text-primary"></i>
                            {{ $startDate->format('d/m/Y') }} - {{ $endDate->format('d/m/Y') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="stat-card bg-white p-4 text-center">
                    <div class="text-muted small mb-2"><i class="fas fa-calendar-check me-1"></i> Jumlah Tempahan</div>
                    <div class="h2 font-weight-bold text-dark">{{ $data['total'] }}</div>
                    <div class="mt-2">
                        <span class="badge bg-primary bg-opacity-10 text-primary small">
                            <i class="fas fa-clock me-1"></i> Sehingga hari ini
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="stat-card bg-white p-4 text-center">
                    <div class="text-muted small mb-2"><i class="fas fa-check-circle me-1"></i> Disahkan</div>
                    <div class="h2 font-weight-bold text-success">{{ $data['confirmed'] }}</div>
                    <div class="progress mt-3" style="height: 6px;">
                        <div class="progress-bar bg-success" role="progressbar" 
                             style="width: {{ $data['total'] > 0 ? round(($data['confirmed']/$data['total'])*100) : 0 }}%" 
                             aria-valuenow="{{ $data['confirmed'] }}" 
                             aria-valuemin="0" 
                             aria-valuemax="{{ $data['total'] }}"></div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="stat-card bg-white p-4 text-center">
                    <div class="text-muted small mb-2"><i class="fas fa-clock me-1"></i> Dalam Proses</div>
                    <div class="h2 font-weight-bold text-warning">{{ $data['pending'] }}</div>
                    <div class="progress mt-3" style="height: 6px;">
                        <div class="progress-bar bg-warning" role="progressbar" 
                             style="width: {{ $data['total'] > 0 ? round(($data['pending']/$data['total'])*100) : 0 }}%" 
                             aria-valuenow="{{ $data['pending'] }}" 
                             aria-valuemin="0" 
                             aria-valuemax="{{ $data['total'] }}"></div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="stat-card bg-white p-4 text-center">
                    <div class="text-muted small mb-2"><i class="fas fa-times-circle me-1"></i> Dibatalkan</div>
                    <div class="h2 font-weight-bold text-danger">{{ $data['cancelled'] }}</div>
                    <div class="progress mt-3" style="height: 6px;">
                        <div class="progress-bar bg-danger" role="progressbar" 
                             style="width: {{ $data['total'] > 0 ? round(($data['cancelled']/$data['total'])*100) : 0 }}%" 
                             aria-valuenow="{{ $data['cancelled'] }}" 
                             aria-valuemin="0" 
                             aria-valuemax="{{ $data['total'] }}"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bookings Table -->
        <div class="report-card card">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h5 class="m-0 font-weight-bold text-primary"><i class="fas fa-list me-2"></i> Senarai Tempahan</h5>
                <div class="no-print">
                    <button onclick="window.print()" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-print me-1"></i> Cetak
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>ID</th>
                                <th>No. Pusara</th>
                                <th>Kawasan</th>
                                <th>Nama Si Mati</th>
                                <th>Waris</th>
                                <th>Tarikh Pengebumian</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data['bookings'] as $booking)
                            <tr>
                                <td class="font-weight-bold">#{{ $booking->id }}</td>
                                <td>
                                    <span class="badge bg-primary bg-opacity-10 text-primary">
                                        {{ $booking->package->pusaraNo ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>{{ $booking->sectionName }}</td>
                                <td>{{ $booking->nama_simati }}</td>
                                <td>{{ $booking->customerName }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->eventDate)->format('d/m/Y') }}</td>
                                <td>
                                    @if($booking->status == 'confirmed')
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success">
                                            <i class="fas fa-check-circle me-1"></i> Disahkan
                                        </span>
                                    @elseif($booking->status == 'pending')
                                        <span class="badge bg-warning bg-opacity-10 text-warning border border-warning">
                                            <i class="fas fa-clock me-1"></i> Dalam Proses
                                        </span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger">
                                            <i class="fas fa-times-circle me-1"></i> Dibatalkan
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-calendar-times fa-2x text-muted mb-3"></i>
                                    <p class="text-muted">Tiada rekod tempahan ditemui</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-muted small d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-info-circle me-1"></i> Dijana pada: {{ now()->format('d/m/Y H:i') }}
                </div>
                <div class="no-print">
                    <span class="badge bg-light text-dark">
                        <i class="fas fa-database me-1"></i> {{ $data['total'] }} rekod
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Summary Section -->
        <div class="row mt-4 no-print">
            <div class="col-md-6 mb-3">
                <div class="report-card card h-100">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary"><i class="fas fa-chart-pie me-2"></i> Taburan Status</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="statusChart" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="report-card card h-100">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary"><i class="fas fa-calendar-alt me-2"></i> Aktiviti Terkini</h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            @foreach($data['bookings']->take(5) as $activity)
                            <div class="timeline-item mb-3">
                                <div class="timeline-badge 
                                    @if($activity->status == 'confirmed') bg-success
                                    @elseif($activity->status == 'pending') bg-warning
                                    @else bg-danger @endif">
                                </div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">{{ $activity->nama_simati }}</h6>
                                    <p class="text-muted small mb-0">
                                        <i class="far fa-clock me-1"></i> 
                                        {{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Watermark -->
    <div class="watermark text-muted">
        <i class="fas fa-file-alt"></i>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Status Chart
            const ctx = document.getElementById('statusChart').getContext('2d');
            const statusChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Disahkan', 'Dalam Proses', 'Dibatalkan'],
                    datasets: [{
                        data: [
                            {{ $data['confirmed'] }}, 
                            {{ $data['pending'] }}, 
                            {{ $data['cancelled'] }}
                        ],
                        backgroundColor: [
                            'rgba(28, 200, 138, 0.8)',
                            'rgba(246, 194, 62, 0.8)',
                            'rgba(231, 74, 59, 0.8)'
                        ],
                        borderColor: [
                            'rgba(28, 200, 138, 1)',
                            'rgba(246, 194, 62, 1)',
                            'rgba(231, 74, 59, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    },
                    cutout: '70%'
                }
            });
            
            // Print button functionality
            document.querySelector('.print-btn').addEventListener('click', function() {
                window.print();
            });
        });
    </script>
    <style>
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
    </style>
</body>
</html>