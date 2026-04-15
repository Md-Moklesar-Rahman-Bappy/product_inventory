@extends('layouts.app')

@section('title', 'Create Product')

@section('contents')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="modern-table-card">
            <div class="table-header-section">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="header-icon">
                            <i class="bi bi-plus-circle-fill"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold text-white">Add New Product</h4>
                            <small class="text-white opacity-75">Fill in the details to create a new product</small>
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

                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                    @csrf

                    <div class="form-section-title mb-4">
                        <i class="bi bi-box"></i>
                        Product Information
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label-custom">Product Name</label>
                            <input type="text" id="product_name" name="product_name"
                                   class="form-control form-input @error('product_name') is-invalid @enderror"
                                   value="{{ old('product_name') }}" placeholder="Enter product name" required>
                            @error('product_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-custom">Price (৳)</label>
                            <input type="number" id="price" name="price"
                                   class="form-control form-input @error('price') is-invalid @enderror"
                                   value="{{ old('price') }}" step="0.01" min="0" placeholder="0.00" required>
                            @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label-custom">Category</label>
                            <select name="category_id" id="category_id"
                                    class="form-select form-input @error('category_id') is-invalid @enderror" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>
                                        {{ $c->category_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label-custom">Brand</label>
                            <select name="brand_id" id="brand_id"
                                    class="form-select form-input @error('brand_id') is-invalid @enderror" required>
                                <option value="">Select Brand</option>
                                @foreach($brands as $b)
                                    <option value="{{ $b->id }}" {{ old('brand_id') == $b->id ? 'selected' : '' }}>
                                        {{ $b->brand_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('brand_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label-custom">Model</label>
                            <select name="model_id" id="model_id"
                                    class="form-select form-input @error('model_id') is-invalid @enderror" required>
                                <option value="">Select Model</option>
                                @foreach($models as $m)
                                    <option value="{{ $m->id }}" {{ old('model_id') == $m->id ? 'selected' : '' }}>
                                        {{ $m->model_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('model_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="form-section-title mb-4">
                        <i class="bi bi-upc"></i>
                        Serial Numbers
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label-custom">Serial No</label>
                            <input type="text" id="serial_no" name="serial_no"
                                   class="form-control form-input @error('serial_no') is-invalid @enderror"
                                   value="{{ old('serial_no') }}" placeholder="Enter serial number" required>
                            @error('serial_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-custom">Project Serial No</label>
                            <input type="text" id="project_serial_no" name="project_serial_no"
                                   class="form-control form-input @error('project_serial_no') is-invalid @enderror"
                                   value="{{ old('project_serial_no') }}" placeholder="Enter project serial number" required>
                            @error('project_serial_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="form-section-title mb-4">
                        <i class="bi bi-geo-alt"></i>
                        Location & Description
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label-custom">Location</label>
                            <input type="text" id="position" name="position"
                                   class="form-control form-input @error('position') is-invalid @enderror"
                                   value="{{ old('position') }}" placeholder="Enter location">
                            @error('position') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-custom">User Description</label>
                            <textarea id="user_description" name="user_description"
                                      class="form-control form-input @error('user_description') is-invalid @enderror"
                                      rows="3" placeholder="Enter description">{{ old('user_description') }}</textarea>
                            @error('user_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label-custom">Remarks</label>
                            <input type="text" id="remarks" name="remarks"
                                   class="form-control form-input @error('remarks') is-invalid @enderror"
                                   value="{{ old('remarks') }}" placeholder="Enter remarks">
                            @error('remarks') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="form-section-title mb-4">
                        <i class="bi bi-shield-check"></i>
                        Warranty Period
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label-custom">Warranty Start</label>
                            <input type="date" id="warranty_start" name="warranty_start"
                                class="form-control form-input @error('warranty_start') is-invalid @enderror"
                                value="{{ old('warranty_start') }}">
                            @error('warranty_start') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-custom">Warranty End</label>
                            <input type="date" id="warranty_end" name="warranty_end"
                                class="form-control form-input @error('warranty_end') is-invalid @enderror"
                                value="{{ old('warranty_end') }}">
                            @error('warranty_end') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3 mt-4 pt-3 border-top">
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary px-4">
                            <i class="bi bi-x-circle me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-add px-4">
                            <i class="bi bi-check-circle me-1"></i> Create Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const brandSelect = document.getElementById('brand_id');
    const modelSelect = document.getElementById('model_id');
    const productInput = document.getElementById('product_name');

    function updateProductName() {
        const brandText = brandSelect.options[brandSelect.selectedIndex]?.text || '';
        const modelText = modelSelect.options[modelSelect.selectedIndex]?.text || '';
        const combined = `${brandText} ${modelText}`.trim();
        if (combined.trim() && combined !== 'Select Brand' && combined !== 'Select Model') {
            productInput.value = combined;
        }
    }

    brandSelect.addEventListener('change', updateProductName);
    modelSelect.addEventListener('change', updateProductName);
});
</script>
@endpush