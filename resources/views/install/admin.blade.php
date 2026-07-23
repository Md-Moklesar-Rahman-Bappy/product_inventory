@extends('install.layout')
@php $currentStep = 4; @endphp

@section('content')
    <h4 class="mb-2"><i class="bi bi-person-gear me-2"></i>Step 4: Super Admin Account</h4>
    <p class="text-muted mb-4">A default super administrator account will be created with the following credentials:</p>

    <form method="POST" action="{{ route('install.admin.store') }}">
        @csrf

        @error('installation')
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ $message }}
            </div>
        @enderror

        <div class="card mb-4">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <div class="form-control bg-light">superadmin@superadmin.com</div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Password</label>
                    <div class="form-control bg-light">Password@123</div>
                </div>
                <div class="mb-0">
                    <label class="form-label fw-bold">Role</label>
                    <div class="form-control bg-light">Super Admin (full access)</div>
                </div>
            </div>
        </div>

        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <strong>Security Notice:</strong> You will be required to change this password on your first login.
            The default credentials are also documented in the INSTALLATION_GUIDE.md file.
        </div>

        <div class="text-center">
            <a href="{{ route('install.license') }}" class="btn btn-outline-secondary me-2">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
            <button type="submit" class="btn btn-install">
                Complete Installation <i class="bi bi-check-circle ms-2"></i>
            </button>
        </div>
    </form>
@endsection
