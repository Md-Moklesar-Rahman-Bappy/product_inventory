@extends('layouts.app')

@section('title', 'Maintenance Records')

@section('contents')
<div class="row">
    <div class="col-lg-12">
        <div class="custom-card border-0 shadow-sm">
            {{-- Header Section --}}
            <div class="card-header bg-white border-bottom py-3">
                <div class="row gy-3 align-items-center">
                    <div class="col-12 col-lg-6 d-flex align-items-center">
                        <div class="icon-box bg-primary text-white">
                            <i class="bi bi-tools"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0 fw-bold text-dark">Maintenance Records</h5>
                            <small class="text-muted">{{ $maintenances->total() }} total records</small>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 text-lg-end">
                        @if(auth()->user()->permission <= 1)
                        <a href="{{ route('maintenance.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-1"></i>Add Record
                        </a>
                        @endif
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
                                <th>Product</th>
                                <th>Serial No</th>
                                <th>Issue</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th style="width: 100px;">Status</th>
                                <th style="width: 100px;">Warranty</th>
                                <th>Logged By</th>
                                <th class="text-center pe-4" style="width: 140px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($maintenances as $index => $m)
                            <tr class="table-row">
                                <td class="ps-4 text-muted">{{ $maintenances->firstItem() + $index }}</td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $m->product->product_name ?? 'N/A' }}</div>
                                </td>
                                <td><code>{{ $m->product->serial_no ?? '-' }}</code></td>
                                <td>
                                    <span class="text-muted">{{ Str::limit($m->description, 30) }}</span>
                                </td>
                                <td>{{ $m->start_time->format('d M Y') }}</td>
                                <td>{{ $m->end_time->format('d M Y') }}</td>
                                <td>
                                    @if(now()->between($m->start_time, $m->end_time))
                                        <span class="badge bg-warning text-dark">In Progress</span>
                                    @elseif(now()->lt($m->start_time))
                                        <span class="badge bg-info text-dark">Scheduled</span>
                                    @else
                                        <span class="badge bg-success">Completed</span>
                                    @endif
                                </td>
                                <td>{!! $m->product->warranty_countdown ?? '<span class="text-muted">—</span>' !!}</td>
                                <td><span class="text-muted">{{ $m->user->name ?? 'System' }}</span></td>
                                <td class="pe-4">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('maintenance.show', $m->id) }}" class="btn btn-sm btn-light" title="View">
                                            <i class="bi bi-eye text-info"></i>
                                        </a>
                                        @if(auth()->user()->permission <= 1)
                                            <a href="{{ route('maintenance.edit', $m->id) }}" class="btn btn-sm btn-light" title="Edit">
                                                <i class="bi bi-pencil text-warning"></i>
                                            </a>
                                            <form action="{{ route('maintenance.destroy', $m->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-light delete-btn"
                                                    data-title="Delete Record"
                                                    data-text="Delete this maintenance record?"
                                                    title="Delete">
                                                    <i class="bi bi-trash text-danger"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center py-5">
                                    <div class="empty-state">
                                        <div class="empty-icon bg-light text-muted">
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

                {{-- Pagination --}}
                @if($maintenances->hasPages())
                <div class="px-3 py-3 border-top bg-light-subtle">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Showing {{ $maintenances->firstItem() ?? 0 }} to {{ $maintenances->lastItem() ?? 0 }} of {{ $maintenances->total() }} results
                        </div>
                        {{ $maintenances->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
                @endif

                {{-- Recycle Bin --}}
                @if(auth()->user()->permission <= 1 && $trashedMaintenances->total() > 0)
                <div class="border-top bg-danger-subtle">
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
</div>
@endsection