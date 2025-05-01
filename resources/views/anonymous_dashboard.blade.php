<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>myPusara Landing Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
    .center-container {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      padding: 30px 15px;
      text-align: center;
    }
    .search-container {
      width: 100%;
      max-width: 500px;
    }
    .footer {
      background-color: #343a40;
      color: white;
      padding: 20px 0;
      text-align: center;
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
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-light bg-white shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="{{ asset('avatars/1734019274.png') }}" alt="myPusara Logo">
    </a>
    <div>
      <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Log Masuk</a>
      <a href="{{ route('register') }}" class="btn btn-outline-success">Daftar</a>
    </div>
  </div>
</nav>

<!-- Main Center Content -->
<div class="center-container">
  <h2 class="text-secondary mb-3">Selamat datang ke myPusara</h2>
  <p class="mb-4">Cari maklumat pusara dengan mudah di sini.</p>
  <div class="search-container">
    <form action="{{ route('search.pusara') }}" method="GET">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Carian Pusara" name="search" required>
        <button class="btn btn-primary" type="submit">Carian</button>
      </div>
    </form>
  </div>
</div>

<!-- Footer -->
<footer class="footer mt-auto">
  <div class="container">
    <p class="mb-2">Perlukan bantuan? Hubungi kami di WhatsApp:</p>
    <a href="https://wa.me/6011111222233" class="whatsapp-btn" target="_blank">
      Hubungi kami di WhatsApp
    </a>
  </div>
</footer>

</body>
</html>
