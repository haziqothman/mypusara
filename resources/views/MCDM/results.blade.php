<!-- resources/views/MCDM/results.blade.php -->
@extends('layouts.navigation')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card shadow-lg mb-5">
                <div class="card-header bg-success text-white">
                    <h3 class="mb-0">Keputusan Cadangan Pusara</h3>
                    <p class="mb-0">Berdasarkan kriteria lokasi dan persekitaran</p>
                </div>
                
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Sistem telah menemui <strong>{{ $packages->count() }}</strong> pusara yang sesuai dengan keperluan anda.
                    </div>
                    
                    <!-- Criteria Summary -->
                    <div class="mb-4 p-3 bg-light rounded">
                        <h5 class="mb-3">Kriteria Pilihan Anda:</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Kedekatan:</strong> 
                                    {{ $criteria['proximity'] === 'very_important' ? 'Sangat Penting (<5km)' : 
                                      ($criteria['proximity'] === 'important' ? 'Penting (<10km)' : 'Tidak Penting') }}
                                </p>
                                <p><strong>Aksesibiliti:</strong> 
                                    {{ ucfirst($criteria['accessibility']) }}
                                </p>
                                <p><strong>Laluan:</strong> 
                                    {{ $criteria['pathway_condition'] === 'wide_paved' ? 'Laluan Luas Berturap' : 
                                      ($criteria['pathway_condition'] === 'narrow_paved' ? 'Laluan Sempit Berturap' : 'Laluan Tanah') }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Keadaan Tanah:</strong> 
                                    {{ ucfirst($criteria['soil_condition']) }}
                                </p>
                                <p><strong>Saliran:</strong> 
                                    {{ ucfirst($criteria['drainage']) }}
                                </p>
                                <p><strong>Teduhan:</strong> 
                                    {{ $criteria['shade'] === 'full_shade' ? 'Teduhan Penuh' : 
                                      ($criteria['shade'] === 'partial_shade' ? 'Teduhan Separuh' : 'Tiada Teduhan') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            @if($packages->isEmpty())
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Tiada pusara ditemui yang memenuhi kriteria anda. Sila cuba kriteria yang lebih fleksibel.
                </div>
            @else
                <!-- Existing results loop -->
            @endif
           <!-- Results List -->
<div class="card shadow-sm">
    <div class="card-header bg-light">
        <h5 class="mb-0">Senarai Pusara Disyorkan</h5>
    </div>
    
    <div class="card-body">
        @foreach($packages as $index => $result)
        <div class="package-card mb-4 p-3 border rounded {{ $index === 0 ? 'border-success border-2' : '' }}">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h4 class="mb-1">
                        {{ $result['package']->pusaraNo }}
                        @if($index === 0)
                        <span class="badge bg-success ms-2">
                            <i class="fas fa-trophy me-1"></i> Pilihan Terbaik
                        </span>
                        @endif
                    </h4>
                    <p class="text-muted mb-2">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        {{ $result['package']->section === 'section_A' ? 'Pintu Masuk' : 
                          ($result['package']->section === 'section_B' ? 'Tandas & Stor' : 'Pintu Belakang') }}
                    </p>
                </div>
                <div class="text-end">
                    <div class="rating">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= round($result['score'] * 5))
                                <i class="fas fa-star text-warning"></i>
                            @else
                                <i class="far fa-star text-warning"></i>
                            @endif
                        @endfor
                        <small class="ms-1">({{ number_format($result['score'] * 100, 1) }}% sesuai)</small>
                    </div>
                </div>
            </div>
            
            <hr class="my-2">
            
            <!-- Location & Accessibility -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <h6 class="text-primary mb-2">
                        <i class="fas fa-map-marker-alt me-2"></i> Lokasi & Akses
                    </h6>
                    <p class="mb-1"><strong>Kedekatan:</strong> {{ $result['package']->proximity_text }} ({{ number_format($result['proximity_score'] * 100, 0) }}%)</p>
                    <p class="mb-1"><strong>Aksesibiliti:</strong> {{ $result['package']->accessibility_text }} ({{ number_format($result['accessibility_score'] * 100, 0) }}%)</p>
                    <p class="mb-1"><strong>Laluan:</strong> {{ $result['package']->pathway_text }} ({{ number_format($result['pathway_score'] * 100, 0) }}%)</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-primary mb-2">
                        <i class="fas fa-tree me-2"></i> Persekitaran
                    </h6>
                    <p class="mb-1"><strong>Tanah:</strong> {{ $result['package']->soil_text }} ({{ number_format($result['soil_score'] * 100, 0) }}%)</p>
                    <p class="mb-1"><strong>Saliran:</strong> {{ $result['package']->drainage_text }} ({{ number_format($result['drainage_score'] * 100, 0) }}%)</p>
                    <p class="mb-1"><strong>Teduhan:</strong> {{ $result['package']->shade_text }} ({{ number_format($result['shade_score'] * 100, 0) }}%)</p>
                </div>
            </div>
            
            <div class="d-flex justify-content-between mt-3">
                <a href="{{ route('customer.create.booking', $result['package']->id) }}" 
                class="btn btn-sm btn-success">
                    <i class="fas fa-calendar-check me-1"></i> Tempah Sekarang
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
        </div>
    </div>
</div>

<style>
    .package-card {
        transition: all 0.3s ease;
    }
    
    .package-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .rating {
        font-size: 0.9rem;
    }
    
    .card-header {
        border-bottom: none;
    }
</style>
@endsection