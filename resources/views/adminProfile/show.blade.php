@extends('layouts.navigation')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            @if(auth()->user()->type == 'admin')
                <div class="d-flex justify-content-end mb-4">
                    <a href="{{ route('adminProfile.users') }}" class="btn btn-primary">
                        <i class="fas fa-users-cog me-2"></i> Manage Users
                    </a>
                </div>
            @endif

            <!-- Profile Card -->
            <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
                <!-- Card Header with User Avatar -->
                <div class="card-header bg-primary text-white py-4">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-xl bg-white text-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="mb-0">{{ $user->name }}</h3>
                            <p class="mb-0 opacity-75">{{ ucfirst($user->type) }} Account</p>
                        </div>
                    </div>
                </div>
                
                <!-- Card Body -->
                <div class="card-body p-4">
                    <div class="row">
                        <!-- Main Profile Info -->
                        <div class="col-md-6">
                            <div class="profile-info-item mb-4">
                                <h6 class="text-muted mb-2"><i class="fas fa-envelope me-2"></i> Email</h6>
                                <p class="mb-0">{{ $user->email }}</p>
                            </div>

                            @if($user->phone)
                            <div class="profile-info-item mb-4">
                                <h6 class="text-muted mb-2"><i class="fas fa-phone me-2"></i> Phone</h6>
                                <p class="mb-0">{{ $user->phone }}</p>
                            </div>
                            @endif

                            <div class="profile-info-item mb-4">
                                <h6 class="text-muted mb-2"><i class="fas fa-calendar-alt me-2"></i> Member Since</h6>
                                <p class="mb-0">{{ $user->created_at->format('F d, Y') }}</p>
                            </div>
                        </div>

                        <!-- Address Info -->
                        <div class="col-md-6">
                            @if($user->address || $user->postcode || $user->city)
                            <div class="profile-info-item mb-4">
                                <h6 class="text-muted mb-2"><i class="fas fa-map-marker-alt me-2"></i> Address</h6>
                                <p class="mb-0">
                                    {{ $user->address }}<br>
                                    {{ $user->postcode }} {{ $user->city }}
                                </p>
                            </div>
                            @endif

                            @if($user->company)
                            <div class="profile-info-item mb-4">
                                <h6 class="text-muted mb-2"><i class="fas fa-building me-2"></i> Company</h6>
                                <p class="mb-0">{{ $user->company }}</p>
                            </div>
                            @endif

                            @if($user->identification_card)
                            <div class="profile-info-item mb-4">
                                <h6 class="text-muted mb-2"><i class="fas fa-id-card me-2"></i> Identification</h6>
                                <p class="mb-0">{{ $user->identification_card }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-center gap-3 mt-4 pt-3 border-top">
                        <a href="{{ route('adminProfile.edit') }}" class="btn btn-primary px-4">
                            <i class="fas fa-user-edit me-2"></i> Edit Profile
                        </a>
                        <a href="{{ auth()->user()->type == 'admin' ? route('admin.home') : route('home') }}" class="btn btn-outline-secondary px-4">
                            <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }
    
    .profile-info-item {
        padding: 0.75rem;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
    }
    
    .profile-info-item:hover {
        background-color: #f8f9fa;
    }
    
    .card {
        border: none;
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
    }
    
    .card-header {
        border-bottom: none;
    }
    
    .btn-outline-secondary:hover {
        background-color: #f8f9fa;
    }
    
    .text-muted {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>
@endsection