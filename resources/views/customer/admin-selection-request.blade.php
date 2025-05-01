<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mohon Bantuan Admin | MyPusara</title>

    <!-- Fonts & CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f7fa;
            padding-top: 80px;
        }

        .navbar {
            height: 80px;
            background-color: #ffffff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.03);
        }

        .navbar-brand img {
            height: 60px;
        }

        .card {
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            border: none;
        }

        .card-header {
            border-radius: 16px 16px 0 0;
            background-color: #0069d9;
        }

        h4 {
            font-weight: 600;
        }

        textarea {
            min-height: 220px;
            resize: none;
        }

        .btn-primary {
            background-color: #0069d9;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .footer {
            background-color: #ffffff;
            box-shadow: 0 -1px 4px rgba(0,0,0,0.05);
        }

        .alert {
            border-radius: 8px;
        }

        .form-label {
            font-weight: 600;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('avatars/1734019274.png') }}" alt="Logo">
            </a>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Utama</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ route('customer.pusara.selection') }}">Pusara</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('ManageBooking.Customer.dashboardBooking') }}">Tempahan Anda</a></li>
                </ul>

                <div class="dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('customerProfile.show') }}">Profil Saya</a></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Log Keluar
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-8">
                <div class="card">
                    <div class="card-header text-white">
                        <h4 class="mb-0"><i class="fas fa-user-tie me-2"></i> Mohon Bantuan Admin Pilih Pusara</h4>
                    </div>
                    <div class="card-body p-4">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('admin.select.package.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="requirements" class="form-label">Butiran Keperluan Anda</label>
                                <textarea class="form-control" id="requirements" name="requirements" required
                                    placeholder="Sila nyatakan keperluan anda secara terperinci. Contoh:
- Jenis pusara yang diinginkan
- Bajet yang ditetapkan
- Lokasi pilihan
- Sebarang keperluan khusus"></textarea>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('customer.pusara.selection') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-1"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-1"></i> Hantar Permohonan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer py-3 mt-5 border-top">
        <div class="container d-flex flex-wrap justify-content-between align-items-center">
            <span class="text-muted">© 2025 MyPusara, Inc</span>
            <ul class="nav list-unstyled d-flex">
                <li class="ms-3"><a class="text-muted" href="#"><i class="fab fa-twitter"></i></a></li>
                <li class="ms-3"><a class="text-muted" href="#"><i class="fab fa-instagram"></i></a></li>
                <li class="ms-3"><a class="text-muted" href="#"><i class="fab fa-facebook"></i></a></li>
            </ul>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
