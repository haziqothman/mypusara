<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Laravel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #F8F9FA;

      .close-btn {
      position: absolute;
      top: 10px;
      left: 10px;
      font-size: 1.5rem;
      color: #000;
      border: none;
      background: transparent;
    }
    }
  </style>
</head>
<body>

<section class="bg-light py-3 py-md-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
        <div class="card border-light rounded-3 shadow-sm">
          <div class="card-body p-3 p-md-4 p-xl-5">
            <button class="close-btn" onclick="window.location.href='{{ route('anonymous.dashboard') }}'">&times;</button>
            <div class="text-center mb-3">
              <a href="#">
                 <img src="{{ asset('avatars/1734019274.png') }}" alt="Logo" width="200">
              </a>
            </div>
            <h2 class="fs-6 fw-normal text-center text-secondary mb-4">Daftar Akaun Baharu</h2>
            <form method="POST" action="{{ route('register') }}">
              @csrf

              @if(session('error'))
                <div class="alert alert-danger" role="alert">
                  {{ session('error') }}
                </div>
              @endif

              <div class="mb-3">
                <div class="form-floating">
                  <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Full Name" required>
                  <label for="name">Nama Penuh</label>
                </div>
                @error('name')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>

              <div class="mb-3">
                <div class="form-floating">
                  <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="name@example.com" required>
                  <label for="email">Alamat Email</label>
                </div>
                @error('email')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>

              <div class="mb-3">
                <input type="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       name="password" 
                       placeholder="Kata Laluan" 
                       required>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
              </div>

              <div class="mb-3">
                <div class="form-floating">
                  <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required>
                  <label for="password_confirmation">Sahkan Kata Laluan</label>
                </div>
                @error('password_confirmation')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>

              <div class="d-grid my-3">
                <button type="submit" class="btn btn-primary btn-lg">Daftar</button>
              </div>

              <p class="text-center">Sudah mempunyai akaun? <a href="{{ route('login') }}" class="text-primary">Log Masuk</a></p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

</body>
</html>
