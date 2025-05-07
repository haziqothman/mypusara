<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>myPusara - @yield('title', 'Sistem Pengurusan Pusara')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background: #F8F9FA;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .navbar-brand img {
            width: 100px;
        }
        .footer {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
            text-align: center;
            margin-top: auto;
        }
        .whatsapp-btn {
            background-color: #25D366;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 50px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            display: inline-block;
        }
        .whatsapp-btn:hover {
            background-color: #128C7E;
        }
        main {
            flex: 1;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('landing') }}">
                <img src="{{ asset('avatars/1734019274.png') }}" alt="myPusara Logo">
            </a>
            <div>
                <a href="{{ route('login') }}" class="btn btn-outline-primary me-2"og Masuk</a>
                <a href="{{ route('register') }}" class="btn btn-outline-success">Daftar</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p class="mb-2">Perlukan bantuan? Hubungi kami di WhatsApp:</p>
            <a href="https://wa.me/6011111222233" class="whatsapp-btn" target="_blank">
                Hubungi kami di WhatsApp
            </a>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>