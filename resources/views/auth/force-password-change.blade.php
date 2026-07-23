<!DOCTYPE html>
<html lang="en">
<head>
  @php
    $appName = \App\Models\Setting::get('app_name', 'Product Inventory');
    $faviconPath = \App\Models\Setting::get('favicon_path');
    $faviconUrl = asset('favicon.ico');
    if (!empty($faviconPath) && \Illuminate\Support\Facades\Storage::disk('public')->exists($faviconPath)) {
        $faviconUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($faviconPath);
    }
    $faviconUrl = $faviconUrl . '?v=' . filemtime(public_path('favicon.ico'));
  @endphp
  <title>{{ $appName }} - Change Password Required</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="shortcut icon" type="image/x-icon" href="{{ $faviconUrl }}">
  <link rel="icon" href="{{ $faviconUrl }}" type="image/x-icon">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

  <style>
    body {
      background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
      font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
      margin: 0;
      padding: 0;
      min-height: 100vh;
    }
    .login-wrapper {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }
    .login-card {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border-radius: 16px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
      padding: 40px 30px;
      max-width: 420px;
      width: 100%;
      text-align: center;
    }
    .login-icon {
      width: 80px;
      margin-bottom: 20px;
    }
    .login-title {
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 25px;
      color: #1e293b;
    }
    .form-group {
      position: relative;
      margin-bottom: 20px;
    }
    .form-control {
      padding: 12px 40px 12px 40px;
      border-radius: 8px;
      border: 1px solid #e2e8f0;
      background-color: #f8fafc;
      transition: box-shadow 0.3s ease;
      color: #1e293b;
    }
    .form-control:focus {
      box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
      border-color: #4f46e5;
      outline: none;
    }
    .form-icon {
      position: absolute;
      top: 50%;
      left: 15px;
      transform: translateY(-50%);
      color: #4f46e5;
      font-size: 1.1rem;
    }
    .btn-login {
      background: linear-gradient(135deg, #4f46e5, #4338ca);
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
      box-shadow: 0 8px 20px rgba(79, 70, 229, 0.4);
    }
    .btn-login:disabled {
      opacity: 0.7;
      cursor: not-allowed;
    }
    .form-check-label {
      color: #64748b;
    }
    footer {
      margin-top: 30px;
      font-size: 0.875rem;
      color: #64748b;
    }
  </style>
</head>
<body>

  <div class="login-wrapper">
    <div class="login-card">

      <i class="bi bi-shield-lock-fill login-icon" style="font-size: 4rem; color: #f59e0b;"></i>

      <div class="login-title">Change Your Password</div>

      <div class="alert alert-warning text-start mb-4">
        <i class="bi bi-exclamation-triangle me-2"></i>
        <strong>Forced Password Change:</strong> You are using the default system password. You must set a new password to continue.
      </div>

      <form method="POST" action="{{ route('force.password.change.store') }}" novalidate>
        @csrf

        {{-- New Password --}}
        <div class="form-group">
          <i class="bi bi-lock form-icon"></i>
          <input
            type="password"
            name="password"
            id="password"
            class="form-control @error('password') is-invalid @enderror"
            placeholder="New Password"
            required
            autofocus
          >
          <small class="text-muted d-block text-start mt-1">
            Min 8 chars: uppercase, lowercase, number, special (!@#$%^&*).
          </small>
          @error('password')
            <div class="invalid-feedback text-start">{{ $message }}</div>
          @enderror
        </div>

        {{-- Confirm Password --}}
        <div class="form-group">
          <i class="bi bi-lock-fill form-icon"></i>
          <input
            type="password"
            name="password_confirmation"
            id="password_confirmation"
            class="form-control"
            placeholder="Confirm New Password"
            required
          >
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn-login">Change Password & Continue</button>
      </form>

      <form method="POST" action="{{ route('logout') }}" class="mt-3">
        @csrf
        <button type="submit" class="btn btn-link text-muted" style="text-decoration: none; font-size: 0.875rem;">
          <i class="bi bi-box-arrow-left me-1"></i> Logout instead
        </button>
      </form>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
