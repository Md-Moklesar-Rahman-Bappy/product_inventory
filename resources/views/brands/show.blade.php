@extends('layouts.app')

@section('title', 'Show Brand')

@section('contents')
<div class="container py-5">
  <div class="card border-0 shadow-lg rounded-4">
    <div class="card-header text-white" style="background: linear-gradient(90deg, #ff9800, #f44336); padding: 1.5rem;">
      <h3 class="mb-0 fw-bold"><i class="fa fa-tag me-2"></i> Brand Details</h3>
    </div>

    <div class="card-body bg-light" style="padding: 2rem;">
      <div class="row mb-4">
        <div class="col-md-6">
          <label class="form-label fw-semibold text-dark">Brand Name</label>
          <input type="text" class="form-control form-control-lg shadow-sm" value="{{ $brand->brand_name }}" readonly>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 mb-4">
          <label class="form-label fw-semibold text-dark">Created At</label>
          <input type="text" class="form-control shadow-sm" value="{{ $brand->created_at->format('d M Y, h:i A') }}" readonly>
        </div>
        <div class="col-md-6 mb-4">
          <label class="form-label fw-semibold text-dark">Updated At</label>
          <input type="text" class="form-control shadow-sm" value="{{ $brand->updated_at->format('d M Y, h:i A') }}" readonly>
        </div>
      </div>

      <div class="d-flex justify-content-end mt-4">
        <a href="{{ route('brands.index') }}" class="btn btn-outline-secondary btn-lg fw-bold">
          <i class="fa fa-arrow-left me-1"></i> Back to List
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
