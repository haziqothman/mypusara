<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="{{ asset('images/pusara.png') }}" type="image/png">
  <title>MyPusara</title>
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
    .features-section {
      padding: 60px 0;
      background: #fff;
    }
    .feature-box {
      padding: 30px;
      border-radius: 10px;
      background: #fff;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      height: 100%;
    }
    .feature-box:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }
    .feature-icon {
      font-size: 2.5rem;
      margin-bottom: 20px;
      color: #4e73df;
    }
    .cta-section {
      background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
      color: white;
      padding: 40px 0;
      text-align: center;
    }
    .cta-btn {
    background: white;
    color: #224abe;
    font-weight: bold;
    padding: 12px 30px;
    border-radius: 50px;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem; /* optional: ensures spacing between icon and text */
    text-decoration: none;
  }

    .cta-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    }
    .section-title {
      position: relative;
      margin-bottom: 40px;
    }
    .section-title:after {
      content: '';
      display: block;
      width: 60px;
      height: 3px;
      background: #4e73df;
      margin: 15px auto;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-light bg-white shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('landing') }}">
      <img src="{{ asset('avatars/1734019274.png') }}" alt="myPusara Logo">
    </a>
    <div>
      <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Log Masuk</a>
      <a href="{{ route('register') }}" class="btn btn-primary">Daftar</a>
    </div>
  </div>
</nav>

<!-- Main Center Content -->
<div class="center-container">
  <div class="search-container">
    <form action="{{ route('search.bookings') }}" method="GET" class="w-100">
        <div class="input-group shadow-sm">
            <input type="text" class="form-control form-control-lg" 
                   placeholder="Carian Pusara (Nama Si Mati/No Sijil Kematian/No Pusara)..." 
                   name="search" required>
            <button class="btn btn-primary btn-lg" type="submit">
                <i class="fas fa-search"></i> Carian
            </button>
        </div>
        <small class="text-muted mt-2 d-block">
            <i class="fas fa-info-circle"></i> Hanya maklumat pusara yang telah dikebumikan sahaja akan dipaparkan
        </small>
    </form>
  </div>
</div>



<!-- Features Section -->
<section class="features-section">
  <div class="container">
    <h2 class="text-center section-title">Mengapa Pilih MyPusara?</h2>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="feature-box">
          <div class="feature-icon">
            <i class="fas fa-search-location"></i>
          </div>
          <h3>Cari Pusara</h3>
          <p>Sistem carian pintar membantu anda mencari maklumat pusara dengan pantas dan tepat menggunakan teknologi terkini.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-box">
          <div class="feature-icon">
            <i class="fas fa-calendar-check"></i>
          </div>
          <h3>Tempahan Online</h3>
          <p>Tempah pusara secara online tanpa perlu hadir ke pejabat. Proses mudah dan pantas dari rumah anda.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-box">
          <div class="feature-icon">
            <i class="fas fa-headset"></i>
          </div>
          <h3>Sokongan 24/7</h3>
          <p>Pasukan sokongan kami sedia membantu anda pada bila-bila masa melalui pelbagai saluran komunikasi.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
  <div class="container">
    <h2 class="mb-4">Bersedia untuk Mula?</h2>
    <p class="lead mb-5">Daftar akaun percuma hari ini dan nikmati kemudahan pengurusan pusara digital</p>
    <a href="{{ route('register') }}" class="cta-btn">
      <i class="fas fa-user-plus me-2"></i> Daftar Sekarang
    </a>
  </div>
</section>

<!-- Footer -->
<footer class="footer mt-auto">
  <div class="container">
    <div class="row">
      <div class="col-md-6 text-md-start mb-3 mb-md-0">
        <img src="{{ asset('avatars/1734019274.png') }}" alt="myPusara Logo" width="120" class="mb-3">
        <p class="mb-0">Platform pengurusan pusara digital pertama di Pahang</p>
      </div>
      <div class="col-md-6 text-md-end">
        <p class="mb-2">Perlukan bantuan? Hubungi kami di:</p>
        <a href="https://wa.me/6011111222233" class="whatsapp-btn" target="_blank">
          <i class="fab fa-whatsapp me-2"></i> WhatsApp
        </a>
      </div>
    </div>
    <hr class="mt-4 mb-4" style="border-color: rgba(255,255,255,0.1);">
    <p class="mb-0 small">&copy; 2025 myPusara. Hak Cipta Terpelihara.</p>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>