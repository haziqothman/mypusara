<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - myPusara</title>
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
      padding-right: 2.5rem; /* Add padding for the eye icon */
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

    .password-strength {
      height: 5px;
      background: #e9ecef;
      border-radius: 3px;
      margin-top: 0.5rem;
      overflow: hidden;
    }

    .strength-meter {
      height: 100%;
      width: 0;
      transition: width 0.3s ease, background 0.3s ease;
    }

    .password-requirements {
      font-size: 0.8rem;
      color: #6c757d;
      margin-top: 0.5rem;
    }

    .requirement {
      display: flex;
      align-items: center;
      margin-bottom: 0.25rem;
    }

    .requirement i {
      margin-right: 0.5rem;
      font-size: 0.7rem;
    }

    .valid {
      color: #28a745;
    }

    .invalid {
      color: #dc3545;
    }

    /* Password toggle button styles */
    .password-toggle-btn {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #6c757d;
      z-index: 5;
    }

    .form-floating {
      position: relative;
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
        <h3 class="mb-0">Buat Akaun Baharu</h3>
      </div>
      <div class="auth-body">
        <h4 class="auth-title">Daftar untuk Mula Menggunakan myPusara</h4>

        @if(session('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
          @csrf

          <div class="mb-3">
            <div class="form-floating">
              <input type="text" class="form-control @error('name') is-invalid @enderror" 
                     id="name" name="name" placeholder="Full Name" 
                     value="{{ old('name') }}" required autofocus>
              <label for="name">Nama Penuh</label>
              @error('name')
                <div class="invalid-feedback">
                  <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                </div>
              @enderror
            </div>
          </div>

          <div class="mb-3">
            <div class="form-floating">
              <input type="email" class="form-control @error('email') is-invalid @enderror" 
                     id="email" name="email" placeholder="name@example.com" 
                     value="{{ old('email') }}" required>
              <label for="email">Alamat Email</label>
              @error('email')
                <div class="invalid-feedback">
                  <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                </div>
              @enderror
            </div>
          </div>

          <div class="mb-3">
            <div class="form-floating">
              <input type="password" class="form-control @error('password') is-invalid @enderror" 
                     id="password" name="password" placeholder="Password" required
                     oninput="checkPasswordStrength(this.value)">
              <label for="password">Kata Laluan</label>
              <button type="button" class="password-toggle-btn" onclick="togglePassword()">
                <i class="fas fa-eye" id="togglePasswordIcon"></i>
              </button>
              <div class="password-strength">
                <div class="strength-meter" id="strength-meter"></div>
              </div>
              <div class="password-requirements">
                <div class="requirement" id="length-req">
                  <i class="fas fa-circle"></i> Minimum 8 aksara
                </div>
                <div class="requirement" id="number-req">
                  <i class="fas fa-circle"></i> Mengandungi nombor
                </div>
                <div class="requirement" id="special-req">
                  <i class="fas fa-circle"></i> Mengandungi aksara khas
                </div>
              </div>
              @error('password')
                <div class="invalid-feedback">
                  <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                </div>
              @enderror
            </div>
          </div>

          <div class="mb-4">
            <div class="form-floating">
              <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                     id="password_confirmation" name="password_confirmation" 
                     placeholder="Confirm Password" required>
              <label for="password_confirmation">Sahkan Kata Laluan</label>
              <button type="button" class="password-toggle-btn" onclick="toggleConfirmPassword()">
                <i class="fas fa-eye" id="toggleConfirmPasswordIcon"></i>
              </button>
              @error('password_confirmation')
                <div class="invalid-feedback">
                  <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                </div>
              @enderror
            </div>
          </div>

          <button type="submit" class="btn btn-auth w-100 mb-3">
            <i class="fas fa-user-plus me-2"></i> Daftar Akaun
          </button>
        </form>

        <div class="auth-footer">
          Sudah mempunyai akaun? <a href="{{ route('login') }}" class="auth-link">Log Masuk</a>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function checkPasswordStrength(password) {
      const strengthMeter = document.getElementById('strength-meter');
      const lengthReq = document.getElementById('length-req');
      const numberReq = document.getElementById('number-req');
      const specialReq = document.getElementById('special-req');

      strengthMeter.style.width = '0%';
      strengthMeter.style.backgroundColor = '#dc3545';

      const hasLength = password.length >= 8;
      const hasNumber = /\d/.test(password);
      const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);

      updateRequirement(lengthReq, hasLength);
      updateRequirement(numberReq, hasNumber);
      updateRequirement(specialReq, hasSpecial);

      let strength = 0;
      if (hasLength) strength += 33;
      if (hasNumber) strength += 33;
      if (hasSpecial) strength += 34;

      strengthMeter.style.width = strength + '%';

      if (strength < 66) {
        strengthMeter.style.backgroundColor = '#dc3545';
      } else if (strength < 100) {
        strengthMeter.style.backgroundColor = '#ffc107';
      } else {
        strengthMeter.style.backgroundColor = '#28a745';
      }
    }

    function updateRequirement(element, isValid) {
      const icon = element.querySelector('i');
      if (isValid) {
        icon.classList.remove('fa-circle');
        icon.classList.add('fa-check-circle', 'valid');
        element.classList.add('valid');
        element.classList.remove('invalid');
      } else {
        icon.classList.remove('fa-check-circle', 'valid');
        icon.classList.add('fa-circle');
        element.classList.add('invalid');
        element.classList.remove('valid');
      }
    }

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

    function toggleConfirmPassword() {
      const confirmPasswordInput = document.getElementById('password_confirmation');
      const icon = document.getElementById('toggleConfirmPasswordIcon');

      if (confirmPasswordInput.type === 'password') {
        confirmPasswordInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        confirmPasswordInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    }
  </script>
</body>
</html>