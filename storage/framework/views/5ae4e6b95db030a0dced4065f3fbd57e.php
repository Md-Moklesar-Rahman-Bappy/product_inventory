<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    $appName = \App\Models\Setting::get('app_name', 'Product Inventory');
    $faviconPath = \App\Models\Setting::get('favicon_path');
    $faviconUrl = asset('favicon.ico');
    if (!empty($faviconPath) && \Illuminate\Support\Facades\Storage::disk('public')->exists($faviconPath)) {
        $faviconUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($faviconPath);
    }
    $faviconUrl = $faviconUrl . '?v=' . filemtime(public_path('favicon.ico'));
  ?>
  <title><?php echo e($appName); ?> - Login</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo e($faviconUrl); ?>">
  <link rel="icon" href="<?php echo e($faviconUrl); ?>" type="image/x-icon">

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?php echo e(asset('css/custom.css')); ?>">

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

    .toggle-password {
      position: absolute;
      top: 50%;
      right: 15px;
      transform: translateY(-50%);
      cursor: pointer;
      color: #64748b;
      font-size: 1.1rem;
      background: none;
      border: none;
    }

    .toggle-password:hover {
      color: #4f46e5;
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

    footer {
      margin-top: 30px;
      font-size: 0.875rem;
      color: #64748b;
    }

    .form-check-label {
      color: #64748b;
    }
  </style>
</head>
<body>

  <div class="login-wrapper">
    <div class="login-card">

      <i class="bi bi-box-seam-fill login-icon" style="font-size: 4rem; color: #4f46e5;"></i>

      <form method="POST" action="<?php echo e(route('login.action')); ?>" novalidate>
        <?php echo csrf_field(); ?>

        <div class="login-title">Product Inventory Login</div>

        
        <?php $__currentLoopData = ['success', 'error', 'message']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php if(session()->has($msg)): ?>
            <div class="alert alert-<?php echo e($msg === 'error' ? 'danger' : 'success'); ?> alert-dismissible fade show" role="alert">
              <?php echo e(session($msg)); ?>

              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        
        <div class="form-group">
          <i class="bi bi-envelope form-icon"></i>
          <input
            type="email"
            name="email"
            class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
            value="<?php echo e(old('email')); ?>"
            placeholder="Email address"
            required
            autocomplete="email"
          >
          <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="invalid-feedback text-start"><?php echo e($message); ?></div>
          <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        
        <div class="form-group">
          <i class="bi bi-lock form-icon"></i>
          <input
            type="password"
            name="password"
            id="password"
            class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
            placeholder="Password"
            required
            autocomplete="current-password"
          >
          <button type="button" class="toggle-password" onclick="togglePassword()">
            <i class="bi bi-eye" id="eyeIcon"></i>
          </button>
          <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="invalid-feedback text-start"><?php echo e($message); ?></div>
          <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        
        <div class="form-group text-start">
          <div class="form-check">
            <input type="checkbox" name="remember" id="remember" class="form-check-input" <?php echo e(old('remember') ? 'checked' : ''); ?>>
            <label for="remember" class="form-check-label">Remember Me</label>
          </div>
        </div>

        
        <button type="submit" class="btn-login">LOGIN</button>
      </form>

      <footer>
        &copy; <?php echo e(date('Y')); ?> Product Inventory. All rights reserved.
      </footer>

    </div>
  </div>

  <!-- Bootstrap 5 JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    function togglePassword() {
      const passwordInput = document.getElementById('password');
      const eyeIcon = document.getElementById('eyeIcon');
      const isPassword = passwordInput.type === 'password';

      passwordInput.type = isPassword ? 'text' : 'password';
      eyeIcon.classList.toggle('bi-eye');
      eyeIcon.classList.toggle('bi-eye-slash');
    }

    document.querySelector('form').addEventListener('submit', function() {
      const btn = document.querySelector('.btn-login');
      btn.disabled = true;
      btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span> Logging in...';
    });

    setTimeout(() => {
      document.querySelectorAll('.alert-success').forEach(alert => {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
      });
    }, 5000);
  </script>
</body>
</html>
<?php /**PATH D:\Xammp\htdocs\bug-fixes v3\product_inventory\resources\views/auth/login.blade.php ENDPATH**/ ?>