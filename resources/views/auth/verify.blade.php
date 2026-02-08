@extends('layouts.app')

@section('title', 'Verify Your Email')

@section('contents')
<div class="container py-5">
    <div class="text-center">
        <h3 class="text-primary fw-bold">📧 Email Verification Required</h3>
        <p class="text-muted">Please check your inbox and click the verification link to activate your account.</p>

        @if (session('message'))
            <div class="alert alert-success mt-3">
                {{ session('message') }}
            </div>
        @endif

        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn btn-outline-primary mt-3">
                Resend Verification Email
            </button>
        </form>

        <p class="text-muted mt-4">Didn’t receive the email? Check your spam folder or click above to resend.</p>
    </div>
</div>
@endsection
