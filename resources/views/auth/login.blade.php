<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - myPusara</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    :root {
      --primary-color: #4e73df;
      --primary-hover: #2e59d9;
      --secondary-color: #f8f9fa;
      --text-color: #5a5c69;
    }
    
    body {
      background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
      min-height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .auth-container {
      max-width: 2000px;
      width: 100%;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
      border: none;
      display: flex;
      height: 700px;
    }
    
    .auth-image {
      flex: 1.2;
      background: url('{{ asset("avatars/kubur1.jpeg") }}') center center;
      background-size: cover;
      position: relative;
      transition: all 0.5s ease;
    }
    
    .auth-image:hover {
      flex: 1.3;
    }
    
    .auth-image::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(135deg, rgba(78, 115, 223, 0.85) 0%, rgba(46, 89, 217, 0.8) 100%);
    }
    
    .auth-image-content {
      position: relative;
      z-index: 1;
      color: white;
      padding: 3rem;
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    
    .auth-image-content h2 {
      font-weight: 700;
      margin-bottom: 1.5rem;
      font-size: 2rem;
      text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    
    .auth-image-content p {
      opacity: 0.9;
      margin-bottom: 2.5rem;
      font-size: 1.1rem;
      line-height: 1.6;
    }
    
    .feature-list {
      list-style: none;
      padding: 0;
    }
    
    .feature-list li {
      margin-bottom: 1rem;
      font-size: 1rem;
      display: flex;
      align-items: center;
    }
    
    .feature-list i {
      margin-right: 0.8rem;
      font-size: 1.2rem;
      color: #fff;
      background: rgba(255,255,255,0.2);
      width: 30px;
      height: 30px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    .auth-form {
      flex: 1;
      max-width: 500px;
      background: white;
      display: flex;
      flex-direction: column;
    }
    
    .auth-header {
      background: var(--primary-color);
      color: white;
      padding: 1.8rem;
      text-align: center;
      position: relative;
    }
    
    .auth-logo {
      width: 140px;
      margin-bottom: 1rem;
      filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
    }
    
    .auth-body {
      padding: 2.5rem;
      flex: 1;
      display: flex;
      flex-direction: column;
    }
    
    .auth-title {
      font-weight: 600;
      color: var(--text-color);
      margin-bottom: 2rem;
      font-size: 1.5rem;
      text-align: center;
    }
    
    .form-floating>label {
      color: #6c757d;
      padding: 0.8rem 1rem;
    }
    
    .form-control {
      padding: 1rem 1rem;
      border-radius: 8px;
      border: 1px solid #e0e0e0;
      height: calc(3rem + 2px);
    }
    
    .form-control:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
    }
    
    .btn-auth {
      background: var(--primary-color);
      border: none;
      padding: 0.85rem;
      font-weight: 600;
      border-radius: 8px;
      transition: all 0.3s ease;
      font-size: 1.05rem;
      box-shadow: 0 4px 8px rgba(78, 115, 223, 0.3);
    }
    
    .btn-auth:hover {
      background: var(--primary-hover);
      transform: translateY(-2px);
      box-shadow: 0 6px 12px rgba(78, 115, 223, 0.35);
    }
    
    .auth-footer {
      text-align: center;
      margin-top: auto;
      padding-top: 1.5rem;
      color: var(--text-color);
    }
    
    .auth-link {
      color: var(--primary-color);
      text-decoration: none;
      font-weight: 500;
      transition: all 0.2s;
    }
    
    .auth-link:hover {
      text-decoration: underline;
      color: var(--primary-hover);
    }
    
    .close-btn {
      position: absolute;
      top: 20px;
      left: 20px;
      font-size: 1.5rem;
      color: white;
      background: transparent;
      border: none;
      opacity: 0.8;
      transition: all 0.3s;
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
    }
    
    .close-btn:hover {
      opacity: 1;
      background: rgba(255,255,255,0.1);
    }
    
    .password-toggle {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #6c757d;
      cursor: pointer;
      z-index: 5;
    }
    
    @media (max-width: 992px) {
      .auth-container {
        height: auto;
        max-width: 600px;
      }
      
      .auth-image {
        display: none;
      }
      
      .auth-form {
        max-width: 100%;
      }
    }
    
    /* Animation for form elements */
    .form-group {
      transition: transform 0.3s ease, opacity 0.3s ease;
    }
    
    .form-group:hover {
      transform: translateX(5px);
    }
  </style>
</head>
<body>
  <div class="container d-flex justify-content-center align-items-center min-vh-100 py-4">
    <div class="auth-container">
      <!-- Left side with beautiful image -->
      <div class="auth-image">
        <div class="auth-image-content">
          <h2>Memorial Digital Keluarga</h2>
          <p>Platform komprehensif untuk mengurus dan memperingati pusara keluarga dengan penuh hormat dan kemudahan.</p>
          <ul class="feature-list">
            <li><i class="fas fa-monument"></i> Rekod maklumat pusara lengkap</li>
            <li><i class="fas fa-calendar-check"></i> Peringatan tarikh penting</li>
            <li><i class="fas fa-map-marked-alt"></i> Lokasi tepat pusara keluarga</li>
            <li><i class="fas fa-users"></i> Kongsi dengan ahli keluarga</li>
          </ul>
        </div>
      </div>
      
      <!-- Right side with login form -->
      <div class="auth-form">
        <div class="auth-header">
          <button class="close-btn" onclick="window.location.href='{{ route('landing') }}'">
            <i class="fas fa-arrow-left"></i>
          </button>
          <img src="{{ asset('avatars/1734019274.png') }}" alt="myPusara Logo" class="auth-logo">
          <h3 class="mb-0">Selamat Datang Kembali</h3>
        </div>
        <div class="auth-body">
          <h4 class="auth-title">Log Masuk ke Akaun Anda</h4>
          
          @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif
          
          <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="mb-4 form-group">
              <div class="form-floating">
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       id="email" name="email" placeholder="name@example.com" 
                       value="{{ old('email') }}" required autofocus>
                <label for="email"><i class="fas fa-envelope me-2"></i>Alamat Email</label>
                @error('email')
                  <div class="invalid-feedback">
                    <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                  </div>
                @enderror
              </div>
            </div>
            
            <div class="mb-4 form-group position-relative">
              <div class="form-floating">
                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                      id="password" name="password" placeholder="Password" required>
                <label for="password"><i class="fas fa-lock me-2"></i>Kata Laluan</label>
                @error('password')
                  <div class="invalid-feedback">
                    <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                  </div>
                @enderror
              </div>
              <button type="button" class="password-toggle" onclick="togglePassword()">
                <i class="fas fa-eye" id="togglePasswordIcon"></i>
              </button>
            </div>

            <button type="submit" class="btn btn-auth w-100 mb-4 mt-2">
              <i class="fas fa-sign-in-alt me-2"></i> Log Masuk
            </button>
          </form>
          
          <div class="auth-footer">
            Belum ada akaun? <a href="{{ route('register') }}" class="auth-link">Daftar Sekarang</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <script>
    function togglePassword() {
      const passwordInput = document.getElementById('password');
      const icon = document.getElementById('togglePasswordIcon');
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        passwordInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>