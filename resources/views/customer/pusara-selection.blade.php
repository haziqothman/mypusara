<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pemilihan Pusara | MyPusara</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: rgb(250, 250, 250);
        }
        .hover-effect {
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        .hover-effect:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }
        .icon-wrapper {
            transition: all 0.3s ease;
        }
        .card:hover .icon-wrapper {
            transform: scale(1.1);
        }
        .btn-lg {
            transition: all 0.3s ease;
        }
        .btn-lg:hover {
            transform: translateY(-2px);
        }
        .nav-link.active {
            font-weight: 600;
            color: #0d6efd !important;
        }
    </style>
</head>

<body>
    <!-- Navigation (copied from your existing layout) -->
    <nav class="navbar navbar-expand-lg navbar-light"
        style="height: 80px; background-color:rgb(255, 255, 255); box-shadow: 0px 7px 10px rgb(241, 241, 241);">
        <a class="navbar-brand ms-4" href="{{ Auth::user()->type == 'admin' ? route('admin.home') : (Auth::user()->type == 'customer' ? route('home') : route('guest.home')) }}">
            <a href="#">
                <img src="{{ asset('avatars/1734019274.png') }}" alt="Logo" width="80">
            </a>
        </a>

        <div class="collapse navbar-collapse ms-5" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        @if (Auth::check() && Auth::user()->type === 'admin')
                            <a class="nav-link" href="{{ route('admin.home') }}"> Utama</a>
                        @elseif (Auth::check() && Auth::user()->type === 'customer')
                            <a class="nav-link" href="{{ route('home') }}"> Utama</a>
                        @else
                            <a class="nav-link" href="{{ url('/') }}">Utama</a>
                        @endif
                    </li>
                </ul>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('customer.pusara.selection') }}"> Pusara</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('ManageBooking.Customer.dashboardBooking') }}">Tempahan Anda</a>
                </li>
               
            </ul>
        </div>

        <a id="navbarDropdown" class="nav-link dropdown-toggle col-1" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            {{ Auth::user()->name }}
        </a>
        <div class="dropdown-menu dropdown-menu-end col-1" aria-labelledby="navbarDropdown">
            <a href="{{ route('customerProfile.show') }}" class="dropdown-item"> MyProfile</a>
            <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </nav>

      <!-- Main Content -->
    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold text-dark">Pemilihan Pusara</h1>
            <p class="lead text-muted">Pilih cara anda ingin memilih pakej pusara</p>
        </div>

        <div class="row g-4">
            <!-- AI Recommendation Card -->
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-lg hover-effect">
                    <div class="card-body p-4 text-center">
                        <div class="icon-wrapper bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                            <i class="fas fa-robot text-primary fa-3x"></i>
                        </div>
                        <h3 class="card-title fw-bold mb-3">Cadangan Berasaskan AI</h3>
                        <p class="card-text text-muted mb-4">
                            Biarkan sistem pintar kami mencadangkan pakej pusara terbaik berdasarkan keperluan anda.
                        </p>
                        <a href="{{ route('mcdm.form') }}" class="btn btn-primary btn-lg px-4 py-2 rounded-pill">
                            Dapatkan Cadangan Peribadi <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Manual Selection Card -->
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-lg hover-effect">
                    <div class="card-body p-4 text-center">
                        <div class="icon-wrapper bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                            <i class="fas fa-search text-success fa-3x"></i>
                        </div>
                        <h3 class="card-title fw-bold mb-3">Lihat Semua Pilihan</h3>
                        <p class="card-text text-muted mb-4">
                            Terokai semua pakej pusara kami dan pilih yang paling sesuai untuk anda.
                        </p>
                        <a href="{{ route('customer.display.package') }}" class="btn btn-success btn-lg px-4 py-2 rounded-pill">
                            Lihat Semua Pusara <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- <div class="col-md-6 mx-auto">
            <div class="card h-100 border-0 shadow-lg hover-effect">
                <div class="card-body p-4 text-center">
                    <div class="icon-wrapper bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                        <i class="fas fa-user-tie text-warning fa-3x"></i>
                    </div>
                    <h3 class="card-title fw-bold mb-3">Admin Pilihkan Pusara Anda</h3>
                    <p class="card-text text-muted mb-4">
                        Biarkan pihak pengurusan memilihkan pakej pusara terbaik untuk anda berdasarkan maklumat anda.
                    </p>
                    <a href="{{ route('admin.select.package.request') }}" class="btn btn-warning btn-lg px-4 py-2 rounded-pill text-white">
                        Mohon Bantuan Admin <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div> -->
        </div>
    </div>


      

    <!-- Footer (copied from your existing layout) -->
    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
        <div class="col-md-4 d-flex align-items-center">
            <a href="/" class="mb-3 me-2 mb-md-0 text-muted text-decoration-none lh-1">
                <svg class="bi" width="30" height="24">
                    <use xlink:href="#bootstrap"></use>
                </svg>
            </a>
            <span class="mb-3 mb-md-0 text-muted">© 2025 Mypusara, Inc</span>
        </div>

        <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
            <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24">
                        <use xlink:href="#twitter"></use>
                    </svg></a></li>
            <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24">
                        <use xlink:href="#instagram"></use>
                    </svg></a></li>
            <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24">
                        <use xlink:href="#facebook"></use>
                    </svg></a></li>
        </ul>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>