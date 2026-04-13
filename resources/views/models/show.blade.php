@extends('layouts.app')

@section('title', 'Model Details')

@section('contents')
<div class="row">
    <div class="col-lg-12">
        <div class="custom-card border-0 shadow-sm">
            {{-- Header --}}
            <div class="card-header bg-white border-bottom py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-primary text-white me-3">
                            <i class="bi bi-layers"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-dark">Model Details</h5>
                            <small class="text-muted">View model information</small>
                        </div>
                    </div>
                    <a href="{{ route('models.index') }}" class="btn btn-light">
                        <i class="bi bi-arrow-left me-1"></i>Back
                    </a>
                </div>
            </div>

            {{-- Body --}}
            <div class="card-body p-4">
                <div class="detail-section mb-4">
                    <div class="section-header d-flex align-items-center mb-3">
                        <div class="section-icon bg-primary-subtle text-primary me-3">
                            <i class="bi bi-layers"></i>
                        </div>
                        <h6 class="mb-0 fw-bold text-dark">Model Information</h6>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="detail-card">
                                <span class="detail-label">Model Name</span>
                                <span class="detail-value">{{ $model->model_name }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-card">
                                <span class="detail-label">Status</span>
                                <span class="detail-value">
                                    <span class="badge {{ $model->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ ucfirst($model->status ?? 'active') }}
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="detail-section mb-4">
                    <div class="section-header d-flex align-items-center mb-3">
                        <div class="section-icon bg-info-subtle text-info me-3">
                            <i class="bi bi-box"></i>
                        </div>
                        <h6 class="mb-0 fw-bold text-dark">Related Products</h6>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="detail-card">
                                <span class="detail-label">Total Products</span>
                                <span class="detail-value">
                                    <span class="badge bg-secondary-subtle text-secondary border">
                                        {{ $model->products_count ?? $model->products->count() }}
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="detail-section mb-4">
                    <div class="section-header d-flex align-items-center mb-3">
                        <div class="section-icon bg-warning-subtle text-warning me-3">
                            <i class="bi bi-clock"></i>
                        </div>
                        <h6 class="mb-0 fw-bold text-dark">Record Information</h6>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="detail-card">
                                <span class="detail-label">Created At</span>
                                <span class="detail-value">{{ $model->created_at->format('d M Y, h:i A') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-card">
                                <span class="detail-label">Last Updated</span>
                                <span class="detail-value">{{ $model->updated_at->format('d M Y, h:i A') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="d-flex justify-content-end pt-3 border-top">
                    <a href="{{ route('models.index') }}" class="btn btn-light me-2">
                        <i class="bi bi-arrow-left me-1"></i>Back
                    </a>
                    @if(auth()->user()->permission <= 1)
                        <a href="{{ route('models.edit', $model->id) }}" class="btn btn-primary">
                            <i class="bi bi-pencil me-1"></i>Edit
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection