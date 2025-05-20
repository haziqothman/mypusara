@extends('layouts.navigation')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit me-2 text-primary"></i>Kemaskini Maklumat Pusara
        </h1>
        <a href="{{ route('admin.display.package') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Senarai
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-lg overflow-hidden mb-4">
        <div class="card-header text-primary py-3">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-tombstone-alt me-2"></i>Maklumat Pusara
            </h6>
        </div>
        <div class="card-body p-4">
            <form method="POST" action="{{ route('admin.update.package', $package->id) }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('PUT')
                
                <div class="row g-4">
                    <!-- First Column -->
                    <div class="col-md-6">
                        <!-- Pusara Number -->
                        <div class="form-group">
                            <label for="pusaraNo" class="form-label fw-bold text-dark">
                                <i class="fas fa-hashtag me-2 text-primary"></i>Nombor Lot Pusara <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('pusaraNo') is-invalid @enderror" 
                                   id="pusaraNo" name="pusaraNo" required>
                                <option value="" disabled>Pilih Nombor Lot</option>
                                <option value="manual" {{ old('pusaraNo') === 'manual' ? 'selected' : '' }}>
                                    Masukkan Nombor Manual
                                </option>
                                @foreach($allPossibleLots as $lot)
                                    @if(!in_array($lot, $usedLots) || old('pusaraNo', $package->pusaraNo) == $lot)
                                        <option value="{{ $lot }}" {{ old('pusaraNo', $package->pusaraNo) == $lot ? 'selected' : '' }}>
                                            {{ $lot }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('pusaraNo')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Manual Input Box -->
                        <div id="manualPusaraNoContainer" style="display: {{ old('pusaraNo') === 'manual' ? 'block' : 'none' }};">
                            <div class="form-group">
                                <label for="manualPusaraNo" class="form-label fw-bold text-dark">
                                    <i class="fas fa-keyboard me-2 text-primary"></i>Nombor Lot Manual <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('manualPusaraNo') is-invalid @enderror" 
                                    id="manualPusaraNo" name="manualPusaraNo" 
                                    value="{{ old('manualPusaraNo', $package->pusaraNo) }}"
                                    pattern="[A-Z][0-9]{3}" 
                                    title="Format: Huruf Besar diikuti 3 digit nombor (Contoh: A123, B045, Z999)"
                                    oninput="this.value = this.value.toUpperCase()">
                                @error('manualPusaraNo')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Format: Huruf Besar diikuti 3 digit nombor (Contoh: A123, B045, Z999)</small>
                            </div>
                        </div>

                        <!-- Section Selection -->
                        <div class="form-group">
                            <label for="section" class="form-label fw-bold text-dark">
                                <i class="fas fa-map-marked-alt me-2 text-primary"></i>Kawasan <span class="text-danger">*</span>
                            </label>
                            <select class="form-control select2 @error('section') is-invalid @enderror" 
                                    id="section" name="section" required>
                                <option value="" disabled>Pilih Kawasan</option>
                                <option value="section_A" {{ old('section', $package->section) == 'section_A' ? 'selected' : '' }}>
                                    <i class="fas fa-door-open me-2"></i>Area Pintu Masuk (A)
                                </option>
                                <option value="section_B" {{ old('section', $package->section) == 'section_B' ? 'selected' : '' }}>
                                    <i class="fas fa-toilet me-2"></i>Area Tandas dan Stor (B)
                                </option>
                                <option value="section_C" {{ old('section', $package->section) == 'section_C' ? 'selected' : '' }}>
                                    <i class="fas fa-door-closed me-2"></i>Area Pintu Belakang (C)
                                </option>
                            </select>
                            @error('section')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status Selection -->
                        <div class="form-group">
                            <label for="status" class="form-label fw-bold text-dark">
                                <i class="fas fa-info-circle me-2 text-primary"></i>Status <span class="text-danger">*</span>
                            </label>
                            <select class="form-control select2 @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="" disabled>Pilih Status</option>
                                <option value="tersedia" {{ old('status', $package->status) == 'tersedia' ? 'selected' : '' }}>
                                    <i class="fas fa-check-circle text-success me-2"></i>Tersedia
                                </option>
                                <option value="tidak_tersedia" {{ old('status', $package->status) == 'tidak_tersedia' ? 'selected' : '' }}>
                                    <i class="fas fa-times-circle text-danger me-2"></i>Tidak Tersedia
                                </option>
                                <option value="dalam_penyelanggaraan" {{ old('status', $package->status) == 'dalam_penyelanggaraan' ? 'selected' : '' }}>
                                    <i class="fas fa-tools text-warning me-2"></i>Dalam Penyelenggaraan
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Second Column -->
                    <div class="col-md-6">
                       
                        <!-- Coordinates -->
                        <div class="form-group">
                            <label for="latitude" class="form-label fw-bold text-dark">
                                <i class="fas fa-map-marker-alt me-2 text-primary"></i>Latitude
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white"><i class="fas fa-globe-asia"></i></span>
                                <input type="number" step="any" class="form-control @error('latitude') is-invalid @enderror" 
                                    id="latitude" name="latitude" value="{{ old('latitude', $package->latitude) }}" placeholder="3.1390">
                            </div>
                            @error('latitude')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="longitude" class="form-label fw-bold text-dark">
                                <i class="fas fa-map-marker-alt me-2 text-primary"></i>Longitude
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white"><i class="fas fa-globe-asia"></i></span>
                                <input type="number" step="any" class="form-control @error('longitude') is-invalid @enderror" 
                                    id="longitude" name="longitude" value="{{ old('longitude', $package->longitude) }}" placeholder="101.6869">
                            </div>
                            @error('longitude')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Description (Full Width) -->
                <div class="row">
                    <div class="col-12">
                        <div class="form-group mb-4">
                            <label for="packageDesc" class="form-label fw-bold text-dark">
                                <i class="fas fa-align-left me-2 text-primary"></i>Keterangan Pusara <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('packageDesc') is-invalid @enderror" 
                                      id="packageDesc" name="packageDesc" rows="4" required>{{ old('packageDesc', $package->packageDesc) }}</textarea>
                            @error('packageDesc')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- MCDM Criteria Section -->
                <div class="card shadow-sm border-0 rounded-lg mt-4">
                    <div class="card-header  text-primary py-3">
                        <h5 class="mb-0">
                            <i class="fas fa-star me-2"></i>Kriteria MCDM
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            @foreach([
                                ['id' => 'proximity_rating', 'label' => 'Kedekatan dengan Pintu Masuk', 'icon' => 'fa-door-open'],
                                ['id' => 'accessibility_rating', 'label' => 'Kemudahan Akses', 'icon' => 'fa-wheelchair'],
                                ['id' => 'pathway_condition', 'label' => 'Keadaan Laluan', 'icon' => 'fa-road'],
                                ['id' => 'soil_condition', 'label' => 'Keadaan Tanah', 'icon' => 'fa-mountain'],
                                ['id' => 'drainage_rating', 'label' => 'Sistem Saliran', 'icon' => 'fa-tint'],
                                ['id' => 'shade_coverage', 'label' => 'Perlindungan Teduhan', 'icon' => 'fa-umbrella-beach']
                            ] as $field)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="{{ $field['id'] }}" class="form-label fw-bold text-dark">
                                        <i class="fas {{ $field['icon'] }} me-2 text-primary"></i>{{ $field['label'] }} <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control select2" id="{{ $field['id'] }}" name="{{ $field['id'] }}" required>
                                        @foreach($mcdmOptions[str_replace('_rating', '', str_replace('_condition', '', str_replace('_coverage', '', $field['id'])))] as $value => $label)
                                            <option value="{{ $value }}" {{ old($field['id'], $package->{$field['id']}) == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex justify-content-between mt-5 pt-3 border-top">
                    <button type="reset" class="btn btn-outline-secondary px-4">
                        <i class="fas fa-undo me-2"></i>Set Semula
                    </button>
                    <button type="submit" class="btn btn-primary btn-gradient px-4">
                        <i class="fas fa-save me-2"></i>Kemaskini Pusara
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
    }
    .card {
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        border: none !important;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    .card-header {
        border-bottom: none !important;
    }
    .form-control, .form-select, .select2-selection {
        border: 1px solid #e0e0e0 !important;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        height: calc(2.25rem + 8px) !important;
        border-radius: 0.375rem !important;
    }
    .form-control:focus, .form-select:focus, .select2-selection:focus {
        border-color: #4e73df !important;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25) !important;
    }
    .btn-gradient {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
        border: none;
        color: white;
        transition: all 0.3s ease;
        box-shadow: 0 4px 8px rgba(78, 115, 223, 0.3);
    }
    .btn-gradient:hover {
        background: linear-gradient(135deg, #3a56b0 0%, #1a3bb5 100%) !important;
        transform: translateY(-1px);
        box-shadow: 0 6px 12px rgba(78, 115, 223, 0.4);
        color: white;
    }
    .btn-outline-primary {
        transition: all 0.3s ease;
    }
    .btn-outline-primary:hover {
        transform: translateY(-1px);
    }
    .file-upload-wrapper {
        position: relative;
        cursor: pointer;
        border: 2px dashed #e0e0e0 !important;
        transition: all 0.3s ease;
    }
    .file-upload-wrapper:hover {
        border-color: #4e73df !important;
        background-color: rgba(78, 115, 223, 0.05);
    }
    .select2-container--default .select2-selection--single {
        height: calc(2.25rem + 8px) !important;
        padding: 0.375rem 0.75rem !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: calc(2.25rem + 8px) !important;
    }
    .input-group-text {
        background-color: #f8f9fc;
        transition: all 0.3s ease;
    }
    .input-group:focus-within .input-group-text {
        background-color: #e9ecef;
    }
    label {
        margin-bottom: 0.5rem;
    }
    .form-text {
        font-size: 0.85rem;
    }
    .invalid-feedback {
        font-size: 0.85rem;
    }
    .was-validated .form-control:invalid, .form-control.is-invalid {
        border-color: #dc3545 !important;
        background-image: none;
        padding-right: 0.75rem;
    }
    .was-validated .form-control:valid, .form-control.is-valid {
        border-color: #28a745 !important;
        background-image: none;
        padding-right: 0.75rem;
    }
    .text-primary {
        color: #4e73df !important;
    }
    .border-primary {
        border-color: #4e73df !important;
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
/* All your original JavaScript remains exactly the same */
document.addEventListener('DOMContentLoaded', function() {
    const pusaraNoSelect = document.getElementById('pusaraNo');
    const manualContainer = document.getElementById('manualPusaraNoContainer');
    const manualInput = document.getElementById('manualPusaraNo');
    
    function handlePusaraNoChange() {
        if (pusaraNoSelect.value === 'manual') {
            manualContainer.style.display = 'block';
            manualInput.setAttribute('required', 'required');
            // Force uppercase and format
            manualInput.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
                // Auto-format to X999 pattern
                if (this.value.length > 0) {
                    let firstChar = this.value.charAt(0).replace(/[^A-Z]/g, '');
                    let numbers = this.value.substring(1).replace(/\D/g, '').substring(0, 3);
                    this.value = firstChar + numbers;
                }
            });
        } else {
            manualContainer.style.display = 'none';
            manualInput.removeAttribute('required');
        }
    }

    pusaraNoSelect.addEventListener('change', handlePusaraNoChange);
    
    // Initialize on page load if coming back with errors
    if (pusaraNoSelect.value === 'manual') {
        handlePusaraNoChange();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Select2
    $('.select2').select2({
        theme: 'bootstrap4',
        width: '100%'
    });

    // Manual input toggle
    const pusaraNoSelect = document.getElementById('pusaraNo');
    const manualContainer = document.getElementById('manualPusaraNoContainer');
    const manualInput = document.getElementById('manualPusaraNo');

    function handlePusaraNoChange() {
        if (pusaraNoSelect.value === 'manual') {
            manualContainer.style.display = 'block';
            manualInput.setAttribute('required', 'required');
            // Force uppercase and format
            manualInput.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
                // Auto-format to X999 pattern
                if (this.value.length > 0) {
                    let firstChar = this.value.charAt(0).replace(/[^A-Z]/g, '');
                    let numbers = this.value.substring(1).replace(/\D/g, '').substring(0, 3);
                    this.value = firstChar + numbers;
                }
            });
        } else {
            manualContainer.style.display = 'none';
            manualInput.removeAttribute('required');
        }
    }

    pusaraNoSelect.addEventListener('change', handlePusaraNoChange);
    
    // Initialize on page load if coming back with errors
    if (pusaraNoSelect.value === 'manual') {
        handlePusaraNoChange();
    }

    // Form validation
    (function() {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
    })();
});
</script>
@endsection