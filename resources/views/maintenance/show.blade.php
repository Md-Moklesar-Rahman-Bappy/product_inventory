@extends('layouts.app')

@section('title', 'Maintenance Details')

@section('contents')
<div class="container py-5">
  <div class="card border-0 shadow-lg rounded-4">
    <div class="card-header bg-info text-white py-3">
      <h3 class="mb-0 fw-bold">
        <i class="fa fa-wrench me-2"></i> Maintenance #{{ $maintenance->id }}
      </h3>
    </div>

    <div class="card-body bg-light px-4 py-5">
      <div class="row mb-4">
        <div class="col-md-6">
          <h5 class="fw-bold text-primary">🔧 Product Info</h5>
          <p><strong>Name:</strong> {{ $maintenance->product->product_name }}</p>
          <p><strong>Serial No:</strong> {{ $maintenance->product->serial_no }}</p>
        </div>
        <div class="col-md-6">
          <h5 class="fw-bold text-primary">🛠️ Maintenance Details</h5>
          <p><strong>Issue:</strong> {{ $maintenance->description }}</p>
          <p><strong>Start:</strong> {{ $maintenance->start_time->format('d M Y, h:i A') }}</p>
          <p><strong>End:</strong> {{ $maintenance->end_time->format('d M Y, h:i A') }}</p>
          <p><strong>Status:</strong>
            @if(now()->between($maintenance->start_time, $maintenance->end_time))
              <span class="badge bg-warning text-dark">In Progress</span>
            @elseif(now()->lt($maintenance->start_time))
              <span class="badge bg-info text-dark">Scheduled</span>
            @else
              <span class="badge bg-success">Completed</span>
            @endif
          </p>
        </div>
      </div>

      <div class="mb-4">
        <h5 class="fw-bold text-primary">👤 Logged By</h5>
        <p>{{ $maintenance->user->name ?? 'System' }}</p>
      </div>

      <div class="d-flex justify-content-between">
        @if(auth()->user()->permission <= 1)
          <a href="{{ route('maintenance.edit', $maintenance->id) }}" class="btn btn-sm btn-outline-warning">
            <i class="fa fa-edit me-1"></i> Edit
          </a>

          <form action="{{ route('maintenance.destroy', $maintenance->id) }}" method="POST" onsubmit="return confirm('Delete this record?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-outline-danger">
              <i class="fa fa-trash me-1"></i> Delete
            </button>
          </form>
        @endif

        <a href="{{ route('maintenance.index') }}" class="btn btn-secondary">
          <i class="fa fa-arrow-left me-1"></i> Back to List
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
