@extends('layouts.app')

@section('title', 'Product Details')

@section('contents')
<div class="row">
    <div class="col-lg-12">
        <div class="custom-card border-0 shadow-sm">
            {{-- Header --}}
            <div class="card-header bg-white border-bottom py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-primary text-white me-3">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-dark">Product Details</h5>
                            <small class="text-muted">View product information</small>
                        </div>
                    </div>
                    <a href="{{ route('products.index') }}" class="btn btn-light">
                        <i class="bi bi-arrow-left me-1"></i>Back
                    </a>
                </div>
            </div>

            {{-- Body --}}
            <div class="card-body p-4">
                {{-- Product Info Section --}}
                <div class="detail-section mb-4">
                    <div class="section-header d-flex align-items-center mb-3">
                        <div class="section-icon bg-primary-subtle text-primary me-3">
                            <i class="bi bi-box"></i>
                        </div>
                        <h6 class="mb-0 fw-bold text-dark">Product Information</h6>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="detail-card">
                                <span class="detail-label">Product Name</span>
                                <span class="detail-value">{{ $product->product_name }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-card">
                                <span class="detail-label">Price</span>
                                <span class="detail-value">
                                    ৳{{ number_format($product->price, 2) }}
                                    @if($product->price > 100000)
                                        <span class="badge bg-danger ms-2">High Value</span>
                                    @elseif($product->price < 5000)
                                        <span class="badge bg-success ms-2">Budget</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Category/Brand/Model --}}
                <div class="detail-section mb-4">
                    <div class="section-header d-flex align-items-center mb-3">
                        <div class="section-icon bg-info-subtle text-info me-3">
                            <i class="bi bi-tags"></i>
                        </div>
                        <h6 class="mb-0 fw-bold text-dark">Category & Brand</h6>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="detail-card">
                                <span class="detail-label">Category</span>
                                <span class="detail-value">
                                    <span class="badge bg-secondary-subtle text-secondary border">
                                        {{ $product->category?->category_name ?? 'N/A' }}
                                    </span>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-card">
                                <span class="detail-label">Brand</span>
                                <span class="detail-value">
                                    <span class="badge bg-secondary-subtle text-secondary border">
                                        {{ $product->brand?->brand_name ?? 'N/A' }}
                                    </span>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-card">
                                <span class="detail-label">Model</span>
                                <span class="detail-value">
                                    <span class="badge bg-secondary-subtle text-secondary border">
                                        {{ $product->model?->model_name ?? 'N/A' }}
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Serial Numbers --}}
                <div class="detail-section mb-4">
                    <div class="section-header d-flex align-items-center mb-3">
                        <div class="section-icon bg-warning-subtle text-warning me-3">
                            <i class="bi bi-upc"></i>
                        </div>
                        <h6 class="mb-0 fw-bold text-dark">Serial Numbers</h6>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="detail-card">
                                <span class="detail-label">Serial No</span>
                                <span class="detail-value"><code>{{ $product->serial_no ?? 'N/A' }}</code></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-card">
                                <span class="detail-label">Project Serial No</span>
                                <span class="detail-value"><code>{{ $product->project_serial_no ?? 'N/A' }}</code></span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Location & Description --}}
                <div class="detail-section mb-4">
                    <div class="section-header d-flex align-items-center mb-3">
                        <div class="section-icon bg-success-subtle text-success me-3">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <h6 class="mb-0 fw-bold text-dark">Location & Description</h6>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="detail-card">
                                <span class="detail-label">Location</span>
                                <span class="detail-value">{{ $product->position ?? '—' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-card">
                                <span class="detail-label">User Description</span>
                                <span class="detail-value">{{ $product->user_description ?? '—' }}</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="detail-card">
                                <span class="detail-label">Remarks</span>
                                <span class="detail-value">{{ $product->remarks ?? '—' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Warranty --}}
                @if($product->warranty_start || $product->warranty_end)
                <div class="detail-section mb-4">
                    <div class="section-header d-flex align-items-center mb-3">
                        <div class="section-icon bg-danger-subtle text-danger me-3">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h6 class="mb-0 fw-bold text-dark">Warranty Information</h6>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="detail-card">
                                <span class="detail-label">Warranty Start</span>
                                <span class="detail-value">{{ $product->warranty_start?->format('d M Y') ?? '—' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-card">
                                <span class="detail-label">Warranty End</span>
                                <span class="detail-value">
                                    {{ $product->warranty_end?->format('d M Y') ?? '—' }}
                                    @if($product->warranty_end)
                                        <span class="ms-2">{!! $product->warranty_countdown !!}</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Timestamps --}}
                <div class="detail-section mb-4">
                    <div class="section-header d-flex align-items-center mb-3">
                        <div class="section-icon bg-light text-muted me-3">
                            <i class="bi bi-clock"></i>
                        </div>
                        <h6 class="mb-0 fw-bold text-dark">Record Info</h6>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="detail-card">
                                <span class="detail-label">Created At</span>
                                <span class="detail-value">{{ $product->created_at->format('d M Y, h:i A') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-card">
                                <span class="detail-label">Updated At</span>
                                <span class="detail-value">{{ $product->updated_at->format('d M Y, h:i A') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="d-flex justify-content-between pt-3 border-top">
                    <a href="{{ route('products.index') }}" class="btn btn-light">
                        <i class="bi bi-arrow-left me-1"></i>Back to List
                    </a>
                    @if(auth()->user()->permission <= 1)
                    <div class="d-flex gap-2">
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">
                            <i class="bi bi-pencil me-1"></i>Edit
                        </a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger delete-btn"
                                data-title="Delete Product"
                                data-text="Are you sure you want to delete this product?">
                                <i class="bi bi-trash me-1"></i>Delete
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection