@extends('layouts.app')

@section('title', 'Edit Product')

@section('contents')
<div class="container py-4">
  <div class="card shadow-sm">
    <div class="card-header bg-warning text-dark">
      <h4 class="mb-0"><i class="fa fa-edit me-2"></i> Edit Product</h4>
    </div>

    <div class="card-body">
      {{-- Validation Errors --}}
      @if($errors->any())
        <div class="alert alert-danger">
          <strong>Validation Error:</strong>
          <ul class="mb-0">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- 📦 Product Info --}}
        <h5 class="text-secondary mb-3">📦 Product Info</h5>

        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Product Name</label>
            <input type="text" name="product_name" class="form-control"
              value="{{ old('product_name', $product->product_name) }}" required>
            @error('product_name') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">Price (৳)</label>
            <input type="number" name="price" class="form-control"
              value="{{ old('price', $product->price) }}" step="0.01" min="0" required>
            @error('price') <small class="text-danger">{{ $message }}</small> @enderror

            {{-- Optional Badge Preview --}}
            @if($product->price > 100000)
              <span class="badge bg-danger text-light mt-2">💸 High Value</span>
            @elseif($product->price < 5000)
              <span class="badge bg-success mt-2">🔖 Budget Pick</span>
            @endif
          </div>
        </div>

        {{-- 🏷️ Brand & Model --}}
        <div class="row mb-3">
          <div class="col-md-4">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-control" required>
              <option value="">Select Category</option>
              @foreach($categories as $c)
                <option value="{{ $c->id }}" {{ old('category_id', $product->category_id) == $c->id ? 'selected' : '' }}>
                  {{ $c->category_name }}
                </option>
              @endforeach
            </select>
            @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
          <div class="col-md-4">
            <label class="form-label">Brand</label>
            <select name="brand_id" class="form-control" required>
              <option value="">Select Brand</option>
              @foreach($brands as $b)
                <option value="{{ $b->id }}" {{ old('brand_id', $product->brand_id) == $b->id ? 'selected' : '' }}>
                  {{ $b->brand_name }}
                </option>
              @endforeach
            </select>
            @error('brand_id') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
          <div class="col-md-4">
            <label class="form-label">Model</label>
            <select name="model_id" class="form-control" required>
              <option value="">Select Model</option>
              @foreach($models as $m)
                <option value="{{ $m->id }}" {{ old('model_id', $product->model_id) == $m->id ? 'selected' : '' }}>
                  {{ $m->model_name }}
                </option>
              @endforeach
            </select>
            @error('model_id') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
        </div>

        {{-- 🔢 Serial Numbers --}}
        <h5 class="text-secondary mb-3">🔢 Serial Numbers</h5>
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Serial No</label>
            <input type="text" name="serial_no" class="form-control"
              value="{{ old('serial_no', $product->serial_no) }}">
            @error('serial_no') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">Project Serial No</label>
            <input type="text" name="project_serial_no" class="form-control"
              value="{{ old('project_serial_no', $product->project_serial_no) }}">
            @error('project_serial_no') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
        </div>

        {{-- 📍 Location & Description --}}
        <h5 class="text-secondary mb-3">📍 Location & Description</h5>
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Location</label>
            <input type="text" name="position" class="form-control"
              value="{{ old('position', $product->position) }}">
            @error('position') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">User Description</label>
            <textarea name="user_description" class="form-control" rows="3">{{ old('user_description', $product->user_description) }}</textarea>
            @error('user_description') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
        </div>

        {{-- 📝 Remarks --}}
        <h5 class="text-secondary mb-3">📝 Remarks</h5>
        <div class="mb-3">
          <label class="form-label">Remarks</label>
          <input type="text" name="remarks" class="form-control"
            value="{{ old('remarks', $product->remarks) }}">
          @error('remarks') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- 🛡️ Warranty Period With Time --}}
        {{-- <h5 class="text-secondary mb-3">🛡️ Warranty Period</h5>
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Warranty Start</label>
            <input type="date" name="warranty_start" class="form-control"
              value="{{ old('warranty_start', $product->warranty_start?->format('Y-m-d')) }}">
            @error('warranty_start') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">Warranty End</label>
            <input type="date" name="warranty_end" class="form-control"
              value="{{ old('warranty_end', $product->warranty_end?->format('Y-m-d')) }}">
            @error('warranty_end') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
        </div> --}}
        {{-- 🛡️ Warranty Period --}}
        <h5 class="text-secondary mb-3">🛡️ Warranty Period</h5>
        <div class="row mb-3">
        <div class="col-md-6">
            <label for="warranty_start" class="form-label">Warranty Start</label>
            <input type="date" id="warranty_start" name="warranty_start"
                class="form-control shadow-sm @error('warranty_start') is-invalid @enderror"
                value="{{ old('warranty_start', $product->warranty_start?->format('Y-m-d')) }}">
            @error('warranty_start')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="warranty_end" class="form-label">Warranty End</label>
            <input type="date" id="warranty_end" name="warranty_end"
                class="form-control shadow-sm @error('warranty_end') is-invalid @enderror"
                value="{{ old('warranty_end', $product->warranty_end?->format('Y-m-d')) }}">
            @error('warranty_end')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        </div>

        {{-- Optional Live Badge Preview --}}
        @if($product->warranty_end)
          <div class="mb-3">
            <strong>Status:</strong> {!! $product->warranty_countdown !!}
          </div>
        @endif

        {{-- Submit & Cancel --}}
        <div class="d-flex justify-content-between mt-4">
          <button class="btn btn-warning">
            <i class="fa fa-save me-1"></i> Update
          </button>
          <a href="{{ route('products.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left me-1"></i> Cancel
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
