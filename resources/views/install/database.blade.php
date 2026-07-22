@extends('install.layout')
@php $currentStep = 2; @endphp

@section('content')
    <h4 class="mb-2"><i class="bi bi-database me-2"></i>Step 2: Database Configuration</h4>
    <p class="text-muted mb-4">Enter your database credentials below. The connection will be tested before saving.</p>

    <form method="POST" action="{{ route('install.database.store') }}">
        @csrf

        @error('database')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="mb-3">
            <label for="host" class="form-label">Database Host</label>
            <input type="text" name="host" id="host" class="form-control @error('host') is-invalid @enderror"
                   value="{{ old('host', $existingConfig['host'] ?? '127.0.0.1') }}" required>
            @error('host')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="port" class="form-label">Database Port</label>
            <input type="number" name="port" id="port" class="form-control @error('port') is-invalid @enderror"
                   value="{{ old('port', $existingConfig['port'] ?? '3306') }}" required min="1" max="65535">
            @error('port')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="database" class="form-label">Database Name</label>
            <input type="text" name="database" id="database" class="form-control @error('database') is-invalid @enderror"
                   value="{{ old('database', $existingConfig['database'] ?? '') }}" required>
            @error('database')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">Database Username</label>
            <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror"
                   value="{{ old('username', $existingConfig['username'] ?? '') }}" required>
            @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="form-label">Database Password</label>
            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                   value="{{ old('password', $existingConfig['password'] ?? '') }}">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="text-center">
            <a href="{{ route('install.requirements') }}" class="btn btn-outline-secondary me-2">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
            <button type="submit" class="btn btn-install">
                Test & Continue <i class="bi bi-arrow-right ms-2"></i>
            </button>
        </div>
    </form>
@endsection
