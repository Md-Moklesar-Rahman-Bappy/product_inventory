@extends('layouts.app')

@section('title', 'Create Product')

@section('contents')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="custom-card">
            {{-- Header --}}
            <div class="card-header bg-primary text-white py-3">
                <h3 class="mb-0 fw-bold"><i class="bi bi-plus-circle me-2"></i> Add New Product</h3>
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

                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Product Info --}}
                    <h5 class="text-primary fw-bold mb-3"><i class="bi bi-box me-2"></i> Product Info</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" id="product_name" name="product_name"
                                       class="form-control @error('product_name') is-invalid @enderror"
                                       value="{{ old('product_name') }}" placeholder="Product Name" required>
                                <label for="product_name">Product Name</label>
                                @error('product_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="number" id="price" name="price"
                                       class="form-control @error('price') is-invalid @enderror"
                                       value="{{ old('price') }}" step="0.01" min="0" placeholder="Price" required>
                                <label for="price">Price (৳)</label>
                                @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="form-floating">
                                <select name="category_id" id="category_id"
                                        class="form-select @error('category_id') is-invalid @enderror" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $c)
                                        <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>
                                            {{ $c->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="category_id">Category</label>
                                @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating">
                                <select name="brand_id" id="brand_id"
                                        class="form-select @error('brand_id') is-invalid @enderror" required>
                                    <option value="">Select Brand</option>
                                    @foreach($brands as $b)
                                        <option value="{{ $b->id }}" {{ old('brand_id') == $b->id ? 'selected' : '' }}>
                                            {{ $b->brand_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="brand_id">Brand</label>
                                @error('brand_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating">
                                <select name="model_id" id="model_id"
                                        class="form-select @error('model_id') is-invalid @enderror" required>
                                    <option value="">Select Model</option>
                                    @foreach($models as $m)
                                        <option value="{{ $m->id }}" {{ old('model_id') == $m->id ? 'selected' : '' }}>
                                            {{ $m->model_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="model_id">Model</label>
                                @error('model_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const brandSelect = document.getElementById('brand_id');
                            const modelSelect = document.getElementById('model_id');
                            const productInput = document.getElementById('product_name');

                            function updateProductName() {
                                const brandText = brandSelect.options[brandSelect.selectedIndex]?.text || '';
                                const modelText = modelSelect.options[modelSelect.selectedIndex]?.text || '';
                                const combined = `${brandText} ${modelText}`.trim();
                                if (combined.trim()) {
                                    productInput.value = combined;
                                }
                            }

                            brandSelect.addEventListener('change', updateProductName);
                            modelSelect.addEventListener('change', updateProductName);
                        });
                    </script>

                    {{-- Serial Numbers --}}
                    <h5 class="text-primary fw-bold mb-3"><i class="bi bi-upc me-2"></i> Serial Numbers</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" id="serial_no" name="serial_no"
                                       class="form-control @error('serial_no') is-invalid @enderror"
                                       value="{{ old('serial_no') }}" placeholder="Serial No" required>
                                <label for="serial_no">Serial No</label>
                                @error('serial_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" id="project_serial_no" name="project_serial_no"
                                       class="form-control @error('project_serial_no') is-invalid @enderror"
                                       value="{{ old('project_serial_no') }}" placeholder="Project Serial No" required>
                                <label for="project_serial_no">Project Serial No</label>
                                @error('project_serial_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Location & Description --}}
                    <h5 class="text-primary fw-bold mb-3"><i class="bi bi-geo-alt me-2"></i> Location & Description</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" id="position" name="position"
                                       class="form-control @error('position') is-invalid @enderror"
                                       value="{{ old('position') }}" placeholder="Location">
                                <label for="position">Location</label>
                                @error('position') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <textarea id="user_description" name="user_description"
                                          class="form-control @error('user_description') is-invalid @enderror"
                                          style="height: 100px" placeholder="User Description">{{ old('user_description') }}</textarea>
                                <label for="user_description">User Description</label>
                                @error('user_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Remarks --}}
                    <h5 class="text-primary fw-bold mb-3"><i class="bi bi-chat-left-text me-2"></i> Remarks</h5>
                    <div class="mb-4">
                        <div class="form-floating">
                            <input type="text" id="remarks" name="remarks"
                                   class="form-control @error('remarks') is-invalid @enderror"
                                   value="{{ old('remarks') }}" placeholder="Remarks">
                            <label for="remarks">Remarks</label>
                            @error('remarks') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Warranty Period --}}
                    <h5 class="text-primary fw-bold mb-3"><i class="bi bi-shield-check me-2"></i> Warranty Period</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="date" id="warranty_start" name="warranty_start"
                                    class="form-control @error('warranty_start') is-invalid @enderror"
                                    value="{{ old('warranty_start') }}" placeholder="Warranty Start">
                                <label for="warranty_start">Warranty Start</label>
                                @error('warranty_start') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="date" id="warranty_end" name="warranty_end"
                                    class="form-control @error('warranty_end') is-invalid @enderror"
                                    value="{{ old('warranty_end') }}" placeholder="Warranty End">
                                <label for="warranty_end">Warranty End</label>
                                @error('warranty_end') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Submit Buttons --}}
                    <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary px-4">
                            <i class="bi bi-x-circle me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">
                            <i class="bi bi-check-circle me-1"></i> Create Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection