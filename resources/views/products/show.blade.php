@extends('layouts.app')

@section('title', 'Product Details')

@section('contents')
<div class="row">
    <div class="col-lg-12">
        <div class="modern-table-card">
            <div class="table-header-section">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="header-icon">
                            <i class="bi bi-box-fill"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold text-white">Product Details</h4>
                            <small class="text-white opacity-75">View product information</small>
                        </div>
                    </div>
                    <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-light">
                        <i class="bi bi-arrow-left me-1"></i> Back
                    </a>
                </div>
            </div>

            <div class="card-body p-4">
                <div class="detail-section mb-4">
                    <div class="section-header d-flex align-items-center mb-3">
                        <div class="section-icon" style="background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%); color: #4f46e5;">
                            <i class="bi bi-box"></i>
                        </div>
                        <h6 class="mb-0 fw-bold" style="color: #1e293b;">Product Information</h6>
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
                                <span class="detail-value" style="color: #059669;">
                                    ৳{{ number_format($product->price, 2) }}
                                    @if($product->price > 100000)
                                        <span class="badge" style="background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); color: #dc2626; border: 1px solid #fecaca;">High Value</span>
                                    @elseif($product->price < 5000)
                                        <span class="badge" style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); color: #047857; border: 1px solid #a7f3d0;">Budget</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="detail-section mb-4">
                    <div class="section-header d-flex align-items-center mb-3">
                        <div class="section-icon" style="background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%); color: #0284c7;">
                            <i class="bi bi-tags"></i>
                        </div>
                        <h6 class="mb-0 fw-bold" style="color: #1e293b;">Category & Brand</h6>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="detail-card">
                                <span class="detail-label">Category</span>
                                <span class="detail-value">
                                    <span class="category-badge">{{ $product->category?->category_name ?? 'N/A' }}</span>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-card">
                                <span class="detail-label">Brand</span>
                                <span class="detail-value">
                                    <span class="category-badge">{{ $product->brand?->brand_name ?? 'N/A' }}</span>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-card">
                                <span class="detail-label">Model</span>
                                <span class="detail-value">
                                    <span class="category-badge">{{ $product->model?->model_name ?? 'N/A' }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="detail-section mb-4">
                    <div class="section-header d-flex align-items-center mb-3">
                        <div class="section-icon" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); color: #d97706;">
                            <i class="bi bi-upc"></i>
                        </div>
                        <h6 class="mb-0 fw-bold" style="color: #1e293b;">Serial Numbers</h6>
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

                <div class="detail-section mb-4">
                    <div class="section-header d-flex align-items-center mb-3">
                        <div class="section-icon" style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); color: #047857;">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <h6 class="mb-0 fw-bold" style="color: #1e293b;">Location & Description</h6>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="detail-card">
                                <span class="detail-label">Location</span>
                                <span class="detail-value location-text">{{ $product->position ?? '—' }}</span>
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

                @if($product->warranty_start || $product->warranty_end)
                <div class="detail-section mb-4">
                    <div class="section-header d-flex align-items-center mb-3">
                        <div class="section-icon" style="background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); color: #dc2626;">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h6 class="mb-0 fw-bold" style="color: #1e293b;">Warranty Information</h6>
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

                <div class="detail-section mb-4">
                    <div class="section-header d-flex align-items-center mb-3">
                        <div class="section-icon" style="background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%); color: #64748b;">
                            <i class="bi bi-clock"></i>
                        </div>
                        <h6 class="mb-0 fw-bold" style="color: #1e293b;">Record Info</h6>
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

                <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-arrow-left me-1"></i>Back
                    </a>
                    @if(auth()->user()->permission <= 1)
                    <div class="d-flex gap-2">
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-edit px-4">
                            <i class="bi bi-pencil me-1"></i>Edit
                        </a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete px-4 delete-btn"
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
