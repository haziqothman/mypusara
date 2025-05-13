@extends('layouts.navigation')

@section('content')
<div class="container-fluid py-4">
    {{-- Notification Messages --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mx-auto" role="alert" style="max-width: 800px;">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-3 fs-4"></i>
                <div>
                    <h5 class="mb-1">Berjaya!</h5>
                    <p class="mb-0">{{ session('success') }}</p>
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    {{-- Page Header --}}
    <div class="text-center my-5">
        <div class="position-relative d-inline-block">
            <h1 class="display-5 fw-bold text-primary mb-3">MyPusara</h1>
            <div class="position-absolute bottom-0 start-0 end-0 mx-auto" style="width: 120px; height: 3px; background: linear-gradient(90deg, #4e73df, #1cc88a, #6f42c1);"></div>
        </div>
        <p class="lead text-muted mt-3">Pilih Pusara Anda Dengan Berhemat</p>
    </div>

    {{-- Filter Section --}}
    <div class="card shadow-sm mb-5 mx-auto" style="max-width: 800px; border: none; border-radius: 12px;">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <h5 class="mb-3 text-secondary fw-semibold">
                    <i class="fas fa-map-marked-alt me-2"></i> Pilih Kawasan
                </h5>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="{{ route('customer.display.package', ['filter' => 'all']) }}" 
                       class="btn btn-sm btn-outline-primary rounded-pill px-4 filter-link {{ request('filter') == 'all' || !request('filter') ? 'active' : '' }}" 
                       data-filter="all">
                        <i class="fas fa-layer-group me-2"></i> Semua
                    </a>
                    <a href="{{ route('customer.display.package', ['filter' => 'section_A']) }}" 
                       class="btn btn-sm btn-outline-primary rounded-pill px-4 filter-link {{ request('filter') == 'section_A' ? 'active' : '' }}" 
                       data-filter="section_A">
                        <i class="fas fa-door-open me-2"></i> Pintu Masuk
                    </a>
                    <a href="{{ route('customer.display.package', ['filter' => 'section_B']) }}" 
                       class="btn btn-sm btn-outline-primary rounded-pill px-4 filter-link {{ request('filter') == 'section_B' ? 'active' : '' }}" 
                       data-filter="section_B">
                        <i class="fas fa-toilet me-2"></i> Tandas & Stor
                    </a>
                    <a href="{{ route('customer.display.package', ['filter' => 'section_C']) }}" 
                       class="btn btn-sm btn-outline-primary rounded-pill px-4 filter-link {{ request('filter') == 'section_C' ? 'active' : '' }}" 
                       data-filter="section_C">
                        <i class="fas fa-door-closed me-2"></i> Pintu Belakang
                    </a>
                </div>
            </div>

            <div class="mt-4">
                <form action="{{ route('customer.display.package') }}" method="GET">
                    <div class="input-group shadow-sm" style="border-radius: 50px;">
                        <span class="input-group-text bg-white border-0 ps-4">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-0 ps-2" 
                               placeholder="Cari nombor pusara..." 
                               name="search" value="{{ request('search') }}"
                               style="height: 45px;">
                        <button class="btn btn-primary px-4 rounded-end" type="submit" style="height: 45px;">
                            Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Compact Map Legend --}}
    <div class="card shadow-sm mb-5 mx-auto" style="max-width: 800px; border: none; border-radius: 12px;">
        <div class="card-body p-3">
            <div class="d-flex flex-wrap justify-content-center gap-2">
                <div class="legend-item compact">
                    <div class="legend-icon road d-flex align-items-center justify-content-center">
                        <div style="width: 12px; height: 2px; background: var(--road-color);"></div>
                    </div>
                    <span class="ms-1">Jalan</span>
                </div>
                <div class="legend-item compact">
                    <div class="legend-icon entrance-icon">
                        <i class="fas fa-door-open fs-6"></i>
                    </div>
                    <span class="ms-1">Masuk</span>
                </div>
                <div class="legend-item compact">
                    <div class="legend-icon toilet-icon">
                        <i class="fas fa-toilet fs-6"></i>
                    </div>
                    <span class="ms-1">Tandas & Stor</span>
                </div>
                <div class="legend-item compact">
                    <div class="legend-icon exit-icon">
                        <i class="fas fa-door-closed fs-6"></i>
                    </div>
                    <span class="ms-1">Keluar</span>
                </div>
                <div class="legend-item compact">
                    <div class="legend-icon available">
                        <i class="fas fa-check-circle fs-6" style="color: var(--available-color);"></i>
                    </div>
                    <span class="ms-1">Tersedia</span>
                </div>
                <div class="legend-item compact">
                    <div class="legend-icon booked">
                        <i class="fas fa-times-circle fs-6" style="color: var(--booked-color);"></i>
                    </div>
                    <span class="ms-1">Ditempah</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Cemetery Layout Container --}}
    <div class="d-flex justify-content-center">
        <div class="cemetery-layout-container" style="width: 100%; max-width: 1200px;">
            {{-- Road System --}}
            <div class="road-system">
                <div class="main-road horizontal"></div>
                <div class="main-road vertical"></div>
                <div class="entrance-road"></div>
                <div class="exit-road-vertical"></div>
            </div>

            {{-- Landmarks --}}
            <div class="landmark-container">
                <div class="landmark entrance">
                    <i class="fas fa-door-open"></i>
                    <span class="landmark-label">Pintu Masuk</span>
                </div>
                <div class="landmark toilet">
                    <i class="fas fa-toilet"></i>
                    <span class="landmark-label">Tandas & Stor</span>
                </div>
                <div class="landmark exit">
                    <i class="fas fa-door-closed"></i>
                    <span class="landmark-label">Pintu Keluar</span>
                </div>
            </div>

            {{-- Visual Partitions --}}
            <div class="cemetery-partitions">
                {{-- Section A: Pintu Masuk (Left) --}}
                <div class="partition partition-a" id="section-a" data-section="section_A">
                    <div class="section-header">
                        <h6 class="section-title">
                            <i class="fas fa-door-open me-2"></i> Kawasan Pintu Masuk
                        </h6>
                    </div>
                    <div class="grave-grid">
                        @foreach ($package as $item)
                            @if($item->section == 'section_A')
                                <div class="grave-item" data-bs-toggle="tooltip" data-bs-placement="top" title="Pusara {{ $item->pusaraNo }}">
                                    @if($item->isAvailable())
                                        <a href="{{ route('customer.create.booking', $item->id) }}" class="grave-link">
                                            <div class="grave-number">{{ $item->pusaraNo }}</div>
                                            <div class="grave-status available">
                                                <i class="fas fa-check-circle"></i>
                                            </div>
                                        </a>
                                    @else
                                        <div class="grave-number">{{ $item->pusaraNo }}</div>
                                        <div class="grave-status booked">
                                            <i class="fas fa-times-circle"></i>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                {{-- Section C: Pintu Belakang (Right) --}}
                <div class="partition partition-c" id="section-c" data-section="section_C">
                    <div class="section-header">
                        <h6 class="section-title">
                            <i class="fas fa-door-closed me-2"></i> Kawasan Pintu Belakang
                        </h6>
                    </div>
                    <div class="grave-grid">
                        @foreach ($package as $item)
                            @if($item->section == 'section_C')
                                <div class="grave-item" data-bs-toggle="tooltip" data-bs-placement="top" title="Pusara {{ $item->pusaraNo }}">
                                    @if($item->isAvailable())
                                        <a href="{{ route('customer.create.booking', $item->id) }}" class="grave-link">
                                            <div class="grave-number">{{ $item->pusaraNo }}</div>
                                            <div class="grave-status available">
                                                <i class="fas fa-check-circle"></i>
                                            </div>
                                        </a>
                                    @else
                                        <div class="grave-number">{{ $item->pusaraNo }}</div>
                                        <div class="grave-status booked">
                                            <i class="fas fa-times-circle"></i>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                {{-- Section B: Tandas & Stor (Bottom - Full Width) --}}
                <div class="partition partition-b" id="section-b" data-section="section_B">
                    <div class="section-header">
                        <h6 class="section-title">
                            <i class="fas fa-toilet me-2"></i> Kawasan Tandas & Stor
                        </h6>
                    </div>
                    <div class="grave-grid">
                        @foreach ($package as $item)
                            @if($item->section == 'section_B')
                                <div class="grave-item" data-bs-toggle="tooltip" data-bs-placement="top" title="Pusara {{ $item->pusaraNo }}">
                                    @if($item->isAvailable())
                                        <a href="{{ route('customer.create.booking', $item->id) }}" class="grave-link">
                                            <div class="grave-number">{{ $item->pusaraNo }}</div>
                                            <div class="grave-status available">
                                                <i class="fas fa-check-circle"></i>
                                            </div>
                                        </a>
                                    @else
                                        <div class="grave-number">{{ $item->pusaraNo }}</div>
                                        <div class="grave-status booked">
                                            <i class="fas fa-times-circle"></i>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- No Results --}}
            @if($package->isEmpty())
            <div class="no-results text-center py-5">
                <div class="empty-state">
                    <i class="fas fa-monument fa-4x text-muted mb-4"></i>
                    <h4 class="text-secondary mb-3">Tiada rekod pusara ditemui</h4>
                    <p class="text-muted mb-4">Sila cuba carian lain atau pilih kawasan yang berbeza</p>
                    <a href="{{ route('customer.display.package') }}" class="btn btn-primary px-4 py-2 rounded-pill">
                        <i class="fas fa-sync-alt me-2"></i> Reset Carian
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Pagination --}}
    @if($package->hasPages())
    <div class="d-flex justify-content-center mt-5">
        <nav aria-label="Page navigation">
            {{ $package->links() }}
        </nav>
    </div>
    @endif
