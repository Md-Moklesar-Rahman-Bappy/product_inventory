@extends('layouts.app')

@section('title', 'Edit Brand')

@section('contents')
<div class="container py-5">
  <div class="card border-0 shadow-lg rounded-4">
    <div class="card-header text-white" style="background: linear-gradient(90deg, #ff9800, #f44336); padding: 1.5rem;">
      <h3 class="mb-0 fw-bold"><i class="fa fa-edit me-2"></i> Edit Brand</h3>
    </div>

    <div class="card-body bg-light" style="padding: 2rem;">
      <form action="{{ route('brands.update', $brand->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Brand Name --}}
        <div class="mb-4">
          <label for="brand_name" class="form-label fw-semibold text-dark">Brand Name</label>
          <input type="text" name="brand_name" id="brand_name" class="form-control form-control-lg shadow-sm" placeholder="Enter brand name..." value="{{ $brand->brand_name }}" required>
        </div>

        {{-- Submit Button --}}
        <div class="d-grid mt-4">
          <button type="submit" class="btn btn-warning btn-lg fw-bold shadow-sm">
            <i class="fa fa-save me-1"></i> Update
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
