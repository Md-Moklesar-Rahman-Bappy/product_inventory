@extends('layouts.app')

@section('title', 'Activity Log')

@section('contents')
<div class="row">
    <div class="col-lg-12">
        <div class="custom-card border-0 shadow-sm">
            {{-- Header Section --}}
            <div class="card-header bg-white border-bottom py-3">
                <div class="row gy-3 align-items-center">
                    <div class="col-12 col-lg-6 d-flex align-items-center">
                        <div class="icon-box bg-primary text-white">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0 fw-bold text-dark">Activity Log</h5>
                            <small class="text-muted">{{ $logs->total() }} total activities</small>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <form method="GET" action="{{ route('activity.logs') }}" class="d-flex gap-2 justify-content-lg-end">
                            <select name="model" class="form-select form-select-sm" style="width: 150px;" onchange="this.form.submit()">
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

            {{-- Table Section --}}
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4" style="width: 50px;">#</th>
                                <th style="min-width: 180px;">User</th>
                                <th style="width: 100px;">Action</th>
                                <th style="width: 100px;">Type</th>
                                <th style="min-width: 280px;">Description</th>
                                <th style="width: 140px;">Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $index => $log)
                            @php
                                $isNoChange = $log->action === 'update' && Str::contains($log->description, 'No changes');
                                
                                $actionColors = [
                                    'login' => 'bg-success',
                                    'logout' => 'bg-warning text-dark',
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
                            <tr class="table-row">
                                <td class="ps-4 text-muted">{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($log->user)
                                        <img src="{{ $log->user->profile_photo_url }}" 
                                             alt="{{ $log->user->name }}" 
                                             class="rounded-circle me-2"
                                             style="width: 32px; height: 32px; object-fit: cover;">
                                        <div>
                                            <div class="fw-semibold text-dark">{{ $log->user->name }}</div>
                                            <small class="text-muted">{{ $log->user->email }}</small>
                                        </div>
                                        @else
                                        <div class="user-avatar bg-light text-muted me-2">
                                            <i class="bi bi-gear"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark">System</div>
                                            <small class="text-muted">Automated</small>
                                        </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge {{ $badgeClass }}">
                                        {{ ucfirst($log->action) }}
                                    </span>
                                </td>
                                <td><span class="text-muted">{{ $log->model ?? '—' }}</span></td>
                                <td class="{{ $isNoChange ? 'text-muted fst-italic' : '' }}">
                                    {!! $log->description !!}
                                </td>
                                <td>
                                    <div class="text-nowrap">
                                        <div class="fw-medium text-dark">{{ $log->updated_at->format('d M Y') }}</div>
                                        <small class="text-muted">{{ $log->updated_at->format('h:i A') }}</small>
                                        <div><small class="text-info">{{ $log->updated_at->diffForHumans() }}</small></div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="empty-state">
                                        <div class="empty-icon bg-light text-muted">
                                            <i class="bi bi-clock-history"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark mt-3">No Activity Found</h6>
                                        <p class="text-muted mb-0">Start interacting with the system to generate logs</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($logs->hasPages())
                <div class="px-3 py-3 border-top bg-light-subtle">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Showing {{ $logs->firstItem() ?? 0 }} to {{ $logs->lastItem() ?? 0 }} of {{ $logs->total() }} results
                        </div>
                        {{ $logs->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection