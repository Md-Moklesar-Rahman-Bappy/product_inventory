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
  <link rel="stylesheet" href="{{ asset('index/vendor/css-hamburgers/hamburgers.min.css') }}">
  <link rel="stylesheet" href="{{ asset('index/vendor/select2/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('index/css/util.css') }}">
  <link rel="stylesheet" href="{{ asset('index/css/main.css') }}">
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

  <style>
    .container-login100 {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding-top: 0 !important;
    }
    .wrap-login100 {
      padding: 40px 55px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
      border-radius: 10px;
      background-color: #fff;
    }
    .login100-form-title {
      margin-bottom: 25px;
    }
    footer {
      margin-top: 30px;
      text-align: center;
      font-size: 0.875rem;
      color: #aaa;
    }
  </style>
</head>
<body>

  <div class="limiter">
    <div class="container-login100">
      <div class="wrap-login100">
        <div class="login100-pic js-tilt" data-tilt>
          <img src="{{ asset('index/images/img-01.png') }}" alt="Login Illustration" class="img-fluid">
        </div>

        <form class="login100-form validate-form" method="POST" action="{{ route('login.action') }}" novalidate role="form" aria-label="Login Form">
          @csrf

          <span class="login100-form-title">Project Member Login</span>

          {{-- Flash Messages --}}
          @foreach (['success', 'error', 'message'] as $msg)
            @if (session($msg))
              <div class="alert alert-{{ $msg === 'error' ? 'danger' : 'success' }} w-100 text-center">
                {!! session($msg) !!}
              </div>
            @endif
          @endforeach

          {{-- Email --}}
          <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
            <input class="input100 @error('email') is-invalid @enderror"
                   type="email"
                   name="email"
                   value="{{ old('email') }}"
                   placeholder="Email"
                   required
                   autocomplete="email"
                   aria-label="Email Address">
            <span class="focus-input100"></span>
            <span class="symbol-input100"><i class="fa fa-envelope" aria-hidden="true"></i></span>
            @error('email')
              <div class="invalid-feedback d-block text-white" role="alert">{{ $message }}</div>
            @enderror
          </div>

          {{-- Password --}}
          <div class="wrap-input100 validate-input" data-validate="Password is required">
            <input id="password"
                   class="input100 @error('password') is-invalid @enderror"
                   type="password"
                   name="password"
                   placeholder="Password"
                   required
                   autocomplete="current-password"
                   aria-label="Password">
            <span class="symbol-input100"><i class="fa fa-lock" aria-hidden="true"></i></span>
            @error('password')
              <div class="invalid-feedback d-block text-white">{{ $message }}</div>
            @enderror
          </div>

          {{-- Submit --}}
          <div class="container-login100-form-btn">
            <button type="submit" class="login100-form-btn">Login</button>
          </div>
        </form>

        <footer>
          &copy; {{ date('Y') }} SOCDS Project. All rights reserved.
        </footer>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="{{ asset('index/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
  <script src="{{ asset('index/vendor/bootstrap/js/popper.js') }}"></script>
  <script src="{{ asset('index/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('index/vendor/select2/select2.min.js') }}"></script>
  <script src="{{ asset('index/vendor/tilt/tilt.jquery.min.js') }}"></script>
  <script src="{{ asset('index/js/main.js') }}"></script>

  <!-- Custom Script -->
  <script>
    $(document).ready(function () {
      $('.js-tilt').tilt({ scale: 1.1 });

      $('form').on('submit', function () {
        $('.login100-form-btn')
          .prop('disabled', true)
          .html('<i class="fa fa-spinner fa-spin"></i> Logging in...');
      });

      setTimeout(() => {
        $('.alert-success').fadeOut('slow');
      }, 5000);
    });
  </script>
</body>
</html>
