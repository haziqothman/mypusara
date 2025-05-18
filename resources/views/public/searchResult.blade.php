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

    .table thead {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        color: white;
    }

    .text-monospace {
        font-family: 'Roboto Mono', monospace;
        font-size: 0.9rem;
        color: #495057;
    }
</style>

<div class="container py-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
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
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No. Pusara</th>
                                    <th>Kawasan</th>
                                    <th>Nama Si Mati</th>
                                    <th>Tarikh Kematian</th>
                                    <th>Koordinat</th>
                                    <th>Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                <tr>
                                    <td>{{ $booking->package->pusaraNo ?? 'N/A' }}</td>
                                    <td>{{ $booking->package->getSectionName() ?? 'N/A' }}</td>
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
                                            data-nama="{{ $booking->nama_simati }}">
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
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&callback=initMap" async defer></script>
<script>
    let map, activeInfoWindow, markers = [];

    function clearMarkers() {
        for (const marker of markers) {
            marker.setMap(null);
        }
        markers = [];
    }

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: 3.1390, lng: 101.6869 }, // Default to Kuala Lumpur
            zoom: 12
        });

        setupViewButtons();
    }

    function setupViewButtons() {
        document.querySelectorAll('.view-map').forEach(button => {
            button.addEventListener('click', function () {
                const lat = parseFloat(this.dataset.lat);
                const lng = parseFloat(this.dataset.lng);
                const pusaraNo = this.dataset.pusara;
                const namaSimati = this.dataset.nama;

                if (!isNaN(lat) && !isNaN(lng)) {
                    clearMarkers();

                    const position = { lat, lng };
                    const marker = new google.maps.Marker({
                        position: position,
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

                    const infoWindow = new google.maps.InfoWindow({
                        content: `
                            <div>
                                <strong>Pusara ${pusaraNo}</strong><br>
                                Nama Si Mati: ${namaSimati}<br>
                                Lat: ${lat.toFixed(6)}<br>
                                Lng: ${lng.toFixed(6)}
                            </div>
                        `
                    });

                    infoWindow.open(map, marker);
                    activeInfoWindow = infoWindow;

                    document.getElementById('coordinate-info').style.display = 'block';
                    document.getElementById('info-pusara').textContent = pusaraNo;
                    document.getElementById('info-nama').textContent = namaSimati;
                    document.getElementById('info-lat').textContent = lat.toFixed(6);
                    document.getElementById('info-lng').textContent = lng.toFixed(6);

                    map.setCenter(position);
                    map.setZoom(18);
                }
            });
        });
    }
</script>
@endpush
@endsection
