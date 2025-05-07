@extends('layouts.navigation')

@section('content')
<style>
    #map {
        min-height: 500px;
        border-radius: 4px;
        height: 500px;
        width: 100%;
    }

    .view-map {
        cursor: pointer;
    }

    .leaflet-popup-content {
        font-size: 14px;
    }
</style>

<div class="container py-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Hasil Carian Pusara untuk "{{ $searchQuery }}"</h4>
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
                <a href="{{ route('landing') }}" class="btn btn-primary mb-3">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Laman Utama
                </a>

                <div class="row">
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>No. Pusara</th>
                                        <th>Kawasan</th>
                                        <th>Nama Si Mati</th>
                                        <th>Tarikh Kematian</th>
                                        <th>Tindakan</th>
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
                                            <button class="btn btn-sm btn-info view-map" 
                                                    data-lat="{{ $booking->package->latitude }}"
                                                    data-lng="{{ $booking->package->longitude }}"
                                                    data-pusara="{{ $booking->package->pusaraNo }}">
                                                <i class="fas fa-map-marker-alt"></i> Peta
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
                        <div class="card">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="mb-0">Lokasi Pusara</h5>
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAY3KxvzDDH7yQl1FHhGOU6NRgOl4XdchY&callback=initMap" async defer></script>

<script>
    console.log("Custom map script loaded");

    let map;
    let markers = [];
    const defaultLocation = { lat: 3.1390, lng: 101.6869 };
    let currentInfoWindow = null; // Track the currently open info window

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
            fullscreenControl: true
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

                // Show coordinates immediately in the button for feedback
                button.innerHTML = `<i class="fas fa-map-marker-alt"></i> ${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                button.classList.add('btn-success');
                button.classList.remove('btn-info');

                if (!map) {
                    showMapError("Peta belum siap. Sila tunggu sebentar.");
                    return;
                }

                if (isNaN(lat) || isNaN(lng)) {
                    showMapError("Koordinat tidak sah.");
                    return;
                }

                addMarker(lat, lng, pusaraNo, true);
                
                // Reset button after 3 seconds
                setTimeout(() => {
                    button.innerHTML = '<i class="fas fa-map-marker-alt"></i> Peta';
                    button.classList.add('btn-info');
                    button.classList.remove('btn-success');
                }, 3000);
            }
        });
    });

    function addMarker(lat, lng, pusaraNo, centerMap = false) {
        clearMarkers();
        
        // Close any existing info window
        if (currentInfoWindow) {
            currentInfoWindow.close();
        }

        const location = { lat, lng };
        const marker = new google.maps.Marker({
            position: location,
            map: map,
            title: `Pusara ${pusaraNo}`,
            icon: {
                url: "https://maps.google.com/mapfiles/ms/icons/red-dot.png",
                scaledSize: new google.maps.Size(40, 40)
            },
            animation: google.maps.Animation.DROP
        });

        // Create coordinate display with better formatting
        const coordinateDisplay = `
            <div class="coordinate-display">
                <span class="coordinate-label">Lat:</span> ${lat.toFixed(6)}<br>
                <span class="coordinate-label">Lng:</span> ${lng.toFixed(6)}
            </div>
        `;

        const infoWindow = new google.maps.InfoWindow({
            content: `
                <div style="min-width: 220px; padding: 10px;">
                    <h5 style="color: #d9534f; margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 5px;">
                        Pusara ${pusaraNo}
                    </h5>
                    <div style="margin-bottom: 15px; font-family: monospace; background: #f8f9fa; padding: 8px; border-radius: 4px;">
                        ${coordinateDisplay}
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <a href="https://www.google.com/maps?q=${lat},${lng}" 
                           target="_blank" 
                           class="btn btn-sm btn-primary"
                           style="padding: 5px 10px;">
                            <i class="fas fa-external-link-alt"></i> Buka
                        </a>
                        <button onclick="copyCoordinates(${lat}, ${lng})" 
                                class="btn btn-sm btn-secondary"
                                style="padding: 5px 10px;">
                            <i class="fas fa-copy"></i> Salin
                        </button>
                    </div>
                </div>
            `
        });

        // Open the info window and track it
        infoWindow.open(map, marker);
        currentInfoWindow = infoWindow;
        
        // Reopen when marker is clicked
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
    }

    function clearMarkers() {
        markers.forEach(marker => marker.setMap(null));
        markers = [];
    }

    window.copyCoordinates = function (lat, lng) {
        const text = `Latitude: ${lat}\nLongitude: ${lng}`;
        navigator.clipboard.writeText(text).then(() => {
            // Show a nice toast notification instead of alert
            showToast('Koordinat telah disalin ke clipboard');
        }).catch(err => {
            console.error('Failed to copy: ', err);
            showToast('Gagal menyalin koordinat', 'error');
        });
    };

    function showToast(message, type = 'success') {
        // Create toast element
        const toast = document.createElement('div');
        toast.style.position = 'fixed';
        toast.style.bottom = '20px';
        toast.style.right = '20px';
        toast.style.padding = '10px 20px';
        toast.style.background = type === 'success' ? '#28a745' : '#dc3545';
        toast.style.color = 'white';
        toast.style.borderRadius = '4px';
        toast.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
        toast.style.zIndex = '10000';
        toast.style.transition = 'all 0.3s ease';
        toast.textContent = message;
        
        document.body.appendChild(toast);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    function showMapError(message) {
        const mapElement = document.getElementById('map');
        if (mapElement) {
            mapElement.innerHTML = `
                <div class="alert alert-danger p-3">
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

<style>
    .coordinate-display {
        font-family: 'Courier New', monospace;
        font-size: 14px;
        line-height: 1.5;
    }
    .coordinate-label {
        display: inline-block;
        width: 40px;
        font-weight: bold;
        color: #333;
    }
</style>
@endpush
@endsection
