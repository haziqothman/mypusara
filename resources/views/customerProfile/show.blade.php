@extends('layouts.navigation')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Profile Header -->
            <div class="d-flex align-items-center mb-4">
                <div class="me-3">
                    <div class="avatar avatar-xl bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <span class="fs-3">{{ substr($user->name, 0, 1) }}</span>
                    </div>
                </div>
                <div>
                    <h2 class="mb-0">{{ $user->name }}</h2>
                    <p class="text-muted mb-0">Ahli sejak {{ $user->created_at->format('F Y') }}</p>
                </div>
            </div>

            <!-- Profile Card -->
            <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-user-circle me-2"></i> Maklumat Profil anda</h5>
                </div>
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <tbody>
                                <!-- Basic Info -->
                                <tr class="border-bottom">
                                    <th class="ps-4 py-3" style="width: 35%;">
                                        <i class="fas fa-envelope me-2 text-primary"></i> E-mel
                                    </th>
                                    <td class="py-3">{{ $user->email }}</td>
                                </tr>
                                
                                @if ($user->phone)
                                <tr class="border-bottom">
                                    <th class="ps-4 py-3">
                                        <i class="fas fa-phone me-2 text-primary"></i> Nombor Telefon
                                    </th>
                                    <td class="py-3">{{ $user->phone }}</td>
                                </tr>
                                @endif
                                
                                <!-- Address Section -->
                                @if ($user->address || $user->postcode || $user->city)
                                <tr class="border-bottom">
                                    <th class="ps-4 py-3">
                                        <i class="fas fa-map-marker-alt me-2 text-primary"></i> Alamat
                                    </th>
                                    <td class="py-3">
                                        @if ($user->address)
                                            <div>{{ $user->address }}</div>
                                        @endif
                                        @if ($user->postcode || $user->city)
                                            <div class="text-muted small">
                                                {{ $user->postcode }} {{ $user->city }}
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @endif
                                
                                <!-- Identification -->
                                @if ($user->identification_card)
                                <tr class="border-bottom">
                                    <th class="ps-4 py-3">
                                        <i class="fas fa-id-card me-2 text-primary"></i> Kad Pengenalan
                                    </th>
                                    <td class="py-3">{{ $user->identification_card }}</td>
                                </tr>
                                @endif
                                
                                <!-- Membership -->
                                <tr>
                                    <th class="ps-4 py-3">
                                        <i class="fas fa-calendar-alt me-2 text-primary"></i> Tarikh Daftar
                                    </th>
                                    <td class="py-3">{{ $user->created_at->format('d F Y') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Card Footer with Actions -->
                <div class="card-footer bg-light border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ auth()->user()->type == 'admin' ? route('admin.home') : route('home') }}" 
                           class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
                        </a>
                        
                        <a href="{{ route('customerProfile.edit') }}" 
                           class="btn btn-primary px-4">
                            <i class="fas fa-edit me-1"></i> Edit Profile
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
        background-color: #0d6efd;
        color: white;
        font-weight: 600;
    }
    
    .table th {
        font-weight: 500;
    }
    
    .card {
        border: none;
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
    }
    
    .card-header {
        border-bottom: none;
    }
</style>
@endsection