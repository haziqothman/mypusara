@extends('layouts.navigation')

@section('content')
<div class="container-fluid py-4">
    {{-- Notification Messages --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mx-auto" style="max-width: 800px;" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2 fs-4"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    {{-- Page Header --}}
    <div class="text-center my-5">
        <h1 class="display-5 fw-bold text-gradient">MyPusara</h1>
        <p class="lead text-muted">Pilih Pusara Anda Dengan Berhemat</p>
    </div>

    {{-- Filter Section --}}
    <div class="card shadow-sm mb-5 mx-auto" style="max-width: 800px; border-radius: 12px;">
        <div class="card-body p-4">
            {{-- Section Selection --}}
            <div class="text-center mb-3">
                <h5 class="mb-3 text-secondary">Pilih Kawasan</h5>
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    <a href="{{ route('customer.display.package', ['filter' => 'all']) }}" 
                       class="btn btn-sm btn-outline-primary rounded-pill px-3 {{ request('filter') == 'all' || !request('filter') ? 'active' : '' }}">
                        <i class="fas fa-layer-group me-1"></i> Semua Area
                    </a>
                    <a href="{{ route('customer.display.package', ['filter' => 'section_A']) }}" 
                       class="btn btn-sm btn-outline-primary rounded-pill px-3 {{ request('filter') == 'section_A' ? 'active' : '' }}">
                        <i class="fas fa-door-open me-1"></i> Pintu Masuk
                    </a>
                    <a href="{{ route('customer.display.package', ['filter' => 'section_B']) }}" 
                       class="btn btn-sm btn-outline-primary rounded-pill px-3 {{ request('filter') == 'section_B' ? 'active' : '' }}">
                        <i class="fas fa-toilet me-1"></i> Tandas & Stor
                    </a>
                    <a href="{{ route('customer.display.package', ['filter' => 'section_C']) }}" 
                       class="btn btn-sm btn-outline-primary rounded-pill px-3 {{ request('filter') == 'section_C' ? 'active' : '' }}">
                        <i class="fas fa-door-closed me-1"></i> Pintu Belakang
                    </a>
                </div>
            </div>

            {{-- Search --}}
            <div class="mt-4">
                <form action="{{ route('customer.display.package') }}" method="GET">
                    <div class="input-group shadow-sm rounded-pill overflow-hidden">
                        <input type="text" class="form-control border-0 ps-4" 
                               placeholder="Cari nombor pusara..." 
                               name="search" value="{{ request('search') }}">
                        <button class="btn btn-primary px-4" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Graves Grid --}}
    @if($package->count())
    <div class="grave-grid mx-auto" style="max-width: 1200px;">
        @foreach ($package as $item)
            <div class="grave-item" data-bs-toggle="tooltip" data-bs-html="true"
                 title="<b>Pusara {{ $item->pusaraNo }}</b><br>Kawasan: {{ 
                    $item->section == 'section_A' ? 'Pintu Masuk' : 
                    ($item->section == 'section_B' ? 'Tandas & Stor' : 'Pintu Belakang')
                 }}<br>Status: {{ 
                    $item->status == 'tersedia' ? 'Tersedia' : 
                    ($item->status == 'tidak_tersedia' ? 'Tidak Tersedia' : 'Dalam Penyelenggaraan')
                 }}">
                @if($item->isAvailable())
                    <a href="{{ route('customer.create.booking', $item->id) }}" class="grave-link">
                        <div class="grave-icon-container">
                            <img src="{{ asset('images/icon.png') }}" class="grave-icon" alt="Grave Icon">
                            <div class="grave-info">
                                <span class="grave-number">{{ $item->pusaraNo }}</span>
                                <span class="grave-status-badge badge bg-success">
                                    <i class="fas fa-check-circle me-1"></i> Tersedia
                                </span>
                            </div>
                        </div>
                    </a>
                @else
                    <div class="grave-unavailable-container">
                        <div class="grave-icon-container">
                            <img src="{{ asset('images/icon2.png') }}" class="grave-icon unavailable-image" alt="Booked Grave">
                            <div class="unavailable-overlay">
                                <div class="unavailable-content">
                                    <i class="fas fa-lock unavailable-icon"></i>
                                    <span class="unavailable-text">DITEMPAH</span>
                                </div>
                            </div>
                            <div class="grave-info">
                                <span class="grave-number text-muted">{{ $item->pusaraNo }}</span>
                                <span class="grave-status-badge badge bg-danger">
                                    <i class="fas fa-times-circle me-1"></i> Ditempah
                                </span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
    @else
    <div class="card shadow-sm mx-auto text-center py-5" style="max-width: 600px; border-radius: 12px;">
        <div class="card-body">
            <i class="fas fa-monument fa-4x text-muted mb-4"></i>
            <h4 class="text-secondary mb-3">Tiada rekod pusara ditemui</h4>
            <p class="text-muted mb-4">Sila cuba carian lain atau pilih kawasan yang berbeza</p>
            <a href="{{ route('customer.display.package') }}" class="btn btn-primary px-4">
                <i class="fas fa-sync-alt me-2"></i> Reset Carian
            </a>
        </div>
    </div>
    @endif

    {{-- Pagination --}}
    @if($package->hasPages())
    <div class="d-flex justify-content-center mt-5">
        <nav aria-label="Page navigation">
            <ul class="pagination shadow-sm">
                {{-- Previous Page Link --}}
                @if ($package->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link rounded-start"><i class="fas fa-angle-left"></i></span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link rounded-start" href="{{ $package->previousPageUrl() }}" aria-label="Previous">
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
                        <a class="page-link rounded-end" href="{{ $package->nextPageUrl() }}" aria-label="Next">
                            <span aria-hidden="true"><i class="fas fa-angle-right"></i></span>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link rounded-end"><i class="fas fa-angle-right"></i></span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
    @endif
</div>

<style>
    .text-gradient {
        background: linear-gradient(45deg, #4e73df, #1cc88a);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }
    
    .grave-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 2rem;
        padding: 1rem;
    }

    .grave-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        transition: all 0.3s ease;
    }

    .grave-icon-container {
        position: relative;
        text-align: center;
        width: 100%;
        transition: all 0.3s ease;
    }

    .grave-icon {
        width: 100px;
        height: 100px;
        object-fit: contain;
        filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
        transition: all 0.3s ease;
    }

    .grave-link:hover .grave-icon {
        transform: translateY(-5px);
        filter: drop-shadow(0 8px 12px rgba(0,0,0,0.15));
    }

    .grave-info {
        margin-top: 0.75rem;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .grave-number {
        font-size: 1rem;
        font-weight: 600;
        color: #2d3748;
    }

    .grave-status-badge {
        font-size: 0.75rem;
        margin-top: 0.5rem;
        padding: 0.35rem 0.75rem;
        border-radius: 1rem;
    }

    /* Unavailable Grave Styles */
    .grave-unavailable-container {
        position: relative;
        width: 100%;
    }

    .unavailable-image {
        filter: grayscale(100%) brightness(0.7);
        opacity: 0.8;
    }

    .unavailable-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 0, 0, 0.4);
        border-radius: 50%;
    }

    .unavailable-content {
        text-align: center;
        color: white;
        z-index: 2;
    }

    .unavailable-icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        color: #fff;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }

    .unavailable-text {
        display: block;
        font-weight: bold;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        background: rgba(220, 53, 69, 0.9);
        padding: 0.25rem 0.5rem;
        border-radius: 1rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    /* Disable all interactions */
    .grave-unavailable-container {
        pointer-events: none;
        cursor: not-allowed;
    }

    /* Optional: Add a diagonal stripe pattern */
    .grave-unavailable-container::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: repeating-linear-gradient(
            45deg,
            rgba(255,255,255,0.1),
            rgba(255,255,255,0.1) 10px,
            rgba(255,255,255,0.05) 10px,
            rgba(255,255,255,0.05) 20px
        );
        border-radius: 50%;
        z-index: 1;
    }

    .btn-outline-primary.active {
        background-color: #4e73df;
        color: white;
        border-color: #4e73df;
    }

    .pagination .page-item.active .page-link {
        background-color: #4e73df;
        border-color: #4e73df;
    }

    .tooltip-inner {
        max-width: 300px;
        padding: 0.75rem 1rem;
        text-align: left;
        border-radius: 0.5rem;
    }

    .card {
        border: none;
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
    }

    .form-control:focus {
        box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
        border-color: #4e73df;
    }
</style>

<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                boundary: document.body,
                popperConfig: {
                    modifiers: [
                        {
                            name: 'offset',
                            options: {
                                offset: [0, 10]
                            }
                        }
                    ]
                }
            });
        });

        // Add hover effect to available graves only
        document.querySelectorAll('.grave-link:not(.unavailable)').forEach(link => {
            link.addEventListener('mouseenter', function() {
                this.querySelector('.grave-icon').style.transform = 'translateY(-5px)';
            });
            link.addEventListener('mouseleave', function() {
                this.querySelector('.grave-icon').style.transform = 'translateY(0)';
            });
        });
    });
</script>
@endsection