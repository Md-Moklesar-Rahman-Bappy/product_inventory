<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>License Error - Product Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            margin: 0;
        }
        .error-card {
            background: rgba(255,255,255,0.97);
            border-radius: 16px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
            padding: 50px 40px;
            max-width: 520px;
            width: 90%;
            text-align: center;
        }
        .error-icon {
            font-size: 5rem;
            color: #dc2626;
            margin-bottom: 20px;
        }
        .error-title {
            font-size: 1.6rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 15px;
        }
        .error-message {
            color: #64748b;
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .contact-info {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 25px;
        }
        .contact-info p {
            margin: 0;
            color: #991b1b;
            font-size: 0.9rem;
        }
        .btn-back {
            background: #64748b;
            color: #fff;
            border: none;
            padding: 10px 30px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-back:hover { background: #475569; color: #fff; }
    </style>
</head>
<body>
    <div class="error-card">
        <div class="error-icon">
            <i class="bi bi-shield-exclamation"></i>
        </div>
        <h2 class="error-title">License Verification Failed</h2>
        <p class="error-message">
            Your software license is inactive, expired, revoked, or could not be verified. Please contact the software provider.
        </p>
        <div class="contact-info">
            <p><i class="bi bi-envelope me-2"></i>If you need assistance, please contact your software vendor with your license key.</p>
        </div>
        <a href="{{ route('login') }}" class="btn-back">
            <i class="bi bi-arrow-left me-2"></i>Back to Login
        </a>
    </div>
</body>
</html>
