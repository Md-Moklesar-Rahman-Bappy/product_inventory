@extends('install.layout')
@php $currentStep = 3; @endphp

@section('content')
    <h4 class="mb-2"><i class="bi bi-key me-2"></i>Step 3: License Activation</h4>
    <p class="text-muted mb-4">Enter your license key to activate the software. The key will be verified with our license server.</p>

    <form method="POST" action="{{ route('install.license.activate') }}">
        @csrf

        @error('license_key')
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ $message }}
            </div>
        @enderror

        <div class="mb-4">
            <label for="license_key" class="form-label">License Key</label>
            <input type="text" name="license_key" id="license_key"
                   class="form-control form-control-lg @error('license_key') is-invalid @enderror"
                   value="{{ old('license_key') }}"
                   placeholder="XXXX-XXXX-XXXX-XXXX"
                   style="text-align:center; letter-spacing:2px; font-weight:600;"
                   required autofocus>
            @error('license_key')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted d-block mt-2 text-center">
                Contact your software provider if you don't have a license key.
            </small>
        </div>

        <div class="text-center">
            <a href="{{ route('install.database') }}" class="btn btn-outline-secondary me-2">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
            <button type="submit" class="btn btn-install">
                Activate License <i class="bi bi-arrow-right ms-2"></i>
            </button>
        </div>
    </form>
@endsection
