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
  <title>{{ $appName }} - Forgot Password</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="{{ $faviconUrl }}">
  <link rel="icon" href="{{ $faviconUrl }}" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
  <style>
    body { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; margin: 0; padding: 0; min-height: 100vh; }
    .login-wrapper { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
    .login-card { background: rgba(255,255,255,0.95); backdrop-filter: blur(20px); border-radius: 16px; box-shadow: 0 20px 40px rgba(0,0,0,0.3); padding: 40px 30px; max-width: 420px; width: 100%; text-align: center; }
    .login-icon { width: 80px; margin-bottom: 20px; }
    .login-title { font-size: 1.5rem; font-weight: 600; margin-bottom: 25px; color: #1e293b; }
    .btn-login { background: linear-gradient(135deg, #4f46e5, #4338ca); color: #fff; font-weight: 600; border: none; padding: 12px; border-radius: 8px; width: 100%; transition: transform 0.2s ease, box-shadow 0.3s ease; }
    .btn-login:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(79,70,229,0.4); color: #fff; }
    .method-card { border: 2px solid #e2e8f0; border-radius: 12px; padding: 24px 16px; text-decoration: none; color: #1e293b; transition: all 0.2s ease; display: block; }
    .method-card:hover { border-color: #4f46e5; background: rgba(79,70,229,0.05); color: #1e293b; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(79,70,229,0.15); }
    .method-card i { font-size: 2rem; color: #4f46e5; display: block; margin-bottom: 8px; }
    .method-card .method-label { font-weight: 600; font-size: 1rem; }
    .method-card .method-desc { font-size: 0.8rem; color: #64748b; margin-top: 4px; }
    footer { margin-top: 30px; font-size: 0.875rem; color: #64748b; }
  </style>
</head>
<body>
  <div class="login-wrapper">
    <div class="login-card">
      <i class="bi bi-box-seam-fill login-icon" style="font-size: 4rem; color: #4f46e5;"></i>
      <div class="login-title">Forgot Password?</div>
      <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 24px;">Choose how you'd like to recover your account.</p>

      @foreach (['success', 'error', 'message'] as $msg)
        @if(session()->has($msg))
          <div class="alert alert-{{ $msg === 'error' ? 'danger' : 'success' }} alert-dismissible fade show" role="alert">
            {{ session($msg) }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif
      @endforeach

      <div class="d-grid gap-3 mb-3">
        <a href="{{ route('password.forgot.email.form') }}" class="method-card">
          <i class="bi bi-envelope-at-fill"></i>
          <div class="method-label">Recover via Email</div>
          <div class="method-desc">We'll send a code to your registered email</div>
        </a>
        <a href="{{ route('password.forgot.phone.form') }}" class="method-card">
          <i class="bi bi-phone-fill"></i>
          <div class="method-label">Recover via SMS</div>
          <div class="method-desc">We'll send a code to your registered phone</div>
        </a>
      </div>

      <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-login">
        <i class="bi bi-arrow-left me-1"></i> Back to Login
      </a>

      <footer>&copy; {{ date('Y') }} Product Inventory. All rights reserved.</footer>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    setTimeout(() => { document.querySelectorAll('.alert-success').forEach(alert => { const bsAlert = new bootstrap.Alert(alert); bsAlert.close(); }); }, 5000);
  </script>
</body>
</html>
