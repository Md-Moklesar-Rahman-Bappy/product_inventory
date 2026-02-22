@extends('layouts.app')

@section('title', 'Show Product')

@section('contents')
  <div class="container py-4">
    <div class="card shadow-sm">
      <div class="card-header bg-info text-white">
        <h4 class="mb-0"><i class="fa fa-box-open me-2"></i> Product Details</h4>
      </div>

      <div class="card-body">
        {{-- 📦 Product Info --}}
        <h5 class="text-secondary mb-3">📦 Product Info</h5>

        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Product Name</label>
            <input type="text" class="form-control" value="{{ $product->product_name }}" readonly title="{{ $product->product_name }}">
          </div>
          <div class="col-md-6">
            <label class="form-label">Price (৳)</label>
            <input type="text" class="form-control" value="{{ number_format($product->price, 2) }}" readonly title="{{ $product->price }}">
            @if($product->price > 1000000)
              <span class="badge bg-danger text-light mt-2">💸 High Value</span>
            @elseif($product->price < 500000)
              <span class="badge bg-success mt-2">🔖 Budget Pick</span>
            @endif
          </div>
        </div>

        {{-- 🏷️ Brand & Model --}}
        <div class="row mb-3">
          <div class="col-md-4">
            <label class="form-label">Category</label>
            <input type="text" class="form-control" value="{{ $product->category?->category_name ?? 'N/A' }}" readonly title="{{ $product->category?->category_name }}">
          </div>
          <div class="col-md-4">
            <label class="form-label">Brand</label>
            <input type="text" class="form-control" value="{{ $product->brand?->brand_name ?? 'N/A' }}" readonly title="{{ $product->brand?->brand_name }}">
          </div>
          <div class="col-md-4">
            <label class="form-label">Model</label>
            <input type="text" class="form-control" value="{{ $product->model?->model_name ?? 'N/A' }}" readonly title="{{ $product->model?->model_name }}">
          </div>
        </div>

        {{-- 🔢 Serial Numbers --}}
        <h5 class="text-secondary mb-3">🔢 Serial Numbers</h5>
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Serial No</label>
            <input type="text" class="form-control" value="{{ $product->serial_no ?? '-' }}" readonly title="{{ $product->serial_no }}">
          </div>
          <div class="col-md-6">
            <label class="form-label">Project Serial No</label>
            <input type="text" class="form-control" value="{{ $product->project_serial_no ?? '-' }}" readonly title="{{ $product->project_serial_no }}">
          </div>
        </div>

        {{-- 📍 Location & Description --}}
        <h5 class="text-secondary mb-3">📍 Location & Description</h5>
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Location</label>
            <input type="text" class="form-control" value="{{ $product->position ?? '-' }}" readonly title="{{ $product->position }}">
          </div>
          <div class="col-md-6">
            <label class="form-label">User Description</label>
            <textarea class="form-control" rows="3" readonly title="{{ $product->user_description }}">{{ $product->user_description ?? '-' }}</textarea>
          </div>
        </div>

        {{-- 📝 Remarks --}}
        <h5 class="text-secondary mb-3">📝 Remarks</h5>
        <div class="mb-3">
          <label class="form-label">Remarks</label>
          <textarea class="form-control" rows="3" readonly title="{{ $product->remarks }}">{{ $product->remarks ?? '-' }}</textarea>
        </div>

        {{-- 🛡️ Warranty Status with Time --}}
        {{-- <h5 class="text-secondary mb-3">🛡️ Warranty Status</h5>
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Warranty Start</label>
            <input type="text" class="form-control" value="{{ $product->warranty_start?->format('Y-m-d H:i') ?? '-' }}" readonly>
          </div>
          <div class="col-md-6">
            <label class="form-label">Warranty End</label>
            <input type="text" class="form-control" value="{{ $product->warranty_end?->format('Y-m-d H:i') ?? '-' }}" readonly>
          </div>
        </div>

        @php
          $now = now();
          $start = $product->warranty_start;
          $end = $product->warranty_end;
        @endphp

        @if($start && $end)
          @if($now->between($start, $end))
            <div class="alert alert-success shadow-sm">
              <i class="fa fa-check-circle me-1"></i>
              Warranty is active. <strong>{{ $end->diffForHumans($now, ['parts' => 2]) }} remaining</strong>.
            </div>
          @elseif($now->lt($start))
            <div class="alert alert-warning shadow-sm">
              <i class="fa fa-hourglass-start me-1"></i>
              Warranty starts in <strong>{{ $start->diffForHumans($now, ['parts' => 2]) }}</strong>.
            </div>
          @else
            <div class="alert alert-danger shadow-sm">
              <i class="fa fa-times-circle me-1"></i>
              Warranty expired <strong>{{ $end->diffForHumans($now, ['parts' => 2]) }}</strong> ago.
            </div>
          @endif
        @endif --}}
        {{-- 🛡️ Warranty Status --}}
        <h5 class="text-secondary mb-3">🛡️ Warranty Status</h5>
        <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Warranty Start</label>
            <input type="text" class="form-control"
                value="{{ $product->warranty_start?->format('Y-m-d') ?? '-' }}" readonly>
        </div>
        <div class="col-md-6">
            <label class="form-label">Warranty End</label>
            <input type="text" class="form-control"
                value="{{ $product->warranty_end?->format('Y-m-d') ?? '-' }}" readonly>
        </div>
        </div>

        @php
        $now = now();
        $start = $product->warranty_start;
        $end = $product->warranty_end;
        @endphp

        @if($start && $end)
        @if($now->between($start, $end))
            <div class="alert alert-success shadow-sm">
            <i class="fa fa-check-circle me-1"></i>
            Warranty is active. <strong>{{ $end->diffForHumans($now, ['parts' => 2]) }} remaining</strong>.
            </div>
        @elseif($now->lt($start))
            <div class="alert alert-warning shadow-sm">
            <i class="fa fa-hourglass-start me-1"></i>
            Warranty starts in <strong>{{ $start->diffForHumans($now, ['parts' => 2]) }}</strong>.
            </div>
        @else
            <div class="alert alert-danger shadow-sm">
            <i class="fa fa-times-circle me-1"></i>
            Warranty expired <strong>{{ $end->diffForHumans($now, ['parts' => 2]) }}</strong> ago.
            </div>
        @endif
        @endif

        {{-- 📅 Timestamps --}}
        <h5 class="text-secondary mb-3">📅 Timestamps</h5>
        <div class="row">
          <div class="col-md-6">
            <label class="form-label">Created At</label>
            <input type="text" class="form-control" value="{{ $product->created_at->format('Y-m-d H:i') }}" readonly>
          </div>
          <div class="col-md-6">
            <label class="form-label">Updated At</label>
            <input type="text" class="form-control" value="{{ $product->updated_at->format('Y-m-d H:i') }}" readonly>
          </div>
        </div>

        {{-- 🔙 Back Button --}}
        <div class="mt-4">
          <a href="{{ url()->previous() }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left me-1"></i> Go Back
          </a>
        </div>
      </div>
    </div>
  </div>
@endsection
