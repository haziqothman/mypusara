@extends('layouts.navigation')

@section('content')
<div class="container-fluid py-4">
    {{-- Notification Messages --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @elseif (session('destroy'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <div>{{ session('destroy') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    {{-- Page Header --}}
    <div class="text-center my-5">
        <div class="position-relative d-inline-block">
            <h1 class="display-5 fw-bold text-primary mb-3 position-relative z-1">
                <span class="text-gradient-primary">MyPusara Admin</span>
            </h1>
            <div class="position-absolute bottom-0 start-0 end-0 mx-auto" style="width: 120px; height: 8px; background: linear-gradient(90deg, #667eea 0%, #764ba2 100%); border-radius: 4px;"></div>
        </div>
        <p class="lead text-muted mt-3">Kelola Makam dengan Penuh Hormat dan Tanggung Jawab</p>
    </div>

    {{-- Section Selection --}}
    <div class="card mb-4 border-0 shadow-sm rounded-lg overflow-hidden">
        <div class="card-header bg-gradient-primary text-white py-3">
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="mb-0"><i class="fas fa-map-marked-alt me-2"></i>Pilih Area Makam</h5>
                <span class="badge bg-white text-primary">{{ $package->total() }} Rekod</span>
            </div>
        </div>
        <div class="card-body">
            <div class="text-center mb-3">
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('admin.display.package', ['filter' => 'all']) }}" 
                       class="btn {{ request('filter') == 'all' || !request('filter') ? 'btn-primary' : 'btn-outline-primary' }}">
                        <i class="fas fa-layer-group me-1"></i> Semua
                    </a>
                    <a href="{{ route('admin.display.package', ['filter' => 'section_A']) }}" 
                       class="btn {{ request('filter') == 'section_A' ? 'btn-primary' : 'btn-outline-primary' }}">
                       <i class="fas fa-door-open me-1"></i> Pintu Masuk
                    </a>
                    <a href="{{ route('admin.display.package', ['filter' => 'section_B']) }}" 
                       class="btn {{ request('filter') == 'section_B' ? 'btn-primary' : 'btn-outline-primary' }}">
                        <i class="fas fa-toilet me-1"></i> Tandas & Stor
                    </a>
                    <a href="{{ route('admin.display.package', ['filter' => 'section_C']) }}" 
                       class="btn {{ request('filter') == 'section_C' ? 'btn-primary' : 'btn-outline-primary' }}">
                        <i class="fas fa-door-closed me-1"></i> Pintu Belakang
                    </a>
                </div>
            </div>

            {{-- Search and Add --}}
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 mt-4">
                <form action="{{ route('admin.display.package') }}" method="GET" class="flex-grow-1 w-100">
                    <div class="input-group input-group-merged shadow-sm">
                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" class="form-control border-start-0 ps-1" placeholder="Cari nombor pusara..." name="search" 
                               value="{{ request('search') }}">
                        <button class="btn btn-primary px-3" type="submit">
                            <i class="fas fa-filter me-1"></i> Filter
                        </button>
                    </div>
                </form>

                <a href="{{ route('admin.create.package') }}" class="btn btn-success px-4 shadow-sm">
                    <i class="fas fa-plus me-2"></i> Tambah Pusara
                </a>
            </div>
        </div>
    </div>

    {{-- Graves Listing --}}
    @if($package->count())
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach ($package as $item)
            <div class="col">
                <div class="card h-100 shadow-sm border-0 overflow-hidden hover-lift">
                    {{-- Grave Header --}}
                    <div class="card-header bg-gradient-dark text-white py-3 position-relative">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-monument me-2"></i>Pusara {{ $item->pusaraNo }}
                            </h5>
                            <span class="badge bg-{{ 
                                $item->status == 'tersedia' ? 'success' : 
                                ($item->status == 'tidak_tersedia' ? 'danger' : 'warning') 
                            }} rounded-pill shadow-sm">
                                {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                            </span>
                        </div>
                        <div class="position-absolute bottom-0 start-0 end-0" style="height: 4px; background: rgba(255,255,255,0.2);"></div>
                    </div>
                    
                    {{-- Grave Details --}}
                    <div class="card-body">
                        <div class="mb-3">
                            <span class="badge bg-light text-dark rounded-pill shadow-sm">
                                <i class="fas fa-map-marker-alt text-primary me-1"></i> {{ str_replace('_', ' ', $item->section) }}
                            </span>
                        </div>

                        <p class="card-text text-muted mb-4">
                            <i class="fas fa-info-circle text-primary me-1"></i> 
                            {{ Str::limit($item->packageDesc, 100) }}
                        </p>

                        {{-- MCDM Criteria Display --}}
                        <div class="bg-light p-3 rounded-3 mb-3 border">
                            <h6 class="text-uppercase text-xs fw-bold text-primary mb-3">
                                <i class="fas fa-clipboard-list me-1"></i> Kriteria Makam
                            </h6>
                            <ul class="list-unstyled mb-0">
                                @php
                                    $criteria = [
                                        'proximity_rating' => 'Kedekatan',
                                        'accessibility_rating' => 'Kemudahan Akses',
                                        'pathway_condition' => 'Keadaan Laluan',
                                        'soil_condition' => 'Keadaan Tanah',
                                        'drainage_rating' => 'Sistem Saliran',
                                        'shade_coverage' => 'Teduhan'
                                    ];
                                @endphp
                                
                                @foreach($criteria as $field => $label)
                                <li class="mb-2">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-sm">{{ $label }}:</span>
                                        <span class="fw-bold text-dark">{{ $item->$field }}</span>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-gradient-primary" role="progressbar" 
                                            style="width: {{ (int)$item->$field * 20 }}%"></div>
                                    </div>
                                </li>
                                @endforeach
                                
                                {{-- Location Button --}}
                                <li class="mt-3 pt-2 border-top">
                                    @if($item->latitude && $item->longitude)
                                        <a href="https://www.google.com/maps?q={{ $item->latitude }},{{ $item->longitude }}" 
                                           target="_blank" class="btn btn-sm btn-outline-primary w-100">
                                            <i class="fas fa-map-marker-alt me-1"></i> Lihat Lokasi
                                        </a>
                                    @else
                                        <span class="text-muted small"><i class="fas fa-map-marker-alt me-1"></i> Tiada koordinat</span>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    {{-- Action Buttons --}}
                    <div class="card-footer bg-transparent border-top-0 pt-0 pb-3 px-3">
                        <div class="d-flex justify-content-between gap-2">
                            <a href="{{ url('admin/package/' . $item->id . '/edit') }}" 
                               class="btn btn-sm btn-outline-primary flex-grow-1 rounded-pill">
                                <i class="fas fa-edit me-1"></i> Sunting
                            </a>
                            <button class="btn btn-sm btn-outline-danger flex-grow-1 rounded-pill" 
                                    data-bs-toggle="modal" data-bs-target="#deleteModal" 
                                    onclick="populateModal({{ json_encode($item) }})">
                                <i class="fas fa-trash-alt me-1"></i> Padam
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @else
    <div class="card shadow-sm border-0 overflow-hidden">
        <div class="card-body text-center py-5">
            <div class="empty-state">
                <img src="{{ asset('assets/img/empty.svg') }}" alt="No graves found" class="img-fluid mb-4" style="max-width: 280px; opacity: 0.7;">
                <h4 class="text-muted mb-3">Tiada rekod pusara ditemui</h4>
                <p class="text-muted mb-4">Sila tambah pusara baru atau cuba carian lain</p>
                <a href="{{ route('admin.create.package') }}" class="btn btn-primary btn-lg px-4 rounded-pill shadow-sm">
                    <i class="fas fa-plus me-2"></i>Tambah Pusara Pertama
                </a>
            </div>
        </div>
    </div>
    @endif

    {{-- Pagination --}}
    @if($package->hasPages())
    <div class="d-flex justify-content-center mt-5">
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-primary shadow-sm">
                {{-- Previous Page Link --}}
                @if ($package->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link rounded-start-pill"><i class="fas fa-angle-left"></i></span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link rounded-start-pill" href="{{ $package->previousPageUrl() }}" aria-label="Previous">
                            <i class="fas fa-angle-left"></i>
                        </a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($packages->links()->elements[0] as $page => $url)
                    <li class="page-item {{ $packages->currentPage() == $page ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach

                {{-- Next Page Link --}}
                @if ($packages->hasMorePages())
                    <li class="page-item">
                        <a class="page-link rounded-end-pill" href="{{ $package->nextPageUrl() }}" aria-label="Next">
                            <i class="fas fa-angle-right"></i>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link rounded-end-pill"><i class="fas fa-angle-right"></i></span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
    @endif
</div>

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i> Sahkan Penghapusan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div class="icon-circle bg-danger text-white mb-3">
                        <i class="fas fa-monument fa-2x"></i>
                    </div>
                    <h5 id="graveIdentifier" class="fw-bold mb-2"></h5>
                    <p class="text-muted">Makam ini akan dihapuskan secara kekal. Anda pasti ingin meneruskan?</p>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" action="#" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger rounded-pill px-4">
                        <i class="fas fa-trash-alt me-1"></i> Ya, Padam
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function populateModal(item) {
        // Set the grave identifier in the modal
        document.getElementById('graveIdentifier').textContent = `Pusara ${item.pusaraNo} - ${item.section.replace('_', ' ')}`;
        
        // Update the delete form's action URL
        const deleteUrl = `{{ url('admin/destroy') }}/${item.id}/package`;
        document.getElementById('deleteForm').action = deleteUrl;
    }
</script>

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --danger-gradient: linear-gradient(135deg, #f5365c 0%, #f56036 100%);
        --dark-gradient: linear-gradient(135deg, #32325d 0%, #1a1a2e 100%);
    }
    
    .text-gradient-primary {
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    .bg-gradient-primary {
        background: var(--primary-gradient);
    }
    
    .bg-gradient-danger {
        background: var(--danger-gradient);
    }
    
    .bg-gradient-dark {
        background: var(--dark-gradient);
    }
    
    .hover-lift {
        transition: all 0.25s ease;
    }
    
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 2.5rem rgba(0,0,0,0.1);
    }
    
    .input-group-merged .form-control {
        border-left: none;
        padding-left: 0;
    }
    
    .input-group-merged .input-group-text {
        border-right: none;
    }
    
    .icon-circle {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 60px;
        border-radius: 50%;
    }
    
    .progress-bar {
        border-radius: 3px;
    }
    
    .pagination-primary .page-item.active .page-link {
        background: var(--primary-gradient);
        border-color: transparent;
    }
    
    .pagination-primary .page-link {
        border-color: #e9ecef;
    }
    
    .empty-state {
        opacity: 0.8;
    }
    
    .btn-outline-primary:hover {
        background: var(--primary-gradient);
        color: white !important;
    }
    
    .btn-outline-danger:hover {
        background: var(--danger-gradient);
        color: white !important;
    }
</style>
@endsection