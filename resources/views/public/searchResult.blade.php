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

    #coordinate-info {
        background: #f8f9fa;
        border-top: 1px solid #dee2e6;
        border-radius: 0 0 8px 8px;
    }

    #coordinate-info h6 {
        color: #495057;
        font-weight: 600;
    }

    .text-monospace {
        font-family: 'Roboto Mono', monospace;
        background: #e9ecef;
        padding: 5px 10px;
        border-radius: 4px;
        margin-bottom: 0;
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
                <a href="{{ route('landing') }}" class="btn btn-primary mb-3">
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
                                            <button class="btn btn-sm btn-info view-map" 
                                                    data-lat="{{ $booking->package->latitude }}"
                                                    data-lng="{{ $booking->package->longitude }}"
                                                    data-pusara="{{ $booking->package->pusaraNo }}"
                                                    data-nama="{{ $booking->nama_simati }}"
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
                            <div class="card-body p-0">
                                <div id="map"></div>
                                <div id="coordinate-info" class="p-3 bg-light border-top" style="display: none;">
                                    <h6 class="mb-3"><i class="fas fa-info-circle me-2"></i>Maklumat Pusara</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong>No. Pusara:</strong></p>
                                            <p id="info-pusara" class="text-monospace">-</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong>Nama Si Mati:</strong></p>
                                            <p id="info-nama" class="text-monospace">-</p>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong>Latitude:</strong></p>
                                            <p id="info-lat" class="text-monospace">-</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong>Longitude:</strong></p>
                                            <p id="info-lng" class="text-monospace">-</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHT6J5S_wRU6tAuBC9XhNb6xmDJ0Afdh4&callback=initMap" async defer></script>
<script>
    // Global variables
    let map;
    let activeInfoWindow = null;
    let markers = [];
    
    // Initialize the map
    function initMap() {
        // Create the map centered on Kuala Lumpur
        map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: 3.1390, lng: 101.6869 },
            zoom: 15,
            mapTypeId: 'hybrid',
            streetViewControl: true,
            fullscreenControl: true,
            styles: [
                { "featureType": "poi", "stylers": [{ "visibility": "off" }] },
                { "featureType": "transit", "stylers": [{ "visibility": "off" }] }
            ]
        });

        // Initialize markers from database
        initMarkers();

        // Set up click event listeners for view buttons
        setupViewButtons();
    }

    // Initialize markers from database
    function initMarkers() {
        // Clear existing markers
        clearMarkers();

        // Get markers from server data
        const initialMarkers = [
            @foreach($bookings as $booking)
                @if($booking->package && $booking->package->latitude && $booking->package->longitude)
                {
                    position: {
                        lat: {{ $booking->package->latitude }},
                        lng: {{ $booking->package->longitude }}
                    },
                    label: {
                        text: '{{ $booking->package->pusaraNo }}',
                        color: 'white'
                    },
                    draggable: false,
                    nama_simati: '{{ addslashes($booking->nama_simati) }}',
                    pusaraNo: '{{ $booking->package->pusaraNo }}'
                },
                @endif
            @endforeach
        ];

        // Create markers
        for (let index = 0; index < initialMarkers.length; index++) {
            const markerData = initialMarkers[index];
            const marker = new google.maps.Marker({
                position: markerData.position,
                label: markerData.label,
                draggable: markerData.draggable,
                map: map,
                icon: {
                    url: "https://maps.google.com/mapfiles/ms/icons/red-dot.png",
                    scaledSize: new google.maps.Size(40, 40)
                }
            });
            markers.push(marker);

            // Create info window content
            const infowindow = new google.maps.InfoWindow({
                content: `
                    <div style="min-width: 200px;">
                        <div style="background: #007bff; color: white; padding: 8px 12px; border-radius: 5px 5px 0 0;">
                            <strong>Pusara ${markerData.pusaraNo}</strong>
                        </div>
                        <div style="padding: 10px;">
                            <p><strong>Nama Si Mati:</strong> ${markerData.nama_simati}</p>
                            <p><strong>Koordinat:</strong><br>
                            Lat: ${markerData.position.lat.toFixed(6)}<br>
                            Lng: ${markerData.position.lng.toFixed(6)}</p>
                        </div>
                    </div>
                `
            });

            // Add click listener to marker
            marker.addListener("click", () => {
                if(activeInfoWindow) {
                    activeInfoWindow.close();
                }
                infowindow.open({
                    anchor: marker,
                    shouldFocus: false,
                    map: map
                });
                activeInfoWindow = infowindow;
                
                // Update the coordinate info box
                updateCoordinateInfo(
                    markerData.pusaraNo,
                    markerData.nama_simati,
                    markerData.position.lat,
                    markerData.position.lng
                );
            });
        }

        // Center on first marker if available
        if (initialMarkers.length > 0) {
            map.setCenter(initialMarkers[0].position);
            map.setZoom(18);
            
            // Show info for first marker
            updateCoordinateInfo(
                initialMarkers[0].pusaraNo,
                initialMarkers[0].nama_simati,
                initialMarkers[0].position.lat,
                initialMarkers[0].position.lng
            );
        }
    }

    // Set up click event listeners for view buttons
    function setupViewButtons() {
        document.querySelectorAll('.view-map').forEach(button => {
            button.addEventListener('click', function() {
                const lat = parseFloat(this.dataset.lat);
                const lng = parseFloat(this.dataset.lng);
                const pusaraNo = this.dataset.pusara;
                const namaSimati = this.dataset.nama || 'N/A';

                if (!isNaN(lat) && !isNaN(lng)) {
                    // Clear existing markers
                    clearMarkers();

                    // Create new marker for the selected grave
                    const marker = new google.maps.Marker({
                        position: { lat, lng },
                        map: map,
                        label: {
                            text: pusaraNo,
                            color: 'white'
                        },
                        icon: {
                            url: "https://maps.google.com/mapfiles/ms/icons/red-dot.png",
                            scaledSize: new google.maps.Size(40, 40)
                        }
                    });
                    markers.push(marker);

                    // Update the coordinate info box
                    updateCoordinateInfo(pusaraNo, namaSimati, lat, lng);

                    // Create info window
                    const infowindow = new google.maps.InfoWindow({
                        content: `
                            <div style="min-width: 200px;">
                                <div style="background: #007bff; color: white; padding: 8px 12px; border-radius: 5px 5px 0 0;">
                                    <strong>Pusara ${pusaraNo}</strong>
                                </div>
                                <div style="padding: 10px;">
                                    <p><strong>Nama Si Mati:</strong> ${namaSimati}</p>
                                    <p><strong>Koordinat:</strong><br>
                                    Lat: ${lat.toFixed(6)}<br>
                                    Lng: ${lng.toFixed(6)}</p>
                                </div>
                            </div>
                        `
                    });

                    // Show info window
                    if(activeInfoWindow) {
                        activeInfoWindow.close();
                    }
                    infowindow.open({
                        anchor: marker,
                        shouldFocus: false,
                        map: map
                    });
                    activeInfoWindow = infowindow;

                    // Center map on this marker
                    map.setCenter({ lat, lng });
                    map.setZoom(18);
                }
            });
        });
    }

    // Update coordinate information display
    function updateCoordinateInfo(pusaraNo, namaSimati, lat, lng) {
        const coordInfo = document.getElementById('coordinate-info');
        coordInfo.style.display = 'block';
        document.getElementById('info-pusara').textContent = pusaraNo;
        document.getElementById('info-nama').textContent = namaSimati;
        document.getElementById('info-lat').textContent = lat.toFixed(6);
        document.getElementById('info-lng').textContent = lng.toFixed(6);
    }

    // Clear all markers from the map
    function clearMarkers() {
        markers.forEach(marker => marker.setMap(null));
        markers = [];
    }

    // Ensure the map is initialized when Google Maps API is loaded
    window.initMap = initMap;
</script>
@endpush
@endsection