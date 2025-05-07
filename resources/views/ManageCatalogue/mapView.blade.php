@extends('layouts.navigation')

@section('content')
<div class="container-fluid p-0">
    <div id="map" style="height: 80vh;"></div>
</div>
@endsection

@section('scripts')
<script>
    function initMap() {
        // Set default center (Kuala Lumpur coordinates)
        const defaultCenter = { lat: 3.1390, lng: 101.6869 };
        
        // Create the map
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 15,
            center: defaultCenter,
        });
        
        // Add markers for each package
        @foreach($packages as $package)
            @if($package->latitude && $package->longitude)
                // Create marker
                const marker{{ $package->id }} = new google.maps.Marker({
                    position: { 
                        lat: {{ $package->latitude }}, 
                        lng: {{ $package->longitude }} 
                    },
                    map,
                    title: "Pusara {{ $package->pusaraNo }}",
                });
                
                // Add info window
                const infoWindow{{ $package->id }} = new google.maps.InfoWindow({
                    content: `
                        <div style="min-width: 200px">
                            <h6 style="color: #2d3748; font-weight: bold; margin-bottom: 5px">
                                <i class="fas fa-monument"></i> Pusara {{ $package->pusaraNo }}
                            </h6>
                            <p style="margin: 5px 0">
                                <i class="fas fa-map-marker-alt"></i> 
                                {{ str_replace('_', ' ', $package->section) }}
                            </p>
                            <p style="margin: 5px 0">
                                Status: 
                                <span class="badge bg-{{ 
                                    $package->status == 'tersedia' ? 'success' : 
                                    ($package->status == 'tidak_tersedia' ? 'danger' : 'warning') 
                                }}">
                                    {{ ucfirst(str_replace('_', ' ', $package->status)) }}
                                </span>
                            </p>
                            <a href="{{ url('admin/package/' . $package->id . '/edit') }}" 
                               class="btn btn-sm btn-primary mt-2">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                    `
                });
                
                // Add click event to show info window
                marker{{ $package->id }}.addListener("click", () => {
                    infoWindow{{ $package->id }}.open(map, marker{{ $package->id }});
                });
            @endif
        @endforeach
    }
</script>

<!-- Load Google Maps API with your key -->
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap&libraries=places" async defer></script>

<!-- Optional: Load Marker Clusterer for many markers -->
<script src="https://unpkg.com/@googlemaps/markerclusterer/dist/index.min.js"></script>
@endsection