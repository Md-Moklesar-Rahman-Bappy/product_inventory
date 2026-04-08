@extends('layouts.app')

@section('title', 'Edit Product')

@section('contents')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="custom-card">
            {{-- Header --}}
            <div class="card-header bg-warning text-dark py-3">
                <h4 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i>Edit Product</h4>
            </div>

            {{-- Form Body --}}
            <div class="card-body p-4">
                {{-- Validation Errors --}}
                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        <strong><i class="bi bi-exclamation-triangle me-1"></i> Please fix the following:</strong>
                        <ul class="mt-2 mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('products.update', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Product Info --}}
                    <h5 class="text-primary fw-bold mb-3"><i class="bi bi-box me-2"></i>Product Info</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" name="product_name" class="form-control"
                                    value="{{ old('product_name', $product->product_name) }}" placeholder="Product Name" required>
                                <label for="product_name">Product Name</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="number" name="price" class="form-control"
                                    value="{{ old('price', $product->price) }}" step="0.01" min="0" placeholder="Price" required>
                                <label for="price">Price (৳)</label>
                            </div>
                            @if($product->price > 100000)
                                <span class="badge bg-danger text-light mt-2">High Value</span>
                            @elseif($product->price < 5000)
                                <span class="badge bg-success mt-2">Budget Pick</span>
                            @endif
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="form-floating">
                                <select name="category_id" class="form-select" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $c)
                                        <option value="{{ $c->id }}" {{ old('category_id', $product->category_id) == $c->id ? 'selected' : '' }}>
                                            {{ $c->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label>Category</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <select name="brand_id" class="form-select" required>
                                    <option value="">Select Brand</option>
                                    @foreach($brands as $b)
                                        <option value="{{ $b->id }}" {{ old('brand_id', $product->brand_id) == $b->id ? 'selected' : '' }}>
                                            {{ $b->brand_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label>Brand</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <select name="model_id" class="form-select" required>
                                    <option value="">Select Model</option>
                                    @foreach($models as $m)
                                        <option value="{{ $m->id }}" {{ old('model_id', $product->model_id) == $m->id ? 'selected' : '' }}>
                                            {{ $m->model_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label>Model</label>
                            </div>
                        </div>
                    </div>

                    {{-- Serial Numbers --}}
                    <h5 class="text-primary fw-bold mb-3"><i class="bi bi-upc me-2"></i>Serial Numbers</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" name="serial_no" class="form-control"
                                    value="{{ old('serial_no', $product->serial_no) }}" placeholder="Serial No">
                                <label for="serial_no">Serial No</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" name="project_serial_no" class="form-control"
                                    value="{{ old('project_serial_no', $product->project_serial_no) }}" placeholder="Project Serial No">
                                <label for="project_serial_no">Project Serial No</label>
                            </div>
                        </div>
                    </div>

                    {{-- Location & Description --}}
                    <h5 class="text-primary fw-bold mb-3"><i class="bi bi-geo-alt me-2"></i>Location & Description</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" name="position" class="form-control"
                                    value="{{ old('position', $product->position) }}" placeholder="Location">
                                <label for="position">Location</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <textarea name="user_description" class="form-control" style="height: 100px"
                                    placeholder="User Description">{{ old('user_description', $product->user_description) }}</textarea>
                                <label for="user_description">User Description</label>
                            </div>
                        </div>
                    </div>

                    {{-- Remarks --}}
                    <h5 class="text-primary fw-bold mb-3"><i class="bi bi-chat-left-text me-2"></i>Remarks</h5>
                    <div class="mb-4">
                        <div class="form-floating">
                            <input type="text" name="remarks" class="form-control"
                                value="{{ old('remarks', $product->remarks) }}" placeholder="Remarks">
                            <label for="remarks">Remarks</label>
                        </div>
                    </div>

                    {{-- Warranty Period --}}
                    <h5 class="text-primary fw-bold mb-3"><i class="bi bi-shield-check me-2"></i>Warranty Period</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="date" name="warranty_start" class="form-control"
                                    value="{{ old('warranty_start', $product->warranty_start?->format('Y-m-d')) }}" placeholder="Warranty Start">
                                <label for="warranty_start">Warranty Start</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="date" name="warranty_end" class="form-control"
                                    value="{{ old('warranty_end', $product->warranty_end?->format('Y-m-d')) }}" placeholder="Warranty End">
                                <label for="warranty_end">Warranty End</label>
                            </div>
                        </div>
                    </div>

                    @if($product->warranty_end)
                        <div class="mb-4">
                            <strong>Status:</strong> {!! $product->warranty_countdown !!}
                        </div>
                    @endif

                    {{-- Submit & Cancel --}}
                    <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary px-4">
                            <i class="bi bi-x-circle me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-warning px-4 fw-bold">
                            <i class="bi bi-check-circle me-1"></i> Update Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection