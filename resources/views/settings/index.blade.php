@extends('layouts.app')

@section('title', 'Application Settings')

@section('contents')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">
                    <i class="bi bi-gear-fill me-2 text-primary"></i>
                    Application Settings
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="app_name" class="form-label">Application Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('app_name') is-invalid @enderror" 
                                    id="app_name" name="app_name" 
                                    value="{{ old('app_name', $settings['app_name'] ?? 'Product Inventory') }}" required>
                                @error('app_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="website" class="form-label">Website URL</label>
                                <input type="url" class="form-control @error('website') is-invalid @enderror" 
                                    id="website" name="website" 
                                    value="{{ old('website', $settings['website'] ?? '') }}" placeholder="https://example.com">
                                @error('website')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                    id="phone" name="phone" 
                                    value="{{ old('phone', $settings['phone'] ?? '') }}" placeholder="+880-1234-567890">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                    id="email" name="email" 
                                    value="{{ old('email', $settings['email'] ?? '') }}" placeholder="info@example.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" 
                                    id="address" name="address" rows="2" 
                                    placeholder="Enter your organization address">{{ old('address', $settings['address'] ?? '') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="footer_credit" class="form-label">Footer Credit</label>
                                <input type="text" class="form-control @error('footer_credit') is-invalid @enderror" 
                                    id="footer_credit" name="footer_credit" 
                                    value="{{ old('footer_credit', $settings['footer_credit'] ?? '') }}" placeholder="Footer Credit Name">
                                @error('footer_credit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="logo" class="form-label">Logo</label>
                                <input type="file" class="form-control @error('logo') is-invalid @enderror" 
                                    id="logo" name="logo" accept="image/*">
                                @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if(!empty($settings['logo_path']))
                                    <div class="mt-2">
                                        <small class="text-muted">Current logo:</small>
                                        <img src="{{ Storage::url($settings['logo_path']) }}" alt="Current Logo" 
                                            class="img-thumbnail" style="max-height: 60px;">
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="favicon" class="form-label">Favicon</label>
                                <input type="file" class="form-control @error('favicon') is-invalid @enderror" 
                                    id="favicon" name="favicon" accept="image/png,image/x-icon,image/svg+xml">
                                @error('favicon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if(!empty($settings['favicon_path']))
                                    <div class="mt-2">
                                        <small class="text-muted">Current favicon:</small>
                                        <img src="{{ Storage::url($settings['favicon_path']) }}" alt="Current Favicon" 
                                            class="img-thumbnail" style="max-height: 32px;">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('dashboard') }}" class="btn btn-light">
                            <i class="bi bi-x-circle me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
