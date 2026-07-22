@extends('install.layout')
@php $currentStep = 4; @endphp

@section('content')
    <h4 class="mb-2"><i class="bi bi-person-gear me-2"></i>Step 4: Super Admin Account</h4>
    <p class="text-muted mb-4">Create the super administrator account. This user will have full access to the system.</p>

    <form method="POST" action="{{ route('install.admin.store') }}">
        @csrf

        @error('installation')
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ $message }}
            </div>
        @enderror

        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name') }}" required autofocus>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="mobile" class="form-label">Phone Number</label>
            <input type="text" name="mobile" id="mobile" class="form-control @error('mobile') is-invalid @enderror"
                   value="{{ old('mobile') }}" placeholder="e.g. 01XXXXXXXXX">
            @error('mobile')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password"
                   class="form-control @error('password') is-invalid @enderror" required>
            <small class="text-muted">
                Min 8 characters, must include uppercase, lowercase, number, and special character (!@#$%^&*).
            </small>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                   class="form-control" required>
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
