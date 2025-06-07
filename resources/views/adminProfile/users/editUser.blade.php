@extends('layouts.navigation')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Page Header with Back Button -->
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('adminProfile.users.index') }}" class="btn btn-outline-secondary me-3 rounded-circle">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h4 class="mb-0">Edit Profil Pengguna</h4>
                    <p class="text-muted mb-0">Kemas kini maklumat pengguna di bawah</p>
                </div>
            </div>

            <!-- User Edit Card -->
            <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-user-edit me-2"></i> Edit Maklumat Pengguna</h5>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('adminProfile.updateUser', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Personal Information Section -->
                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3"><i class="fas fa-user-tie me-2"></i> Maklumat Peribadi</h6>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $user->name) }}" 
                                           placeholder="Full Name" required>
                                    <label for="name">Nama Penuh</label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', $user->email) }}" 
                                           placeholder="Email Address" required>
                                    <label for="email">Alamat E-mel</label>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone', $user->phone) }}" 
                                           placeholder="Phone Number">
                                    <label for="phone">Nombor Telefon</label>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('identification_card') is-invalid @enderror" 
                                           id="identification_card" name="identification_card" 
                                           value="{{ old('identification_card', $user->identification_card) }}" 
                                           placeholder="Identification Card">
                                    <label for="identification_card">Kad Pengenalan</label>
                                    @error('identification_card')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Address Information Section -->
                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3"><i class="fas fa-map-marker-alt me-2"></i> Maklumat Alamat</h6>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                           id="address" name="address" value="{{ old('address', $user->address) }}" 
                                           placeholder="Street Address">
                                    <label for="address">Alamat</label>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                           id="city" name="city" value="{{ old('city', $user->city) }}" 
                                           placeholder="City">
                                    <label for="city">Bandar</label>
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('postcode') is-invalid @enderror" 
                                           id="postcode" name="postcode" value="{{ old('postcode', $user->postcode) }}" 
                                           placeholder="Postal Code">
                                    <label for="postcode">Poskod</label>
                                    @error('postcode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                            <a href="{{ route('adminProfile.users.index') }}" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-1"></i> Kemas Kini Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border: none;
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
    }
    
    .card-header {
        border-bottom: none;
    }
    
    .form-floating label {
        color: #6c757d;
    }
    
    .form-control:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }
    
    .invalid-feedback {
        display: block;
    }
    
    .rounded-circle {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endsection