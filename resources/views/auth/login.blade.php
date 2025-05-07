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
      max-width: 450px;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      border: none;
    }
    
    .auth-header {
      background: var(--primary-color);
      color: white;
      padding: 1.5rem;
      text-align: center;
      position: relative;
    }
    
    .auth-logo {
      width: 120px;
      margin-bottom: 1rem;
    }
    
    .auth-body {
      padding: 2rem;
      background: white;
    }
    
    .auth-title {
      font-weight: 600;
      color: var(--text-color);
      margin-bottom: 1.5rem;
    }
    
    .form-floating>label {
      color: #6c757d;
    }
    
    .form-control {
      padding: 1rem 1rem;
      border-radius: 8px;
      border: 1px solid #e0e0e0;
    }
    
    .form-control:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
    }
    
    .btn-auth {
      background: var(--primary-color);
      border: none;
      padding: 0.75rem;
      font-weight: 600;
      border-radius: 8px;
      transition: all 0.3s ease;
    }
    
    .btn-auth:hover {
      background: var(--primary-hover);
      transform: translateY(-2px);
    }
    
    .auth-footer {
      text-align: center;
      margin-top: 1.5rem;
      color: var(--text-color);
    }
    
    .auth-link {
      color: var(--primary-color);
      text-decoration: none;
      font-weight: 500;
    }
    
    .auth-link:hover {
      text-decoration: underline;
    }
    
    .close-btn {
      position: absolute;
      top: 15px;
      left: 15px;
      font-size: 1.5rem;
      color: white;
      background: transparent;
      border: none;
      opacity: 0.8;
      transition: opacity 0.3s;
    }
    
    .close-btn:hover {
      opacity: 1;
    }
    
    .divider {
      display: flex;
      align-items: center;
      margin: 1.5rem 0;
      color: #adb5bd;
    }
    
    .divider::before, .divider::after {
      content: "";
      flex: 1;
      border-bottom: 1px solid #dee2e6;
    }
    
    .divider::before {
      margin-right: 1rem;
    }
    
    .divider::after {
      margin-left: 1rem;
    }
    
    .social-btn {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 0.75rem;
      border-radius: 8px;
      font-weight: 500;
      margin-bottom: 0.75rem;
      transition: all 0.3s ease;
    }
    
    .social-btn i {
      margin-right: 0.5rem;
      font-size: 1.1rem;
    }
    
    .btn-google {
      background: #fff;
      color: #5a5c69;
      border: 1px solid #e0e0e0;
    }
    
    .btn-google:hover {
      background: #f8f9fa;
      border-color: #d1d3e2;
    }
    
    .btn-facebook {
      background: #3b5998;
      color: white;
    }
    
    .btn-facebook:hover {
      background: #344e86;
      color: white;
    }
  </style>
</head>
<body>
  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="auth-container">
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
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
        
        <form method="POST" action="{{ route('login') }}">
          @csrf
          
          <div class="mb-3">
            <div class="form-floating">
              <input type="email" class="form-control @error('email') is-invalid @enderror" 
                     id="email" name="email" placeholder="name@example.com" 
                     value="{{ old('email') }}" required autofocus>
              <label for="email">Alamat Email</label>
              @error('email')
                <div class="invalid-feedback">
                  <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                </div>
              @enderror
            </div>
          </div>
          
          <div class="mb-3 position-relative">
            <div class="form-floating">
              <input type="password" class="form-control @error('password') is-invalid @enderror" 
                    id="password" name="password" placeholder="Password" required>
              <label for="password">Kata Laluan</label>
              @error('password')
                <div class="invalid-feedback">
                  <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                </div>
              @enderror
            </div>
            <button type="button" class="btn btn-sm position-absolute end-0 top-50 translate-middle-y me-3 text-secondary" 
                    onclick="togglePassword()" tabindex="-1">
              <i class="fas fa-eye" id="togglePasswordIcon"></i>
            </button>
          </div>

          
          <!-- <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="remember" id="remember">
              <label class="form-check-label" for="remember">Ingat Saya</label>
            </div>
            <a href="{{ route('password.request') }}" class="auth-link">Lupa Kata Laluan?</a>
          </div> -->
          
          <button type="submit" class="btn btn-auth w-100 mb-3 mt-3">
            <i class="fas fa-sign-in-alt me-2"></i> Log Masuk
          </button>
          
        
        </form>
        
        <div class="auth-footer">
          Belum ada akaun? <a href="{{ route('register') }}" class="auth-link">Daftar Sekarang</a>
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