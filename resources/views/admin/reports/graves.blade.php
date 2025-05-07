<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Laporan Status Pusara</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4e73df;
            --secondary: #858796;
            --success: #1cc88a;
            --warning: #f6c23e;
            --danger: #e74a3b;
            --light: #f8f9fc;
            --dark: #5a5c69;
        }
        
        body {
            background-color: #f8f9fc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .report-header {
            background: linear-gradient(135deg, var(--primary) 0%, #224abe 100%);
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
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .section-card {
            border-radius: 0.5rem;
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }
        
        .section-card .card-header {
            font-weight: 600;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        
        .table-responsive {
            border-radius: 0.5rem;
            overflow: hidden;
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table thead th {
            background-color: var(--light);
            border-bottom-width: 2px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            color: var(--secondary);
        }
        
        .table tbody tr {
            transition: background-color 0.2s ease;
        }
        
        .table tbody tr:hover {
            background-color: rgba(78, 115, 223, 0.05);
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
</head>
<body>
    <div class="container py-4">
        <!-- Report Header -->
        <div class="report-header">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-1"><i class="fas fa-archway me-2"></i> Laporan Status Pusara</h2>
                        <p class="mb-0 opacity-75">Sistem Pengurusan Tanah Perkuburan</p>
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

        <!-- Summary Statistics -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="stat-card bg-white p-3 text-center h-100">
                    <div class="text-muted small mb-2"><i class="fas fa-archway me-1"></i> Jumlah Pusara</div>
                    <div class="h3 font-weight-bold text-dark">{{ $data['totalGraves'] }}</div>
                    <div class="progress mt-2" style="height: 6px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 100%"></div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-3">
                <div class="stat-card bg-white p-3 text-center h-100">
                    <div class="text-muted small mb-2"><i class="fas fa-check-circle me-1"></i> Tersedia</div>
                    <div class="h3 font-weight-bold text-success">{{ $data['availableGraves'] }}</div>
                    <div class="progress mt-2" style="height: 6px;">
                        <div class="progress-bar bg-success" role="progressbar" 
                             style="width: {{ $data['totalGraves'] > 0 ? round(($data['availableGraves']/$data['totalGraves'])*100) : 0 }}%"></div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-3">
                <div class="stat-card bg-white p-3 text-center h-100">
                    <div class="text-muted small mb-2"><i class="fas fa-tools me-1"></i> Dalam Penyelenggaraan</div>
                    <div class="h3 font-weight-bold text-warning">{{ $data['maintenanceGraves'] }}</div>
                    <div class="progress mt-2" style="height: 6px;">
                        <div class="progress-bar bg-warning" role="progressbar" 
                             style="width: {{ $data['totalGraves'] > 0 ? round(($data['maintenanceGraves']/$data['totalGraves'])*100) : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section-wise Reports -->
        @foreach(['section_A' => 'Pintu Masuk', 'section_B' => 'Tandas & Stor', 'section_C' => 'Pintu Belakang'] as $section => $name)
        <div class="section-card card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="m-0"><i class="fas fa-map-marker-alt me-2"></i> Kawasan {{ $name }}</h5>
                <span class="badge bg-primary bg-opacity-10 text-primary">
                    {{ count($data['sectionStats'][$section]) }} Pusara
                </span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr class="text-center">
                                <th width="15%">No. Pusara</th>
                                <th width="20%">Status</th>
                                <th width="15%">Tempahan</th>
                                <th width="50%">Koordinat GPS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data['sectionStats'][$section] as $grave)
                            <tr>
                                <td class="text-center font-weight-bold">{{ $grave->pusaraNo }}</td>
                                <td class="text-center">
                                    @if($grave->status == 'tersedia')
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success">
                                            <i class="fas fa-check-circle me-1"></i> Tersedia
                                        </span>
                                    @elseif($grave->status == 'dalam_penyelanggaraan')
                                        <span class="badge bg-warning bg-opacity-10 text-warning border border-warning">
                                            <i class="fas fa-tools me-1"></i> Penyelenggaraan
                                        </span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary">
                                            <i class="fas fa-times-circle me-1"></i> Tidak Tersedia
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $grave->total_bookings }}</td>
                                <td>
                                    @if($grave->latitude && $grave->longitude)
                                        <a href="https://www.google.com/maps?q={{ $grave->latitude }},{{ $grave->longitude }}" 
                                           target="_blank" class="text-primary">
                                            <i class="fas fa-map-marked-alt me-1"></i> 
                                            {{ $grave->latitude }}, {{ $grave->longitude }}
                                        </a>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    <i class="fas fa-archway fa-2x mb-3"></i><br>
                                    Tiada pusara dalam kawasan ini
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-muted small">
                <i class="fas fa-info-circle me-1"></i> Dikemaskini: {{ now()->format('d/m/Y H:i') }}
            </div>
        </div>
        @endforeach

        <!-- Watermark -->
        <div class="watermark text-muted">
            <i class="fas fa-archway"></i>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>