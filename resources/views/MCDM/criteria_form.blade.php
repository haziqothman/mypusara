<!-- resources/views/MCDM/criteria_form.blade.php -->
@extends('layouts.navigation')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Sistem Cadangan Pusara Berasaskan Lokasi & Persekitaran</h3>
                    <p class="mb-0">Sila nyatakan keutamaan anda untuk kriteria berikut</p>
                </div>
                
                <div class="card-body">
                    <form method="POST" action="{{ route('mcdm.process') }}">
                        @csrf
                        
                        <!-- Location & Accessibility Section -->
                        <div class="mb-5">
                            <h4 class="mb-4 border-bottom pb-2">
                                <i class="fas fa-map-marker-alt me-2"></i> Lokasi & Aksesibiliti
                            </h4>
                            
                            <!-- Proximity -->
                            <div class="mb-4">
                                <h5 class="mb-3">Kedekatan dengan Keluarga</h5>
                                <p class="text-muted mb-3">Betapa pentingnya lokasi berhampiran tempat tinggal keluarga?</p>
                                <div class="btn-group-vertical w-100" role="group">
                                    <input type="radio" class="btn-check" name="proximity" id="proximity_very_important" value="very_important" autocomplete="off" checked>
                                    <label class="btn btn-outline-primary text-start" for="proximity_very_important">
                                        <i class="fas fa-home me-2"></i> Sangat Penting - Kurang dari 5km dari rumah
                                    </label>
                                    
                                    <input type="radio" class="btn-check" name="proximity" id="proximity_important" value="important" autocomplete="off">
                                    <label class="btn btn-outline-primary text-start" for="proximity_important">
                                        <i class="fas fa-home me-2"></i> Penting - Dalam 10km dari rumah
                                    </label>
                                    
                                    <input type="radio" class="btn-check" name="proximity" id="proximity_not_important" value="not_important" autocomplete="off">
                                    <label class="btn btn-outline-primary text-start" for="proximity_not_important">
                                        <i class="fas fa-home me-2"></i> Tidak Penting - Lokasi tidak menjadi halangan
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Accessibility -->
                            <div class="mb-4">
                                <h5 class="mb-3">Kemudahan Akses</h5>
                                <p class="text-muted mb-3">Bagaimana keadaan akses ke lokasi pusara?</p>
                                <div class="btn-group-vertical w-100" role="group">
                                    <input type="radio" class="btn-check" name="accessibility" id="access_excellent" value="excellent" autocomplete="off" checked>
                                    <label class="btn btn-outline-primary text-start" for="access_excellent">
                                        <i class="fas fa-road me-2"></i> Cemerlang - Jalan raya baik, boleh dilalui kenderaan
                                    </label>
                                    
                                    <input type="radio" class="btn-check" name="accessibility" id="access_good" value="good" autocomplete="off">
                                    <label class="btn btn-outline-primary text-start" for="access_good">
                                        <i class="fas fa-road me-2"></i> Baik - Jalan boleh dilalui tetapi mungkin sempit
                                    </label>
                                    
                                    <input type="radio" class="btn-check" name="accessibility" id="access_poor" value="poor" autocomplete="off">
                                    <label class="btn btn-outline-primary text-start" for="access_poor">
                                        <i class="fas fa-road me-2"></i> Terhad - Hanya boleh dilalui pejalan kaki
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Pathway Condition -->
                            <div class="mb-4">
                                <h5 class="mb-3">Keadaan Laluan ke Pusara</h5>
                                <p class="text-muted mb-3">Bagaimana keadaan laluan ke pusara?</p>
                                <div class="btn-group-vertical w-100" role="group">
                                    <input type="radio" class="btn-check" name="pathway_condition" id="path_wide_paved" value="wide_paved" autocomplete="off" checked>
                                    <label class="btn btn-outline-primary text-start" for="path_wide_paved">
                                        <i class="fas fa-walking me-2"></i> Laluan luas dan berturap
                                    </label>
                                    
                                    <input type="radio" class="btn-check" name="pathway_condition" id="path_narrow_paved" value="narrow_paved" autocomplete="off">
                                    <label class="btn btn-outline-primary text-start" for="path_narrow_paved">
                                        <i class="fas fa-walking me-2"></i> Laluan sempit tetapi berturap
                                    </label>
                                    
                                    <input type="radio" class="btn-check" name="pathway_condition" id="path_unpaved" value="unpaved" autocomplete="off">
                                    <label class="btn btn-outline-primary text-start" for="path_unpaved">
                                        <i class="fas fa-walking me-2"></i> Laluan tanah/tanpa turapan
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Grave Condition & Environment Section -->
                        <div class="mb-5">
                            <h4 class="mb-4 border-bottom pb-2">
                                <i class="fas fa-tree me-2"></i> Keadaan Pusara & Persekitaran
                            </h4>
                            
                            <!-- Soil Condition -->
                            <div class="mb-4">
                                <h5 class="mb-3">Keadaan Tanah</h5>
                                <p class="text-muted mb-3">Kualiti tanah untuk pengebumian mengikut hukum Islam</p>
                                <div class="btn-group-vertical w-100" role="group">
                                    <input type="radio" class="btn-check" name="soil_condition" id="soil_excellent" value="excellent" autocomplete="off" checked>
                                    <label class="btn btn-outline-primary text-start" for="soil_excellent">
                                        <i class="fas fa-mountain me-2"></i> Cemerlang - Tanah keras dan dalam
                                    </label>
                                    
                                    <input type="radio" class="btn-check" name="soil_condition" id="soil_good" value="good" autocomplete="off">
                                    <label class="btn btn-outline-primary text-start" for="soil_good">
                                        <i class="fas fa-mountain me-2"></i> Baik - Tanah sederhana keras
                                    </label>
                                    
                                    <input type="radio" class="btn-check" name="soil_condition" id="soil_poor" value="poor" autocomplete="off">
                                    <label class="btn btn-outline-primary text-start" for="soil_poor">
                                        <i class="fas fa-mountain me-2"></i> Kurang Baik - Tanah lembut/berpasir
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Drainage -->
                            <div class="mb-4">
                                <h5 class="mb-3">Sistem Saliran</h5>
                                <p class="text-muted mb-3">Bagaimana keadaan saliran air di kawasan pusara?</p>
                                <div class="btn-group-vertical w-100" role="group">
                                    <input type="radio" class="btn-check" name="drainage" id="drainage_excellent" value="excellent" autocomplete="off" checked>
                                    <label class="btn btn-outline-primary text-start" for="drainage_excellent">
                                        <i class="fas fa-water me-2"></i> Cemerlang - Kawasan tinggi, tiada takungan air
                                    </label>
                                    
                                    <input type="radio" class="btn-check" name="drainage" id="drainage_good" value="good" autocomplete="off">
                                    <label class="btn btn-outline-primary text-start" for="drainage_good">
                                        <i class="fas fa-water me-2"></i> Baik - Sedikit takungan air ketika hujan lebat
                                    </label>
                                    
                                    <input type="radio" class="btn-check" name="drainage" id="drainage_poor" value="poor" autocomplete="off">
                                    <label class="btn btn-outline-primary text-start" for="drainage_poor">
                                        <i class="fas fa-water me-2"></i> Teruk - Kerap banjir/takungan air
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Shade -->
                            <div class="mb-4">
                                <h5 class="mb-3">Perlindungan Teduhan</h5>
                                <p class="text-muted mb-3">Keutamaan teduhan untuk keselesaan pelawat</p>
                                <div class="btn-group-vertical w-100" role="group">
                                    <input type="radio" class="btn-check" name="shade" id="shade_full" value="full_shade" autocomplete="off" checked>
                                    <label class="btn btn-outline-primary text-start" for="shade_full">
                                        <i class="fas fa-umbrella-beach me-2"></i> Teduhan Penuh - Ada binaan/pokok teduh
                                    </label>
                                    
                                    <input type="radio" class="btn-check" name="shade" id="shade_partial" value="partial_shade" autocomplete="off">
                                    <label class="btn btn-outline-primary text-start" for="shade_partial">
                                        <i class="fas fa-umbrella-beach me-2"></i> Teduhan Separuh - Ada pokok tetapi tidak banyak
                                    </label>
                                    
                                    <input type="radio" class="btn-check" name="shade" id="shade_none" value="no_shade" autocomplete="off">
                                    <label class="btn btn-outline-primary text-start" for="shade_none">
                                        <i class="fas fa-sun me-2"></i> Tiada Teduhan - Kawasan terbuka sepenuhnya
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg py-3">
                                <i class="fas fa-search-location me-2"></i> Dapatkan Cadangan Pusara
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-group-vertical .btn {
        text-align: left;
        padding: 0.75rem 1.25rem;
        margin-bottom: 0.5rem;
        border-radius: 0.5rem !important;
    }
    
    .btn-check:checked + .btn {
        background-color: #0d6efd;
        color: white;
    }
    
    .card-header {
        border-bottom: none;
    }
</style>
@endsection