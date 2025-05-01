@extends('layouts.navigation')

@section('content')
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-12 mt-5">
            <!-- Page Header with Actions -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-0 fw-bold text-primary">
                        <i class="fas fa-users me-2"></i> User Management
                    </h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Users</li>
                        </ol>
                    </nav>
                </div>
                
                @if(auth()->user()->type == 'admin')
                <div class="d-flex gap-2">
                    <a href="{{ route('adminProfile.show') }}" class="btn btn-outline-secondary rounded-circle" data-bs-toggle="tooltip" title="Back">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <a href="{{ route('adminProfile.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Add Admin
                    </a>
                </div>
                @endif
            </div>

            <!-- Users Card -->
            <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
                <div class="card-header bg-primary text-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-list-check me-2"></i> Users List
                        </h5>
                        <span class="badge bg-white text-primary">
                            {{ $users->count() }} {{ Str::plural('User', $users->count()) }}
                        </span>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    @if($users->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Users Found</h5>
                            <p class="text-muted">Start by adding new users to your system</p>
                            <a href="{{ route('adminProfile.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Add User
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">User</th>
                                        <th>Contact</th>
                                        <th>Location</th>
                                        <th>Role</th>
                                        <th class="text-end pe-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm bg-primary text-white rounded-circle me-3">
                                                    {{ substr($user->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $user->name }}</h6>
                                                    <small class="text-muted">{{ $user->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="d-block">{{ $user->phone }}</span>
                                                <small class="text-muted">{{ $user->identification_card }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="d-block">{{ $user->address }}</span>
                                                <small class="text-muted">{{ $user->postcode }} {{ $user->city }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge 
                                                @if($user->type == 'admin') bg-primary
                                                @else bg-secondary
                                                @endif">
                                                {{ ucfirst($user->type) }}
                                            </span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="d-flex gap-2 justify-content-end">
                                                <a href="{{ route('adminProfile.users.editUser', $user->id) }}" 
                                                   class="btn btn-sm btn-outline-primary rounded-circle action-btn"
                                                   data-bs-toggle="tooltip" title="Edit">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                
                                                <form action="{{ route('adminProfile.delete', $user->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-outline-danger rounded-circle action-btn"
                                                            data-bs-toggle="tooltip" title="Delete"
                                                            onclick="return confirm('Are you sure you want to delete this user?')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
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
    
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }
    
    .action-btn {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .card {
        border: none;
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
    }
    
    .badge {
        font-weight: 500;
        padding: 0.35em 0.65em;
    }
    
    .breadcrumb {
        font-size: 0.9rem;
        padding: 0;
        background: transparent;
    }
</style>

<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endsection