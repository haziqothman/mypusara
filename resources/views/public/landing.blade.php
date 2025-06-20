<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="{{ asset('images/pusara.png') }}" type="image/png">
  <title>MyPusara - Platform Pengurusan Pusara Digital</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary-color: #4e73df;
      --primary-hover: #2e59d9;
      --secondary-color: #f8f9fa;
      --text-color: #2d3748;
      --light-gray: #f7fafc;
      --dark-blue: #1a365d;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: var(--light-gray);
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      color: var(--text-color);
      line-height: 1.6;
    }

    .navbar {
      background: white;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
      padding: 15px 0;
    }

    .navbar-brand img {
      width: 120px;
      transition: transform 0.3s ease;
    }

    .navbar-brand:hover img {
      transform: scale(1.05);
    }

    .hero-section {
      background: linear-gradient(135deg, rgba(78, 115, 223, 0.95) 0%, rgba(26, 54, 93, 0.95) 100%), 
                  url('{{ asset("avatars/kubur1.jpeg") }}');
      background-size: cover;
      background-position: center;
      color: white;
      padding: 80px 0;
      text-align: center;
      position: relative;
    }

    .hero-content {
      max-width: 800px;
      margin: 0 auto;
      padding: 0 20px;
    }

    .hero-title {
      font-size: 2.8rem;
      font-weight: 700;
      margin-bottom: 20px;
      line-height: 1.2;
    }

    .hero-subtitle {
      font-size: 1.2rem;
      margin-bottom: 30px;
      opacity: 0.9;
    }

    .search-container {
      width: 100%;
      max-width: 800px;
      margin: 0 auto;
      position: relative;
      z-index: 10;
    }

    .search-form {
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
      border-radius: 50px;
      overflow: hidden;
    }

    .search-input {
      height: 60px;
      border: none;
      padding: 0 25px;
      font-size: 1.1rem;
    }

    .search-input:focus {
      box-shadow: none;
      border-color: var(--primary-color);
    }

    .search-btn {
      height: 60px;
      padding: 0 30px;
      font-size: 1.1rem;
      font-weight: 500;
      background: var(--primary-color);
      border: none;
      transition: all 0.3s ease;
    }

    .search-btn:hover {
      background: var(--primary-hover);
    }

    .search-note {
      margin-top: 15px;
      font-size: 0.9rem;
      color: rgba(255, 255, 255, 0.8);
    }

    .features-section {
      padding: 80px 0;
      background: white;
    }

    .section-title {
      font-weight: 700;
      color: var(--dark-blue);
      margin-bottom: 50px;
      position: relative;
      text-align: center;
    }

    .section-title:after {
      content: '';
      display: block;
      width: 80px;
      height: 4px;
      background: var(--primary-color);
      margin: 15px auto 0;
      border-radius: 2px;
    }

    .feature-box {
      padding: 40px 30px;
      border-radius: 12px;
      background: white;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
      height: 100%;
      text-align: center;
      border: 1px solid rgba(0, 0, 0, 0.03);
    }

    .feature-box:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
      border-color: rgba(78, 115, 223, 0.2);
    }

    .feature-icon {
      font-size: 2.8rem;
      margin-bottom: 25px;
      color: var(--primary-color);
      background: rgba(78, 115, 223, 0.1);
      width: 80px;
      height: 80px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      transition: all 0.3s ease;
    }

    .feature-box:hover .feature-icon {
      background: var(--primary-color);
      color: white;
      transform: rotate(10deg) scale(1.1);
    }

    .feature-title {
      font-weight: 600;
      margin-bottom: 15px;
      color: var(--dark-blue);
    }

    .feature-text {
      color: #4a5568;
    }

    .cta-section {
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--dark-blue) 100%);
      color: white;
      padding: 80px 0;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .cta-section:before {
      content: '';
      position: absolute;
      top: -50px;
      left: -50px;
      width: 200px;
      height: 200px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
    }

    .cta-section:after {
      content: '';
      position: absolute;
      bottom: -100px;
      right: -100px;
      width: 300px;
      height: 300px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
    }

    .cta-title {
      font-size: 2.2rem;
      font-weight: 700;
      margin-bottom: 20px;
    }

    .cta-text {
      font-size: 1.1rem;
      max-width: 600px;
      margin: 0 auto 40px;
      opacity: 0.9;
    }

    .cta-btn {
      background: white;
      color: var(--primary-color);
      font-weight: 600;
      padding: 15px 40px;
      border-radius: 50px;
      font-size: 1.1rem;
      transition: all 0.3s ease;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
      display: inline-flex;
      align-items: center;
      text-decoration: none;
      position: relative;
      z-index: 1;
    }

    .cta-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
      color: var(--primary-color);
    }

    .cta-btn i {
      margin-right: 10px;
    }

    .footer {
      background: var(--dark-blue);
      color: white;
      padding: 60px 0 30px;
    }

    .footer-logo {
      width: 140px;
      margin-bottom: 20px;
    }

    .footer-about {
      margin-bottom: 20px;
      opacity: 0.8;
    }

    .footer-title {
      font-weight: 600;
      margin-bottom: 20px;
      font-size: 1.1rem;
    }

    .footer-links {
      list-style: none;
      padding: 0;
    }

    .footer-links li {
      margin-bottom: 10px;
    }

    .footer-links a {
      color: rgba(255, 255, 255, 0.7);
      text-decoration: none;
      transition: all 0.3s ease;
    }

    .footer-links a:hover {
      color: white;
      padding-left: 5px;
    }

    .whatsapp-btn {
      background-color: #25D366;
      color: white;
      border: none;
      padding: 12px 25px;
      font-size: 1rem;
      border-radius: 50px;
      text-decoration: none;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      font-weight: 500;
      box-shadow: 0 5px 15px rgba(37, 211, 102, 0.3);
    }

    .whatsapp-btn:hover {
      background-color: #128C7E;
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(37, 211, 102, 0.4);
    }

    .whatsapp-btn i {
      margin-right: 8px;
      font-size: 1.2rem;
    }

    .social-links {
      display: flex;
      gap: 15px;
      margin-top: 20px;
    }

    .social-link {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 40px;
      height: 40px;
      background: rgba(255, 255, 255, 0.1);
      color: white;
      border-radius: 50%;
      transition: all 0.3s ease;
    }

    .social-link:hover {
      background: var(--primary-color);
      transform: translateY(-3px);
    }

    .copyright {
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      padding-top: 30px;
      margin-top: 40px;
      text-align: center;
      opacity: 0.7;
      font-size: 0.9rem;
    }

    @media (max-width: 768px) {
      .hero-title {
        font-size: 2rem;
      }
      
      .hero-subtitle {
        font-size: 1rem;
      }
      
      .search-input {
        height: 50px;
        font-size: 1rem;
      }
      
      .search-btn {
        height: 50px;
        padding: 0 20px;
      }
      
      .feature-box {
        padding: 30px 20px;
      }
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light sticky-top">
  <div class="container">
    <a class="navbar-brand" href="{{ route('landing') }}">
      <img src="{{ asset('avatars/1734019274.png') }}" alt="myPusara Logo">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Log Masuk</a>
        </li>
        <li class="nav-item">
          <a href="{{ route('register') }}" class="btn btn-primary">Daftar</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<section class="hero-section">
  <div class="container">
    <div class="hero-content">
      <h1 class="hero-title">Platform Pengurusan Pusara Digital</h1>
      <p class="hero-subtitle">Memudahkan pencarian dan pengurusan maklumat pusara keluarga anda dengan teknologi terkini</p>
      
      <div class="search-container">
        <form action="{{ route('search.bookings') }}" method="GET" class="search-form">
          <div class="input-group">
            <input type="text" class="form-control search-input" 
                   placeholder="Carian Pusara (Nama Si Mati/No Pusara/No khairat Kematian)..." 
                   name="search" required>
            <button class="btn search-btn" type="submit">
              <i class="fas fa-search me-2"></i> Carian
            </button>
          </div>
        </form>
        <p class="search-note">
          <i class="fas fa-info-circle"></i> Hanya maklumat pusara yang telah dikebumikan sahaja akan dipaparkan
        </p>
      </div>
    </div>
  </div>
</section>

<!-- Features Section -->
<section class="features-section">
  <div class="container">
    <h2 class="section-title">Mengapa Pilih MyPusara?</h2>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="feature-box">
          <div class="feature-icon">
            <i class="fas fa-search-location"></i>
          </div>
          <h3 class="feature-title">Cari Pusara</h3>
          <p class="feature-text">Sistem carian pintar membantu anda mencari maklumat pusara dengan pantas dan tepat menggunakan teknologi terkini.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-box">
          <div class="feature-icon">
            <i class="fas fa-calendar-check"></i>
          </div>
          <h3 class="feature-title">Tempahan Online</h3>
          <p class="feature-text">Tempah pusara secara online tanpa perlu hadir ke pejabat. Proses mudah dan pantas dari rumah anda.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-box">
          <div class="feature-icon">
            <i class="fas fa-headset"></i>
          </div>
          <h3 class="feature-title">Sokongan 24/7</h3>
          <p class="feature-text">Pasukan sokongan kami sedia membantu anda pada bila-bila masa melalui pelbagai saluran komunikasi.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
  <div class="container">
    <h2 class="cta-title">Bersedia untuk Mula?</h2>
    <p class="cta-text">Daftar akaun percuma hari ini dan nikmati kemudahan pengurusan pusara digital yang lebih efisien dan teratur.</p>
    <a href="{{ route('register') }}" class="cta-btn">
      <i class="fas fa-user-plus me-2"></i> Daftar Sekarang
    </a>
  </div>
</section>

<!-- Footer -->
<footer class="footer">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 mb-5 mb-lg-0">
        <img src="{{ asset('avatars/1734019274.png') }}" alt="myPusara Logo" class="footer-logo">
        <p class="footer-about">Platform pengurusan pusara digital pertama di Pahang yang menyediakan penyelesaian lengkap untuk pengurusan maklumat pusara.</p>
        <a href="https://wa.me/6011111222233" class="whatsapp-btn" target="_blank">
          <i class="fab fa-whatsapp"></i> WhatsApp Kami
        </a>
      </div>
      <div class="col-lg-2 col-md-6 mb-4 mb-md-0">
        <h4 class="footer-title">Pautan Pantas</h4>
        <ul class="footer-links">
          <li><a href="{{ route('landing') }}">Laman Utama</a></li>
          <li><a href="{{ route('login') }}">Log Masuk</a></li>
          <li><a href="{{ route('register') }}">Daftar Akaun</a></li>
          <li><a href="#">Carian Pusara</a></li>
        </ul>
      </div>
      <div class="col-lg-2 col-md-6 mb-4 mb-md-0">
        <h4 class="footer-title">Perkhidmatan</h4>
        <ul class="footer-links">
          <li><a href="#">Tempahan Pusara</a></li>
          <li><a href="#">Pengurusan Pusara</a></li>
          <li><a href="#">Panduan Pengguna</a></li>
          <li><a href="#">Soalan Lazim</a></li>
        </ul>
      </div>
      <div class="col-lg-4 col-md-6">
        <h4 class="footer-title">Hubungi Kami</h4>
        <ul class="footer-links">
          <li><i class="fas fa-map-marker-alt me-2"></i> Masjid Saidina Othman Ibnu Affan,25150 Kuantan, Pahang</li>
          <li><i class="fas fa-phone-alt me-2"></i> +603-1234 5678</li>
          <li><i class="fas fa-envelope me-2"></i> info@mypusara.com</li>
        </ul>
        <div class="social-links">
          <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
          <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
          <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
        </div>
      </div>
    </div>
    <div class="copyright">
      &copy; {{ date('Y') }} MyPusara. Hak Cipta Terpelihara.
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>