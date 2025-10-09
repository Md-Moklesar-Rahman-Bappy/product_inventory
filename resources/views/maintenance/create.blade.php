@extends('layouts.app')

@section('title', 'Log Maintenance')

@section('contents')
<div class="container py-5">
  <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
    <div class="card-header bg-primary text-white py-3">
      <h3 class="mb-0 fw-bold"><i class="fa fa-tools me-2"></i> Create Maintenance Record</h3>
    </div>

    <div class="card-body bg-white px-4 py-5">
      @if($errors->any())
        <div class="alert alert-danger shadow-sm">
          <strong><i class="fa fa-exclamation-triangle me-1"></i> Please fix the following:</strong>
          <ul class="mt-2 mb-0">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('maintenance.store') }}" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">

        {{-- Product Info --}}
        <h5 class="text-primary fw-bold mb-3"><i class="fa fa-box-open me-2"></i> Product Details</h5>
        <div class="row g-3 mb-4">
          <div class="col-md-6">
            <label class="form-label">Product Name</label>
            <input type="text" class="form-control" value="{{ $product->product_name }}" readonly>
          </div>
          <div class="col-md-6">
            <label class="form-label">Serial No</label>
            <input type="text" class="form-control" value="{{ $product->serial_no }}" readonly>
          </div>
          <div class="col-md-6">
            <label class="form-label">Project Serial No</label>
            <input type="text" class="form-control" value="{{ $product->project_serial_no }}" readonly>
          </div>
          <div class="col-md-6">
            <label class="mt-5">Warranty</label>
            <td>{!! $product->warranty_countdown !!}</td>
          </div>
        </div>

        {{-- Problem Description --}}
        <h5 class="text-primary fw-bold mb-3"><i class="fa fa-exclamation-circle me-2"></i> Problem Description</h5>
        <div class="mb-4">
          <textarea name="description" class="form-control" rows="4" placeholder="Describe the issue..." required>{{ old('description') }}</textarea>
        </div>

        {{-- Maintenance Timeline --}}
        <h5 class="text-primary fw-bold mb-3"><i class="fa fa-calendar-alt me-2"></i> Maintenance Timeline</h5>
        <div class="row g-3 mb-4">
          <div class="col-md-6">
            <label class="form-label">Start Date</label>
            <input type="date" name="start_time" class="form-control" value="{{ old('start_time') }}" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">End Date</label>
            <input type="date" name="end_time" class="form-control" value="{{ old('end_time') }}" required>
          </div>
        </div>

        {{-- Submit --}}
        <div class="d-flex justify-content-between mt-4">
          <button type="submit" class="btn btn-primary px-4 fw-bold">
            <i class="fa fa-check-circle me-1"></i> Create
          </button>
          <a href="{{ route('products.index') }}" class="btn btn-outline-secondary px-4">
            <i class="fa fa-times-circle me-1"></i> Cancel
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
