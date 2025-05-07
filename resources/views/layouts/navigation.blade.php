<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('images/pusara.png') }}" type="image/png">
    <title>MyPusara</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <style>
        body {
            background-color: rgb(250, 250, 250);
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light"
        style="height: 80px; background-color:rgb(255, 255, 255); box-shadow: 0px 7px 10px rgb(241, 241, 241);">
        <!-- Updated logo with <a href="#"> -->
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
                    @if (Auth::user()->type == 'admin')
                        <a class="nav-link" href="{{ route('admin.display.package') }}"> Tambah Pusara</a>
                    @elseif (Auth::user()->type == 'customer')
                        <a class="nav-link" href="{{ route('customer.pusara.selection') }}"> Pusara</a>
                    @endif
                </li>
                <li class="nav-item">
                    @if (Auth::user()->type == 'admin')
                        <a class="nav-link" href="{{ route('admin.bookings.index')}}">Tempahan Waris</a>
                    @elseif (Auth::user()->type == 'customer')
                        <a class="nav-link" href="{{ route('ManageBooking.Customer.dashboardBooking') }}">Tempahan Anda</a>
                    @endif
                </li>
        
            </ul>
        </div>

        <a id="navbarDropdown" class="nav-link dropdown-toggle col-1" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            {{ Auth::user()->name }}
        </a>
        <div class="dropdown-menu dropdown-menu-end col-1" aria-labelledby="navbarDropdown">
            @if (Auth::user()->type === 'admin')
                <a href="{{ route('adminProfile.show') }}" class="dropdown-item">My Profile</a>
            @elseif (Auth::user()->type === 'customer')
                <a href="{{ route('customerProfile.show') }}" class="dropdown-item"> MyProfile</a>
            @endif
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
    @yield('content')

    {{-- Footer --}}
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
    @yield('scripts')
</body>

</html>
