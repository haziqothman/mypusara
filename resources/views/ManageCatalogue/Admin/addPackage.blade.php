@extends('layouts.navigation')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Pusara Baru</h1>
        <a href="{{ route('admin.display.package') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Senarai
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary">
            <h6 class="m-0 font-weight-bold text-white">Maklumat Pusara</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.store.package') }}" enctype="multipart/form-data">
                @csrf
                
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pusaraNo" class="form-label">Nombor Lot Pusara <span class="text-danger">*</span></label>
                                <select class="form-select @error('pusaraNo') is-invalid @enderror" 
                                    id="pusaraNo" name="pusaraNo" required>
                                    <option value="" disabled selected>Pilih Nombor Lot</option>
                                     <option value="auto" {{ old('pusaraNo') == 'auto' ? 'selected' : '' }}>
                                        Jana Kod ({{ $nextAvailable['A'] }}/{{ $nextAvailable['B'] }}/{{ $nextAvailable['C'] }})
                                    </option>
                                    <option value="manual">Tambah Nombor Lot Manual</option>
                                    @foreach($availableLots as $lot)
                                        <option value="{{ $lot }}" {{ old('pusaraNo') == $lot ? 'selected' : '' }}>
                                            {{ $lot }}
                                        </option>
                                    @endforeach                
                                </select>
                                @error('pusaraNo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Manual Input Box (Hidden by default) -->
                       <div class="col-md-6" id="manualPusaraNoContainer" style="display: none;">
                            <div class="mb-3">
                                <label for="manualPusaraNo" class="form-label">Nombor Lot Manual <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('manualPusaraNo') is-invalid @enderror" 
                                    id="manualPusaraNo" name="manualPusaraNo" value="{{ old('manualPusaraNo') }}"
                                    pattern="[A-Z][0-9]{3}" title="Format: Huruf Besar diikuti 3 digit nombor (Contoh: A123, B045, Z999)"
                                    oninput="this.value = this.value.toUpperCase()">
                                @error('manualPusaraNo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Format: Huruf Besar diikuti 3 digit nombor (Contoh: A123, B045, Z999)</small>
                            </div>
                        </div>
                                    
                   <div class="col-md-6">
                        <div class="mb-3">
                            <label for="section" class="form-label">Kawasan <span class="text-danger">*</span></label>
                            <select class="form-select @error('section') is-invalid @enderror" 
                                    id="section" name="section" required>
                                <option value="" disabled selected>Pilih Kawasan</option>
                                <option value="section_A" {{ old('section') == 'section_A' ? 'selected' : '' }}>
                                    Area Pintu Masuk (A)
                                </option>
                                <option value="section_B" {{ old('section') == 'section_B' ? 'selected' : '' }}>
                                    Area Tandas dan stor (B)
                                </option>
                                <option value="section_C" {{ old('section') == 'section_C' ? 'selected' : '' }}>
                                    Area pintu Belakang (C)
                                </option>
                            </select>
                            @error('section')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="" disabled selected>Pilih Status</option>
                                <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="tidak_tersedia" {{ old('status') == 'tidak_tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                                <option value="dalam_penyelanggaraan" {{ old('status') == 'dalam_penyelanggaraan' ? 'selected' : '' }}>Dalam Penyelenggaraan</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                <div class="mb-4">
                    <label for="packageDesc" class="form-label">Keterangan Pusara <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('packageDesc') is-invalid @enderror" 
                              id="packageDesc" name="packageDesc" rows="4" required>{{ old('packageDesc') }}</textarea>
                    @error('packageDesc')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="latitude" class="form-label">Latitude</label>
                            <input type="number" step="any" class="form-control @error('latitude') is-invalid @enderror" 
                                id="latitude" name="latitude" value="{{ old('latitude') }}">
                            @error('latitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="longitude" class="form-label">Longitude</label>
                            <input type="number" step="any" class="form-control @error('longitude') is-invalid @enderror" 
                                id="longitude" name="longitude" value="{{ old('longitude') }}">
                            @error('longitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- MCDM Criteria Section -->
                <div class="card mb-4 border-primary">
                    <div class="card-header bg-light">
                        <h5 class="mb-0 text-primary">
                            <i class="fas fa-star me-2"></i>Kriteria 
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="proximity_rating" class="form-label">Kedekatan dengan Pintu Masuk <span class="text-danger">*</span></label>
                                    <select class="form-select" id="proximity_rating" name="proximity_rating" required>
                                        @foreach($mcdmOptions['proximity'] as $value => $label)
                                            <option value="{{ $value }}" {{ old('proximity_rating') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="accessibility_rating" class="form-label">Kemudahan Akses <span class="text-danger">*</span></label>
                                    <select class="form-select" id="accessibility_rating" name="accessibility_rating" required>
                                        @foreach($mcdmOptions['accessibility'] as $value => $label)
                                            <option value="{{ $value }}" {{ old('accessibility_rating') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="pathway_condition" class="form-label">Keadaan Laluan <span class="text-danger">*</span></label>
                                    <select class="form-select" id="pathway_condition" name="pathway_condition" required>
                                        @foreach($mcdmOptions['pathway'] as $value => $label)
                                            <option value="{{ $value }}" {{ old('pathway_condition') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="soil_condition" class="form-label">Keadaan Tanah <span class="text-danger">*</span></label>
                                    <select class="form-select" id="soil_condition" name="soil_condition" required>
                                        @foreach($mcdmOptions['soil'] as $value => $label)
                                            <option value="{{ $value }}" {{ old('soil_condition') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="drainage_rating" class="form-label">Sistem Saliran <span class="text-danger">*</span></label>
                                    <select class="form-select" id="drainage_rating" name="drainage_rating" required>
                                        @foreach($mcdmOptions['drainage'] as $value => $label)
                                            <option value="{{ $value }}" {{ old('drainage_rating') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="shade_coverage" class="form-label">Perlindungan Teduhan <span class="text-danger">*</span></label>
                                    <select class="form-select" id="shade_coverage" name="shade_coverage" required>
                                        @foreach($mcdmOptions['shade'] as $value => $label)
                                            <option value="{{ $value }}" {{ old('shade_coverage') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="reset" class="btn btn-outline-secondary">
                        <i class="fas fa-undo me-2"></i>Set Semula
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Pusara
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pusaraNoSelect = document.getElementById('pusaraNo');
        const manualContainer = document.getElementById('manualPusaraNoContainer');
        const manualInput = document.getElementById('manualPusaraNo');
        
        function handlePusaraNoChange() {
            if (pusaraNoSelect.value === 'manual') {
                manualContainer.style.display = 'block';
                manualInput.setAttribute('required', 'required');
                // Clear any auto-generated value
                if (pusaraNoSelect.querySelector('option[value="auto"]').selected) {
                    pusaraNoSelect.querySelector('option[value=""]').selected = true;
                }
            } else {
                manualContainer.style.display = 'none';
                manualInput.removeAttribute('required');
            }
        }
        
        pusaraNoSelect.addEventListener('change', handlePusaraNoChange);
        
        // Initialize on page load
        handlePusaraNoChange();
        
        // Also handle form validation errors
        @if(old('pusaraNo') === 'manual')
            manualContainer.style.display = 'block';
            manualInput.setAttribute('required', 'required');
        @endif
    });
</script>
@endsection