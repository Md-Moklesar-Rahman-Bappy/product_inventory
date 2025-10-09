@extends('layouts.app')

@section('title', 'Show Category')

@section('contents')
<div class="container py-5">
  <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

    {{-- Gradient Header --}}
    <div class="card-header text-white" style="background: linear-gradient(90deg, #4CAF50, #81C784); padding: 1.5rem;">
      <h3 class="mb-0 fw-bold"><i class="fa fa-info-circle me-2"></i> Category Details</h3>
    </div>

    {{-- Card Body --}}
    <div class="card-body bg-light" style="padding: 2rem;">
      <div class="row mb-4">
        <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold text-dark">Category Name</label>
          <input type="text" class="form-control form-control-lg shadow-sm" value="{{ $category->category_name }}" readonly>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold text-dark">Created At</label>
          <input type="text" class="form-control shadow-sm" value="{{ $category->created_at->format('d M Y, h:i A') }}" readonly>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold text-dark">Updated At</label>
          <input type="text" class="form-control shadow-sm" value="{{ $category->updated_at->format('d M Y, h:i A') }}" readonly>
        </div>
      </div>

      {{-- Back Button --}}
      <div class="mt-4">
        <a href="{{ route('categories.index') }}" class="btn btn-gradient fw-bold">
          <i class="fa fa-arrow-left me-1"></i> Back to Category List
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
