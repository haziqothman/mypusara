@extends('layouts.public')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Butiran Pusara: {{ $grave->pusaraNo }}</h4>
                <a href="{{ url()->previous() }}" class="btn btn-light btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
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
                            <label class="form-label fw-bold">Kawasan:</label>
                            <p class="form-control-static">
                                @if($grave->section == 'section_A')
                                    Pintu Masuk
                                @elseif($grave->section == 'section_B')
                                    Tandas & Stor
                                @else
                                    Pintu Belakang
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h5 class="text-primary mb-4">
                            <i class="fas fa-users me-2"></i>Senarai Si Mati
                        </h5>
                        
                        @if($grave->bookings->isNotEmpty())
                            <div class="list-group">
                                @foreach($grave->bookings as $booking)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="mb-1">{{ $booking->nama_simati }}</h6>
                                            <small class="text-muted">No KP: {{ $booking->no_mykad_simati }}</small>
                                        </div>
                                        <div class="text-end">
                                            <small class="text-muted">Dikebumikan: {{ $booking->eventDate }}</small>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>Tiada maklumat si mati dijumpai.
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-4">
                        <h5 class="text-primary mb-4">
                            <i class="fas fa-map-marked-alt me-2"></i>Lokasi Pusara
                        </h5>
                        
                        @if($grave->latitude && $grave->longitude)
                            <div id="map" style="height: 300px; border-radius: 8px;"></div>
                            <div class="mt-3">
                                <a href="https://www.google.com/maps?q={{ $grave->latitude }},{{ $grave->longitude }}" 
                                   target="_blank" class="btn btn-outline-primary">
                                    <i class="fas fa-external-link-alt me-1"></i> Buka di Google Maps
                                </a>
                            </div>
                        @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>Koordinat lokasi tidak tersedia.
                            </div>
                        @endif
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
        const map = L.map('map').setView([{{ $grave->latitude }}, {{ $grave->longitude }}], 18);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        const graveMarker = L.marker([{{ $grave->latitude }}, {{ $grave->longitude }}]).addTo(map)
            .bindPopup(`
                <div class="map-popup">
                    <h6 class="mb-1">Pusara No: {{ $grave->pusaraNo }}</h6>
                    <p class="mb-1 small">Kawasan: 
                        @if($grave->section == 'section_A')
                            Pintu Masuk
                        @elseif($grave->section == 'section_B')
                            Tandas & Stor
                        @else
                            Pintu Belakang
                        @endif
                    </p>
                </div>
            `)
            .openPopup();
        
        L.circle([{{ $grave->latitude }}, {{ $grave->longitude }}], {
            color: '#4e73df',
            fillColor: '#4e73df',
            fillOpacity: 0.3,
            radius: 5
        }).addTo(map);
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