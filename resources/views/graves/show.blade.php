@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-lg glass-effect">
                <div class="card-header bg-gradient-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Butiran Pusara</h4>
                        <a href="{{ route('graves.search') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <!-- Grave Information -->
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="text-primary mb-4">
                                    <i class="fas fa-info-circle me-2"></i>Maklumat Pusara
                                </h5>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">No. Pusara:</label>
                                    <p class="form-control-static">{{ $grave->pusaraNo }}</p>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Status:</label>
                                    <p class="form-control-static">
                                        <span class="badge bg-success bg-opacity-10 text-success">
                                            <i class="fas fa-check-circle me-1"></i> Disahkan
                                        </span>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <h5 class="text-primary mb-4">
                                    <i class="fas fa-user-alt me-2"></i>Maklumat Si Mati
                                </h5>
                                
                                @if($grave->bookings->isNotEmpty())
                                    @php $deceased = $grave->bookings->first(); @endphp
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nama Penuh:</label>
                                        <p class="form-control-static">{{ $deceased->nama_simati }}</p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">No. Kad Pengenalan:</label>
                                        <p class="form-control-static">{{ $deceased->no_mykad_simati }}</p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Tarikh Dikebumikan:</label>
                                        <p class="form-control-static">{{ $deceased->eventDate }}</p>
                                    </div>
                                @else
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle me-2"></i>Tiada maklumat si mati dijumpai.
                                    </div>
                                @endif
                            </div>
                            
                            <div>
                                <h5 class="text-primary mb-4">
                                    <i class="fas fa-map-marked-alt me-2"></i>Koordinat Lokasi
                                </h5>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Latitude:</label>
                                    <p class="form-control-static">{{ $grave->latitude ?? 'N/A' }}</p>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Longitude:</label>
                                    <p class="form-control-static">{{ $grave->longitude ?? 'N/A' }}</p>
                                </div>
                                
                                @if($grave->latitude && $grave->longitude)
                                <div class="d-flex gap-2">
                                    <a href="https://www.google.com/maps?q={{ $grave->latitude }},{{ $grave->longitude }}" 
                                       target="_blank" class="btn btn-outline-primary">
                                        <i class="fas fa-external-link-alt me-1"></i> Buka di Google Maps
                                    </a>
                                    <button class="btn btn-primary" id="showMapBtn">
                                        <i class="fas fa-map me-1"></i> Lihat Peta
                                    </button>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Map Section -->
                        <div class="col-md-6">
                            <div id="mapContainer" style="height: 600px; border-radius: 8px; overflow: hidden; display: none;">
                                <div id="graveMap" style="height: 100%; width: 100%;"></div>
                            </div>
                            
                            <div id="mapPlaceholder" style="height: 600px; background-color: #f8f9fa; border-radius: 8px; 
                                display: flex; align-items: center; justify-content: center; flex-direction: column;">
                                <i class="fas fa-map-marked-alt fa-4x text-muted mb-3"></i>
                                <h5 class="text-muted">Pratonton Peta</h5>
                                <p class="text-muted text-center px-4">Klik butang "Lihat Peta" untuk memaparkan lokasi pusara</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($grave->latitude && $grave->longitude)
<!-- Include Leaflet CSS and JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const showMapBtn = document.getElementById('showMapBtn');
    const mapContainer = document.getElementById('mapContainer');
    const mapPlaceholder = document.getElementById('mapPlaceholder');
    
    showMapBtn.addEventListener('click', function() {
        // Hide placeholder and show map
        mapPlaceholder.style.display = 'none';
        mapContainer.style.display = 'block';
        
        // Initialize map
        const map = L.map('graveMap').setView([{{ $grave->latitude }}, {{ $grave->longitude }}], 18);
        
        // Add tile layer (OpenStreetMap)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        // Add marker
        const graveMarker = L.marker([{{ $grave->latitude }}, {{ $grave->longitude }}]).addTo(map)
            .bindPopup(`
                <div class="map-popup">
                    <h6 class="mb-1">Pusara No: {{ $grave->pusaraNo }}</h6>
                    <p class="mb-1 small">Nama: {{ $grave->bookings->first()->nama_simati ?? 'N/A' }}</p>
                    <p class="mb-0 small">Tarikh: {{ $grave->bookings->first()->eventDate ?? 'N/A' }}</p>
                </div>
            `)
            .openPopup();
        
        // Add circle to mark the exact location
        L.circle([{{ $grave->latitude }}, {{ $grave->longitude }}], {
            color: '#4e73df',
            fillColor: '#4e73df',
            fillOpacity: 0.3,
            radius: 5
        }).addTo(map);
    });
});
</script>

<style>
    .map-popup {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }
    .map-popup h6 {
        color: #2d3748;
        font-weight: 600;
    }
    .map-popup p {
        color: #4a5568;
    }
</style>
@endif
@endsection