</div>

<style>
    /* Color Scheme */
    :root {
        --section-a: #f8f9fa;
        --section-b: #f1f8e9;
        --section-c: #f3e5f5;
        --road-color: #d7ccc8;
        --partition-border: rgba(0,0,0,0.08);
        --primary-color: #4e73df;
        --success-color: #28a745;
        --danger-color: #dc3545;
        --exit-color: #6f42c1;
        --available-color: #2ecc71;
        --booked-color: #dc3545;
        --shadow-sm: 0 1px 3px rgba(0,0,0,0.1);
        --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
        --shadow-lg: 0 10px 15px rgba(0,0,0,0.1);
    }

    /* Compact Legend Styles */
    .legend-item.compact {
        display: flex;
        align-items: center;
        padding: 0.3rem 0.8rem;
        background: white;
        border-radius: 50px;
        box-shadow: var(--shadow-sm);
        transition: all 0.2s;
        font-size: 0.85rem;
    }

    .legend-item.compact:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .legend-item.compact .legend-icon {
        width: 20px;
        height: 20px;
        font-size: 0.7rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .legend-item.compact .legend-icon i {
        font-size: 0.7rem;
    }

    .legend-item.compact .legend-icon.road {
        background-color: transparent;
    }

    .legend-item.compact .legend-icon.available {
        background-color: rgba(46, 204, 113, 0.15);
    }

    .legend-item.compact .legend-icon.booked {
        background-color: rgba(220, 53, 69, 0.15);
    }

    .legend-item.compact .legend-icon.entrance-icon {
        background-color: var(--primary-color);
        color: white;
    }

    .legend-item.compact .legend-icon.toilet-icon {
        background-color: var(--success-color);
        color: white;
    }

    .legend-item.compact .legend-icon.exit-icon {
        background-color: var(--exit-color);
        color: white;
    }

    /* Cemetery Layout */
    .cemetery-layout-container {
        position: relative;
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: var(--shadow-lg);
        margin-bottom: 3rem;
        min-height: 600px;
        overflow: hidden;
    }

    /* Road System */
    .road-system {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 1;
    }

    .main-road {
        position: absolute;
        background-color: var(--road-color);
    }

    .horizontal {
        top: 50%;
        left: 0;
        width: 100%;
        height: 4px;
        transform: translateY(-50%);
    }

    .vertical {
        top: 0;
        left: 50%;
        width: 4px;
        height: 100%;
        transform: translateX(-50%);
    }

    /* Entrance and Exit Roads */
    .entrance-road {
        position: absolute;
        background-color: var(--road-color);
        top: 50%;
        left: 0;
        width: 30px;
        height: 4px;
        transform: translateY(-50%);
    }

    .exit-road-vertical {
        position: absolute;
        background-color: var(--road-color);
        top: 20%;
        right: 0;
        width: 4px;
        height: 60%;
    }

    /* Landmarks */
    .landmark-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 10;
    }

    .landmark {
        position: absolute;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: white;
        box-shadow: var(--shadow-lg);
        transition: all 0.3s;
    }

    .landmark:hover {
        transform: scale(1.1);
    }

    .landmark i {
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
    }

    .landmark-label {
        font-size: 0.7rem;
        font-weight: 500;
        white-space: nowrap;
        display: none;
        position: absolute;
        bottom: -25px;
        background: white;
        padding: 3px 8px;
        border-radius: 20px;
        box-shadow: var(--shadow-sm);
        color: #333;
    }

    .landmark:hover .landmark-label {
        display: block;
        animation: fadeIn 0.3s ease;
    }

    /* Fixed landmark positions - Updated to center the entrance */
    .entrance {
        top: 5%;
        left: 15px;
        transform: translateY(-50%);
        background: linear-gradient(135deg, var(--primary-color), #3a56c8);
    }

    .toilet {
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        background: linear-gradient(135deg, var(--success-color), #1e7e34);
        width: 60px;
        height: 60px;
    }

    .exit {
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, var(--exit-color), #5a3ab6);
    }

    /* Partitions Layout */
    .cemetery-partitions {
        display: grid;
        grid-template-areas:
            "left right"
            "bottom bottom";
        grid-template-columns: 1fr 1fr;
        grid-template-rows: 1fr auto;
        gap: 1.5rem;
        position: relative;
        z-index: 2;
        margin-top: 30px;
    }

    .partition {
        padding: 1rem;
        border-radius: 12px;
        min-height: 450px;
        border: 1px solid var(--partition-border);
        position: relative;
        transition: all 0.3s;
        background-color: white;
    }

    .partition:hover {
        box-shadow: var(--shadow-md);
    }

    .partition-a {
        grid-area: left;
        background-color: var(--section-a);
    }

    .partition-b {
        grid-area: bottom;
        background-color: var(--section-b);
    }

    .partition-c {
        grid-area: right;
        background-color: var(--section-c);
    }

    .section-header {
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid rgba(0,0,0,0.05);
    }

    .section-title {
        font-weight: 600;
        color: #495057;
        display: flex;
        align-items: center;
    }

    /* Grave Grid */
    .grave-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
        gap: 1rem;
    }

    /* Grave Item */
    .grave-item {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 0.75rem;
        border-radius: 8px;
        background: white;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s;
        text-decoration: none;
        color: inherit;
        min-height: 80px;
        overflow: hidden;
    }

    .grave-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--primary-color), var(--success-color));
        opacity: 0;
        transition: opacity 0.3s;
    }

    .grave-item:hover::before {
        opacity: 1;
    }

    .grave-link {
        text-decoration: none;
        color: inherit;
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .grave-item:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-md);
    }

    .grave-number {
        font-weight: 700;
        font-size: 1rem;
        margin-top: 0.5rem;
        z-index: 2;
        color: #343a40;
    }

    .grave-status {
        position: absolute;
        bottom: 8px;
        right: 8px;
        font-size: 0.8rem;
        padding: 0.3rem;
        border-radius: 50%;
        width: 22px;
        height: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 3;
    }

    .available {
        background-color: rgba(46, 204, 113, 0.15);
        color: var(--available-color);
    }

    .booked {
        background-color: rgba(220, 53, 69, 0.15);
        color: var(--booked-color);
    }

    /* No Results */
    .no-results {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
    }

    .empty-state {
        max-width: 400px;
        margin: 0 auto;
        padding: 2rem;
        background: white;
        border-radius: 12px;
        box-shadow: var(--shadow-sm);
    }

    /* Pagination */
    .pagination {
        gap: 0.5rem;
    }

    .page-item .page-link {
        border-radius: 8px !important;
        border: none;
        box-shadow: var(--shadow-sm);
    }

    .page-item.active .page-link {
        background: linear-gradient(135deg, var(--primary-color), #3a56c8);
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Responsive Adjustments */
    @media (max-width: 1200px) {
        .grave-grid {
            grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
        }
    }

    @media (max-width: 992px) {
        .cemetery-partitions {
            grid-template-areas:
                "left"
                "right"
                "bottom";
            grid-template-columns: 1fr;
        }
        
        .grave-grid {
            grid-template-columns: repeat(auto-fill, minmax(75px, 1fr));
        }

        .landmark {
            width: 45px;
            height: 45px;
            font-size: 18px;
        }

        .toilet {
            width: 55px;
            height: 55px;
        }
    }

    @media (max-width: 768px) {
        .filter-link {
            padding: 0.5rem 1rem !important;
        }

        .legend-item.compact {
            padding: 0.25rem 0.6rem;
            font-size: 0.8rem;
        }

        .grave-grid {
            grid-template-columns: repeat(auto-fill, minmax(70px, 1fr));
            gap: 0.8rem;
        }
        
        .grave-number {
            font-size: 0.9rem;
        }
        
        .grave-status {
            width: 20px;
            height: 20px;
            font-size: 0.7rem;
        }
    }

    @media (max-width: 576px) {
        .cemetery-layout-container {
            padding: 1.5rem;
        }

        .partition {
            padding: 1rem;
        }

        .grave-grid {
            grid-template-columns: repeat(auto-fill, minmax(60px, 1fr));
        }
        
        .legend-item.compact {
            padding: 0.2rem 0.5rem;
            font-size: 0.75rem;
        }
        
        .legend-item.compact .legend-icon {
            width: 18px;
            height: 18px;
        }
    }
</style>

<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        // Enhanced tooltips with custom class
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                customClass: 'custom-tooltip',
                boundary: 'window'
            });
        });

        // Handle filter clicks with smooth transitions
        const filterLinks = document.querySelectorAll('.filter-link');
        
        filterLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Update active button with animation
                filterLinks.forEach(l => {
                    l.classList.remove('active');
                    l.style.transform = '';
                });
                
                this.classList.add('active');
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 200);
                
                const filter = this.dataset.filter;
                
                // Animate section transitions
                document.querySelectorAll('.partition').forEach(p => {
                    if(filter === 'all' || p.dataset.section === filter) {
                        p.style.display = 'block';
                        p.style.animation = 'fadeIn 0.5s ease';
                    } else {
                        p.style.animation = 'fadeOut 0.3s ease';
                        setTimeout(() => {
                            p.style.display = 'none';
                        }, 300);
                    }
                });
                
                // Update URL
                history.pushState({}, '', this.href);
            });
        });

        // Apply initial filter from URL
        const urlParams = new URLSearchParams(window.location.search);
        const filterParam = urlParams.get('filter');
        if(filterParam) {
            document.querySelector(`.filter-link[data-filter="${filterParam}"]`).click();
        } else {
            // Show all by default
            document.querySelector('.filter-link[data-filter="all"]').click();
        }

        // Add custom animation styles
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            @keyframes fadeOut {
                from { opacity: 1; transform: translateY(0); }
                to { opacity: 0; transform: translateY(10px); }
            }
            .custom-tooltip .tooltip-inner {
                background-color: #333;
                padding: 8px 12px;
                font-size: 0.85rem;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            }
            .custom-tooltip .tooltip-arrow {
                display: none;
            }
        `;
        document.head.appendChild(style);
    });
</script>
@endsection