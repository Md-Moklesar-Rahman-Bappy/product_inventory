@extends('layouts.app')

@section('title', 'Maintenance Records')

@section('contents')
<div class="container py-5">
  <div class="card border-0 shadow-lg rounded-4">
    <div class="card-header bg-info text-white py-3">
      <h3 class="mb-0 fw-bold">
        <i class="fa fa-tools me-2"></i> Maintenance History
        <span class="badge bg-light text-dark ms-3">{{ $maintenances->total() }}</span>
      </h3>
    </div>

    <div class="card-body bg-light px-4 py-5">
      @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm fw-semibold" role="alert">
          <i class="fa fa-check-circle me-1"></i> {{ Session::get('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      {{-- Active Maintenance Table --}}
      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle text-center shadow-sm">
          <thead class="bg-light text-uppercase fw-bold text-primary">
            <tr>
              <th>SL</th>
              <th>Product</th>
              <th>Serial No</th>
              <th>Issue</th>
              <th>Start</th>
              <th>End</th>
              <th>Status</th>
              <th>Warranty</th>
              <th>Logged By</th>
              <th style="min-width: 140px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($maintenances as $index => $m)
              <tr>
                <td>{{ $maintenances->firstItem() + $index }}</td>
                <td>{{ $m->product->product_name }}</td>
                <td>{{ $m->product->serial_no }}</td>
                <td>{{ Str::limit($m->description, 40) }}</td>
                <td>{{ $m->start_time->format('d M Y, h:i A') }}</td>
                <td>{{ $m->end_time->format('d M Y, h:i A') }}</td>
                <td>
                  @if(now()->between($m->start_time, $m->end_time))
                    <span class="badge bg-warning text-dark">In Progress</span>
                  @elseif(now()->lt($m->start_time))
                    <span class="badge bg-info text-dark">Scheduled</span>
                  @else
                    <span class="badge bg-success">Completed</span>
                  @endif
                </td>
                <td>{!! $m->product->warranty_countdown !!}</td>
                <td>{{ $m->user->name ?? 'System' }}</td>
                <td>
                  <div class="action-buttons">
                    <a href="{{ route('maintenance.show', $m->id) }}" class="btn btn-sm btn-outline-info" title="View">
                      <i class="fa fa-eye"></i>
                    </a>
                    @if(auth()->user()->permission <= 1)
                      <a href="{{ route('maintenance.edit', $m->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                        <i class="fa fa-edit"></i>
                      </a>
                      <form action="{{ route('maintenance.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Delete this record?')" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                          <i class="fa fa-trash"></i>
                        </button>
                      </form>
                    @endif
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="10" class="text-center py-5 text-muted">
                  <i class="fa fa-tools fa-2x mb-3 text-danger"></i>
                  <h5 class="fw-bold">No maintenance records found</h5>
                  <p class="small">Start by logging a maintenance entry for a product.</p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{-- Pagination --}}
      <div class="mt-4">
        <x-pagination-block :paginator="$maintenances" />
      </div>

      {{-- Recycle Bin Section --}}
      @if(auth()->user()->permission <= 1 && $trashedMaintenances->total() > 0)
        <div class="mt-5">
          <h5 class="text-danger fw-bold"><i class="fa fa-trash-alt me-2"></i> Archived Maintenance</h5>
          <table class="table table-bordered table-hover text-center shadow-sm">
            <thead class="bg-light">
              <tr>
                <th>Product</th>
                <th>Serial No</th>
                <th>Issue</th>
                <th>Deleted At</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($trashedMaintenances as $archived)
                <tr class="table-danger">
                  <td>{{ $archived->product->product_name }}</td>
                  <td>{{ $archived->product->serial_no }}</td>
                  <td>{{ Str::limit($archived->description, 40) }}</td>
                  <td>{{ $archived->deleted_at->format('d M Y, h:i A') }}</td>
                  <td>
                    <form action="{{ route('maintenance.restore', $archived->id) }}" method="POST">
                      @csrf
                      <button class="btn btn-sm btn-success fw-bold" title="Restore Maintenance">
                        <i class="fa fa-undo"></i> Restore
                      </button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <x-pagination-block :paginator="$trashedMaintenances" />
        </div>
      @endif
    </div>
  </div>
</div>
@endsection
