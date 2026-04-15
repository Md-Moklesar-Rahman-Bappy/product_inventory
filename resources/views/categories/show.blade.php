@extends('layouts.app')

@section('title', 'Category Details')

@section('contents')
<div class="row">
    <div class="col-lg-12">
        <div class="modern-table-card">
            <div class="table-header-section">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="header-icon">
                            <i class="bi bi-tags-fill"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold text-white">Category Details</h4>
                            <small class="text-white opacity-75">View category information</small>
                        </div>
                    </div>
                    <a href="{{ route('categories.index') }}" class="btn btn-sm btn-outline-light">
                        <i class="bi bi-arrow-left me-1"></i> Back
                    </a>
                </div>
            </div>

            <div class="card-body p-4">
                <div class="detail-section mb-4">
                    <div class="section-header d-flex align-items-center mb-3">
                        <div class="section-icon" style="background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%); color: #4f46e5;">
                            <i class="bi bi-tag"></i>
                        </div>
                        <h6 class="mb-0 fw-bold" style="color: #1e293b;">Category Information</h6>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="detail-card">
                                <span class="detail-label">Category Name</span>
                                <span class="detail-value">{{ $category->category_name }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-card">
                                <span class="detail-label">Status</span>
                                <span class="detail-value">
                                    <span class="status-badge {{ $category->status === 'active' ? 'status-active' : 'status-inactive' }}">
                                        {{ ucfirst($category->status ?? 'active') }}
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="detail-section mb-4">
                    <div class="section-header d-flex align-items-center mb-3">
                        <div class="section-icon" style="background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%); color: #0284c7;">
                            <i class="bi bi-box"></i>
                        </div>
                        <h6 class="mb-0 fw-bold" style="color: #1e293b;">Related Products</h6>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="detail-card">
                                <span class="detail-label">Total Products</span>
                                <span class="detail-value">
                                    <span class="category-badge">{{ $category->products_count ?? $category->products->count() }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="detail-section mb-4">
                    <div class="section-header d-flex align-items-center mb-3">
                        <div class="section-icon" style="background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%); color: #64748b;">
                            <i class="bi bi-clock"></i>
                        </div>
                        <h6 class="mb-0 fw-bold" style="color: #1e293b;">Record Information</h6>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="detail-card">
                                <span class="detail-label">Created At</span>
                                <span class="detail-value">{{ $category->created_at->format('d M Y, h:i A') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-card">
                                <span class="detail-label">Last Updated</span>
                                <span class="detail-value">{{ $category->updated_at->format('d M Y, h:i A') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-arrow-left me-1"></i>Back
                    </a>
                    @if(auth()->user()->permission <= 1)
                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-edit px-4">
                            <i class="bi bi-pencil me-1"></i>Edit
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
