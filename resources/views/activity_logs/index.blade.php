@extends('layouts.app')

@section('title', 'Activity Log')

@section('contents')
<div class="row">
    <div class="col-lg-12">
        <div class="modern-table-card">
            <div class="table-header-section">
                <div class="row gy-3 align-items-center">
                    <div class="col-12 col-lg-6 d-flex align-items-center">
                        <div class="header-icon">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-white">Activity Log</h5>
                            <small class="text-white opacity-75">{{ $logs->total() }} total activities</small>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <form method="GET" action="{{ route('activity.logs') }}" class="d-flex gap-2 justify-content-lg-end">
                            <select name="model" class="filter-select" style="width: 150px;" onchange="this.form.submit()">
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

            <div class="table-container">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-header-gradient">
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
                                'login' => 'warranty-active',
                                'logout' => 'warranty-expiring',
                                'create' => 'warranty-active',
                                'update' => 'role-admin',
                                'delete' => 'warranty-expired',
                                'restore' => 'status-active',
                                'status-toggle' => 'role-user',
                                'send-credentials' => 'status-active',
                                'verification-init' => 'status-active',
                            ];
                            $badgeClass = $actionColors[$log->action] ?? 'role-user';
                        @endphp
                        <tr>
                            <td class="ps-4">
                                <span class="row-number">{{ $index + 1 }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($log->user)
                                    <img src="{{ $log->user->profile_photo_url }}" 
                                         alt="{{ $log->user->name }}" 
                                         class="user-avatar me-2"
                                         style="width: 36px; height: 36px;">
                                    <div>
                                        <div class="product-name">{{ $log->user->name }}</div>
                                        <small class="product-meta">{{ $log->user->email }}</small>
                                    </div>
                                    @else
                                    <div class="product-avatar me-2" style="width: 36px; height: 36px; font-size: 0.9rem;">
                                        <i class="bi bi-gear"></i>
                                    </div>
                                    <div>
                                        <div class="product-name">System</div>
                                        <small class="product-meta">Automated</small>
                                    </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="warranty-badge {{ $badgeClass }}">
                                    {{ ucfirst($log->action) }}
                                </span>
                            </td>
                            <td><span class="product-meta">{{ $log->model ?? '—' }}</span></td>
                            <td class="{{ $isNoChange ? 'text-muted fst-italic' : '' }}">
                                {!! \App\Helpers\StringHelper::sanitizeHtml($log->description) !!}
                            </td>
                            <td>
                                <div class="text-nowrap">
                                    <div class="product-name">{{ $log->updated_at->format('d M Y') }}</div>
                                    <small class="product-meta">{{ $log->updated_at->format('h:i A') }}</small>
                                    <div><small class="text-info">{{ $log->updated_at->diffForHumans() }}</small></div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                <div class="empty-state">
                                    <div class="empty-icon">
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

            @if($logs->hasPages())
            <div class="table-footer px-3">
                {{ $logs->links('vendor.pagination.bootstrap-5') }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
