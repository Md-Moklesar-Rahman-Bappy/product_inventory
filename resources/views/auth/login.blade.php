<!DOCTYPE html>
<html lang="en">
<head>
  <title>SOCDS Project Admin - Login</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- SEO & Branding -->
  <meta name="description" content="Login to SOCDS Project Admin Dashboard">
  <meta name="author" content="SOCDS Team">
  <link rel="icon" href="{{ asset('favicon.ico') }}">

  <!-- Assets -->
  <link rel="stylesheet" href="{{ asset('index/vendor/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('index/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('index/vendor/animate/animate.css') }}">
  <link rel="stylesheet" href="{{ asset('index/vendor/select2/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('index/css/util.css') }}">
  <link rel="stylesheet" href="{{ asset('index/css/main.css') }}">
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

  <style>
    body {
      background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      overflow-x: hidden;
    }

    .login-wrapper {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .login-card {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(20px);
      border-radius: 16px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
      padding: 40px 30px;
      max-width: 420px;
      width: 100%;
      text-align: center;
      color: #fff;
      border: 1px solid rgba(255, 255, 255, 0.2);
      animation: fadeInUp 0.8s ease-out;
    }

    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .login-icon {
      width: 80px;
      margin-bottom: 20px;
      animation: pulse 2s infinite;
    }

    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.05); }
      100% { transform: scale(1); }
    }

    .login-title {
      font-size: 1.8rem;
      font-weight: 600;
      margin-bottom: 25px;
    }

    .form-group {
      position: relative;
      margin-bottom: 20px;
    }

    .form-control {
      padding: 12px 40px 12px 40px;
      border-radius: 8px;
      border: none;
      background-color: rgba(255, 255, 255, 0.95);
      color: #333;
      transition: box-shadow 0.3s ease, transform 0.2s ease;
    }

    .form-control:focus {
      box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.3);
      transform: scale(1.02);
      outline: none;
    }

    .form-icon {
      position: absolute;
      top: 50%;
      left: 15px;
      transform: translateY(-50%);
      color: #28a745;
      font-size: 1.1rem;
      z-index: 2;
    }

    .toggle-password {
      position: absolute;
      top: 50%;
      right: 15px;
      transform: translateY(-50%);
      cursor: pointer;
      color: #28a745;
      font-size: 1.1rem;
      z-index: 2;
      transition: color 0.3s ease;
    }

    .toggle-password:hover {
      color: #218838;
    }

    .btn-login {
      background: linear-gradient(135deg, #28a745, #218838);
      color: #fff;
      font-weight: 600;
      border: none;
      padding: 12px;
      border-radius: 8px;
      width: 100%;
      transition: transform 0.2s ease, box-shadow 0.3s ease;
    }

    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(40, 167, 69, 0.4);
    }

    .invalid-feedback {
      font-size: 0.875rem;
      margin-top: 5px;
      text-align: left;
      color: #ffc107;
    }

    footer {
      margin-top: 30px;
      font-size: 0.875rem;
      color: #eee;
    }
  </style>
</head>
<body>

  <div class="login-wrapper">
    <div class="login-card">

      <img src="{{ asset('index/images/img-01.png') }}" alt="User Icon" class="login-icon">

      <form method="POST" action="{{ route('login.action') }}" novalidate>
        @csrf

        <div class="login-title">Project Member Login</div>

        {{-- Flash Messages --}}
        @foreach (['success', 'error', 'message'] as $msg)
          @if(session()->has($msg))
            <div class="alert alert-{{ $msg === 'error' ? 'danger' : 'success' }}">
              {!! session($msg) !!}
            </div>
          @endif
        @endforeach

        {{-- Email --}}
        <div class="form-group">
          <i class="fa fa-envelope form-icon" aria-hidden="true"></i>
          <input
            type="email"
            name="email"
            class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email') }}"
            placeholder="Email"
            required
            autocomplete="email"
            aria-label="Email Address"
            aria-describedby="email-error"
          >
          @error('email')
            <div id="email-error" class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- Password --}}
        <div class="form-group">
          <i class="fa fa-lock form-icon" aria-hidden="true"></i>
          <input
            type="password"
            name="password"
            id="password"
            class="form-control @error('password') is-invalid @enderror"
            placeholder="Password"
            required
            autocomplete="current-password"
            aria-label="Password"
            aria-describedby="password-error"
          >
          <span class="toggle-password" onclick="togglePassword()" title="Show/Hide Password">
            <i class="fa fa-eye" id="eyeIcon"></i>
          </span>
          @error('password')
            <div id="password-error" class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn-login">LOGIN</button>
      </form>

      <footer>
        &copy; {{ date('Y') }} SOCDS Project. All rights reserved.
      </footer>

    </div>
  </div>

  <!-- Scripts -->
  <script src="{{ asset('index/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
  <script src="{{ asset('index/vendor/bootstrap/js/popper.js') }}"></script>
  <script src="{{ asset('index/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('index/vendor/select2/select2.min.js') }}"></script>
  <script src="{{ asset('index/vendor/tilt/tilt.jquery.min.js') }}"></script>
  <script src="{{ asset('index/js/main.js') }}"></script>

  <script>
    $(function () {
      $('.js-tilt').tilt({ scale: 1.1 });

      $('form').on('submit', function () {
        $('.btn-login')
          .prop('disabled', true)
          .html('<i class="fa fa-spinner fa-spin"></i> Logging in...');
      });

      setTimeout(() => {
        $('.alert-success').fadeOut('slow');
      }, 5000);
    });

    function togglePassword() {
      const passwordInput = document.getElementById('password');
      const eyeIcon = document.getElementById('eyeIcon');
      const isPassword = passwordInput.type === 'password';

      passwordInput.type = isPassword ? 'text' : 'password';
      eyeIcon.classList.toggle('fa-eye');
      eyeIcon.classList.toggle('fa-eye-slash');
    }
  </script>
</body>
</html>
