@extends('layouts.navigation')

@section('content')
<style>
    #map {
        min-height: 500px;
        border-radius: 8px;
        height: 500px;
        width: 100%;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .view-map {
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .view-map:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .coordinate-display {
        font-family: 'Roboto Mono', monospace;
        font-size: 14px;
        line-height: 1.5;
        background: #f8f9fa;
        padding: 10px;
        border-radius: 6px;
        border-left: 4px solid #007bff;
    }

    .coordinate-label {
        display: inline-block;
        width: 40px;
        font-weight: 600;
        color: #495057;
    }

    .map-card {
        border: none;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .map-header {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        border-bottom: none;
    }

    .table-responsive {
        border-radius: 8px;
        overflow: hidden;
    }

    .table thead {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        color: white;
    }

    .table th {
        border: none;
        padding: 12px 15px;
    }

    .table td {
        vertical-align: middle;
        padding: 12px 15px;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }

    .text-monospace {
        font-family: 'Roboto Mono', monospace;
        font-size: 0.9rem;
        color: #495057;
    }

    .toast {
        position: fixed;
        bottom: 20px;
        right: 20px;
        padding: 12px 20px;
        border-radius: 6px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        z-index: 10000;
        transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        opacity: 0;
        transform: translateY(20px);
    }

    .toast.show {
        opacity: 1;
        transform: translateY(0);
    }

    .toast.success {
        background: #28a745;
        color: white;
    }

    .toast.error {
        background: #dc3545;
        color: white;
    }

    .btn-map {
        position: relative;
        overflow: hidden;
    }

    .btn-map::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 5px;
        height: 5px;
        background: rgba(255, 255, 255, 0.5);
        opacity: 0;
        border-radius: 100%;
        transform: scale(1, 1) translate(-50%, -50%);
        transform-origin: 50% 50%;
    }

    .btn-map:focus:not(:active)::after {
        animation: ripple 0.6s ease-out;
    }

    @keyframes ripple {
        0% {
            transform: scale(0, 0);
            opacity: 0.5;
        }
        100% {
            transform: scale(20, 20);
            opacity: 0;
        }
    }
</style>

<div class="container py-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white" style="background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);">
            <h4 class="mb-0"><i class="fas fa-search-location me-2"></i>Hasil Carian Pusara untuk "{{ $searchQuery }}"</h4>
        </div>
        
        <div class="card-body">
            @if($bookings->isEmpty())
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Tiada rekod pusara yang dijumpai untuk carian anda.
                </div>
                <a href="{{ route('landing') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Laman Utama
                </a>
            @else
                <a href="{{ route('landing') }}" class="btn btn-primary mb-3 btn-map">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Laman Utama
                </a>

                <div class="row">
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th><i class="fas fa-hashtag me-1"></i> No. Pusara</th>
                                        <th><i class="fas fa-map-marked-alt me-1"></i> Kawasan</th>
                                        <th><i class="fas fa-user me-1"></i> Nama Si Mati</th>
                                        <th><i class="fas fa-calendar-day me-1"></i> Tarikh Kematian</th>
                                        <th><i class="fas fa-map-pin me-1"></i> Koordinat</th>
                                        <th><i class="fas fa-actions me-1"></i> Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                    <tr>
                                        <td>{{ $booking->package ? $booking->package->pusaraNo : 'N/A' }}</td>
                                        <td>{{ $booking->package ? $booking->package->getSectionName() : 'N/A' }}</td>
                                        <td>{{ $booking->nama_simati }}</td>
                                        <td>{{ $booking->eventDate ? \Carbon\Carbon::parse($booking->eventDate)->format('d/m/Y') : 'N/A' }}</td>
                                        <td>
                                            @if($booking->package && $booking->package->latitude && $booking->package->longitude)
                                                <div class="coordinate-display">
                                                    <span class="coordinate-label">Lat:</span> {{ number_format($booking->package->latitude, 6) }}<br>
                                                    <span class="coordinate-label">Lng:</span> {{ number_format($booking->package->longitude, 6) }}
                                                </div>
                                            @else
                                                <span class="text-muted">Tiada koordinat</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($booking->package && $booking->package->latitude && $booking->package->longitude)
                                            <button class="btn btn-sm btn-info view-map btn-map" 
                                                    data-lat="{{ $booking->package->latitude }}"
                                                    data-lng="{{ $booking->package->longitude }}"
                                                    data-pusara="{{ $booking->package->pusaraNo }}"
                                                    title="Klik untuk lihat lokasi di peta">
                                                <i class="fas fa-map-marker-alt me-1"></i> Peta
                                            </button>
                                            @else
                                            <span class="text-muted">Tiada peta</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            {{ $bookings->links() }}
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="map-card">
                            <div class="card-header map-header text-white">
                                <h5 class="mb-0"><i class="fas fa-map-marked-alt me-2"></i>Lokasi Pusara</h5>
                            </div>
                            <div class="card-body p-0" style="height: 500px;">
                                <div id="map"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<!-- Load Google Maps API -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHT6J5S_wRU6tAuBC9XhNb6xmDJ0Afdh4&callback=initMap" async defer></script>

<script>
    console.log("Custom map script loaded");

    let map;
    let markers = [];
    const defaultLocation = { lat: 3.1390, lng: 101.6869 };
    let currentInfoWindow = null;

    window.initMap = function () {
        console.log("Map initialization started");
        const mapElement = document.getElementById("map");
        if (!mapElement) {
            console.error("Map element not found");
            return;
        }

        map = new google.maps.Map(mapElement, {
            zoom: 15,
            center: defaultLocation,
            mapTypeId: 'hybrid',
            streetViewControl: true,
            fullscreenControl: true,
            styles: [
                {
                    "featureType": "poi",
                    "stylers": [
                        { "visibility": "off" }
                    ]
                },
                {
                    "featureType": "transit",
                    "stylers": [
                        { "visibility": "off" }
                    ]
                }
            ]
        });

        // Center on first valid marker
        @foreach($bookings as $booking)
            @if($booking->package && $booking->package->latitude && $booking->package->longitude)
                addMarker(
                    {{ $booking->package->latitude }},
                    {{ $booking->package->longitude }},
                    '{{ $booking->package->pusaraNo }}',
                    true
                );
                @break
            @endif
        @endforeach
    };

    document.addEventListener('DOMContentLoaded', function () {
        console.log("DOM fully loaded, binding click events");

        document.addEventListener('click', function (e) {
            const button = e.target.closest('.view-map');
            if (button) {
                e.preventDefault();

                const lat = parseFloat(button.dataset.lat);
                const lng = parseFloat(button.dataset.lng);
                const pusaraNo = button.dataset.pusara;

                // Visual feedback
                button.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Memuat...';
                button.disabled = true;
                button.classList.remove('btn-info');
                button.classList.add('btn-warning');

                if (!map) {
                    showMapError("Peta belum siap. Sila tunggu sebentar.");
                    return;
                }

                if (isNaN(lat) || isNaN(lng)) {
                    showMapError("Koordinat tidak sah.");
                    return;
                }

                setTimeout(() => {
                    addMarker(lat, lng, pusaraNo, true);
                    
                    // Reset button after operation
                    setTimeout(() => {
                        button.innerHTML = '<i class="fas fa-map-marker-alt me-1"></i> Peta';
                        button.disabled = false;
                        button.classList.remove('btn-warning');
                        button.classList.add('btn-info');
                    }, 1000);
                }, 300);
            }
        });
    });

    function addMarker(lat, lng, pusaraNo, centerMap = false) {
        clearMarkers();
        if (currentInfoWindow) currentInfoWindow.close();

        const location = { lat, lng };
        const marker = new google.maps.Marker({
            position: location,
            map: map,
            title: `Pusara ${pusaraNo}`,
            icon: {
                url: "https://maps.google.com/mapfiles/ms/icons/red-dot.png",
                scaledSize: new google.maps.Size(40, 40)
            },
            animation: google.maps.Animation.DROP,
            optimized: false // For better performance with few markers
        });

        const infoWindow = new google.maps.InfoWindow({
            content: `
                <div style="min-width: 250px;">
                    <div style="background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); 
                            color: white; padding: 10px 15px; border-radius: 6px 6px 0 0;">
                        <h5 style="margin: 0; font-weight: 600;">
                            <i class="fas fa-map-marker-alt me-1"></i> Pusara ${pusaraNo}
                        </h5>
                    </div>
                    <div style="padding: 15px;">
                        <div class="coordinate-display" style="margin-bottom: 15px;">
                            <span class="coordinate-label">Lat:</span> ${lat.toFixed(6)}<br>
                            <span class="coordinate-label">Lng:</span> ${lng.toFixed(6)}
                        </div>
                        <div style="display: flex; justify-content: space-between; gap: 10px;">
                            <a href="https://www.google.com/maps?q=${lat},${lng}" 
                               target="_blank" 
                               class="btn btn-sm btn-primary btn-map"
                               style="flex: 1;">
                                <i class="fas fa-external-link-alt me-1"></i> Buka Peta
                            </a>
                            <button onclick="copyCoordinates(${lat}, ${lng})" 
                                    class="btn btn-sm btn-secondary btn-map"
                                    style="flex: 1;">
                                <i class="fas fa-copy me-1"></i> Salin
                            </button>
                        </div>
                    </div>
                </div>
            `,
            maxWidth: 300
        });

        infoWindow.open(map, marker);
        currentInfoWindow = infoWindow;
        
        marker.addListener("click", () => {
            infoWindow.open(map, marker);
            currentInfoWindow = infoWindow;
        });

        markers.push(marker);

        if (centerMap) {
            map.setCenter(location);
            map.setZoom(18);
        }

        // Add a circle around the marker (50m radius)
        new google.maps.Circle({
            strokeColor: "#FF0000",
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: "#FF0000",
            fillOpacity: 0.1,
            map: map,
            center: location,
            radius: 50
        });

        // Add a subtle pulse effect to the marker
        setInterval(() => {
            if (marker.getAnimation() === null) {
                marker.setAnimation(google.maps.Animation.BOUNCE);
                setTimeout(() => marker.setAnimation(null), 750);
            }
        }, 4000);
    }

    function clearMarkers() {
        markers.forEach(marker => marker.setMap(null));
        markers = [];
    }

    window.copyCoordinates = function (lat, lng) {
        const text = `Latitude: ${lat.toFixed(6)}\nLongitude: ${lng.toFixed(6)}`;
        navigator.clipboard.writeText(text).then(() => {
            showToast('Koordinat telah disalin ke clipboard', 'success');
        }).catch(err => {
            console.error('Failed to copy: ', err);
            showToast('Gagal menyalin koordinat', 'error');
        });
    };

    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.innerHTML = `
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} me-2"></i>
            ${message}
        `;
        document.body.appendChild(toast);
        
        setTimeout(() => toast.classList.add('show'), 10);
        
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 400);
        }, 3000);
    }

    function showMapError(message) {
        const mapElement = document.getElementById('map');
        if (mapElement) {
            mapElement.innerHTML = `
                <div class="alert alert-danger p-3 m-3">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    ${message}
                </div>
            `;
        }
        showToast(message, 'error');
    }

    setTimeout(() => {
        if (!window.google || !window.google.maps) {
            showMapError("Peta tidak dapat dimuatkan. Sila pastikan sambungan internet anda stabil.");
        }
    }, 5000);
</script>
@endpush
@endsection