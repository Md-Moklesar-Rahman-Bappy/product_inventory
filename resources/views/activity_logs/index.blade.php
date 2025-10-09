@extends('layouts.app')

@section('title', 'Activity Log For Product Inventory System')

@section('contents')
<div class="row">
  <div class="col-md-12">

    <!-- 📜 Activity Logs Card -->
    <div class="card shadow-lg border-0 animate__animated animate__fadeIn">
      <div class="card-header bg-white border-bottom py-3">
        <div class="row align-items-center">
          <div class="col-md-6 d-flex align-items-center gap-3">
            <h5 class="mb-0 text-info fw-bold">
              <i class="fas fa-history me-2"></i> Recent Activity Logs
            </h5>

            <!-- 🔍 Filter Dropdown -->
            <form method="GET" action="{{ route('activity.logs') }}">
              <select name="model" class="form-select form-select-sm border-info text-dark fw-semibold" onchange="this.form.submit()">
                <option value="">All Models</option>
                <option value="Product" {{ request('model') === 'Product' ? 'selected' : '' }}>Product</option>
                <option value="Category" {{ request('model') === 'Category' ? 'selected' : '' }}>Category</option>
                <option value="Brand" {{ request('model') === 'Brand' ? 'selected' : '' }}>Brand</option>
                <option value="Model" {{ request('model') === 'Model' ? 'selected' : '' }}>Model</option>
                <option value="Maintenance" {{ request('model') === 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
              </select>
            </form>
          </div>

          <div class="col-md-6 text-end">
            <span class="badge bg-light text-dark fw-medium px-3 py-2 rounded-pill shadow-sm">
              {{ $logs->total() }} total logs
            </span>
          </div>
        </div>
      </div>

      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-bordered table-hover align-middle mb-0">
            <thead class="table-light text-uppercase text-primary small">
              <tr>
                <th>User</th>
                <th>Action</th>
                <th>Model</th>
                <th>Description</th>
                <th>Time</th>
              </tr>
            </thead>
            <tbody>
              @forelse($logs as $log)
              @php
                $isNoChange = $log->action === 'update' && Str::contains($log->description, 'No changes');
              @endphp
              <tr>
                <td class="fw-semibold text-dark">
                  {{ $log->user->name ?? 'System' }}
                </td>
                <td>
                  <span class="badge
                    @if($log->action === 'create') bg-success
                    @elseif($isNoChange) bg-secondary
                    @elseif($log->action === 'update') bg-primary
                    @elseif($log->action === 'delete') bg-danger
                    @else bg-secondary @endif
                    text-white fw-semibold px-3 py-2 rounded-pill shadow-sm">
                    {{ ucfirst($log->action) }}
                  </span>
                </td>
                <td>
                  <span class="text-muted">{{ $log->model ?? '-' }}</span>
                </td>
                <td class="{{ $isNoChange ? 'text-muted fst-italic' : '' }}">
                  {!! $log->description !!}
                </td>
                <td>
                  <div class="text-nowrap" title="{{ $log->updated_at->format('Y-m-d H:i:s') }}">
                    <strong>{{ $log->updated_at->format('d M Y, h:i:s A') }}</strong><br>
                    <small class="text-muted fst-italic">({{ $log->updated_at->diffForHumans() }})</small>
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="text-center py-5 text-muted">
                  <div class="d-flex flex-column align-items-center justify-content-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" alt="No logs" width="80" class="mb-3 opacity-75">
                    <h6 class="fw-bold text-danger">No activity logs found</h6>
                    <p class="small">Start interacting with the system to generate logs.</p>
                  </div>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <!-- 📄 Pagination -->
        <div class="p-3">
          <x-pagination-block :paginator="$logs" />
        </div>
      </div>
    </div>

  </div>
</div>
@endsection
