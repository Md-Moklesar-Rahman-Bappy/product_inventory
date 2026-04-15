@extends('layouts.app')

@section('title', 'Verify Your Email')

@section('contents')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="custom-card text-center p-4">
                <div class="card-body">
                    <i class="bi bi-envelope-check text-primary" style="font-size: 4rem;"></i>
                    <h3 class="text-primary fw-bold mt-3">Email Verification Required</h3>
                    <p class="text-muted">Please check your inbox and click the verification link to activate your account.</p>

                    @if (session('message'))
                        <div class="alert alert-success mt-3">
                            {{ session('message') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary mt-3">
                            <i class="bi bi-arrow-repeat me-2"></i>Resend Verification Email
                        </button>
                    </form>

                    <p class="text-muted mt-4">Didn't receive the email? Check your spam folder or click above to resend.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
