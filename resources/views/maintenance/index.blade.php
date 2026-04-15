@extends('layouts.app')

@section('title', 'Maintenance Records')

@section('contents')
<div class="row">
    <div class="col-lg-12">
        <div class="modern-table-card">
            <div class="table-header-section">
                <div class="row gy-3 align-items-center">
                    <div class="col-12 col-lg-6 d-flex align-items-center">
                        <div class="header-icon">
                            <i class="bi bi-tools"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-white">Maintenance Records</h5>
                            <small class="text-white opacity-75">{{ $maintenances->total() }} total records</small>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 text-lg-end">
                        @if(auth()->user()->permission <= 1)
                        <a href="{{ route('maintenance.create') }}" class="btn btn-add">
                            <i class="bi bi-plus-lg me-1"></i>Add Record
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="table-container">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-header-gradient">
                        <tr>
                            <th class="ps-4" style="width: 50px;">#</th>
                            <th>Product</th>
                            <th>Serial No</th>
                            <th>Issue</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th style="width: 110px;">Status</th>
                            <th style="width: 100px;">Warranty</th>
                            <th>Logged By</th>
                            <th class="text-center" style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($maintenances as $index => $m)
                        <tr>
                            <td class="ps-4">
                                <span class="row-number">{{ $maintenances->firstItem() + $index }}</span>
                            </td>
                            <td>
                                <a href="{{ route('products.show', $m->product_id) }}" class="product-name text-decoration-none">
                                    {{ $m->product->product_name ?? 'N/A' }}
                                </a>
                            </td>
                            <td>
                                <code class="serial-code">{{ $m->product->serial_no ?? '-' }}</code>
                            </td>
                            <td>
                                <span class="text-muted">{{ Str::limit($m->description, 30) }}</span>
                            </td>
                            <td>{{ $m->start_time->format('d M Y') }}</td>
                            <td>{{ $m->end_time->format('d M Y') }}</td>
                            <td>
                                @if(now()->between($m->start_time, $m->end_time))
                                    <span class="warranty-badge warranty-expiring">
                                        <i class="bi bi-clock"></i> In Progress
                                    </span>
                                @elseif(now()->lt($m->start_time))
                                    <span class="category-badge">
                                        <i class="bi bi-calendar"></i> Scheduled
                                    </span>
                                @else
                                    <span class="warranty-badge warranty-active">
                                        <i class="bi bi-check-circle-fill"></i> Completed
                                    </span>
                                @endif
                            </td>
                            <td>{!! $m->product->warranty_countdown ?? '<span class="text-muted">—</span>' !!}</td>
                            <td><span class="text-muted">{{ $m->user->name ?? 'System' }}</span></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('maintenance.show', $m->id) }}" class="action-btn action-btn-view" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if(auth()->user()->permission <= 1)
                                        <a href="{{ route('maintenance.edit', $m->id) }}" class="action-btn action-btn-edit" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('maintenance.destroy', $m->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn action-btn-delete delete-btn"
                                                data-title="Delete Record"
                                                data-text="Delete this maintenance record?"
                                                title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="bi bi-tools"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mt-3">No Maintenance Records</h6>
                                    <p class="text-muted mb-3">Get started by adding your first record</p>
                                    @if(auth()->user()->permission <= 1)
                                        <a href="{{ route('maintenance.create') }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-plus-lg me-1"></i>Add Record
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($maintenances->hasPages())
            <div class="table-footer px-3">
                {{ $maintenances->links('vendor.pagination.bootstrap-5') }}
            </div>
            @endif

            @if(auth()->user()->permission <= 1 && $trashedMaintenances->total() > 0)
            <div class="recycle-bin-section">
                <div class="px-3 py-2 d-flex align-items-center">
                    <i class="bi bi-trash text-danger me-2"></i>
                    <h6 class="mb-0 text-danger fw-bold">Recycle Bin</h6>
                    <span class="badge bg-danger ms-2">{{ $trashedMaintenances->total() }}</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">Product</th>
                                <th>Serial No</th>
                                <th>Issue</th>
                                <th>Deleted</th>
                                <th class="pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($trashedMaintenances as $archived)
                            <tr>
                                <td class="ps-3">{{ $archived->product->product_name ?? 'N/A' }}</td>
                                <td><code>{{ $archived->product->serial_no ?? '-' }}</code></td>
                                <td>{{ Str::limit($archived->description, 30) }}</td>
                                <td>{{ $archived->deleted_at->format('d M Y') }}</td>
                                <td class="pe-3">
                                    <form action="{{ route('maintenance.restore', $archived->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-success">
                                            <i class="bi bi-arrow-counterclockwise me-1"></i>Restore
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($trashedMaintenances->hasPages())
                <div class="px-3 py-2 border-top">
                    {{ $trashedMaintenances->links('vendor.pagination.bootstrap-5') }}
                </div>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
