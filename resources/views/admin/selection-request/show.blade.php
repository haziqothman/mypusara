<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permohonan #{{ $request->id }} | MyPusara</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 80px;
        }
        .navbar {
            height: 80px;
            background-color: white;
            box-shadow: 0px 7px 10px rgb(241, 241, 241);
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .badge-pending {
            background-color: #ffc107;
            color: #000;
        }
        .badge-processing {
            background-color: #0dcaf0;
            color: #fff;
        }
        .badge-completed {
            background-color: #198754;
            color: #fff;
        }
        .requirements-box {
            background-color: #f8f9fa;
            border-left: 4px solid #0d6efd;
            padding: 1rem;
            white-space: pre-wrap;
        }
        footer {
            background-color: white;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.home') }}">
                <img src="{{ asset('avatars/1734019274.png') }}" alt="Logo" width="80">
            </a>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.home') }}">Utama</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.display.package') }}">Tambah Pusara</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.bookings.index') }}">Tempahan Waris</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('admin.selection.requests') }}">Pemilihan Admin</a>
                    </li>
                </ul>

                <div class="dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('adminProfile.show') }}">Profil Saya</a></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Log Keluar
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card shadow mb-4">
                    <div class="card-header bg-white border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="mb-0">Permohonan #{{ $request->id }}</h3>
                            <span class="badge 
                                @if($request->status == 'pending') badge-pending
                                @elseif($request->status == 'processing') badge-processing
                                @else badge-completed @endif">
                                {{ ucfirst($request->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-user me-2"></i>Maklumat Pelanggan</h5>
                        <div class="ps-4 mb-4">
                            <p><strong>Nama:</strong> {{ $request->user->name }}</p>
                            <p><strong>Email:</strong> {{ $request->user->email }}</p>
                        </div>
                        
                        <hr>
                        
                        <h5 class="card-title mt-4"><i class="fas fa-list-check me-2"></i>Keperluan Pelanggan</h5>
                        <div class="requirements-box mb-4">
                            {{ $request->requirements }}
                        </div>
                        
                        @if($request->status == 'completed')
                        <hr>
                        <h5 class="card-title mt-4"><i class="fas fa-archive me-2"></i>Pusara Yang Dipilih</h5>
                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <h5>{{ $request->package->pusaraNo }}</h5>
                                <p class="mb-1"><strong>Lokasi:</strong> {{ $request->package->section }}</p>
                                <p class="mb-1"><strong>Status:</strong> {{ $request->package->status }}</p>
                                <p>{{ $request->package->packageDesc }}</p>
                            </div>
                        </div>
                        
                        <h5 class="card-title"><i class="fas fa-note-sticky me-2"></i>Catatan Admin</h5>
                        <div class="requirements-box">
                            {{ $request->admin_notes ?? 'Tiada catatan' }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            @if($request->status != 'completed')
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-header bg-white border-0">
                        <h4 class="mb-0"><i class="fas fa-check-circle me-2"></i>Pilih Pusara</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.selection.select.package', $request->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="package_id" class="form-label">Pusara</label>
                                <select class="form-select" id="package_id" name="package_id" required>
                                    <option value="">-- Pilih Pusara --</option>
                                    @foreach($packages as $package)
                                    <option value="{{ $package->id }}">
                                        {{ $package->pusaraNo }} ({{ $package->section }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="admin_notes" class="form-label">Catatan</label>
                                <textarea class="form-control" id="admin_notes" name="admin_notes" rows="3"
                                    placeholder="Berikan penjelasan mengapa pusara ini dipilih..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-check me-1"></i> Sahkan Pilihan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Footer -->
    <footer class="py-3 mt-5 border-top">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <div class="col-md-4 d-flex align-items-center">
                    <span class="mb-3 mb-md-0 text-muted">© 2025 Mypusara, Inc</span>
                </div>
                <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
                    <li class="ms-3"><a class="text-muted" href="#"><i class="fab fa-twitter"></i></a></li>
                    <li class="ms-3"><a class="text-muted" href="#"><i class="fab fa-instagram"></i></a></li>
                    <li class="ms-3"><a class="text-muted" href="#"><i class="fab fa-facebook"></i></a></li>
                </ul>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>