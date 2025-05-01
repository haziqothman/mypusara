<div class="tooltip-content">
    <h6 class="mb-2">Pusara {{ $grave->pusaraNo }}</h6>
    <p class="mb-1"><i class="fas fa-map-marker-alt me-1"></i> 
        {{ $grave->section == 'section_A' ? 'Pintu Masuk' : 
          ($grave->section == 'section_B' ? 'Tandas & Stor' : 'Pintu Belakang') }}
    </p>
    
    <div class="tooltip-criteria mt-2">
        <div class="d-flex justify-content-between mb-1">
            <span><i class="fas fa-road me-1"></i> Kedekatan:</span>
            <span class="fw-bold">{{ $grave->getProximityLabel() }}</span>
        </div>
        <div class="progress" style="height: 5px;">
            <div class="progress-bar bg-primary" style="width: {{ $grave->getProximityWidth() }}%"></div>
        </div>
        
        <!-- Repeat for other criteria -->
    </div>
    
    <div class="d-flex justify-content-between mt-2">
        <span class="badge bg-{{ $grave->isAvailable() ? 'success' : 'danger' }} rounded-pill">
            <i class="fas {{ $grave->isAvailable() ? 'fa-check-circle' : 'fa-lock' }} me-1"></i>
            {{ $grave->isAvailable() ? 'Tersedia' : 'Ditempah' }}
        </span>
        @if($grave->isAvailable())
            <a href="{{ route('customer.create.booking', $grave->id) }}" class="btn btn-sm btn-primary py-0 px-2">
                Tempah
            </a>
        @endif
    </div>
</div>