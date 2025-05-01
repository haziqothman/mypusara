@extends('layouts.navigation')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Page Header with Back Button -->
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('adminProfile.show') }}" class="btn btn-outline-secondary rounded-circle me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="mb-0">Edit Admin Profile</h2>
                    <p class="text-muted mb-0">Update your account information</p>
                </div>
            </div>

            <!-- Profile Edit Card -->
            <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-user-cog me-2"></i> Administrator Details</h5>
                </div>
                
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('adminProfile.update') }}" enctype="multipart/form-data" id="profileForm">
                        @csrf

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Personal Information Section -->
                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3"><i class="fas fa-user-tie me-2"></i> Personal Information</h6>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $user->name) }}" 
                                           placeholder="Full Name" required>
                                    <label for="name">Full Name</label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone', $user->phone) }}" 
                                           placeholder="Phone Number" required
                                           pattern="[0-9]{10,15}">
                                    <label for="phone">Phone Number</label>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">10-15 digits only</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('identification_card') is-invalid @enderror" 
                                           id="identification_card" name="identification_card" 
                                           value="{{ old('identification_card', $user->identification_card) }}" 
                                           placeholder="Identification Card" required
                                           pattern="[0-9]{12}">
                                    <label for="identification_card">Identification Card</label>
                                    @error('identification_card')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">12 digits without dashes</div>
                                </div>
                            </div>
                        </div>

                        <!-- Address Information Section -->
                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3"><i class="fas fa-map-marker-alt me-2"></i> Address Information</h6>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                           id="address" name="address" value="{{ old('address', $user->address) }}" 
                                           placeholder="Street Address" required>
                                    <label for="address">Street Address</label>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                           id="city" name="city" value="{{ old('city', $user->city) }}" 
                                           placeholder="City" required>
                                    <label for="city">City</label>
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('postcode') is-invalid @enderror" 
                                           id="postcode" name="postcode" value="{{ old('postcode', $user->postcode) }}" 
                                           placeholder="Postal Code" required
                                           pattern="[0-9]{5}">
                                    <label for="postcode">Postal Code</label>
                                    @error('postcode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">5 digits (e.g., 12345)</div>
                                </div>
                            </div>
                        </div>

                        <!-- Security Information Section -->
                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3"><i class="fas fa-lock me-2"></i> Change Password (Leave blank to keep current)</h6>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating position-relative">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password" placeholder="Password"
                                           minlength="8">
                                    <label for="password">New Password</label>
                                    <span class="position-absolute end-0 top-50 translate-middle-y pe-3" style="cursor: pointer;">
                                        <i class="far fa-eye-slash" id="togglePassword"></i>
                                    </span>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Minimum 8 characters</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating position-relative">
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                           id="password_confirmation" name="password_confirmation" 
                                           placeholder="Confirm Password">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <span class="position-absolute end-0 top-50 translate-middle-y pe-3" style="cursor: pointer;">
                                        <i class="far fa-eye-slash" id="toggleConfirmPassword"></i>
                                    </span>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                            <a href="{{ route('adminProfile.show') }}" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary px-4" id="submitBtn">
                                <i class="fas fa-save me-1"></i> Update Profile
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
        font-weight: 500;
    }
    
    .form-control:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        border-color: #86b7fe;
    }
    
    .invalid-feedback {
        display: block;
        font-size: 0.85rem;
    }
    
    .form-text {
        font-size: 0.8rem;
        color: #6c757d;
    }
    
    #togglePassword, #toggleConfirmPassword {
        color: #6c757d;
    }
    
    .btn-outline-secondary:hover {
        background-color: #f8f9fa;
    }
    
    .rounded-circle {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle password visibility
        const togglePassword = document.querySelector('#togglePassword');
        const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
        const password = document.querySelector('#password');
        const passwordConfirm = document.querySelector('#password_confirmation');
        
        if (togglePassword) {
            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        }
        
        if (toggleConfirmPassword) {
            toggleConfirmPassword.addEventListener('click', function() {
                const type = passwordConfirm.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordConfirm.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        }
        
        // Form submission loading state
        const form = document.getElementById('profileForm');
        const submitBtn = document.getElementById('submitBtn');
        
        if (form) {
            form.addEventListener('submit', function() {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Saving...';
            });
        }
    });
</script>
@endsection