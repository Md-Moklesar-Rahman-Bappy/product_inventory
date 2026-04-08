@extends('layouts.app')

@section('title', 'Product Details')

@section('contents')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="custom-card">
            {{-- Header --}}
            <div class="card-header bg-info text-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-bold"><i class="bi bi-box-seam me-2"></i>Product Details</h4>
                    <a href="{{ route('products.index') }}" class="btn btn-sm btn-light text-dark">
                        <i class="bi bi-arrow-left me-1"></i>Back
                    </a>
                </div>
            </div>

            {{-- Body --}}
            <div class="card-body p-4">
                {{-- Product Info --}}
                <h5 class="text-primary fw-bold mb-3"><i class="bi bi-box me-2"></i>Product Info</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">Product Name</small>
                            <strong>{{ $product->product_name }}</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">Price</small>
                            <strong>{{ number_format($product->price, 2) }} ৳</strong>
                            @if($product->price > 100000)
                                <span class="badge bg-danger text-light ms-2">High Value</span>
                            @elseif($product->price < 5000)
                                <span class="badge bg-success ms-2">Budget Pick</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">Category</small>
                            <strong>{{ $product->category?->category_name ?? 'N/A' }}</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">Brand</small>
                            <strong>{{ $product->brand?->brand_name ?? 'N/A' }}</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">Model</small>
                            <strong>{{ $product->model?->model_name ?? 'N/A' }}</strong>
                        </div>
                    </div>
                </div>

                {{-- Serial Numbers --}}
                <h5 class="text-primary fw-bold mb-3"><i class="bi bi-upc me-2"></i>Serial Numbers</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">Serial No</small>
                            <strong>{{ $product->serial_no ?? 'N/A' }}</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">Project Serial No</small>
                            <strong>{{ $product->project_serial_no ?? 'N/A' }}</strong>
                        </div>
                    </div>
                </div>

                {{-- Location & Description --}}
                <h5 class="text-primary fw-bold mb-3"><i class="bi bi-geo-alt me-2"></i>Location & Description</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">Location</small>
                            <strong>{{ $product->position ?? 'N/A' }}</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">User Description</small>
                            <strong>{{ $product->user_description ?? 'N/A' }}</strong>
                        </div>
                    </div>
                </div>

                {{-- Remarks --}}
                <h5 class="text-primary fw-bold mb-3"><i class="bi bi-chat-left-text me-2"></i>Remarks</h5>
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">Remarks</small>
                            <strong>{{ $product->remarks ?? 'N/A' }}</strong>
                        </div>
                    </div>
                </div>

                {{-- Warranty --}}
                <h5 class="text-primary fw-bold mb-3"><i class="bi bi-shield-check me-2"></i>Warranty</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">Warranty Start</small>
                            <strong>{{ $product->warranty_start?->format('d M Y') ?? 'N/A' }}</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">Warranty End</small>
                            <strong>{{ $product->warranty_end?->format('d M Y') ?? 'N/A' }}</strong>
                        </div>
                    </div>
                </div>

                @if($product->warranty_end)
                    <div class="mb-4">
                        {!! $product->warranty_countdown !!}
                    </div>
                @endif

                {{-- Timestamps --}}
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">Created At</small>
                            <strong>{{ $product->created_at->format('d M Y, h:i A') }}</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block">Updated At</small>
                            <strong>{{ $product->updated_at->format('d M Y, h:i A') }}</strong>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="d-flex justify-content-between pt-3 border-top">
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Back to List
                    </a>
                    <div class="d-flex gap-2">
                        @if(auth()->user()->permission <= 1)
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">
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
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection