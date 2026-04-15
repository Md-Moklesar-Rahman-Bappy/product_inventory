@extends('layouts.app')

@section('title', 'Edit Product')

@section('contents')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="modern-table-card">
            <div class="table-header-section">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="header-icon" style="background: rgba(251, 191, 36, 0.3);">
                            <i class="bi bi-pencil-square"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold text-white">Edit Product</h4>
                            <small class="text-white opacity-75">Update product information</small>
                        </div>
                    </div>
                    <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-light">
                        <i class="bi bi-arrow-left me-1"></i> Back
                    </a>
                </div>
            </div>

            <div class="card-body p-4">
                @if($errors->any())
                    <div class="alert alert-danger mb-4" style="border-radius: 12px;">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle-fill fs-4 me-2"></i>
                            <strong>Please fix the following errors:</strong>
                        </div>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('products.update', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-section-title mb-4">
                        <i class="bi bi-box"></i>
                        Product Information
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label-custom">Product Name</label>
                            <input type="text" name="product_name" class="form-control form-input"
                                value="{{ old('product_name', $product->product_name) }}" placeholder="Enter product name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">Price (৳)</label>
                            <input type="number" name="price" class="form-control form-input"
                                value="{{ old('price', $product->price) }}" step="0.01" min="0" placeholder="0.00" required>
                            @if($product->price > 100000)
                                <span class="badge bg-danger mt-2">High Value</span>
                            @elseif($product->price < 5000)
                                <span class="badge bg-success mt-2">Budget Pick</span>
                            @endif
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label-custom">Category</label>
                            <select name="category_id" class="form-select form-input" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}" {{ old('category_id', $product->category_id) == $c->id ? 'selected' : '' }}>
                                        {{ $c->category_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label-custom">Brand</label>
                            <select name="brand_id" class="form-select form-input" required>
                                <option value="">Select Brand</option>
                                @foreach($brands as $b)
                                    <option value="{{ $b->id }}" {{ old('brand_id', $product->brand_id) == $b->id ? 'selected' : '' }}>
                                        {{ $b->brand_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label-custom">Model</label>
                            <select name="model_id" class="form-select form-input" required>
                                <option value="">Select Model</option>
                                @foreach($models as $m)
                                    <option value="{{ $m->id }}" {{ old('model_id', $product->model_id) == $m->id ? 'selected' : '' }}>
                                        {{ $m->model_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-section-title mb-4">
                        <i class="bi bi-upc"></i>
                        Serial Numbers
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label-custom">Serial No</label>
                            <input type="text" name="serial_no" class="form-control form-input"
                                value="{{ old('serial_no', $product->serial_no) }}" placeholder="Enter serial number">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">Project Serial No</label>
                            <input type="text" name="project_serial_no" class="form-control form-input"
                                value="{{ old('project_serial_no', $product->project_serial_no) }}" placeholder="Enter project serial number">
                        </div>
                    </div>

                    <div class="form-section-title mb-4">
                        <i class="bi bi-geo-alt"></i>
                        Location & Description
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label-custom">Location</label>
                            <input type="text" name="position" class="form-control form-input"
                                value="{{ old('position', $product->position) }}" placeholder="Enter location">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">User Description</label>
                            <textarea name="user_description" class="form-control form-input" rows="3"
                                placeholder="Enter description">{{ old('user_description', $product->user_description) }}</textarea>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label-custom">Remarks</label>
                            <input type="text" name="remarks" class="form-control form-input"
                                value="{{ old('remarks', $product->remarks) }}" placeholder="Enter remarks">
                        </div>
                    </div>

                    <div class="form-section-title mb-4">
                        <i class="bi bi-shield-check"></i>
                        Warranty Period
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label-custom">Warranty Start</label>
                            <input type="date" name="warranty_start" class="form-control form-input"
                                value="{{ old('warranty_start', $product->warranty_start?->format('Y-m-d')) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">Warranty End</label>
                            <input type="date" name="warranty_end" class="form-control form-input"
                                value="{{ old('warranty_end', $product->warranty_end?->format('Y-m-d')) }}">
                        </div>
                    </div>

                    @if($product->warranty_end)
                        <div class="alert alert-info mb-4" style="border-radius: 12px;">
                            <strong>Warranty Status:</strong> {!! $product->warranty_countdown !!}
                        </div>
                    @endif

                    <div class="d-flex justify-content-end gap-3 mt-4 pt-3 border-top">
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary px-4">
                            <i class="bi bi-x-circle me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-edit px-4">
                            <i class="bi bi-check-circle me-1"></i> Update Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection