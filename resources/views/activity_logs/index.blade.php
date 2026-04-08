@extends('layouts.app')

@section('title', 'Activity Log')

@section('contents')
<div class="row">
  <div class="col-md-12">

    <!-- Activity Logs Card -->
    <div class="custom-card">
      <div class="card-header bg-primary text-white py-3">
        <div class="row align-items-center">
          <div class="col-md-6 d-flex align-items-center gap-3">
            <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Activity Log</h5>
          </div>

          <div class="col-md-6">
            <form method="GET" action="{{ route('activity.logs') }}" class="d-flex gap-2 justify-content-md-end">
              <select name="model" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">All Actions</option>
                <option value="login" {{ request('model') === 'login' ? 'selected' : '' }}>Login</option>
                <option value="logout" {{ request('model') === 'logout' ? 'selected' : '' }}>Logout</option>
                <option value="create" {{ request('model') === 'create' ? 'selected' : '' }}>Create</option>
                <option value="update" {{ request('model') === 'update' ? 'selected' : '' }}>Update</option>
                <option value="delete" {{ request('model') === 'delete' ? 'selected' : '' }}>Delete</option>
                <option value="restore" {{ request('model') === 'restore' ? 'selected' : '' }}>Restore</option>
                <option value="Product" {{ request('model') === 'Product' ? 'selected' : '' }}>Product</option>
                <option value="Category" {{ request('model') === 'Category' ? 'selected' : '' }}>Category</option>
                <option value="Brand" {{ request('model') === 'Brand' ? 'selected' : '' }}>Brand</option>
                <option value="Model" {{ request('model') === 'Model' ? 'selected' : '' }}>Model</option>
                <option value="Maintenance" {{ request('model') === 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                <option value="User" {{ request('model') === 'User' ? 'selected' : '' }}>User</option>
              </select>
            </form>
          </div>
        </div>
      </div>

      <div class="card-body p-0">
        @if($logs->total() > 0)
        <div class="badge bg-light text-dark m-3">
            <i class="bi bi-info-circle me-1"></i>{{ $logs->total() }} total activities
        </div>
        @endif

        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-uppercase small">
              <tr>
                <th style="width: 50px;">#</th>
                <th style="min-width: 150px;">User</th>
                <th style="width: 100px;">Action</th>
                <th style="width: 100px;">Type</th>
                <th style="min-width: 300px;">Description</th>
                <th style="width: 150px;">Time</th>
              </tr>
            </thead>
            <tbody>
              @forelse($logs as $index => $log)
              @php
                $isNoChange = $log->action === 'update' && Str::contains($log->description, 'No changes');
                
                $actionColors = [
                    'login' => 'bg-success',
                    'logout' => 'bg-warning',
                    'create' => 'bg-success',
                    'update' => 'bg-primary',
                    'delete' => 'bg-danger',
                    'restore' => 'bg-info',
                    'status-toggle' => 'bg-secondary',
                    'send-credentials' => 'bg-info',
                    'verification-init' => 'bg-info',
                ];
                $badgeClass = $actionColors[$log->action] ?? 'bg-secondary';
              @endphp
              <tr>
                <td class="text-muted">{{ $index + 1 }}</td>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    @if($log->user)
                    <img src="{{ $log->user->profile_photo_url }}" 
                         alt="{{ $log->user->name }}" 
                         class="rounded-circle"
                         style="width: 32px; height: 32px; object-fit: cover;">
                    <div>
                      <div class="fw-semibold">{{ $log->user->name }}</div>
                      <small class="text-muted">{{ $log->user->email }}</small>
                    </div>
                    @else
                    <i class="bi bi-gear text-muted" style="font-size: 1.5rem;"></i>
                    <div>
                      <div class="fw-semibold">System</div>
                      <small class="text-muted">Automated action</small>
                    </div>
                    @endif
                  </div>
                </td>
                <td>
                  <span class="badge {{ $badgeClass }}">
                    {{ ucfirst($log->action) }}
                  </span>
                </td>
                <td><span class="text-muted">{{ $log->model ?? '-' }}</span></td>
                <td class="{{ $isNoChange ? 'text-muted fst-italic' : '' }}">
                  {!! $log->description !!}
                </td>
                <td>
                  <div class="text-nowrap">
                    <div class="fw-medium">{{ $log->updated_at->format('d M Y') }}</div>
                    <small class="text-muted">{{ $log->updated_at->format('h:i A') }}</small>
                    <div><small class="text-info">{{ $log->updated_at->diffForHumans() }}</small></div>
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="6" class="text-center py-5">
                  <div class="d-flex flex-column align-items-center">
                    <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                    <h6 class="fw-bold text-muted mt-3">No activity logs found</h6>
                    <p class="text-muted small">Start interacting with the system to generate logs.</p>
                  </div>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="p-3">
            <x-pagination-block :paginator="$logs" />
        </div>
      </div>
    </div>
  </div>
</div>
@endSection