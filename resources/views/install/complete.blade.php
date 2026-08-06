@extends('install.layout')
@php $currentStep = 5; @endphp

@section('content')
    <div class="text-center py-3">
        <div style="font-size: 4rem; color: #10b981; margin-bottom: 15px;">
            <i class="bi bi-check-circle-fill"></i>
        </div>
        <h3 class="mb-3" style="color: #1e293b;">Installation Complete!</h3>
        <p class="text-muted mb-4">
            {{ config('app.name', 'Equipment Inventory Management System') }} has been installed successfully. Your license is activated and your admin account is ready.
        </p>

        <div class="card mb-4 mx-auto" style="max-width: 400px;">
            <div class="card-body text-start">
                <h6 class="card-title mb-3"><i class="bi bi-info-circle me-2"></i>Next Steps</h6>
                <div class="mb-2">
                    Use the admin credentials you just created to log in.
                </div>
                <div class="mb-0">
                    You can then create additional users and configure your inventory settings.
                </div>
            </div>
        </div>

        @if(session('mail_warning'))
            <div class="alert alert-warning mb-4">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Mail Configuration Notice:</strong> {{ session('mail_warning') }}
            </div>
        @endif

        <a href="{{ route('login') }}" class="btn btn-install btn-lg">
            <i class="bi bi-box-arrow-in-right me-2"></i> Go to Login
        </a>
    </div>
@endsection
