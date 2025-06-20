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
      max-width: 900px;
      width: 100%;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      border: none;
      display: flex;
    }

    .auth-form-section {
      flex: 1;
      padding: 0;
      background: white;
    }

    .auth-requirements-section {
      flex: 1;
      background: #f8fafc;
      padding: 2rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
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
    }

    .auth-title {
      font-weight: 600;
      color: var(--text-color);
      margin-bottom: 1.5rem;
      text-align: center;
    }

    .section-title {
      font-weight: 600;
      color: var(--primary-color);
      margin-bottom: 1.5rem;
      text-align: center;
      font-size: 1.5rem;
    }

    .form-floating>label {
      color: #6c757d;
    }

    .form-control {
      padding: 1rem 1rem;
      border-radius: 8px;
      border: 1px solid #e0e0e0;
      padding-right: 2.5rem;
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
      width: 100%;
    }

    .btn-auth:hover {
      background: var(--primary-hover);
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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

    /* Password Strength Meter */
    .password-strength-container {
      margin-top: 0.5rem;
    }

    .strength-meter {
      display: flex;
      align-items: center;
      margin-bottom: 0.5rem;
    }

    .strength-label {
      font-size: 0.875rem;
      font-weight: 500;
      color: #374151;
      margin-right: 0.5rem;
    }

    .strength-value {
      font-size: 0.875rem;
      font-weight: 600;
    }

    .strength-bar {
      width: 100%;
      height: 0.5rem;
      background-color: #e5e7eb;
      border-radius: 0.25rem;
      overflow: hidden;
    }

    .strength-progress {
      height: 100%;
      width: 0;
      transition: width 0.3s ease, background-color 0.3s ease;
    }

    /* Password Requirements */
    .requirements-box {
      background-color: white;
      border-radius: 0.75rem;
      padding: 1.5rem;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .requirements-title {
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem;
      font-weight: 600;
      color: var(--primary-color);
      margin-bottom: 1rem;
    }

    .requirements-title i {
      margin-right: 0.5rem;
      font-size: 1.2rem;
    }

    .requirements-list {
      list-style-type: none;
      padding-left: 0;
      margin-bottom: 0;
    }

    .requirement-item {
      display: flex;
      align-items: center;
      font-size: 0.875rem;
      margin-bottom: 0.75rem;
      padding: 0.5rem;
      border-radius: 0.5rem;
      transition: all 0.2s ease;
    }

    .requirement-item:hover {
      background-color: #f8f9fa;
    }

    .requirement-item i {
      margin-right: 0.75rem;
      font-size: 0.9rem;
      width: 20px;
      text-align: center;
    }

    .requirement-met {
      color: #16a34a;
    }

    .requirement-unmet {
      color: #6b7280;
    }

    /* Password toggle button */
    .password-toggle-btn {
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

    .form-floating {
      position: relative;
    }

    /* Match error styling */
    .password-match-error {
      color: #dc3545;
      font-size: 0.875rem;
      margin-top: 0.25rem;
      display: none;
    }

    /* Alert styling */
    .alert {
      border-radius: 0.5rem;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      .auth-container {
        flex-direction: column;
        max-width: 450px;
      }
      
      .auth-requirements-section {
        order: -1;
        padding: 1.5rem;
      }
      
      .requirements-box {
        padding: 1rem;
      }
    }
  </style>
</head>
<body>
  <div class="container d-flex justify-content-center align-items-center min-vh-100 py-4">
    <div class="auth-container">
      <!-- Left side with form -->
      <div class="auth-form-section">
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

          <form method="POST" action="{{ route('register') }}" id="registrationForm">
            @csrf

            <!-- Honeypot field for spam protection -->
            <input type="text" name="honeypot" style="display:none;" value="">

            <div class="mb-3">
              <div class="form-floating">
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" placeholder="Full Name" 
                       value="{{ old('name') }}" required autofocus
                       pattern="^[a-zA-Z\s]{2,50}$"
                       title="Name should be 2-50 alphabetic characters">
                <label for="name"><i class="fas fa-user me-2"></i> Nama Penuh</label>
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
                       value="{{ old('email') }}" required
                       pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
                <label for="email"><i class="fas fa-envelope me-2"></i> Alamat Email</label>
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
                       oninput="checkPasswordStrength(this.value)"
                       pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!#%*?&])[A-Za-z\d@$!#%*?&]{8,}$">
                <label for="password"><i class="fas fa-lock me-2"></i> Kata Laluan</label>
                <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('password')">
                  <i class="fas fa-eye" id="togglePasswordIcon"></i>
                </button>
                @error('password')
                  <div class="invalid-feedback">
                    <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                  </div>
                @enderror
              </div>
              
              <!-- Password Strength Meter -->
              <div class="password-strength-container">
                <div class="strength-meter">
                  <span class="strength-label">Kekuatan Kata Laluan:</span>
                  <span class="strength-value" id="passwordStrengthText">Lemah</span>
                </div>
                <div class="strength-bar">
                  <div class="strength-progress" id="passwordStrengthBar"></div>
                </div>
              </div>
            </div>

            <div class="mb-4">
              <div class="form-floating">
                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                       id="password_confirmation" name="password_confirmation" 
                       placeholder="Confirm Password" required
                       oninput="checkPasswordMatch()">
                <label for="password_confirmation"><i class="fas fa-lock me-2"></i> Sahkan Kata Laluan</label>
                <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('password_confirmation')">
                  <i class="fas fa-eye" id="toggleConfirmPasswordIcon"></i>
                </button>
                <div class="password-match-error" id="passwordMatchError">
                  <i class="fas fa-exclamation-circle me-1"></i> Kata laluan tidak sepadan
                </div>
                @error('password_confirmation')
                  <div class="invalid-feedback">
                    <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                  </div>
                @enderror
              </div>
            </div>

            <button type="submit" class="btn btn-auth mb-3">
              <i class="fas fa-user-plus me-2"></i> Daftar Akaun
            </button>
          </form>

          <div class="auth-footer">
            Sudah mempunyai akaun? <a href="{{ route('login') }}" class="auth-link">Log Masuk</a>
          </div>
        </div>
      </div>
      
      <!-- Right side with password requirements -->
      <div class="auth-requirements-section">
        <h3 class="section-title">Keperluan Kata Laluan</h3>
        <div class="requirements-box">
          <div class="requirements-title">
            <i class="fas fa-shield-alt"></i>
            <span>Kata Laluan Anda Perlu:</span>
          </div>
          <ul class="requirements-list">
            <li class="requirement-item" id="reqLength">
              <i class="fas fa-circle requirement-unmet"></i>
              <span>Minimum 8 aksara</span>
            </li>
            <li class="requirement-item" id="reqUpper">
              <i class="fas fa-circle requirement-unmet"></i>
              <span>Sekurang-kurangnya satu huruf besar</span>
            </li>
            <li class="requirement-item" id="reqLower">
              <i class="fas fa-circle requirement-unmet"></i>
              <span>Sekurang-kurangnya satu huruf kecil</span>
            </li>
            <li class="requirement-item" id="reqNumber">
              <i class="fas fa-circle requirement-unmet"></i>
              <span>Sekurang-kurangnya satu nombor</span>
            </li>
            <li class="requirement-item" id="reqSpecial">
              <i class="fas fa-circle requirement-unmet"></i>
              <span>Sekurang-kurangnya satu aksara khas (@$!#%*?&)</span>
            </li>
          </ul>
        </div>
        
        <div class="mt-4 text-center">
          <i class="fas fa-info-circle text-primary me-2"></i>
          <small class="text-muted">Kata laluan anda akan disimpan dengan selamat</small>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Toggle password visibility
    function togglePasswordVisibility(fieldId) {
      const field = document.getElementById(fieldId);
      const icon = document.getElementById(fieldId === 'password' ? 'togglePasswordIcon' : 'toggleConfirmPasswordIcon');
      
      if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    }
    
    // Check password match
    function checkPasswordMatch() {
      const password = document.getElementById('password').value;
      const confirmPassword = document.getElementById('password_confirmation').value;
      const errorElement = document.getElementById('passwordMatchError');
      
      if (password !== confirmPassword && confirmPassword !== '') {
        errorElement.style.display = 'block';
        return false;
      } else {
        errorElement.style.display = 'none';
        return true;
      }
    }
    
    // Password strength checker
    function checkPasswordStrength(password) {
      const strengthBar = document.getElementById('passwordStrengthBar');
      const strengthText = document.getElementById('passwordStrengthText');
      
      // Reset requirements
      document.getElementById('reqLength').querySelector('i').className = 'fas fa-circle requirement-unmet';
      document.getElementById('reqUpper').querySelector('i').className = 'fas fa-circle requirement-unmet';
      document.getElementById('reqLower').querySelector('i').className = 'fas fa-circle requirement-unmet';
      document.getElementById('reqNumber').querySelector('i').className = 'fas fa-circle requirement-unmet';
      document.getElementById('reqSpecial').querySelector('i').className = 'fas fa-circle requirement-unmet';
      
      // Check requirements
      const hasLength = password.length >= 8;
      const hasUpper = /[A-Z]/.test(password);
      const hasLower = /[a-z]/.test(password);
      const hasNumber = /[0-9]/.test(password);
      const hasSpecial = /[@$!#%*?&]/.test(password);
      
      // Update requirement indicators
      if (hasLength) document.getElementById('reqLength').querySelector('i').className = 'fas fa-check-circle requirement-met';
      if (hasUpper) document.getElementById('reqUpper').querySelector('i').className = 'fas fa-check-circle requirement-met';
      if (hasLower) document.getElementById('reqLower').querySelector('i').className = 'fas fa-check-circle requirement-met';
      if (hasNumber) document.getElementById('reqNumber').querySelector('i').className = 'fas fa-check-circle requirement-met';
      if (hasSpecial) document.getElementById('reqSpecial').querySelector('i').className = 'fas fa-check-circle requirement-met';
      
      // Calculate strength
      let strength = 0;
      if (hasLength) strength += 20;
      if (hasUpper) strength += 20;
      if (hasLower) strength += 20;
      if (hasNumber) strength += 20;
      if (hasSpecial) strength += 20;
      
      // Update UI
      strengthBar.style.width = strength + '%';
      
      if (strength < 40) {
        strengthBar.style.backgroundColor = '#dc3545';
        strengthText.textContent = 'Lemah';
        strengthText.style.color = '#dc3545';
      } else if (strength < 80) {
        strengthBar.style.backgroundColor = '#ffc107';
        strengthText.textContent = 'Sederhana';
        strengthText.style.color = '#ffc107';
      } else {
        strengthBar.style.backgroundColor = '#28a745';
        strengthText.textContent = 'Kuat';
        strengthText.style.color = '#28a745';
      }
    }
    
    // Form submission handler
    document.getElementById('registrationForm').addEventListener('submit', function(e) {
      // Honeypot check
      const honeypot = document.querySelector('input[name="honeypot"]').value;
      if (honeypot !== '') {
        e.preventDefault();
        return false;
      }
      
      // Check password match
      if (!checkPasswordMatch()) {
        e.preventDefault();
        return false;
      }
      
      return true;
    });
    
    // Initialize password strength check if there's existing value
    document.addEventListener('DOMContentLoaded', function() {
      const passwordField = document.getElementById('password');
      if (passwordField.value) {
        checkPasswordStrength(passwordField.value);
      }
      
      // Check password match on load if there's a confirmation
      if (document.getElementById('password_confirmation').value) {
        checkPasswordMatch();
      }
    });
  </script>
</body>
</html>