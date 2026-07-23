@extends('install.layout')
@php $currentStep = 4; @endphp

@section('content')
    <h4 class="mb-2"><i class="bi bi-person-gear me-2"></i>Step 4: Super Admin Account</h4>
    <p class="text-muted mb-4">Create the administrator account for managing your inventory system.</p>

    <form method="POST" action="{{ route('install.admin.store') }}">
        @csrf

        @error('installation')
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ $message }}
            </div>
        @enderror

        <div class="mb-3">
            <label for="name" class="form-label fw-bold">Admin Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label fw-bold">Admin Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="mobile" class="form-label fw-bold">Mobile Number</label>
            <input type="text" class="form-control @error('mobile') is-invalid @enderror" id="mobile" name="mobile" value="{{ old('mobile') }}" required>
            @error('mobile')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label fw-bold">Password</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
            <div class="form-text">Min 8 characters, including uppercase, lowercase, number, and special character.</div>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label fw-bold">Confirm Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
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
