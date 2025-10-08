@extends('layouts.app')

@section('title', 'Create Brand')

@section('contents')
<div class="container py-5">
  <div class="card border-0 shadow-lg rounded-4">
    <div class="card-header text-white" style="background: linear-gradient(90deg, #ff5722, #ff9800); padding: 1.5rem;">
      <h3 class="mb-0 fw-bold"><i class="fa fa-plus-circle me-2"></i> Add New Brand</h3>
    </div>

    <div class="card-body bg-light" style="padding: 2rem;">
      <form action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Brand Name --}}
        <div class="mb-4">
          <label for="brand_name" class="form-label fw-semibold text-dark">Brand Name</label>
          <input type="text" name="brand_name" id="brand_name" class="form-control form-control-lg shadow-sm" placeholder="Enter brand name..." value="{{ old('brand_name') }}" required>
        </div>

        {{-- Submit Button --}}
        <div class="d-grid mt-4">
          <button type="submit" class="btn btn-success px-4">
              <i class="fa fa-check-circle me-1"></i> Create
            </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
