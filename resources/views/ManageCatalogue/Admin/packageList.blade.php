@extends('layouts.navigation')

@section('content')
<div class="container-fluid py-4">
    {{-- Notification Messages --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @elseif (session('destroy'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <div>{{ session('destroy') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    {{-- Page Header --}}
    <div class="text-center my-5">
        <h1 class="display-5 fw-bold text-gradient text-primary">MyPusara Admin</h1>
        <p class="lead text-muted">Kelola Makam dengan Penuh Hormat dan Tanggung Jawab</p>
        <div class="divider mx-auto bg-gradient-primary" style="width: 100px; height: 3px;"></div>
    </div>

    {{-- Section Selection --}}
    <div class="card mb-4 border-0 shadow-lg rounded-3 overflow-hidden">
        <div class="card-header bg-gradient-primary text-white py-3">
            <h5 class="mb-0 text-center"><i class="fas fa-map-marked-alt me-2"></i>Pilih Area Makam</h5>
        </div>
        <div class="card-body">
            <div class="text-center mb-3">
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    <a href="{{ route('admin.display.package', ['filter' => 'all']) }}" 
                       class="btn btn-sm btn-pill {{ request('filter') == 'all' || !request('filter') ? 'btn-primary' : 'btn-outline-primary' }}">
                        <i class="fas fa-layer-group me-1"></i> Semua Area
                    </a>
                    <a href="{{ route('admin.display.package', ['filter' => 'section_A']) }}" 
                       class="btn btn-sm btn-pill {{ request('filter') == 'section_A' ? 'btn-primary' : 'btn-outline-primary' }}">
                       <i class="fas fa-door-open me-1"></i> Pintu Masuk
                    </a>
                    <a href="{{ route('admin.display.package', ['filter' => 'section_B']) }}" 
                       class="btn btn-sm btn-pill {{ request('filter') == 'section_B' ? 'btn-primary' : 'btn-outline-primary' }}">
                        <i class="fas fa-toilet me-1"></i> Tandas & Stor
                    </a>
                    <a href="{{ route('admin.display.package', ['filter' => 'section_C']) }}" 
                       class="btn btn-sm btn-pill {{ request('filter') == 'section_C' ? 'btn-primary' : 'btn-outline-primary' }}">
                        <i class="fas fa-door-closed me-1"></i> Pintu Belakang
                    </a>
                </div>
            </div>

            {{-- Search and Add --}}
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 mt-4">
                <form action="{{ route('admin.display.package') }}" method="GET" class="flex-grow-1 w-100">
                    <div class="input-group input-group-dynamic">
                        <span class="input-group-text bg-transparent border-end-0"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control ps-2" placeholder="Cari nombor pusara..." name="search" 
                               value="{{ request('search') }}">
                        <button class="btn btn-primary px-3" type="submit">
                            <i class="fas fa-filter me-1"></i> Filter
                        </button>
                    </div>
                </form>

                <a href="{{ route('admin.create.package') }}" class="btn btn-success btn-icon">
                    <i class="fas fa-plus me-1"></i> Tambah Pusara
                </a>
            </div>
        </div>
    </div>

    {{-- Graves Listing --}}
    @if($package->count())
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach ($package as $item)
            <div class="col">
                <div class="card h-100 shadow-sm border-0 overflow-hidden">
                    {{-- Grave Header --}}
                    <div class="card-header bg-gradient-dark text-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-monument me-2"></i>Pusara {{ $item->pusaraNo }}
                            </h5>
                            <span class="badge bg-{{ 
                                $item->status == 'tersedia' ? 'success' : 
                                ($item->status == 'tidak_tersedia' ? 'danger' : 'warning') 
                            }} rounded-pill">
                                {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                            </span>
                        </div>
                    </div>
                    
                    {{-- Grave Details --}}
                    <div class="card-body">
                        <div class="mb-3">
                            <span class="badge bg-info text-dark rounded-pill">
                                <i class="fas fa-map-marker-alt me-1"></i> {{ str_replace('_', ' ', $item->section) }}
                            </span>
                        </div>

                        <p class="card-text text-muted mb-4">
                            <i class="fas fa-info-circle me-1 text-primary"></i> 
                            {{ Str::limit($item->packageDesc, 100) }}
                        </p>

                      {{-- MCDM Criteria Display --}}
                    <div class="bg-gray-100 p-3 rounded-2 mb-3">
                        <h6 class="text-uppercase text-xs font-weight-bold text-primary mb-3">
                            <i class="fas fa-clipboard-list me-1"></i> Kriteria Makam
                        </h6>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <div class="d-flex justify-content-between">
                                    <span class="text-sm">Kedekatan:</span>
                                    <span class="fw-bold">{{ $item->proximity_rating }}</span>
                                </div>
                                <div class="progress mt-1" style="height: 4px;">
                                    <div class="progress-bar bg-primary" role="progressbar" 
                                        style="width: {{ (int)$item->proximity_rating * 20 }}%"></div>
                                </div>
                            </li>
                            <li class="mb-2">
                                <div class="d-flex justify-content-between">
                                    <span class="text-sm">Kemudahan Akses:</span>
                                    <span class="fw-bold">{{ $item->accessibility_rating }}</span>
                                </div>
                                <div class="progress mt-1" style="height: 4px;">
                                    <div class="progress-bar bg-primary" role="progressbar" 
                                        style="width: {{ (int)$item->accessibility_rating * 20 }}%"></div>
                                </div>
                            </li>
                            <li class="mb-2">
                                <div class="d-flex justify-content-between">
                                    <span class="text-sm">Keadaan Laluan:</span>
                                    <span class="fw-bold">{{ $item->pathway_condition }}</span>
                                </div>
                                <div class="progress mt-1" style="height: 4px;">
                                    <div class="progress-bar bg-primary" role="progressbar" 
                                        style="width: {{ (int)$item->pathway_condition * 20 }}%"></div>
                                </div>
                            </li>
                            <li class="mb-2">
                                <div class="d-flex justify-content-between">
                                    <span class="text-sm">Keadaan Tanah:</span>
                                    <span class="fw-bold">{{ $item->soil_condition }}</span>
                                </div>
                                <div class="progress mt-1" style="height: 4px;">
                                    <div class="progress-bar bg-primary" role="progressbar" 
                                        style="width: {{ (int)$item->soil_condition * 20 }}%"></div>
                                </div>
                            </li>
                            <li class="mb-2">
                                <div class="d-flex justify-content-between">
                                    <span class="text-sm">Sistem Saliran:</span>
                                    <span class="fw-bold">{{ $item->drainage_rating }}</span>
                                </div>
                                <div class="progress mt-1" style="height: 4px;">
                                    <div class="progress-bar bg-primary" role="progressbar" 
                                        style="width: {{ (int)$item->drainage_rating * 20 }}%"></div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex justify-content-between">
                                    <span class="text-sm">Teduhan:</span>
                                    <span class="fw-bold">{{ $item->shade_coverage }}</span>
                                </div>
                                <div class="progress mt-1" style="height: 4px;">
                                    <div class="progress-bar bg-primary" role="progressbar" 
                                        style="width: {{ (int)$item->shade_coverage * 20 }}%"></div>
                                </div>
                            </li>
                        </ul>
                    </div>

                    </div>
                    
                    {{-- Action Buttons --}}
                    <div class="card-footer bg-transparent border-top-0 pt-0">
                        <div class="d-flex justify-content-between">
                            <a href="{{ url('admin/package/' . $item->id . '/edit') }}" 
                               class="btn btn-sm btn-outline-primary btn-round">
                                <i class="fas fa-edit me-1"></i> Sunting
                            </a>
                            <button class="btn btn-sm btn-outline-danger btn-round" data-bs-toggle="modal"
                                data-bs-target="#deleteModal" onclick="populateModal({{ json_encode($item) }})">
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
                <img src="{{ asset('assets/img/empty.svg') }}" alt="No graves found" class="img-fluid mb-4" style="max-width: 300px;">
                <h4 class="text-muted">Tiada rekod pusara ditemui</h4>
                <p class="text-muted mb-4">Sila tambah pusara baru atau cuba carian lain</p>
                <a href="{{ route('admin.create.package') }}" class="btn btn-primary btn-lg">
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
            <ul class="pagination pagination-primary">
                {{-- Previous Page Link --}}
                @if ($package->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link"><i class="fas fa-angle-left"></i></span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $package->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true"><i class="fas fa-angle-left"></i></span>
                        </a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($package->links()->elements[0] as $page => $url)
                    <li class="page-item {{ $package->currentPage() == $page ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach

                {{-- Next Page Link --}}
                @if ($package->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $package->nextPageUrl() }}" aria-label="Next">
                            <span aria-hidden="true"><i class="fas fa-angle-right"></i></span>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link"><i class="fas fa-angle-right"></i></span>
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
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-gradient-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i> Sahkan Penghapusan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="fas fa-monument fa-4x text-danger mb-3"></i>
                    <h5 id="graveIdentifier" class="fw-bold"></h5>
                    <p class="text-muted">Makam ini akan dihapuskan secara kekal. Anda pasti ingin meneruskan?</p>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary btn-round" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" action="#" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-round">
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
    
    .bg-gradient-primary {
        background: var(--primary-gradient);
    }
    
    .bg-gradient-danger {
        background: var(--danger-gradient);
    }
    
    .bg-gradient-dark {
        background: var(--dark-gradient);
    }
    
    .text-gradient {
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    .text-gradient.text-primary {
        background-image: var(--primary-gradient);
    }
    
    .card {
        transition: all 0.3s ease;
        border-radius: 12px;
        overflow: hidden;
        border: none;
    }
    
    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.1);
    }
    
    .btn-pill {
        border-radius: 50px;
        padding: 0.375rem 1.25rem;
    }
    
    .btn-round {
        border-radius: 50px;
    }
    
    .btn-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .badge.rounded-pill {
        padding: 0.35em 0.65em;
    }
    
    .pagination .page-item .page-link {
        border-radius: 8px;
        margin: 0 3px;
        border: none;
    }
    
    .pagination.pagination-primary .page-item.active .page-link {
        background: var(--primary-gradient);
    }
    
    .divider {
        background: var(--primary-gradient);
    }
    
    .bg-gray-100 {
        background-color: #f8f9fa;
    }
    
    .input-group.input-group-dynamic .form-control {
        border-radius: 0 8px 8px 0;
    }
    
    .input-group.input-group-dynamic .input-group-text {
        border-radius: 8px 0 0 8px;
        background-color: transparent;
        border-right: none;
    }
    
    .empty-state {
        opacity: 0.7;
    }
    
    .progress {
        border-radius: 4px;
        background-color: #e9ecef;
    }
    
    .progress-bar {
        border-radius: 4px;
    }
</style>
@endsection