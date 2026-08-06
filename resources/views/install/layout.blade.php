<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Installation Wizard - {{ config('app.name', 'Equipment Inventory Management System') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        * { box-sizing: border-box; }
        body {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            margin: 0;
            padding: 20px 0;
        }
        .install-wrapper {
            max-width: 680px;
            margin: 0 auto;
            padding: 0 15px;
        }
        .install-card {
            background: rgba(255,255,255,0.97);
            border-radius: 16px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.25);
            overflow: hidden;
        }
        .install-header {
            background: #4f46e5;
            color: #fff;
            padding: 24px 30px;
            text-align: center;
        }
        .install-header h2 { margin: 0 0 5px; font-weight: 700; }
        .install-header p { margin: 0; opacity: 0.85; font-size: 0.95rem; }
        .install-body { padding: 30px; }
        .steps-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
            gap: 8px;
        }
        .step-dot {
            width: 40px;
            height: 6px;
            border-radius: 3px;
            background: #e2e8f0;
            transition: all 0.3s;
        }
        .step-dot.active { background: #4f46e5; }
        .step-dot.completed { background: #10b981; }
        .btn-install {
            background: #4f46e5;
            color: #fff;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.2s;
        }
        .btn-install:hover { background: #4338ca; color: #fff; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(79,70,229,0.4); }
        .btn-install:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
        .requirement-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 14px;
            border-radius: 8px;
            margin-bottom: 6px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
        }
        .requirement-item.passed { border-color: #d1fae5; background: #f0fdf4; }
        .requirement-item.failed { border-color: #fecaca; background: #fef2f2; }
        .status-badge {
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .status-badge.pass { background: #d1fae5; color: #065f46; }
        .status-badge.fail { background: #fecaca; color: #991b1b; }
        .form-label { font-weight: 600; color: #334155; margin-bottom: 6px; }
        .form-control { border-radius: 8px; border: 1px solid #e2e8f0; padding: 10px 14px; }
        .form-control:focus { border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79,70,229,0.15); }
        .install-footer { text-align: center; padding: 20px 30px; color: #94a3b8; font-size: 0.85rem; border-top: 1px solid #e2e8f0; }
        .loader { display: none; }
        .loader.active { display: inline-block; }
    </style>
</head>
<body>
    <div class="install-wrapper">
        <div class="install-card">
            <div class="install-header">
                <h2><i class="bi bi-box-seam-fill me-2"></i>{{ config('app.name', 'Equipment Inventory Management System') }}</h2>
                <p>Installation Wizard</p>
            </div>

            <div class="install-body">
                <div class="steps-indicator">
                    @php $currentStep = $currentStep ?? 1; @endphp
                    @for($i = 1; $i <= 5; $i++)
                        <div class="step-dot {{ $i < $currentStep ? 'completed' : ($i === $currentStep ? 'active' : '') }}"></div>
                    @endfor
                </div>

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>

            <div class="install-footer">
                &copy; {{ date('Y') }} {{ config('app.name', 'Equipment Inventory Management System') }}. Installation Wizard.
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const btn = this.querySelector('button[type="submit"]');
                if (btn) {
                    btn.disabled = true;
                    const originalText = btn.innerHTML;
                    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
                    setTimeout(() => { btn.disabled = false; btn.innerHTML = originalText; }, 15000);
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
