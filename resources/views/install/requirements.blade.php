@extends('install.layout')
@php $currentStep = 1; @endphp

@section('content')
    <h4 class="mb-2"><i class="bi bi-gear me-2"></i>Step 1: System Requirements</h4>
    <p class="text-muted mb-4">Please verify that your server meets the minimum requirements.</p>

    @php
        $allPassed = collect($requirements)->every(fn($r) => $r['passed']);
    @endphp

    @foreach($requirements as $req)
        <div class="requirement-item {{ $req['passed'] ? 'passed' : 'failed' }}">
            <div>
                <strong>{{ $req['name'] }}</strong>
                <br><small class="text-muted">Current: {{ $req['current'] }}</small>
            </div>
            <span class="status-badge {{ $req['passed'] ? 'pass' : 'fail' }}">
                {{ $req['passed' ] ? 'Pass' : 'Fail' }}
            </span>
        </div>
    @endforeach

    <div class="text-center mt-4">
        @if($allPassed)
            <a href="{{ route('install.database') }}" class="btn btn-install">
                Continue <i class="bi bi-arrow-right ms-2"></i>
            </a>
        @else
            <div class="alert alert-danger mt-3">
                <i class="bi bi-exclamation-triangle me-2"></i>
                Please fix the failing requirements above before continuing.
            </div>
            <button class="btn btn-install" disabled>
                Cannot Continue <i class="bi bi-arrow-right ms-2"></i>
            </button>
        @endif
    </div>
@endsection
